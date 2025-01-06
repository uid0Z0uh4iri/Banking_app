<?php 
require_once 'config/db.php';
require_once 'classes/User.php';

session_start();

$db = new Database();
$pdo = $db->connect();
$user = new User($pdo);
$errors = [];





if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'login') {
      
        // Logic pour login
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
                $errors['login'] = 'Adresse e-mail ou mot de passe incorrect';
            }
        }
    } 
    elseif ($action === 'register') {
        // Logic pour register
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $passwordConfirm = $_POST['PasswordC'];

        // Validation register
        if (empty($name)) {
            $errors[] = 'Veuillez entrer votre nom';
        }
        if (empty($email)) {
            $errors[] = 'Veuillez entrer votre adresse e-mail';
        }
        if (empty($password)) {
            $errors[] = 'Veuillez entrer votre mot de passe';
        }
        if ($password !== $passwordConfirm) {
            $errors[] = 'Les mots de passe ne correspondent pas';
        }

        if (empty($errors)) {
          $user->register($name, $email, $password);
            if ($user->register($name, $email, $password)) {
                $_SESSION['success_message'] = 'Inscription réussie! Vous pouvez maintenant vous connecter.';
                header('Location: client/index.php');
                exit();
            } else {
                $errors[] = 'Une erreur est survenue lors de l\'inscription';
            }
        }
    }
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Document</title>
</head>
<body>
<?php if (!empty($errors)): ?>
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        <?php foreach($errors as $error): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
        <?php $errors = []; ?>
    </div>
<?php endif; ?>
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        <?php 
        echo htmlspecialchars($_SESSION['success_message']); 
        unset($_SESSION['success_message']); // Effacer le message aprrs l'avoir afficher
        ?>
    </div>
<?php endif; ?>


<div class="container" id="container">
            

    <!-- form de login -->
  <div class="form-container sign-up-container">
    <form action="auth.php" method="post">
        <input type="hidden" name="action" value="login">
        <h1>Sign in</h1>
        <input type="email" placeholder="Email" name="email" required/>
        <input type="password" placeholder="Password" name="password" required/>
        <a href="#">Forgot your password?</a>
        <button>Sign In</button>
    </form>
  </div>

 <!-- form de Register -->
  <div class="form-container sign-in-container">
    <form action="auth.php" method="post">
        <input type="hidden" name="action" value="register">
        <h1>Create Account</h1>
        <input type="text" placeholder="Name" name="name" required/>
        <input type="email" placeholder="Email" name="email" required/>
        <input type="password" placeholder="Password" name="password" required/>
        <input type="password" placeholder="Confirm Password" name="PasswordC" required/>
        <button>Sign Up</button>
    </form>
  </div>

  <div class="overlay-container">
    <div class="overlay">
      <div class="overlay-panel overlay-left">
        <h1>Welcome Back!</h1>
        <p>To keep connected with us please login with your personal info</p>
        <button class="ghost" id="signIn">Sign In</button>
      </div>
      <div class="overlay-panel overlay-right">
        <h1>Hello, Friend!</h1>
        <p>Enter your personal details and start journey with us</p>
        <button class="ghost" id="signUp">Sign Up</button>
      </div>
    </div>
  </div>

</div>

</body>
<script src="assets/js/script.js"></script>
</html>