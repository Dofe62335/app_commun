let presenceChart = null;

document.addEventListener("DOMContentLoaded", () => {
  updatePresence();

  // Rechargement du graphe quand on change la classe
  const select = document.getElementById("class-select");
  if (select) {
    select.addEventListener("change", updatePresence);
  }
});

function updatePresence() {
  const classes = { G3: 20, G4: 18, G5: 22 };
  const selected = document.getElementById("class-select").value;
  const max = classes[selected];

  fetch("/volpe-site/app/views/prof/presence_data.php")
    .then(res => res.json())
    .then(data => {
      const current = data.latest || 0;
      document.getElementById("presence-display").innerText = `Présence actuelle : ${current}/${max}`;
      drawPresenceChart(current, max);
    });
}

function drawPresenceChart(current, max) {
  const ctx = document.getElementById('presenceChart').getContext('2d');

  // ❌ Supprimer l'ancien graphe s’il existe
  if (presenceChart) {
    presenceChart.destroy();
  }

  // ✅ Créer un nouveau graphe avec les nouvelles données
  presenceChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Présents', 'Absents'],
      datasets: [{
        data: [current, max - current],
        backgroundColor: ['#2e8b57', '#ccc']
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'bottom' }
      },
      cutout: '70%' // option esthétique
    }
  });
}
