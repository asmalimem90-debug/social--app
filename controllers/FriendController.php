<?php
declare(strict_types=1);

class FriendController
{
    private Friend        $friendModel;
    private FriendRequest $requestModel;

    public function __construct()
    {
        $this->friendModel  = new Friend();
        $this->requestModel = new FriendRequest();
    }

    // ─── Friends list ────────────────────────────────────────

    public function showFriends(): void
    {
        requireAuth();

        $userId  = (int)$_SESSION['user_id'];
        $search  = trim($_GET['q'] ?? '');
        $friends = $this->friendModel->getFriends($userId);

        if ($search !== '') {
            $friends = array_filter($friends, static function (array $f) use ($search): bool {
                return stripos($f['nom'], $search) !== false
                    || stripos($f['email'], $search) !== false;
            });
        }

        $flash = getFlash();
        include __DIR__ . '/../views/friends/list.php';
    }

    // ─── Remove friend ───────────────────────────────────────

    public function processRemove(): void
    {
        requireAuth();
        verifyCsrf();

        $currentUser = (int)$_SESSION['user_id'];
        $friendId    = (int)($_POST['friend_id'] ?? 0);

        if ($this->friendModel->remove($currentUser, $friendId)) {
            setFlash('success', 'Ami supprimé.');
        } else {
            setFlash('danger', 'Impossible de supprimer cet ami.');
        }

        redirect('index.php?page=friends');
    }

    // ─── Friend suggestions (BONUS) ──────────────────────────

    public function showSuggestions(): void
    {
        requireAuth();

        $userId      = (int)$_SESSION['user_id'];
        $suggestions = $this->friendModel->getSuggestions($userId);

        // Attach current relation status for each suggestion
        foreach ($suggestions as &$s) {
            $s['relation'] = $this->requestModel->getRelation($userId, (int)$s['id']);
        }
        unset($s);

        $flash = getFlash();
        include __DIR__ . '/../views/friends/suggestions.php';
    }
}
