var collumn = [];

// document.getElementById("addcollumn").addEventListener("click", addCollumn);

function deleteCollumn(id){
  console.log(JSON.stringify(collumn));
  var formdata = new FormData();
  formdata.append("id",id)
  formdata.append("list",JSON.stringify(collumn))
  var requestOptions = {
    method: 'POST',
    body: formdata,
    redirect: 'follow'
  };

  fetch("http://localhost:8000/api/del-criteria-candidates-pres", requestOptions)
    .then(response => response.text())
    .then(result => {
      if(result != null) {
        console.log(result);

          var coba = JSON.parse(result)
          console.log(coba['data']);
          // var criteria = coba['data']
          // $("#namedkey").empty();
          // for (let index = 0; index < criteria.length; index++) {
          //   let tag ='<div class="input-group mb-3" id="collumn-'+index+'"><input type="text" class="form-control" id="collumn-'+index+'" name="collumn-'+index+'" value="'+criteria[index]+'" readonly><div class="input-group-append" id="collumn-'+index+'"><button class="btn btn-outline-danger" type="button" onclick="deleteCollumn('+index+')"><i class="fa-solid fa-times fa-lg"></i> Hapus</button></div></div>'
          //   $("#namedkey").append(tag);
          // }
      }
      else {
        alert('empty')
          
      }
      
    }
      )
    .catch(error => {
      alert(error)
    });
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
  console.log(collumn);
  document.getElementById("nameCollumn").value = ''
  document.getElementById("banyakCollumn").value = collumn.length





  //KASIH ALERT ATAU APAPUN ITU





}

function myFunction(){

  var formdata = new FormData();
  formdata.append("tahun",document.getElementById("periode").value)
  var requestOptions = {
    method: 'POST',
    body:formdata,
    redirect: 'follow'
  };

  fetch("http://localhost:8000/api/get-criteria-candidates-pres/", requestOptions)
    .then(response => response.text())
    .then(result => {
      if(result != null) {
          var coba = JSON.parse(result)
          collumn = coba['data']
          $("#namedkey").empty();
          for (let index = 0; index < collumn.length; index++) {
            let tag ='<div class="input-group mb-3" id="collumn-'+index+'"><input type="text" class="form-control" id="collumn-'+index+'" name="collumn-'+index+'" value="'+collumn[index]+'" readonly><div class="input-group-append" id="collumn-'+index+'"><button class="btn btn-outline-danger" type="button" onclick="deleteCollumn('+index+')"><i class="fa-solid fa-times fa-lg"></i> Hapus</button></div></div>'
            $("#namedkey").append(tag);
          }
      }
      else {
        alert('empty')
          
      }
      
    }
      )
    .catch(error => {
      alert(error)
    });

}