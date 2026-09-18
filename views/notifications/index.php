<?php include __DIR__ . '/../../views/partials/header.php'; ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h5 class="mb-0 fw-bold">
        <i class="bi bi-bell me-2 text-primary"></i>Notifications
    </h5>
    <?php if (!empty($notifications)): ?>
        <form method="post" action="index.php">
            <input type="hidden" name="action"     value="mark-all-read">
            <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
            <button type="submit" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-check-all me-1"></i>Tout marquer comme lu
            </button>
        </form>
    <?php endif; ?>
</div>

<?php if (empty($notifications)): ?>
    <div class="text-center text-muted py-5">
        <i class="bi bi-bell-slash fs-1 d-block mb-2"></i>
        Aucune notification.
    </div>
<?php else: ?>
    <div class="list-group shadow-sm">
        <?php foreach ($notifications as $n): ?>
        <?php
            $bgClass  = $n['is_read'] ? '' : 'list-group-item-light';
            $typeIcon = match ($n['type']) {
                'demandeAmitié'   => 'bi-person-plus text-primary',
                'demandeAcceptée' => 'bi-check-circle text-success',
                'demandeRefusée'  => 'bi-x-circle text-danger',
                default           => 'bi-bell text-secondary',
            };
            $typeLabel = match ($n['type']) {
                'demandeAmitié'   => 'vous a envoyé une demande d\'amitié',
                'demandeAcceptée' => 'a accepté votre demande d\'amitié',
                'demandeRefusée'  => 'a refusé votre demande d\'amitié',
                default           => '',
            };
        ?>
        <div class="list-group-item <?= $bgClass ?> d-flex align-items-center gap-3 py-3">
            <!-- Actor avatar -->
            <?php if ($n['nom_acteur']): ?>
                <a href="index.php?page=profile&id=<?= (int)($n['demandeur_id'] ?? 0) ?>">
                    <img src="<?= avatarUrl($n['image_acteur'] ?? null, $n['nom_acteur']) ?>"
                         class="avatar-sm rounded-circle flex-shrink-0" alt="">
                </a>
            <?php else: ?>
                <i class="bi <?= $typeIcon ?> fs-4 flex-shrink-0"></i>
            <?php endif; ?>

            <!-- Text -->
            <div class="flex-grow-1">
                <?php if ($n['nom_acteur']): ?>
                    <strong><?= h($n['nom_acteur']) ?></strong>
                <?php endif; ?>
                <?= h($typeLabel) ?>
                <div class="text-muted small"><?= timeAgo($n['dateCreation']) ?></div>
            </div>

            <!-- Badge + mark-read -->
            <div class="d-flex flex-column align-items-end gap-1">
                <?php if (!$n['is_read']): ?>
                    <span class="badge bg-primary rounded-pill">Nouveau</span>
                    <form method="post" action="index.php">
                        <input type="hidden" name="action"     value="mark-read">
                        <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                        <input type="hidden" name="notif_id"   value="<?= (int)$n['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-link p-0 text-muted">
                            <i class="bi bi-check"></i> Lu
                        </button>
                    </form>
                <?php else: ?>
                    <span class="text-muted small"><i class="bi bi-check-all"></i></span>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../../views/partials/footer.php'; ?>
