<?php

// connexion à la BDD

$pdo = new PDO('mysql:host=localhost;dbname=booking_sale','root','', 
    array( 
        PDO::ATTR_ERRMODE => PDO:: ERRMODE_WARNING,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
));

// demarrage de la session

session_start();

// définition du chemin racine

define('RACINE_SITE','/bookingSale/');

require_once 'functions.php';