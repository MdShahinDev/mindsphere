document.addEventListener("DOMContentLoaded", function () {
    const chartDiv = document.getElementById('chartData');
    const labels = JSON.parse(chartDiv.getAttribute('data-labels'));
    const values = JSON.parse(chartDiv.getAttribute('data-values'));

    const ctx = document.getElementById('efficiencyChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Efficiency Score',
                data: values,
                fill: false,
                borderColor: 'rgba(255, 117, 0, 0.3)',
                backgroundColor: 'rgba(255, 117, 0, 1)',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Efficiency Score'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                }
            }
        }
    });
});
