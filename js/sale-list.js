/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */


function checkRoomAvailability(endDate, endHour, startDate, startHour) {
    const nowStart = new Date();
    nowStart.setHours(7,30,0,0);
    const nowEnd = new Date();
    nowEnd.setHours(19,30,0,0);
    //console.log("endDate",endDate,"endHour",endHour,"startDate",startDate,"startHour",startHour);
    // 1. Vérification des paramètres obligatoires
    if (!endDate || !endHour || !startDate || !startHour) {
        return false;
    }

    // 2. Création des objets Date avec les heures
    const startD = new Date(startDate);
    const endD = new Date(endDate);
    
    // Configuration des heures/minutes
    const [startH, startM] = startHour.split(':').map(Number);
    const [endH, endM] = endHour.split(':').map(Number);
    
    startD.setHours(startH, startM, 0, 0);
    endD.setHours(endH, endM, 0, 0);

    //console.log("startD",startD,"endD",endD);

    // 3. Vérification que la date de début est au moins 1 jour dans le futur
    const oneDayInMs = 24 * 60 * 60 * 1000; // 1 jour en millisecondes

    const commandeStartWithBuffer = new Date(startD.getTime() - oneDayInMs);
    const commandeEndWithBuffer = new Date(endD.getTime() + oneDayInMs);

    //const timeUntilStart = Math.abs(startD.getTime() - now.getTime());
    //console.log("startD",startD.getTime(),"now",now.getTime())
    // 4. Vérification que la date de fin est après la date de début
    /*if (endD <= startD) {
        return false;
    }else{
        console.log("test")
        
        if (startD.getTime() >= now.getTime()) {
            if ((timeUntilStart / oneDayInMs) >= 1) {
                // Moins de 24h avant le début de la réservation
                return false;
            }else{
                console.log("test1","timeUntilStart",timeUntilStart,"oneDayInMs",oneDayInMs)
                return true
            }
        } else {
            if (endD.getTime() <= now.getTime()) {
                return false;
            } else {
                return true
            }
        }
    }*/
    const isOverlapping = nowStart <= commandeEndWithBuffer && nowEnd >= commandeStartWithBuffer;
    return isOverlapping;
}
if(document.getElementById("bookingSale")){
    // Données des salles (simulées)
    let roomsData = [];
    const pagination = $("#pagination");
    const url = new URL(window.location.href);
    const pSize = url.search ? url.search.split("=")[1] : 1;
    $.post(RACINE+'inc/controls.php',{"postType":"salleList",page:pSize},(res)=>{
        if(res.resultat){
            $("#pagination a").remove();
            console.log(pSize,url);
            const start = Math.max(1, pSize - 2);
            const end = Math.min(res.totalPages, pSize + 2);
            roomsData = res.resultat;
            let link = '';
            console.log("start",start, "end",end,res)
            for (let i = start; i <= end; i++) {
                link += `<a href="?page=${i}" ${i === parseInt(pSize) ? "class='active'" : ""}>${i}</a>`;
            }
            if (parseInt(pSize) < res.totalPages) {
                link += `<a href="?page=${parseInt(pSize) + 1}" class="noRounded">Suivant</a>`;
                link += `<a href="?page=${res.totalPages}" class="noRounded">Dernière &raquo;</a>`;
            }
            pagination.prepend(link);
            displayRooms(res.resultat,pSize);
        }
        console.log(res)
    },'json');

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
        //displayRooms(roomsData);

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
        //const startDate = document.getElementById('startDate').value;
        //const endDate = document.getElementById('endDate').value;

        const filterValue = {
            "postType":"salleListFilter",
            "city":city,
            "categorie":categories,
            "capaciteMin": capacityMin,
            "capaciteMax": capacityMax,
            "prixMin":priceMin,
            "prixMax":priceMax,
            page:pSize
        }

        $.post(RACINE+'inc/controls.php',filterValue,(res)=>{
            if(res.resultat){
                $("#pagination a").remove();
                console.log(pSize,url);
                const start = Math.max(1, pSize - 2);
                const end = Math.min(res.totalPages, pSize + 2);
                roomsData = res.resultat;
                let link = '';
                console.log("start",start, "end",end,res)
                for (let i = start; i <= end; i++) {
                    link += `<a href="?page=${i}" ${i === parseInt(pSize) ? "class='active'" : ""}>${i}</a>`;
                }
                if (parseInt(pSize) < res.totalPages) {
                    link += `<a href="?page=${parseInt(pSize) + 1}" class="noRounded">Suivant</a>`;
                    link += `<a href="?page=${res.totalPages}" class="noRounded">Dernière &raquo;</a>`;
                }
                pagination.prepend(link);
                displayRooms(res.resultat,pSize);
            }
            console.log(res)
        },'json');
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

        /*document.getElementById('startDate').value = '';
        document.getElementById('endDate').value = '';*/

        $.post(RACINE+'inc/controls.php',{"postType":"salleList",page:pSize},(res)=>{
            if(res.resultat){
                $("#pagination a").remove();
                console.log(pSize,url);
                const start = Math.max(1, pSize - 2);
                const end = Math.min(res.totalPages, pSize + 2);
                roomsData = res.resultat;
                let link = '';
                console.log("start",start, "end",end,res)
                for (let i = start; i <= end; i++) {
                    link += `<a href="?page=${i}" ${i === parseInt(pSize) ? "class='active'" : ""}>${i}</a>`;
                }
                if (parseInt(pSize) < res.totalPages) {
                    link += `<a href="?page=${parseInt(pSize) + 1}" class="noRounded">Suivant</a>`;
                    link += `<a href="?page=${res.totalPages}" class="noRounded">Dernière &raquo;</a>`;
                }
                pagination.prepend(link);
                displayRooms(res.resultat,pSize);
            }
            console.log(res)
        },'json');

        // Afficher toutes les salles
        displayRooms(roomsData,pSize);
    }

    // Afficher les salles
    function displayRooms(rooms,pageSize) {
        const container = document.getElementById('rooms-container');
        container.innerHTML = '';

        if (rooms.length === 0) {
            container.innerHTML = '<div class="col-12 text-center py-5 noroom"><h4>Aucune salle ne correspond à vos critères de recherche</h4></div>';
            return;
        }

        rooms.forEach(room => {
            console.log("checkRoomAvailability(room.date_debut)",checkRoomAvailability(room.date_fin,room.heure_fin,room.date_debut,room.heure_debut),room.titre)
            const statusClass = checkRoomAvailability(room.date_fin,room.heure_fin,room.date_debut,room.heure_debut) ? 'booked' : 'available';
            const statusText = checkRoomAvailability(room.date_fin,room.heure_fin,room.date_debut,room.heure_debut) ? 'Réservée' : 'Disponible';
            const statusBadgeClass = checkRoomAvailability(room.date_fin,room.heure_fin,room.date_debut,room.heure_debut) ? 'bg-danger' : 'bg-success';

            // Traduire la catégorie
            let categoryText = '';
            switch(room.categorie) {
                case 'bureau': categoryText = 'Bureau'; break;
                case 'reunion': categoryText = 'Réunion'; break;
                case 'formation': categoryText = 'Formation'; break;
            }

            // Traduire la ville
            let cityText = '';
            switch(room.ville) {
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
            let link = room.photo.split("#");
            let url = '';
            if (link[1] && link[1] === 'img') {
                url = RACINE + link[0];
            } else {
                url = link[0];
            }
            roomCard.className = 'col-md-6 col-lg-4 pb-4';
            roomCard.innerHTML = `
                <div class="card room-card ${statusClass} h-100">
                    <span class="badge ${statusBadgeClass} status-badge">${statusText}</span>
                    <img src="${url}" class="card-img-top room-img" alt="${room.titre}">
                    <div class="card-body">
                        <h5 class="card-title">${room.titre}</h5>
                        <p class="card-text">${room.description}</p>
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item"><i class="fas fa-city"></i> ${cityText}</li>
                            <li class="list-group-item"><i class="fas fa-tag"></i> ${categoryText}</li>
                            <li class="list-group-item"><i class="fas fa-users"></i> Capacité: ${room.capacite} personnes</li>
                            <li class="list-group-item"><span class="price-highlight">${room.prix}€</span> / jour</li>
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent">
                        ${!checkRoomAvailability(room.date_fin,room.heure_fin,room.date_debut,room.heure_debut)
                            ? '<a href="'+RACINE+'booking?roomId='+room.id_salle+'" class="btn btn-primary w-100">Réserver</a>' 
                            : '<a href="'+RACINE+'view-room?roomId='+room.id_salle+'" class="btn btn-outline-secondary w-100">Voir plus</a>'}
                    </div>
                </div>
            `;
            container.appendChild(roomCard);
        });
        const input = document.createElement("input");
        input.type = "hidden";
        input.id = "pageSize";
        input.value = pageSize;
        container.appendChild(input);
        $("#pagination .start").remove();
        $("#pagination .prev").remove();
        if (pageSize && pageSize > 1) {
            pagination.prepend('<a href="?page=1" class="noRounded start">&laquo; Première</a><a href="?page='+(pageSize - 1)+'" class="noRounded prev">Précédent</a>')
            
        }
    }
}

