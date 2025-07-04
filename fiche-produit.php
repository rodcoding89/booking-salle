<?php
    require_once 'inc/init.php';
    $message = '';
    $info = '';
    $actuel_note = 0;
    $salle_note = 0;
    $check = true;
    $check_commentaire = true;
    
    //debug($_SESSION);
    if (isset($_GET) && !empty($_GET)) {
        //debug($_GET);
        $resultat = executeRequete("SELECT * FROM salle s INNER JOIN produit p ON s.id_salle = p.id_salle WHERE p.id_produit = :id_produit",array(
            ':id_produit' => $_GET['id_produit']
        ));

        if($resultat->rowCount() > 0){
            $query = $resultat->fetch(PDO::FETCH_ASSOC);

            $result = executeRequete("SELECT ROUND(AVG(note),1) AS salle_note FROM avis WHERE id_salle = :id_salle",array(':id_salle' => $query['id_salle']));
            $note = $result->fetch(PDO::FETCH_ASSOC);
                //$actuel_note +=$note['note'];
            //debug($note);
            $salle_note = $note['salle_note'];
            
        }else{
            header('location:index.php');
            exit;
        }
        
    }else{
        header('location:index.php');
        exit;
    }

    // le traitement des commandes et des commentaires
    if(isset($_POST) && !empty($_POST)){
        //debug($_POST);
        if (!empty($_POST['id_membre']) && !empty($_POST['id_produit'])) {
            $requete = executeRequete("SELECT * FROM commande WHERE id_membre = :id_membre AND id_produit = :id_produit",array(':id_membre' => $_POST['id_membre'],':id_produit' =>$_POST['id_produit']));
            if ($requete->rowCount() > 0) {
                $check = false;
                $message = '<p class="alert alert-info">Vous avez déja commandé ce produit</p>';
            } else {
                executeRequete("INSERT INTO commande(id_membre,id_produit,date_enregistrement) VALUES(:id_membre,:id_produit,NOW())",array(
                    ':id_membre' => $_POST['id_membre'],
                    ':id_produit' => $_POST['id_produit']
                ));
                executeRequete("UPDATE produit SET etat = :etat WHERE id_produit = :id_produit",array(
                    ':etat' => 'reservation',
                    ':id_produit' => $_POST['id_produit']
                ));
                $message = '<p class="alert alert-success">Commande éffectué</p>';
                $check = false;
            }
        }
        if (!empty($_POST['commentaire']) && !empty($_POST['note'])) {
            //debug($_POST);
            $requete = executeRequete("SELECT * FROM avis WHERE id_membre = :id_membre AND id_salle = :id_salle",array(
                ':id_membre' => $_SESSION['membre']['id_membre'],
                ':id_salle' => $query['id_salle']
            ));
            if ($requete->rowCount() > 0) {
                $check_commentaire = false;
                $message = '<p class="alert alert-info">Vous avez déja commenté ce produit</p>';
            }else{
                executeRequete("INSERT INTO avis(id_membre,id_salle,commentaire,note,date_enregistrement) VALUES(:id_membre,:id_salle,:commentaire,:note,NOW())",array(
                    ':id_membre' => $_SESSION['membre']['id_membre'],
                    ':id_salle' => $query['id_salle'],
                    ':commentaire' => $_POST['commentaire'],
                    ':note' => $_POST['note']
                ));
                $check_commentaire = false;
                $message = '<p class="alert alert-success">Votre commentaire a été pris en compte</p>';
            }
        }
        
    }
    
    require_once 'inc/header.php';
?>


