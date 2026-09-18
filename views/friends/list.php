<?php include __DIR__ . '/../../views/partials/header.php'; ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h5 class="mb-0 fw-bold"><i class="bi bi-people me-2 text-primary"></i>Mes amis</h5>
    <span class="badge bg-primary rounded-pill"><?= count($friends) ?></span>
</div>

<!-- Search / filter -->
<form method="get" action="index.php" class="mb-4">
    <input type="hidden" name="page" value="friends">
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input type="search" name="q" class="form-control"
               placeholder="Filtrer par nom ou email…"
               value="<?= h($_GET['q'] ?? '') ?>">
        <button class="btn btn-outline-secondary" type="submit">Filtrer</button>
        <?php if (!empty($_GET['q'])): ?>
            <a href="index.php?page=friends" class="btn btn-outline-secondary">
                <i class="bi bi-x"></i>
            </a>
        <?php endif; ?>
    </div>
</form>

<?php if (empty($friends)): ?>
    <div class="text-center text-muted py-5">
        <i class="bi bi-people fs-1 d-block mb-2"></i>
        <?= !empty($_GET['q']) ? 'Aucun ami ne correspond à votre recherche.' : 'Vous n\'avez pas encore d\'amis. <a href="index.php?page=search">Recherchez des utilisateurs</a> pour commencer !' ?>
    </div>
<?php else: ?>
    <div class="row g-3">
        <?php foreach ($friends as $f): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <a href="index.php?page=profile&id=<?= (int)$f['id'] ?>">
                        <img src="<?= avatarUrl($f['image'], $f['nom']) ?>"
                             class="avatar-md rounded-circle flex-shrink-0" alt="">
                    </a>
                    <div class="flex-grow-1 min-width-0">
                        <a href="index.php?page=profile&id=<?= (int)$f['id'] ?>"
                           class="fw-semibold text-dark text-decoration-none d-block text-truncate">
                            <?= h($f['nom']) ?>
                        </a>
                        <small class="text-muted d-block text-truncate"><?= h($f['email']) ?></small>
                        <small class="text-muted">
                            <i class="bi bi-calendar3 me-1"></i>Amis depuis <?= date('d/m/Y', strtotime($f['amis_depuis'])) ?>
                        </small>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 py-2 px-3">
                    <form method="post" action="index.php" class="d-inline">
                        <input type="hidden" name="action"    value="remove-friend">
                        <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                        <input type="hidden" name="friend_id" value="<?= (int)$f['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Supprimer <?= h(addslashes($f['nom'])) ?> de vos amis ?')">
                            <i class="bi bi-person-dash me-1"></i>Retirer
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../../views/partials/footer.php'; ?>
