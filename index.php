<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/helpers.php';

require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/FriendRequest.php';
require_once __DIR__ . '/models/Friend.php';
require_once __DIR__ . '/models/Notification.php';

require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/FriendRequestController.php';
require_once __DIR__ . '/controllers/FriendController.php';
require_once __DIR__ . '/controllers/NotificationController.php';

$page   = trim($_GET['page']         ?? '');
$action = trim($_POST['action']      ?? '');

if ($action !== '') {
    $publicActions = ['login', 'register'];

    if (!isLoggedIn() && !in_array($action, $publicActions, true)) {
        redirect('index.php?page=login');
    }

    switch ($action) {
        case 'login':
            (new AuthController())->processLogin();
            break;
        case 'register':
            (new AuthController())->processRegister();
            break;
        case 'logout':
            (new AuthController())->logout();
            break;
        case 'update-profile':
            (new UserController())->processUpdateProfile();
            break;
        case 'delete-account':
            (new UserController())->processDeleteAccount();
            break;
        case 'send-request':
            (new FriendRequestController())->processSend();
            break;
        case 'cancel-request':
            (new FriendRequestController())->processCancel();
            break;
        case 'accept-request':
            (new FriendRequestController())->processAccept();
            break;
        case 'reject-request':
            (new FriendRequestController())->processReject();
            break;
        case 'remove-friend':
            (new FriendController())->processRemove();
            break;
        case 'mark-read':
            (new NotificationController())->processMarkRead();
            break;
        case 'mark-all-read':
            (new NotificationController())->processMarkAllRead();
            break;
        default:
            redirect('index.php?page=' . (isLoggedIn() ? 'profile' : 'login'));
    }
    exit;
}

if ($page === '') {
    redirect('index.php?page=' . (isLoggedIn() ? 'profile' : 'login'));
}

$publicPages = ['login', 'register'];

if (!isLoggedIn() && !in_array($page, $publicPages, true)) {
    setFlash('warning', 'Veuillez vous connecter pour accéder à cette page.');
    redirect('index.php?page=login');
}

if (isLoggedIn() && in_array($page, $publicPages, true)) {
    redirect('index.php?page=profile');
}

switch ($page) {
    case 'login':
        (new AuthController())->showLogin();
        break;
    case 'register':
        (new AuthController())->showRegister();
        break;
    case 'profile':
        (new UserController())->showProfile();
        break;
    case 'edit-profile':
        (new UserController())->showEditProfile();
        break;
    case 'search':
        (new UserController())->search();
        break;
    case 'friend-requests':
        (new FriendRequestController())->showRequests();
        break;
    case 'friends':
        (new FriendController())->showFriends();
        break;
    case 'notifications':
        (new NotificationController())->showNotifications();
        break;
    case 'suggestions':
        (new FriendController())->showSuggestions();
        break;
    default:
        redirect('index.php?page=' . (isLoggedIn() ? 'profile' : 'login'));
}
