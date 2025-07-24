<?php
    require_once dirname(__DIR__) . '/inc/init.php';

    require_once dirname(__DIR__) . '/inc/header.php';

    if(!isset($_SESSION['confirmation'])){
        Header("Location:".RACINE_SITE);
    }
    function create_date($dateString) {
        return new DateTime($dateString);
    }
    $data = $_SESSION['confirmation'];
    $dateDebut=date_create($data['dateDebut']);
    $dateDebutFormated = date_format($dateDebut,"j F, Y");

    $dateFin=date_create($data['dateFin']);
    $dateFinFormated = date_format($dateFin,"j F, Y");
?>
<div class="confirmation-container">
    <input type="hidden" value="<?php echo $data['adresse']; ?>" id="cadresse">
    <div class="row align-items-center justify-content-center">
        <!-- Sidebar Informative -->
        <div class="col-lg-6 col-md-12 confirmation-sidebar">
            <div class="text-center mb-5">
                <div class="checkmark-circle">
                    <i class="fas fa-check text-white" style="font-size: 2.5rem;"></i>
                </div>
                <h3>Réservation confirmée !</h3>
                <p class="lead">Votre espace est réservé avec succès</p>
            </div>

            <div class="d-flex flex-wrap justify-content-around align-items-center gap-2 w-100">
                <div class="card bg-transparent border-light mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Référence</h5>
                        <p class="h4"><?php echo $data['commandeRef']; ?></p>
                        
                        <div class="timeline mt-4">
                            <div class="timeline-item">
                                <h6>Réservation effectuée</h6>
                                <small class="text-muted"><?php echo date("F j, Y, g:i"); ?></small>
                            </div>
                            <div class="timeline-item">
                                <h6>Confirmation envoyée</h6>
                                <small class="text-muted"><?php echo date("F j, Y, g:i"); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-light me-2 mb-2" id="cPrint">
                        <i class="fas fa-print me-1"></i> Imprimer
                    </button>
                    <button class="btn btn-light mb-2" id="cShare">
                        <i class="fas fa-share-alt me-1"></i> Partager
                    </button>
                    <!--<button class="btn btn-outline-light">
                        <i class="fas fa-calendar-plus me-1"></i> Ajouter au calendrier
                    </button>-->
                </div>
            </div>
        </div>
        
        <!-- Contenu principal -->
        <div class="col-12 confirmation-content">
            <div class="confirmation-header">
                <h2>Merci, <?php echo $data['name']; ?> !</h2>
                <p class="lead">Voici les détails de votre réservation</p>
            </div>
            
            <div class="card confirmation-card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <h4><?php echo $data['titre']; ?></h4>
                            <p><i class="fas fa-map-marker-alt me-2"></i> <?php echo $data['adresse']; ?></p>
                            
                            <div class="d-flex flex-wrap mb-3">
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
                            
                            <h5 class="mt-4">Votre réservation</h5>
                            <p><i class="fas fa-calendar-day me-2"></i> DU <strong><?php echo $dateDebutFormated; ?></strong><span><i class="fas fa-clock ms-3 me-1" style="font-size:.7rem;"></i> <strong><?php echo $data['heureDebut']; ?></strong></span></p>
                            <p><i class="fas fa-calendar-day me-2"></i> AU <strong><?php echo $dateFinFormated; ?></strong><span><i class="fas fa-clock ms-3 me-1" style="font-size:.7rem;"></i> <strong><?php echo $data['heureFin']; ?></strong></span></p>
                        </div>
                        <div class="col-md-6">
                            <div class="ratio ratio-16x9">
                                <img src="https://images.unsplash.com/photo-1568219656418-15c329312bf1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                                     class="rounded" 
                                     alt="Salle de réunion">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Plan d'accès</h5>
                            <div class="mb-3 d-flex justify-content-start align-items-start gap-2">
                                <div style="max-width: 50%; min-width: 280px; width: 100%;">
                                <!-- Intégration Google Maps -->
                                    <div id="map1" class="" style="width: 100%; height: 400px;">
                                        
                                    </div>
                                     <button class="btn btn-outline-primary mt-2">
                                        <i class="fas fa-directions me-1"></i> Itinéraire
                                    </button>
                                </div>
                                <div class="" style="max-width: 50%; min-width: 280px; width: 100%;">
                                    <p><i class="fas fa-building me-2"></i> <strong>Immeuble Les Horizons</strong></p>
                                    <p><i class="fas fa-map-marker-alt me-2"></i> <?php echo $data['adresse']; ?>"</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                <a href="<?php echo RACINE_SITE; ?>" class="btn btn-outline-secondary me-md-2">
                    <i class="fas fa-home me-1"></i> Retour à l'accueil
                </a>
                <a href="<?php echo RACINE_SITE . 'profil'; ?>" class="btn btn-primary">
                    <i class="fas fa-calendar-check me-1"></i> Voir mes réservations
                </a>
            </div>
        </div>
    </div>
</div>

<?php
    require_once dirname(__DIR__) . '/inc/footer.php'; 

