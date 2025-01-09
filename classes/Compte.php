<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/Transactions.php';

abstract class Compte {
    protected $pdo;
    protected $user_id;
    protected $account_type;
    protected $balance;
    protected $transactions;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->transactions = new Transactions($pdo);
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
            $this->pdo->beginTransaction();

            // Récupérer l'ID du compte
            $stmt = $this->pdo->prepare("SELECT id FROM accounts WHERE user_id = ? AND account_type = ?");
            $stmt->execute([$user_id, $account_type]);
            $account = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$account) {
                throw new Exception("Compte non trouvé");
            }

            // Mettre à jour le solde
            $stmt = $this->pdo->prepare("
                UPDATE accounts 
                SET balance = balance + ? 
                WHERE user_id = ? AND account_type = ?
            ");
            $stmt->execute([$montant, $user_id, $account_type]);
            
            // Enregistrer la transaction
            $this->transactions->recordTransaction($account['id'], 'depot', $montant);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    // Fonction pour faire un retrait
    public function retraitCompte($user_id, $montant, $account_type = 'courant') {
        if (!$this->verifierMontant($montant) || !$this->verifierSolde($user_id, $account_type)) {
        require_once __DIR__ . '/Transactions.php';            
        return false;
        }

        try {
            $this->pdo->beginTransaction();

            // Récupérer l'ID du compte
            $stmt = $this->pdo->prepare("SELECT id FROM accounts WHERE user_id = ? AND account_type = ?");
            $stmt->execute([$user_id, $account_type]);
            $account = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$account) {
                throw new Exception("Compte non trouvé");
            }

            // Mettre à jour le solde
            $stmt = $this->pdo->prepare("
                UPDATE accounts 
                SET balance = balance - ? 
                WHERE user_id = ? AND account_type = ?
            ");
            $stmt->execute([$montant, $user_id, $account_type]);
            
            // Enregistrer la transaction
            $this->transactions->recordTransaction($account['id'], 'retrait', $montant);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
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
        return $stmt->fetchColumn();
    }

    // Recuperer tous les comptes d'un utilisateur
    public function getComptesByUserId($user_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM accounts WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}