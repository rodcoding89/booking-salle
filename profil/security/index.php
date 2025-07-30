<?php
    require_once dirname(dirname(__DIR__)) . '/inc/init.php';
    $errorIncorrectCPw = "";
    $errorIncorrectPw = "";
    if(isset($_POST['updatePw'])){
        //var_dump($_POST);
        if (password_verify($_POST['apw'],$user['mdp'])) {
            if($_POST['npw'] == $_POST['cpw']){
                $hashedPw = password_hash($_POST['npw'], PASSWORD_DEFAULT);
                $query = executeRequete("UPDATE membre SET mdp = :mdp WHERE id_membre =:id_membre", array(
                    "mdp" => $hashedPw,
                    "id_membre" => $user['id_membre']
                ));
            }else{
                $errorIncorrectCPw = "<div class='alert alert-danger mt-3'>Votre nouveau mot de passe ne correspond a celui de confirmation.</div>";
            }
        } else {
            $errorIncorrectPw = "<div class='alert alert-danger mt-3'>Votre mot de passe actuelle ne correspond pas a celui saisi.</div>";
        }
    }
    require_once dirname(dirname(__DIR__)) . '/inc/header.php';
?>
<div class="tab-pane">
    <div class="row align-items-center justify-content-center">
        <?php require_once dirname(__DIR__).'/aside.php'; ?>
        <div class="col-lg-7 col-md-8 profile-content">
            <h2 class="mb-4"><i class="fas fa-lock me-2"></i> Sécurité du compte</h2>

            <form id="security-form" action="" method="POST">
                <div class="mb-4">
                    <h5>Changer le mot de passe</h5>
                    <div class="mb-3">
                        <label class="form-label">Mot de passe actuel</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="apw" class="form-control" id="current-password" required value="<?php echo isset($_POST['apw']) ? $_POST['apw'] : ''; ?>">
                            <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <?php echo $errorIncorrectPw; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nouveau mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="npw" class="form-control" id="new-password" required value="<?php echo isset($_POST['npw']) ? $_POST['npw'] : ''; ?>">
                            <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-text">Minimum 8 caractères avec chiffres et lettres</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirmer le nouveau mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="cpw" class="form-control" id="confirm-password" required value="<?php echo isset($_POST['cpw']) ? $_POST['cpw'] : ''; ?>">
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <?php echo $errorIncorrectCPw; ?>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" name="updatePw" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </div>

                <div class="mb-4">
                    <h5>Sécurité supplémentaire</h5>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="twoFactorAuth" checked>
                        <label class="form-check-label" for="twoFactorAuth">Authentification à deux facteurs</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="loginAlerts">
                        <label class="form-check-label" for="loginAlerts">Alertes de connexion</label>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
    require_once dirname(dirname(__DIR__)) . '/inc/footer.php';