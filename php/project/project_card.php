<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-start">
            <div class="d-flex align-items-start">
                <div class="avatar me-3">
                    <img src="../../assets/img/icons/brands/social-label.png" alt="Avatar" class="rounded-circle" />
                </div>
                <div class="me-2">
                    <h5 class="mb-1"><a href="javascript:;" class="h5 stretched-link">Projet numéro :
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
                <h6 class="mb-1"><?php     echo $projet['offre_prix']; ?> </h6>
            </div>
            <div class="text-end mb-3">
                <h6 class="mb-1">Date de démarrage: <span class="text-body fw-normal"></span></h6>
                <h6 class="mb-1">Deadline: <span class="text-body fw-normal">28/2/22</span></h6>
            </div>
        </div>
        <p class="mb-0">We are Consulting, Software Development and Web Development Services.</p>
    </div>
    <div class="card-body border-top">
        <div class="d-flex align-items-center mb-3">
            <h6 class="mb-1">All Hours: <span class="text-body fw-normal">380/244</span></h6>
            <span class="badge bg-label-success ms-auto">28 Days left</span>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-1">
            <small>Task: 290/344</small>
            <small>95% Completed</small>
        </div>
        <div class="progress mb-3" style="height: 8px">
            <div class="progress-bar" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0"
                aria-valuemax="100"></div>
        </div>
        <div class="d-flex align-items-center">
            <div class="d-flex align-items-center">
                <ul class="list-unstyled d-flex align-items-center avatar-group mb-0 zindex-2">
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                        title="Vinnie Mostowy" class="avatar avatar-sm pull-up">
                        <img class="rounded-circle" src="../../assets/img/avatars/5.png" alt="Avatar" />
                    </li>
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                        title="Allen Rieske" class="avatar avatar-sm pull-up">
                        <img class="rounded-circle" src="../../assets/img/avatars/12.png" alt="Avatar" />
                    </li>
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                        title="Julee Rossignol" class="avatar avatar-sm pull-up me-2">
                        <img class="rounded-circle" src="../../assets/img/avatars/6.png" alt="Avatar" />
                    </li>
                    <li><small class="text-muted">280 Members</small></li>
                </ul>
            </div>
            <div class="ms-auto">
                <a href="javascript:void(0);" class="text-body"><i class="bx bx-chat"></i> 15</a>
            </div>
        </div>
    </div>
</div>