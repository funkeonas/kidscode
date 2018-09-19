<?php

session_start();

//initializing variables
$username = '';
$email = '';
$errors = array();
$password_1 = "";
$password_2 = "";


//this connects this page to the registration database $db
$db = mysqli_connect('localhost' , 'root' , '' , 'registration');


//Register new user
//all the codes inside the if statement will run when the reg-user button is pressed
 
if (isset($_POST['reg_user']))  {
    //recieve input values from form
    $username =
    mysqli_real_escape_string($db,$_POST['username']);
    
    $email =
    mysqli_real_escape_string($db,$_POST['email']);
    
    $password_1 =               mysqli_real_escape_string($db,$_POST['password_1']);
    
  $password_2 =               mysqli_real_escape_string($db,$_POST['password_2']);
    
//    echo $username;
//   echo $email;
//   echo $password_1;
//   echo $password_2;
//   
    // to check that form have been filled correctly
    // create $errors arrays and use (array_push()) to add corressponding errors
    if (empty($username)){
        array_push($errors, "username is required");
    }
    if (empty($email)){
         array_push($errors, "email is required");
    }
    if (empty($password_1)){
         array_push($errors, "password is required");
    }
    if ($password_1 != $password_2) {
         array_push($errors, "password must match");
 }
    //this check to see if anthing a user inputs matches with something in the database  
$user_check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    
if ($user) { //if user exists
    if ($user['username'] === $username){
        array_push ($errors, "username already exists");
    }
if ($user['email'] === $email){
        array_push ($errors, "email already exists");
    } 
}
    
if (count($errors)== 0) {
    $password = md5($password_1); //encrypts password
    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    
    $info = mysqli_query($db, $query); //inserts the user into the database and the info is stored in the info variable
    
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header ('location: index.php');
            
    
     }
     
}

 

//Login existing user
if (isset($_POST['login_user'])){ 
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password =               mysqli_real_escape_string($db,$_POST['password']);
  
    //checks if form is correctly filled
    if (empty($username)){
        array_push($errors, "username is required");
    }
    
    if (empty($password)){
         array_push($errors, "password is required");
    }
 
    if (count($errors)== 0) {
    $password = md5($password); //encrypts password
    $query =  "SELECT * FROM users WHERE username = '$username' AND password = '$password' ";
    $user_info = mysqli_query($db, $query);
    
        if (mysqli_num_rows($user_info) == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
        header ('location: index.php'); 
        } else{
            array_push ($errors, 'username and password invalid');
        }
    }
}

//Logout
if (isset($_GET['logout'])){
    session_destroy();
    unset ($_SESSION['username']);
    header ('location: login.php');  
}
?>