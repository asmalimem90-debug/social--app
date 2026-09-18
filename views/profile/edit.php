<?php include __DIR__ . '/../../views/partials/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">

        <!-- Edit profile form -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-pencil-square me-2 text-primary"></i>Modifier le profil
            </div>
            <div class="card-body p-4">

                <!-- Current avatar preview -->
                <div class="text-center mb-3">
                    <img src="<?= avatarUrl($user['image'], $user['nom']) ?>"
                         alt="avatar" id="avatarPreview"
                         class="avatar-lg rounded-circle border border-3 border-primary">
                </div>

                <form method="post" action="index.php" enctype="multipart/form-data">
                    <input type="hidden" name="action"     value="update-profile">
                    <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom complet</label>
                        <input type="text" id="nom" name="nom" class="form-control"
                               value="<?= h($user['nom']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse email</label>
                        <input type="email" id="email" name="email" class="form-control"
                               value="<?= h($user['email']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Changer la photo de profil</label>
                        <input type="file" id="image" name="image" class="form-control"
                               accept="image/jpeg,image/png,image/gif,image/webp">
                        <div class="form-text">Laissez vide pour conserver la photo actuelle.</div>
                    </div>

                    <hr>
                    <p class="fw-semibold mb-2">Changer le mot de passe <span class="text-muted fw-normal small">(optionnel)</span></p>

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mot de passe actuel</label>
                        <input type="password" id="current_password" name="current_password" class="form-control"
                               placeholder="Requis si vous changez le mot de passe">
                    </div>

                    <div class="mb-4">
                        <label for="new_password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" id="new_password" name="new_password" class="form-control"
                               placeholder="Minimum 6 caractères" minlength="6">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save me-1"></i>Enregistrer les modifications
                    </button>
                </form>
            </div>
        </div>

        <!-- Danger zone -->
        <div class="card border-danger shadow-sm">
            <div class="card-header bg-danger text-white fw-semibold">
                <i class="bi bi-exclamation-triangle me-2"></i>Zone dangereuse
            </div>
            <div class="card-body p-4">
                <p class="mb-3 text-muted">La suppression du compte est <strong>définitive</strong> et supprime toutes vos données.</p>
                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash me-1"></i>Supprimer le compte
                </button>
            </div>
        </div>

    </div>
</div>

<!-- Delete account modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-danger">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-trash me-2"></i>Supprimer le compte
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Cette action est irréversible. Confirmez votre mot de passe pour continuer.</p>
                <form method="post" action="index.php" id="deleteForm">
                    <input type="hidden" name="action"     value="delete-account">
                    <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                    <div class="mb-3">
                        <label for="del_password" class="form-label">Mot de passe</label>
                        <input type="password" id="del_password" name="password"
                               class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-trash me-1"></i>Supprimer définitivement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Live avatar preview
document.getElementById('image').addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('avatarPreview').src = e.target.result;
        reader.readAsDataURL(file);
    }
});
</script>

<?php include __DIR__ . '/../../views/partials/footer.php'; ?>
