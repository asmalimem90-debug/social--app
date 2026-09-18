<?php
declare(strict_types=1);

class AuthController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }


    public function showLogin(): void
    {
        $flash = getFlash();
        include __DIR__ . '/../views/auth/login.php';
    }

    public function showRegister(): void
    {
        $flash = getFlash();
        include __DIR__ . '/../views/auth/register.php';
    }


    public function processLogin(): void
    {
        verifyCsrf();

        $email    = trim($_POST['email']    ?? '');
        $password =      $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            setFlash('danger', 'Veuillez remplir tous les champs.');
            redirect('index.php?page=login');
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['motDePasse'])) {
            setFlash('danger', 'Email ou mot de passe incorrect.');
            redirect('index.php?page=login');
        }

        session_regenerate_id(true);
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['user_name']  = $user['nom'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_image'] = $user['image'];

        redirect('index.php?page=profile');
    }

    public function processRegister(): void
    {
        verifyCsrf();

        $nom             = trim($_POST['nom']              ?? '');
        $email           = trim($_POST['email']            ?? '');
        $password        =      $_POST['password']         ?? '';
        $passwordConfirm =      $_POST['password_confirm'] ?? '';

        if ($nom === '' || $email === '' || $password === '') {
            setFlash('danger', 'Veuillez remplir tous les champs obligatoires.');
            redirect('index.php?page=register');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            setFlash('danger', 'Adresse email invalide.');
            redirect('index.php?page=register');
        }

        if (strlen($password) < 6) {
            setFlash('danger', 'Le mot de passe doit contenir au moins 6 caractères.');
            redirect('index.php?page=register');
        }

        if ($password !== $passwordConfirm) {
            setFlash('danger', 'Les mots de passe ne correspondent pas.');
            redirect('index.php?page=register');
        }

        if ($this->userModel->findByEmail($email)) {
            setFlash('danger', 'Cette adresse email est déjà utilisée.');
            redirect('index.php?page=register');
        }

        $imageName = handleImageUpload('image');
        if ($imageName === false) {
            redirect('index.php?page=register');
        }

        $userId = $this->userModel->create($nom, $email, password_hash($password, PASSWORD_DEFAULT), $imageName);

        if (!$userId) {
            setFlash('danger', 'Erreur lors de la création du compte.');
            redirect('index.php?page=register');
        }

        session_regenerate_id(true);
        $_SESSION['user_id']    = $userId;
        $_SESSION['user_name']  = $nom;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_image'] = $imageName;

        setFlash('success', 'Compte créé avec succès. Bienvenue, ' . $nom . ' !');
        redirect('index.php?page=profile');
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        redirect('index.php?page=login');
    }
}
