<?php
use classes\user;

    $userId = 1;
    $name = "";
    $surname = '';
    $mail = '....';
    $img = '';
    $messages = '';
    
    $user = new classes\user($userId,$name,$surname, $mail, $img, $messages);
    header("Location: index.php");



?> 