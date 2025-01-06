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
                        <!-- ... Cards statistiques existantes ... -->
                    </div>

                    <!-- Grilles responsive -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mt-6">
                        <!-- ... Rest of your content ... -->
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