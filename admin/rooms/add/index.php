<?php
	require_once dirname(dirname(dirname(__DIR__))).'/inc/init.php';
	require_once '../../nav.php';
?>

<div class="addForm" style="margin-top: 155px;">
	<h2 class="mb-4">Ajouter une nouvelle salle</h2>
	<form action = "" method = "post" enctype ="multipart/form-data">
		<div class="d-flex justify-content-between align-items-start gap-4 flex-wrap">
			<div class="left">
	            <div class="mb-3 item">
	                <label for="titre" class="form-label">Titre</label>
	                <input type="text" class="form-control" id="titre" name="titre" placeholder = "Titre de la salle" value="<?php echo $_POST['titre'] ?? '' ?>">
	            </div>
	            <div class="mb-3 item">
	                <label for="description" class="form-label">Description</label>
	                <textarea name="description" id="description" class="form-control" placeholder="Description de la salle"><?php echo $_POST['description'] ?? '' ?></textarea>
	            </div>
	            <div class="mb-3 item">
	                <label for="capacite" class="form-label">Capacité</label>
	                <input type="number" name="capacite" min="5" class="form-control" max="50" value="<?php echo isset($_POST['capacite']) ? $_POST['capacite'] : 0; ?>">
	            </div>
	            <div class="mb-3 item">
	                <label for="categorie" class="form-label">Catégorie</label>
	                <select name="categorie" id="categorie" class="form-select" aria-label="Default select example">
	                    <option value="reunion" <?php if(isset($_POST['categorie']) && $_POST['categorie'] == 'reunion') echo 'selected'; ?>>Réunion</option>
	                    <option value="bureau" <?php if(isset($_POST['categorie']) && $_POST['categorie'] == 'bureau') echo 'selected'; ?>>Bureau</option>
	                    <option value="formation" <?php if(isset($_POST['categorie']) && $_POST['categorie'] == 'formation') echo 'selected'; ?>>Formation</option>
	                </select>
	            </div>
	            <div class="mb-3 item">
	                <label for="photo" class="form-label">Photo</label>
	                <input class="form-control" type="file" id="formFile" name = "photo" id="photo">
	                <?php 
	                    if (isset($_POST['photo'])) {
	                        echo '<p>Photo actuelle : </p>';
					        echo '<div><img src="../'.$_POST['photo'].'" style="width:80px"> </div>';
					        echo '<input type="hidden" name="photo_modifiee" id="photo_modifiee" value="'.$_POST['photo'].'">';
	                    }
	                ?>
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
	                	<option value="paris" <?php if(isset($_POST['ville']) && $_POST['ville'] == 'paris') echo 'selected'; ?>>Paris</option>
	                    <option value="lyon" <?php if(isset($_POST['ville']) && $_POST['ville'] == 'lyon') echo 'selected'; ?>>Lyon</option>
	                    <option value="marseille" <?php if(isset($_POST['ville']) && $_POST['ville'] == 'marseille') echo 'selected'; ?>>Marseille</option>
	                    <option value="toulouse" <?php if(isset($_POST['ville']) && $_POST['ville'] == 'toulouse') echo 'selected'; ?>>Toulouse</option>
	                    <option value="nice" <?php if(isset($_POST['ville']) && $_POST['ville'] == 'nice') echo 'selected'; ?>>Nice</option>
	                    <option value="bordeaux" <?php if(isset($_POST['ville']) && $_POST['ville'] == 'bordeaux') echo 'selected'; ?>>Bordeaux</option>
	                    <option value="nante" <?php if(isset($_POST['ville']) && $_POST['ville'] == 'nante') echo 'selected'; ?>>Nante</option>
	                    <option value="monpellier" <?php if(isset($_POST['ville']) && $_POST['ville'] == 'monpellier') echo 'selected'; ?>>Monpellier</option>
	                    <option value="strasbourg" <?php if(isset($_POST['ville']) && $_POST['ville'] == 'strasbourg') echo 'selected'; ?>>Strasbourg</option>
	                    <option value="lille" <?php if(isset($_POST['ville']) && $_POST['ville'] == 'lille') echo 'selected'; ?>>Lille</option>
	                </select>
	            </div>
	            <div class="mb-3 item">
	                <label for="rue" class="form-label">rue</label>
	                <textarea name="rue" id="rue" class="form-control" placeholder="rue"><?php echo $_POST['rue'] ?? '' ?></textarea>
	            </div>
	            <div class="mb-3 item">
	                <label for="cp" class="form-label">Code postal</label>
	                <input type="text" class="form-control" id="cp" name="cp" value = "<?php echo $_POST['cp'] ?? '' ?>">
	            </div>
	        </div>
		</div>
		<button type="submit" class="btn btn-primary w-100 mt-3">Enregistrer</button>
    </form>
</div>

<?php
	require_once '../../footer.php';