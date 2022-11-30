refresh("");
var datatable = 0;

function refresh(append) {
    var url = document.getElementById("main-content").getAttribute("url");
    var requestOptions = {
        method: "GET",
        redirect: "follow",
    };

    fetch(url + append, requestOptions)
        .then((response) => response.text())
        .then((result) => {
            var dataAPI = JSON.parse(result);
            console.log(dataAPI);

            //status progress
            document.getElementById("progress-bar").style.width =
                dataAPI.status.progress + "%";

            //status proses
            document.getElementById("status").innerHTML = dataAPI.status.status;

            //select tahun
            $("#tahun_terdaftar").empty();
            for (let index = 0; index < dataAPI.tahun.length; index++) {
                let tag = "<option >" + dataAPI.tahun[index] + "</option>";
                $("#tahun_terdaftar").append(tag);
            }
            document.getElementById("tahun_terdaftar").value =
                dataAPI.status.periode;

            //reset tabel
            $("#table-responsive").empty();
            let tag =
                '<table class="table-hover table display nowrap" id="tbl-preview" style="width: 100%"><thead><tr id="tbl-header"></tr></thead><tbody id="tbl-body"></tbody></table>';
            $("#table-responsive").append(tag);

            //deklar kolom
            tag = null;
            tag = '<th scope="col">#</th>';
            tag = tag + '<th scope="col">periode</th>';
            $("#tbl-header").append(tag);
            dataAPI.criteria.forEach((element) => {
                let tag = '<th scope="col">' + element + "</th>";
                $("#tbl-header").append(tag);
            });

            for (let index = 0; index < dataAPI.candidates.length; index++) {
                tag = null;
                tag = "<tr>";
                tag += "<td>" + (index + 1) + "</td>";
                tag +=
                    "<td>" + dataAPI["candidates"][index]["periode"] + "</td>";
                dataAPI.criteria.forEach((element) => {
                    if (dataAPI["candidates"][index][element] != "") {
                        tag +=
                            "<td>" +
                            dataAPI["candidates"][index][element] +
                            "</td>";
                    } else {
                        tag += "<td>-</td>";
                    }
                });
                tag = tag + "</tr>";
                $("#tbl-body").append(tag);
            }

            $("#tbl-preview").DataTable({
                scrollX: true,
                responsive: true,
                pageLength: 10,
                autoWidth: true,
            });
        })
        .catch((error) => console.log("error", error));
}

function gantiTahun() {
    var tahun_terdaftar = document.getElementById("tahun_terdaftar").value;
    refresh("?tahun=" + tahun_terdaftar);
}
