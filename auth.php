<?php 
session_start();
require_once 'config/db.php';
require_once 'classes/User.php';

$db = new Database();
$pdo = $db->connect();
$user = new User($pdo);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // validation 
    if (empty($email)) {
        $errors[] = 'Veuillez entrer votre adresse e-mail';
    }
    if (empty($password)) {
        $errors[] = 'Veuillez entrer votre mot de passe';
    }

    if (empty($errors)) {
        if ($user->login($email, $password)) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user_name'] = $user->getName();
            $_SESSION['user_role'] = $user->getRole();
            
            // Check if user is inactive
            if ($user->getStatus() === 'inactive') {
                header('Location: client/inactif.php');
                exit();
            }
            
            // Vérifier si c'est la première connexion
            if ($user->isFirstLogin()) {
                header('Location: activate_account.php');
                exit();
            }
            
            // redirection vers le role 
            switch($user->getRole()) {
                case 'admin':
                    header('Location: admin/index.php');
                    break;
                case 'user':
                    header('Location: client/index.php');
                    break;
                default:
                    header("Location: index.php");
            }
            exit();
        } else {
            $errors[] = 'Adresse e-mail ou mot de passe incorrect';
        }
    }
}

?>





<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Connexion</title>
    <!-- Ajout de Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient">
    <div class="main-container">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach($errors as $error): ?>
                    <p><i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
                <?php $errors = []; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php 
                echo htmlspecialchars($_SESSION['success_message']); 
                unset($_SESSION['success_message']);
                ?>
            </div>
        <?php endif; ?>
        
        
        <div class="login-container">
            <div class="logo-container">
                <div class="bank-logo">
                    <i class="fas fa-university"></i>
                </div>
                <h2 class="bank-name">Banka2Ka</h2>
            </div>
            
            <div class="login-header">
                <h1>Connexion</h1>
                <p>Bienvenue sur votre espace bancaire sécurisé</p>
            </div>
            
            <form action="auth.php" method="post" class="login-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="Votre email" required/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Votre mot de passe" required/>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>Se souvenir de moi</span>
                    </label>
                    <a href="#" class="forgot-password">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="login-button">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </button>
            </form>
        </div>
    </div>
</body>
</html>