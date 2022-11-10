var collumn = [];

// document.getElementById("addcollumn").addEventListener("click", addCollumn);

// collumn = sessionStorage.getItem("collumn");
// console.log(sessionStorage.getItem("collumn"));

function simpanFilter() { 
  sessionStorage.setItem("collumn",collumn);
}

function deleteCollumn(id){
  collumn.splice(id,1);
  refreshCollumn();
}


function addCollumn() {
  if (document.getElementById("kolom").value != '' && document.getElementById("operator").value != '' && document.getElementById("nilai").value != '') {
    var kolom = document.getElementById("kolom").value;
    var operator = document.getElementById("operator").value;
    var nilai = document.getElementById("nilai").value;
    collumn.push([kolom, operator, nilai])
  }
  document.getElementById("kolom").value = ''
  document.getElementById("operator").value = ''
  document.getElementById("nilai").value = ''
  refreshCollumn()
}

function refreshCollumn() {
  $("#namedkey").empty();
  for (let index = 0; index < collumn.length; index++) {
    let tag ='<div class="input-group mb-3" id="collumn-'+index+'">'+
                '<input type="text" class="form-control" id="kolom-'+index+'" name="kolom-'+index+'" value="'+collumn[index][0]+'" readonly>'+
                '<input type="text" class="form-control" id="operator-'+index+'" name="operator-'+index+'" value="'+collumn[index][1]+'" readonly>'+
                '<input type="text" class="form-control" id="nilai-'+index+'" name="nilai-'+index+'" value="'+collumn[index][2]+'" readonly>'+
                '<div class="input-group-append" id="collumn-'+index+'">'+
                  '<button class="btn btn-outline-danger" type="button" onclick="deleteCollumn('+index+')"><i class="fa-solid fa-times fa-lg"></i> Hapus</button>'+
                '</div>'+
              '</div>'
    $("#namedkey").append(tag);
  }
  document.getElementById("banyakCollumn").value = collumn.length
}

function myFunction(){

  var taun = document.getElementById("periode").value;
  var url = document.getElementById("periode").getAttribute('url');
  
  var formdata = new FormData;
  formdata.append('tahun', taun);

  var requestOptions = {
    method: 'POST',
    body: formdata,
    redirect: 'follow'
  };
  console.log(url, formdata);
  fetch(url, requestOptions)
    .then(response => response.text())
    .then(result => {
      if(result != null) {
        var coba = JSON.parse(result)
        var hasil = coba.kolom
        console.log(hasil);
        hasil.forEach(element => {
          collumn.push([element.kolom, element.operator, element.nilai])          
        });
        refreshCollumn()
      }
      else {
        alert('null');   
      }
    })
    .catch(error => {
      alert(error);
  });
}