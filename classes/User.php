<?php 

require_once './config/db.php';

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

}

?>