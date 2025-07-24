<?php
	require_once 'init.php';
	if(isset($_POST)){
		$commandeRef = "CMD-".time();
		$option = "";
		if (isset($_POST['option-traiteur'])) {
			$option .= "Option - Service Traiteur(+".$_POST['traiteur-value']."€), ";
		}

		if(isset($_POST['option-parking'])){
			$option .= "Option - Stationnement privé(+".$_POST['parking-value']."€), ";
		}

		if($_POST['option-materiel']){
			$option .= "Option - Matériel audiovisuel supplémentaire(+".$_POST['materiel-value']."€), ";
		}

		//echo $option;

		$resultat = executeRequete("UPDATE salle SET etat =:etat WHERE id_salle =:idSalle",array(
			"etat"=>false,
			"idSalle"=>$_POST["id_salle"]
		));

		if($resultat){
			$result = executeRequete("INSERT INTO commande (id_membre,id_salle,commande_ref,commande_statut,prix_journalier,nb_jours_reserve,prix_total,date_debut,date_fin,heure_debut,heure_fin,other_option) VALUES(:id_membre,:id_salle,:commande_ref,:commande_status,:prix_journalier,:nb_jours_reserve,:prix_total,:date_debut,:date_fin,:heure_debut,:heure_fin,:other_option)", array(
				":id_membre" =>$_POST["id_membre"],
				":id_salle" =>$_POST["id_salle"],
				":commande_ref" =>$commandeRef,
				":commande_status" =>"pending",
				":prix_journalier" =>$_POST["prix_journalier"],
				":nb_jours_reserve" =>$_POST["nb_jours_reserve"],
				":prix_total" =>$_POST["prix_total"],
				":date_debut" =>$_POST["date_debut"],
				":date_fin" =>$_POST["date_fin"],
				":heure_debut" =>$_POST["heure_debut"],
				":heure_fin" =>$_POST["heure_fin"],
				":other_option" => $option
			));
			if ($result) {
				$_SESSION['confirmation'] = [
					"commandeRef" =>$commandeRef,
					"prixTotal" =>$_POST["prix_total"],
					"dateDebut" =>$_POST["date_debut"],
					"dateFin" =>$_POST["date_fin"],
					"heureDebut" =>$_POST["heure_debut"],
					"heureFin" =>$_POST["heure_fin"],
					"name" =>$_SESSION['membre']['nom'] .' ' .$_SESSION['membre']['prenom'],
					"adresse" => $_POST['adresse'],
					"caracteristic" =>$_POST['caracteristic'],
					"photo" =>$_POST['photo'],
					"titre" =>$_POST['titre'],
					"capacite" =>$_POST['capacite']
				];
				header("Location:". RACINE_SITE . "confirmation");
			} else {
				header("Location:". RACINE_SITE . "booking?roomId=".$_POST["id_salle"]."&error=true");
			}
		}else {
				header("Location:". RACINE_SITE . "booking?roomId=".$_POST["id_salle"]."&error=true");
		}
	}
?>