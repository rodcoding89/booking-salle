<?php 
	require_once 'init.php';
	if(isset($_POST) && isset($_POST['orderId'])){
		$resultat = executeRequete('UPDATE commande SET commande_statut = :new_status WHERE id_commande = :ordersId',array(
			"new_status"=> "cancelled",
			"ordersId" => $_POST['orderId']
		));

		if ($resultat) {
			header("Location:".RACINE_SITE.'admin/orders?success=true');
		} else {
			header("Location:".RACINE_SITE.'admin/orders?error=cancelling');
		}
		
	}else{
		echo 'no post';
	}
?>