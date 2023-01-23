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

function sendPres() {
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
        .catch((error) => console.log("error", error));
}
