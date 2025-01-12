<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen relative">
            <!-- Bouton Menu Mobile -->
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
                        <a href="clients.php" class="flex items-center w-full px-6 py-3 text-gray-400 hover:text-white hover:bg-gray-800">
                            <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                            <span>Clients</span>
                        </a>
                        <a href="statistiques.php" class="flex items-center w-full px-6 py-3 text-gray-400 hover:text-white hover:bg-gray-800">
                            <i data-lucide="bar-chart" class="w-5 h-5 mr-3"></i>
                            <span>Statistiques</span>
                        </a>
                    </nav>

                    <!-- Profil Admin avec Déconnexion -->
                    <div class="border-t border-gray-800 p-6">
                        <a href="../logout.php" class="flex items-center w-full text-red-400 hover:bg-gray-800 rounded-lg p-2">
                            <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
                            <span>Déconnexion</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col">
                <!-- Top Navigation -->
                <div class="bg-white shadow">
                    <div class="px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
                        <div class="flex items-center space-x-4">
                            <button class="p-2 text-gray-400 hover:text-gray-600">
                                <i data-lucide="search" class="w-5 h-5"></i>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-gray-600 relative">
                                <i data-lucide="bell" class="w-5 h-5"></i>
                                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Content avec Responsive -->
                <div class="p-4 sm:p-6 lg:p-8 flex-grow">
                    <!-- Statistiques -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                        <!-- Carte Clients Actifs -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Clients Actifs</p>
                                    <h3 class="text-2xl font-bold mt-2">1,234</h3>
                                    <p class="text-green-500 text-sm mt-2">
                                        <i data-lucide="trending-up" class="w-4 h-4 inline"></i>
                                        +12.5%
                                    </p>
                                </div>
                                <div class="bg-blue-100 p-3 rounded-full">
                                    <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Carte Transactions -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Transactions (24h)</p>
                                    <h3 class="text-2xl font-bold mt-2">€45,678</h3>
                                    <p class="text-green-500 text-sm mt-2">
                                        <i data-lucide="trending-up" class="w-4 h-4 inline"></i>
                                        +8.3%
                                    </p>
                                </div>
                                <div class="bg-green-100 p-3 rounded-full">
                                    <i data-lucide="activity" class="w-6 h-6 text-green-600"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Carte Comptes -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Nouveaux Comptes</p>
                                    <h3 class="text-2xl font-bold mt-2">89</h3>
                                    <p class="text-red-500 text-sm mt-2">
                                        <i data-lucide="trending-down" class="w-4 h-4 inline"></i>
                                        -2.7%
                                    </p>
                                </div>
                                <div class="bg-purple-100 p-3 rounded-full">
                                    <i data-lucide="credit-card" class="w-6 h-6 text-purple-600"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Carte Revenus -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Revenus Mensuels</p>
                                    <h3 class="text-2xl font-bold mt-2">€123,456</h3>
                                    <p class="text-green-500 text-sm mt-2">
                                        <i data-lucide="trending-up" class="w-4 h-4 inline"></i>
                                        +15.2%
                                    </p>
                                </div>
                                <div class="bg-yellow-100 p-3 rounded-full">
                                    <i data-lucide="dollar-sign" class="w-6 h-6 text-yellow-600"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Rapides -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Actions Rapides</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Nouveau Client -->
                            <a href="clients.php" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex items-center space-x-4">
                                    <div class="bg-blue-100 p-3 rounded-full">
                                        <i data-lucide="user-plus" class="w-6 h-6 text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Nouveau Client</h4>
                                        <p class="text-sm text-gray-500">Ajouter un client</p>
                                    </div>
                                </div>
                            </a>

                            <!-- Nouvelle Transaction -->
                            <a href="transactions.html" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex items-center space-x-4">
                                    <div class="bg-green-100 p-3 rounded-full">
                                        <i data-lucide="repeat" class="w-6 h-6 text-green-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Transaction</h4>
                                        <p class="text-sm text-gray-500">Nouvelle transaction</p>
                                    </div>
                                </div>
                            </a>

                            <!-- Nouveau Compte -->
                            <a href="clients.php" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex items-center space-x-4">
                                    <div class="bg-purple-100 p-3 rounded-full">
                                        <i data-lucide="folder-plus" class="w-6 h-6 text-purple-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Compte</h4>
                                        <p class="text-sm text-gray-500">Créer un compte</p>
                                    </div>
                                </div>
                            </a>

                            <!-- Rapports -->
                            <a href="#" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex items-center space-x-4">
                                    <div class="bg-yellow-100 p-3 rounded-full">
                                        <i data-lucide="file-text" class="w-6 h-6 text-yellow-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Rapports</h4>
                                        <p class="text-sm text-gray-500">Voir les rapports</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlay pour mobile -->
        <div 
        id="sidebarOverlay"
        onclick="toggleSidebar()"
        class="fixed inset-0 bg-black bg-opacity-50 lg:hidden hidden z-20"
    ></div>

    <!-- Scripts -->
    <script>
        // Initialisation des icônes
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
    </script>
</body>
</html>