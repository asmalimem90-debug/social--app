<?php include __DIR__ . '/../../views/partials/header.php'; ?>

<h5 class="fw-bold mb-4"><i class="bi bi-person-plus me-2 text-primary"></i>Demandes d'amitié</h5>

<!-- Tabs -->
<ul class="nav nav-tabs mb-4" id="reqTabs" role="tablist">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-received">
            <i class="bi bi-inbox me-1"></i>Reçues
            <?php if (!empty($received)): ?>
                <span class="badge bg-danger ms-1"><?= count($received) ?></span>
            <?php endif; ?>
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-sent">
            <i class="bi bi-send me-1"></i>Envoyées
            <?php if (!empty($sent)): ?>
                <span class="badge bg-secondary ms-1"><?= count($sent) ?></span>
            <?php endif; ?>
        </button>
    </li>
</ul>

<div class="tab-content">

    <!-- Received requests -->
    <div class="tab-pane fade show active" id="tab-received">
        <?php if (empty($received)): ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                Aucune demande en attente.
            </div>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($received as $req): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center gap-3 p-3">
                            <a href="index.php?page=profile&id=<?= (int)$req['demandeur_id'] ?>">
                                <img src="<?= avatarUrl($req['image_demandeur'], $req['nom_demandeur']) ?>"
                                     class="avatar-md rounded-circle flex-shrink-0" alt="">
                            </a>
                            <div class="flex-grow-1 min-width-0">
                                <a href="index.php?page=profile&id=<?= (int)$req['demandeur_id'] ?>"
                                   class="fw-semibold text-dark text-decoration-none d-block text-truncate">
                                    <?= h($req['nom_demandeur']) ?>
                                </a>
                                <small class="text-muted"><?= timeAgo($req['dateCreation']) ?></small>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 d-flex gap-2 py-2 px-3">
                            <form method="post" action="index.php">
                                <input type="hidden" name="action"     value="accept-request">
                                <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                                <input type="hidden" name="request_id" value="<?= (int)$req['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="bi bi-check-lg me-1"></i>Accepter
                                </button>
                            </form>
                            <form method="post" action="index.php">
                                <input type="hidden" name="action"     value="reject-request">
                                <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                                <input type="hidden" name="request_id" value="<?= (int)$req['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-x-lg me-1"></i>Refuser
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Sent requests -->
    <div class="tab-pane fade" id="tab-sent">
        <?php if (empty($sent)): ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-send fs-1 d-block mb-2"></i>
                Vous n'avez envoyé aucune demande.
            </div>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($sent as $req): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center gap-3 p-3">
                            <a href="index.php?page=profile&id=<?= (int)$req['recepteur_id'] ?>">
                                <img src="<?= avatarUrl($req['image_recepteur'], $req['nom_recepteur']) ?>"
                                     class="avatar-md rounded-circle flex-shrink-0" alt="">
                            </a>
                            <div class="flex-grow-1 min-width-0">
                                <a href="index.php?page=profile&id=<?= (int)$req['recepteur_id'] ?>"
                                   class="fw-semibold text-dark text-decoration-none d-block text-truncate">
                                    <?= h($req['nom_recepteur']) ?>
                                </a>
                                <small class="text-muted"><?= timeAgo($req['dateCreation']) ?></small>
                                <span class="badge ms-1
                                    <?= $req['statut'] === 'EN_ATTENTE' ? 'bg-warning text-dark'
                                        : ($req['statut'] === 'ACCEPTEE' ? 'bg-success' : 'bg-danger') ?>">
                                    <?= h($req['statut']) ?>
                                </span>
                            </div>
                        </div>
                        <?php if ($req['statut'] === 'EN_ATTENTE'): ?>
                        <div class="card-footer bg-transparent border-0 py-2 px-3">
                            <form method="post" action="index.php">
                                <input type="hidden" name="action"     value="cancel-request">
                                <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                                <input type="hidden" name="request_id" value="<?= (int)$req['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-x me-1"></i>Annuler
                                </button>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</div><!-- /.tab-content -->

<?php include __DIR__ . '/../../views/partials/footer.php'; ?>
