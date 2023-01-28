var collumn = [];

refresh();

function refresh() {
    document.getElementById("formfilter").setAttribute("hidden", true);
    document.getElementById("card-table").setAttribute("hidden", true);

    document.getElementById("pendidikan").setAttribute("disabled", true);
    document.getElementById("pendidikan").value = "Pilih Pendidikan";

    var url = document.getElementById("main-content").getAttribute("url");

    var requestOptions = {
        method: "GET",
        redirect: "follow",
    };
    fetch(url, requestOptions)
        .then((response) => response.text())
        .then((result) => {
            let dataAPI = JSON.parse(result);
            if (dataAPI.list_tahun != "") {
                tahun_template = dataAPI.list_tahun;

                $("#tahun_terdaftar").empty();
                let tag;
                tag += "<option selected hidden>Pilih Tahun Terdaftar</option>";
                for (let index = 0; index < tahun_template.length; index++) {
                    tag += "<option >" + tahun_template[index] + "</option>";
                }

                $("#tahun_terdaftar").append(tag);
                document.getElementById("headfilter").removeAttribute("hidden");
            } else if (dataAPI.list_tahun == "") {
                document
                    .getElementById("headfilter")
                    .setAttribute("hidden", true);
                document
                    .getElementById("data-kosong")
                    .removeAttribute("hidden");
            } else if (dataAPI.error) {
                swal("Error", dataAPI.error, "error");
            }
        })
        .catch((error) => {
            swal("Error", "Terjadi Kesalahan", "error");
        });
}

function getPend() {
    document.getElementById("formfilter").setAttribute("hidden", true);
    document.getElementById("card-table").setAttribute("hidden", true);

    document.getElementById("pendidikan").setAttribute("disabled", true);
    document.getElementById("pendidikan").value = "Pilih Pendidikan";

    var url = document.getElementById("tahun_terdaftar").getAttribute("url");
    var tahun = document.getElementById("tahun_terdaftar").value;

    var formdata = new FormData();
    formdata.append("tahun", tahun);

    var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
    };

    fetch(url, requestOptions)
        .then((response) => response.text())
        .then((result) => {
            let dataAPI = JSON.parse(result);

            if (dataAPI.pendidikan) {
                pend = dataAPI.pendidikan;

                $("#pendidikan").empty();
                let tag;
                tag += "<option selected hidden>Pilih Pendidikan</option>";
                for (let index = 0; index < pend.length; index++) {
                    tag += "<option >" + pend[index] + "</option>";
                }

                $("#pendidikan").append(tag);
                document
                    .getElementById("pendidikan")
                    .removeAttribute("disabled");
            } else if (dataAPI.error) {
                swal("Error", dataAPI.error, "error");
            }
        })
        .catch((error) => {
            swal("Error", "Terjadi Kesalahan", "error");
        });
}

function getKolom() {
    var url = document.getElementById("pendidikan").getAttribute("url");
    var tahun = document.getElementById("tahun_terdaftar").value;
    var pend = document.getElementById("pendidikan").value;

    var formdata = new FormData();
    formdata.append("tahun", tahun);
    formdata.append("pendidikan", pend);

    var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
    };

    fetch(url, requestOptions)
        .then((response) => response.text())
        .then((result) => {
            let dataAPI = JSON.parse(result);

            let tag;
            if (dataAPI.kolom) {
                jur = dataAPI.kolom;
                $("#jurusan").empty();
                tag += "<option selected hidden>Pilih Pendidikan</option>";
                for (let index = 0; index < jur.length; index++) {
                    tag += "<option >" + jur[index] + "</option>";
                }
                $("#jurusan").append(tag);

                kolom = dataAPI.kolom_filter;
                $("#kolom").empty();
                tag = "";
                tag += "<option selected hidden>Pilih Kolom</option>";
                for (let index = 0; index < kolom.length; index++) {
                    tag += "<option >" + kolom[index] + "</option>";
                }
                $("#kolom").append(tag);

                periode = dataAPI.tahun_template;
                $("#periode").empty();
                tag = "";
                tag += "<option selected hidden>Pilih Tahun</option>";
                for (let index = 0; index < periode.length; index++) {
                    tag += "<option >" + periode[index] + "</option>";
                }
                $("#periode").append(tag);

                document.getElementById("formfilter").removeAttribute("hidden");
            } else if (dataAPI.error) {
                swal("Error", dataAPI.error, "error");
            }
        })
        .catch((error) => {
            swal("Error", "Terjadi Kesalahan", "error");
        });
}

