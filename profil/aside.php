<!-- Sidebar Profil -->
<?php 
    $result = selectQuery("SELECT * FROM membre WHERE id_membre =:id_membre",array(
            "id_membre" => $_SESSION['membre']['id_membre']
    ));
    $user = $result->fetch(PDO::FETCH_ASSOC);
?>
<div class="col-lg-3 col-md-4 info-sidebar" id="aside">
    <div class="text-center mb-4">
        <div class="top mx-auto mb-3">
            <span><?php echo isset($user) ? substr($user['prenom'],0,1) . substr($user['nom'],0,1) : '';  ?></span>
        </div>
        <h3 id="profile-name"><?php echo isset($user) ? $user['nom']. ' '.$user['prenom'] : '' ?></h3>
        <p class="mb-0"><i class="fas fa-envelope me-2"></i> <span id="profile-email"><?php echo $user['email'] ?></span></p>
        <p><i class="fas fa-user-tag me-2"></i> <span id="profile-status"><?php echo $user['statut'] == 0 ? 'Membre Standard' : 'Administrateur'; ?></span></p>
    </div>

    <ul class="profilNav nav nav-pills flex-column mb-4">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo RACINE_SITE. 'profil' ?>">
                <i class="fas fa-user me-2"></i> Mon Profil
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo RACINE_SITE. 'profil/booking' ?>">
                <i class="fas fa-calendar-check me-2"></i> Mes Réservations
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo RACINE_SITE. 'profil/security' ?>">
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
