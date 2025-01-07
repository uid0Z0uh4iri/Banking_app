
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
