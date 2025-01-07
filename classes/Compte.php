<?php

require_once __DIR__ . '/../config/db.php';

class Compte {
    private $pdo;
    private $user_id;
    private $account_type;
    private $balance;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Fonction pour alimenter le compte
    public function alimenterCompte($user_id, $montant, $account_type = 'courant') {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE accounts 
                SET balance = balance + ? 
                WHERE user_id = ? AND account_type = ?
            ");
            $stmt->execute([$montant, $user_id, $account_type]);
            
            if ($stmt->rowCount() > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Récupérer le solde d'un compte spécifique
    public function getBalance($user_id, $account_type = 'courant') {
        $stmt = $this->pdo->prepare("
            SELECT balance 
            FROM accounts 
            WHERE user_id = ? AND account_type = ?
        ");
        $stmt->execute([$user_id, $account_type]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ? $result['balance'] : 0;
    }
}