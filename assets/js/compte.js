
        
// Fonction pour afficher/masquer le modal
function toggleModal(accountType) {
    const modal = document.getElementById('alimenterCompteModal');
    modal.classList.toggle('hidden');
    
    if (accountType) {
        // Présélectionner le compte dans le select
        const selectAccount = modal.querySelector('select');
        selectAccount.value = accountType;
    }
}

// Initialisation : masquer le bloc des informations de carte
document.getElementById('carteInfo').style.display = 'none';

// Gestion de l'affichage des champs de carte
document.querySelectorAll('input[name="paymentMethod"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const carteInfo = document.getElementById('carteInfo');
        carteInfo.style.display = this.value === 'carte' ? 'block' : 'none';
    });
});

// Fonction pour gérer la soumission du formulaire
function submitForm() {
    const form = document.getElementById('alimenterForm');
    if (form.checkValidity()) {
        // Traitement du formulaire ici
        alert('Alimentation effectuée avec succès !');
        toggleModal();
    } else {
        form.reportValidity();
    }
}

// Fermer le modal si on clique en dehors
window.onclick = function(event) {
    const modal = document.getElementById('alimenterCompteModal');
    if (event.target === modal) {
        toggleModal();
    }
}
