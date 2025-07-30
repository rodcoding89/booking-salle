<?php 
	require_once dirname(dirname(__DIR__)).'/inc/init.php';
	require_once '../nav.php';
	$message = '';

	function filterAction ($item,$action){
        //var_dump($action);
        $result = [];
        if ($item == "pending") {
            $result = ["cancelled","confirmed"];
        }else if($item == "cancelled"){
            $result = ["pending"];
        }else if($item == "confirmed"){
            $result = ["closed","pending"];
        }else{
            $result = [];
        }
        return $result;
    }

    function initStatus ($status,$from,$orderId){
        $statusText = '';
        $spanStyle = 'font-size:11px; padding:5px 10px; border-radius:.5rem; color:white;display:block;width:max-content;'.($from != 'status' ? 'cursor:pointer;':';');

        if ($status == 'pending') {
        	$statusText = $from == 'status' ? '<span style="' . $spanStyle . 'background-color:yellowgreen;">En attente</span>' : '<form action="'.RACINE_SITE.'inc/make_as_pending.php" method="POST"><input type="hidden" value="'.$orderId.'" name="orderId"> <button style="'.$spanStyle.'background-color:yellowgreen;border:none;" type="submit">Mettre en attente</button></form>';
        } elseif ($status == 'confirmed') {
            $statusText = $from == 'status' ? '<span style="' . $spanStyle . 'background-color:blue;">Confirmé</span>' : '<form action="'.RACINE_SITE.'inc/make_as_confirmed.php" method="POST"><input type="hidden" value="'.$orderId.'" name="orderId"> <button style="'.$spanStyle.'background-color:blue;border:none;" type="submit">Confirmer</button></form>';
        } elseif ($status == 'cancelled') {
            $statusText = $from == 'status' ? '<span style="' . $spanStyle . 'background-color:red;">Annulé</span>' : '<form action="'.RACINE_SITE.'inc/make_as_cancelled.php" method="POST"><input type="hidden" value="'.$orderId.'" name="orderId"> <button style="'.$spanStyle.'background-color:red;border:none;" type="submit">Annuler</button></form>';
        } else {
            $statusText = $from == 'status' ? '<span style="' . $spanStyle . 'background-color:orange;">Terminé</span>' : '<form action="'.RACINE_SITE.'inc/make_as_closed.php" method="POST"><input type="hidden" value="'.$orderId.'" name="orderId"> <button style="'.$spanStyle.'background-color:orange;border:none;" type="submit">Terminer</button></form>';
        }
        return $statusText;
    }
	//traitement de la suppression d'une commande
    if (isset($_GET['id_commande']) && !empty($_GET['id_commande'])) {
    
        executeRequete("DELETE FROM commande WHERE id_commande = :id_commande",array(':id_commande' => $_GET['id_commande']));
        $message = '<div class="alert alert-info">Suppression de la commande éffectuée</div>';
        //debug($membre_modifie);
    }

    $resultat = executeRequete("SELECT id_commande,id_membre,id_salle,commande_ref,nb_jours_reserve,CONCAT(date_debut,' : ', heure_debut,' , ',date_fin,' : ',heure_fin) as comm_date,other_option,prix_total,commande_statut,date_commande FROM commande");
    $nb_row = $resultat->rowCount();

    $contenu = '<table class="table table-striped">';
    $contenu .= '<tr>
				<th>ID</th>
                <th>Client</th>
				<th>Salle reservé</th>
				<th>Réference commande</th>
				<th>Temps reservé</th>
				<th>Dates reservations</th>
				<th>Options</th>
				<th>Prix Total</th>
				<th>Statut commande</th>
				<th>Date commande</th>
				<th>Action</th>

			</tr>';
    while ($commande = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $contenu .= '<tr>';
        //debug($commande);
        foreach ($commande as $key => $value) {
        	//$contenu .= '<td>'.$commande['id_commande'].'</td>';
        	if ($key == 'id_membre') {
        		$result = executeRequete("SELECT nom,prenom FROM membre WHERE id_membre = :id_membre",array(':id_membre' => $value));
            	$membre = $result->fetch(PDO::FETCH_ASSOC);
	        	$contenu .= '<td>'.$value.'-'.$membre['nom'].' '.$membre['prenom'].'</td>';
        	}else if($key == 'commande_statut'){
        		$contenu .= '<td>' . initStatus($commande['commande_statut'],'status','0') . '</td>';
        	} else if($key == 'id_salle'){
        		$result = executeRequete("SELECT titre FROM salle WHERE id_salle = :id_salle",array(':id_salle' => $value));
	            $salle = $result->fetch(PDO::FETCH_ASSOC);
	        	$contenu .= '<td>'.$value.'-salle '.$salle['titre'].'</td>';
        	} else {
        		$contenu .= '<td>'.$value.'</td>';
        	}	
        }
        $action = ["pending","cancelled","confirmed","closed"];
        $actionList = ['pending','cancelled','delivered','shipped'];
        $possibleAction = filterAction($commande['commande_statut'],$actionList);

        $actions = '<div style="display: flex;flex-wrap: wrap;gap: 5px;"><a href="?id_commande='.$commande['id_commande'].'&action=delete" onclick="return confirm(\'Êtes vous certains de vouloir supprimer cette commande?\')"> <i class="fa fa-trash"></i></a>';
        foreach ($possibleAction as $key => $value) {
            $actions .= initStatus($value,'action',$commande['id_commande']);
        }
        $actions .= '</div>';
        $contenu .= '<td>' . $actions . '</td>';
        $contenu .= '</tr>';
        //debug($membre);
    }
    $contenu .= '</table>';

    $success = '';
    $error = '';

    if (isset($_GET['success'])) {
        $success = '<div class="alert alert-success">Modification éffectué avec succès</div>';
    } else if (isset($_GET['error'])) {
        $error = '<div class="alert alert-danger">Erreur survenu lors de la modification du statut de la commande</div>';
    }

?>
<div class="bloc"  style="margin-top: 100px;">
    <h1 class="mb-4">Gestion des commandes</h1>
    <div class="commande-content mb-4">
        <?php echo $message; ?>
        <?php echo $success; ?>
        <?php echo $error; ?>
        <h4 class="mb-4">Nombre de commande : <?php echo $nb_row; ?> </h4>
        <?php echo $contenu; ?>
    </div>
</div>
<?php
	require_once '../footer.php';