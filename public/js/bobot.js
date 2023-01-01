var fullData;
var kolom;
var datatable = 0;
refresh("", "", "");

function refresh() {
    document.getElementById("datatable").setAttribute("hidden", true);
    document.getElementById("form-bobot").setAttribute("hidden", true);

    var url = document.getElementById("main-content").getAttribute("url");

    var requestOptions = {
        method: "GET",
        redirect: "follow",
    };

    fetch(url, requestOptions)
        .then((response) => response.text())
        .then((result) => {
            var tahun = JSON.parse(result);
            $("#tahun_terdaftar").empty();
            let tag = "<option selected hidden disabled>Pilih Tahun</option>";
            $("#tahun_terdaftar").append(tag);
            tahun.tahun.forEach((element) => {
                let tag = "<option >" + element + "</option>";
                $("#tahun_terdaftar").append(tag);
            });
        })
        .catch((error) => console.log("error", error));
}

function sendTahun() {
    var url = document.getElementById("tahun_terdaftar").getAttribute("url");

    var formdata = new FormData();
    formdata.append("tahun", document.getElementById("tahun_terdaftar").value);

    var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
    };

    fetch(url, requestOptions)
        .then((response) => response.text())
        .then((result) => {
            var pend = JSON.parse(result);

            document.getElementById("pendidikan").removeAttribute("disabled");
            document.getElementById("datatable").setAttribute("hidden", true);
            document.getElementById("form-bobot").setAttribute("hidden", true);

            $("#pendidikan").empty();
            let tag =
                "<option selected hidden disabled>Pilih Pendidikan</option>";
            $("#pendidikan").append(tag);
            pend.pendidikan.forEach((element) => {
                let tag = "<option >" + element + "</option>";
                $("#pendidikan").append(tag);
            });
        })
        .catch((error) => console.log("error", error));
}

function sendPend() {
    table();
    document.getElementById("datatable").removeAttribute("hidden");
    document.getElementById("form-bobot").setAttribute("hidden", true);
}

function table() {
    var url = document.getElementById("pendidikan").getAttribute("url");

    var formdata = new FormData();
    formdata.append("tahun", document.getElementById("tahun_terdaftar").value);
    formdata.append("pendidikan", document.getElementById("pendidikan").value);

    var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
    };
    fetch(url, requestOptions)
        .then((response) => response.text())
        .then((result) => {
            dataAPI = JSON.parse(result);
            if (dataAPI.criteria != null) {
                fullData = dataAPI.criteria;
            } else {
                fullData = null;
            }

            kolom = dataAPI.kolom;
            $("#kolom").empty();
            let tag = "<option selected hidden>Pilih Kolom</option>";
            kolom.forEach((element) => {
                tag += "<option>" + element + "</option>";
            });
            $("#kolom").append(tag);

            if (datatable != 0) {
                $("#tbl-bobot").dataTable().fnClearTable();
                $("#tbl-bobot").dataTable().fnAddData(fullData);
            } else {
                datatable++;
                $("#tbl-bobot").DataTable({
                    data: fullData,
                    responsive: true,
                    pageLength: 10,
                    autoWidth: false,
                    columns: [
                        {
                            data: null,
                            render: function (data, type, full, meta) {
                                return meta.row + 1;
                            },
                        },
                        {
                            data: "kolom",
                        },
                        {
                            data: null,
                            render: function (data, type, full, meta) {
                                if (full.nilai) {
                                    return full.nilai;
                                } else {
                                    return "-";
                                }
                            },
                        },
                        {
                            data: null,
                            render: function (data, type, full, meta) {
                                let a;
                                switch (full.tipe) {
                                    case "prioritas":
                                        a =
                                            "<span class='badge badge-primary'>" +
                                            full.tipe +
                                            "</span>";
                                        break;

                                    case "pembobotan":
                                        a =
                                            "<span class='badge badge-success'>" +
                                            full.bobot +
                                            "</span>";
                                        break;

                                    case "tambahan":
                                        a =
                                            "<span class='badge badge-info'>" +
                                            full.tipe +
                                            "</span>";
                                        break;
                                }
                                return a;
                            },
                            orderable: false,
                        },
                        {
                            data: null,
                            render: function (data, type, full, meta) {
                                let tag =
                                    '<div class="btn-group m-1" role="group" aria-label="Basic example">';
                                tag +=
                                    '<button class="btn btn-sm btn-icon btn-warning" id="editBtn" onclick="editBtn(' +
                                    meta.row +
                                    ')" ><i class="fas fa-edit"></i> Edit</button>';
                                tag +=
                                    '<button class="btn btn-sm btn-icon btn-danger" id="editBtn" onclick="deleteBtn(' +
                                    full.id +
                                    ')" ><i class="fas fa-edit"></i> Delete</button>';

                                tag += "</div>";

                                return tag;
                            },
                            orderable: false,
                        },
                    ],
                });
            }
        })
        .catch((error) => {
            console.log(error);
            swal("Error", "Terjadi Kesalahan", "error");
        });
}

