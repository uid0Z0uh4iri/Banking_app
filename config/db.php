<?php
// db.php : Connexion a la base de données
    class Database {
        private $host = 'localhost';   
        private $dbname = 'banque';   
        private $username = 'root';    
        private $password = '';        
        private $conn;

        public function connect() {
            try {
                // Cree une nouvelle connexion PDO
                $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->conn;  // Retourne la connexion
            } catch (PDOException $e) {
                echo "Erreur de connexion : " . $e->getMessage();
                return null;
            }
        }
    }

?>