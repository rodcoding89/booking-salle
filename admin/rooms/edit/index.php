<?php
	require_once dirname(dirname(dirname(__DIR__))).'/inc/init.php';
	require_once '../../nav.php';
	$listCaracteristic = [
        "fa-solid fa-video" => "Projecteur",
        "fa-solid fa-fan" => "Climatisation",
        "fa-solid fa-wifi" => "Wi-Fi",
        "fa-solid fa-desktop" => "Ecran LCD",
        "fa-solid fa-microphone" => "Système de conférence",
        "fa-solid fa-volume-xmark" => "Isolation phonique",
        "fa-solid fa-volume-high" => "Sonorisation",
        "fa-solid fa-fa-utensils" => "Service traiteur",
        "fa-solid fa-sticky-note" => "Post-its",
        "fa-solid fa-mug-hot" => "Machine à café",
        "fa-solid fa-square-parking" => "Parking",
        "fa-solid fa-hand-pointer" => "Ecran tactile",
        "fa-solid fa-lock" => "Confidentialité absolue",
        "fa-solid fa-crown" => "Service VIP",
        "fa-solid fa-screwdriver-wrench" => "Equipements techniques",
        "fa-solid fa-couch" => "Espace détente",
        "fa-solid fa-chair" => "Bureaux ergonomiques",
        "fa-solid fa-print" => "Imprimante 3D",
        "fa-solid fa-vr-cardboard" => "Réalité virtuelle",
        "fa-solid fa-volume-low" => "Ambiance sonore",
        "fa-solid fa-wand-magic-sparkles" => "Matériel d'animation",
        "fa-solid fa-spoon" => "Cuisine équipée",
        "fa-solid fa-sun" => "Lumière naturelle",
        "fa-solid fa-wind" => "Air purifié",
        "fa-solid fa-tree" => "Espace extérieur",
        "fa-solid fa-cubes" => "Mobilier modulable",
        "fa-solid fa-microchip" => "Matériel high-tech",
        "fa-solid fa-chalkboard-user" => "Tableaux interactifs",
        "fa-solid fa-flask" => "FabLab",
        "fa-solid fa-border-all" => "Tableaux muraux",
        // Si tu souhaites ajouter "Matériel créatif", donne-lui un icône valide
        "fa-solid fa-paintbrush" => "Matériel créatif",
        "fa-solid fa-mug-saucer" => "Café illimité",
        "fa-solid fa-chalkboard" => "Tableau blanc",
        "fa-solid fa-lightbulb" => "Éclairage professionnel"
    ];
	$salle_modifie = null;
	$message = '';
	$result = executeRequete("SELECT * FROM salle WHERE id_salle = :id_salle",array(':id_salle' => $_GET['id_salle']));
    $salle_modifie = $result->fetch(PDO::FETCH_ASSOC);

    $link = explode("#", $salle_modifie['photo']);
	$url = '';
	if (isset($link[1]) && $link[1] == 'img') {
	    $url = RACINE_SITE. $link[0];
	} else {
	    $url = $link[0];
	}

	//traitement du formulaire
    if (isset($salle_modifie) && !empty($salle_modifie)) {
        $bdd_photo = '';
        //debuging($salle_modifie);
        //debuging($_POST);
        if (isset($_POST['photo_modifiee_img'])) {
            $bdd_photo = $_POST['photo_modifiee_img'];
        }

        if (isset($_POST['photo_modifiee_link'])) {
            $bdd_photo = $_POST['photo_modifiee_link'];
        }

        //debug($_FILES);
        if (!empty($_FILES['photoImg']['name'])) {
            $file_name = uniqid().'_'.$_FILES['photoImg']['name'];
            $fileLink = dirname(dirname(dirname(__DIR__))).'/images/'.$file_name;
            $bdd_photo = 'images/'.$file_name.'#img';
            copy($_FILES['photoImg']['tmp_name'],$fileLink);
        }

        if (isset($_POST['photoLink']) && !empty($_POST['photoLink'])) {
        	$bdd_photo = $_POST['photoLink'].'#link';
        }
        //debug($_POST);
        if (!empty($_POST['titre']) && !empty($_POST['description']) && !empty($bdd_photo) && !empty($_POST['pays']) && !empty($_POST['rue']) && !empty($_POST['ville']) && !empty($_POST['cp']) && !empty($_POST['capacite']) && !empty($_POST['categorie']) && !empty($_POST['prix']) && !empty($_POST['caracteristic'])) {
            $resultat = executeRequete("REPLACE INTO salle(id_salle,titre,description,photo,pays,ville,rue,cp,capacite,categorie,prix,etat,caracteristic) VALUES(:id_salle,:titre,:description,:photo,:pays,:ville,:rue,:cp,:capacite,:categorie,:prix,:etat,:caracteristic)",array(
                ':id_salle' => $_POST['id_salle'],
                ':titre' => $_POST['titre'],
                ':description' => $_POST['description'],
                ':photo' => $bdd_photo,
                ':pays' => $_POST['pays'],
                ':ville' => $_POST['ville'],
                ':rue' => $_POST['rue'],
                ':cp' => $_POST['cp'],
                ':capacite' => $_POST['capacite'],
                ':categorie' => $_POST['categorie'],
                ':prix' => $_POST['prix'],
                ':etat' => false,
                ':caracteristic' => implode(", ",$_POST['caracteristic'])
            ));
            if ($resultat) {
            	$result = executeRequete("SELECT * FROM salle WHERE id_salle = :id_salle",array(':id_salle' => $_GET['id_salle']));
	    		$salle_modifie = $result->fetch(PDO::FETCH_ASSOC);
	            $_POST = array();
	            $message = '<div class="alert alert-success">La salle à été Ajouté avec sucèss</div>';
            } else {
            	$message = '<div class="alert alert-danger">Veillez remplir tous les champs</div>';
            }
            
            //header("Location:".RACINE_SITE.'admin/rooms/add');
        }else{
            
        }
    }

    $selectedCaracteristic = explode(", ", $salle_modifie['caracteristic']);
    //var_dump($salle_modifie['caracteristic']);
    //var_dump($selectedCaracteristic);

