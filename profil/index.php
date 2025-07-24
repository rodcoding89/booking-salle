<?php
    require_once dirname(__DIR__) . '/inc/init.php';
    $message = '';
    $contenu = 'Vous avez 0 commande';
    if (!estConnecte()) {
        header('location:'. RACINE_SITE.'sign-in');
    }
    function create_date($dateString) {
        return new DateTime($dateString);
    }
    $result = selectQuery("SELECT * FROM membre WHERE id_membre =:id_membre",array(
        "id_membre" => $_SESSION['membre']['id_membre']
    ));
    $user = $result->fetch(PDO::FETCH_ASSOC);
    $resultat = executeRequete(
    "SELECT c.*, s.* FROM commande c INNER JOIN salle s ON c.id_salle = s.id_salle WHERE c.id_membre = :id_membre",array(':id_membre' => $_SESSION['membre']['id_membre']));
    $contenu = '';
    while ($data = $resultat->fetch(PDO::FETCH_ASSOC)) {
        //debuging($data);
        $contenu .= '<div class="list-group-item reservation-card mb-3"><div class="d-flex justify-content-between"><div>';
        $contenu .= '<h5 class="mb-1">' . $data['titre'] . '</h5>';
        $contenu .= '<p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i>' . $data['ville'] . '</p>';
        $contenu .= '<small class="text-muted"><i class="fas fa-calendar-alt me-2"></i> ' . date_format(create_date($data['date_debut']), "j F, Y") . ' - ' . date_format(create_date($data['date_fin']), "j F, Y") . ' ' . $data['heure_debut'] . ' - ' . $data['heure_fin'] . '</small></div><div class="text-end">';
        $contenu .= '<span class="badge status-badge badg ' . ($data['commande_statut'] == "pending" ? "bg-warning" : ($data['commande_statut'] == "confirmed" ? "bg-success" : ($data['commande_statut'] == "cancelled" ? 'bg-primary' : "bg-secondary"))) . '">' . ($data['commande_statut'] == "pending" ? "En attente" : ($data['commande_statut'] == "confirmed" ? "Confirmée" : ($data['commande_statut'] == "cancelled" ? "Annuler" : "Terminé"))) . '</span>';
        $contenu .= '<p class="price-highlight mt-3">' . $data['prix_total'] . '€</p></div></div><div class="d-flex justify-content-end mt-2">';

        if ($data['commande_statut'] == "pending" || $data['commande_statut'] == "confirmed") {
            $contenu .= '<form method="POST" action= "'.RACINE_SITE . 'inc/reset_orders.php' .'"><input type="hidden" name="orderId" value="'.$data['id_commande'].'"><button type="submit" class="btn btn-outline-danger btn-sm me-2">Annuler</button></form><a href="' . RACINE_SITE . 'profil/booking-detail?orderId='.$data['id_commande'].'" class="btn btn-outline-primary btn-sm">Détails</a>';
        } else {
            $contenu .= '<a href="' . RACINE_SITE . 'profil/booking-detail?orderId='.$data["id_commande"].'" class="btn btn-outline-primary btn-sm">Détails</a>';
        }

        $contenu .= '</div></div>';

        //debug($commande);
    }
    //debug($_SESSION['membre']);
    $errorIncorrectCPw = "";
    $errorIncorrectPw = "";
    if(isset($_POST)){
        if(isset($_POST['updateUser'])){
            $resultat = executeRequete("UPDATE membre SET nom =:nom, prenom =:prenom, email =:email, civilite =:civilite WHERE id_membre =:id_membre", array(
                "nom" => $_POST['nom'],
                "prenom" => $_POST['prenom'],
                "email" => $_POST['email'],
                "civilite" => $_POST['civilite'],
                "id_membre" => $user['id_membre']
            ));
        }else if(isset($_POST['updatePw'])){
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
    }
    if(isset($_GET) && isset($_GET['logout'])){
        session_destroy();
        header("Location:".RACINE_SITE);
    }
    require_once dirname(__DIR__) . '/inc/header.php';
?>

<div class="container-fluid">
    <div class="row align-items-center justify-content-center">
        <!-- Sidebar Profil -->
        <div class="col-lg-3 col-md-4 info-sidebar">
            <div class="text-center mb-4">
                <div class="top mx-auto mb-3">
                    <span><?php echo isset($user) ? substr($user['prenom'],0,1) . substr($user['nom'],0,1) : '';  ?></span>
                </div>
                <h3 id="profile-name"><?php echo isset($user) ? $user['nom']. ' '.$user['prenom'] : '' ?></h3>
                <p class="mb-0"><i class="fas fa-envelope me-2"></i> <span id="profile-email"><?php echo $user['email'] ?></span></p>
                <p><i class="fas fa-user-tag me-2"></i> <span id="profile-status"><?php echo $user['statut'] == 0 ? 'Membre Standard' : 'Administrateur'; ?></span></p>
            </div>

            <ul class="nav nav-pills flex-column mb-4">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="pill" href="#profile-tab">
                        <i class="fas fa-user me-2"></i> Mon Profil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="pill" href="#reservations-tab">
                        <i class="fas fa-calendar-check me-2"></i> Mes Réservations
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="pill" href="#security-tab">
                        <i class="fas fa-lock me-2"></i> Sécurité
                    </a>
                </li>
            </ul>

            <div class="text-center">
                <form action="" method="GET">
                    <button type="submit" name="logout" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt me-1"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>

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

                <!-- Onglet Réservations -->
                <div class="tab-pane fade" id="reservations-tab">
                    <h2 class="mb-4"><i class="fas fa-calendar-check me-2"></i> Mes Réservations</h2>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="btn-group">
                            <button class="btn btn-outline-primary active">Toutes</button>
                            <button class="btn btn-outline-primary">À venir</button>
                            <button class="btn btn-outline-primary">Passées</button>
                        </div>
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Nouvelle réservation
                        </button>
                    </div>

                    <div class="list-group">
                        <?php echo $contenu; ?>
                    </div>
                </div>

                <!-- Onglet Sécurité -->
                <div class="tab-pane fade" id="security-tab">
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
    </div>
    </div>


<?php
require_once dirname(__DIR__) . '/inc/footer.php';