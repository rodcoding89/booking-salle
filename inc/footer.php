<?php 
    require_once 'init.php';
?>
    </main>
    <footer id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Contactez-nous</h5>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Rue des Salles, 75000 Paris</p>
                    <p><i class="fas fa-phone"></i> +33 1 23 45 67 89</p>
                    <p><i class="fas fa-envelope"></i> contact@stwich.com</p>
                </div>
                <div class="col-md-4">
                    <h5>Horaires</h5>
                    <p>Lundi - Vendredi: 9h - 18h</p>
                    <p>Samedi: 10h - 15h</p>
                    <p>Dimanche: Fermé</p>
                </div>
                <div class="col-md-4">
                    <h5>Newsletter</h5>
                    <form id="contactForm">
                        <div class="mb-2">
                            <input type="email" class="form-control" placeholder="Votre email" required>
                        </div>
                        <div class="mb-2">
                            <textarea class="form-control" rows="3" placeholder="Votre message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-outline-light">Envoyer</button>
                    </form>
                </div>
            </div>
            <hr class="bg-light">
            <div class="text-center">
                <p>&copy; 2023 Stwich. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script>
        const RACINE = "<?php echo RACINE_SITE; ?>";
        const  node_env = "<?php echo NODE_ENV; ?>";
    </script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- NoUI Slider pour les curseurs de plage -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.js"></script>
    <script src="<?php echo RACINE_SITE.'js/header.js' ?>"></script>
    <script src="<?php echo RACINE_SITE.'js/auth.js' ?>"></script>
    <script src="<?php echo RACINE_SITE.'js/booking.js' ?>"></script>
    <script src="<?php echo RACINE_SITE.'js/sale-list.js' ?>"></script>
    <script src="<?php echo RACINE_SITE.'js/map.js' ?>"></script>
    <script src="<?php echo RACINE_SITE.'js/profil.js' ?>"></script>
</body>
</html>