var collumn = [];

refresh("");
var datatable = 0;

function refresh(append) {
    document.getElementById("data-kosong").setAttribute("hidden", true);
    document.getElementById("card-table").setAttribute("hidden", true);
    document.getElementById("formfilter").setAttribute("hidden", true);

    var url = document.getElementById("main-content").getAttribute("url");
    var requestOptions = {
        method: "GET",
        redirect: "follow",
    };

    fetch(url + append, requestOptions)
        .then((response) => response.text())
        .then((result) => {
            var dataAPI = JSON.parse(result);
            if (
                typeof dataAPI.eror == "undefined" &&
                dataAPI.candidates == ""
            ) {
                document.getElementById("formfilter").removeAttribute("hidden");
                swal(
                    "Data Kosong",
                    "Pastikan anda telah menentukan filter pada kolom yang berisi angka",
                    "error"
                );
            } else if (typeof dataAPI.eror == "undefined") {
                document.getElementById("card-table").removeAttribute("hidden");
                document.getElementById("formfilter").removeAttribute("hidden");
                $("#namedkey").empty();
                refreshCollumn();

                let tag = null;
                //select tahun
                var tahun_template = dataAPI["tahun_template"];
                $("#periode").empty();
                tag += "<option selected hidden>Pilih Tahun Terdaftar</option>";
                for (let index = 0; index < tahun_template.length; index++) {
                    tag += "<option >" + tahun_template[index] + "</option>";
                }
                $("#periode").append(tag);

                //select kolom
                tag = null;
                tag += "<option selected hidden value=''>Pilih Kolom</option>";
                $("#kolom").empty();
                dataAPI.kolom.forEach((element) => {
                    tag += "<option>" + element + "</option>";
                });
                $("#kolom").append(tag);

                //select tahun
                tag = null;
                var listtahun = dataAPI["list_tahun"];
                $("#tahun_terdaftar").empty();
                for (let index = 0; index < listtahun.length; index++) {
                    tag += "<option >" + listtahun[index] + "</option>";
                }
                $("#tahun_terdaftar").append(tag);
                document.getElementById("tahun_terdaftar").value =
                    dataAPI.status.tahun;
                document.getElementById("tahunperiode").value =
                    dataAPI.status.tahun;

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
                        if (dataAPI["candidates"][index][element] != "") {
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
                document.getElementById("alert-text").innerHTML = dataAPI.eror;
                document
                    .getElementById("data-kosong")
                    .removeAttribute("hidden");
                swal("Data Kosong", dataAPI.eror, "warning");
            }
        })
        .catch((error) => {
            swal("Error", "Terjadi Kesalahan", "error");
        });
}

function gantiTahun() {
    var tahun_terdaftar = document.getElementById("tahun_terdaftar").value;
    refresh("?tahun=" + tahun_terdaftar);
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

function kirimFilter() {
    var tahun_terdaftar = document.getElementById("tahun_terdaftar").value;
    var link = "?tahun=" + tahun_terdaftar;

    for (let x = 0; x < collumn.length; x++) {
        for (let y = 0; y < collumn[x].length; y++) {
            link += "&filter[" + x + "][" + y + "]=" + collumn[x][y];
        }
    }
    refresh(link);
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
                console.log(url, taun);
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
                alert("null");
            }
        })
        .catch((error) => {
            alert(error);
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
            var tahun_terdaftar =
                document.getElementById("tahun_terdaftar").value;

            var formdata = new FormData();
            formdata.append("tahun", tahun_terdaftar);
            for (let x = 0; x < collumn.length; x++) {
                for (let y = 0; y < collumn[x].length; y++) {
                    formdata.append(
                        "filter[" + x + "][" + y + "]",
                        collumn[x][y]
                    );
                }
            }
            console.log(url);
            var requestOptions = {
                method: "POST",
                body: formdata,
                redirect: "follow",
            };

            fetch(url, requestOptions)
                .then((response) => response.text())
                .then((result) => {
                    console.log(result);
                    var result = JSON.parse(result);
                    swal("Success", result.status, "success");
                    window.location.replace(result.redirect);
                })
                .catch((error) => {
                    console.log(error);
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
    gantiTahun();
}
