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

    console.log("startDateTime",startDateTime,"endDateTime",endDateTime);

    if (!startDateTime || !endDateTime ) {
        return {totalPrice:0,dayHour:{days:0,hours:0,minutes:0}};
    }

    // Création des dates
    const startDate = new Date(startYear, startMonth, startDay, startHours, startMinutes);
    const endDate = new Date(endYear, endMonth, endDay, endHours, endMinutes);

    //console.log("startDate.getTime() >= endDate.getTime()",startDate.getTime() >= endDate.getTime(),"startDate",startDate,"endDate",endDate);
    $("#blocDate .dateErr").remove();
    if (startDate.getTime() >= endDate.getTime()) {
        //alert("date identique");
        
        const initialStartDate = document.getElementById("initialStartDate").value;
        const initialEndDate = document.getElementById("initialEndDate").value;
        console.log("initialStartDate",initialStartDate,"initialEndDate",initialEndDate)
        $("#blocDate").append('<div class="alert alert-danger dateErr">Vos dates ne respectent pas l\'ordre chronologique. Soit la date d\'arrivée est identique a celle de départ ou la date d\'arrivée est supérieur a celle de départ. Veuillez ajuster avant de continuer.</div>')

        return {totalPrice:0,dayHour:{days:0,hours:0,minutes:0}};
    }

    //console.log("startDateTime",startDateTime,"endDateTime",endDateTime,"startDate",startDate,"endDate",endDate);
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
    const dayPrice = document.getElementById("dayHourPrice");
    const ttprice = document.querySelector('#ttprice');
    dayPrice.textContent = saleDayPrice.toFixed(2) + '€';
    //console.log("daysEl",daysEl);
    daysEl.textContent = 'Location de salle (1 Jour)';
    ttprice.textContent = saleDayPrice.toFixed(2) + '€';
    $("#reservation-form").prepend("<input type='hidden' value='"+saleDayPrice.toFixed(2)+"' name='prix_total' class='totalPrice'>")
    $("#reservation-form").prepend("<input type='hidden' value='"+saleDayPrice.toFixed(2)+"' name='prix_journalier'>")
    function updateTotalPrice() {
        $("#reservation-form .totalPrice").remove()
        let total = parseFloat(saleDayPrice); // Prix de base
        let dayHour;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        const startTime = document.getElementById('startTime').value;
        const endTime = document.getElementById('endTime').value;
        const card = $('#reservation-form .card .card-body .sub');
        console.log(endDate,startDate);
        const startDateTime =  endDate+'T'+(endTime !== 'default' ? endTime : '00:00'); 
        const endDateTime =  startDate+'T'+(startTime !== 'default' ? startTime : '00:00');
        console.log(startDateTime,endDateTime);
        if(startDateTime && endDateTime){
            const result = calculBookingPrice(startDateTime,endDateTime,saleDayPrice);
            dayHour = result.dayHour;
            dayPrice.textContent = (result.totalPrice > 0 ? result.totalPrice : saleDayPrice).toFixed(2) + '€';
            total = result.totalPrice > 0 ? parseFloat(result.totalPrice) : parseFloat(saleDayPrice);
        }
        console.log(dayHour);
        if(document.getElementById('option-traiteur').checked) {
            total += traiteur;
            if(document.querySelector("#reservation-form .card .card-body .sub .traiteur") === null){
                card.append('<div class="traiteur d-flex justify-content-between mb-2 text-muted"><span>Service traiteur</span><span>+'+traiteur+'€</span></div>') 
            }
        }else{
            $('#reservation-form .card .card-body .sub .traiteur').remove();
        }
        if(document.getElementById('option-parking').checked) {
            total += parking;
            if(document.querySelector("#reservation-form .card .card-body .sub .parking") === null){
                card.append('<div class="parking d-flex justify-content-between mb-2 text-muted"><span>Stationnement</span><span>+'+parking+'€</span></div>') 
            }
        }else{
            $('#reservation-form .card .card-body .sub .parking').remove();
        }
        if(document.getElementById('option-materiel').checked) {
            total += materiel;
            if(document.querySelector("#reservation-form .card .card-body .sub .materiel") === null){
                card.append('<div class="materiel d-flex justify-content-between mb-2 text-muted"><span>Matériel audiovisuel</span><span>+'+materiel+'€</span></div>') 
            }
        }else{
            $('#reservation-form .card .card-body .sub .materiel').remove();
        }
        console.log("total",dayHour);
        const updateDay = dayHour ? (dayHour.days > 0 ? '('+dayHour.days +' Jour(s) ' : '(') +(dayHour.hours > 0 ? dayHour.hours+'h)' : '1 Jour)') + (dayHour.minutes > 0 ? (':' + dayHour.minutes + 'm') : '') : '(1 Jour)';
        // Mise à jour de l'affichage
        $("#reservation-form").prepend("<input type='hidden' value='"+updateDay+"' name='nb_jours_reserve' class='updateDay'>")
        daysEl.textContent = 'Location de salle '+updateDay;
        ttprice.textContent = total.toFixed(2) + '€';
        $("#reservation-form").prepend("<input type='hidden' value='"+total.toFixed(2)+"' name='prix_total' class='totalPrice'>")
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
    /*document.getElementById('reservation-form').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Réservation confirmée avec succès!');
        // Ici vous ajouteriez la logique pour enregistrer la réservation
    });*/
}

