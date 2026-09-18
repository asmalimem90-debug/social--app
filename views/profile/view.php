<?php include __DIR__ . '/../../views/partials/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body text-center p-4">
                <img src="<?= avatarUrl($user['image'], $user['nom']) ?>"
                     alt="avatar de <?= h($user['nom']) ?>"
                     class="avatar-lg rounded-circle mb-3 border border-3 border-primary">

                <h4 class="fw-bold mb-0"><?= h($user['nom']) ?></h4>
                <p class="text-muted small mb-2"><?= h($user['email']) ?></p>

                <div class="d-flex justify-content-center gap-4 my-3">
                    <div class="text-center">
                        <div class="fw-bold fs-5"><?= $friendCount ?></div>
                        <div class="text-muted small">ami<?= $friendCount > 1 ? 's' : '' ?></div>
                    </div>
                    <?php if (!$isSelf && count($commonFriends) > 0): ?>
                    <div class="text-center">
                        <div class="fw-bold fs-5"><?= count($commonFriends) ?></div>
                        <div class="text-muted small">ami<?= count($commonFriends) > 1 ? 's' : '' ?> en commun</div>
                    </div>
                    <?php endif; ?>
                </div>

                <p class="text-muted small">
                    Membre depuis <?= date('d/m/Y', strtotime($user['dateCreation'])) ?>
                </p>

                <?php if ($isSelf): ?>
                    <a href="index.php?page=edit-profile" class="btn btn-outline-primary">
                        <i class="bi bi-pencil me-1"></i>Modifier le profil
                    </a>
                <?php else: ?>
                    <?php if ($isFriend): ?>
                        <form method="post" action="index.php" class="d-inline">
                            <input type="hidden" name="action"     value="remove-friend">
                            <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                            <input type="hidden" name="friend_id"  value="<?= (int)$user['id'] ?>">
                            <button type="submit" class="btn btn-outline-danger"
                                    onclick="return confirm('Supprimer cet ami ?')">
                                <i class="bi bi-person-dash me-1"></i>Retirer des amis
                            </button>
                        </form>
                    <?php elseif ($relation): ?>
                        <?php if ($relation['statut'] === 'EN_ATTENTE' && (int)$relation['demandeur_id'] === (int)$_SESSION['user_id']): ?
                            <form method="post" action="index.php" class="d-inline">
                                <input type="hidden" name="action"     value="cancel-request">
                                <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                                <input type="hidden" name="request_id" value="<?= (int)$relation['id'] ?>">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="bi bi-clock me-1"></i>Demande envoyée
                                </button>
                            </form>
                        <?php elseif ($relation['statut'] === 'EN_ATTENTE' && (int)$relation['recepteur_id'] === (int)$_SESSION['user_id']): ?>
                            <!-- Accept / Reject incoming -->
                            <form method="post" action="index.php" class="d-inline">
                                <input type="hidden" name="action"     value="accept-request">
                                <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                                <input type="hidden" name="request_id" value="<?= (int)$relation['id'] ?>">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-lg me-1"></i>Accepter
                                </button>
                            </form>
                            <form method="post" action="index.php" class="d-inline">
                                <input type="hidden" name="action"     value="reject-request">
                                <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                                <input type="hidden" name="request_id" value="<?= (int)$relation['id'] ?>">
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="bi bi-x-lg me-1"></i>Refuser
                                </button>
                            </form>
                        <?php else: ?>
                            <!-- Send a new request (previous was accepted/rejected and friendship removed) -->
                            <form method="post" action="index.php" class="d-inline">
                                <input type="hidden" name="action"     value="send-request">
                                <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                                <input type="hidden" name="target_id"  value="<?= (int)$user['id'] ?>">
                                <input type="hidden" name="return"     value="profile">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-person-plus me-1"></i>Ajouter comme ami
                                </button>
                            </form>
                        <?php endif; ?>
                    <?php else: ?>
                        <!-- No relation — send request -->
                        <form method="post" action="index.php" class="d-inline">
                            <input type="hidden" name="action"     value="send-request">
                            <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                            <input type="hidden" name="target_id"  value="<?= (int)$user['id'] ?>">
                            <input type="hidden" name="return"     value="profile">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-person-plus me-1"></i>Ajouter comme ami
                            </button>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Common friends (BONUS) -->
        <?php if (!$isSelf && count($commonFriends) > 0): ?>
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-people me-2 text-primary"></i>Amis en commun (<?= count($commonFriends) ?>)
            </div>
            <div class="card-body d-flex flex-wrap gap-3 p-3">
                <?php foreach ($commonFriends as $cf): ?>
                    <a href="index.php?page=profile&id=<?= (int)$cf['id'] ?>"
                       class="text-decoration-none text-center" style="width:70px">
                        <img src="<?= avatarUrl($cf['image'], $cf['nom']) ?>"
                             class="avatar-sm rounded-circle d-block mx-auto mb-1" alt="">
                        <small class="text-muted" style="font-size:.75rem"><?= h($cf['nom']) ?></small>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<?php include __DIR__ . '/../../views/partials/footer.php'; ?>