function sendKolom() {
    console.log("sd");
    var url = document.getElementById("kolom").getAttribute("url");

    var formdata = new FormData();
    formdata.append("tahun", document.getElementById("tahun_terdaftar").value);
    formdata.append("pendidikan", document.getElementById("pendidikan").value);
    formdata.append("kolom", document.getElementById("kolom").value);
    var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
    };

    fetch(url, requestOptions)
        .then((response) => response.text())
        .then((result) => {
            dataAPI = JSON.parse(result);
            nilai = dataAPI.nilai;

            $("#nilai").empty();
            let tag = "<option selected hidden>Pilih Nilai</option>";
            $("#nilai").append(tag);
            nilai.forEach((element) => {
                let tag = "<option >" + element + "</option>";
                $("#nilai").append(tag);
            });
        })
        .catch((error) => console.log("error", error));
}

function sendTipe() {
    switch (document.querySelector('input[name="tipe"]:checked').value) {
        case "prioritas":
            document.getElementById("nilai").removeAttribute("disabled");
            document.getElementById("bobot").setAttribute("disabled", true);
            break;

        case "pembobotan":
            document.getElementById("nilai").removeAttribute("disabled");
            document.getElementById("bobot").removeAttribute("disabled");
            break;

        case "tambahan":
            document.getElementById("nilai").setAttribute("disabled", true);
            document.getElementById("bobot").setAttribute("disabled", true);
            break;

        default:
            break;
    }
}

function showForm() {
    document.getElementById("form-bobot").removeAttribute("hidden");
    document.getElementById("form-bobot").focus();
    document.getElementById("tambahanbtn").checked = true;
    document
        .querySelectorAll("input[name='tipe']")
        .forEach((el) => el.removeAttribute("disabled"));
}

function tutup() {
    document.getElementById("kolom").value = "Pilih Kolom";

    document.getElementById("tambahanbtn").checked = true;
    document
        .querySelectorAll("input[name='tipe']")
        .forEach((el) => el.setAttribute("disabled", true));

    $("#nilai").empty();
    let tag = "<option selected hidden>Pilih Nilai</option>";
    $("#nilai").append(tag);

    document.getElementById("nilai").setAttribute("disabled", true);
    document.getElementById("bobot").setAttribute("disabled", true);

    document.getElementById("form-bobot").setAttribute("hidden", true);
}

function addCriteria() {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Pastikan data sudah benar! ",
        icon: "warning",
        buttons: true,
    }).then((saveData) => {
        if (saveData) {
            var url = document.getElementById("submitBtn").getAttribute("url");

            var kolominput = document.getElementById("kolom").value;
            var tipe = document.querySelector(
                'input[name="tipe"]:checked'
            ).value;
            var nilai = document.getElementById("nilai").value;
            var bobot = document.getElementById("bobot").value;

            let formdata = new FormData();
            if (kolominput == null) {
                swal("Error", "Pastikan kolom telah terisi", "error");
            } else {
                switch (tipe) {
                    case "prioritas":
                        formdata.append("data[1]", nilai);
                        break;

                    case "pembobotan":
                        formdata.append("data[1]", nilai);
                        formdata.append("data[2]", bobot);
                        break;

                    default:
                        break;
                }
            }

            formdata.append(
                "tahun",
                document.getElementById("tahun_terdaftar").value
            );
            formdata.append(
                "pendidikan",
                document.getElementById("pendidikan").value
            );
            formdata.append("pembobotan", tipe);
            formdata.append("data[0]", kolominput);

            var requestOptions = {
                method: "POST",
                body: formdata,
                redirect: "follow",
            };

            fetch(url, requestOptions)
                .then((response) => response.text())
                .then((result) => {
                    dataAPI = JSON.parse(result);
                    if (dataAPI.status) {
                        swal("Success", dataAPI.status, "success");
                        tutup();
                        table();
                    } else if (dataAPI.error) {
                        swal("Error", dataAPI.error, "error");
                    }
                })
                .catch((error) => {
                    console.log(error);
                    swal("Error", "Telah terjadi Error", "error");
                });
        } else {
            swal("Proses Insert dibatalkan", {
                timer: 3000,
            });
        }
    });
}

