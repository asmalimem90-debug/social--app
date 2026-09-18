<?php include __DIR__ . '/../../views/partials/header.php'; ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h5 class="mb-0 fw-bold">
        <i class="bi bi-stars me-2 text-warning"></i>Suggestions d'amis
    </h5>
</div>

<?php if (empty($suggestions)): ?>
    <div class="text-center text-muted py-5">
        <i class="bi bi-stars fs-1 d-block mb-2"></i>
        Aucune suggestion pour l'instant. Recherchez des utilisateurs pour agrandir votre réseau !
    </div>
<?php else: ?>
    <p class="text-muted small mb-3">Basées sur vos amis en commun</p>
    <div class="row g-3">
        <?php foreach ($suggestions as $s): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <a href="index.php?page=profile&id=<?= (int)$s['id'] ?>">
                        <img src="<?= avatarUrl($s['image'], $s['nom']) ?>"
                             class="avatar-md rounded-circle flex-shrink-0" alt="">
                    </a>
                    <div class="flex-grow-1 min-width-0">
                        <a href="index.php?page=profile&id=<?= (int)$s['id'] ?>"
                           class="fw-semibold text-dark text-decoration-none d-block text-truncate">
                            <?= h($s['nom']) ?>
                        </a>
                        <small class="text-muted">
                            <i class="bi bi-people me-1"></i><?= (int)$s['amis_communs'] ?> ami<?= $s['amis_communs'] > 1 ? 's' : '' ?> en commun
                        </small>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 py-2 px-3">
                    <?php if ($s['relation'] && $s['relation']['statut'] === 'EN_ATTENTE'
                              && (int)$s['relation']['demandeur_id'] === (int)$_SESSION['user_id']): ?>
                        <form method="post" action="index.php">
                            <input type="hidden" name="action"     value="cancel-request">
                            <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                            <input type="hidden" name="request_id" value="<?= (int)$s['relation']['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-secondary">
                                <i class="bi bi-clock me-1"></i>Annuler
                            </button>
                        </form>
                    <?php else: ?>
                        <form method="post" action="index.php">
                            <input type="hidden" name="action"     value="send-request">
                            <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                            <input type="hidden" name="target_id"  value="<?= (int)$s['id'] ?>">
                            <input type="hidden" name="return"     value="suggestions">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="bi bi-person-plus me-1"></i>Ajouter
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../../views/partials/footer.php'; ?>
