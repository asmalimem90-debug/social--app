<?php

$_unreadCount = 0;
if (isLoggedIn()) {
    $__n = new Notification();
    $_unreadCount = $__n->getUnreadCount((int)$_SESSION['user_id']);
}
$__pendingReq = 0;
if (isLoggedIn()) {
    $__r = new FriendRequest();
    $__pendingReq = $__r->countPendingReceived((int)$_SESSION['user_id']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h(APP_NAME) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

<?php if (isLoggedIn()): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php?page=profile">
            <i class="bi bi-people-fill me-1"></i><?= h(APP_NAME) ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=profile">
                        <i class="bi bi-person-circle"></i> Profil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=friends">
                        <i class="bi bi-people"></i> Amis
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link position-relative" href="index.php?page=friend-requests">
                        <i class="bi bi-person-plus"></i> Demandes
                        <?php if ($__pendingReq > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= $__pendingReq ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=suggestions">
                        <i class="bi bi-stars"></i> Suggestions
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=search">
                        <i class="bi bi-search"></i> Rechercher
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link position-relative" href="index.php?page=notifications">
                        <i class="bi bi-bell-fill fs-5"></i>
                        <?php if ($_unreadCount > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= $_unreadCount > 99 ? '99+' : $_unreadCount ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= avatarUrl($_SESSION['user_image'] ?? null, $_SESSION['user_name'] ?? '') ?>"
                             alt="avatar" class="avatar-xs rounded-circle">
                        <span><?= h($_SESSION['user_name'] ?? '') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="index.php?page=edit-profile">
                            <i class="bi bi-pencil me-2"></i>Modifier le profil
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="post" action="index.php">
                                <input type="hidden" name="action"     value="logout">
                                <input type="hidden" name="csrf_token" value="<?= h(csrfToken()) ?>">
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php endif; ?>

<div class="container py-4">

<?php if (!empty($flash)): ?>
    <div class="alert alert-<?= h($flash['type']) ?> alert-dismissible fade show" role="alert">
        <?= h($flash['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
