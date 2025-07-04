<?php
    require_once '../inc/init.php';
    $message = '';
    $contenu = '';

    //on vérifie si l'internaute n'est pas administrateur
    if (!estAdmin()) {
        header('location:../connexion.php');
        exit;
    }

    //traitement du formulaire
    if (isset($_POST) && !empty($_POST)) {
        $bdd_photo = '';

        if (isset($_POST['photo_modifiee'])) {
            $bdd_photo = $_POST['photo_modifiee'];
        }
        //debug($_FILES);
        if (!empty($_FILES['photo']['name'])) {
            $file_name = uniqid().'_'.$_FILES['photo']['name'];
            $bdd_photo = 'photos/'.$file_name;
            copy($_FILES['photo']['tmp_name'],'../'.$bdd_photo);
        }
        //debug($_POST);
        if (!empty($_POST['titre']) && !empty($_POST['description']) && !empty($bdd_photo) && !empty($_POST['pays']) && !empty($_POST['ville']) && !empty($_POST['cp']) && !empty($_POST['capacite']) && !empty($_POST['categorie'])) {
            executeRequete("REPLACE INTO salle(id_salle,titre,description,photo,pays,ville,adresse,cp,capacite,categorie) VALUES(:id_salle,:titre,:description,:photo,:pays,:ville,:adresse,:cp,:capacite,:categorie)",array(
                ':id_salle' => $_POST['id_salle'],
                ':titre' => $_POST['titre'],
                ':description' => $_POST['description'],
                ':photo' => $bdd_photo,
                ':pays' => $_POST['pays'],
                ':ville' => $_POST['ville'],
                ':adresse' => $_POST['adresse'],
                ':cp' => $_POST['cp'],
                ':capacite' => $_POST['capacite'],
                ':categorie' => $_POST['categorie']
            ));
            $message = '<div class="alert alert-success">La salle à été modifiée ou ajoutée</div>';
        }else{
            $message = '<div class="alert alert-danger">Veillez remplir tous les champs</div>';
        }
    }

    //traitement de la suppression ou de la modification des salles
    if (isset($_GET['id_salle']) && !empty($_GET['id_salle'])) {
        if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            executeRequete("DELETE FROM salle WHERE id_salle = :id_salle",array(':id_salle' => $_GET['id_salle']));
            executeRequete("DELETE FROM produit WHERE id_salle = :id_salle",array(':id_salle' => $_GET['id_salle']));
            executeRequete("DELETE FROM avis WHERE id_salle = :id_salle",array(':id_salle' => $_GET['id_salle']));
            $message = '<div class="alert alert-info">Suppression de la salle éffectuée</div>';
        }else{
            $result = executeRequete("SELECT * FROM salle WHERE id_salle = :id_salle",array(':id_salle' => $_GET['id_salle']));
            $salle_modifie = $result->fetch(PDO::FETCH_ASSOC);
        }
        //debug($membre_modifie);
    }

    $resultat = executeRequete("SELECT * FROM salle");
    $nb_row = $resultat->rowCount();

    $contenu .= '<table class="table table-striped">';
    $contenu .= '<tr>
				<th>ID</th>
				<th>Titre</th>
				<th>Desciption</th>
				<th>Photo</th>
				<th>Pays</th>
				<th>Ville</th>
                <th>Adresse</th>
				<th>Code postal</th>
				<th>Capacité</th>
                <th>Catégorie</th>
				<th>Action</th>

			</tr>';
    while ($salle = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $contenu .= '<tr>';
        foreach ($salle as $key => $value) {
            if ($key == 'photo') {
                $contenu .= '<td><img src="../'.$value.'" style="width:80px;"></td>';
            }else{
                $contenu .= '<td>'.$value.'</td>';
            } 
        }
            $contenu .= '<td>';
                $contenu .= '<a href="?id_salle='.$salle['id_salle'].'"> Modifier </a><br>';
                $contenu .= '<a href="?id_salle='.$salle['id_salle'].'&action=delete" onclick="return confirm(\'Êtes vous certains de vouloir supprimer cette salle?\')"> Supprimer</a>';
            $contenu .= '</td>';
        $contenu .= '</tr>';
        //debug($membre);
    }
    $contenu .= '</table>';

    require_once '../inc/header.php';
