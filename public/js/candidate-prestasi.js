var collumn = [];
var dataAPI;
var datatable = 0;
refresh('');


function refresh(append) {
  document.getElementById("preview").setAttribute("hidden", true);
  var url = document.getElementById("main-content").getAttribute('url');
  var requestOptions = {
    method: 'GET',
    redirect: 'follow'
  };
    
  fetch(url+append, requestOptions)
    .then(response => response.text())
    .then(result => {
      dataAPI = JSON.parse(result)
      if (typeof dataAPI.error == "undefined") {
      console.log(dataAPI);

      if (datatable != 0) {
        $('#table-candidatepres').dataTable().fnClearTable();
        $('#table-candidatepres').dataTable().fnAddData(dataAPI.candidates);
      } else {
        datatable ++
        $("#head-col").empty();
        $("#table-content").empty();
        $("#head-col").append("<th scope='col'>#</th>");
        $("#head-col").append("<th scope='col'>Periode</th>");
        for(let i = 0 ; i < dataAPI.kolom[0].length; i ++){
          let tag ="<th scope='col'>"+dataAPI.kolom[0][i]+"</th>";
          $("#head-col").append(tag);
        }

        for (let index = 0; index < dataAPI.candidates.length; index++) {
          tags = "<tr>"
          tags += "<td scope='col'>"+ (index + 1) +"</td>"
          tags += "<td scope='col'>"+ dataAPI.candidates[index].periode + "</td>"
          for (let i = 0; i < dataAPI.kolom[0].length; i++) {
            a = dataAPI.kolom[0][i]
            if ( dataAPI.candidates[index][String(a)] == "") {
              tags += "<td scope='col'>-</td>"
            } else {
              tags += "<td scope='col'>" + dataAPI.candidates[index][String(a)] + "</td>"
            }}
          tags += "</tr>"
        $("#table-content").append(tags);
        }
        
      document.getElementById('preview').removeAttribute('hidden');
        $("#table-candidatepres").DataTable({
          responsive: true,
          pageLength: 10,
          autoWidth: false,
          // order: [[1, "desc"]],
        });
      }
      }
    })
    .catch(error => console.log('error', error));
  }
// document.getElementById("addcollumn").addEventListener("click", addCollumn);

function deleteCollumn(id){
  collumn.splice(id,1);
  addCollumn();
}

function addCollumn() {
  
  if (document.getElementById("nameCollumn").value != '') {
    collumn[collumn.length] = document.getElementById("nameCollumn").value;
  }
  $("#namedkey").empty();
  for (let index = 0; index < collumn.length; index++) {
    let tag ='<div class="input-group mb-3" id="collumn-'+index+'"><input type="text" class="form-control" id="collumn-'+index+'" name="collumn-'+index+'" value="'+collumn[index]+'" readonly><div class="input-group-append" id="collumn-'+index+'"><button class="btn btn-outline-danger" type="button" onclick="deleteCollumn('+index+')"><i class="fa-solid fa-times fa-lg"></i> Hapus</button></div></div>'
    $("#namedkey").append(tag);
  }
  document.getElementById("nameCollumn").value = ''
  document.getElementById("banyakCollumn").value = collumn.length




console.log(collumn);
  //KASIH ALERT ATAU APAPUN ITU





}

function myFunction(){

    var taun = document.getElementById("periode").value;
    var url = document.getElementById("tambahCriteria").getAttribute('url');
    var urldel = document.getElementById("tambahCriteria").getAttribute('url-del');
    
    var formdata = new FormData;
    formdata.append('tahun', taun);

    var requestOptions = {
      method: 'POST',
      body: formdata,
      redirect: 'follow'
    };
    fetch(url, requestOptions)
      .then(response => response.text())
      .then(result => {
        if(result != null) {
            var coba = JSON.parse(result)
            collumn = coba.criteria
            $("#namedkey").empty();
            for (let index = 0; index < collumn.length; index++) {
              let tag ='<div class="input-group mb-3" id="collumn-'+index+'"><input type="text" class="form-control" id="collumn-'+index+'" name="collumn-'+index+'" value="'+collumn[index]+'" readonly><div class="input-group-append" id="collumn-'+index+'"><button class="btn btn-outline-danger" type="button" url="'+urldel+'" onclick="deleteCollumn('+index+')"><i class="fa-solid fa-times fa-lg"></i> Hapus</button></div></div>'
              $("#namedkey").append(tag);
            }
            document.getElementById("banyakCollumn").value = collumn.length
        }
        else {
          alert('null');   
        }
      })
      .catch(error => {
        alert(erorr);
    });
}