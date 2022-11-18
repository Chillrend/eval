var url = document.getElementById("main-content").getAttribute('url');
console.log(url);

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
                data: "_id",
                render: function (data) {
                  return '<button class="btn btn-icon btn-warning m-1" id="editBtn" onclick="editBtn('+ data +')" ><i class="fas fa-edit"></i> Binding</button>';
                },
                orderable: false,
            }
        ],
    });
  })
  .catch(error => console.log('error', error));