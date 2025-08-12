<?php

// connexion à la BDD
// Connexion à la base de données
$env = "dev";

$host    = $env == 'dev' ? 'localhost'     : 'sql100.infinityfree.com';
$db      = $env == 'dev' ? 'booking_sale'  : 'if0_39691001_stwich';
$user    = $env == 'dev' ? 'root'          : 'if0_39691001';
$pass    = $env == 'dev' ? ''              : 'SRPu0LoLHj';
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
define('RACINE_SITE',$env == 'dev' ? '/bookingSale/' : '/');
define('NODE_ENV',$env);
//define('NODE_ENV','prod');
require_once 'functions.php';