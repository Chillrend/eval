function myFunction(){
    var requestOptions = {
      method: 'POST',
      redirect: 'follow'
    };
    var taun = document.getElementById("periode").value;
    
    fetch("http://localhost:8000/api/get-criteria-prodi/?tahun=" + taun, requestOptions)
      .then(response => response.text())
      .then(result => {
        if(result != null) {
            var coba = JSON.parse(result)
            document.getElementById("col_id_prodi").value = coba.criteria[0];
            document.getElementById("col_jurusan").value = coba.criteria[1];
            document.getElementById("col_id_politeknik").value = coba.criteria[2];
            document.getElementById("col_politeknik").value = coba.criteria[3];
            document.getElementById("col_id_kelompok_bidang").value = coba.criteria[4];
            document.getElementById("col_kelompok_bidang").value = coba.criteria[5];
            document.getElementById("col_Quota").value = coba.criteria[6];
            document.getElementById("col_tertampung").value = coba.criteria[7];
        }
        else {
            
        }
        
      }
        )
      .catch(error => {
        document.getElementById("col_id_prodi").value = "";
        document.getElementById("col_jurusan").value = "";
        document.getElementById("col_id_politeknik").value = "";
        document.getElementById("col_politeknik").value = "";
        document.getElementById("col_id_kelompok_bidang").value = "";
        document.getElementById("col_kelompok_bidang").value = "";
        document.getElementById("col_Quota").value = "";
        document.getElementById("col_tertampung").value = "";
      });

}