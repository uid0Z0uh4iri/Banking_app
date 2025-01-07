<?php
session_start();
require_once '../config/database.php';
require_once '../classes/User.php';

// Vérifier si l'utilisateur est connecté et est admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth.php');
    exit;
}

// Créer une instance de User avec la connexion PDO
$user = new User($pdo);
$message = '';

// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ajouter un nouveau client
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        if ($user->addUser($_POST['name'], $_POST['email'], $_POST['password'])) {
            $message = "Client ajouté avec succès!";
        } else {
            $message = "Erreur lors de l'ajout du client.";
        }
    }
    
    // Modifier un client
    if (isset($_POST['action']) && $_POST['action'] === 'edit') {
        if ($user->updateUser($_POST['user_id'], [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'status' => $_POST['status']
        ])) {
            $message = "Client modifié avec succès!";
        } else {
            $message = "Erreur lors de la modification du client.";
        }
    }
    
    // Changer le statut
    if (isset($_POST['action']) && $_POST['action'] === 'toggle_status') {
        if ($user->toggleUserStatus($_POST['user_id'])) {
            $message = "Statut modifié avec succès!";
        } else {
            $message = "Erreur lors du changement de statut.";
        }
    }
}

// Récupérer tous les utilisateurs
$users = $user->getAllUsers();
?>

<!-- Afficher le message -->
<?php if ($message): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline"><?php echo $message; ?></span>
    </div>
<?php endif; ?>

<!-- Liste des clients -->
<table class="min-w-full">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $client): ?>
            <tr>
                <td><?php echo $client['id']; ?></td>
                <td><?php echo htmlspecialchars($client['name']); ?></td>
                <td><?php echo htmlspecialchars($client['email']); ?></td>
                <td><?php echo $client['status']; ?></td>
                <td>
                    <!-- Formulaire pour modifier le statut -->
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="action" value="toggle_status">
                        <input type="hidden" name="user_id" value="<?php echo $client['id']; ?>">
                        <button type="submit" class="text-<?php echo $client['status'] === 'active' ? 'red' : 'green'; ?>-600">
                            <?php echo $client['status'] === 'active' ? 'Désactiver' : 'Activer'; ?>
                        </button>
                    </form>

                    <!-- Bouton pour modifier -->
                    <a href="?edit=<?php echo $client['id']; ?>" class="text-blue-600">
                        Modifier
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Formulaire d'ajout/modification -->
<?php 
$editUser = null;
if (isset($_GET['edit'])) {
    $editUser = $user->getUserById($_GET['edit']);
}
?>

<form method="POST" class="mt-4">
    <input type="hidden" name="action" value="<?php echo $editUser ? 'edit' : 'add'; ?>">
    <?php if ($editUser): ?>
        <input type="hidden" name="user_id" value="<?php echo $editUser['id']; ?>">
    <?php endif; ?>

    <div class="mb-4">
        <label>Nom:</label>
        <input type="text" name="name" value="<?php echo $editUser ? $editUser['name'] : ''; ?>" required>
    </div>

    <div class="mb-4">
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $editUser ? $editUser['email'] : ''; ?>" required>
    </div>

    <?php if (!$editUser): ?>
        <div class="mb-4">
            <label>Mot de passe:</label>
            <input type="password" name="password" required>
        </div>
    <?php endif; ?>

    <?php if ($editUser): ?>
        <div class="mb-4">
            <label>Statut:</label>
            <select name="status">
                <option value="active" <?php echo $editUser['status'] === 'active' ? 'selected' : ''; ?>>Actif</option>
                <option value="inactive" <?php echo $editUser['status'] === 'inactive' ? 'selected' : ''; ?>>Inactif</option>
            </select>
        </div>
    <?php endif; ?>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
        <?php echo $editUser ? 'Modifier' : 'Ajouter'; ?> le client
    </button>
</form>