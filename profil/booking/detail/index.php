<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

    require_once dirname(dirname(dirname(__DIR__))) . '../inc/init.php';

    if (!estConnecte()) {
        header('location:'. RACINE_SITE.'sign-in');
    }

    require_once dirname(dirname(dirname(__DIR__))) . '../inc/header.php';
    function create_date($dateString) {
        return new DateTime($dateString);
    }
    $user = $_SESSION['membre'];
    $orderId = $_GET['orderId'];
    $resultat = executeRequete("SELECT c.*, s.*,m.* FROM commande c INNER JOIN salle s ON c.id_salle = s.id_salle INNER JOIN membre m ON m.id_membre = c.id_membre WHERE c.id_commande = :orderId",array(':orderId' => $orderId));

    $data = $resultat->fetch(PDO::FETCH_ASSOC);
    $dateDebut=date_create($data['date_debut']);
    $dateDebutFormated = date_format($dateDebut,"j F, Y");

    $dateFin=date_create($data['date_fin']);
    $dateFinFormated = date_format($dateFin,"j F, Y");
    $link = explode("#", $data['photo']);
    $url = '';
    if (isset($link[1]) && $link[1] == 'img') {
        $url = RACINE_SITE. $link[0];
    } else {
        $url = $link[0];
    }
?>

<div class="detail-container">
    <div class="row align-items-start justify-content-center">
        <!-- Sidebar Informative -->
        <div class="col-lg-6 col-md-12 info-sidebar mb-3">
            <div class="text-center mb-5">
                <h3><i class="fas fa-calendar-check me-2"></i> Détails Réservation</h3>
                <p class="lead">Votre espace réservé vous attend</p>
            </div>

            <div class="card detail-card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Informations clés</h5>
                    <ul class="d-flex flex-wrap justify-content-between ps-0 align-item-center gap-2">
                        <li class="py-2 d-flex flex-column justify-content-between">
                            <span><i class="fas fa-calendar-day me-2"></i> Date</span>
                            <strong><?php echo $dateDebutFormated.' - '.$dateFinFormated; ?></strong>
                        </li>
                        <li class="py-2 d-flex flex-column justify-content-between">
                            <span><i class="fas fa-clock me-2"></i> Horaires</span>
                            <strong><?php echo $data['heure_debut'] .' - '.$data['heure_fin']; ?></strong>
                        </li>
                        <li class="py-2 d-flex flex-column justify-content-between">
                            <span><i class="fas fa-user me-2"></i> Réservé par</span>
                            <strong><?php echo $data['nom']. ' '. $data['prenom']; ?></strong>
                        </li>
                        <li class="py-2 d-flex flex-column justify-content-between">
                            <span><i class="fas fa-receipt me-2"></i> Référence</span>
                            <strong><?php echo $data['commande_ref']; ?></strong>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="text-center d-flex gap-2 justify-content-center align-item-center">
                <button class="btn btn-outline-light me-2" id="pPrint">
                    <i class="fas fa-print me-1"></i> Imprimer
                </button>
                <button class="btn btn-light" id="pShare">
                    <i class="fas fa-share-alt me-1"></i> Partager
                </button>
            </div>
        </div>

        <!-- Détail de la réservation -->
        <div class="col-lg-7 col-md-8 detail-content">
            <div class="detail-header">
                <div class="d-flex justify-content-between align-items-center position-relative">
                    <div>
                        <h2><?php echo $data['titre']; ?></h2>
                        <p class="lead mb-0"><i class="fas fa-map-marker-alt me-2"></i><?php echo $data['rue'] .', '.$data['ville'] .' '.$data['cp'] .' '.$data['pays']; ?></p>
                    </div>
                    <span class="<?php echo 'badge status-badge ' . ($data['commande_statut'] == 'bg-success' ? 'Confirmée' : ($data['commande_statut'] == 'pending' ? 'bg-warning' : ($data['commande_statut'] == 'cancelled' ? 'bg-primary' : 'bg-secondary'))) ?>"><?php echo ($data['commande_statut'] == 'confirmed' ? 'Confirmée' : ($data['commande_statut'] == 'pending' ? 'En ententte' : ($data['commande_statut'] == 'cancelled' ? 'Annulée' : 'Terminé'))) ?></span>
                </div>
            </div>

            <div class="row mb-4">
                <div class="w-100 d-flex justify-content-center mb-3">
                    <img class="booking-detail-img" src="<?php echo $url; ?>" alt="Salle de réunion">
                </div>

                <div class="col-md-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Description</h5>
                            <p class="card-text"><?php echo $data['description']; ?></p>

                            <h5 class="mt-4">Caractéristiques</h5>
                            <div class="d-flex flex-wrap">
                                <span class="badge equipment-badge"><i class="fas fa-users me-1"></i> <?php echo $data['capacite']; ?> personnes</span>
                                <?php
                                    $carac = explode(",", $data['caracteristic']);
                                    $html = '';
                                    foreach ($carac as $key => $value) {
                                        $html .= caracteristic($value);
                                    }
                                    echo $html;
                                ?>
                            </div>

                            <div class="mt-4">
                                <h5>Adresse</h5>
                                <p><?php echo $data['rue'] .', '.$data['ville'] .' <br> '.$data['cp'] .' '.$data['pays']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Plan d'accès</h5>
                            <div class="map-container" id="map">
                                <!-- Intégration Google Maps ou autre service -->
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-outline-primary">
                                    <i class="fas fa-directions me-1"></i> Itinéraire
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Récapitulatif</h5>
                            <ul class="list-group list-group-flush">
                                <?php 
                                    if(!empty($data['other_option'])){
                                        $lis = '';
                                        foreach (explode(',',$data['other_option']) as $key => $value) {
                                            $lis .= '<li class="list-group-item d-flex justify-content-start gap-2">';
                                            $newVal = explode('(',$value);
                                            $lis .= '<span>'.$newVal[0].'</span>';
                                            if(!empty($newVal[1])){
                                                $lis .= '<span>('.$newVal[1].'</span>';
                                            }
                                            $lis .= '</li>';
                                        }
                                        echo $lis; 
                                    }
                                ?>
                                <li class="list-group-item d-flex justify-content-start fw-bold gap-2">
                                    <span>Total</span>
                                    <span><?php echo $data['prix_total']; ?>€</span>
                                </li>
                            </ul>

                            <div class="mt-4">
                                <h5>Contact sur place</h5>
                                <p><i class="fas fa-user me-2"></i> Marie Dupont<br>
                                <i class="fas fa-phone me-2"></i> +33 1 23 45 67 89<br>
                                <i class="fas fa-envelope me-2"></i> contact@espacelyon.com</p>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <?php 
                                    if ($data['commande_statut'] == 'pending') {
                                        ?>
                                        <a href="<?php echo RACINE_SITE . '/profil/booking/update-order?orderId='.$data['id_commande']; ?>" class="btn btn-outline-primary">
                                            <i class="fas fa-edit me-1"></i> Modifier la réservation
                                        </a>
                                        <?php
                                    }
                                ?>
                                <?php 
                                    if($data['commande_statut'] == "pending" || $data['commande_statut'] == "confirmed"){
                                        ?>
                                         <form  method="POST" action="<?php echo RACINE_SITE . 'inc/reset_orders.php'; ?>">
                                            <input type="hidden" name="orderId" value="<?php echo $data['id_commande']; ?>">
                                             <button class="btn btn-danger">
                                                <i class="fas fa-times me-1"></i> Annuler la réservation
                                            </button>
                                         </form>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
require_once dirname(dirname(dirname(__DIR__))) . '../inc/footer.php';
