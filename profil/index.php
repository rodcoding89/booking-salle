<?php
    require_once dirname(__DIR__) . '/inc/init.php';
    $message = '';
    $contenu = 'Vous avez 0 commande';
    if (!estConnecte()) {
        header('location:'. RACINE_SITE.'sign-in');
    }
    $user = $_SESSION['membre'];
    $resultat = executeRequete("SELECT * FROM commande c INNER JOIN produit p ON c.id_produit = p.id_produit INNER JOIN salle s ON s.id_salle = p.id_salle WHERE id_membre = :id_membre",array(':id_membre' => $_SESSION['membre']['id_membre']));
    while ($commande = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $contenu  = '<div class="commande-item">';
        $contenu .= '<h6>'.$commande['categorie'].' '.$commande['titre'].'</h6>';
        $contenu .= '<div class="historique">';
        $contenu .= '<img src="'.$commande['photo'].'" alt="'.$commande['titre'].'">';
        $contenu .= '<div style="margin-right:20px;"><p>Arrivée : '.explode(" ",$commande['date_arrivee'])[0].'</p><p>Départ : '.explode(" ",$commande['date_depart'])[0].'</p></div>';
        $contenu .= '<div><p>Adresse : '.$commande['adresse'].' '.$commande['cp'].' '.$commande['ville'].'</p><p>Capacité :'.$commande['capacite'].'</p></div>';
        $contenu .= '</div>';
        $contenu .= '<p>Enregistré le : '.explode(" ",$commande['date_enregistrement'])[0].'</p>';
        $contenu .= '</div>';
        //debug($commande);
    }
    //debug($_SESSION['membre']);

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
                <button class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt me-1"></i> Déconnexion
                </button>
            </div>
        </div>

        <!-- Contenu du Profil -->
        <div class="col-lg-7 col-md-8 profile-content">
            <div class="tab-content">
                <!-- Onglet Profil -->
                <div class="tab-pane fade show active" id="profile-tab">
                    <h2 class="mb-4"><i class="fas fa-user-cog me-2"></i> Modifier mon profil</h2>

                    <form id="profile-form">
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
                                <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo $user['pseudo'] ?>" required>
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
                            <button type="button" class="btn btn-outline-secondary me-2">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
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
                        <!-- Réservation 1 -->
                        <div class="list-group-item reservation-card mb-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">Salle de Réunion Lumineuse</h5>
                                    <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i> Paris</p>
                                    <small class="text-muted"><i class="fas fa-calendar-alt me-2"></i> 15 juin 2023, 09:00 - 12:00</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-success status-badge">Confirmée</span>
                                    <p class="price-highlight mt-2">120€</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-2">
                                <button class="btn btn-outline-danger btn-sm me-2">Annuler</button>
                                <a href="<?php echo RACINE_SITE .'profil/booking-detail?id=1' ?>" class="btn btn-outline-primary btn-sm">Détails</a>
                            </div>
                        </div>

                        <!-- Réservation 2 -->
                        <div class="list-group-item reservation-card mb-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">Bureau Privé Moderne</h5>
                                    <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i> Lyon</p>
                                    <small class="text-muted"><i class="fas fa-calendar-alt me-2"></i> 20 juin 2023, 08:00 - 18:00</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-warning text-dark status-badge">En attente</span>
                                    <p class="price-highlight mt-2">80€</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-2">
                                <button class="btn btn-outline-danger btn-sm me-2">Annuler</button>
                                <a href="<?php echo RACINE_SITE .'profil/booking-detail?id=1' ?>" class="btn btn-outline-primary btn-sm">Détails</a>
                            </div>
                        </div>

                        <!-- Réservation 3 -->
                        <div class="list-group-item reservation-card">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">Espace Formation Professionnel</h5>
                                    <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i> Marseille</p>
                                    <small class="text-muted"><i class="fas fa-calendar-alt me-2"></i> 5 juin 2023, 10:00 - 17:00</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-secondary status-badge">Terminée</span>
                                    <p class="price-highlight mt-2">250€</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-2">
                                <button class="btn btn-outline-secondary btn-sm me-2">Archiver</button>
                                <a href="<?php echo RACINE_SITE .'profil/booking-detail?id=1' ?>" class="btn btn-outline-primary btn-sm">Détails</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Onglet Sécurité -->
                <div class="tab-pane fade" id="security-tab">
                    <h2 class="mb-4"><i class="fas fa-lock me-2"></i> Sécurité du compte</h2>

                    <form id="security-form">
                        <div class="mb-4">
                            <h5>Changer le mot de passe</h5>
                            <div class="mb-3">
                                <label class="form-label">Mot de passe actuel</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="current-password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nouveau mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="new-password" required>
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
                                    <input type="password" class="form-control" id="confirm-password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
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