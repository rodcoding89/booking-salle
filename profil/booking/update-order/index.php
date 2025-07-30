<?php 
    require_once dirname(dirname(dirname(__DIR__))) . '../inc/init.php';
    require_once dirname(dirname(dirname(__DIR__))) . '../inc/header.php';
    $commande;
    $orderId = $_GET['orderId'];
    $result = executeRequete("SELECT * FROM commande WHERE id_commande =:orderId",array(
        "orderId" => $orderId
    ));
    $commande = $result->fetchAll(PDO::FETCH_ASSOC)[0];

    //debuging($commande);

    $endDateTime = DateTime::createFromFormat('Y-m-d H:i', $commande['date_fin'] . ' ' . $commande['heure_fin']);
    $now = new DateTime();
    if ($endDateTime < $now ) {
        $message = "Commande expiré veuillez faire une nouvelle reservation";
    } else {
        $message = "";
    }
    
    //debuging($commande);
?>
<div class="container">
    <div class="row align-items-center justify-content-center">
        <?php require_once dirname(__DIR__).'/../aside.php'; ?>
        <?php 
            if(!empty($message)){
                echo "<div class='col-lg-7 col-md-8 form-container' style='height:350px; background-color:#ccc;display:flex;justify-content:center;align-items:center;'>".$message."</div>";
            }else{
                ?>
                    <div class="col-lg-7 col-md-8 form-container">
                        <h2 class="mb-4 text-center"><i class="fas fa-edit me-2"></i>Mise à jour de commande <?php echo htmlspecialchars($commande['commande_ref']); ?></h2>
                        
                        <form action="update_commande.php" method="post">
                            <!-- Champ caché pour l'ID de la commande -->
                            <input type="hidden" value="<?php echo $commande['prix_journalier']; ?>" id="saleDayPrice">
                            <input type="hidden" name="id_commande" value="<?php echo $commande['id_commande']; ?>">
                            
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="nb_jours_reserve" class="form-label">Nombre de jours</label>
                                    <input type="number" class="form-control" id="nb_jours_reserve" name="nb_jours_reserve" 
                                           value="<?php echo $commande['nb_jours_reserve']; ?>" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="prix_total" class="form-label">Prix total (€)</label>
                                    <input type="number" step="0.01" class="form-control" id="prix_total" name="prix_total" 
                                           value="<?php echo $commande['prix_total']; ?>" readonly>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Dates et heures</label>
                                <div class="date-time-group">
                                    <div class="form-group">
                                        <label for="date_debut" class="form-label">Date début</label>
                                        <input type="date" min="<?php echo date("Y-m-d"); ?>" class="form-control" id="date_debut" name="date_debut" 
                                               value="<?php echo $commande['date_debut']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="heure_debut" class="form-label">Heure début</label>
                                        <input type="time" class="form-control" id="heure_debut" name="heure_debut" 
                                               value="<?php echo $commande['heure_debut']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="date_fin" class="form-label">Date fin</label>
                                        <input type="date" min="<?php echo date("Y-m-d"); ?>" class="form-control" id="date_fin" name="date_fin" 
                                               value="<?php echo $commande['date_fin']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="heure_fin" class="form-label">Heure fin</label>
                                        <input type="time" class="form-control" id="heure_fin" name="heure_fin" 
                                               value="<?php echo $commande['heure_fin']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h4 class="mb-3">2. Options supplémentaires</h4>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="option-traiteur" name="option-traiteur" <?php echo strpos($commande["other_option"], "35") != false ? 'checked' : '' ?>>
                                    <input type="hidden" value="35" id="traiteur" name="traiteur-value">
                                    <label class="form-check-label" for="option-traiteur">
                                        Service traiteur (+35€)
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="option-parking" name="option-parking" <?php echo strpos($commande["other_option"], "15") != false ? 'checked' : '' ?>>
                                    <input type="hidden" value="15" id="parking" name="parking-value">
                                    <label class="form-check-label" for="option-parking">
                                        Stationnement privé (+15€)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="option-materiel" name="option-materiel" <?php echo strpos($commande["other_option"], "25") != false ? 'checked' : '' ?>>
                                    <input type="hidden" value="25" id="materiel" name="materiel-value">
                                    <label class="form-check-label" for="option-materiel">
                                        Matériel audiovisuel supplémentaire (+25€)
                                    </label>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-outline-secondary me-md-2">
                                    <i class="fas fa-undo me-1"></i> Réinitialiser
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Mettre à jour
                                </button>
                            </div>
                        </form>
                    </div>
                <?php
            }
        ?>
    </div>
</div>
<?php
    require_once dirname(dirname(dirname(__DIR__))) . '../inc/footer.php';