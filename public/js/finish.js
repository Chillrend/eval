refresh();

function refresh() {
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
        .catch((error) => {
            console.log(error);
            swal("Error", "Terjadi Kesalahan", "error");
        });
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
            // document.getElementById("datatable").setAttribute("hidden", true);
            // document.getElementById("form-bobot").setAttribute("hidden", true);

            $("#pendidikan").empty();
            let tag =
                "<option selected hidden disabled>Pilih Pendidikan</option>";
            $("#pendidikan").append(tag);
            pend.pendidikan.forEach((element) => {
                let tag = "<option >" + element + "</option>";
                $("#pendidikan").append(tag);
            });
        })
        .catch((error) => {
            console.log(error);
            swal("Error", "Terjadi Kesalahan", "error");
        });
}

function sendPend() {
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
            var data = JSON.parse(result);
            kolom = ["id", "nama", "jurusan", "alamat"];

            if (data.error) {
                throw data.error;
            }

            for (let i = 0; i < kolom.length; i++) {
                $("#" + kolom[i] + "_pres").empty();
                let tag =
                    "<option selected hidden disabled>Pilih " +
                    kolom[i] +
                    "</option>";
                $("#" + kolom[i] + "_pres").append(tag);
                data.pres.forEach((element) => {
                    let tag = "<option >" + element + "</option>";
                    $("#" + kolom[i] + "_pres").append(tag);
                });
            }

            for (let i = 0; i < kolom.length; i++) {
                $("#" + kolom[i] + "_tes").empty();
                let tag =
                    "<option selected hidden disabled>Pilih " +
                    kolom[i] +
                    "</option>";
                $("#" + kolom[i] + "_tes").append(tag);
                data.tes.forEach((element) => {
                    let tag = "<option >" + element + "</option>";
                    $("#" + kolom[i] + "_tes").append(tag);
                });
            }

            for (let i = 0; i < kolom.length; i++) {
                $("#" + kolom[i] + "_mand").empty();
                let tag =
                    "<option selected hidden disabled>Pilih " +
                    kolom[i] +
                    "</option>";
                $("#" + kolom[i] + "_mand").append(tag);
                data.mand.forEach((element) => {
                    let tag = "<option >" + element + "</option>";
                    $("#" + kolom[i] + "_mand").append(tag);
                });
            }
        })
        .catch((error) => {
            swal("Error", error, "error");
        });
}

function sendKolom(tahap) {
    var url = document.getElementById("link-sendkolom").getAttribute("url");

    switch (tahap) {
        case "pres":
            kolom = [
                document.getElementById("id_pres").value,
                document.getElementById("nama_pres").value,
                document.getElementById("jurusan_pres").value,
                document.getElementById("alamat_pres").value,
            ];
            break;

        case "tes":
            kolom = [
                document.getElementById("id_tes").value,
                document.getElementById("nama_tes").value,
                document.getElementById("jurusan_tes").value,
                document.getElementById("alamat_tes").value,
            ];
            break;

        case "mand":
            kolom = [
                document.getElementById("id_mand").value,
                document.getElementById("nama_mand").value,
                document.getElementById("jurusan_mand").value,
                document.getElementById("alamat_mand").value,
            ];
            break;
    }

    var formdata = new FormData();
    formdata.append("tahun", document.getElementById("tahun_terdaftar").value);
    formdata.append("pendidikan", document.getElementById("pendidikan").value);
    formdata.append("tahap", tahap);
    formdata.append("id", kolom[0]);
    formdata.append("nama", kolom[1]);
    formdata.append("jurusan", kolom[2]);
    formdata.append("alamat", kolom[3]);

    var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
    };

    fetch(url, requestOptions)
        .then((response) => response.text())
        .then((result) => {
            var data = JSON.parse(result);
            console.log(data);

            //deklar kolom table
            taghead = null;
            taghead += '<th scope="col">' + kolom[0] + "</th>";
            taghead += '<th scope="col">' + kolom[1] + "</th>";
            taghead += '<th scope="col">' + kolom[2] + "</th>";
            taghead += '<th scope="col">' + kolom[3] + "</th>";

            tag = null;
            for (let index = 0; index < data.data.length; index++) {
                tag += "<tr>";
                kolom.forEach((element) => {
                    if (typeof data["data"][index][element] != "undefined") {
                        tag += "<td>" + data["data"][index][element] + "</td>";
                    } else {
                        tag += "<td>-</td>";
                    }
                });
                tag += "</tr>";
            }

            switch (tahap) {
                case "pres":
                    $("#table-responsive-pres").empty();
                    temp =
                        '<table class="table table-striped" id="table-pres"><thead><tr id="tbl-header-pres"></tr></thead><tbody id="tbl-body-pres"></tbody></table>';
                    $("#table-responsive-pres").append(temp);
                    $("#tbl-header-pres").append(taghead);
                    $("#tbl-body-pres").append(tag);
                    $("#table-pres").DataTable({
                        scrollX: true,
                        responsive: false,
                        pageLength: 10,
                        autoWidth: false,
                    });
                    break;

                case "tes":
                    $("#table-responsive-tes").empty();
                    temp =
                        '<table class="table table-striped" id="table-tes"><thead><tr id="tbl-header-tes"></tr></thead><tbody id="tbl-body-tes"></tbody></table>';
                    $("#table-responsive-tes").append(temp);
                    $("#tbl-header-tes").append(taghead);
                    $("#tbl-body-tes").append(tag);
                    $("#table-tes").DataTable({
                        scrollX: true,
                        responsive: false,
                        pageLength: 10,
                        autoWidth: false,
                    });
                    break;

                case "mand":
                    $("#table-responsive-mand").empty();
                    temp =
                        '<table class="table table-striped" id="table-mand"><thead><tr id="tbl-header-mand"></tr></thead><tbody id="tbl-body-mand"></tbody></table>';
                    $("#table-responsive-mand").append(temp);
                    $("#tbl-header-mand").append(taghead);
                    $("#tbl-body-mand").append(tag);
                    $("#table-mand").DataTable({
                        scrollX: true,
                        responsive: false,
                        pageLength: 10,
                        autoWidth: false,
                    });
                    break;
            }
        })
        .catch((error) => console.log("error", error));
}
