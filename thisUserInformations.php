<?php
use classes\user;

    $userId = 2;
    $name = "Giosue";
    $surname = 'Calgaro';
    $mail = '....';
    $img = '';
    
    $user = new classes\user($userId,$name,$surname, $mail, $img);
    header("Location: index.php");



?> 