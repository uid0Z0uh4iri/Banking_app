<?php
session_start();
require_once '../config/database.php';
require_once '../classes/User.php';
require_once '../classes/Mailer.php';

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
        $password = $_POST['password'];
        if ($user->addUser($_POST['name'], $_POST['email'], $password)) {
            // Envoyer l'email avec les informations du compte
            if (sendAccountDetails($_POST['email'], $_POST['name'], $password)) {
                $message = "Client ajouté avec succès et les informations ont été envoyées par email!";
            } else {
                $message = "Client ajouté avec succès mais l'envoi de l'email a échoué.";
            }
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

// Ajouter cette partie pour gérer la recherche Ajax
if (isset($_GET['ajax_search'])) {
    $search = $_GET['ajax_search'];
    // Préparer la requête de recherche
    $stmt = $pdo->prepare("SELECT * FROM users WHERE name LIKE :search OR email LIKE :search");
    $stmt->execute(['search' => "%$search%"]);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Retourner les résultats en HTML
    foreach ($users as $client): ?>
        <tr>
            <td><?php echo $client['id']; ?></td>
            <td><?php echo htmlspecialchars($client['name']); ?></td>
            <td><?php echo htmlspecialchars($client['email']); ?></td>
            <td><?php echo $client['status']; ?></td>
            <td>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="toggle_status">
                    <input type="hidden" name="user_id" value="<?php echo $client['id']; ?>">
                    <button type="submit" class="text-<?php echo $client['status'] === 'active' ? 'red' : 'green'; ?>-600">
                        <?php echo $client['status'] === 'active' ? 'Désactiver' : 'Activer'; ?>
                    </button>
                </form>
                <a href="?edit=<?php echo $client['id']; ?>" class="text-blue-600">
                    Modifier
                </a>
            </td>
        </tr>
    <?php endforeach;
    exit; // Important: arrêter l'exécution ici pour l'appel Ajax
}
?>

<!-- Afficher le message -->
<?php if ($message): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline"><?php echo $message; ?></span>
    </div>
<?php endif; ?>

<!-- Ajouter la barre de recherche avant la table -->
<div class="mb-4">
    <input 
        type="text" 
        id="searchInput" 
        placeholder="Rechercher un client..."
        class="border rounded px-4 py-2 w-full"
    >
</div>

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
    <tbody id="clientsTableBody">
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

<!-- Ajouter le JavaScript à la fin de la page -->
<script>
// Attendre que la page soit chargée
document.addEventListener('DOMContentLoaded', function() {
    // Récupérer l'input de recherche
    const searchInput = document.getElementById('searchInput');
    // Récupérer le tbody du tableau
    const tableBody = document.getElementById('clientsTableBody');
    
    // Variable pour stocker le timeout
    let timeoutId;
    
    // Écouter l'événement input sur la barre de recherche
    searchInput.addEventListener('input', function() {
        // Récupérer la valeur de recherche
        const searchTerm = this.value;
        
        // Annuler le timeout précédent
        clearTimeout(timeoutId);
        
        // Créer un nouveau timeout (attendre 300ms après la dernière frappe)
        timeoutId = setTimeout(function() {
            // Créer la requête Ajax
            fetch('clients.php?ajax_search=' + encodeURIComponent(searchTerm))
                .then(response => response.text())
                .then(html => {
                    // Mettre à jour le contenu du tableau
                    tableBody.innerHTML = html;
                })
                .catch(error => console.error('Erreur:', error));
        }, 300);
    });
});
</script>