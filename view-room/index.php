<?php 
	require_once dirname(__DIR__) . '/inc/init.php';
	require_once dirname(__DIR__) . '/inc/header.php';
    $roomId = $_GET['roomId'];
     $result = selectQuery("SELECT s.*,c.heure_fin,c.heure_debut,c.date_debut,c.date_fin FROM salle s INNER JOIN commande c ON c.id_salle = s.id_salle WHERE s.id_salle = :roomId",array(
        "roomId"=>$roomId
    ));

    $data = $result->fetchAll(PDO::FETCH_ASSOC)[0];
    //debuging($data);

    function create_date($dateString) {
        return new DateTime($dateString);
    }

    $dateDebut=date_create($data['date_debut']);
    $dateDebutFormated = date_format($dateDebut,"j F, Y");

    $dateFin=date_create($data['date_fin']);
    $dateFinFormated = date_format($dateFin,"j F, Y");
    $link = explode("#", $data['photo']);
    $url = '';
    if (isset($link[1]) && $link[1] == 'img') {
        $url = RACINE_SITE. $link[0];
    } else {
        $url = $link[0];
    }
?>

<div class="detail-container">
    <div id="toasView" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body"></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
    <div class="row align-items-start justify-content-center">
        <!-- Détail de la réservation -->
        <div class="col-12 detail-content">
            <div class="detail-header">
                <div class="d-flex justify-content-between align-items-center position-relative">
                    <div>
                        <h2><?php echo $data['titre']; ?></h2>
                        <p class="lead mb-0"><i class="fas fa-map-marker-alt me-2"></i> <?php echo $data['rue'] .', '. $data['ville'] .' '.$data['cp'].' '.$data['pays']; ?></p>
                    </div>
                    <span class="<?php echo "badge status-badge ". ($data['etat'] ? "bg-success" : "bg-danger"); ?>"><?php echo $data['etat'] ? 'Disponible' : 'Actuellement reservée'; ?></span>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-lg-6 col-md-12 mb-4">
                    <img src="<?php echo $url; ?>" alt="<?php echo $data['titre']; ?>" class="roomImg">
                    <div class="d-flex justify-content-center align-items-center w-100 my-4">
                        <div class="d-flex flex-wrap justify-content-center align-items-center gap-2" style="max-width: 400px;">
                            <div id="printUnAvailableRoom" class="btn btn-outline-info"><i class="fas fa-print me-1"></i>Imprimer</div>
                            <div id="shareUnAvailableRoom" class="btn btn-outline-info"><i class="fas fa-share me-1"></i>Partager</div>
                            <div class="text-center">
                                <a href="<?php echo RACINE_SITE ?>" class="btn btn-outline-info">
                                    <i class="fas fa-arrow-left me-1"></i> Selectionner une autre salle
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Description</h5>
                            <p class="card-text"><?php echo $data['description']; ?></p>
                            
                            <h5 class="mt-4">Caractéristiques</h5>
                            <div class="d-flex flex-wrap">
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
                            
                            <div class="mt-4">
                                <h5>Details de réservation</h5>
                                <p><i class="fas fa-calendar-day me-2"></i> Du <strong><?php echo $dateDebutFormated; ?></strong><i class="fas fa-clock ms-2 me-1" style="font-size: 13px;"></i>A <strong><?php echo $data["heure_debut"] ?></strong></p>
                                <p><i class="fas fa-calendar-day me-2"></i> Au <strong><?php echo $dateFinFormated; ?></strong><i class="fas fa-clock ms-2 me-1" style="font-size: 13px;"></i>A <strong><?php echo $data["heure_fin"] ?></strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
	require_once dirname(__DIR__) . '/inc/footer.php';