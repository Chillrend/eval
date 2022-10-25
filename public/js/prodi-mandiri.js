var collumn = [];

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
            sessionStorage.setItem('collumn', collumn);
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