<?php
    require_once 'inc/init.php';
    $page = isset($_POST['page']) && is_numeric($_POST['page']) ? (int)$_POST['page'] : 1;

    require_once 'inc/header.php';
?>
<div class="position-relative mb-4 img">
    <img src="https://images.unsplash.com/photo-1556760544-74068565f05c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" 
         alt="Salle de réunion moderne" 
         class="banner w-100" 
         style="aspect-ratio: 9/3.5; object-fit: cover;">

    <div class="banner-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" 
         style="background-color: rgba(0, 0, 0, 0.4);">
        <h1 class="text-white display-4 fw-bold text-center px-3" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
            Trouvez la salle parfaite<br>pour vos besoins
        </h1>
    </div>
</div>

<div id="bookingSale" class="container my-4 catalogue">
    <div class="row">
        <!-- Section de Filtres -->
        <div class="col-lg-3">
            <div class="filter-section sticky-top" style="top: 20px;">
                <h4>Filtrer les salles</h4>

                <div class="mb-3">
                    <label for="city" class="form-label">Ville</label>
                    <select class="form-select" id="city">
                        <option value="">Toutes les villes</option>
                        <option value="paris">Paris</option>
                        <option value="lyon">Lyon</option>
                        <option value="marseille">Marseille</option>
                        <option value="toulouse">Toulouse</option>
                        <option value="nice">Nice</option>
                        <option value="bordeaux">Bordeaux</option>
                        <option value="nante">Nante</option>
                        <option value="monpellier">Monpellier</option>
                        <option value="strasbourg">Strasbourg</option>
                        <option value="lille">Lille</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Catégorie</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="bureau" id="category-office" checked>
                        <label class="form-check-label" for="category-office">
                            Bureau
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="reunion" id="category-meeting" checked>
                        <label class="form-check-label" for="category-meeting">
                            Réunion
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="formation" id="category-training" checked>
                        <label class="form-check-label" for="category-training">
                            Formation
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="capacityRange" class="form-label">Capacité: <span id="capacityValue" class="slider-value">1-50</span></label>
                    <div id="capacityRange" class="range-slider"></div>
                    <div class="d-flex justify-content-between">
                        <span>1</span>
                        <span>50</span>
                    </div>
                    <input type="hidden" id="capacityMin" value="1">
                    <input type="hidden" id="capacityMax" value="50">
                </div>

                <div class="mb-3">
                    <label for="priceRange" class="form-label">Prix (€): <span id="priceValue" class="slider-value">0-500</span></label>
                    <div id="priceRange" class="range-slider"></div>
                    <div class="d-flex justify-content-between">
                        <span>0€</span>
                        <span>500€</span>
                    </div>
                    <input type="hidden" id="priceMin" value="0">
                    <input type="hidden" id="priceMax" value="500">
                </div>

                <!--<div class="mb-3">
                    <label for="startDate" class="form-label">Date de début</label>
                    <input type="date" class="form-control" id="startDate">
                </div>

                <div class="mb-3">
                    <label for="endDate" class="form-label">Date de fin</label>
                    <input type="date" class="form-control" id="endDate">
                </div>-->

                <button id="applyFilters" class="btn btn-primary w-100">Appliquer</button>
                <button id="resetFilters" class="btn btn-outline-secondary w-100 mt-2">Réinitialiser</button>
            </div>
        </div>

        <!-- Section des Salles -->
        <div class="col-lg-9">
            <div class="row" id="rooms-container">
                <!-- Les salles seront chargées ici dynamiquement -->
            </div>
            <!-- Pagination -->
            <div id="pagination" class="pagination">
            </div>
        </div>
    </div>
</div>




<?php
require_once 'inc/footer.php';