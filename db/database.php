<?php

$link = mysqli_connect('localhost', 'daginterdb', 'P8gws6K', 'daginterdb');
mysqli_set_charset($link, 'utf8');

$pdo = new PDO('mysql:host=localhost;dbname=daginterdb;charset=utf8', 'daginterdb', 'P8gws6K', array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
));
