<?php 
	require_once dirname(dirname(__DIR__)).'/inc/init.php';
    $title = "Statistique - Stwich";
	require_once '../nav.php';

	$message = '';
    $contenu1 = '';
    $contenu2 = '';
    $contenu3 = '';

	/*$resultat = executeRequete("SELECT s.titre,s.id_salle,ROUND(AVG(a.note),1) AS note_max FROM avis a INNER JOIN salle s ON s.id_salle = a.id_salle GROUP BY a.id_salle ORDER BY note_max DESC LIMIT 0,5");

    while ($note = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $contenu .= '<li class="list-group-item"><span>Salle '.$note['titre'].'</span><span style="float:right">'.$note['note_max'].'</span></li>';
        //debug($note);
    }*/

    $resultat = executeRequete("SELECT s.titre, COUNT(c.id_commande) AS salle_commandee FROM commande c INNER JOIN salle s ON s.id_salle = c.id_salle GROUP BY s.id_salle ORDER BY salle_commandee DESC LIMIT 0,5");

    while ($commande = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $contenu1 .= '<li class="list-group-item"><span>Salle '.$commande['titre'].'</span><span style="float:right">'.$commande['salle_commandee'].'</span></li>';
    }

    $resultat = executeRequete("SELECT m.nom, m.prenom, COUNT(c.id_commande) AS nb_commande FROM commande c INNER JOIN membre m ON m.id_membre = c.id_membre GROUP BY c.id_membre ORDER BY nb_commande DESC LIMIT 0,5");

    while ($membre = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $contenu2 .= '<li class="list-group-item"><span>'.$membre['nom'].' '.$membre['prenom'].'</span><span style="float:right">'.$membre['nb_commande'].'</span></li>';
        //debug($membre);
    }

    $resultat = executeRequete("SELECT m.nom, m.prenom, SUM(c.prix_total) AS prix_eleve FROM commande c INNER JOIN membre m ON c.id_membre = m.id_membre GROUP BY m.id_membre ORDER BY prix_eleve DESC LIMIT 0,5");

    while ($prix = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $contenu3 .= '<li class="list-group-item"><span>'.$prix['nom'].' '.$prix['prenom'].'</span><span style="float:right">'.$prix['prix_eleve'].'</span></li>';
        //debug($prix);
    }
    //modification de la table membre
    
?>
<div class="stat-content" style="margin-top: 100px;">
	<h1 class="mb-4">Statistique</h1>
    <div class="note mb-4">
        <h6 class="mb-4">Le top 5 des salles les plus commandées</h6>
        <ol class="list-group list-group-numbered">
            <?php echo $contenu1 ?>
        </ol>
    </div>
    <div class="note mb-4">
        <h6 class="mb-4">Le top 5 des membres qui achétent le plus</h6>
        <ol class="list-group list-group-numbered">
            <?php echo $contenu2 ?>
        </ol>
    </div>
    <div class="note mb-4">
        <h6 class="mb-4">Le top 5 des membres qui achétent le plus cher</h6>
        <ol class="list-group list-group-numbered">
            <?php echo $contenu3 ?>
        </ol>
    </div>
</div>
<?php
	require_once '../footer.php';