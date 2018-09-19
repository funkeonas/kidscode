<?php 

if (count($errors) > 0) : ?>
    <div class = "error">
        <?php foreach ($errors as $error):
            echo "<p> $error </p>";
        endforeach;?>

    </div>


<?php endif






?>
