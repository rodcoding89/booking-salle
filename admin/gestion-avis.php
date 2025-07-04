<?php
    require_once '../inc/init.php';
    $contenu = '';
    $nb_row = 0;
    $message = '';

    if (!estAdmin()) {
        header('location:../connexion.php');
        exit;
    }
    //debug($_POST);
    //traitement du formulaire
    if (isset($_POST) && !empty($_POST)) {
        if (!empty($_POST['id_avis']) && !empty($_POST['commentaire']) && !empty($_POST['note']) && !empty($_POST['date_enregistrement'])) {
            executeRequete("UPDATE avis SET commentaire = :commentaire,note = :note, date_enregistrement = :date_enregistrement WHERE id_avis = :id_avis",array(
                ':commentaire' => $_POST['commentaire'],
                ':note' => $_POST['note'],
                ':date_enregistrement' => $_POST['date_enregistrement'],
                ':id_avis' => $_POST['id_avis']
            ));
            $message = '<div class="alert alert-info">Mise a jour de l\'avis éffectué</div>';
        }
        //debug($_POST);
    }

    if (isset($_GET['id_avis']) && !empty($_GET['id_avis'])) {
        if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            executeRequete("DELETE FROM avis WHERE id_avis = :id_avis",array(':id_avis' => $_GET['id_avis']));
            $message = '<div class="alert alert-info">Suppression de l\'avis éffectué</div>';
        }else{
            $resultat = executeRequete("SELECT * FROM avis WHERE id_avis = :id_avis",array(':id_avis' => $_GET['id_avis']));
            $avis_modifie = $resultat->fetch(PDO::FETCH_ASSOC);
        }
        //debug($membre_modifie);
    }

    $resultat = executeRequete("SELECT * FROM avis");
    $nb_row = $resultat->rowCount();

    $contenu .= '<table class="table table-striped">';
    $contenu .= '<tr>
				<th>ID</th>
                <th>ID membre</th>
				<th>ID salle</th>
				<th>Commentaire</th>
                <th>Note</th>
				<th>Date d\'enregistrement</th>
				<th>Action</th>

			</tr>';
    while ($avis = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $contenu .= '<tr>';
        //debug($avis);
        $contenu .= '<td>'.$avis['id_avis'].'</td>';
            $result = executeRequete("SELECT email FROM membre WHERE id_membre = :id_membre",array(':id_membre' => $avis['id_membre']));
            $membre = $result->fetch(PDO::FETCH_ASSOC);
        $contenu .= '<td>'.$avis['id_membre'].'-'.$membre['email'].'</td>';
            $result = executeRequete("SELECT titre FROM salle WHERE id_salle = :id_salle",array(':id_salle' => $avis['id_salle']));
            $salle = $result->fetch(PDO::FETCH_ASSOC);
        $contenu .= '<td>'.$avis['id_salle'].'-salle '.$salle['titre'].'</td>';
        $contenu .= '<td>'.$avis['commentaire'].'</td>';
        $contenu .= '<td>'.$avis['note'].'</td>';
        $contenu .= '<td>'.explode(" ",$avis['date_enregistrement'])[0].'</td>';
        
        $contenu .= '<td>';
            $contenu .= '<a href="?id_avis='.$avis['id_avis'].'"> Modifier </a><br>';
            $contenu .= '<a href="?id_avis='.$avis['id_avis'].'&action=delete" onclick="return confirm(\'Êtes vous certains de vouloir supprimer cet avis?\')"> Supprimer</a>';
        $contenu .= '</td>';
        $contenu .= '</tr>';
        //debug($membre);
    }
    $contenu .= '</table>';


    require_once '../inc/header.php';
?>
<div class="bloc">
    <h1>Gestion des avis</h1>
    <div class="avis">
        <ul class="nav nav-tabs">
            <li><a class="nav-link" href="gestion-membre.php">Gestion des membres</a></li>
            <li><a class="nav-link" href="gestion-salle.php">Gestion des salles</a></li>
            <li><a class="nav-link" href="gestion-produits.php">Gestion des produits</a></li>
            <li><a class="nav-link" href="gestion-commande.php">Gestion des commandes</a></li>
            <li><a class="nav-link active" href="gestion-avis.php">Gestion des avis</a></li>
            <li><a class="nav-link" href="statistique.php">Statistique</a></li>
        </ul>
    </div>
    <div class="avis-content">
        <div class="content-table">
            <?php echo $message; ?>
            <h4>Nombre d'avis enregistré : <?php echo $nb_row;?> </h4>
            <div class="content-table">
                <?php echo $contenu; ?>
            </div>
        </div>
        <h6>Modifier des avis</h6>
        <form action = "" method = "post">
            <div class="left">
                <div class="mb-3">
                    <input type="hidden" name="id_avis" value="<?php echo $avis_modifie['id_avis'] ?? 0 ?>">
                </div>
                <div class="mb-3">
                    <label for="commentaire" class="form-label">Commentaire</label>
                    <textarea name="commentaire" id="commentaire" class="form-control" placeholder="Commentaire sur la salle"><?php echo $avis_modifie['commentaire'] ?? '' ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">Note</label>
                    <select name="note" id="note" class="form-select" aria-label="Default select example">
                        <option value="1" <?php if(isset($avis_modifie['note']) && $avis_modifie['note'] == 1) echo 'selected'; ?>>1</option>
                        <option value="2" <?php if(isset($avis_modifie['note']) && $avis_modifie['note'] == 2) echo 'selected'; ?>>2</option>
                        <option value="3" <?php if(isset($avis_modifie['note']) && $avis_modifie['note'] == 3) echo 'selected'; ?>>3</option>
                        <option value="4" <?php if(isset($avis_modifie['note']) && $avis_modifie['note'] == 4) echo 'selected'; ?>>4</option>
                        <option value="5" <?php if(isset($avis_modifie['note']) && $avis_modifie['note'] == 5) echo 'selected'; ?>>5</option>
                    </select>
                </div>
                
            </div>
            <div class="right">
                <div class="mb-3">
                    <label for="date_enregistrement" class="form-label">Date d'enregistrement</label>
                    <input type="datetime-local" class="form-control" name="date_enregistrement" id="date_enregistrement" value ="<?php echo str_replace(' ','T',$avis_modifie['date_enregistrement']) ?? '' ?>" min="<?php echo date('Y-m-d\TH:i') ?>">
                </div>
                <button type="submit" class="btn btn-primary">Modifier un avis</button>
            </div>
        </form>
    </div>
</div>






<?php
require_once '../inc/footer.php';