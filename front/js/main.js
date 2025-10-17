document.addEventListener("DOMContentLoaded", () => {

    // ✅ Confirmation d'inscription (registerForm)
    const form = document.getElementById('registerForm');
    if (form) {
        form.addEventListener('submit', (e) => {
            if (!confirm("Êtes-vous sûr de vouloir vous inscrire ?")) {
                e.preventDefault(); // annule la soumission si Annuler
            }
            // sinon le formulaire se soumet normalement
        });
    }

    // ✅ Confirmation pour le vote (si boutons de vote)
    const buttonsVote = document.querySelectorAll(".btn-primary.vote-btn");
    buttonsVote.forEach(btn => {
        btn.addEventListener("click", () => {
            if (!confirm("Êtes-vous sûr de votre choix ? Ce vote est définitif.")) {
                return; // annule seulement l'action si Annuler
            }
            alert("✅ Votre vote a été enregistré avec succès !");
        });
    });

    // ✅ Charts (résultats) — si présents
    if (document.getElementById("barChart")) {
        const ctxBar = document.getElementById("barChart");
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Candidat A', 'Candidat B', 'Candidat C'],
                datasets: [{
                    label: 'Nombre de votes',
                    data: [10, 7, 5],
                    backgroundColor: ['#008037', '#0077b6', '#f4a261']
                }]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });
    }

    if (document.getElementById("pieChart")) {
        const ctxPie = document.getElementById("pieChart");
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Candidat A', 'Candidat B', 'Candidat C'],
                datasets: [{
                    data: [10, 7, 5],
                    backgroundColor: ['#008037', '#0077b6', '#f4a261']
                }]
            },
            options: { responsive: true }
        });
    }

}); // ← fin de DOMContentLoaded
