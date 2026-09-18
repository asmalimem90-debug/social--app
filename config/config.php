<?php
declare(strict_types=1);

// ── Database ────────────────────────────────────────────────
define('DB_HOST', 'localhost');
define('DB_NAME', 'social_app');
define('DB_USER', 'root');
define('DB_PASS', '');

// ── File uploads ─────────────────────────────────────────────
// dirname(__DIR__) resolves to the project root from config/
define('UPLOAD_PATH', dirname(__DIR__) . '/public/uploads/');

// ── Application ───────────────────────────────────────────────
define('APP_NAME', 'SocialApp');
