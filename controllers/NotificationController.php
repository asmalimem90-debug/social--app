<?php
declare(strict_types=1);

class NotificationController
{
    private Notification $notifModel;

    public function __construct()
    {
        $this->notifModel = new Notification();
    }

   

    public function showNotifications(): void
    {
        requireAuth();

        $userId        = (int)$_SESSION['user_id'];
        $notifications = $this->notifModel->getByUser($userId);

        $flash = getFlash();
        include __DIR__ . '/../views/notifications/index.php';
    }

 

    public function processMarkRead(): void
    {
        requireAuth();
        verifyCsrf();

        $userId = (int)$_SESSION['user_id'];
        $id     = (int)($_POST['notif_id'] ?? 0);

        $this->notifModel->markAsRead($id, $userId);
        redirect('index.php?page=notifications');
    }

 

    public function processMarkAllRead(): void
    {
        requireAuth();
        verifyCsrf();

        $this->notifModel->markAllAsRead((int)$_SESSION['user_id']);
        redirect('index.php?page=notifications');
    }
}
