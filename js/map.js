/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

function initMap(lat,long,adresse,map){
    var map = L.map(map).setView([lat, long], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    var marker = L.marker([lat, long]).addTo(map);
    marker.bindPopup("<b>"+adresse+"</b>.").openPopup();
}

if(document.getElementById("map")){
    // Utiliser Nominatim pour convertir l'adresse en coordonnées
    var address = "1600 Pennsylvania Ave NW, Washington DC";
    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
    .then(response => response.json())
    .then(data => {
        if (data.length > 0) {
            var lat = parseFloat(data[0].lat);
            var lon = parseFloat(data[0].lon);

            initMap(lat,lon,address,"map");
        } else {
            console.error("Adresse non trouvée");
        }
    })
    .catch(error => {
        console.error("Erreur lors de la conversion de l'adresse en coordonnées :", error);
    });
}

if(document.getElementById("map1")){
    // Utiliser Nominatim pour convertir l'adresse en coordonnées
    var address = "1600 Pennsylvania Ave NW, Washington DC";
    const adresse = document.getElementById("cadresse").value;
    //console.log("adresse",adresse);
    //alert(adresse);
    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
    .then(response => response.json())
    .then(data => {
        if (data.length > 0) {
            var lat = parseFloat(data[0].lat);
            var lon = parseFloat(data[0].lon);

            initMap(lat,lon,adresse,"map1");
        } else {
            console.error("Adresse non trouvée");
        }
    })
    .catch(error => {
        console.error("Erreur lors de la conversion de l'adresse en coordonnées :", error);
    });
}
