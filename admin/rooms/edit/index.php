<?php
	require_once dirname(dirname(dirname(__DIR__))).'/inc/init.php';
	require_once '../../nav.php';
	$salle_modifie = [];
?>
<div class="addForm" style="margin-top: 155px;">
	<h2 class="mb-4">Modifier la salle</h2>
	<form action = "" method = "post" enctype ="multipart/form-data">
		<input type="hidden" name="id_salle" value="<?php echo $salle_modifie['id_salle'] ?? 0; ?>">
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
	                <input type="number" name="capacite" min="5" class="form-control" max="50" value="<?php echo isset($salle_modifie['capacite']) ? $salle_modifie['capacite'] : 0; ?>">
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
	        </div>
		</div>
		<button type="submit" class="btn btn-primary w-100 mt-3">Modifier</button>
    </form>
</div>

<?php
	require_once '../../footer.php';