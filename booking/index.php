<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
 require_once dirname(__DIR__) . '/inc/init.php';

 require_once dirname(__DIR__) . '/inc/header.php';
 
 $roomId = $_GET['roomId'];
 $error = "";

 function GeneredEndHour($givinHour,$start,$limit,$type,$startDate){
    //echo $givinHour;
    $options = '';
    $left = '';
    $defaultStartDateHour = 0;
    $nowDay = explode("-",date("Y-m-d"))[2];
    $startDay = explode("-",$startDate)[2];
    echo $nowDay.' ';
    echo $startDay. ' ';
    if ($givinHour) {
        $left = (int)explode(':',$givinHour)[0];
        $right = explode(':',$givinHour)[1];
    }
    if ($type == "start") {
        $realStart = $left + 1;
        $realLimit = !empty($left) ? $startDay > $nowDay ? $realStart + 23 - $left - 4 : abs($left - 15) : $limit;
    } else {
        $realStart = !empty($left)
         ? (
            abs($nowDay - $startDay) > 1 || $left < 17
            ? $left + 2 
            : (17 - 3)
        )
        : 17;
        $realLimit = !empty($left)
        ? (
            abs($nowDay - $startDay) > 1
                ? $limit
                : (
                    $left < 17
                        ? $limit
                        : (17 - abs(17 - $left))
                )
        )
        : 14;

    }
    
    $hour = (int)$realStart;
    //$currentHour = date("h");
    echo "realStart ".$realStart ." ";
    echo "realLimit ".$realLimit .", ";
    for ($i=0; $i < $realLimit; $i++) {
        //echo 'before '.$hour .' index='.$i.', ';
        if ($type == "start") {
            if($hour == 24){
                $hour = 0;
            }
            if ($i%2 == 0) {
                $hour = $hour < 10 ? '0'.$hour : $hour;
                $options .= '<option value="'.$hour.':00'.'">'.$hour.':00'.'</option>';
            }else{
                $options .= '<option value="'.$hour.':30'.'">'.$hour.':30'.'</option>';
                $hour = $hour + 1; 
            }
            
        } else {
            if (!empty($givinHour)) {
            //echo 'test left'.$left;
                if (abs($nowDay - $startDay) > 1 || $left < 17) {
                    //echo 'test1';
                    if ($hour == $left || $hour == $left - 1 || $hour == $left - 2) {
                    } else {
                        if($hour == 24){
                            $hour = 0;
                        }
                        if ($i%2 == 0) {
                            $hour = $hour < 10 ? '0'.$hour : $hour;
                            $options .= '<option value="'.$hour.':00'.'">'.$hour.':00'.'</option>';
                        }else{
                            $options .= '<option value="'.$hour.':30'.'">'.$hour.':30'.'</option>';
                            $hour = $hour + 1; 
                        }
                    }
                    
                } else if($hour < $left - 1) {
                    echo 'test '.$hour.', ';
                    if ($i%2 == 0) {
                        $hour = $hour < 10 ? '0'.$hour : $hour;
                        $options .= '<option value="'.$hour.':00'.'">'.$hour.':00'.'</option>';
                    }else{
                        $options .= '<option value="'.$hour.':30'.'">'.$hour.':30'.'</option>';
                        $hour = $hour + 1; 
                    }
                }
            } else {
                if ($i%2 == 0) {
                    $hour = $hour < 10 ? '0'.$hour : $hour;
                    $options .= '<option value="'.$hour.':00'.'">'.$hour.':00'.'</option>';
                }else{
                    $options .= '<option value="'.$hour.':30'.'">'.$hour.':30'.'</option>';
                    $hour = $hour + 1; 
                }
            }
            
        }
        
        //echo 'after '.$hour;
    }
    return $options;
 }
 
 
 $result = selectQuery("SELECT s.*, c.date_fin,c.heure_fin,c.date_debut,c.heure_debut FROM salle s LEFT JOIN commande c ON c.id_salle = s.id_salle WHERE s.id_salle= :roomId",array(
    "roomId"=>$roomId
 ));
 $data = $result->fetchAll(PDO::FETCH_ASSOC)[0];

 if (isset($_GET['error'])) {
    $error = "<div class='alert alert-danger'>Une erreur est survenu lors de la suavegarde de votre commande.</div>";
 }
 //GeneredEndHour(date("H:m"),0,46,'start',$data['date_debut']);
 $statusClass = checkRoomAvailability($data['date_fin'],$data['heure_fin'],$data['date_debut'],$data['heure_debut']) ? 'booked' : 'available';
 $statusText = checkRoomAvailability($data['date_fin'],$data['heure_fin'],$data['date_debut'],$data['heure_debut']) ? 'Réservée' : 'Disponible';
