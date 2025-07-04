<?php
    require_once '../inc/init.php';
    $message = '';
    $contenu = '';
    $nb_row = '';
    $dateD = false;
    $dateA = false;
    $dateC = false;
    $index = 0;

    //on vérifie si l'internaute n'est pas administrateur
    if (!estAdmin()) {
        header('location:../connexion.php');
        exit;
    }
    //debug($_POST);
    //traitement du formulaire
    if (isset($_POST) && !empty($_POST)) {
        if (!empty($_POST['date_arrivee']) && !empty($_POST['date_depart']) && !empty($_POST['id_salle']) && !empty($_POST['prix'])) {
            $actuel_date = date('Y-m-d H:i:s');
            if ($_POST['date_arrivee'] >= $actuel_date) {
                $dateA = true;
            } else {
                $message .= '<div class="alert alert-danger">La date d\'arrivée doit être égale ou supérieur à la date actuel </div>';
            }
            
            if ($_POST['date_depart'] > $actuel_date) {
                $dateD = true;
            } else {
                $message .= '<div class="alert alert-danger">La date de depart doit être supérieur à la date actuel </div>';
            }

            if ($_POST['date_depart'] > $_POST['date_arrivee']) {
                $dateC = true;
            } else {
                $message .= '<div class="alert alert-danger">La date de depart doit être supérieur à la date d\'arrivée </div>';
            }
            
            
            if ($dateA && $dateD && $dateC) {
                $resultat = executeRequete("SELECT * FROM produit WHERE id_salle = :id_salle",array(
                    ':id_salle' => $_POST['id_salle']
                ));
                if ($resultat->rowCount() > 0) {
                    while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)) {
                        if ($produit['date_depart'] > $_POST['date_depart'] || $produit['date_depart'] > $_POST['date_arrivee']) {
                            $message .= '<div class="alert alert-danger">Veillez modifier vos dates le produit est déja reservé</div>';
                            break;
                        }else{
                            $index ++;
                        }
                    }
                    if ($index == $resultat->rowCount()) {
                        
                        executeRequete("REPLACE INTO produit (id_produit,id_salle,date_arrivee,date_depart,prix,etat) VALUES(:id_produit,:id_salle,:date_arrivee,:date_depart,:prix,:etat)",array(
                            ':id_produit' => $_POST['id_produit'],
                            ':id_salle' => $_POST['id_salle'],
                            ':date_arrivee' => $_POST['date_arrivee'],
                            ':date_depart' => $_POST['date_depart'],
                            ':prix' => $_POST['prix'],
                            ':etat' => 'libre'
                        ));
                        $message .= '<div class="alert alert-success">Le produit à été modifiée ou ajoutée</div>';
                       
                        //echo 'sans faute';
                    }
                    
                }else{
                    executeRequete("REPLACE INTO produit (id_produit,id_salle,date_arrivee,date_depart,prix,etat) VALUES(:id_produit,:id_salle,:date_arrivee,:date_depart,:prix,:etat)",array(
                        ':id_produit' => $_POST['id_produit'],
                        ':id_salle' => $_POST['id_salle'],
                        ':date_arrivee' => $_POST['date_arrivee'],
                        ':date_depart' => $_POST['date_depart'],
                        ':prix' => $_POST['prix'],
                        ':etat' => 'libre'
                    ));
                    $message .= '<div class="alert alert-success">Le produit à été modifiée ou ajoutée</div>';
                }
            }
        }else{
            $message .= '<div class="alert alert-danger">Veillez remplir tous les champs</div>';
        }
    }

    //traitement de la suppression ou de la modification d'un produit
    if (isset($_GET['id_produit']) && !empty($_GET['id_produit'])) {
        if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            executeRequete("DELETE FROM produit WHERE id_produit = :id_produit",array(':id_produit' => $_GET['id_produit']));
            $message = '<div class="alert alert-info">Suppression du produit éffectuée</div>';
        }else{
            $result = executeRequete("SELECT * FROM produit WHERE id_produit = :id_produit",array(':id_produit' => $_GET['id_produit']));
            $produit_modifie = $result->fetch(PDO::FETCH_ASSOC);
        }
        //debug($membre_modifie);
    }

    $resultat = executeRequete("SELECT * FROM produit");
    $nb_row = $resultat->rowCount();

    $contenu .= '<table class="table table-striped">';
    $contenu .= '<tr>
				<th>ID</th>
                <th>ID salle</th>
				<th>Date d\'arrivée</th>
				<th>Date de départ</th>
				<th>Prix</th>
				<th>Etat</th>
				<th>Action</th>

			</tr>';
    while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $contenu .= '<tr>';
        foreach ($produit as $key => $value) {
            if($key == 'id_salle'){
                $result = executeRequete("SELECT photo,titre FROM salle WHERE id_salle = :id_salle",array(':id_salle'=>$value));
                $salle = $result->fetch(PDO::FETCH_ASSOC);
                $contenu .= '<td>'.$value.' - Salle '.$salle['titre'].'<br><img src="../'.$salle['photo'].'" alt="'.$salle['titre'].'" style="width:80px;"></td>';
            }else{
                $contenu .= '<td>'.$value.'</td>';
            } 
        }
            $contenu .= '<td>';
                $contenu .= '<a href="?id_produit='.$produit['id_produit'].'"> Modifier </a><br>';
                $contenu .= '<a href="?id_produit='.$produit['id_produit'].'&action=delete" onclick="return confirm(\'Êtes vous certains de vouloir supprimer ce produit?\')"> Supprimer</a>';
            $contenu .= '</td>';
        $contenu .= '</tr>';
        //debug($membre);
    }
    $contenu .= '</table>';

    require_once '../inc/header.php';
