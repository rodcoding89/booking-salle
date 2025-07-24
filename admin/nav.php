<?php
    require_once dirname(__DIR__).'/inc/init.php';
    if (!estAdmin()) {
        header('location:'.RACINE_SITE.'sign-in');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo RACINE_SITE . 'inc/styles/backoffice.css' ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="backoffice">
        <ul class="nav nav-tabs d-flex justify-content-center">
            <li><a class="nav-link" href="<?php echo RACINE_SITE.'admin'; ?>">Gestion des membres</a></li>
            <li><a class="nav-link" href="<?php echo RACINE_SITE.'admin/rooms'; ?>">Gestion des salles</a></li>
            <!--<li><a class="nav-link" href="gestion-produits.php">Gestion des produits</a></li>-->
            <li><a class="nav-link" href="<?php echo RACINE_SITE.'admin/orders'; ?>">Gestion des commandes</a></li>
            <!--<li><a class="nav-link" href="gestion-avis.php">Gestion des avis</a></li>-->
            <li><a class="nav-link" href="<?php echo RACINE_SITE.'admin/statistic'; ?>">Statistique</a></li>
        </ul>
    