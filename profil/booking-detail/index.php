<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

    require_once dirname(dirname(__DIR__)) . '/inc/init.php';

    if (!estConnecte()) {
        header('location:'. RACINE_SITE.'sign-in');
    }

    require_once dirname(dirname(__DIR__)) . '/inc/header.php';

?>

<div class="container-fluid detail-container">
    <div class="row align-items-start justify-content-center">
        <!-- Sidebar Informative -->
        <div class="col-lg-3 col-md-4 info-sidebar">
            <div class="text-center mb-5">
                <h3><i class="fas fa-calendar-check me-2"></i> Détails Réservation</h3>
                <p class="lead">Votre espace réservé vous attend</p>
            </div>

            <div class="card detail-card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Informations clés</h5>
                    <ul class="list-group list-group-flush">
                        <li class="py-2 d-flex flex-column justify-content-between">
                            <span><i class="fas fa-calendar-day me-2"></i> Date</span>
                            <strong>15 juin 2023</strong>
                        </li>
                        <li class="py-2 d-flex flex-column justify-content-between">
                            <span><i class="fas fa-clock me-2"></i> Horaires</span>
                            <strong>09:00 - 12:00</strong>
                        </li>
                        <li class="py-2 d-flex flex-column justify-content-between">
                            <span><i class="fas fa-user me-2"></i> Réservé par</span>
                            <strong>John Doe</strong>
                        </li>
                        <li class="py-2 d-flex flex-column justify-content-between">
                            <span><i class="fas fa-receipt me-2"></i> Référence</span>
                            <strong>RES-2023-1564</strong>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="text-center d-flex gap-2 justify-content-center align-item-center">
                <button class="btn btn-outline-light me-2">
                    <i class="fas fa-print me-1"></i> Imprimer
                </button>
                <button class="btn btn-light">
                    <i class="fas fa-share-alt me-1"></i> Partager
                </button>
            </div>
        </div>

        <!-- Détail de la réservation -->
        <div class="col-lg-7 col-md-8 detail-content">
            <div class="detail-header">
                <div class="d-flex justify-content-between align-items-center position-relative">
                    <div>
                        <h2>Salle de Réunion Lumineuse</h2>
                        <p class="lead mb-0"><i class="fas fa-map-marker-alt me-2"></i> Paris, 15ème arrondissement</p>
                    </div>
                    <span class="badge bg-success status-badge">Confirmée</span>
                </div>
            </div>

            <div class="row mb-4">
                <div class="w-100">
                    <img class="booking-detail-img" src="https://images.unsplash.com/photo-1568219656418-15c329312bf1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="d-block w-100" alt="Salle de réunion">
                </div>

                <div class="col-md-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Description</h5>
                            <p class="card-text">Salle spacieuse avec vue sur la ville, idéale pour les réunions d'équipe. Lumière naturelle abondante, ambiance calme et professionnelle.</p>

                            <h5 class="mt-4">Caractéristiques</h5>
                            <div class="d-flex flex-wrap">
                                <span class="badge equipment-badge"><i class="fas fa-users me-1"></i> 12 personnes</span>
                                <span class="badge equipment-badge"><i class="fas fa-wifi me-1"></i> WiFi haut débit</span>
                                <span class="badge equipment-badge"><i class="fas fa-tv me-1"></i> Écran 65"</span>
                                <span class="badge equipment-badge"><i class="fas fa-coffee me-1"></i> Machine à café</span>
                                <span class="badge equipment-badge"><i class="fas fa-parking me-1"></i> Parking</span>
                                <span class="badge equipment-badge"><i class="fas fa-utensils me-1"></i> Service traiteur</span>
                            </div>

                            <div class="mt-4">
                                <h5>Adresse</h5>
                                <p>123 Rue des Entrepreneurs<br>75015 Paris, France</p>
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
                                <img src="https://maps.googleapis.com/maps/api/staticmap?center=48.8566,2.3522&zoom=15&size=600x300&markers=color:red%7C48.8566,2.3522&key=YOUR_API_KEY" 
                                     alt="Carte de localisation" 
                                     class="w-100 h-100">
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
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Location (3 heures)</span>
                                    <span>120€</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Service traiteur (option)</span>
                                    <span>35€</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Stationnement (option)</span>
                                    <span>15€</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between fw-bold">
                                    <span>Total</span>
                                    <span>170€</span>
                                </li>
                            </ul>

                            <div class="mt-4">
                                <h5>Contact sur place</h5>
                                <p><i class="fas fa-user me-2"></i> Marie Dupont<br>
                                <i class="fas fa-phone me-2"></i> +33 1 23 45 67 89<br>
                                <i class="fas fa-envelope me-2"></i> contact@espacelyon.com</p>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button class="btn btn-danger">
                                    <i class="fas fa-times me-1"></i> Annuler la réservation
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="fas fa-edit me-1"></i> Modifier la réservation
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
require_once dirname(dirname(__DIR__)) . '/inc/footer.php';
