const ctx = document.getElementById('dashboardChart').getContext('2d');
const background = ctx.createLinearGradient(0, 0, 0, 600);
background.addColorStop(0, '#6C64D7');
background.addColorStop(1, '#C850C0');

const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['22/05/22', '23/06/22', '24/07/22', '25/01/22', '26/01/22', '27/01/22', '28/01/22', '29/01/22', '30/01/22'],
        datasets: [{
            label: "Number of visitors",
            data: [401, 500, 450, 325, 450, 550, 375, 530, 280],
            fill: false,
            backgroundColor:
                background,
        }]
    },
    options: {
        plugins: {
            legend: {
                color: "#FFF",
                display:false
            },
        },
        scales: {
            y: {
                ticks: {
                    color: "#FFF",
                    beginAtZero: true
                },
            },
            x: {
                ticks: {
                    color: "#FFF",
                },
            }
        },
    }
});
