<?php

// connexion à la BDD
// Connexion à la base de données
$host = 'localhost';
$db   = 'booking_sale';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// demarrage de la session

session_start();

// définition du chemin racine
putenv("node=dev");
//putenv("node=prod");
define('RACINE_SITE','/bookingSale/');
define('NODE_ENV','dev');
//define('NODE_ENV','prod');
require_once 'functions.php';