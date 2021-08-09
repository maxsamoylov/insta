<?php

$host = 'localhost';
$database = 'itsmakc_insta';
$user = 'insta';
$pass = 'pass2021wordN';

$dsn = "mysql:host=$host;dbname=$database;";
$options = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_PERSISTENT => true
);
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
}
catch(PDOException $e){
    echo $e->getMessage();
    $pdo = null;
};