function kirimFilter() {
    var tahun = document.getElementById("tahun_terdaftar").value;
    var pend = document.getElementById("pendidikan").value;
    var jurusan = document.getElementById("jurusan").value;
    var url = document.getElementById("btnFilter").getAttribute("url");

    var formdata = new FormData();
    formdata.append("jurusan_kolom", jurusan);
    formdata.append("tahun", tahun);
    formdata.append("pendidikan", pend);

    if (collumn != []) {
        for (let x = 0; x < collumn.length; x++) {
            for (let y = 0; y < collumn[x].length; y++) {
                formdata.append("filter[" + x + "][" + y + "]", collumn[x][y]);
            }
        }
    }

    var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
    };
    console.log(url, requestOptions, collumn);
    fetch(url, requestOptions)
        .then((response) => response.text())
        .then((result) => {
            var dataAPI = JSON.parse(result);
            if (
                typeof dataAPI.error == "undefined" &&
                dataAPI.candidates == ""
            ) {
                document.getElementById("formfilter").removeAttribute("hidden");
                swal(
                    "Data Kosong",
                    "Pastikan anda telah mengatur filter dengan benar",
                    "error"
                );
            } else if (typeof dataAPI.error == "undefined") {
                document.getElementById("card-table").removeAttribute("hidden");
                document.getElementById("formfilter").removeAttribute("hidden");

                refreshCollumn();

                //reset tabel
                $("#table-responsive").empty();
                tag =
                    '<table class="table-hover table display nowrap" id="tbl-filter" style="width: 100%"><thead><tr id="tbl-header"></tr></thead><tbody id="tbl-body"></tbody></table>';
                $("#table-responsive").append(tag);

                //deklar kolom table
                tag = null;
                tag += '<th scope="col">#</th>';
                tag += '<th scope="col">periode</th>';
                dataAPI.kolom.forEach((element) => {
                    tag += '<th scope="col">' + element + "</th>";
                });
                $("#tbl-header").append(tag);

                for (
                    let index = 0;
                    index < dataAPI.candidates.length;
                    index++
                ) {
                    tag = null;
                    tag = "<tr>";
                    tag += "<td>" + (index + 1) + "</td>";
                    tag +=
                        "<td>" +
                        dataAPI["candidates"][index]["periode"] +
                        "</td>";
                    dataAPI.kolom.forEach((element) => {
                        if (
                            typeof dataAPI["candidates"][index][element] !=
                            "undefined"
                        ) {
                            tag +=
                                "<td>" +
                                dataAPI["candidates"][index][element] +
                                "</td>";
                        } else {
                            tag += "<td>-</td>";
                        }
                    });
                    tag += "</tr>";
                    $("#tbl-body").append(tag);
                }

                $("#tbl-filter").DataTable({
                    scrollX: true,
                    responsive: false,
                    pageLength: 10,
                    autoWidth: false,
                });
            } else {
                swal("Data Kosong", dataAPI.error, "warning");
            }
        })
        .catch((error) => {
            console.log(error);
            swal("Error", "Terjadi Kesalahan", "error");
        });
}

