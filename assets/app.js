// -------------------------------------------------------
// E-Douane — JavaScript minimaliste
// -------------------------------------------------------

document.addEventListener('DOMContentLoaded', function () {

    // 1. Auto-disparition des messages de succes apres 3 secondes
    var alertes = document.querySelectorAll('.alert-success');
    alertes.forEach(function (alerte) {
        setTimeout(function () {
            alerte.style.transition = 'opacity 0.5s';
            alerte.style.opacity = '0';
            setTimeout(function () { alerte.remove(); }, 500);
        }, 3000);
    });

    // 2. Confirmation avant suppression d'un utilisateur
    var liensSupprimer = document.querySelectorAll('.lien-supprimer');
    liensSupprimer.forEach(function (lien) {
        lien.addEventListener('click', function (e) {
            if (!confirm('Confirmer la suppression de cet utilisateur ?')) {
                e.preventDefault();
            }
        });
    });

    // 3. Live search — filtre le tableau en temps reel pendant la frappe
    var champRecherche = document.getElementById('recherche-live');
    if (champRecherche) {
        champRecherche.addEventListener('input', function () {
            var terme = this.value.toLowerCase();
            var lignes = document.querySelectorAll('tbody tr');
            lignes.forEach(function (ligne) {
                var texte = ligne.textContent.toLowerCase();
                ligne.style.display = texte.includes(terme) ? '' : 'none';
            });
        });
    }

});
