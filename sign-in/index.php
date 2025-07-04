<?php
    require_once dirname(__DIR__) . '/inc/init.php';
    $message = '';

    if (!empty($_POST)) {
        if (empty($_POST['pseudo'])) {
            $message .= '<div class="alert alert-danger">Veillez remplir votre champ pseudo</div>';
        }
        if (empty($_POST['mdp'])) {
            $message .= '<div class="alert alert-danger">Veillez remplir votre champ mot de passe</div>';
        }
        if (!empty($_POST['pseudo']) && !empty($_POST['mdp'])) {
            $resultat = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo",array(':pseudo' => $_POST['pseudo']));
            if ($resultat->rowCount() > 0) {
                $membre = $resultat->fetch(PDO::FETCH_ASSOC);
                if (password_verify($_POST['mdp'],$membre['mdp'])) {
                    $_SESSION['membre'] = $membre;
                    header('location:profil.php');
                }else{
                    $message = '<div class="alert alert-danger">Vos données saisies sont incorrectes</div>';
                }
                //debug($membre);
            }else{
                $message = '<div class="alert alert-danger">Vos données saisies sont incorrectes</div>';
            }
        }
    }
    if (isset($_GET['action']) && $_GET['action'] == 'deconnexion') {
        unset($_SESSION['membre']);
        header('location:connexion.php');
        exit;
    }
    //debug($_POST);


    require_once dirname(__DIR__) . '/inc/header.php';
?>

<div class="container-fluid login-container">
    <div class="row align-items-center justify-content-center">
        <!-- Sidebar Informative -->
        <div class="col-lg-5 col-md-6 d-none d-md-block info-sidebar">
            <div class="text-center mb-5">
                <h2><i class="fas fa-calendar-check"></i> Booking Sale</h2>
                <p class="lead">Réservez l'espace parfait pour vos besoins professionnels</p>
            </div>

            <h4 class="mb-4">Retrouvez vos avantages</h4>

            <div class="benefit-item d-flex align-items-start">
                <i class="fas fa-history benefit-icon"></i>
                <div>
                    <h5>Historique de réservations</h5>
                    <p>Accédez à toutes vos réservations passées et à venir</p>
                </div>
            </div>

            <div class="benefit-item d-flex align-items-start">
                <i class="fas fa-percent benefit-icon"></i>
                <div>
                    <h5>Tarifs préférentiels</h5>
                    <p>Bénéficiez de réductions exclusives en tant que membre</p>
                </div>
            </div>

            <div class="benefit-item d-flex align-items-start">
                <i class="fas fa-bolt benefit-icon"></i>
                <div>
                    <h5>Réservation express</h5>
                    <p>Accédez à notre système de réservation en 1 clic</p>
                </div>
            </div>

            <div class="mt-5 text-center">
                <p>Pas encore membre ? <a href="<?php echo RACINE_SITE. 'sign-up' ?>" class="text-white fw-bold">Inscrivez-vous</a></p>
            </div>
        </div>

        <!-- Formulaire de connexion -->
        <div class="col-lg-5 col-md-6 form-side">
            <h2 class="mb-4">Connectez-vous</h2>
            <p class="mb-4">Accédez à votre espace personnel pour gérer vos réservations.</p>

            <form>
                <div class="mb-3">
                    <label class="form-label">Email ou pseudo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="loginPassword" required>
                        <button class="btn btn-outline-secondary" type="button" id="toggleLoginPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="text-end mt-2">
                        <a href="#" class="text-decoration-none">Mot de passe oublié ?</a>
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="rememberCheck">
                    <label class="form-check-label" for="rememberCheck">Se souvenir de moi</label>
                </div>

                <div class="d-grid gap-2 mb-4">
                    <button type="submit" class="btn btn-primary btn-lg">Se connecter</button>
                </div>

                <div class="divider">
                    <span class="divider-text">OU</span>
                </div>

                <div class="mb-3">
                    <button class="btn btn-light social-btn w-100" style="border: 1px solid #dee2e6;">
                        <i class="fab fa-google text-danger"></i> Continuer avec Google
                    </button>
                    <button class="btn btn-light social-btn w-100" style="border: 1px solid #dee2e6;">
                        <i class="fab fa-microsoft text-primary"></i> Continuer avec Microsoft
                    </button>
                </div>

                <div class="mt-3 text-center d-md-none">
                    <p>Pas encore membre ? <a href="#">Inscrivez-vous</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
        // Toggle password visibility
    document.getElementById('toggleLoginPassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('loginPassword');
        const icon = this.querySelector('i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
</script>








<?php
require_once dirname(__DIR__) . '/inc/footer.php';