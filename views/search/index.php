<?php include __DIR__ . '/../../views/partials/header.php'; ?>

<div class="d-flex align-items-center gap-2 mb-4">
    <h5 class="mb-0 fw-bold"><i class="bi bi-search me-2 text-primary"></i>Rechercher un utilisateur</h5>
</div>

<form method="get" action="index.php" class="mb-4">
    <input type="hidden" name="page" value="search">
    <div class="input-group">
        <input type="search" name="q" class="form-control form-control-lg"
               placeholder="Nom ou adresse email…"
               value="<?= h($query) ?>" autofocus>
        <button class="btn btn-primary" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </div>
</form>

<?php if ($query !== '' && empty($users)): ?>
    <div class="text-center text-muted py-5">
        <i class="bi bi-person-x fs-1 d-block mb-2"></i>
        Aucun utilisateur trouvé pour « <?= h($query) ?> »
    </div>
<?php endif; ?>

<?php if (!empty($users)): ?>
<p class="text-muted small mb-3"><?= count($users) ?> résultat(s) pour « <?= h($query) ?> »</p>

<div class="row g-3">
    <?php foreach ($users as $u): ?>
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <a href="index.php?page=profile&id=<?= (int)$u['id'] ?>">
                    <img src="<?= avatarUrl($u['image'], $u['nom']) ?>"
                         class="avatar-md rounded-circle flex-shrink-0" alt="">
                </a>
                <div class="flex-grow-1 min-width-0">
                    <a href="index.php?page=profile&id=<?= (int)$u['id'] ?>"
                       class="fw-semibold text-dark text-decoration-none d-block text-truncate">
                        <?= h($u['nom']) ?>
                    </a>
                    <small class="text-muted d-block text-truncate"><?= h($u['email']) ?></small>
                    <small class="text-muted"><?= $u['friendCount'] ?> ami<?= $u['friendCount'] > 1 ? 's' : '' ?></small>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 py-2 px-3">
                <?php if ($u['isFriend']): ?>
                    <span class="badge bg-success-subtle text-success">
                        <i class="bi bi-check-circle me-1"></i>Ami
                    </span>
                    <form method="post" action="index.php" class="d-inline">
                        <input type="hidden" name="action"    value="remove-friend">
                        <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                        <input type="hidden" name="friend_id" value="<?= (int)$u['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger ms-1"
                                onclick="return confirm('Supprimer cet ami ?')">
                            <i class="bi bi-person-dash"></i>
                        </button>
                    </form>
                <?php elseif (isset($u['relation']) && $u['relation']): ?>
                    <?php $rel = $u['relation']; ?>
                    <?php if ($rel['statut'] === 'EN_ATTENTE' && (int)$rel['demandeur_id'] === (int)$_SESSION['user_id']): ?>
                        <form method="post" action="index.php" class="d-inline">
                            <input type="hidden" name="action"     value="cancel-request">
                            <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                            <input type="hidden" name="request_id" value="<?= (int)$rel['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-secondary">
                                <i class="bi bi-clock me-1"></i>Annuler
                            </button>
                        </form>
                    <?php elseif ($rel['statut'] === 'EN_ATTENTE' && (int)$rel['recepteur_id'] === (int)$_SESSION['user_id']): ?>
                        <form method="post" action="index.php" class="d-inline">
                            <input type="hidden" name="action"     value="accept-request">
                            <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                            <input type="hidden" name="request_id" value="<?= (int)$rel['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="bi bi-check-lg"></i> Accepter
                            </button>
                        </form>
                    <?php else: ?>
                        <form method="post" action="index.php" class="d-inline">
                            <input type="hidden" name="action"     value="send-request">
                            <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                            <input type="hidden" name="target_id"  value="<?= (int)$u['id'] ?>">
                            <input type="hidden" name="return"     value="search">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="bi bi-person-plus me-1"></i>Ajouter
                            </button>
                        </form>
                    <?php endif; ?>
                <?php else: ?>
                    <form method="post" action="index.php" class="d-inline">
                        <input type="hidden" name="action"     value="send-request">
                        <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                        <input type="hidden" name="target_id"  value="<?= (int)$u['id'] ?>">
                        <input type="hidden" name="return"     value="search">
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
