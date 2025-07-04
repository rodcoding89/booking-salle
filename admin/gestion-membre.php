<?php
    require_once '../inc/init.php';
    $contenu = '';
    $message = '';

     //on vérifie si l'internaute n'est pas administrateur
    if (!estAdmin()) {
        header('location:../connexion.php');
        exit;
    }

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

    $contenu .= '<table class="table table-striped">';
    $contenu .= '<tr>
				<th>ID</th>
				<th>Pseudo</th>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Email</th>
				<th>Civilité</th>
				<th>Statut</th>
				<th>Date d\'enregistrement</th>
				<th>Action</th>

			</tr>';
    while ($membre = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $contenu .= '<tr>';
        foreach ($membre as $key => $value) {
            if ($key == 'mdp') {
                # code...
            }elseif($key == 'statut'){
                if($value == 0){
                    $contenu .= '<td>membre</td>';
                }else{
                    $contenu .= '<td>admin</td>';
                }
            }else{
                $contenu .= '<td>'.$value.'</td>';
            }
            
        }
            $contenu .= '<td>';
                $contenu .= '<a href="?id_membre='.$membre['id_membre'].'"> Modifier </a><br>';
                $contenu .= '<a href="?id_membre='.$membre['id_membre'].'&action=delete" onclick="return confirm(\'Êtes vous certains de vouloir supprimer ce membre?\')"> Supprimer</a>';
            $contenu .= '</td>';
        $contenu .= '</tr>';
        //debug($membre);
    }
    $contenu .= '</table>';

    //modification de la table membre
    
    require_once '../inc/header.php';
?>
<div class="bloc">
    <h1>Gestion des membres</h1>
    <div class="membre">
        <ul class="nav nav-tabs">
            <li><a class="nav-link active" href="gestion-membre.php">Gestion des membres</a></li>
            <li><a class="nav-link" href="gestion-salle.php">Gestion des salles</a></li>
            <li><a class="nav-link" href="gestion-produits.php">Gestion des produits</a></li>
            <li><a class="nav-link" href="gestion-commande.php">Gestion des commandes</a></li>
            <li><a class="nav-link" href="gestion-avis.php">Gestion des avis</a></li>
            <li><a class="nav-link" href="statistique.php">Statistique</a></li>
        </ul>
    </div>
    <div class="content">
        <?php echo $message; ?>
        <h4>Nombre de membre inscrit : <?php echo $nb_row; ?> </h4>
        <div class="content-table">
            <?php echo $contenu; ?>
        </div>
        <h5>Modification des membres</h5>
        <form action = "" method = "post">
            <div class="left">
                <div class="mb-3">
                    <input type="hidden" name="id_membre" value="<?php echo $membre_modifie['id_membre'] ?? '' ?>">
                </div>
                <div class="mb-3">
                    <label for="pseudo" class="form-label">Pseudo</label>
                    <input type="text" class="form-control" id="pseudo" name="pseudo" value = "<?php echo $membre_modifie['pseudo'] ?? '' ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value = "<?php echo $membre_modifie['email'] ?? '' ?>">
                </div>
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $membre_modifie['nom'] ?? '' ?>">
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prenom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" value = "<?php echo $membre_modifie['prenom'] ?? '' ?>">
                </div>
            </div>
            <div class="right">
                <div class="mb-3">
                    <label for="pseudo" class="form-label">Civilité</label>
                    <select name="civilite" id="civilite" class="form-select" aria-label="Default select example">
                        <option value="m" <?php if(isset($membre_modifie['civilite']) && $membre_modifie['civilite'] == "m") echo 'selected' ?> >Homme</option>
                        <option value="f" <?php if(isset($membre_modifie['civilite']) && $membre_modifie['civilite'] == "f") echo 'selected' ?>>Femme</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="statut" class="form-label">Statut</label>
                    <select name="statut" id="statut" class="form-select" aria-label="Default select example">
                        <option value="1" <?php if(isset($membre_modifie['statut']) && $membre_modifie['statut'] == 1) echo 'selected' ?> >Admin</option>
                        <option value="0" <?php if(isset($membre_modifie['statut']) && $membre_modifie['statut'] == 0) echo 'selected' ?>>Membre</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Modifier les données</button>
            </div>
        </form>
    </div>
</div>






<?php
require_once '../inc/footer.php';