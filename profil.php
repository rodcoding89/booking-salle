<?php
    require_once 'inc/init.php';
    $message = '';
    $contenu = 'Vous avez 0 commande';
    if (!estConnecte()) {
        header('location:connexion.php');
    }
    $resultat = executeRequete("SELECT * FROM commande c INNER JOIN produit p ON c.id_produit = p.id_produit INNER JOIN salle s ON s.id_salle = p.id_salle WHERE id_membre = :id_membre",array(':id_membre' => $_SESSION['membre']['id_membre']));
    while ($commande = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $contenu  = '<div class="commande-item">';
        $contenu .= '<h6>'.$commande['categorie'].' '.$commande['titre'].'</h6>';
        $contenu .= '<div class="historique">';
        $contenu .= '<img src="'.$commande['photo'].'" alt="'.$commande['titre'].'">';
        $contenu .= '<div style="margin-right:20px;"><p>Arrivée : '.explode(" ",$commande['date_arrivee'])[0].'</p><p>Départ : '.explode(" ",$commande['date_depart'])[0].'</p></div>';
        $contenu .= '<div><p>Adresse : '.$commande['adresse'].' '.$commande['cp'].' '.$commande['ville'].'</p><p>Capacité :'.$commande['capacite'].'</p></div>';
        $contenu .= '</div>';
        $contenu .= '<p>Enregistré le : '.explode(" ",$commande['date_enregistrement'])[0].'</p>';
        $contenu .= '</div>';
        //debug($commande);
    }
    //debug($_SESSION['membre']);

    require_once 'inc/header.php';
?>


<div class="profil">
    <h2>Bonjour <?php echo $_SESSION['membre']['prenom'] . ' '.$_SESSION['membre']['nom'];  ?></h2>
    <p><?php if(estAdmin()) echo 'Vous êtes administrateur' ;?></p>
    <hr>
    <h5>Vos coordonnées</h5>

    <ul>
        <li>Email: <?php echo $_SESSION['membre']['email']; ?> </li>
        <li>Civilite: <?php if($_SESSION['membre']['civilite'] == 'f') echo 'Vous êtes une femme'; else echo 'Vous êtes un homme' ?> </li>
        <li>pseudo: <?php echo $_SESSION['membre']['pseudo']; ?> </li>
    </ul>
    <hr>
    <h5>Vos differentes commandes</h5>
    <?php echo $contenu; ?>
</div>









<?php
require_once 'inc/footer.php';