if(document.getElementById("printUnAvailableRoom")){
    document.getElementById("printUnAvailableRoom").addEventListener("click",function(){
        window.print();
    });

    document.getElementById("shareUnAvailableRoom").addEventListener("click", async function(){
        try{
            const text = `Visitez la salle a partir de ce lien - ${window.location.href}`;
            await navigator.clipboard.writeText(text);
            const toastElement = document.getElementById("toasView");
            document.querySelector("#toasView .toast-body").textContent = "Lien copié avec succès.";
            toastElement.classList.add("text-bg-success");
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }catch(error){
            const toastElement = document.getElementById("toasView");
            document.querySelector("#toasView .toast-body").textContent = "Echec lors de la copie du lien.";
            toastElement.classList.add("text-bg-danger");
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
            console.error(error);
        }
    });
}

if(document.getElementById("printBookingRoom")){
    document.getElementById("printBookingRoom").addEventListener("click",function(){
        window.print();
    });
    document.getElementById("shareBookingRoom").addEventListener("click", async function(){
        try{
            const text = `Visitez la salle a partir de ce lien - ${window.location.href}`;
            await navigator.clipboard.writeText(text);
            const toastElement = document.getElementById("toasBooking");
            document.querySelector("#toasBooking .toast-body").textContent = "Lien copié avec succès.";
            toastElement.classList.add("text-bg-success");
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }catch(error){
            const toastElement = document.getElementById("toasBooking");
            document.querySelector("#toasBooking .toast-body").textContent = "Echec lors de la copie du lien.";
            toastElement.classList.add("text-bg-danger");
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
            console.error(error);
        }
    });
}

if(document.getElementById("cShare")){
    document.getElementById("cPrint").addEventListener("click",function(){
        window.print();
    });
    document.getElementById("cShare").addEventListener("click", async function(){
        try{
            const text = `Visitez la salle a partir de ce lien - ${window.location.href}`;
            await navigator.clipboard.writeText(text);
            const toastElement = document.getElementById("toasBooking");
            document.querySelector("#toasBooking .toast-body").textContent = "Lien copié avec succès.";
            toastElement.classList.add("text-bg-success");
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }catch(error){
            const toastElement = document.getElementById("toasBooking");
            document.querySelector("#toasBooking .toast-body").textContent = "Echec lors de la copie du lien.";
            toastElement.classList.add("text-bg-danger");
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
            console.error(error);
        }
    });
}

if(document.getElementById("pShare")){
    document.getElementById("pPrint").addEventListener("click",function(){
        window.print();
    });
    document.getElementById("pShare").addEventListener("click", async function(){
        try{
            const text = `Visitez la salle a partir de ce lien - ${window.location.href}`;
            await navigator.clipboard.writeText(text);
            const toastElement = document.getElementById("toasBooking");
            document.querySelector("#toasBooking .toast-body").textContent = "Lien copié avec succès.";
            toastElement.classList.add("text-bg-success");
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }catch(error){
            const toastElement = document.getElementById("toasBooking");
            document.querySelector("#toasBooking .toast-body").textContent = "Echec lors de la copie du lien.";
            toastElement.classList.add("text-bg-danger");
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
            console.error(error);
        }
    });
}
if(document.getElementById('toggleCurrentPassword')){
    document.getElementById('toggleCurrentPassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('current-password');
        const icon = this.querySelector('i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
}

if(document.getElementById('toggleNewPassword')){
    document.getElementById('toggleNewPassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('new-password');
        const icon = this.querySelector('i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
}

if(document.getElementById('toggleConfirmPassword')){
    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('confirm-password');
        const icon = this.querySelector('i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
}