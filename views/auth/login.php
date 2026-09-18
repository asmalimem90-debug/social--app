<?php include __DIR__ . '/../../views/partials/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h4 class="card-title text-center mb-4 fw-bold">
                    <i class="bi bi-box-arrow-in-right me-2 text-primary"></i>Connexion
                </h4>

                <form method="post" action="index.php">
                    <input type="hidden" name="action" value="login">
                    <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">

                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" id="email" name="email" class="form-control"
                                   placeholder="vous@exemple.com" required autofocus
                                   value="<?= h($_POST['email'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" id="password" name="password" class="form-control"
                                   placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Se connecter
                    </button>
                </form>

                <hr class="my-3">
                <p class="text-center mb-0 small">
                    Pas encore de compte ?
                    <a href="index.php?page=register">Créer un compte</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../views/partials/footer.php'; ?>
