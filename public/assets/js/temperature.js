document.addEventListener("DOMContentLoaded", () => {
  fetch("/volpe-site/app/views/prof/temperature_data.php")
    .then(res => res.json())
    .then(data => {
      const values = data.map(e => e.temp);
      const labels = data.map(e => e.date);

      const min = Math.min(...values);
      const max = Math.max(...values);
      const avg = (values.reduce((a, b) => a + b, 0) / values.length).toFixed(1);

      document.getElementById("temp-min").innerText = min;
      document.getElementById("temp-max").innerText = max;
      document.getElementById("temp-avg").innerText = avg;

      const ctx = document.getElementById("temperatureChart").getContext("2d");
      new Chart(ctx, {
        type: "line",
        data: {
          labels: labels.reverse(),
          datasets: [{
            label: "Température (°C)",
            data: values.reverse(),
            borderColor: "#2e8b57",
            borderWidth: 2,
            fill: false
          }]
        }
      });
    });
});