$statusBadgeClass = checkRoomAvailability($data['date_fin'],$data['heure_fin'],$data['date_debut'],$data['heure_debut']) ? 'bg-danger' : 'bg-success';
?>
<div id="booking" class="booking-container">
    <div id="toasBooking" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body"></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
    <?php echo $error; ?>
    <div class="row align-items-start justify-content-center">
        <!-- Sidebar Informative -->
        <div class="col-lg-4 col-md-5 info-sidebar">
            <div class="text-center mb-5">
                <h3><i class="fas fa-calendar-plus me-2"></i> Nouvelle Réservation</h3>
                <p class="lead">Réservez votre espace en quelques clics</p>
            </div>

            <div class="card room-card mb-4">
                <img src="<?php echo $data['photo']; ?>" 
                     class="card-img-top roomBookingImg"
                     alt="Salle de réunion">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $data['titre']; ?></h5>
                    <p class="card-text"><?php echo ucfirst($data['ville']); ?>, <?php echo $data['cp']; ?></p>

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

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <input type="hidden" value="<?php echo $data['prix']; ?>" id="saleDayPrice">
                            <span class="price-highlight"><?php echo $data['prix']; ?>€</span>
                            <span class="text-muted">/ jour</span>
                        </div>
                        <span class="badge <?php echo $statusBadgeClass; ?>"><?php echo $statusText; ?></span>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center w-100 my-4">
                <div class="d-flex flex-wrap justify-content-center align-items-center gap-2" style="max-width: 400px;">
                    <div id="printBookingRoom" class="btn btn-outline-light"><i class="fas fa-print me-1"></i>Imprimer</div>
                    <div id="shareBookingRoom" class="btn btn-outline-light"><i class="fas fa-share me-1"></i>Partager</div>
                    <div class="text-center">
                        <a href="<?php echo RACINE_SITE ?>" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-1"></i> Choisir une autre salle
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire de réservation -->
        <div class="col-lg-6 col-md-7 booking-form">
            <h2 class="mb-4">Formulaire de Réservation</h2>
            <p class="mb-4">Remplissez les informations nécessaires pour finaliser votre réservation.</p>

            <form id="reservation-form" method="POST" action="<?php echo RACINE_SITE . 'inc/orders.php'; ?>">
                <input type="hidden" name="id_salle" value="<?php echo $roomId; ?>">
                <input type="hidden" name="caracteristic" value="<?php echo $data['caracteristic']; ?>">
                <input type="hidden" name="adresse" value="<?php echo $data["rue"].', '.$data['ville'].' '.$data['cp'].' '.$data['pays']; ?>">
                <input type="hidden" name="photo" value="<?php echo $data['photo']; ?>">
                <input type="hidden" name="titre" value="<?php echo $data['titre']; ?>">
                <input type="hidden" name="capacite" value="<?php echo $data['capacite']; ?>">
                <?php
                    if (isset($_SESSION['membre']) && isset($_SESSION['membre']['id_membre'])) {
                        ?>
                            <input type="hidden" name="id_membre" value="<?php echo $_SESSION['membre']['id_membre']; ?>">
                        <?php
                    }
                ?>
                <div class="mb-4">
                    <h4 class="mb-3">1. Période de réservation</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date d'arrivée</label>
                            <input type="date" min="<?php echo date('Y-m-d'); ?>" max="<?php 
                                    $currentDate = date('Y-m-d');
                                    $formatedDate = '';
                                    if(!empty($data['date_debut'])){
                                        $newDate = date_create($data['date_debut']);
                                        $subDate = date_sub($newDate,date_interval_create_from_date_string("2 days"));
                                        $formatedDate = date_format($subDate,"Y-m-d");
                                    }
                                    $minDate = (!empty($formatedDate) && strtotime($formatedDate) >= time()) 
                                              ? $formatedDate 
                                              : $currentDate;
                                    echo htmlspecialchars($minDate);
                               ?>" value="<?php echo date('Y-m-d'); ?>" class="form-control" id="endDate" required name="date_debut">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Heure d'arrivée</label>
                            <select class="form-select" id="endTime" required name="heure_debut">
                                <option value="default">Sélectionner</option>
                                <?php echo GeneredEndHour(date("H:m"),0,26,'start',$data['date_debut']) ?>
                                <!--<option value="00:00">00:00</option>
                                <option value="00:30">00:30</option>
                                <option value="01:00">01:00</option>
                                <option value="01:30">01:30</option>
                                <option value="02:00">02:00</option>
                                <option value="02:30">02:30</option>
                                <option value="03:00">03:00</option>
                                <option value="03:30">03:30</option>
                                <option value="04:00">04:00</option>
                                <option value="04:30">04:30</option>
                                <option value="05:00">05:00</option>
                                <option value="05:30">05:30</option>
                                <option value="06:00">06:00</option>
                                <option value="06:30">06:30</option>
                                <option value="07:00">07:00</option>
                                <option value="07:30">07:30</option>
                                <option value="08:00">08:00</option>
                                <option value="08:30">08:30</option>
                                <option value="09:00">09:00</option>
                                <option value="09:30">09:30</option>
                                <option value="10:00">10:00</option>
                                <option value="10:30">10:30</option>
                                <option value="11:00">11:00</option>
                                <option value="11:30">11:30</option>
                                <option value="12:00">12:00</option>
                                <option value="12:30">12:30</option>-->
                                <!-- Ajoutez d'autres options selon les besoins -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date de départ</label>
                            <input type="date" 
                               max="<?php 
                                    $currentDate = date('Y-m-d');
                                    $formatedDate = '';
                                    if(!empty($data['date_debut'])){
                                        $newDate = date_create($data['date_debut']);
                                        $subDate = date_sub($newDate,date_interval_create_from_date_string("1 days"));
                                        $formatedDate = date_format($subDate,"Y-m-d");
                                    }
                                    $minDate = (!empty($formatedDate) && strtotime($formatedDate) >= time()) 
                                              ? $formatedDate 
                                              : $currentDate;
                                    echo htmlspecialchars($minDate);
                               ?>"
                               min="<?php echo date('Y-m-d'); ?>" 
                               value="<?php 
                                    $defaultValue = (!empty($formatedDate) && strtotime($formatedDate) >= time()) 
                                                  ? $formatedDate 
                                                  : $currentDate;
                                    echo htmlspecialchars($defaultValue);
                               ?>" 
                               class="form-control" 
                               id="startDate" 
                               required 
                               name="date_fin">
                               <input type="hidden" id="initialEndDate" value="<?php 
                                    $defaultValue = (!empty($data['date_debut']) && strtotime($data['date_debut']) >= time()) 
                                                  ? $data['date_debut'] 
                                                  : $currentDate;
                                    echo htmlspecialchars($defaultValue);
                               ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Heure de départ</label>
                            <select class="form-select" id="startTime" required name="heure_fin">
                                <option value="default">Sélectionner</option>
                                <?php echo GeneredEndHour($data["heure_debut"],0,40,'end',$data['date_debut']) ?>
                            </select>
                        </div>
                        <div id="blocDate"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="mb-3">2. Options supplémentaires</h4>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="option-traiteur" name="option-traiteur">
                        <input type="hidden" value="35" id="traiteur" name="traiteur-value">
                        <label class="form-check-label" for="option-traiteur">
                            Service traiteur (+35€)
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="option-parking" name="option-parking" >
                        <input type="hidden" value="15" id="parking" name="parking-value">
                        <label class="form-check-label" for="option-parking">
                            Stationnement privé (+15€)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="option-materiel" name="option-materiel">
                        <input type="hidden" value="25" id="materiel" name="materiel-value">
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
                                <span id="dayHourPrice"></span>
                            </div>
                            <div class="sub"></div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Prix Total</span>
                                <span id="ttprice"></span>
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
                            <p>Vous n'êtes pas connecté. Afin de faire une reservation, veuillez vous connecter ou créer un compte.</p>
                            <a class="btn btn-primary btn-lg" href="<?php echo RACINE_SITE.'sign-in'; ?>"><i class="fas fa-user me-2"></i>Connexion</a>
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

