<?php
declare(strict_types=1);

class FriendRequestController
{
    private FriendRequest $requestModel;
    private Friend        $friendModel;
    private Notification  $notifModel;

    public function __construct()
    {
        $this->requestModel = new FriendRequest();
        $this->friendModel  = new Friend();
        $this->notifModel   = new Notification();
    }

    // ─── Show requests page ──────────────────────────────────

    public function showRequests(): void
    {
        requireAuth();

        $userId   = (int)$_SESSION['user_id'];
        $sent     = $this->requestModel->getSent($userId);
        $received = $this->requestModel->getReceived($userId);

        $flash = getFlash();
        include __DIR__ . '/../views/friends/requests.php';
    }

    // ─── Send request ────────────────────────────────────────

    public function processSend(): void
    {
        requireAuth();
        verifyCsrf();

        $currentUser = (int)$_SESSION['user_id'];
        $targetId    = (int)($_POST['target_id'] ?? 0);

        // Whitelist the return page to prevent open-redirect
        $allowed    = ['search', 'profile', 'suggestions', 'friends'];
        $rawReturn  = $_POST['return'] ?? 'search';
        $returnPage = in_array($rawReturn, $allowed, true) ? $rawReturn : 'search';

        if ($targetId === 0 || $targetId === $currentUser) {
            setFlash('danger', 'Action impossible.');
            redirect('index.php?page=' . $returnPage);
        }

        // Guard: already friends
        if ($this->friendModel->areFriends($currentUser, $targetId)) {
            setFlash('warning', 'Vous êtes déjà amis avec cet utilisateur.');
            redirect('index.php?page=' . $returnPage);
        }

        // Guard: request already exists in either direction
        if ($this->requestModel->getRelation($currentUser, $targetId)) {
            setFlash('warning', 'Une demande existe déjà avec cet utilisateur.');
            redirect('index.php?page=' . $returnPage);
        }

        $newId = $this->requestModel->send($currentUser, $targetId);

        if ($newId) {
            // Notify the recipient
            $this->notifModel->create($targetId, 'demandeAmitié', $newId);
            setFlash('success', 'Demande d\'amitié envoyée.');
        } else {
            setFlash('danger', 'Impossible d\'envoyer la demande.');
        }

        redirect('index.php?page=' . $returnPage);
    }

    // ─── Cancel sent request ─────────────────────────────────

    public function processCancel(): void
    {
        requireAuth();
        verifyCsrf();

        $currentUser = (int)$_SESSION['user_id'];
        $requestId   = (int)($_POST['request_id'] ?? 0);

        if ($this->requestModel->cancel($requestId, $currentUser)) {
            setFlash('success', 'Demande annulée.');
        } else {
            setFlash('danger', 'Impossible d\'annuler cette demande.');
        }

        redirect('index.php?page=friend-requests');
    }

    // ─── Accept request ──────────────────────────────────────

    public function processAccept(): void
    {
        requireAuth();
        verifyCsrf();

        $currentUser = (int)$_SESSION['user_id'];
        $requestId   = (int)($_POST['request_id'] ?? 0);

        $row = $this->requestModel->findById($requestId);
        if (!$row || (int)$row['recepteur_id'] !== $currentUser) {
            setFlash('danger', 'Demande introuvable.');
            redirect('index.php?page=friend-requests');
        }

        if ($this->requestModel->accept($requestId, $currentUser)) {
            // Create symmetric friendship (one row, ordered IDs)
            $this->friendModel->add($currentUser, (int)$row['demandeur_id']);
            // Notify the sender that their request was accepted
            $this->notifModel->create((int)$row['demandeur_id'], 'demandeAcceptée', $requestId);
            setFlash('success', 'Demande d\'amitié acceptée.');
        } else {
            setFlash('danger', 'Impossible d\'accepter cette demande.');
        }

        redirect('index.php?page=friend-requests');
    }

    // ─── Reject request ──────────────────────────────────────

    public function processReject(): void
    {
        requireAuth();
        verifyCsrf();

        $currentUser = (int)$_SESSION['user_id'];
        $requestId   = (int)($_POST['request_id'] ?? 0);

        $row = $this->requestModel->findById($requestId);
        if (!$row || (int)$row['recepteur_id'] !== $currentUser) {
            setFlash('danger', 'Demande introuvable.');
            redirect('index.php?page=friend-requests');
        }

        if ($this->requestModel->reject($requestId, $currentUser)) {
            // Notify the sender about the rejection
            $this->notifModel->create((int)$row['demandeur_id'], 'demandeRefusée', $requestId);
            setFlash('info', 'Demande refusée.');
        } else {
            setFlash('danger', 'Impossible de refuser cette demande.');
        }

        redirect('index.php?page=friend-requests');
    }
}