?>
<div class="bloc">
    <h1>Gestion des salles</h1>
    <div class="salle">
        <ul class="nav nav-tabs">
            <li><a class="nav-link" href="gestion-membre.php">Gestion des membres</a></li>
            <li><a class="nav-link active" href="gestion-salle.php">Gestion des salles</a></li>
            <li><a class="nav-link" href="gestion-produits.php">Gestion des produits</a></li>
            <li><a class="nav-link" href="gestion-commande.php">Gestion des commandes</a></li>
            <li><a class="nav-link" href="gestion-avis.php">Gestion des avis</a></li>
            <li><a class="nav-link" href="statistique.php">Statistique</a></li>
        </ul>
    </div>
    <div class="salle-content">
        <div class="content-table">
            <?php echo $message; ?>
            <h4>Nombre de salle enregistré : <?php echo $nb_row;?> </h4>
            <div class="content-table">
                <?php echo $contenu; ?>
            </div>
        </div>
        <h6>Ajouter ou modifier des salles</h6>
        <form action = "" method = "post" enctype ="multipart/form-data">
            <div class="left">
                <div class="mb-3">
                    <input type="hidden" name="id_salle" value="<?php echo $salle_modifie['id_salle'] ?? 0 ?>">
                </div>
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" placeholder = "Titre de la salle" value="<?php echo $salle_modifie['titre'] ?? '' ?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" placeholder="Description de la salle"><?php echo $salle_modifie['description'] ?? '' ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Photo</label>
                    <input class="form-control" type="file" id="formFile" name = "photo" id="photo">
                    <?php 
                        if (isset($salle_modifie['photo'])) {
                            echo '<p>Photo actuelle : </p>';
					        echo '<div><img src="../'.$salle_modifie['photo'].'" style="width:80px"> </div>';
					        echo '<input type="hidden" name="photo_modifiee" id="photo_modifiee" value="'.$salle_modifie['photo'].'">';
                        }
                    ?>
                </div>
                <div class="mb-3">
                    <label for="capacite" class="form-label">Capacité</label>
                    <select name="capacite" id="capacite" class="form-select" aria-label="Default select example">
                        <option value="4" <?php if(isset($salle_modifie['capacite']) && $salle_modifie['capacite'] == '4') echo 'selected'; ?>>4</option>
                        <option value="20" <?php if(isset($salle_modifie['capacite']) && $salle_modifie['capacite'] == '20') echo 'selected'; ?>>20</option>
                        <option value="30" <?php if(isset($salle_modifie['capacite']) && $salle_modifie['capacite'] == '30') echo 'selected'; ?>>30</option>
                        <option value="50" <?php if(isset($salle_modifie['capacite']) && $salle_modifie['capacite'] == '50') echo 'selected'; ?>>50</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="categorie" class="form-label">Catégorie</label>
                    <select name="categorie" id="categorie" class="form-select" aria-label="Default select example">
                        <option value="Réunion" <?php if(isset($salle_modifie['categorie']) && $salle_modifie['categorie'] == 'Réunion') echo 'selected'; ?>>Réunion</option>
                        <option value="Bureau" <?php if(isset($salle_modifie['categorie']) && $salle_modifie['categorie'] == 'Bureau') echo 'selected'; ?>>Bureau</option>
                        <option value="Formation" <?php if(isset($salle_modifie['categorie']) && $salle_modifie['categorie'] == 'Formation') echo 'selected'; ?>>Formation</option>
                    </select>
                </div>
            </div>
            <div class="right">
                <div class="mb-3">
                    <label for="pays" class="form-label">Pays</label>
                    <select name="pays" id="pays" class="form-select" aria-label="Default select example">
                        <option value="france" <?php if(isset($salle_modifie['pays']) && $salle_modifie['pays'] == 'france') echo 'selected'; ?>>France</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="ville" class="form-label">Ville</label>
                    <select name="ville" id="ville" class="form-select" aria-label="Default select example">
                        <option value="Paris" <?php if(isset($salle_modifie['ville']) && $salle_modifie['ville'] == 'Paris') echo 'selected'; ?>>Paris</option>
                        <option value="Lyon" <?php if(isset($salle_modifie['ville']) && $salle_modifie['ville'] == 'Lyon') echo 'selected'; ?>>Lyon</option>
                        <option value="Marseille" <?php if(isset($salle_modifie['ville']) && $salle_modifie['ville'] == 'Marseille') echo 'selected'; ?>>Marseille</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="adresse" class="form-label">Adresse</label>
                    <textarea name="adresse" id="adresse" class="form-control" placeholder="Adresse de la salle"><?php echo $salle_modifie['adresse'] ?? '' ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="cp" class="form-label">Code postal</label>
                    <input type="text" class="form-control" id="cp" name="cp" value = "<?php echo $salle_modifie['cp'] ?? '' ?>">
                </div>
                <button type="submit" class="btn btn-primary">Modifier ou ajouter une salle</button>
            </div>
        </form>
    </div>
</div>





<?php
require_once '../inc/footer.php';