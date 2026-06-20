<?php
// src/Controller/web/AuthController.php

require_once __DIR__ . '/../../Repository/UserRepository.php';

class AuthController {
    private UserRepository $userRepo;

    public function __construct() {
        $this->userRepo = new UserRepository();
    }

 
    public function login() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?action=dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userRepo->findByUsername($email);

            if ($user && $password==$user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['nom'];
                $_SESSION['role'] = $user['role'];

                header("Location: index.php?action=dashboard");
                exit;
            } else {
                $error = "Identifiants incorrects.";
               
                require __DIR__ . '/../../../templates/auth/login.php';
                return;
            }
        }

      
        require __DIR__ . '/../../../templates/auth/login.php';
    }

    public function logout() {
     
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();

       
        header("Location: index.php?action=login");
        exit;
    }
}