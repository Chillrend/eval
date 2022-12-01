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
        // var jumlah = bis.kolom.length - 2;
        // for(i= 2; i < bis.kolom.length; i ++){
        // console.log(bis.kolom[i]);
        // }
  
        if (datatable != 0) {
          $('#tabel-preview').dataTable().fnClearTable();
          $('#tabel-preview').dataTable().fnAddData(dataAPI.candidates);
        } else {
          datatable ++
          $("#head-col").empty();
          $("#table-content").empty();
          $("#head-col").append("<th scope='col'>#</th>");
          $("#head-col").append("<th scope='col'>Periode</th>");
          for(let i = 0 ; i < dataAPI.criteria.length; i ++){
            let tag ="<th scope='col'>"+dataAPI.criteria[i]+"</th>";
            $("#head-col").append(tag);
          }
  
          for (let index = 0; index < dataAPI.candidates.length; index++) {
            tags = "<tr>"
            tags += "<td scope='col'>"+ (index + 1) +"</td>"
            tags += "<td scope='col'>"+ dataAPI.candidates[index].periode + "</td>"
            for (let i = 0; i < dataAPI.criteria.length; i++) {
              a = dataAPI.criteria[i]
              if ( dataAPI.candidates[index][String(a)] == "") {
                tags += "<td scope='col'>-</td>"
              } else {
                tags += "<td scope='col'>" + dataAPI.candidates[index][String(a)] + "</td>"
              }}
            tags += "</tr>"
          $("#table-content").append(tags);
          }
          
          $("#tabel-preview").DataTable({
            responsive: true,
            pageLength: 10,
            autoWidth: false,
            // order: [[1, "desc"]],
          });
        }
      })
      .catch(error => console.log('error', error));
    }

function gantiTahun() {
    var tahun_terdaftar = document.getElementById("tahun_terdaftar").value
    location.replace(url + '?tahun=' + tahun_terdaftar)
}