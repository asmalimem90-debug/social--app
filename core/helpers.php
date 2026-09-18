<?php
declare(strict_types=1);

// ─── CSRF ────────────────────────────────────────────────────

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(403);
        die('Jeton CSRF invalide. Rechargez la page et réessayez.');
    }
}

// ─── Output ──────────────────────────────────────────────────

/** HTML-escape a value safely */
function h(mixed $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// ─── Redirect / Flash ────────────────────────────────────────

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash(): ?array
{
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

// ─── Auth ────────────────────────────────────────────────────

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

function requireAuth(): void
{
    if (!isLoggedIn()) {
        setFlash('warning', 'Veuillez vous connecter pour accéder à cette page.');
        redirect('index.php?page=login');
    }
}

// ─── File upload ─────────────────────────────────────────────

/**
 * Handle a profile image upload.
 * Returns: filename (string) on success, null if no file was sent, false on error.
 */
function handleImageUpload(string $fieldName = 'image'): string|null|false
{
    if (empty($_FILES[$fieldName]['name'])) {
        return null;
    }

    $file          = $_FILES[$fieldName];
    $allowedMimes  = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $maxSize       = 2 * 1024 * 1024; // 2 MB

    if ($file['error'] !== UPLOAD_ERR_OK) {
        setFlash('danger', 'Erreur lors du téléchargement du fichier (code ' . $file['error'] . ').');
        return false;
    }

    if ($file['size'] > $maxSize) {
        setFlash('danger', "L'image ne doit pas dépasser 2 Mo.");
        return false;
    }

    // Verify actual MIME type (not just the extension declared by the client)
    $finfo    = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, $allowedMimes, true)) {
        setFlash('danger', 'Type de fichier non autorisé. Utilisez JPEG, PNG, GIF ou WebP.');
        return false;
    }

    $extMap  = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
    $ext     = $extMap[$mimeType] ?? 'jpg';
    $newName = bin2hex(random_bytes(16)) . '.' . $ext;

    if (!is_dir(UPLOAD_PATH)) {
        mkdir(UPLOAD_PATH, 0755, true);
    }

    if (!move_uploaded_file($file['tmp_name'], UPLOAD_PATH . $newName)) {
        setFlash('danger', "Impossible de sauvegarder l'image sur le serveur.");
        return false;
    }

    return $newName;
}

// ─── Avatar URL ──────────────────────────────────────────────

function avatarUrl(?string $image, string $name = ''): string
{
    if ($image && file_exists(UPLOAD_PATH . $image)) {
        return 'public/uploads/' . rawurlencode($image);
    }
    // Generate a placeholder using ui-avatars (no tracking, just initials)
    return 'https://ui-avatars.com/api/?name=' . rawurlencode($name ?: '?')
         . '&size=128&background=6366f1&color=fff&bold=true&rounded=true';
}

// ─── Time formatting ─────────────────────────────────────────

function timeAgo(string $datetime): string
{
    $diff = time() - strtotime($datetime);
    if ($diff < 60)      return "À l'instant";
    if ($diff < 3600)    return floor($diff / 60) . ' min';
    if ($diff < 86400)   return floor($diff / 3600) . 'h';
    if ($diff < 2592000) return floor($diff / 86400) . 'j';
    return date('d/m/Y', strtotime($datetime));
}