function refreshCollumn() {
    $("#namedkey").empty();
    for (let index = 0; index < collumn.length; index++) {
        let tag =
            '<div class="input-group mb-3" id="collumn-' +
            index +
            '">' +
            '<input type="text" class="form-control" id="kolom-' +
            index +
            '" name="kolom-' +
            index +
            '" value="' +
            collumn[index][0] +
            '" readonly>' +
            '<input type="text" class="form-control" id="operator-' +
            index +
            '" name="operator-' +
            index +
            '" value="' +
            collumn[index][1] +
            '" readonly>' +
            '<input type="text" class="form-control" id="nilai-' +
            index +
            '" name="nilai-' +
            index +
            '" value="' +
            collumn[index][2] +
            '" readonly>' +
            '<div class="input-group-append" id="collumn-' +
            index +
            '">' +
            '<button class="btn btn-outline-danger" type="button" onclick="deleteCollumn(' +
            index +
            ')"><i class="fa-solid fa-times fa-lg"></i> Hapus</button>' +
            "</div>" +
            "</div>";
        $("#namedkey").append(tag);
    }
    document.getElementById("banyakCollumn").value = collumn.length;
}

function deleteCollumn(id) {
    collumn.splice(id, 1);
    refreshCollumn();
}

function addCollumn() {
    if (
        document.getElementById("kolom").value != "" &&
        document.getElementById("operator").value != "" &&
        document.getElementById("nilai").value != ""
    ) {
        var kolom = document.getElementById("kolom").value;
        var operator = document.getElementById("operator").value;
        var nilai = document.getElementById("nilai").value;
        collumn.push([kolom, operator, nilai]);
    }
    document.getElementById("kolom").value = "";
    document.getElementById("operator").value = "";
    document.getElementById("nilai").value = "";
    refreshCollumn();
}

function myFunction() {
    var taun = document.getElementById("periode").value;
    var url = document.getElementById("periode").getAttribute("url");
    var formdata = new FormData();
    formdata.append("tahun", taun);

    var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
    };
    fetch(url, requestOptions)
        .then((response) => response.text())
        .then((result) => {
            if (result != null) {
                var coba = JSON.parse(result);
                var hasil = coba.kolom;
                collumn = [];
                hasil.forEach((element) => {
                    collumn.push([
                        element.kolom,
                        element.operator,
                        element.nilai,
                    ]);
                });
                refreshCollumn();
            } else {
                swal("Error", "Terjadi Kesalahan", "error");
            }
        })
        .catch((error) => {
            console.log(error);
            swal("Error", "Terjadi Kesalahan", "error");
        });
}

function saveFilter() {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Proses ini tidak dibatalkan. Pastikan data sudah benar! ",
        icon: "warning",
        buttons: true,
    }).then((saveData) => {
        if (saveData) {
            var url = document.getElementById("saveBtn").getAttribute("url");
            var tahun = document.getElementById("tahun_terdaftar").value;
            var pend = document.getElementById("pendidikan").value;
            var jurusan = document.getElementById("jurusan").value;

            var formdata = new FormData();
            formdata.append("jurusan_kolom", jurusan);
            formdata.append("tahun", tahun);
            formdata.append("pendidikan", pend);
            for (let x = 0; x < collumn.length; x++) {
                for (let y = 0; y < collumn[x].length; y++) {
                    formdata.append(
                        "filter[" + x + "][" + y + "]",
                        collumn[x][y]
                    );
                }
            }

            var requestOptions = {
                method: "POST",
                body: formdata,
                redirect: "follow",
            };

            fetch(url, requestOptions)
                .then((response) => response.text())
                .then((result) => {
                    var result = JSON.parse(result);
                    if (result.status) {
                        swal("Success", result.status, "success");
                        refresh();
                    } else if (result.error) {
                        swal("Error", result.error, "error");
                    }
                })
                .catch((error) => {
                    swal("Error", "Terjadi Kesalahan", "error");
                });
        } else {
            swal("Proses filter dibatalkan", {
                timer: 3000,
            });
        }
    });
}

function cancelFilter() {
    refresh();
}
