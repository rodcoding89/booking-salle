<?php 
	require_once 'init.php';
	$res = array();
	$limit = 9;
	if (isset($_POST)) {
		if (isset($_POST['postType'])) {
			if ($_POST['postType'] == 'salleList') {
				$page = isset($_POST['page']) && is_numeric($_POST['page']) ? (int)$_POST['page'] : 1;
				$offset = ($page - 1) * $limit;
				$resultat = selectQuery("SELECT s.*,c.date_debut,c.heure_debut,c.date_fin,c.heure_fin FROM salle s LEFT JOIN commande c ON c.id_salle = s.id_salle GROUP BY c.id_salle LIMIT :limit OFFSET :offset", array(
					"limit" =>$limit,
					"offset" => $offset
				));
				/*$now = date("Y-m-d H:i:s");

				$resultat = selectQuery("SELECT s.*, c.* FROM salle s LEFT JOIN commande c ON c.id_salle = s.id_salle WHERE NOT EXISTS ( SELECT 1 FROM commande c2 WHERE c2.id_salle = s.id_salle AND c2.commande_statut = 'confirmed' AND ( :nowStart <= DATE_ADD(STR_TO_DATE(CONCAT(c2.date_fin, ' ', c2.heure_fin), '%Y-%m-%d %H:%i:%s'), INTERVAL 1 DAY) AND :nowEnd >= DATE_SUB(STR_TO_DATE(CONCAT(c2.date_debut, ' ', c2.heure_debut), '%Y-%m-%d %H:%i:%s'), INTERVAL 1 DAY))) LIMIT :limit OFFSET :offset",array(
					"nowStart" => $now,
					"nowEnd" => $now,
					"limit" => $limit,
					"offset" => $offset
				));*/

				$result = selectQuery("SELECT c.id_commande, s.id_salle FROM salle s LEFT JOIN commande c ON c.id_salle = s.id_salle");
				$data = $result->fetchAll(PDO::FETCH_ASSOC); // Fetch all results at once
				$totalPages = ceil(count($data) / $limit);
				$res['resultat'] = $resultat->fetchAll(PDO::FETCH_ASSOC);;
				$res['totalPages'] = $totalPages;
        		echo json_encode($res);
			}
		}
		if($_POST['postType'] == 'salleListFilter'){
			$page = isset($_POST['page']) && is_numeric($_POST['page']) ? (int)$_POST['page'] : 1;
			$offset = ($page - 1) * $limit;
			//var_dump($_POST);
			// Initialisation du tableau des conditions
			$where = [];
			$parameter = [];

			// Vérifie la ville
			if (!empty($_POST['city'])) {
			    $where[] = 'ville = :ville';
			    $parameter['ville'] = $_POST['city'];
			}

			// Vérifie la catégorie
			if (isset($_POST['categorie']) && count($_POST['categorie']) > 0) {
			    // Crée des placeholders pour chaque catégorie
			    $placeholders = [];
			    foreach ($_POST['categorie'] as $index => $cat) {
			        $placeholders[] = ':categorie' . $index;
			        $parameter['categorie'.$index] = $cat;
			    }
			    $where[] = 'categorie IN (' . implode(', ', $placeholders) . ')';
			}

			// Vérifie la capacité
			if (!empty($_POST['capaciteMin']) && !empty($_POST['capaciteMax'])) {
			    $where[] = 'capacite BETWEEN :minC AND :maxC';
			    $parameter['minC'] = (int)$_POST['capaciteMin'];
			    $parameter['maxC'] = (int)$_POST['capaciteMax'];
			}

			// Vérifie le prix
			if (!empty($_POST['prixMin']) && !empty($_POST['prixMax'])) {
			    $where[] = 'prix BETWEEN :minP AND :maxP';
			    $parameter['minP'] = (int)$_POST['prixMin'];
			    $parameter['maxP'] = (int)$_POST['prixMax'];
			}

			// Construit la clause WHERE complète
			$whereClause = '';
			if (count($where) > 0) {
			    $whereClause = 'WHERE ' . implode(' AND ', $where);
			}

			// Construit la requête finale
			$sql = "SELECT s.*, c.date_debut, c.heure_debut, c.date_fin, c.heure_fin 
			        FROM salle s 
			        LEFT JOIN commande c ON c.id_salle = s.id_salle 
			        $whereClause
			        LIMIT :limit OFFSET :offset";

			//echo $sql;
			$parameter1 = $parameter;
			$parameter1['limit'] = $limit;
			$parameter1['offset'] = $offset;
			//var_dump($parameter1);
			$resultat = selectQuery($sql, $parameter1);
			$result = selectQuery("SELECT c.id_commande, s.id_salle FROM salle s LEFT JOIN commande c ON c.id_salle = s.id_salle ".$whereClause,$parameter);
			$data = $result->fetchAll(PDO::FETCH_ASSOC); // Fetch all results at once
			$totalPages = ceil(count($data) / $limit);
			$res['resultat'] = $resultat->fetchAll(PDO::FETCH_ASSOC);;
			$res['totalPages'] = $totalPages;
    		echo json_encode($res);
		}
	}
?>