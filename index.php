
<?php
$cmd = 'cd server && php server.php';

echo shell_exec($cmd);

?>

<!DOCTYPE html>
<html lang="en" class="hw-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--<meta http-equiv="Content-Security-Policy" content="connect-src 'self'"> -->
    <!---------------------------------------- required css ------------------------------------------------>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!----------------------------------------- start of page -->
    <!------------------------------------- required js ------------------------------------------------>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- import css --> 
    <link rel="stylesheet" type="text/css" href="style.css">   

</head>
    

<body>
    <div class="container h-100 p-0 border-left border-bottom border-right">
        <?php require 'header.php' ?>
        <div class="d-flex flex-row w-100 p-0 m-0" id="content-part">
           <?php require 'sidebar.php' ?>
           <?php require 'view.php' ?> 
        </div>
    </div>
</body>
    
    <?php require 'footer.php' ?>