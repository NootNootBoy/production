<div class="col-xl-4 col-lg-6 col-md-6">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-start">
                <div class="d-flex align-items-start">
                    <div class="avatar me-3">
                        <img src="../../assets/img/icons/brands/social-label.png" alt="Avatar" class="rounded-circle" />
                    </div>
                    <div class="me-2">
                        <h5 class="mb-1"><a>Projet numéro :
                                <?php echo htmlspecialchars($projet['id_projet']) ?></a></h5>
                        <div class="client-info d-flex align-items-center">
                            <h6 class="mb-0 me-1">Client:</h6>
                            <span><?php echo htmlspecialchars($projet['nom_projet']) ?></span>
                        </div>
                    </div>
                </div>
                <div class="ms-auto">
                    <div class="dropdown zindex-2">
                        <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="javascript:void(0);">Renommer le projet</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Voir en détail</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item text-danger" href="javascript:void(0);">Archiver le projet</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center flex-wrap">
                <div class="bg-lighter p-2 rounded me-auto mb-3">
                    <span>Forfait :</span>
                    <h6 class="mb-1"><?php echo $projet['offre_prix_mensuel']; ?> €</h6>
                </div>
                <div class="text-end mb-3">
                    <h6 class="mb-1">Démarrage : <span class="text-body fw-normal"><?php $dateSignature = new DateTime($projet['client_date_signature']);
                        echo $dateSignature->format('d F Y'); ?> </span></h6>
                    <h6 class="mb-1">Deadline : <span class="text-body fw-normal"><?php $dateAcceptation = new DateTime($projet['mission_date_acceptation']);
                        echo $dateAcceptation->format('d F Y'); ?></span></h6>
                </div>
            </div>
            <p class="mb-0"><?php echo htmlspecialchars($projet['desc_projet']) ?></p>
        </div>
        <div class="card-body border-top">
            <div class="d-flex align-items-center mb-3">
                <h6 class="mb-1">Temps restant :</h6>
                <?php 
                
                $dateAcceptation = new DateTime($projet['mission_date_acceptation']);
                $dateFin = clone $dateAcceptation;
                $dateFin->add(new DateInterval('P45D')); // Ajoute 45 jours à la date d'acceptation
                
                $dateActuelle = new DateTime();
                
                $interval = $dateActuelle->diff($dateFin);
                $joursRestants = $interval->format('%a');
                
                ?>
                <span class="badge bg-label-success ms-auto"><?php if ($joursRestants == 1) {
                    echo $joursRestants . ' jour restant';
                } else {
                    echo $joursRestants . ' jours restants';
                }; ?></span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <small>Tâches:
                    <?php echo $projet['taches_completees']; ?>/<?php echo $projet['total_taches']; ?></small>
                <small><?php echo $projet['mission_progression']; ?>% terminé</small>
            </div>
            <?php 
                $progression = $projet['mission_progression']; // Assurez-vous de remplacer ceci par la variable appropriée

                $couleur = 'darkred';
                if ($progression >= 85) {
                    $couleur = 'green';
                } elseif ($progression >= 60) {
                    $couleur = 'palegreen';
                } elseif ($progression >= 20) {
                    $couleur = 'orange';
                }
            ?>
            <div class="progress mb-3" style="height: 8px">
                <div class="progress-bar" role="progressbar"
                    style="width: <?php echo $progression; ?>%; background-color: <?php echo $couleur; ?>"
                    aria-valuenow="<?php echo $progression; ?>" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center">
                    <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                        <?php
                    $stmt2 = $pdo->prepare("SELECT avatar, nom FROM users WHERE id = ?");
                    $stmt2->execute([$projet['client_commercial_id']]);
                    $commercial = $stmt2->fetch(PDO::FETCH_ASSOC);
                    
                    $stmt2->execute([$projet['id_user_developpeur']]);
                    $idDevAvatar = $stmt2->fetch(PDO::FETCH_ASSOC);

                    $stmt2->execute([$projet['id_user_assistant']]);
                    $idAssistant = $stmt2->fetch(PDO::FETCH_ASSOC);
                    
                    if ($commercial && isset($commercial['avatar'])) {
                    ?>

                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            class="avatar avatar-xs pull-up" title="<?php echo htmlspecialchars($commercial['nom']) ?>">
                            <img src="<?php echo htmlspecialchars($commercial['avatar']) ?>" alt="Avatar"
                                class="rounded-circle" />
                        </li>

                        <?php
                    } else {
                        echo $commercial['nom'];
                    }
                    ?>
                        <?php 

                    if ($idDevAvatar && isset($idDevAvatar['avatar'])) {
                        ?>

                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            class="avatar avatar-xs pull-up"
                            title="<?php echo htmlspecialchars($idDevAvatar['nom']) ?>">
                            <img src="<?php echo htmlspecialchars($idDevAvatar['avatar']) ?>" alt="Avatar"
                                class="rounded-circle" />
                        </li>

                        <?php
                        } else {
                            echo $idDevAvatar['nom'];
                        }
                        ?>
                        <?php 

                        if ($idAssistant && isset($idAssistant['avatar'])) {
                            ?>

                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            class="avatar avatar-xs pull-up"
                            title="<?php echo htmlspecialchars($idAssistant['nom']) ?>">
                            <img src="<?php echo htmlspecialchars($idAssistant['avatar']) ?>" alt="Avatar"
                                class="rounded-circle" />
                        </li>

                        <?php
                            } else {
                                echo $idAssistant['nom'];
                            }
                            ?>
                        <small>3 membres</small>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>