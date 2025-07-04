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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- NoUI Slider pour les curseurs de plage -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.js"></script>
    <script src="<?php echo RACINE_SITE.'js/header.js' ?>"></script>
    <script>
        // Données des salles (simulées)
        const roomsData = [
            {
                id: 1,
                title: "Salle de Réunion Lumineuse",
                description: "Salle spacieuse avec vue sur la ville, idéale pour les réunions d'équipe.",
                image: "https://images.unsplash.com/photo-1568219656418-15c329312bf1?ixlib=rb-4.0.3",
                city: "paris",
                category: "reunion",
                capacity: 12,
                price: 120,
                available: true
            },
            {
                id: 2,
                title: "Bureau Privé Moderne",
                description: "Bureau calme et bien équipé pour le travail en solo ou à deux.",
                image: "https://images.unsplash.com/photo-1524758631624-e2822e304c36?ixlib=rb-4.0.3",
                city: "lyon",
                category: "bureau",
                capacity: 2,
                price: 80,
                available: true
            },
            {
                id: 3,
                title: "Espace Formation Professionnel",
                description: "Grande salle équipée pour les sessions de formation avec tableau interactif.",
                image: "https://images.unsplash.com/photo-1593642632823-8f785ba67e45?ixlib=rb-4.0.3",
                city: "marseille",
                category: "formation",
                capacity: 25,
                price: 250,
                available: false
            },
            {
                id: 4,
                title: "Salle de Conférence Élégante",
                description: "Salle prestigieuse pour les conférences et réunions importantes.",
                image: "https://images.unsplash.com/photo-1571624436279-b272aff752b5?ixlib=rb-4.0.3",
                city: "paris",
                category: "reunion",
                capacity: 30,
                price: 350,
                available: true
            },
            {
                id: 5,
                title: "Bureau Coworking",
                description: "Espace de travail partagé avec accès à toutes les commodités.",
                image: "https://images.unsplash.com/photo-1497366811353-6870744d04b2?ixlib=rb-4.0.3",
                city: "toulouse",
                category: "bureau",
                capacity: 1,
                price: 50,
                available: true
            },
            {
                id: 6,
                title: "Atelier Créatif",
                description: "Espace lumineux pour les sessions de brainstorming et ateliers créatifs.",
                image: "https://images.unsplash.com/photo-1505373877841-8d25f7d46678?ixlib=rb-4.0.3",
                city: "bordeaux",
                category: "formation",
                capacity: 15,
                price: 180,
                available: true
            },
            {
                id: 7,
                title: "Salle de Réunion Intime",
                description: "Petite salle conviviale pour les réunions en petit comité.",
                image: "https://images.unsplash.com/photo-1552581234-26160f608093?ixlib=rb-4.0.3",
                city: "lyon",
                category: "reunion",
                capacity: 6,
                price: 90,
                available: false
            },
            {
                id: 8,
                title: "Espace Formation Technologique",
                description: "Salle équipée d'ordinateurs et de matériel high-tech pour les formations IT.",
                image: "https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3",
                city: "paris",
                category: "formation",
                capacity: 20,
                price: 300,
                available: true
            }
        ];

        // Initialisation des curseurs de plage
        document.addEventListener('DOMContentLoaded', function() {
            // Curseur pour la capacité
            const capacitySlider = document.getElementById('capacityRange');
            noUiSlider.create(capacitySlider, {
                start: [1, 50],
                connect: true,
                range: {
                    'min': 1,
                    'max': 50
                },
                step: 1
            });
            
            capacitySlider.noUiSlider.on('update', function(values, handle) {
                document.getElementById('capacityMin').value = Math.round(values[0]);
                document.getElementById('capacityMax').value = Math.round(values[1]);
                document.getElementById('capacityValue').textContent = `${Math.round(values[0])}-${Math.round(values[1])}`;
            });
            
            // Curseur pour le prix
            const priceSlider = document.getElementById('priceRange');
            noUiSlider.create(priceSlider, {
                start: [0, 500],
                connect: true,
                range: {
                    'min': 0,
                    'max': 500
                },
                step: 10
            });
            
            priceSlider.noUiSlider.on('update', function(values, handle) {
                document.getElementById('priceMin').value = Math.round(values[0]);
                document.getElementById('priceMax').value = Math.round(values[1]);
                document.getElementById('priceValue').textContent = `${Math.round(values[0])}-${Math.round(values[1])}€`;
            });
            
            // Charger les salles initiales
            displayRooms(roomsData);
            
            // Gestion des filtres
            document.getElementById('applyFilters').addEventListener('click', applyFilters);
            document.getElementById('resetFilters').addEventListener('click', resetFilters);
        });
        
        // Appliquer les filtres
        function applyFilters() {
            const city = document.getElementById('city').value;
            const categories = [];
            if (document.getElementById('category-office').checked) categories.push('bureau');
            if (document.getElementById('category-meeting').checked) categories.push('reunion');
            if (document.getElementById('category-training').checked) categories.push('formation');
            
            const capacityMin = parseInt(document.getElementById('capacityMin').value);
            const capacityMax = parseInt(document.getElementById('capacityMax').value);
            const priceMin = parseInt(document.getElementById('priceMin').value);
            const priceMax = parseInt(document.getElementById('priceMax').value);
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            const filteredRooms = roomsData.filter(room => {
                // Filtre par ville
                if (city && room.city !== city) return false;
                
                // Filtre par catégorie
                if (categories.length > 0 && !categories.includes(room.category)) return false;
                
                // Filtre par capacité
                if (room.capacity < capacityMin || room.capacity > capacityMax) return false;
                
                // Filtre par prix
                if (room.price < priceMin || room.price > priceMax) return false;
                
                // Les filtres de date seraient normalement vérifiés contre les réservations existantes
                // Pour cette démo, nous ne les utilisons pas pour filtrer les salles
                
                return true;
            });
            
            displayRooms(filteredRooms);
        }
        
        // Réinitialiser les filtres
        function resetFilters() {
            document.getElementById('city').value = '';
            document.getElementById('category-office').checked = true;
            document.getElementById('category-meeting').checked = true;
            document.getElementById('category-training').checked = true;
            
            // Réinitialiser les curseurs
            const capacitySlider = document.getElementById('capacityRange');
            capacitySlider.noUiSlider.set([1, 50]);
            
            const priceSlider = document.getElementById('priceRange');
            priceSlider.noUiSlider.set([0, 500]);
            
            document.getElementById('startDate').value = '';
            document.getElementById('endDate').value = '';
            
            // Afficher toutes les salles
            displayRooms(roomsData);
        }
        
        // Afficher les salles
        function displayRooms(rooms) {
            const container = document.getElementById('rooms-container');
            container.innerHTML = '';
            
            if (rooms.length === 0) {
                container.innerHTML = '<div class="col-12 text-center py-5"><h4>Aucune salle ne correspond à vos critères de recherche</h4></div>';
                return;
            }
            
            rooms.forEach(room => {
                const statusClass = room.available ? 'available' : 'booked';
                const statusText = room.available ? 'Disponible' : 'Réservée';
                const statusBadgeClass = room.available ? 'bg-success' : 'bg-danger';
                
                // Traduire la catégorie
                let categoryText = '';
                switch(room.category) {
                    case 'bureau': categoryText = 'Bureau'; break;
                    case 'reunion': categoryText = 'Réunion'; break;
                    case 'formation': categoryText = 'Formation'; break;
                }
    
                // Traduire la ville
                let cityText = '';
                switch(room.city) {
                    case 'paris': cityText = 'Paris'; break;
                    case 'lyon': cityText = 'Lyon'; break;
                    case 'marseille': cityText = 'Marseille'; break;
                    case 'toulouse': cityText = 'Toulouse'; break;
                    case 'bordeaux': cityText = 'Bordeaux'; break;
                    case 'nante': cityText = 'Nante'; break;
                    case 'monpellier': cityText = 'Monpellier'; break;
                    case 'strasbourg': cityText = 'Strasbourg'; break;
                    case 'lille': cityText = 'Lille'; break;
                    case 'nice': cityText = 'Nice'; break;
                }
                
                const roomCard = document.createElement('div');
                roomCard.className = 'col-md-6 col-lg-4 pb-4';
                roomCard.innerHTML = `
                    <div class="card room-card ${statusClass} h-100">
                        <span class="badge ${statusBadgeClass} status-badge">${statusText}</span>
                        <img src="${room.image}" class="card-img-top room-img" alt="${room.title}">
                        <div class="card-body">
                            <h5 class="card-title">${room.title}</h5>
                            <p class="card-text">${room.description}</p>
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item"><i class="fas fa-city"></i> ${cityText}</li>
                                <li class="list-group-item"><i class="fas fa-tag"></i> ${categoryText}</li>
                                <li class="list-group-item"><i class="fas fa-users"></i> Capacité: ${room.capacity} personnes</li>
                                <li class="list-group-item"><span class="price-highlight">${room.price}€</span> / jour</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent">
                            ${room.available 
                                ? '<button class="btn btn-primary w-100">Réserver</button>' 
                                : '<button class="btn btn-outline-secondary w-100">Voir plus</button>'}
                        </div>
                    </div>
                `;
                
                container.appendChild(roomCard);
            });
        }
    </script>
</body>
</html>