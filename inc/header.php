<?php 
    require_once 'init.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo RACINE_SITE . 'inc/styles/style.css' ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <style>
        
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand d-lg-block" href="<?php echo RACINE_SITE ?>">Stwich</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav navi">
                    <li class="nav-item catalogue">
                        <a class="nav-link" href="<?php echo RACINE_SITE ?>"><i class="fas fa-list"></i> Catalogue</a>
                    </li>
                    <li class="nav-item send-message">
                        <a class="nav-link" href="<?php echo RACINE_SITE . 'contact' ?>"><i class="fas fa-envelope"></i> Nous contacter</a>
                    </li>
                    <?php 
                        if (estAdmin()) {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link backoffice" href="<?php echo RACINE_SITE.'admin'; ?>"><i class="fas fa-cog me-1"></i>Backoffice</a>
                            </li>
                            <?php
                        }
                    ?>
                </ul>
            </div>
            
            <?php 
                if(!estConnecte()){
                    ?><ul class="navbar-nav d-lg-flex">
                        <li class="nav-item sign-in">
                            <a class="nav-link logIn" href="<?php echo RACINE_SITE . 'sign-in' ?>"><i class="fas fa-user"></i> Connexion</a>
                        </li>
                    </ul>

                    <div class="d-lg-none sign-in">
                        <a class="nav-link logIn" href="<?php echo RACINE_SITE . 'sign-in' ?>"><i class="fas fa-user"></i> Connexion</a>
                    </div>
                <?php
                }else{
                    ?><ul class="navbar-nav d-lg-flex">
                        <li class="nav-item sign-in">
                            <a class="nav-link proFil" href="<?php echo RACINE_SITE . 'profil' ?>"><i class="fas fa-user"></i> Profil</a>
                        </li>
                    </ul>

                    <div class="d-lg-none sign-in">
                        <a class="nav-link proFil" href="<?php echo RACINE_SITE . 'profil' ?>"><i class="fas fa-user"></i> Profil</a>
                    </div>
                <?php
                }
            ?>
        </div>
    </nav>
    <main>
    