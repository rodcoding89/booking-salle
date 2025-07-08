/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */
function calculateTimeDifference(startDate, endDate) {

    // Calculate the difference in time (milliseconds)
    const timeDifference = endDate - startDate;

    // Calculate days, hours, and minutes
    const daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
    const hoursDifference = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutesDifference = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));

    return {
        days: daysDifference,
        hours: hoursDifference,
        minutes: minutesDifference
    };
}

function calculBookingPrice(startDateTime,endDateTime,dailyPrice){
    // Parse the start and end date-time strings into Date objects
    // Extraction des composants de la date/heure
    const [startYear, startMonth, startDay, startHours, startMinutes] = [
        parseInt(startDateTime.split('T')[0].split('-')[0], 10),  // Année (number)
        parseInt(startDateTime.split('T')[0].split('-')[1], 10) - 1,  // Mois (0-11)
        parseInt(startDateTime.split('T')[0].split('-')[2], 10),  // Jour (number)
        parseInt(startDateTime.split('T')[1].split(':')[0], 10),  // Heures (number)
        parseInt(startDateTime.split('T')[1].split(':')[1], 10),  // Minutes (number)
    ];

    const [endYear, endMonth, endDay, endHours, endMinutes] = [
        parseInt(endDateTime.split('T')[0].split('-')[0], 10),  // Année (number)
        parseInt(endDateTime.split('T')[0].split('-')[1], 10) - 1,  // Mois (0-11)
        parseInt(endDateTime.split('T')[0].split('-')[2], 10),  // Jour (number)
        parseInt(endDateTime.split('T')[1].split(':')[0], 10),  // Heures (number)
        parseInt(endDateTime.split('T')[1].split(':')[1], 10),  // Minutes (number)
    ];

    // Création des dates
    const startDate = new Date(startYear, startMonth, startDay, startHours, startMinutes);
    const endDate = new Date(endYear, endMonth, endDay, endHours, endMinutes);
    console.log("startDateTime",startDateTime,"endDateTime",endDateTime,"startDate",startDate,"endDate",endDate);
    // Calculate the difference in time (milliseconds)
    const timeDifference = endDate - startDate;

    // Convert the time difference from milliseconds to days
    const daysDifference = timeDifference / (1000 * 60 * 60 * 24);
    const dayHour = calculateTimeDifference(startDate,endDate);
    // Calculate the total price
    const totalPrice = daysDifference * dailyPrice;
    console.log("timeDifference",timeDifference,"daysDifference",daysDifference,"totalPrice",totalPrice);

    return {totalPrice,dayHour};
}

if(document.getElementById('booking')){
    // Calcul dynamique du prix total
    const traiteur = parseFloat(document.getElementById('traiteur').value);
    const parking = parseFloat(document.getElementById('parking').value);
    const materiel = parseFloat(document.getElementById('materiel').value);
    const saleDayPrice = parseFloat(document.getElementById('saleDayPrice').value);
    const daysEl = document.getElementById("days");
    //console.log("daysEl",daysEl);
    daysEl.textContent = 'Location de salle (1 Jour)';
    function updateTotalPrice() {
        let total = parseFloat(saleDayPrice); // Prix de base
        let dayHour;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        const startTime = document.getElementById('startTime').value;
        const endTime = document.getElementById('endTime').value;
        console.log(endDate,startDate);
        const startDateTime =  endDate+'T'+(endTime !== 'default' ? endTime : '00:00'); 
        const endDateTime =  startDate+'T'+(startTime !== 'default' ? startTime : '00:00');
        console.log(startDateTime,endDateTime);
        if(startDateTime && endDateTime){
            const result = calculBookingPrice(startDateTime,endDateTime,saleDayPrice);
            dayHour = result.dayHour;
            total = result.totalPrice > 0 ? parseFloat(result.totalPrice) : parseFloat(saleDayPrice);
        }
        console.log(dayHour);
        if(document.getElementById('option-traiteur').checked) {
            total += traiteur;
        }
        if(document.getElementById('option-parking').checked) {
            total += parking;
        }
        if(document.getElementById('option-materiel').checked) {
            total += materiel;
        }
        console.log("total",total);
        const updateDay = dayHour ? (dayHour.days > 0 ? '('+dayHour.days +' ' : '(') +(dayHour.hours > 0 ? dayHour.hours+'h)' : '1 Jour)')+ (dayHour.minutes > 0 ? +':'+dayHour.minutes+'m)' : '') : '(1 Jour)';
        // Mise à jour de l'affichage
        daysEl.textContent = 'Location de salle '+updateDay;
        document.querySelector('.card-body .fw-bold span:last-child').textContent = total + '€';
    }

    // Écouteurs pour les cases à cocher
    document.getElementById('option-traiteur').addEventListener('change', updateTotalPrice);
    document.getElementById('option-parking').addEventListener('change', updateTotalPrice);
    document.getElementById('option-materiel').addEventListener('change', updateTotalPrice);
    document.getElementById('startDate').addEventListener('change', updateTotalPrice);
    document.getElementById('endDate').addEventListener('change', updateTotalPrice);
    document.getElementById('startTime').addEventListener('change', updateTotalPrice);
    document.getElementById('endTime').addEventListener('change', updateTotalPrice);

    // Validation du formulaire
    document.getElementById('reservation-form').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Réservation confirmée avec succès!');
        // Ici vous ajouteriez la logique pour enregistrer la réservation
    });
}