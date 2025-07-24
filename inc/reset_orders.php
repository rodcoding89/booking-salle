<?php
	require_once 'init.php';
	if(isset($_POST)){
		$resultat = executeRequete('UPDATE commande SET commande_statut =:status WHERE id_commande =:orderId',array(
			"orderId" => $_POST['orderId'],
			"status" => "cancelled"
		));
		if ($resultat) {
			header("Location:".RACINE_SITE.'profil?success=cancelled');
		} else {
			header("Location:".RACINE_SITE.'profil?error=cancelled');
		}
		
	}
?>