function deleteBtn(id) {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Proses ini tidak dibatalkan. Pastikan data sudah benar! ",
        icon: "warning",
        buttons: true,
    }).then((saveData) => {
        if (saveData) {
            url = document.getElementById("link-delete").getAttribute("url");

            let formdata = new FormData();
            formdata.append(
                "tahun",
                document.getElementById("tahun_terdaftar").value
            );
            formdata.append(
                "pendidikan",
                document.getElementById("pendidikan").value
            );
            formdata.append("id", id);

            var requestOptions = {
                method: "POST",
                body: formdata,
                redirect: "follow",
            };

            fetch(url, requestOptions)
                .then((response) => response.text())
                .then((result) => {
                    dataAPI = JSON.parse(result);
                    if (dataAPI.status) {
                        swal("Success", dataAPI.status, "success");
                        table();
                    } else if (dataAPI.error) {
                        swal("Error", dataAPI.error, "error");
                    }
                })
                .catch((error) => {
                    console.log(error);
                    swal("Error", "Telah terjadi Error", "error");
                });
        } else {
            swal("Proses Delete dibatalkan", {
                timer: 3000,
            });
        }
    });
}

function editBtn(id) {
    document.getElementById("form-bobot").removeAttribute("hidden");
    document.getElementById("form-bobot").focus();
    document
        .querySelectorAll("input[name='tipe']")
        .forEach((el) => el.removeAttribute("disabled"));

    document.getElementById("id-bobot").value = fullData[id]["id"];

    document.getElementById("kolom").value = fullData[id]["kolom"];
    sendKolom();

    document.querySelectorAll("input[name='tipe']").forEach((el) => {
        if (el.value == fullData[id]["tipe"]) {
            el.checked = true;
        }
    });
    switch (fullData[id]["tipe"]) {
        case "prioritas":
            document.getElementById("nilai").removeAttribute("disabled");
            document.getElementById("bobot").setAttribute("disabled", true);

            document.getElementById("nilai").value = fullData[id]["nilai"];
            break;

        case "pembobotan":
            document.getElementById("nilai").removeAttribute("disabled");
            document.getElementById("bobot").removeAttribute("disabled");

            document.getElementById("nilai").value = fullData[id]["nilai"];
            document.getElementById("bobot").value = fullData[id]["bobot"];

            break;

        case "tambahan":
            document.getElementById("nilai").setAttribute("disabled", true);
            document.getElementById("bobot").setAttribute("disabled", true);
            break;

        default:
            break;
    }
}

function ediitCriteria() {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Proses ini tidak dibatalkan. Pastikan data sudah benar! ",
        icon: "warning",
        buttons: true,
    }).then((saveData) => {
        if (saveData) {
            url = document.getElementById("link-delete").getAttribute("url");

            let formdata = new FormData();
            formdata.append(
                "tahun",
                document.getElementById("tahun_terdaftar").value
            );
            formdata.append(
                "pendidikan",
                document.getElementById("pendidikan").value
            );
            formdata.append("id", id);

            var requestOptions = {
                method: "POST",
                body: formdata,
                redirect: "follow",
            };

            fetch(url, requestOptions)
                .then((response) => response.text())
                .then((result) => {
                    dataAPI = JSON.parse(result);
                    if (dataAPI.status) {
                        swal("Success", dataAPI.status, "success");
                        table();
                    } else if (dataAPI.error) {
                        swal("Error", dataAPI.error, "error");
                    }
                })
                .catch((error) => {
                    console.log(error);
                    swal("Error", "Telah terjadi Error", "error");
                });
        } else {
            swal("Proses Delete dibatalkan", {
                timer: 3000,
            });
        }
    });
}
