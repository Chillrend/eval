var ctx = document.getElementById("myChart");
var chart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: ["Seleksi Prestasi", "Seleksi Tes", "seleksi Mandiri"],
        datasets: [{
                type: "bar",
                backgroundColor: "rgba(54, 162, 235, 0.2)",
                borderColor: "rgba(54, 162, 235, 1)",
                borderWidth: 1,
                label: "Jumlah Pendaftar",
                data: [60, 49, 72]
            },
            {
                type: "line",
                label: "Program Studi",
                borderWidth: 2,
                backgroundColor: '#6777ef',
                borderColor: '#6777ef',
                data: [25, 13, 30],
                lineTension: 0,
                fill: true
            }
        ]
    }
});
var myChartCircle = new Chart('chartProgress', {
    type: 'doughnut',
    data: {
        datasets: [{
            label: 'Progres Kegiatan',
            percent: 68,
            backgroundColor: ['#5283ff']
        }]
    },
    plugins: [{
            beforeInit: (chart) => {
                const dataset = chart.data.datasets[0];
                chart.data.labels = [dataset.label];
                dataset.data = [dataset.percent, 100 - dataset.percent];
            }
        },
        {
            beforeDraw: (chart) => {
                var width = chart.chart.width,
                    height = chart.chart.height,
                    ctx = chart.chart.ctx;
                ctx.restore();
                var fontSize = (height / 150).toFixed(2);
                ctx.font = fontSize + "em sans-serif";
                ctx.fillStyle = "#9b9b9b";
                ctx.textBaseline = "middle";
                var text = chart.data.datasets[0].percent + "%",
                    textX = Math.round((width - ctx.measureText(text).width) / 2),
                    textY = height / 2;
                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }
    ],
    options: {
        maintainAspectRatio: false,
        cutoutPercentage: 85,
        rotation: Math.PI / 2,
        legend: {
            display: false,
        },
        tooltips: {
            filter: tooltipItem => tooltipItem.index == 0
        }
    }
});