?>
<div class="bloc">
    <h1>Gestion des produits</h1>
    <div class="produit">
        <ul class="nav nav-tabs">
            <li><a class="nav-link" href="gestion-membre.php">Gestion des membres</a></li>
            <li><a class="nav-link" href="gestion-salle.php">Gestion des salles</a></li>
            <li><a class="nav-link active" href="gestion-produits.php">Gestion des produits</a></li>
            <li><a class="nav-link" href="gestion-commande.php">Gestion des commandes</a></li>
            <li><a class="nav-link" href="gestion-avis.php">Gestion des avis</a></li>
            <li><a class="nav-link" href="statistique.php">Statistique</a></li>
        </ul>
    </div>
    <div class="produit-content">
        <div class="content-table">
            <?php echo $message; ?>
            <h4>Nombre de produit enregistré : <?php echo $nb_row;?> </h4>
            <div class="content-table">
                <?php echo $contenu; ?>
            </div>
        </div>
        <h6>Ajouter ou modifier des produits</h6>
        <form action = "" method = "post" enctype ="multipart/form-data">
            <div class="left">
                <div class="mb-3">
                    <input type="hidden" name="id_produit" value="<?php echo $produit_modifie['id_produit'] ?? 0 ?>">
                </div>
                <div class="mb-3">
                    <label for="date_arrivee" class="form-label">Date d'arrivé</label>
                    <input type="datetime-local" class="form-control" name="date_arrivee" id="date_arrivee" value="<?php echo str_replace(' ','T',$produit_modifie['date_arrivee']) ?? '' ?>" min="<?php echo date('Y-m-d\TH:i') ?>">
                </div>
                <div class="mb-3">
                    <label for="date_depart" class="form-label">Date de départ</label>
                    <input type="datetime-local" class="form-control" name="date_depart" id="date_depart" value ="<?php echo str_replace(' ','T',$produit_modifie['date_depart']) ?? '' ?>" min="<?php echo date('Y-m-d\TH:i') ?>">
                </div>
                <div class="mb-3">
                    <label for="id_salle" class="form-label">Salle</label>
                    <select name="id_salle" id="id_salle" class="form-select" aria-label="Default select example">
                        <?php
                            $resultat = executeRequete("SELECT * FROM salle");
                            while ($salle = $resultat->fetch(PDO::FETCH_ASSOC)) {
                                if (isset($produit_modifie['id_salle']) && $produit_modifie['id_salle'] == $salle['id_salle']) {
                                    echo '<option value="'.$salle['id_salle'].'" selected>'.$salle['id_salle'].' '.$salle['titre'].' - '.$salle['adresse'].', '.$salle['cp'].', '.$salle['ville'].' - '.$salle['capacite'].' Pers</option>';
                                } else {
                                    echo '<option value="'.$salle['id_salle'].'">'.$salle['id_salle'].' '.$salle['titre'].' - '.$salle['adresse'].', '.$salle['cp'].', '.$salle['ville'].' - '.$salle['capacite'].' Pers</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="right">
            <div class="mb-3">
                    <label for="etat" class="form-label">Etat</label>
                    <select name="etat" id="etat" class="form-select" aria-label="Default select example">
                        <option value="libre" <?php if(isset($produit_modifie) && $produit_modifie['etat'] == 'libre') echo 'selected'?>>Libre</option>
                        <option value="reservation" <?php if(isset($produit_modifie) && $produit_modifie['etat'] == 'reservation') echo 'selected'?>>Reservation</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="prix" class="form-label">Prix</label>
                    <input type="text" class="form-control" id="prix" name="prix" value = "<?php echo $produit_modifie['prix'] ?? '' ?>">
                </div>
                <button type="submit" class="btn btn-primary">Modifier ou ajouter un produit</button>
            </div>
        </form>
    </div>
</div>






<?php
require_once '../inc/footer.php';