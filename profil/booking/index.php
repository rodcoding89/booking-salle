<?php 
    require_once dirname(dirname(__DIR__)) . '/inc/init.php';
    function create_date($dateString) {
        return new DateTime($dateString);
    }
    function loadOrders($where){
        $resultat;
        if ($where == "all") {
            //echo "called all";
            $resultat = executeRequete(
            "SELECT c.*, s.* FROM commande c INNER JOIN salle s ON c.id_salle = s.id_salle WHERE c.id_membre = :id_membre",array(':id_membre' => $_SESSION['membre']['id_membre']));
        } else if($where == "pass") {
            //echo "called pass";
            $resultat = executeRequete(
            "SELECT c.*, s.* FROM commande c INNER JOIN salle s ON c.id_salle = s.id_salle WHERE c.id_membre = :id_membre AND c.commande_statut =:statut
            ",
                array(':id_membre' => $_SESSION['membre']['id_membre'],
                    ":statut" => "closed"
            ));
        }else{
            //echo "called futur";
            $resultat = executeRequete(
            "SELECT c.*, s.* FROM commande c INNER JOIN salle s ON c.id_salle = s.id_salle WHERE c.id_membre = :id_membre AND c.commande_statut =:statut",
                array(':id_membre' => $_SESSION['membre']['id_membre'],
                    ":statut" => "pending"
            ));
        }
        $result = selectQuery("SELECT * FROM membre WHERE id_membre =:id_membre",array(
                "id_membre" => $_SESSION['membre']['id_membre']
        ));
        $user = $result->fetch(PDO::FETCH_ASSOC);
        $contenu = '';
        while ($data = $resultat->fetch(PDO::FETCH_ASSOC)) {
            //debuging($data);
            $borderColor = $data['commande_statut'] == "confirmed" ? '#198754' : ($data['commande_statut'] == "cancelled" ? '#3a7bd5' : ($data['commande_statut'] == "pending" ? '#ffc107' : '#6c757d'));
            $contenu .= '<div class="list-group-item reservation-card mb-3" style="border-left: 4px solid ' . $borderColor . ';">';
                $contenu .= '<div class="d-flex justify-content-between"><div>';
            $contenu .= '<h5 class="mb-1">' . $data['titre'] . '</h5>';
            $contenu .= '<p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i>' . $data['ville'] . '</p>';
            $contenu .= '<small class="text-muted"><i class="fas fa-calendar-alt me-2"></i> ' . date_format(create_date($data['date_debut']), "j F, Y") . ' - ' . date_format(create_date($data['date_fin']), "j F, Y") . ' ' . $data['heure_debut'] . ' - ' . $data['heure_fin'] . '</small></div><div class="text-end">';
            $contenu .= '<span class="badge status-badge badg ' . ($data['commande_statut'] == "pending" ? "bg-warning" : ($data['commande_statut'] == "confirmed" ? "bg-success" : ($data['commande_statut'] == "cancelled" ? 'bg-primary' : "bg-secondary"))) . '">' . ($data['commande_statut'] == "pending" ? "En attente" : ($data['commande_statut'] == "confirmed" ? "Confirmée" : ($data['commande_statut'] == "cancelled" ? "Annuler" : "Terminé"))) . '</span>';
            $contenu .= '<p class="price-highlight mt-3">' . $data['prix_total'] . '€</p></div></div><div class="d-flex justify-content-end mt-2">';

            if ($data['commande_statut'] == "pending" || $data['commande_statut'] == "confirmed") {
                $contenu .= '<form method="POST" action= "'.RACINE_SITE . 'inc/reset_orders.php' .'"><input type="hidden" name="orderId" value="'.$data['id_commande'].'"><button type="submit" class="btn btn-outline-danger btn-sm me-2">Annuler</button></form><a href="' . RACINE_SITE . 'profil/booking/detail?orderId='.$data['id_commande'].'" class="btn btn-outline-primary btn-sm">Détails</a>';
            } else {
                $contenu .= '<a href="' . RACINE_SITE . 'profil/booking/detail?orderId='.$data["id_commande"].'" class="btn btn-outline-primary btn-sm">Détails</a>';
            }

            $contenu .= '</div></div>';

            //debug($commande);
        }
        return [
            "user"=>$user,
            "contenu" => $contenu
        ];
    }

    if(isset($_POST['filterAll'])){
        $data = loadOrders("all");
        $user = $data["user"];
        $contenu = $data["contenu"];
    }else if(isset($_POST['filterPass'])){
        $data = loadOrders("pass");
        $user = $data["user"];
        $contenu = $data["contenu"];
    }else if(isset($_POST['filterFutur'])){
        $data = loadOrders("futur");
        $user = $data["user"];
        $contenu = $data["contenu"];
    }else{
        $data = loadOrders("all");
        $user = $data["user"];
        $contenu = $data["contenu"];
    }
    require_once dirname(dirname(__DIR__)) . '/inc/header.php';
?>
<!-- Onglet Réservations -->
<div class="container-fluid">
    <div class="row align-items-center justify-content-center">
        <?php require_once dirname(__DIR__).'/aside.php'; ?>
        <div class="col-lg-7 col-md-8 profile-content">
            <div class="tab-pane">
                <h2 class="mb-4"><i class="fas fa-calendar-check me-2"></i> Mes Réservations</h2>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="btn-group">
                        <form action="" method="POST" class="me-2">
                            <button type="submit" name="filterAll" class="btn btn-outline-primary active">Toutes</button>
                        </form>

                        <form action="" method="POST">
                            <button type="submit" name="filterFutur" class="btn btn-outline-primary">À venir</button>
                        </form>

                        <form action="" method="POST" class="ms-2">
                            <button type="submit" name="filterPass" class="btn btn-outline-primary">Passées</button>
                        </form>
                    </div>
                    <a href="<?php echo RACINE_SITE; ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Nouvelle réservation
                    </a>
                </div>

                <div class="list-group">
                    <?php echo $contenu; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    require_once dirname(dirname(__DIR__)) . '/inc/footer.php';
