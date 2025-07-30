<?php 
	require_once dirname(dirname(__DIR__)).'/inc/init.php';
	require_once '../nav.php';
    $message = '';
    //traitement de la suppression ou de la modification des salles
    if (isset($_GET['action']) && $_GET['action'] == 'delete') {
        $idSalle = $_GET['id_salle'];
        $result = executeRequete("DELETE FROM salle WHERE id_salle = :id_salle",array(':id_salle' => $idSalle));
        if ($result) {
            $message = '<div class="alert alert-info">Suppression de la salle éffectuée.</div>';
        } else {
            $message = '<div class="alert alert-danger">Echec lors de la suppression.</div>';
        }
        //debug($membre_modifie);
    }
	$resultat = executeRequete("SELECT id_salle,titre,description,photo,CONCAT(rue, ', ', ville, ' ',cp, ' ',pays) AS adresse,caracteristic,categorie,capacite,prix FROM salle");
    $nb_row = $resultat->rowCount();

        $contenu = '<table class="table table-striped">';
        $contenu .= '<tr>
				<th>ID</th>
				<th>Titre</th>
				<th>Desciption</th>
				<th>Photo</th>
				<th>Addresse</th>
				<th>Caractéristique</th>
				<th>Catégorie</th>
				<th>Capacité</th>
                <th>Prix</th>
				<th>Action</th>
			</tr>';
            $contenu .= '<tbody>';
            while ($salle = $resultat->fetch(PDO::FETCH_ASSOC)) {
                foreach ($salle as $key => $value) {
                    if ($key == 'photo') {
                        $link = explode("#", $value);
                        if (isset($link[1]) && $link[1] == "img") {
                            $contenu .= '<td><img src="'.RACINE_SITE.$value.'" style="width:80px;"></td>';
                        } else {
                            $contenu .= '<td><img src="'.$link[0].'" style="width:80px;"></td>';
                        }
                    }else{
                        $contenu.= '<td>'.$value.'</td>';
                    }
                }
                $contenu .= '<td>';
                    $contenu .= '<div style="display:flex;align-items:center;justify-content:flex-start;gap:5px;"><a href="'.RACINE_SITE.'admin/rooms/edit?id_salle='.$salle['id_salle'].'" title="Modifier la salle"> <i class="fa fa-edit"></i> </a><br>';
                    $contenu .= '<a href="?id_salle='.$salle['id_salle'].'&action=delete" onclick="return confirm(\'Êtes vous certains de vouloir supprimer cette salle?\')" title="Supprimer la salle"><i class="fa fa-trash"></i></a></div>';
                $contenu .= '</td>';
                $contenu .= '</tr>';
            }
            $contenu .= '</tbody>';
        $contenu .= '</table>';
?>
<div class="content-table" style="margin-top: 100px;">
    <?php echo $message; ?>
    <h1 class="mb-4">Gestion Salles</h1>
    <div class="content-table">
        <h4 class="mb-4 d-flex justify-content-between align-items-center gap-2">Nombre de salle enregistré : <?php echo $nb_row;?> <a href="<?php echo RACINE_SITE .'admin/rooms/add' ?>" title="Ajouter une nouvelle salle" style="width: 40px;height: 40px; border-radius: 50%;background-color: #aaa; display: flex;align-items: center;justify-content: center;text-decoration: none;"><i class="fa fa-plus" style="font-size: 1.3rem;color: white;"></i></a></h4>
        <?php echo $contenu; ?>
    </div>
</div>
<?php
	require_once '../footer.php';