?>
<div class="addForm" style="margin-top: 100px;">
	<?php echo $message; ?>
	<h2 class="mb-4">Ajouter une nouvelle salle</h2>
	<form action = "" method = "post" enctype ="multipart/form-data">
		<input type="hidden" name="id_salle" value="<?php echo $salle_modifie['id_salle'] ?>">
		<div class="d-flex justify-content-between align-items-start gap-4 flex-wrap">
			<div class="left">
	            <div class="mb-3 item">
	                <label for="titre" class="form-label">Titre</label>
	                <input type="text" class="form-control" id="titre" name="titre" placeholder = "Titre de la salle" value="<?php echo $salle_modifie['titre'] ?? '' ?>">
	            </div>
	            <div class="mb-3 item">
	                <label for="description" class="form-label">Description</label>
	                <textarea name="description" id="description" class="form-control" placeholder="Description de la salle"><?php echo $salle_modifie['description'] ?? '' ?></textarea>
	            </div>
	            <div class="mb-3 item">
	                <label for="capacite" class="form-label">Capacité</label>
	                <input type="number" name="capacite" min="5" class="form-control" max="50" value="<?php echo isset($salle_modifie['capacite']) ? $salle_modifie['capacite'] : 5; ?>">
	            </div>
	            <div class="mb-3 item">
	                <label for="categorie" class="form-label">Catégorie</label>
	                <select name="categorie" id="categorie" class="form-select" aria-label="Default select example">
	                    <option value="reunion" <?php if(isset($salle_modifie['categorie']) && $salle_modifie['categorie'] == 'reunion') echo 'selected'; ?>>Réunion</option>
	                    <option value="bureau" <?php if(isset($salle_modifie['categorie']) && $salle_modifie['categorie'] == 'bureau') echo 'selected'; ?>>Bureau</option>
	                    <option value="formation" <?php if(isset($salle_modifie['categorie']) && $salle_modifie['categorie'] == 'formation') echo 'selected'; ?>>Formation</option>
	                </select>
	            </div>
	            <div class="mb-3 item">
	            	<label for="caracteristic" class="form-label">Caractéristique</label>
	            	<?php echo genereOption($listCaracteristic,$selectedCaracteristic); ?>
	            </div>
	        </div>
	        <div class="right">
	            <div class="mb-3 item">
	                <label for="pays" class="form-label">Pays</label>
	                <input type="text" class="form-control" id="titre" name="pays" placeholder = "Titre de la salle" value="France" readonly>
	            </div>
	            <div class="mb-3 item">
	                <label for="ville" class="form-label">Ville</label>
	                <select name="ville" id="ville" class="form-select" aria-label="Default select example">
	                	<option value="paris" <?php if(isset($salle_modifie['ville']) && $salle_modifie['ville'] == 'paris') echo 'selected'; ?>>Paris</option>
	                    <option value="lyon" <?php if(isset($salle_modifie['ville']) && $salle_modifie['ville'] == 'lyon') echo 'selected'; ?>>Lyon</option>
	                    <option value="marseille" <?php if(isset($salle_modifie['ville']) && $salle_modifie['ville'] == 'marseille') echo 'selected'; ?>>Marseille</option>
	                    <option value="toulouse" <?php if(isset($salle_modifie['ville']) && $salle_modifie['ville'] == 'toulouse') echo 'selected'; ?>>Toulouse</option>
	                    <option value="nice" <?php if(isset($salle_modifie['ville']) && $salle_modifie['ville'] == 'nice') echo 'selected'; ?>>Nice</option>
	                    <option value="bordeaux" <?php if(isset($salle_modifie['ville']) && $salle_modifie['ville'] == 'bordeaux') echo 'selected'; ?>>Bordeaux</option>
	                    <option value="nante" <?php if(isset($salle_modifie['ville']) && $salle_modifie['ville'] == 'nante') echo 'selected'; ?>>Nante</option>
	                    <option value="monpellier" <?php if(isset($salle_modifie['ville']) && $salle_modifie['ville'] == 'monpellier') echo 'selected'; ?>>Monpellier</option>
	                    <option value="strasbourg" <?php if(isset($salle_modifie['ville']) && $salle_modifie['ville'] == 'strasbourg') echo 'selected'; ?>>Strasbourg</option>
	                    <option value="lille" <?php if(isset($salle_modifie['ville']) && $salle_modifie['ville'] == 'lille') echo 'selected'; ?>>Lille</option>
	                </select>
	            </div>
	            <div class="mb-3 item">
	                <label for="rue" class="form-label">rue</label>
	                <textarea name="rue" id="rue" class="form-control" placeholder="rue"><?php echo $salle_modifie['rue'] ?? '' ?></textarea>
	            </div>
	            <div class="mb-3 item">
	                <label for="cp" class="form-label">Code postal</label>
	                <input type="text" class="form-control" id="cp" name="cp" value = "<?php echo $salle_modifie['cp'] ?? '' ?>">
	            </div>
	            <div class="mb-3 item">
	                <label for="prix" class="form-label">Prix journalier</label>
	                <input type="number" class="form-control" id="prix" name="prix" value = "<?php echo $salle_modifie['prix'] ?? '' ?>">
	            </div>
	        </div>
		</div>
		<div class="mt-4">
        	<ul class="nav nav-pills mb-4">
                <li class="nav-item">
                    <a class="nav-link <?php 
                    	$link = explode("#",$salle_modifie['photo']);
                    	if (isset($link[1]) && $link[1] == 'img') {
                    	 	echo 'active';
                    	}?>" data-bs-toggle="pill" href="#image-tab">
                        <i class="fas fa-file-image me-2"></i> Image
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php 
                    	$link = explode("#",$salle_modifie['photo']);
                    	if (isset($link[1]) && $link[1] == 'link') {
                    	 	echo 'active';
                    	}?>" data-bs-toggle="pill" href="#link-tab">
		                <i class="fas fa-external-link me-2"></i> Lien
		            </a>
                </li>
            </ul>
            <div class="tab-content">
                <!-- Onglet Profil -->
                <div class="tab-pane fade show active mb-3 p-3" id="image-tab" style="border: 1px dashed #ccc;">
	                <label for="photoImg" class="form-label">Ajouter une image</label>
	                <input class="form-control" type="file" name = "photoImg" id="photoImg">
	                <?php
	                    echo '<p>Photo actuelle : </p>';
				        echo '<div><img src="'.$url.'" style="width:80px"> </div>';
				        echo '<input type="hidden" name="photo_modifiee_img" id="photo_modifiee_img" value="'.$url.'">';
	                ?>
	            </div>
	            <div class="tab-pane fade show mb-3 p-3" id="link-tab" style="border: 1px dashed #ccc;">
	                <label for="photoLink" class="form-label">Ajouter un lien</label>
	                <input class="form-control" type="text" name = "photoLink" id="photoLink" placeholder="Ajouter un lien pour la salle">
	                <?php 
	                    if (isset($salle_modifie['photo'])) {
	                        echo '<p>Photo actuelle : </p>';
					        echo '<div><img src="'.$url.'" style="width:80px"> </div>';
					        echo '<input type="hidden" name="photo_modifiee_link" id="photo_modifiee_link" value="'.$url.'">';
	                    }
	                ?>
	            </div>
        	</div>
        </div>
		<button type="submit" class="btn btn-primary w-100 mt-3">Enregistrer</button>
    </form>
</div>


<?php
	require_once '../../footer.php';