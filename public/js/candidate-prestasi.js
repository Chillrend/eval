var collumn = [];
var dataAPI;
var datatable = 0;
refresh("");

function refresh(append) {
    document.getElementById("preview").setAttribute("hidden", true);

    var url = document.getElementById("main-content").getAttribute("url");
    var requestOptions = {
        method: "GET",
        redirect: "follow",
    };

    fetch(url + append, requestOptions)
        .then((response) => response.text())
        .then((result) => {
            dataAPI = JSON.parse(result);
            if (typeof dataAPI.error == "undefined") {
                console.log(dataAPI);

                //pembersihan data
                $("#namedkey").empty();

                //tahun tempalate
                let tag = null;
                $("#periode").empty();
                var listtahun = dataAPI["tahun_template"];
                for (let index = 0; index < listtahun.length; index++) {
                    tag += "<option >" + listtahun[index] + "</option>";
                }
                $("#periode").append(
                    "<option selected hidden>Tahun Tabel</option>"
                );
                $("#periode").append(tag);

                //select tahun
                tag = null;
                var listtahun = dataAPI["tahun_import"];
                $("#tahun_terdaftar").empty();
                for (let index = 0; index < listtahun.length; index++) {
                    tag += "<option >" + listtahun[index] + "</option>";
                }
                $("#tahun_terdaftar").append(tag);
                document.getElementById("tahun_terdaftar").value =
                    dataAPI.status.tahun;

                $("#table-responsive").empty();
                tag = '<div class="table-responsive">';
                tag +=
                    '<table class="table table-striped" id="table-candidatepres" style="width: 100%">';
                tag += '<thead><tr id="head-col"></tr></thead>';
                tag += '<tbody id="table-content"></tbody></table>';
                console.log(tag);
                $("#table-responsive").append(tag);

                //pengisian kolom
                $("#head-col").append("<th scope='col'>#</th>");
                $("#head-col").append("<th scope='col'>Periode</th>");
                for (let i = 0; i < dataAPI.kolom[0].length; i++) {
                    let tag =
                        "<th scope='col'>" + dataAPI.kolom[0][i] + "</th>";
                    $("#head-col").append(tag);
                }

                //pengisian isi table
                for (
                    let index = 0;
                    index < dataAPI.candidates.length;
                    index++
                ) {
                    tags = "<tr>";
                    tags += "<td scope='col'>" + (index + 1) + "</td>";
                    tags +=
                        "<td scope='col'>" +
                        dataAPI.candidates[index].periode +
                        "</td>";
                    for (let i = 0; i < dataAPI.kolom[0].length; i++) {
                        a = dataAPI.kolom[0][i];
                        if (dataAPI.candidates[index][String(a)] == "") {
                            tags += "<td scope='col'>-</td>";
                        } else {
                            tags +=
                                "<td scope='col'>" +
                                dataAPI.candidates[index][String(a)] +
                                "</td>";
                        }
                    }
                    tags += "</tr>";
                    $("#table-content").append(tags);
                }

                //ngebuka table hidden
                document.getElementById("preview").removeAttribute("hidden");
                $("#table-candidatepres").DataTable({
                    responsive: true,
                    pageLength: 10,
                    autoWidth: false,
                    // order: [[1, "desc"]],
                });
            }
        })
        .catch((error) => console.log("error", error));
}

function deleteCollumn(id) {
    collumn.splice(id, 1);
    addCollumn();
}

function gantiTahun() {
    var tahun_terdaftar = document.getElementById("tahun_terdaftar").value;
    refresh("?tahun=" + tahun_terdaftar);
}

function addCollumn() {
    if (document.getElementById("nameCollumn").value != "") {
        collumn[collumn.length] = document.getElementById("nameCollumn").value;
    }
    $("#namedkey").empty();
    for (let index = 0; index < collumn.length; index++) {
        let tag =
            '<div class="input-group mb-3" id="collumn-' +
            index +
            '"><input type="text" class="form-control" id="collumn-' +
            index +
            '" name="collumn-' +
            index +
            '" value="' +
            collumn[index] +
            '" readonly><div class="input-group-append" id="collumn-' +
            index +
            '"><button class="btn btn-outline-danger" type="button" onclick="deleteCollumn(' +
            index +
            ')"><i class="fa-solid fa-times fa-lg"></i> Hapus</button></div></div>';
        $("#namedkey").append(tag);
    }
    document.getElementById("nameCollumn").value = "";
    document.getElementById("banyakCollumn").value = collumn.length;
}

