<?php
    require_once '../inc/init.php';
    $contenu = '';
    $nb_row = 0;
    $message = '';

    //traitement de la suppression d'une commande
    if (isset($_GET['id_commande']) && !empty($_GET['id_commande']) && isset($_GET['id_produit']) && !empty($_GET['id_produit'])) {
    
        executeRequete("DELETE FROM commande WHERE id_commande = :id_commande",array(':id_commande' => $_GET['id_commande']));
        executeRequete("UPDATE produit SET etat = :etat WHERE id_produit = :id_produit",array(
            ':etat' => 'libre',
            ':id_produit' => $_GET['id_produit']
        ));
        $message = '<div class="alert alert-info">Suppression de la commande éffectuée</div>';
        //debug($membre_modifie);
    }

    $resultat = executeRequete("SELECT * FROM commande c INNER JOIN produit p ON c.id_produit = p.id_produit");
    $nb_row = $resultat->rowCount();

    $contenu .= '<table class="table table-striped">';
    $contenu .= '<tr>
				<th>ID</th>
                <th>ID membre</th>
				<th>ID produit</th>
				<th>Prix</th>
				<th>Date d\'enregistrement</th>
				<th>Action</th>

			</tr>';
    while ($commande = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $contenu .= '<tr>';
        //debug($commande);
        $contenu .= '<td>'.$commande['id_commande'].'</td>';
            $result = executeRequete("SELECT email FROM membre WHERE id_membre = :id_membre",array(':id_membre' => $commande['id_membre']));
            $membre = $result->fetch(PDO::FETCH_ASSOC);
        $contenu .= '<td>'.$commande['id_membre'].'-'.$membre['email'].'</td>';
            $result = executeRequete("SELECT titre FROM salle WHERE id_salle = :id_salle",array(':id_salle' => $commande['id_salle']));
            $salle = $result->fetch(PDO::FETCH_ASSOC);
        $contenu .= '<td>'.$commande['id_produit'].'-salle '.$salle['titre'].' '.explode(" ",$commande['date_arrivee'])[0].' au '.explode(" ",$commande['date_depart'])[0].'</td>';
        $contenu .= '<td>'.$commande['prix'].'</td>';
        $contenu .= '<td>'.explode(" ",$commande['date_enregistrement'])[0].'</td>';
        
        $contenu .= '<td>';
            $contenu .= '<a href="?id_commande='.$commande['id_commande'].'&action=delete&id_produit='.$commande['id_produit'].'" onclick="return confirm(\'Êtes vous certains de vouloir supprimer cette commande?\')"> Supprimer</a>';
        $contenu .= '</td>';
        $contenu .= '</tr>';
        //debug($membre);
    }
    $contenu .= '</table>';

    require_once '../inc/header.php';
?>
<div class="bloc">
    <h1>Gestion des commande</h1>
    <div class="commande">
        <ul class="nav nav-tabs">
            <li><a class="nav-link" href="gestion-membre.php">Gestion des membres</a></li>
            <li><a class="nav-link" href="gestion-salle.php">Gestion des salles</a></li>
            <li><a class="nav-link" href="gestion-produits.php">Gestion des produits</a></li>
            <li><a class="nav-link active" href="gestion-commande.php">Gestion des commandes</a></li>
            <li><a class="nav-link" href="gestion-avis.php">Gestion des avis</a></li>
            <li><a class="nav-link" href="statistique.php">Statistique</a></li>
        </ul>
    </div>
    <div class="commande-content">
        <?php echo $message; ?>
        <h4>Nombre de commande : <?php echo $nb_row; ?> </h4>
        <?php echo $contenu; ?>
    </div>
</div>






<?php
require_once '../inc/footer.php';