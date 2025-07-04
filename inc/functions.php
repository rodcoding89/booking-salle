<?php

//la fonction debug

function debug($variable){
    echo '<div style = "border: 1px solid orange">';
		echo '<pre>';
		print_r($variable);
		echo '</pre>';
	echo '</div>';
}

//fonction qui mentionne si l'internaute est connecté

function estConnecte(){
    if (isset($_SESSION['membre'])) {
        return true;
    }else{
        return false;
    }
}

// fonction qui détérmine si l'internaute est un admin

function estAdmin(){
    if (estConnecte() && $_SESSION['membre']['statut'] == 1) {
        return true;
    } else {
        return false;
    }
    
}

// gestion des requêtes sql

function executeRequete($requete,$marqueurs = array()){
    foreach ($marqueurs as $key => $value) {
        $marqueurs[$key] = htmlspecialchars($value,ENT_QUOTES);
    }
    global $pdo;
    $resultat = $pdo->prepare($requete);
    $success = $resultat->execute($marqueurs);
    if ($success) {
        return $resultat;
    }else{
        die("Une erreur est survenu lors de l'execution de la requête");
    }
}

// gestion des notes

function gestionNote($note){
    $element = '0 / 5';
    if ($note == 1) {
        $element = '<span>⭐</span>';
    }elseif($note == 2){
        $element = '<span>⭐⭐</span>';
    }elseif($note == 3){
        $element = '<span>⭐⭐⭐</span>';
    }elseif($note == 4){
        $element = '<span>⭐⭐⭐⭐</span>';
    }elseif($note == 5){
        $element = '<span>⭐⭐⭐⭐⭐</span>';
    }
    return $element;
}
