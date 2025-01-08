
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
    document.querySelector('.burger-button').addEventListener('click', function(e) {
        e.stopPropagation();
        const menu = document.querySelector('.menu-options');
        menu.classList.toggle('hidden');
    });

    // Fermer le menu si on clique en dehors
    document.addEventListener('click', function(e) {
        const menu = document.querySelector('.menu-options');
        if (!menu.contains(e.target) && !document.querySelector('.burger-button').contains(e.target)) {
            menu.classList.add('hidden');
        }
    });