function myFunction() {
    var taun = document.getElementById("periode").value;
    var url = document.getElementById("tambahCriteria").getAttribute("url");
    var urldel = document
        .getElementById("tambahCriteria")
        .getAttribute("url-del");

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
                collumn = coba.criteria;
                $("#namedkey").empty();
                for (let index = 0; index < collumn.length; index++) {
                    let tag =
                        '<div class="input-group mb-3" id="collumn-' +
                        index +
                        '"><input type="text" class="form-control" id="collumn-' +
                        index +
                        '" name="collumn-' +
                        index +
                        '" value="' +
                        collumn[index] +
                        '" readonly><div class="input-group-append" id="collumn-' +
                        index +
                        '"><button class="btn btn-outline-danger" type="button" url="' +
                        urldel +
                        '" onclick="deleteCollumn(' +
                        index +
                        ')"><i class="fa-solid fa-times fa-lg"></i> Hapus</button></div></div>';
                    $("#namedkey").append(tag);
                }
                document.getElementById("banyakCollumn").value = collumn.length;
            } else {
                alert("null");
            }
        })
        .catch((error) => {
            alert(erorr);
        });
}

function insert() {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Proses ini tidak dibatalkan. Pastikan data sudah benar! ",
        icon: "warning",
        buttons: true,
    }).then((saveData) => {
        if (saveData) {
            var url = document
                .getElementById("form-candidate")
                .getAttribute("url");
            var tahunperiode = document.getElementById("tahunperiode").value;
            var fileInput = document.getElementById("customFile");
            // console.log(fileInput.files[0]);

            var formdata = new FormData();
            formdata.append("tahunperiode", tahunperiode);
            formdata.append("excel", fileInput.files[0]);
            for (let index = 0; index < collumn.length; index++) {
                formdata.append("collumn[" + index + "]", collumn[index]);
            }
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
                    if (result.status) {
                        swal("Success", result.status, "success");
                        refresh("");
                    } else {
                        swal("Error", result.error, "error");
                    }
                })
                .catch((error) => {
                    swal("Error", "Terjadi Kesalahan", "error");
                });
        } else {
            swal("Proses import dibatalkan", {
                timer: 3000,
            });
        }
    });
}

function cancel() {
    var tahun_terdaftar = document.getElementById("tahun_terdaftar").value;
    swal({
        title: "Hapus Data Tahun " + tahun_terdaftar + " ?",
        text: "Data yang telah dihapus tidak dapat dikembalikan",
        icon: "warning",
        buttons: true,
    }).then((saveData) => {
        if (saveData) {
            var url = document.getElementById("cancelbtn").getAttribute("url");

            var formdata = new FormData();
            formdata.append("tahun", tahun_terdaftar);

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
                    if (result.status) {
                        swal("Success", result.status, "success");
                        refresh("");
                    } else {
                        swal("Error", result.error, "error");
                    }
                })
                .catch((error) => {
                    swal("Error", "Terjadi Kesalahan", "error");
                });
        } else {
            swal("Proses import dibatalkan", {
                timer: 3000,
            });
        }
    });
}

function save() {
    var tahun_terdaftar = document.getElementById("tahun_terdaftar").value;
    swal({
        title: "Simpan Data Tahun " + tahun_terdaftar + " ?",
        text: "Proses ini tidak bisa diundur. Pastikan data telah benar!",
        icon: "warning",
        buttons: true,
    }).then((saveData) => {
        if (saveData) {
            var url = document.getElementById("savebtn").getAttribute("url");

            var formdata = new FormData();
            formdata.append("tahun", tahun_terdaftar);

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
                    if (result.status) {
                        swal("Success", result.status, "success");
                        refresh("");
                    } else {
                        swal("Error", result.error, "error");
                    }
                })
                .catch((error) => {
                    swal("Error", "Terjadi Kesalahan", "error");
                });
        } else {
            swal("Proses import dibatalkan", {
                timer: 3000,
            });
        }
    });
}
