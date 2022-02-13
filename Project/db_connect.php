<?php

//Connection à la bdd

$host = "163.172.130.142";
$databaseName = "sakila";
$username = 'etudiant';
$password = 'CrERP29qwMNvcbnAMgLzW9CwuTC5eJHn';

$dsn = "mysql:host=$host;port=3310;dbname=$databaseName";
try {
    $databaseConnection = new PDO($dsn, $username, $password);
    echo "Connection successfull";
    echo '</pre>';
} catch (PDOException $error) {
    echo $error->getMessage();
}