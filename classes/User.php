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
    private $created_at;
    private $status;

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
                $this->created_at = $user['created_at'];
                $this->status = $user['status'];
            }
        }
    }

    // getters 
    public function getId()  { return $this->id; }
    public function getName()  { return $this->name; }
    public function getEmail()  { return $this->email; }
    public function getRole()  { return $this->role; }
    public function getdate() { return $this->created_at; }
    public function getStatus() { return $this->status; }

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

    // Récupérer les comptes de l'utilisateur
    public function getAccounts() {
        $accounts = [];
        
        // Récupérer le compte courant
        $stmt = $this->pdo->prepare("SELECT id FROM accounts WHERE user_id = ? AND account_type = 'courant'");
        $stmt->execute([$this->id]);
        $courant = $stmt->fetch();
        if ($courant) {
            $accounts['courant'] = $courant;
        }

        // Récupérer le compte épargne
        $stmt = $this->pdo->prepare("SELECT id FROM accounts WHERE user_id = ? AND account_type = 'epargne'");
        $stmt->execute([$this->id]);
        $epargne = $stmt->fetch();
        if ($epargne) {
            $accounts['epargne'] = $epargne;
        }

        return $accounts;
    }

    // Recuperer les soldes des comptes
    public function getAccountBalances() {
        $balances = ['courant' => 0, 'epargne' => 0];
        
        $stmt = $this->pdo->prepare("
            SELECT account_type, balance 
            FROM accounts 
            WHERE user_id = ?
        ");
        $stmt->execute([$this->id]);
        
        while ($account = $stmt->fetch()) {
            $balances[$account['account_type']] = $account['balance'];
        }
        
        return $balances;
    }



    // recupere le totale des depots


    public function getTotaleDepot()
    {
        $stmt=$this->pdo->prepare("SELECT SUM(amount) FROM transactions WHERE transaction_type='depot'");
        $stmt->execute();
        $TotaleDepot= $stmt->fetch();

        return $TotaleDepot;
    }




    public function getTotaleRetrait()
    {
        $stmt=$this->pdo->prepare("SELECT SUM(amount) FROM transactions WHERE transaction_type='retrait'");
        $stmt->execute();
        $TotaleRetrait= $stmt->fetch();

        return $TotaleRetrait;
    }



    public function getTotaleBalance()
    {
        $stmt=$this->pdo->prepare("SELECT SUM(balance) FROM accounts");
        $stmt->execute();
        $TotaleBalance= $stmt->fetch();

        return $TotaleBalance;
    }

    public function isFirstLogin() {
        $stmt = $this->pdo->prepare("SELECT is_first_login FROM users WHERE id = ?");
        $stmt->execute([$this->getId()]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['is_first_login'] == 1;
    }
}

?>