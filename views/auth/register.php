<?php include __DIR__ . '/../../views/partials/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h4 class="card-title text-center mb-4 fw-bold">
                    <i class="bi bi-person-plus-fill me-2 text-primary"></i>Créer un compte
                </h4>

                <form method="post" action="index.php" enctype="multipart/form-data">
                    <input type="hidden" name="action"     value="register">
                    <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom complet <span class="text-danger">*</span></label>
                        <input type="text" id="nom" name="nom" class="form-control"
                               placeholder="Jean Dupont" required autofocus
                               value="<?= h($_POST['nom'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse email <span class="text-danger">*</span></label>
                        <input type="email" id="email" name="email" class="form-control"
                               placeholder="vous@exemple.com" required
                               value="<?= h($_POST['email'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                        <input type="password" id="password" name="password" class="form-control"
                               placeholder="Minimum 6 caractères" required minlength="6">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
                        <input type="password" id="password_confirm" name="password_confirm" class="form-control"
                               placeholder="Répétez le mot de passe" required>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label">Photo de profil <span class="text-muted small">(optionnel)</span></label>
                        <input type="file" id="image" name="image" class="form-control"
                               accept="image/jpeg,image/png,image/gif,image/webp">
                        <div class="form-text">JPEG, PNG, GIF ou WebP — max 2 Mo</div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle me-1"></i>Créer le compte
                    </button>
                </form>

                <hr class="my-3">
                <p class="text-center mb-0 small">
                    Déjà un compte ?
                    <a href="index.php?page=login">Se connecter</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../views/partials/footer.php'; ?>
