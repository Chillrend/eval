var url = document.getElementById("main-content").getAttribute('url');

var dataAPI;
var datatable = 0;
refresh('');

function refresh(append) {
  var requestOptions = {
    method: 'GET',
    redirect: 'follow'
  };
    
  fetch(url+append, requestOptions)
    .then(response => response.text())
    .then(result => {

      dataAPI = JSON.parse(result)
      console.log(dataAPI);

      if (datatable != 0) {
        $('#tbl-bindprodimandiri').dataTable().fnClearTable();
        $('#tbl-bindprodimandiri').dataTable().fnAddData(dataAPI.prodi);
      } else {
        datatable ++
        var tahun = dataAPI.tahun
        $("#tahun_terdaftar").empty();
        
        if (String(tahun[0]['tahun']) != String(new Date().getFullYear())) {
          let tag ='<option >'+new Date().getFullYear()+'</option>'
          $("#tahun_terdaftar").append(tag);
        }
        for (let index = 0; index < tahun.length; index++) {
          let tag ='<option >'+tahun[index]['tahun']+'</option>'
          $("#tahun_terdaftar").append(tag);
        }
        

        $("#tbl-bindprodimandiri").DataTable({
          data: dataAPI.prodi,
          responsive: true,
          pageLength: 10,
          autoWidth: false,
          // order: [[1, "desc"]],
          columnDefs: [
            { targets: [ 5 ], className: 'dt-center' }
          ],
          columns: [
            {
                data: null,
                render: function (data, type, full, meta) {
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
                data: "binding",
                orderable: false,
                render: function (data) {
                  if (data != null) {
                    return '<p>'+data+'<p>'
                  } else {
                    return '<code> NO DATA REGISTERED <code>'
                  }
                }
            },
            {
              data: null,
              render: function (data, type, full, meta) {
                rowww = meta.row
                return '<a href=#binding><button class="btn btn-icon btn-warning m-1" id="editBtn" onclick="editBtn('+ rowww +')" ><i class="fas fa-edit"></i>  Binding </button> </a>';
              },
              orderable: false,
            }
          ],
        });
      }
    })
    .catch(error => console.log('error', error));
  }


  function tutup(){
    document.getElementById('binding').setAttribute('hidden');
  }

  function cek(){
    var a = document.getElementById('flexCheckDefault');
      if (a.checked == true) {
        document.getElementById('input_prodi').value=  document.getElementById('prodi').value;
        document.getElementById('input_prodi').readOnly = true;
        document.getElementById('tahuntemplate').setAttribute('disabled',true);
        
      } else {
        document.getElementById('input_prodi').value= "";
        document.getElementById('input_prodi').readOnly = false;
        document.getElementById('tahuntemplate').removeAttribute('disabled');
      }
  }

  function editBtn(id) {
    document.getElementById('binding').removeAttribute('hidden');
    document.getElementById('binding').focus();
    var idbaru = dataAPI['prodi'][id];
    document.getElementById('id').value= idbaru['id_prodi'];
    document.getElementById('id_obj').value= idbaru['_id'];
    document.getElementById('prodi').value= idbaru['prodi'];
    document.getElementById('tahun').value= document.getElementById('tahun_terdaftar').value;
    
  }

  function tahun_terdaftar() {
    var append = '?tahun='+document.getElementById('tahun_terdaftar').value
    refresh(append);
  }