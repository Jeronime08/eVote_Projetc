// main.js — logique front de eVote Bénin
document.addEventListener("DOMContentLoaded", () => {

    // Confirmation avant vote
    const buttonsVote = document.querySelectorAll(".btn-primary");
    buttonsVote.forEach(btn => {
        btn.addEventListener("click", () => {
            if (confirm("Êtes-vous sûr de votre choix ? Ce vote est définitif.")) {
                alert("✅ Votre vote a été enregistré avec succès !");
                btn.disabled = true;
                btn.style.opacity = "0.6";
            }
        });
    });

    // Chart.js (résultats)
    if (document.getElementById("barChart")) {
        const ctxBar = document.getElementById("barChart");
        const barChart = new Chart(ctxBar, {
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
        const pieChart = new Chart(ctxPie, {
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
});
