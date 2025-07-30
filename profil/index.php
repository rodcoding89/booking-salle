<?php
    require_once dirname(__DIR__) . '/inc/init.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $message = '';
    $contenu = '';
    if (!estConnecte()) {
        header('location:'. RACINE_SITE.'sign-in');
    }
    //debug($_SESSION['membre']);
    $contenu;
    $user;
    if(isset($_POST)){
        if(isset($_POST['updateUser'])){
            $resultat = executeRequete("UPDATE membre SET nom =:nom, prenom =:prenom, email =:email, civilite =:civilite WHERE id_membre =:id_membre", array(
                "nom" => $_POST['nom'],
                "prenom" => $_POST['prenom'],
                "email" => $_POST['email'],
                "civilite" => $_POST['civilite'],
                "id_membre" => $user['id_membre']
            ));
        }
    }
    if(isset($_GET) && isset($_GET['logout'])){
        session_destroy();
        header("Location:".RACINE_SITE);
    }
    require_once dirname(__DIR__) . '/inc/header.php';
?>

<div class="container-fluid">
    <div class="row align-items-center justify-content-center">
        <?php require_once __DIR__.'/aside.php'; ?>
        <!-- Contenu du Profil -->
        <div class="col-lg-7 col-md-8 profile-content">
            <div class="tab-content">
                <!-- Onglet Profil -->
                <div class="tab-pane fade show active" id="profile-tab">
                    <h2 class="mb-4"><i class="fas fa-user-cog me-2"></i> Modifier mon profil</h2>

                    <form id="profile-form" method="POST" action="">
                        <div class="row mb-3">
                            <div class="col-md-2 mb-3 mb-md-0">
                                <label class="form-label">Civilité</label>
                                <select class="form-select" id="civilite" name="civilite">
                                    <option value="m" <?php echo (isset($user['civilite']) && $user['civilite'] == 'm') ? 'selected' : ''; ?>>M.</option>
                                    <option value="f" <?php echo (isset($user['civilite']) && $user['civilite'] == 'f') ? 'selected' : ''; ?>>Mme</option>
                                </select>
                            </div>
                            <div class="col-md-5 mb-3 mb-md-0">
                                <label class="form-label">Prénom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $user['nom'] ?>" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $user['prenom'] ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pseudo</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo $user['pseudo'] ?>" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email'] ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Statut</label>
                            <input type="text" class="form-control" id="statut" name="statut" value="<?php echo $user['statut'] == 0 ? 'Membre Standard' : 'Administrateur'; ?>" readonly>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" name="updateUser" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
                <!-- Onglet Sécurité -->
            </div>
        </div>
    </div>
    </div>


<?php
require_once dirname(__DIR__) . '/inc/footer.php';