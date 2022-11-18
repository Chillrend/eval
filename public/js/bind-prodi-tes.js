var url = document.getElementById("main-content").getAttribute('url');

var dataAPI;

var requestOptions = {
  method: 'GET',
  redirect: 'follow'
};
  
fetch(url, requestOptions)
  .then(response => response.text())
  .then(result => {

      dataAPI = JSON.parse(result)
      console.log(dataAPI);

      $("#tbl-bindprodites").DataTable({
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
                data: "kuota",
                // orderable: false,
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
  })
  .catch(error => console.log('error', error));

  function tutup(){
    document.getElementById('binding').setAttribute('hidden','');
  }

  function cek(){
    var a = document.getElementById('flexCheckDefault');
      if (a.checked == true) {
        document.getElementById('input_prodi').value=  document.getElementById('prodi').value;
        document.getElementById('input_prodi').readOnly = true;
        document.getElementById('tahuntemplate').setAttribute('readonly',true);
      } else {
        document.getElementById('input_prodi').value= "";
        document.getElementById('tahun').value= "";
        document.getElementById('input_prodi').readOnly = false;
        document.getElementById('tahuntemplate').removeAttribute('readonly');
      }
  }

  function editBtn(id) {
    document.getElementById('binding').removeAttribute('hidden');
    document.getElementById('binding').focus();
    var idbaru = dataAPI['prodi'][id];
    document.getElementById('id').value= idbaru['id_prodi'];
    document.getElementById('prodi').value= idbaru['prodi'];
    document.getElementById('tahun').value= "";
    
  }