<div class="fiche-produit">
    <div class="message"><?php echo $message;?></div>
    <div class="part1">
        <h3><?php echo $query['categorie'] .' '.$query['titre'].' '.gestionNote(round($salle_note)) ?></h3>
        <div><?php if(estConnecte()) {if($check){echo '<form action ="" method="post"><input type="hidden" name="id_produit" value="'.$_GET['id_produit'].'"><input type="hidden" name="id_membre" value="'.$_SESSION['membre']['id_membre'].'"><input type="submit" value="Reserver" class="btn btn-primary"></form>';}else{echo '';}} else echo '<a href = "connexion.php">Veillez vous connecter pour reserver</a>' ?></div>
    </div>
    <div class="part2">
        <div class="photo">
            <img src="<?php echo $query['photo'] ?>" alt="<?php echo $query['titre'] ?>">
        </div>
        <div class="description">
            <h5>Description</h5>
            <p><?php echo $query['description'] ?></p>
            <h5>Localisation</h5>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.7685630813835!2d2.2945996153519643!3d48.84355307928601!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e67016472aab37%3A0x7f5783172b32028a!2s30%20Rue%20Mademoiselle%2C%2075015%20Paris!5e0!3m2!1sde!2sfr!4v1621070242713!5m2!1sde!2sfr" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
    <h5 class="info">Informations complementaires</h5>
    <div class="part3">
        <div class="periode">
            <p>Arrivée : <?php echo explode(" ",$query['date_arrivee'])[0]?></p>
            <p>Départ : <?php echo explode(" ",$query['date_depart'])[0]?></p>
        </div>
        <div class="capacite">
            <p>Capacité : <?php echo $query['capacite']?></p>
            <p>Catégorie : <?php echo $query['categorie'] ?></p>
        </div>
        <div class="adresse">
            <p>Adresse : <?php echo $query['adresse'] .' '.$query['cp']. ' '. $query['ville'] ?></p>
            <p>Prix : <?php echo $query['prix'].' €' ?></p>
        </div>
    </div>
    <h5 class="info commentaire">Commentaires sur le produit</h5>
    <div class="part4">
        <div class="commentaire-list">
            <?php
                $result = executeRequete("SELECT m.nom,m.prenom,a.commentaire,a.date_enregistrement FROM membre m INNER JOIN avis a ON m.id_membre = a.id_membre WHERE a.id_salle = :id_salle LIMIT 5",array(':id_salle' => $query['id_salle']));
                while ($avis = $result->fetch(PDO::FETCH_ASSOC)) {
                    //debug($avis);
                    echo '<div class="item-list"><div class="left-part"><p>'.substr($avis['nom'],0,1).'</p></div><div class="right-part"><h6>'.$avis['prenom'].' '.$avis['nom'].'</h6><p style="margin-bottom:3px;">'.$avis['commentaire'].'</p><i style="float:right;font-size:0.8em;">'.$avis['date_enregistrement'].'</i></div></div>';
                }
            ?>
        </div>
    </div>
    <h5 class="info">Autres Produits</h5>
    <div class="part5">
        <?php 
            $result = executeRequete("SELECT s.photo,s.titre,p.id_produit,p.id_salle FROM salle s INNER JOIN produit p WHERE s.id_salle = p.id_salle AND s.categorie = :categorie AND p.id_produit != :id_produit AND p.date_arrivee > NOW() AND p.etat = :etat LIMIT 4",array(':categorie' => $query['categorie'],':id_produit' => $_GET['id_produit'],':etat' => 'libre'));
            while ($categorie = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="card"><a href="fiche-produit.php?id_produit='.$categorie['id_produit'].'"><img src="'.$categorie['photo'].'" alt="'.$categorie['titre'].'" class="card-img-top"></a></div>';
            }
        ?>
    </div>
    <h5 class="info">Déposer un commentaire et une note sur le produit</h5>
    <div class="part6">
        <?php
            echo $info;
            if (estConnecte()) {
                if ($check_commentaire) {
                    echo '<form action="" method="post"><div class="mb-3"><label for="commentaire" class="form-label">Commentaire</label><textarea name="commentaire" id="commentaire" class="form-control" placeholder="Laissez un commentaire"></textarea></div><div class="mb-3"><label for="note" class="form-label">Note</label><select name="note" id="note" class="form-select" aria-label="Default select example"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select></div><button type="submit" class="btn btn-primary">Envoyer</button></form>';
                } else {
                    echo '';
                }
            }else{
                echo '<p><a href="connexion.php">Veillez vous connecter </a>pour laissez un commentaire et une note</p>';
            }
        ?>    
    </div>
</div>


<?php
require_once 'inc/footer.php';