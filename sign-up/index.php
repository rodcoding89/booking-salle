<?php

    require_once dirname(__DIR__) . '/inc/init.php';
    $message = '';
    $errorPseudo = '';
    $errorEmail = '';
    $errorMdp = '';
    $errorNom = '';
    $errorPrenom = '';
    $errorCivilite = '';
    $cguError = '';
    if (!empty($_POST)) {
        if(isset($_POST['cgu'])){
            if (empty($_POST['pseudo']) || strlen($_POST['pseudo']) < 4 || strlen($_POST['pseudo']) > 20) {
                $errorPseudo = '<p class="alert alert-danger">Le pseudo doit contenir 4 à 20 caractéres</p>';
            }
            if (empty($_POST['email']) || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
                $errorEmail = '<p class="alert alert-danger">L\'email adresse est invalide</p>';
            }
            if (empty($_POST['mdp']) || strlen($_POST['mdp']) < 5 || strlen($_POST['mdp']) > 12) {
                $errorMdp = '<p class="alert alert-danger">Le mot de passe doit contenir 5 à 12 caractéres</p>';
            }
            if (empty($_POST['nom']) || strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 20) {
                $errorNom = '<p class="alert alert-danger">Le nom doit contenir 2 à 20 caractéres</p>';
            }
            if (empty($_POST['prenom']) || strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) > 20) {
                $errorPrenom = '<p class="alert alert-danger">Le prenom doit contenir 2 à 20 caractéres</p>';
            }
            $civilite = array("m","f");
            if (!isset($_POST['civilite']) || ! in_array($_POST['civilite'],$civilite)) {
                $errorCivilite = '<p class="alert alert-danger">La civilité est invalide</p>';
            }

            if (empty($errorPseudo) && empty($errorEmail) && empty($errorMdp) && empty($errorNom) && empty($errorPrenom) && empty($errorCivilite)) {
                $resultat = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo",array(':pseudo' => $_POST['pseudo'] ));

                if ($resultat->rowCount() > 0) {
                    $errorPseudo = '<p class="alert alert-danger">Le pseudo est déja pris. Choisissez un autre</p>';
                } else {
                    $encodeMdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
                    executeRequete("INSERT INTO membre (pseudo,mdp,nom,prenom,email,civilite,statut,date_enregistrement) VALUES (:pseudo,:mdp,:nom,:prenom,:email,:civilite,:statut,NOW())",array(
                        ':pseudo' => $_POST['pseudo'],
                        ':mdp' => $encodeMdp,
                        ':nom' => $_POST['nom'],
                        ':prenom' => $_POST['prenom'],
                        ':email' => $_POST['email'],
                        ':civilite' => $_POST['civilite'],
                        ':statut' => 0
                    ));
                    $message .= '<div class="alert alert-success">Votre inscription a été un succes <a href="'. RACINE_SITE.'sign-in"> Cliquer ici</a> pour vous connecter</div>';

                }
            }
        }else{
            $cguError .= '<div class="alert alert-danger">Veuillez valider nos CGU et Politiques de confidentialités.</div>';
        }
    }
    //debug($_POST);

    require_once dirname(__DIR__) . '/inc/header.php';
?>

<div class="container-fluid registration-container">
    <div class="row align-items-center justify-content-center">
        <!-- Sidebar Informative -->
        <div class="col-lg-5 col-md-6 d-none d-md-block info-sidebar">
            <div class="text-center mb-5">
                <h2><i class="fas fa-calendar-check"></i> Booking Sale</h2>
                <p class="lead">Réservez l'espace parfait pour vos besoins professionnels</p>
            </div>

            <h4 class="mb-4">Pourquoi nous choisir ?</h4>

            <div class="benefit-item d-flex align-items-start">
                <i class="fas fa-check-circle benefit-icon"></i>
                <div>
                    <h5>+500 salles disponibles</h5>
                    <p>Des espaces adaptés à tous vos événements dans toute la France</p>
                </div>
            </div>

            <div class="benefit-item d-flex align-items-start">
                <i class="fas fa-euro-sign benefit-icon"></i>
                <div>
                    <h5>Meilleurs prix garantis</h5>
                    <p>Jusqu'à 30% moins cher que la concurrence</p>
                </div>
            </div>

            <div class="benefit-item d-flex align-items-start">
                <i class="fas fa-headset benefit-icon"></i>
                <div>
                    <h5>Support 24/7</h5>
                    <p>Notre équipe est disponible à tout moment pour vous aider</p>
                </div>
            </div>

            <div class="mt-5 text-center">
                <p>Déjà membre ? <a href="<?php echo RACINE_SITE . 'sign-in'; ?>" class="text-white fw-bold">Connectez-vous</a></p>
            </div>
        </div>

        <!-- Formulaire d'inscription -->
        <div class="col-lg-5 col-md-6 form-side">
            <?php echo $message; ?>
            <h2 class="mb-4">Créer un compte</h2>
            <p class="mb-4">Rejoignez notre communauté et accédez à des centaines d'espaces de travail.</p>

            <form action="" method="post">
                <div class="row mb-3">
                    <div class="col-md-12 mb-3 mb-md-0">
                        <label class="form-label">Civilité</label>
                        <select class="form-select" name="civilite">
                            <option value="m" <?php echo (isset($_POST['civilite']) && $_POST['civilite'] == 'm') ? 'selected' : ''; ?>>M.</option>
                            <option value="f" <?php echo (isset($_POST['civilite']) && $_POST['civilite'] == 'f') ? 'selected' : ''; ?>>Mme</option>
                        </select>
                        <?php echo $errorCivilite; ?>
                    </div>
                    <div class="col-md-12 mb-3 mb-md-0">
                        <label class="form-label">Prénom</label>
                        <input type="text" value="<?php echo isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : ''; ?>" class="form-control" name="prenom">
                        <?php echo $errorPrenom; ?>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Nom</label>
                        <input type="text" value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>" class="form-control" name="nom">
                        <?php echo $errorNom; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pseudo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" value="<?php echo isset($_POST['pseudo']) ? htmlspecialchars($_POST['pseudo']) : ''; ?>" class="form-control" name="pseudo">
                    </div>
                    <?php echo $errorPseudo; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="text" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" class="form-control" name="email">
                    </div>
                    <?php echo $errorEmail; ?>
                </div>
                <div class="mb-4">
                    <label class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" value="<?php echo isset($_POST['mdp']) ? htmlspecialchars($_POST['mdp']) : ''; ?>" id="signUpPassword" name="mdp">
                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordSignUp">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="form-text">Minimum 8 caractères avec chiffres et lettres</div>
                    <?php echo $errorMdp; ?>
                </div>
                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="termsCheck" name="cgu" <?php echo isset($_POST['cgu']) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="termsCheck">
                        J'accepte les <a href="#">conditions générales</a> et la <a href="#">politique de confidentialité</a>
                    </label>
                </div>
                <?php echo $cguError; ?>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">S'inscrire</button>
                </div>
                <div class="mt-3 text-center d-md-none">
                    <p>Déjà membre ? <a href="<?php echo RACINE_SITE . 'sign-in'; ?>">Connectez-vous</a></p>
                </div>
            </form>

        </div>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/inc/footer.php';