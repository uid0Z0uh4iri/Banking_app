<?php

require_once __DIR__ . '/../config/db.php';

abstract class Compte {
    protected $pdo;
    protected $user_id;
    protected $account_type;
    protected $balance;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // methodes abstraites
    abstract protected function verifierMontant($montant): bool;
    abstract protected function verifierSolde($user_id, $account_type): bool;

    // Fonction pour alimenter le compte
    public function alimenterCompte($user_id, $montant, $account_type = 'courant') {
        if (!$this->verifierMontant($montant)) {
            return false;
        }

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

    // Fonction pour faire un retrait
    public function retraitCompte($user_id, $montant, $account_type = 'courant') {
        if (!$this->verifierMontant($montant) || !$this->verifierSolde($user_id, $account_type)) {
            return false;
        }

        try {
            $stmt = $this->pdo->prepare("
                UPDATE accounts 
                SET balance = balance - ? 
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

    // Recuperer le solde d'un compte specifique
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