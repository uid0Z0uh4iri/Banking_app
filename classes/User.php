<?php 

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

    public function login($email,$password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user){
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
                $_SESSION['user_id'] = $this->id;
                $_SESSION['user_email'] = $this->email;
                $_SESSION['user_password'] = $this->password; // hadi macchi bon pratique de securite

                return true;
            }
    
        }
        return false;

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