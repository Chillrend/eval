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

            $("#pendidikan").empty();
            let tag =
                "<option selected hidden disabled>Pilih Pendidikan</option>";
            $("#pendidikan").append(tag);
            pend.pendidikan.forEach((element) => {
                let tag = "<option >" + element + "</option>";
                $("#pendidikan").append(tag);
            });

            document.getElementById("card-pres").setAttribute("hidden", true);
            document.getElementById("card-tes").setAttribute("hidden", true);
            document.getElementById("card-mand").setAttribute("hidden", true);
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
            console.log(data);
            kolom = ["id", "nama", "jurusan", "alamat"];
            tahap = ["pres", "tes", "mand"];
            if (data.error) {
                throw data.error;
            }

            for (let a = 0; a < tahap.length; a++) {
                if (data[tahap[a]].candidate && data[tahap[a]].kolom) {
                    table(
                        data[tahap[a]].kolom,
                        data[tahap[a]].candidate,
                        tahap[a]
                    );
                    for (let i = 0; i < kolom.length; i++) {
                        $("#" + kolom[i] + "_" + tahap[a]).empty();
                        let tag =
                            "<option selected hidden disabled>" +
                            data[tahap[a]].kolom[i] +
                            "</option>";
                        $("#" + kolom[i] + "_" + tahap[a]).append(tag);
                        document
                            .getElementById(kolom[i] + "_" + tahap[a])
                            .setAttribute("disabled", true);
                    }
                    document
                        .getElementById("searchbtn-" + tahap[a])
                        .setAttribute("hidden", true);
                    document
                        .getElementById("savebtn-" + tahap[a])
                        .setAttribute("hidden", true);
                    document
                        .getElementById("expbtn-" + tahap[a])
                        .removeAttribute("hidden");
                } else {
                    for (let i = 0; i < kolom.length; i++) {
                        $("#" + kolom[i] + "_" + tahap[a]).empty();
                        let tag =
                            "<option selected hidden disabled>Pilih " +
                            kolom[i] +
                            "</option>";
                        $("#" + kolom[i] + "_" + tahap[a]).append(tag);
                        data[tahap[a]].forEach((element) => {
                            let tag = "<option >" + element + "</option>";
                            $("#" + kolom[i] + "_" + tahap[a]).append(tag);
                            document
                                .getElementById(kolom[i] + "_" + tahap[a])
                                .removeAttribute("disabled");
                        });
                        document
                            .getElementById("searchbtn-" + tahap[a])
                            .removeAttribute("hidden");
                        document
                            .getElementById("savebtn-" + tahap[a])
                            .setAttribute("hidden", true);
                        document
                            .getElementById("expbtn-" + tahap[a])
                            .setAttribute("hidden", true);
                    }
                }
            }
            document.getElementById("card-pres").removeAttribute("hidden");
            document.getElementById("card-tes").removeAttribute("hidden");
            document.getElementById("card-mand").removeAttribute("hidden");
        })
        .catch((error) => {
            swal("Error", "Terjadi Kesalahan", "error");
            console.log(error);
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
            table(kolom, data["data"], tahap);
            document
                .getElementById("searchbtn-" + tahap)
                .setAttribute("hidden", true);
            document
                .getElementById("savebtn-" + tahap)
                .removeAttribute("hidden");

            document
                .getElementById("expbtn-" + tahap)
                .setAttribute("hidden", true);
        })
        .catch((error) => console.log("error", error));
}

function table(kolom, data, tahap) {
    //deklar kolom table
    taghead = "";
    taghead += '<th scope="col">' + kolom[0] + "</th>";
    taghead += '<th scope="col">' + kolom[1] + "</th>";
    taghead += '<th scope="col">' + kolom[2] + "</th>";
    taghead += '<th scope="col">' + kolom[3] + "</th>";
    tag = "";

    for (let index = 0; index < data.length; index++) {
        tag += "<tr>";
        kolom.forEach((element) => {
            if (typeof data[index][element] != "undefined") {
                tag += "<td>" + data[index][element] + "</td>";
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
                responsive: true,
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
                responsive: true,
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
                responsive: true,
                pageLength: 10,
                autoWidth: false,
            });
            break;
    }
}

function saveKolom(tahap) {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Proses ini tidak dibatalkan dan dihapus ",
        icon: "warning",
        buttons: true,
    }).then((saveData) => {
        swal({
            title: "Apakah sudah diperiksa?",
            text: "Proses ini tidak dibatalkan dan dihapus ",
            icon: "warning",
            buttons: true,
        }).then((saveData) => {
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
            formdata.append(
                "tahun",
                document.getElementById("tahun_terdaftar").value
            );
            formdata.append(
                "pendidikan",
                document.getElementById("pendidikan").value
            );
            formdata.append("tahap", tahap);
            formdata.append("id", kolom[0]);
            formdata.append("nama", kolom[1]);
            formdata.append("jurusan", kolom[2]);
            formdata.append("alamat", kolom[3]);

            var url = document
                .getElementById("link-savekolom")
                .getAttribute("url");

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
                    sendPend();
                })
                .catch((error) => console.log("error", error));
        });
    });
}

function expKolom(tahap) {
    var url = document.getElementById("link-export").getAttribute("url");
    var tahun = document.getElementById("tahun_terdaftar").value;
    var pend = document.getElementById("pendidikan").value;
    let link =
        url + "?tahun=" + tahun + "&pendidikan=" + pend + "&tahap=" + tahap;
    window.open(link);
}
