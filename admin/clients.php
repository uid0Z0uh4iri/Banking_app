<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Gestion des Clients</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <button 
        onclick="toggleSidebar()"
        class="lg:hidden fixed top-4 left-4 z-50 bg-gray-900 text-white p-2 rounded-lg"
    >
        <i data-lucide="menu" class="w-6 h-6"></i>
    </button>

    <!-- Sidebar avec classe pour contrôler la visibilité -->
    <div id="sidebar" class="fixed inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 lg:relative lg:flex w-64 bg-gray-900 transition-transform duration-200 ease-in-out z-30">
        <div class="flex flex-col h-full">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-white">Admin Panel</h1>
                    <button onclick="toggleSidebar()" class="lg:hidden text-white">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
                <p class="text-gray-400 text-sm">Gestion bancaire</p>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 flex-grow">
                <a href="#" class="flex items-center w-full px-6 py-3 text-white bg-gray-800">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="clients.html" class="flex items-center w-full px-6 py-3 text-gray-400 hover:text-white hover:bg-gray-800">
                    <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                    <span>Clients</span>
                </a>
                <a href="compte.html" class="flex items-center w-full px-6 py-3 text-gray-400 hover:text-white hover:bg-gray-800">
                    <i data-lucide="credit-card" class="w-5 h-5 mr-3"></i>
                    <span>Comptes</span>
                </a>
                <a href="transactions.html" class="flex items-center w-full px-6 py-3 text-gray-400 hover:text-white hover:bg-gray-800">
                    <i data-lucide="repeat" class="w-5 h-5 mr-3"></i>
                    <span>Transactions</span>
                </a>
                <a href="#" class="flex items-center w-full px-6 py-3 text-gray-400 hover:text-white hover:bg-gray-800">
                    <i data-lucide="bell" class="w-5 h-5 mr-3"></i>
                    <span>Notifications</span>
                </a>
                <a href="#" class="flex items-center w-full px-6 py-3 text-gray-400 hover:text-white hover:bg-gray-800">
                    <i data-lucide="settings" class="w-5 h-5 mr-3"></i>
                    <span>Paramètres</span>
                </a>
            </nav>

            <!-- Profil Admin avec Déconnexion -->
            <div class="border-t border-gray-800 p-6">
                <div class="relative">
                    <button 
                        onclick="toggleProfileMenu()"
                        class="flex items-center w-full text-white hover:bg-gray-800 rounded-lg p-2"
                    >
                        <img src="/api/placeholder/32/32" alt="Admin" class="w-8 h-8 rounded-full">
                        <div class="ml-3 flex-grow">
                            <p class="text-sm font-medium">Admin</p>
                            <p class="text-xs text-gray-400">admin@banque.fr</p>
                        </div>
                        <i data-lucide="chevron-up" class="w-5 h-5 transform transition-transform duration-200" id="profileChevron"></i>
                    </button>

                    <!-- Menu Profil -->
                    <div id="profileMenu" class="absolute bottom-full left-0 w-full mb-2 bg-gray-800 rounded-lg shadow-lg hidden">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded-t-lg">
                            <i data-lucide="user" class="w-4 h-4 inline-block mr-2"></i>
                            Mon profil
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">
                            <i data-lucide="settings" class="w-4 h-4 inline-block mr-2"></i>
                            Paramètres
                        </a>
                        <a 
                            href="javascript:logout()" 
                            class="block px-4 py-2 text-sm text-red-400 hover:bg-gray-700 rounded-b-lg"
                        >
                            <i data-lucide="log-out" class="w-4 h-4 inline-block mr-2"></i>
                            Déconnexion
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Main Content -->
        <div class="flex-1">
            <!-- Top Navigation -->
            <div class="bg-white shadow">
                <div class="px-8 py-4 flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Gestion des Clients</h2>
                    <button 
                        onclick="toggleAddClientModal()"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center"
                    >
                        <i data-lucide="user-plus" class="w-5 h-5 mr-2"></i>
                        Nouveau Client
                    </button>
                </div>
            </div>

            <!-- Filters -->
            <div class="p-8">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    placeholder="Nom, email, ID..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                                <i data-lucide="search" class="w-5 h-5 text-gray-400 absolute left-3 top-2"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>Tous les statuts</option>
                                <option>Actif</option>
                                <option>Inactif</option>
                                <option>En attente</option>
                                <option>Bloqué</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type de compte</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>Tous les types</option>
                                <option>Compte Courant</option>
                                <option>Compte Épargne</option>
                                <option>Compte Joint</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Trier par</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>Date d'inscription</option>
                                <option>Nom</option>
                                <option>Solde</option>
                                <option>Activité récente</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Client List -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6">
                        <table class="min-w-full">
                            <thead>
                                <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <th class="p-3">Client</th>
                                    <th class="p-3">Contact</th>
                                    <th class="p-3">Comptes</th>
                                    <th class="p-3">Statut</th>
                                    <th class="p-3">Dernière activité</th>
                                    <th class="p-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <!-- Client 1 -->
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3">
                                        <div class="flex items-center">
                                            <img src="/api/placeholder/40/40" alt="Thomas Robert" class="w-10 h-10 rounded-full">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Thomas Robert</div>
                                                <div class="text-sm text-gray-500">ID: #45789</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <div class="text-sm text-gray-900">thomas@email.com</div>
                                        <div class="text-sm text-gray-500">06 12 34 56 78</div>
                                    </td>
                                    <td class="p-3">
                                        <div class="text-sm text-gray-900">2 comptes</div>
                                        <div class="text-sm text-gray-500">Courant, Épargne</div>
                                    </td>
                                    <td class="p-3">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Actif
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <div class="text-sm text-gray-900">Il y a 2 heures</div>
                                        <div class="text-sm text-gray-500">Virement sortant</div>
                                    </td>
                                    <td class="p-3">
                                        <div class="flex space-x-2">
                                            <button class="text-blue-600 hover:text-blue-900">
                                                <i data-lucide="eye" class="w-5 h-5"></i>
                                            </button>
                                            <button class="text-gray-600 hover:text-gray-900">
                                                <i data-lucide="edit" class="w-5 h-5"></i>
                                            </button>
                                            <button class="text-red-600 hover:text-red-900">
                                                <i data-lucide="lock" class="w-5 h-5"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Client 2 -->
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3">
                                        <div class="flex items-center">
                                            <img src="/api/placeholder/40/40" alt="Marie Dubois" class="w-10 h-10 rounded-full">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Marie Dubois</div>
                                                <div class="text-sm text-gray-500">ID: #45790</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <div class="text-sm text-gray-900">marie@email.com</div>
                                        <div class="text-sm text-gray-500">06 98 76 54 32</div>
                                    </td>
                                    <td class="p-3">
                                        <div class="text-sm text-gray-900">1 compte</div>
                                        <div class="text-sm text-gray-500">Courant</div>
                                    </td>
                                    <td class="p-3">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            En attente
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <div class="text-sm text-gray-900">Hier</div>
                                        <div class="text-sm text-gray-500">Création compte</div>
                                    </td>
                                    <td class="p-3">
                                        <div class="flex space-x-2">
                                            <button class="text-blue-600 hover:text-blue-900">
                                                <i data-lucide="eye" class="w-5 h-5"></i>
                                            </button>
                                            <button class="text-gray-600 hover:text-gray-900">
                                                <i data-lucide="edit" class="w-5 h-5"></i>
                                            </button>
                                            <button class="text-green-600 hover:text-green-900">
                                                <i data-lucide="check-circle" class="w-5 h-5"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- add client  -->

                        <div id="addClientModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
                            <div class="relative top-10 mx-auto p-5 w-full max-w-2xl">
                                <div class="bg-white rounded-lg shadow-xl">
                                    <!-- Modal Header -->
                                    <div class="flex justify-between items-center p-6 border-b">
                                        <h3 class="text-lg font-semibold text-gray-900">Ajouter un nouveau client</h3>
                                        <button onclick="toggleAddClientModal()" class="text-gray-400 hover:text-gray-500">
                                            <i data-lucide="x" class="w-6 h-6"></i>
                                        </button>
                                    </div>
                        
                                    <!-- Modal Body -->
                                    <div class="p-6">
                                        <form id="addClientForm" class="space-y-6">
                                            <!-- Informations personnelles -->
                                            <div>
                                                <h4 class="text-base font-medium text-gray-900 mb-4">Informations personnelles</h4>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Civilité *</label>
                                                        <select required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                            <option value="">Sélectionner</option>
                                                            <option value="mr">M.</option>
                                                            <option value="mme">Mme</option>
                                                        </select>
                                                    </div>
                        
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Numéro client</label>
                                                        <input 
                                                            type="text" 
                                                            readonly 
                                                            value="CLT-2024-0001"
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50"
                                                        >
                                                    </div>
                        
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                                                        <input 
                                                            type="text" 
                                                            required
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        >
                                                    </div>
                        
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                                                        <input 
                                                            type="text" 
                                                            required
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        >
                                                    </div>
                        
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Date de naissance *</label>
                                                        <input 
                                                            type="date" 
                                                            required
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        >
                                                    </div>
                        
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nationalité *</label>
                                                        <select required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                            <option value="">Sélectionner</option>
                                                            <option value="fr">Française</option>
                                                            <option value="other">Autre</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                        
                                            <!-- Coordonnées -->
                                            <div>
                                                <h4 class="text-base font-medium text-gray-900 mb-4">Coordonnées</h4>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                                        <input 
                                                            type="email" 
                                                            required
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        >
                                                    </div>
                        
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                                                        <input 
                                                            type="tel" 
                                                            required
                                                            pattern="[0-9]{10}"
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        >
                                                    </div>
                        
                                                    <div class="md:col-span-2">
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Adresse *</label>
                                                        <input 
                                                            type="text" 
                                                            required
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        >
                                                    </div>
                        
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Code postal *</label>
                                                        <input 
                                                            type="text" 
                                                            required
                                                            pattern="[0-9]{5}"
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        >
                                                    </div>
                        
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Ville *</label>
                                                        <input 
                                                            type="text" 
                                                            required
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                        
                                            <!-- Type de compte -->
                                            <div>
                                                <h4 class="text-base font-medium text-gray-900 mb-4">Configuration du compte</h4>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Type de compte *</label>
                                                        <select required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                            <option value="">Sélectionner</option>
                                                            <option value="courant">Compte Courant</option>
                                                            <option value="epargne">Compte Épargne</option>
                                                            <option value="both">Les deux</option>
                                                        </select>
                                                    </div>
                        
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Conseiller assigné</label>
                                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                            <option value="">Sélectionner</option>
                                                            <option value="1">Marc Dubois</option>
                                                            <option value="2">Sophie Martin</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                        
                              
                                        </form>
                                    </div>
                        
                                    <!-- Modal Footer -->
                                    <div class="flex justify-end space-x-3 p-6 border-t bg-gray-50">
                                        <button 
                                            onclick="toggleAddClientModal()" 
                                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500"
                                        >
                                            Annuler
                                        </button>
                                        <button 
                                            onclick="submitAddClientForm()"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        >
                                            Créer le compte
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="flex items-center justify-between mt-6">
                            <div class="text-sm text-gray-700">
                                Affichage de 1 à 10 sur 45 clients
                            </div>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 border rounded text-gray-600 hover:bg-gray-50">
                                    Précédent
                                </button>
                                <button class="px-3 py-1 border bg-blue-50 text-blue-600 rounded">
                                    1
                                </button>
                                <button class="px-3 py-1 border rounded text-gray-600 hover:bg-gray-50">
                                    2
                                </button>
                                <button class="px-3 py-1 border rounded text-gray-600 hover:bg-gray-50">
                                    3
                                </button>
                                <button class="px-3 py-1 border rounded text-gray-600 hover:bg-gray-50">
                                    Suivant
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
            // Toggle Sidebar Mobile
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    // Toggle Profile Menu
    function toggleProfileMenu() {
        const menu = document.getElementById('profileMenu');
        const chevron = document.getElementById('profileChevron');
        
        menu.classList.toggle('hidden');
        chevron.classList.toggle('rotate-180');
    }

    // Fonction de déconnexion
    function logout() {
        // Afficher un modal de confirmation
        if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
            // Rediriger vers la page de login
            window.location.href = 'login.html';
        }
    }

    // Fermer le menu profil si on clique ailleurs
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('profileMenu');
        const profileButton = event.target.closest('button');
        
        if (!profileButton && !menu.classList.contains('hidden')) {
            menu.classList.add('hidden');
            document.getElementById('profileChevron').classList.remove('rotate-180');
        }
    });
        function toggleAddClientModal() {
    const modal = document.getElementById('addClientModal');
    modal.classList.toggle('hidden');
}

function submitAddClientForm() {
    const form = document.getElementById('addClientForm');
    if (form.checkValidity()) {
        // Traitement du formulaire ici
        alert('Client ajouté avec succès !');
        toggleAddClientModal();
    } else {
        form.reportValidity();
    }
}
    </script>
</body>
</html>