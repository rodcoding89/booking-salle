<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
 require_once dirname(__DIR__) . '/inc/init.php';

 require_once dirname(__DIR__) . '/inc/header.php';
?>
<div id="booking" class="booking-container">
    <div class="row align-items-start justify-content-center">
        <!-- Sidebar Informative -->
        <div class="col-lg-4 col-md-5 info-sidebar">
            <div class="text-center mb-5">
                <h3><i class="fas fa-calendar-plus me-2"></i> Nouvelle Réservation</h3>
                <p class="lead">Réservez votre espace en quelques clics</p>
            </div>

            <div class="card room-card mb-4">
                <img src="https://images.unsplash.com/photo-1568219656418-15c329312bf1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     class="card-img-top" 
                     alt="Salle de réunion">
                <div class="card-body">
                    <h5 class="card-title">Salle de Réunion Lumineuse</h5>
                    <p class="card-text">Paris, 15ème arrondissement</p>

                    <div class="d-flex flex-wrap mb-3">
                        <span class="badge equipment-badge"><i class="fas fa-users me-1"></i> 12 personnes</span>
                        <span class="badge equipment-badge"><i class="fas fa-wifi me-1"></i> WiFi</span>
                        <span class="badge equipment-badge"><i class="fas fa-tv me-1"></i> Écran</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <input type="hidden" value="120" id="saleDayPrice">
                            <span class="price-highlight">120€</span>
                            <span class="text-muted">/ jour</span>
                        </div>
                        <span class="badge bg-success">Disponible</span>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="<?php echo RACINE_SITE ?>" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-1"></i> Choisir une autre salle
                </a>
            </div>
        </div>

        <!-- Formulaire de réservation -->
        <div class="col-lg-6 col-md-7 booking-form">
            <h2 class="mb-4">Formulaire de Réservation</h2>
            <p class="mb-4">Remplissez les informations nécessaires pour finaliser votre réservation.</p>

            <form id="reservation-form">
                <div class="mb-4">
                    <h4 class="mb-3">1. Période de réservation</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date d'arrivée</label>
                            <input type="date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" class="form-control" id="endDate" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Heure d'arrivée</label>
                            <select class="form-select" id="endTime" required>
                                <option value="default">Sélectionner</option>
                                <option value="08:00">08:00</option>
                                <option value="09:00">09:00</option>
                                <option value="10:00">10:00</option>
                                <!-- Ajoutez d'autres options selon les besoins -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date de départ</label>
                            <input type="date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" class="form-control" id="startDate" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Heure de départ</label>
                            <select class="form-select" id="startTime" required>
                                <option value="default">Sélectionner</option>
                                <option value="17:00">17:00</option>
                                <option value="18:00">18:00</option>
                                <option value="19:00">19:00</option>
                                <!-- Ajoutez d'autres options selon les besoins -->
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="mb-3">2. Options supplémentaires</h4>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="option-traiteur">
                        <input type="hidden" value="35" id="traiteur">
                        <label class="form-check-label" for="option-traiteur">
                            Service traiteur (+35€)
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="option-parking">
                        <input type="hidden" value="15" id="parking">
                        <label class="form-check-label" for="option-parking">
                            Stationnement privé (+15€)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="option-materiel">
                        <input type="hidden" value="25" id="materiel">
                        <label class="form-check-label" for="option-materiel">
                            Matériel audiovisuel supplémentaire (+25€)
                        </label>
                    </div>
                </div>
                <div class="mb-4">
                    <h4 class="mb-3">4. Récapitulatif</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span id="days"></span>
                                <span>120€</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 text-muted">
                                <span>Service traiteur</span>
                                <span>+35€</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 text-muted">
                                <span>Stationnement</span>
                                <span>+15€</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total estimé</span>
                                <span>170€</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="conditions" required>
                    <label class="form-check-label" for="conditions">
                        J'accepte les <a href="#">conditions générales</a> et la <a href="#">politique de confidentialité</a>
                    </label>
                </div>
                <?php 
                    if(estConnecte()){
                        ?>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-calendar-check me-2"></i> Confirmer la réservation
                            </button>
                        </div>
                    <?php
                    }else{
                        ?>
                        <div class="d-grid gap-2">
                            <p>Vous n'êtes pas connecté, afin de faire une reservation, veuillez vous connecter ou créer un compte.</p>
                            <a href="<?php echo RACINE_SITE.'sign-in'; ?>">Coonexion</a>
                        </div>
                    <?php
                    }
                ?>
            </form>
        </div>
    </div>
</div>

<?php
    require_once dirname(__DIR__) . '/inc/footer.php';

