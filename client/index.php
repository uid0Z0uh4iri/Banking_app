<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Banque - Tableau de bord</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg hidden md:block" id="sidebar">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-blue-600">Ma Banque</h1>
            </div>
            <nav class="mt-6">
                <a href="index.html" class="flex items-center w-full p-4 space-x-3 bg-blue-50 text-blue-600 border-r-4 border-blue-600">
                    <i data-lucide="wallet"></i>
                    <span>Tableau de bord</span>
                </a>
                <a href="compte.html" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="credit-card"></i>
                    <span>Mes comptes</span>
                </a>
                <a href="virement.html" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="send"></i>
                    <span>Virements</span>
                </a>
                <a href="benificier.html" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="users"></i>
                    <span>Bénéficiaires</span>
                </a>
                <a href="historique.html" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="history"></i>
                    <span>Historique</span>
                </a>
                <a href="profeil.html" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="user"></i>
                    <span>Profil</span>
                </a>
            </nav>
        </div>

        <!-- Toggle Button for Mobile -->
        <button class="md:hidden p-4 text-gray-600 hover:text-blue-600" id="toggleSidebar">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>

        <!-- Add this button for desktop view -->
        <button class="hidden md:block p-4 text-gray-600 hover:text-blue-600" id="toggleSidebarDesktop">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>

        <!-- Main Content -->
        <div class="flex-1 p-4 md:p-8">
            <h2 class="text-2xl font-bold text-gray-800">Tableau de bord</h2>
            
            <!-- Account Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700">Compte Courant</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2">€2,450.50</p>
                    <p class="text-sm text-gray-500 mt-1">N° FR76 1234 5678 9012</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700">Compte Épargne</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2">€15,750.20</p>
                    <p class="text-sm text-gray-500 mt-1">N° FR76 9876 5432 1098</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
                <button class="flex items-center justify-center space-x-2 p-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i data-lucide="send" class="w-5 h-5"></i>
                    <span>Nouveau virement</span>
                </button>
                <button class="flex items-center justify-center space-x-2 p-4 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    <span>Alimenter compte</span>
                </button>
                <button class="flex items-center justify-center space-x-2 p-4 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span>Gérer bénéficiaires</span>
                </button>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white rounded-lg shadow mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700">Transactions récentes</h3>
                    <div class="mt-4 space-y-4">
                        <div class="flex items-center justify-between p-4 border-b">
                            <div>
                                <p class="font-medium">Virement à John Doe</p>
                                <p class="text-sm text-gray-500">12 janvier 2025</p>
                            </div>
                            <p class="text-red-600 font-medium">-€125.00</p>
                        </div>
                        <div class="flex items-center justify-between p-4 border-b">
                            <div>
                                <p class="font-medium">Virement reçu de Marie Martin</p>
                                <p class="text-sm text-gray-500">11 janvier 2025</p>
                            </div>
                            <p class="text-green-600 font-medium">+€350.00</p>
                        </div>
                        <div class="flex items-center justify-between p-4 border-b">
                            <div>
                                <p class="font-medium">Paiement Carte Bancaire</p>
                                <p class="text-sm text-gray-500">10 janvier 2025</p>
                            </div>
                            <p class="text-red-600 font-medium">-€42.50</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Toggle Button for Mobile -->
<button class="md:hidden p-4 text-gray-600 hover:text-blue-600" id="toggleSidebar">
    <i data-lucide="menu" class="w-6 h-6"></i>
</button>

<!-- Add this button for desktop view -->
<button class="hidden md:block p-4 text-gray-600 hover:text-blue-600" id="toggleSidebarDesktop">
    <i data-lucide="menu" class="w-6 h-6"></i>
</button>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
        const toggleButton = document.getElementById('toggleSidebar');
        const toggleButtonDesktop = document.getElementById('toggleSidebarDesktop');
        const sidebar = document.getElementById('sidebar');

        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });

        toggleButtonDesktop.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });
    });
</script>
</body>
</html>