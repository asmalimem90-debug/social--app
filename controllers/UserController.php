<?php
declare(strict_types=1);

class UserController
{
    private User          $userModel;
    private Friend        $friendModel;
    private FriendRequest $requestModel;

    public function __construct()
    {
        $this->userModel    = new User();
        $this->friendModel  = new Friend();
        $this->requestModel = new FriendRequest();
    }

    // ─── Show profile (own or another user's) ────────────────

    public function showProfile(): void
    {
        requireAuth();

        $viewUserId = isset($_GET['id']) ? (int)$_GET['id'] : (int)$_SESSION['user_id'];
        $user       = $this->userModel->findById($viewUserId);

        if (!$user) {
            setFlash('danger', 'Utilisateur introuvable.');
            redirect('index.php?page=profile');
        }

        $currentUserId = (int)$_SESSION['user_id'];
        $isSelf        = ($viewUserId === $currentUserId);
        $friendCount   = $this->friendModel->getCount($viewUserId);
        $isFriend      = !$isSelf && $this->friendModel->areFriends($currentUserId, $viewUserId);
        $relation      = !$isSelf ? $this->requestModel->getRelation($currentUserId, $viewUserId) : null;
        $commonFriends = !$isSelf ? $this->friendModel->getCommonFriends($currentUserId, $viewUserId) : [];

        $flash = getFlash();
        include __DIR__ . '/../views/profile/view.php';
    }

    // ─── Edit profile form ───────────────────────────────────

    public function showEditProfile(): void
    {
        requireAuth();
        $user  = $this->userModel->findById((int)$_SESSION['user_id']);
        $flash = getFlash();
        include __DIR__ . '/../views/profile/edit.php';
    }

    // ─── Process profile update ──────────────────────────────

    public function processUpdateProfile(): void
    {
        requireAuth();
        verifyCsrf();

        $nom         = trim($_POST['nom']              ?? '');
        $email       = trim($_POST['email']            ?? '');
        $currentPass =      $_POST['current_password'] ?? '';
        $newPass     =      $_POST['new_password']     ?? '';

        if ($nom === '' || $email === '') {
            setFlash('danger', 'Le nom et l\'email sont obligatoires.');
            redirect('index.php?page=edit-profile');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            setFlash('danger', 'Adresse email invalide.');
            redirect('index.php?page=edit-profile');
        }

        // Email uniqueness check (may be claimed by another account)
        $existing = $this->userModel->findByEmail($email);
        if ($existing && (int)$existing['id'] !== (int)$_SESSION['user_id']) {
            setFlash('danger', 'Cette adresse email est déjà utilisée.');
            redirect('index.php?page=edit-profile');
        }

        $data = ['nom' => $nom, 'email' => $email];

        // Optional password change
        if ($newPass !== '') {
            if (strlen($newPass) < 6) {
                setFlash('danger', 'Le nouveau mot de passe doit contenir au moins 6 caractères.');
                redirect('index.php?page=edit-profile');
            }
            $currentUser = $this->userModel->findById((int)$_SESSION['user_id']);
            if (!password_verify($currentPass, $currentUser['motDePasse'])) {
                setFlash('danger', 'Mot de passe actuel incorrect.');
                redirect('index.php?page=edit-profile');
            }
            $data['motDePasse'] = password_hash($newPass, PASSWORD_DEFAULT);
        }

        // Optional avatar change
        $imageName = handleImageUpload('image');
        if ($imageName === false) {
            redirect('index.php?page=edit-profile');
        }
        if ($imageName !== null) {
            // Delete old avatar if it exists on disk
            $currentUser = $currentUser ?? $this->userModel->findById((int)$_SESSION['user_id']);
            if ($currentUser['image'] && file_exists(UPLOAD_PATH . $currentUser['image'])) {
                unlink(UPLOAD_PATH . $currentUser['image']);
            }
            $data['image'] = $imageName;
        }

        $this->userModel->update((int)$_SESSION['user_id'], $data);

        // Keep the session in sync
        $_SESSION['user_name']  = $nom;
        $_SESSION['user_email'] = $email;
        if (isset($data['image'])) {
            $_SESSION['user_image'] = $data['image'];
        }

        setFlash('success', 'Profil mis à jour avec succès.');
        redirect('index.php?page=edit-profile');
    }

    // ─── Delete account ──────────────────────────────────────

    public function processDeleteAccount(): void
    {
        requireAuth();
        verifyCsrf();

        $password = $_POST['password'] ?? '';
        $user     = $this->userModel->findById((int)$_SESSION['user_id']);

        if (!password_verify($password, $user['motDePasse'])) {
            setFlash('danger', 'Mot de passe incorrect. Suppression annulée.');
            redirect('index.php?page=edit-profile');
        }

        if ($user['image'] && file_exists(UPLOAD_PATH . $user['image'])) {
            unlink(UPLOAD_PATH . $user['image']);
        }

        $this->userModel->delete((int)$_SESSION['user_id']);
        session_unset();
        session_destroy();
        redirect('index.php?page=login');
    }

    // ─── Search ──────────────────────────────────────────────

    public function search(): void
    {
        requireAuth();

        $query       = trim($_GET['q'] ?? '');
        $users       = [];
        $currentUser = (int)$_SESSION['user_id'];

        if ($query !== '') {
            $users = $this->userModel->search($query, $currentUser);

            foreach ($users as &$u) {
                $u['friendCount'] = $this->friendModel->getCount((int)$u['id']);
                $u['isFriend']    = $this->friendModel->areFriends($currentUser, (int)$u['id']);
                $u['relation']    = $this->requestModel->getRelation($currentUser, (int)$u['id']);
            }
            unset($u);
        }

        $flash = getFlash();
        include __DIR__ . '/../views/search/index.php';
    }
}
