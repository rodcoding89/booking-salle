<?php

//la fonction debug

function debuging($variable){
    echo '<div style = "border: 1px solid orange">';
		echo '<pre>';
		print_r($variable);
		echo '</pre>';
	echo '</div>';
}

function caracteristic($item){
    $item = trim($item);
    //echo $item;
    $content = [
        "fa-solid fa-video" => "Projecteur",
        "fa-solid fa-fan" => "Climatisation",
        "fa-solid fa-wifi" => "Wi-Fi",
        "fa-solid fa-desktop" => "Ecran LCD",
        "fa-solid fa-microphone" => "Système de conférence",
        "fa-solid fa-volume-xmark" => "Isolation phonique",
        "fa-solid fa-volume-high" => "Sonorisation",
        "fa-solid fa-fa-utensils" => "Service traiteur",
        "fa-solid fa-sticky-note" => "Post-its",
        "fa-solid fa-mug-hot" => "Machine à café",
        "fa-solid fa-square-parking" => "Parking",
        "fa-solid fa-hand-pointer" => "Ecran tactile",
        "fa-solid fa-lock" => "Confidentialité absolue",
        "fa-solid fa-crown" => "Service VIP",
        "fa-solid fa-screwdriver-wrench" => "Equipements techniques",
        "fa-solid fa-couch" => "Espace détente",
        "fa-solid fa-chair" => "Bureaux ergonomiques",
        "fa-solid fa-print" => "Imprimante 3D",
        "fa-solid fa-vr-cardboard" => "Réalité virtuelle",
        "fa-solid fa-volume-low" => "Ambiance sonore",
        "fa-solid fa-wand-magic-sparkles" => "Matériel d'animation",
        "fa-solid fa-spoon" => "Cuisine équipée",
        "fa-solid fa-sun" => "Lumière naturelle",
        "fa-solid fa-wind" => "Air purifié",
        "fa-solid fa-tree" => "Espace extérieur",
        "fa-solid fa-cubes" => "Mobilier modulable",
        "fa-solid fa-microchip" => "Matériel high-tech",
        "fa-solid fa-chalkboard-user" => "Tableaux interactifs",
        "fa-solid fa-flask" => "FabLab",
        "fa-solid fa-border-all" => "Tableaux muraux",
        // Si tu souhaites ajouter "Matériel créatif", donne-lui un icône valide
        "fa-solid fa-paintbrush" => "Matériel créatif",
        "fa-solid fa-mug-saucer" => "Café illimité",
        "fa-solid fa-chalkboard" => "Tableau blanc",
        "fa-solid fa-lightbulb" => "Éclairage professionnel"
    ];

    $span = '<span class="badge equipment-badge"><i class="me-1"></i> ' . htmlspecialchars($item) . '</span>';

    foreach ($content as $key => $value) {
        /*$result = stripos($value, $item) !== false;
        echo "Comparing '$value' with '$item' => ";
        var_dump($result);*/
        if (stripos(strtolower($value), strtolower($item)) !== false) { // comparaison insensible à la casse
            $span = '<span class="badge equipment-badge"><i class="' . $key . ' me-1"></i> ' . htmlspecialchars($value) . '</span>';
            break;
        }else{
            //var_dump($value);
        }
    }
    /*$select = '<select name="services" id="services">';
    foreach($content as $icon => $label){
        $select .= '<option value="' . htmlspecialchars($label) . '">' . htmlspecialchars($label) . '</option>';
    }
    $select .= '</select>';
    echo $select;*/
    return $span;
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

function checkRoomAvailability($endDate, $endHour, $startDate, $startHour) {
    // 1. Vérification des paramètres obligatoires
    if (empty($endDate) || empty($endHour) || empty($startDate) || empty($startHour)) {
        return false;
    }

    // 2. Création des timestamps avec les heures
    $startDateTime = DateTime::createFromFormat('Y-m-d H:i', $startDate . ' ' . $startHour);
    $endDateTime = DateTime::createFromFormat('Y-m-d H:i', $endDate . ' ' . $endHour);
    $now = new DateTime();

    if (!$startDateTime || !$endDateTime) {
        // Format invalide
        return false;
    }

    // 3. Vérification que la date de fin est après la date de début
    if ($endDateTime <= $startDateTime) {
        return false;
    }

    // 4. Vérification que la date de début est au moins 1 jour dans le futur
    $interval = $now->diff($startDateTime);
    $timeUntilStart = abs($startDateTime->getTimestamp() - $now->getTimestamp());
    $oneDayInSeconds = 24 * 60 * 60;

    if ($startDateTime >= $now) {
        if (($timeUntilStart / $oneDayInSeconds) >= 1) {
            // Plus de 24h avant le début de la réservation → selon ton JS, ici retour false
            return false;
        } else {
            return true;
        }
    } else {
        // Si la date de début est passée, vérifier si la fin est aussi passée
        if ($endDateTime <= $now) {
            return false;
        } else {
            return true;
        }
    }
}

//var_dump($listCaracteristic);
function findItem($caracteristic,$item=''){
    return array_search(trim($item), $caracteristic) !== false;
}

function genereOption($listCaracteristic,$selectedItem){
    //var_dump($selectedItem[0]);
    //var_dump($selectedItem);
    $checkbox = '<div style="height:150px;width100%;border:1px solid #ccc;border-radius:8px;overflow:auto;padding: 10px 20px 10px;">';
    foreach ($listCaracteristic as $key => $value) {
        $checkbox .= '<div class="d-flex justify-content-start align-items-center gap-2">';
        $checkbox .= '<input type="checkbox" name="caracteristic[]" value="' . $value . '" id="' . $value . '" ' . (findItem($selectedItem, $value) ? 'checked' : '') . '>';
        $checkbox .= '<label for="' . $value . '">' . $value . '</label>';
        $checkbox .= '</div>';
    }
    $checkbox .= '</div>';
    //echo " checkbox ". $checkbox;
    return $checkbox;
}

// gestion des requêtes sql

function executeRequete($requete,$marqueurs = array()){
    foreach ($marqueurs as $key => $value) {
        if (is_array($value) || is_numeric($value)) {
            $marqueurs[$key] = $value;
        } else {
            $marqueurs[$key] = htmlspecialchars($value,ENT_QUOTES);
        }
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

function selectQuery($query,$marqueurs = array()){
    foreach ($marqueurs as $key => $value) {
        if (is_array($value) || is_numeric($value)) {
            $marqueurs[$key] = $value;
        } else {
            $marqueurs[$key] = htmlspecialchars($value,ENT_QUOTES);
        }
    }
    //var_dump($marqueurs);
    global $pdo;

    $resultat = $pdo->prepare($query);
    $success = $resultat->execute($marqueurs);
    if ($success) {
        return $resultat;
    }else {
        die('Erreur produit lors de l\'execution de la requête');
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
