var url = document.getElementById("main-content").getAttribute('url');
var dataAPI;
var datatable = 0;
refresh('');

function refresh(append) {
    var requestOptions = {
        method: 'GET',
        redirect: 'follow'
    };

    fetch(url + append, requestOptions)
        .then(response => response.text())
        .then(result => {

            dataAPI = JSON.parse(result)
            console.log(dataAPI);
            if (datatable != 0) {
                $('#table-prodi-mandiri').dataTable().fnClearTable();
                $('#table-prodi-mandiri').dataTable().fnAddData(dataAPI.prodi);
            } else {
                datatable++

                $("#table-prodi-mandiri").DataTable({
                    data: dataAPI.prodi,
                    responsive: true,
                    pageLength: 10,
                    autoWidth: false,
                    // order: [[1, "desc"]],
                    columnDefs: [
                        { targets: [5], className: 'dt-center' }
                    ],
                    columns: [{
                            data: null,
                            render: function(data, type, full, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: "id_prodi",
                        },
                        {
                            data: "prodi",
                            orderable: false,
                        },
                        {
                            data: "kelompok_bidang",
                            // orderable: false,
                        },
                        {
                            data: "kuota",

                        },
                        {
                            data: '_id',
                            render: function(data, type, full, meta) {
                                rowww = meta.row
                                editbtn = '<button class="btn btn-icon btn-warning m-1" id="editBtn" onclick="editBtn(' + rowww + ')" ><i class="fas fa-edit"></i> </button>';
                                deletebtn = '<button class="btn btn-icon btn-danger m-1" id="deleteBtn" onclick="editBtn(' + data + ')" ><i class="fas fa-trash"></i> </button>';
                                return '<a href=#prodi-tes-edit>' + editbtn + deletebtn + '</a>';
                            },
                            orderable: false,
                        }
                    ],
                });
            }
        })
        .catch(error => console.log('error', error));
}


function tutup() {
    document.getElementById('prodi-mandiri-edit').setAttribute('hidden', true);
    sessionStorage.clear();
}

function submit() {

    var link = document.getElementById("edit-prodi-mandiri").getAttribute('url');
    var formdata = new FormData();
    formdata.append("id_panjang", document.getElementById('id_obj').value);
    formdata.append("id_prodi", document.getElementById('id').value);
    formdata.append("prodi", document.getElementById('prodi').value);
    console.log(document.getElementById('prodi').value);
    formdata.append("kelompok_bidang", document.getElementById('bidang').value);
    formdata.append("kuota", document.getElementById('kuota').value);

    var requestOptions = {
        method: 'POST',
        body: formdata,
        redirect: 'follow'
    };

    fetch(link, requestOptions)
        .then(response => response.text())
        .then(result => {
            console.log(result)
            tutup()
            refresh('')
        })
        .catch(error => console.log('error', error));

}

function editBtn(id) {
    document.getElementById('prodi-mandiri-edit').removeAttribute('hidden');
    document.getElementById('prodi-mandiri-edit').focus();
    var idbaru = dataAPI['prodi'][id];
    document.getElementById('id').value = idbaru['id_prodi'];
    document.getElementById('id_obj').value = idbaru['_id'];
    document.getElementById('prodi').value = idbaru['prodi'];
    document.getElementById('kuota').value = idbaru['kuota'];
    document.getElementById('bidang').value = idbaru['kelompok_bidang'];

}

function tahun_terdaftar() {
    var append = '?tahun=' + document.getElementById('tahun_terdaftar').value
    refresh(append);
}

function templatetahun() {
    var idprodi = document.getElementById('id_obj').value;
    var formdata = new FormData();
    formdata.append("id", idprodi);

    var requestOptions = {
        method: 'POST',
        body: formdata,
        redirect: 'follow'
    };

    fetch("http://localhost:8000/api/prodi-tes/detail", requestOptions)
        .then(response => response.text())
        .then(result => {
            var API = JSON.parse(result)
            var thn = API["prodi"]["binding"][0]["tahun"]
            var bind = API["prodi"]["binding"][0]["bind"]
            var selector = document.getElementById("tahuntemplate");
            if (API["prodi"]["binding"] != null) {
                let tag = '<option>' + thn + '-' + bind + '</option>'
                $("#tahuntemplate").empty();
                $("#tahuntemplate").append('<option>Tahun Terdata</option>');
                $("#tahuntemplate").append(tag);
            }

        })
        .catch(error => console.log('error', error));

}

function pilihtahun() {
    var idprodi = document.getElementById('id_obj').value;
    var formdata = new FormData();
    formdata.append("id", idprodi);

    var requestOptions = {
        method: 'POST',
        body: formdata,
        redirect: 'follow'
    };

    fetch("http://localhost:8000/api/bind-prodi-tes/detail", requestOptions)
        .then(response => response.text())
        .then(result => {
            var data = JSON.parse(result)
            var bind = data["prodi"]["binding"][0]["bind"]
            document.getElementById('input_prodi').value = bind;


        })
        .catch(error => console.log('error', error));
}