<?php
use classes\user;

$userId = 2;
$name = "Giosue";
$surname = 'Calgaro';
$mail = '....';
$img = '';
$connection = " ";
$user = new classes\user($userId,$name,$mail, $img, $connection);
echo "ciao";
?> 