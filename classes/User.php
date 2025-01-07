<?php 

require_once __DIR__ . '/../config/db.php';
require_once __DIR__.'/../config/db.php';


class User {
    private $pdo;
    private $id;
    private $name;  
    private $email;
    private $password;
    private $role;
    private $profil_pic;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        if (isset($_SESSION['user_id'])) {
            $this->id = $_SESSION['user_id'];
            // Charger les informations de l'utilisateur
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$this->id]);
            $user = $stmt->fetch();
            if ($user) {
                $this->name = $user['name'];
                $this->email = $user['email'];
                $this->role = $user['role'];
            }
        }
    }

    // getters 

    public function getId()  { return $this->id; }
    public function getName()  { return $this->name; }
    public function getEmail()  { return $this->email; }
    public function getRole()  { return $this->role; }

    // login method

    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            $isValid = false;
            if ($user['role'] == 'admin' && $password == $user['password']) {
                $isValid = true;
            } else {
                $isValid = password_verify($password, $user['password']);
            }

            if ($isValid) {
                $this->id = $user['id'];
                $this->name = $user['name'];
                $this->email = $user['email'];
                $this->role = $user['role'];
                
                // Ajoutons le rôle dans la session
                $_SESSION['user_id'] = $this->id;
                $_SESSION['user_email'] = $this->email;
                $_SESSION['role'] = $user['role'];  // Important !
                
                return true;
            }
        }
        return false;
    }

    // Récupérer tous les utilisateurs
    public function getAllUsers() {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE role = 'user'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Ajouter un nouveau client
    public function addUser($name, $email, $password, $status = 'active') {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, 'user', ?)");
        return $stmt->execute([$name, $email, $hashedPassword, $status]);
    }

    // Mettre à jour un client
    public function updateUser($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE users SET name = ?, email = ?, status = ? WHERE id = ? AND role = 'user'");
        return $stmt->execute([$data['name'], $data['email'], $data['status'], $id]);
    }

    // Récupérer un utilisateur par ID
    public function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Désactiver/Activer un compte client
    public function toggleUserStatus($id) {
        $user = $this->getUserById($id);
        $newStatus = ($user['status'] === 'active') ? 'inactive' : 'active';
        
        $stmt = $this->pdo->prepare("UPDATE users SET status = ? WHERE id = ? AND role = 'user'");
        return $stmt->execute([$newStatus, $id]);
    }

    

  


    // Recuperer les soldes des comptes
    public function getAccountBalances() {
        $stmt = $this->pdo->prepare("
            SELECT account_type, balance 
            FROM accounts 
            WHERE user_id = ?
        ");
        $stmt->execute([$this->id]);
        $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $balances = [
            'courant' => 0,
            'epargne' => 0
        ];
        
        foreach ($accounts as $account) {
            $balances[$account['account_type']] = $account['balance'];
        }
        
        return $balances;
    }

    // fonction pour alimenter le compte
    public function alimenterCompte($montant, $account_type = 'courant') {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE accounts 
                SET balance = balance + ? 
                WHERE user_id = ? AND account_type = ?
            ");
            $stmt->execute([$montant, $this->id, $account_type]);
            
            if ($stmt->rowCount() > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>