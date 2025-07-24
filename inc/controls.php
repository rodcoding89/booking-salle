<?php 
	require_once 'init.php';
	$res = array();
	$limit = 9;
	if (isset($_POST)) {
		if (isset($_POST['postType'])) {
			if ($_POST['postType'] == 'salleList') {
				$page = isset($_POST['page']) && is_numeric($_POST['page']) ? (int)$_POST['page'] : 1;
				$offset = ($page - 1) * $limit;
				$resultat = selectQuery("SELECT s.*,c.date_debut,c.heure_debut,c.date_fin,c.heure_fin FROM salle s LEFT JOIN commande c ON c.id_salle = s.id_salle LIMIT :limit OFFSET :offset", array(
					"limit" =>$limit,
					"offset" => $offset
				));
				$result = selectQuery("SELECT c.id_commande, s.id_salle FROM salle s LEFT JOIN commande c ON c.id_salle = s.id_salle");
				$data = $result->fetchAll(PDO::FETCH_ASSOC); // Fetch all results at once
				$totalPages = ceil(count($data) / $limit);
				$res['resultat'] = $resultat->fetchAll(PDO::FETCH_ASSOC);;
				$res['totalPages'] = $totalPages;
        		echo json_encode($res);
			}
		}
	}
?>