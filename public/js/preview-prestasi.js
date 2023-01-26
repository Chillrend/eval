refresh("");
var datatable = 0;

function refresh(append) {
    document.getElementById("data-kosong").setAttribute("hidden", true);
    document.getElementById("card-done").setAttribute("hidden", true);
    document.getElementById("card-filter").setAttribute("hidden", true);
    document.getElementById("card-import").setAttribute("hidden", true);

    var url = document.getElementById("main-content").getAttribute("url");
    var requestOptions = {
        method: "GET",
        redirect: "follow",
    };

    fetch(url + append, requestOptions)
        .then((response) => response.text())
        .then((result) => {
            var dataAPI = JSON.parse(result);
            if (dataAPI.error) {
                throw dataAPI.error;
            }
            //select tahun
            $("#tahun_terdaftar").empty();
            for (let index = 0; index < dataAPI.tahun.length; index++) {
                let tag = "<option >" + dataAPI.tahun[index] + "</option>";
                $("#tahun_terdaftar").append(tag);
            }
            document.getElementById("tahun_terdaftar").value = dataAPI.periode;

            let vari = ["import", "filter", "done"];
            //proses looping buat 3 tahap
            for (let i = 0; i < vari.length; i++) {
                if (dataAPI[vari[i]]) {
                    //bikin kolom
                    let taghead = '<th scope="col">#</th>';
                    // console.log(dataAPI[vari[i]]["kolom"]);
                    dataAPI[vari[i]]["kolom"].forEach((element) => {
                        taghead += '<th scope="col">' + element + "</th>";
                    });

                    //isi nilai
                    tag = null;
                    for (
                        let index = 0;
                        index < dataAPI[vari[i]]["candidates"].length;
                        index++
                    ) {
                        tag += "<tr>";
                        tag += "<td>" + (index + 1) + "</td>";
                        dataAPI[vari[i]]["kolom"].forEach((element) => {
                            if (
                                dataAPI[vari[i]]["candidates"][index][
                                    element
                                ] != ""
                            ) {
                                tag +=
                                    "<td>" +
                                    dataAPI[vari[i]]["candidates"][index][
                                        element
                                    ] +
                                    "</td>";
                            } else {
                                tag += "<td>-</td>";
                            }
                        });
                        tag = tag + "</tr>";
                    }

                    //deklar table
                    switch (vari[i]) {
                        case "done":
                            $("#table-responsive-done").empty();
                            temp =
                                '<table class="table table-striped" id="table-done"><thead><tr id="tbl-header-done"></tr></thead><tbody id="tbl-body-done"></tbody></table>';
                            $("#table-responsive-done").append(temp);
                            $("#tbl-header-done").append(taghead);
                            $("#tbl-body-done").append(tag);
                            $("#table-done").DataTable({
                                responsive: true,
                                pageLength: 10,
                                autoWidth: false,
                            });
                            document
                                .getElementById("card-done")
                                .removeAttribute("hidden");

                            break;

                        case "filter":
                            $("#table-responsive-filter").empty();
                            temp =
                                '<table class="table table-striped" id="table-filter"><thead><tr id="tbl-header-filter"></tr></thead><tbody id="tbl-body-filter"></tbody></table>';
                            $("#table-responsive-filter").append(temp);
                            $("#tbl-header-filter").append(taghead);
                            $("#tbl-body-filter").append(tag);
                            $("#table-filter").DataTable({
                                responsive: true,
                                pageLength: 10,
                                autoWidth: false,
                            });
                            document
                                .getElementById("card-filter")
                                .removeAttribute("hidden");

                            break;

                        case "import":
                            $("#table-responsive-import").empty();
                            temp =
                                '<table class="table table-striped" id="table-import"><thead><tr id="tbl-header-import"></tr></thead><tbody id="tbl-body-import"></tbody></table>';
                            $("#table-responsive-import").append(temp);
                            $("#tbl-header-import").append(taghead);
                            $("#tbl-body-import").append(tag);
                            $("#table-import").DataTable({
                                responsive: true,
                                pageLength: 10,
                                autoWidth: true,
                            });
                            document
                                .getElementById("card-import")
                                .removeAttribute("hidden");

                            break;
                    }
                }
            }
        })
        .catch((error) => {
            swal("Error", "Terjadi Kesalahan", "error");
            console.log(error);
        });
}

function gantiTahun() {
    var tahun_terdaftar = document.getElementById("tahun_terdaftar").value;
    refresh("?tahun=" + tahun_terdaftar);
}
