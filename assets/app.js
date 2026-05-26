// j'attends que la page soit completement chargee avant de faire quoi que ce soit
document.addEventListener('DOMContentLoaded', function () {

    // je fais disparaitre les messages de succes apres 3 secondes
    var alertes = document.querySelectorAll('.alert-success');
    alertes.forEach(function (alerte) {
        setTimeout(function () {
            alerte.style.transition = 'opacity 0.5s';
            alerte.style.opacity = '0';
            // j'enleve completement l'element apres la transition
            setTimeout(function () { alerte.remove(); }, 500);
        }, 3000);
    });

    // je demande une confirmation avant de supprimer quelque chose
    var liensSupprimer = document.querySelectorAll('.lien-supprimer');
    liensSupprimer.forEach(function (lien) {
        lien.addEventListener('click', function (e) {
            // si l'utilisateur clique sur non j'annule la suppression
            if (!confirm('Confirmer la suppression ?')) {
                e.preventDefault();
            }
        });
    });

    // recherche en direct : je filtre le tableau pendant que l'utilisateur tape
    var champRecherche = document.getElementById('recherche-live');
    if (champRecherche) {
        champRecherche.addEventListener('input', function () {
            var terme = this.value.toLowerCase();
            var lignes = document.querySelectorAll('tbody tr');
            lignes.forEach(function (ligne) {
                var texte = ligne.textContent.toLowerCase();
                // j'affiche ou je cache la ligne selon si elle contient le terme
                ligne.style.display = texte.includes(terme) ? '' : 'none';
            });
        });
    }

});
