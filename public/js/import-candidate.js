var collumn = [];

// document.getElementById("addcollumn").addEventListener("click", addCollumn);

function deleteCollumn(id){
  collumn = collumn.splice(id,0);
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
  console.log(collumn);
  document.getElementById("nameCollumn").value = ''
  document.getElementById("banyakCollumn").value = collumn.length





  //KASIH ALERT ATAU APAPUN ITU





}

// function myFunction(){
//     var requestOptions = {
//       method: 'POST',
//       redirect: 'follow'
//     };
//     var taun = document.getElementById("periode").value;
    
//     fetch("http://localhost:8000/api/get-criteria-candidates/?tahun=" + taun, requestOptions)
//       .then(response => response.text())
//       .then(result => {
//         if(result != null) {
//             var coba = JSON.parse(result)
//             document.getElementById("col_no_daftar").value = coba.criteria[0];
//             document.getElementById("col_nama").value = coba.criteria[1];
//             document.getElementById("col_id_pilihan_1").value = coba.criteria[2];
//             document.getElementById("col_id_pilihan_2").value = coba.criteria[3];
//             document.getElementById("col_id_pilihan_3").value = coba.criteria[4];
//             document.getElementById("col_kode_kelompok_bidang").value = coba.criteria[5];
//             document.getElementById("col_alamat").value = coba.criteria[6];
//             document.getElementById("col_sekolah").value = coba.criteria[7];
//             document.getElementById("col_no_telp").value = coba.criteria[9];
//         }
//         else {
            
//         }
        
//       }
//         )
//       .catch(error => {
//         document.getElementById("col_no_daftar").value = "";
//         document.getElementById("col_nama").value = "";
//         document.getElementById("col_id_pilihan_1").value = "";
//         document.getElementById("col_id_pilihan_2").value = "";
//         document.getElementById("col_id_pilihan_3").value = "";
//         document.getElementById("col_kode_kelompok_bidang").value = "";
//         document.getElementById("col_alamat").value = "";
//         document.getElementById("col_sekolah").value = "";
//         document.getElementById("col_no_telp").value = "";
//       });

// }