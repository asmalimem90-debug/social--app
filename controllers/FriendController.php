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


    public function showSuggestions(): void
    {
        requireAuth();

        $userId      = (int)$_SESSION['user_id'];
        $suggestions = $this->friendModel->getSuggestions($userId);

        foreach ($suggestions as &$s) {
            $s['relation'] = $this->requestModel->getRelation($userId, (int)$s['id']);
        }
        unset($s);

        $flash = getFlash();
        include __DIR__ . '/../views/friends/suggestions.php';
    }
}
