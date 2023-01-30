refresh("");

function refresh(append) {
    var url = document.getElementById("main-content").getAttribute("url");
    console.log(url);
    var requestOptions = {
        method: "GET",
        redirect: "follow",
    };

    fetch(url + append, requestOptions)
        .then((response) => response.text())
        .then((result) => {
            var data = JSON.parse(result);

            document.getElementById("total-candidates").innerHTML = data.total;
            document.getElementById("total-prestasi").innerHTML =
                data.pres.import;
            document.getElementById("total-tes").innerHTML = data.tes.import;
            document.getElementById("total-mandiri").innerHTML =
                data.mandiri.import;

            //select tahun
            $("#tahun_terdaftar").empty();
            data.tahun.list.forEach((element) => {
                let tag = "<option >" + element + "</option>";
                $("#tahun_terdaftar").append(tag);
            });
            document.getElementById("tahun_terdaftar").value =
                data.tahun.status;

            console.log(data);

            $("#chart-statistik").empty();
            $("#chart-statistik").append('<canvas id="myChart"></canvas>');

            new Chart("myChart", {
                type: "bar",
                data: {
                    labels: [
                        "Seleksi Prestasi",
                        "Seleksi Tes",
                        "Seleksi Mandiri",
                    ],
                    datasets: [
                        {
                            label: "Data Masuk",
                            data: [
                                data.pres.import,
                                data.tes.import,
                                data.mandiri.import,
                            ],
                            backgroundColor: "rgba(255, 99, 132, 0.7)",
                            borderWidth: 1,
                        },
                        {
                            label: "Penyaringan",
                            data: [
                                data.pres.filter,
                                data.tes.filter,
                                data.mandiri.filter,
                            ],
                            backgroundColor: "rgba(255, 159, 64, 0.7)",
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            labels: {
                                fontFamily: '"Nunito", "Segoe UI", "arial"',
                                fontSize: 13,
                                fontStyle: "normal",
                                padding: 0,
                            },
                            position: "top",
                            onClick() {},
                        },
                        title: {
                            display: true,
                            text: "Statistika Pendaftar",
                        },
                    },
                },
            });

            var backColor = [
                "rgba(255, 255, 255, 1)",
                "rgba(103, 119, 239, 0.7)",
                "rgba(255, 255, 255, 1)",
                "rgba(252, 84, 75, 0.7)",
                "rgba(255, 255, 255, 1)",
                "rgba(255, 164, 38, 0.7)",
                "rgba(255, 255, 255, 1)",
                "rgba(71, 195, 99, 0.7)",
            ];

            $("#chart-progress").empty();
            $("#chart-progress").append('<canvas id="chartProgress"></canvas>');
            new Chart("chartProgress", {
                type: "pie",
                data: {
                    labels: [
                        "",
                        "Keseluruhan",
                        "",
                        "Tahap Prestasi",
                        "",
                        "Tahap Tes",
                        "",
                        "Tahap Mandri",
                    ],
                    datasets: [
                        {
                            label: "Keseluruhan",
                            backgroundColor: backColor,
                            data: [
                                100 - data.status.total,
                                data.status.total,
                                0,
                                0,
                                0,
                                0,
                                0,
                                0,
                            ],
                        },
                        {
                            label: "Tahap Prestasi",
                            backgroundColor: backColor,
                            data: [
                                0,
                                0,
                                100 - data.status.pres,
                                data.status.pres,
                                0,
                                0,
                                0,
                                0,
                            ],
                        },
                        {
                            label: "Tahap Tes",
                            backgroundColor: backColor,
                            data: [
                                0,
                                0,
                                0,
                                0,
                                100 - data.status.tes,
                                data.status.tes,
                                0,
                                0,
                            ],
                        },
                        {
                            label: "Tahap Mandri",
                            backgroundColor: backColor,
                            data: [
                                0,
                                0,
                                0,
                                0,
                                0,
                                0,
                                100 - data.status.mandiri,
                                data.status.mandiri,
                            ],
                        },
                        {
                            data: [],
                        },
                    ],
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                    legend: {
                        labels: {
                            fontFamily: '"Nunito", "Segoe UI", "arial"',
                            fontSize: 13,
                            fontStyle: "normal",
                            padding: 0,
                        },
                        position: "right",
                        onClick() {},
                    },
                    tooltips: {
                        mode: "point",
                        callbacks: {
                            label: function (tooltipItem, data) {
                                if (
                                    tooltipItem.index % 2 !== 0 &&
                                    tooltipItem.index !== 0
                                ) {
                                    var label =
                                        data.datasets[tooltipItem.datasetIndex]
                                            .label;
                                } else {
                                    var label =
                                        "Sisa Progress " +
                                        data.datasets[tooltipItem.datasetIndex]
                                            .label;
                                }
                                label += ": ";
                                num =
                                    data.datasets[tooltipItem.datasetIndex]
                                        .data[tooltipItem.index];
                                label +=
                                    Math.round((num + Number.EPSILON) * 100) /
                                        100 +
                                    "%";

                                return label;
                            },
                        },
                    },
                },
            });
        })
        .catch((error) => console.log("error", error));
}

function gantiTahun() {
    var tahun_terdaftar = document.getElementById("tahun_terdaftar").value;
    refresh("?tahun=" + tahun_terdaftar);
}
