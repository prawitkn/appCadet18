<?php

//$link = mysqli_connect('localhost', 'root', 'root', 'website');
//mysqli_set_charset($link, 'utf8');

$link = mysqli_connect('localhost', 'root', '', 'website');
mysqli_set_charset($link, 'utf8');

$pdo = new PDO('mysql:host=localhost;dbname=website;charset=utf8', 'root', '', array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
));
jfkdsjlk