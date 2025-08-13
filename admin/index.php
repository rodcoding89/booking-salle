<?php 
	require_once dirname(__DIR__).'/inc/init.php';
    $title = "Liste Client - Stwich";
	require_once 'nav.php';
	//traitement du formulaire
    if (isset($_POST) && !empty($_POST)) {
        executeRequete("UPDATE membre SET pseudo = :pseudo,email=:email,nom=:nom,prenom=:prenom,civilite=:civilite,statut=:statut WHERE id_membre = :id_membre",array(
            ':pseudo' => $_POST['pseudo'],
            ':email' => $_POST['email'],
            ':nom' => $_POST['nom'],
            ':prenom' => $_POST['prenom'],
            ':civilite' => $_POST['civilite'],
            ':statut' => $_POST['statut'],
            ':id_membre' => $_POST['id_membre']
        ));
        $message = '<div class="alert alert-info">Mise a jour du membre éffectué</div>';
    }
    
    //traitement de la suppression ou de la modification des membres
    if (isset($_GET['id_membre']) && !empty($_GET['id_membre'])) {
        if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            executeRequete("DELETE FROM membre WHERE id_membre = :id_membre",array(':id_membre' => $_GET['id_membre']));
            executeRequete("DELETE FROM commande WHERE id_membre = :id_membre",array(':id_membre' => $_GET['id_membre']));
            executeRequete("DELETE FROM avis WHERE id_membre = :id_membre",array(':id_membre' => $_GET['id_membre']));
            $message = '<div class="alert alert-info">Suppression du membre éffectué</div>';
        }else{
            $resultat = executeRequete("SELECT * FROM membre WHERE id_membre = :id_membre",array(':id_membre' => $_GET['id_membre']));
            $membre_modifie = $resultat->fetch(PDO::FETCH_ASSOC);
        }
        //debug($membre_modifie);
    }
    //debug($_POST);

    $resultat = executeRequete("SELECT * FROM membre");
    $nb_row = $resultat->rowCount();

    $contenu = '<table class="table table-striped">';
    $contenu .= '<tr>
				<th>ID</th>
				<th>Pseudo</th>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Email</th>
				<th>Civilité</th>
				<th>Role</th>
				<th>Date d\'enregistrement</th>

			</tr>';
    while ($membre = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $contenu .= '<tr>';
        foreach ($membre as $key => $value) {
            if ($key == 'mdp') {
                # code...
            }elseif($key == 'statut'){
                if($value == 0){
                    $contenu .= '<td>Utilisateur</td>';
                }else{
                    $contenu .= '<td>Administrateur</td>';
                }
            }else if($key == 'civilite'){
            	if ($value == 'm') {
            		$contenu .= '<td>M.</td>';
            	} else {
            		$contenu .= '<td>Mme</td>';
            	}
            }else if($key == 'date_enregistrement'){
            	$date=date_create($value);
            	$contenu .= '<td>'.date_format($date,'j F, Y').'</td>';
            }else{
                $contenu .= '<td>'.$value.'</td>';
            }
            
        }
        $contenu .= '</tr>';
        //debug($membre);
    }
    $contenu .= '</table>';

?>
<div class="" style="margin-top: 100px;">
	<h1 class="mb-4">Liste client</h1>
    <div class="content-table mb-4">
        <h4 class="mb-4">Nombre de client : <?php echo $nb_row; ?> </h4>
        <?php echo $contenu; ?>
    </div>
</div>
<?php
	require_once 'footer.php';