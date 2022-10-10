function myFunction(){
    var requestOptions = {
      method: 'POST',
      redirect: 'follow'
    };
    var taun = document.getElementById("periode").value;
    
    fetch("http://localhost:8000/api/get-criteria-candidates/?tahun=" + taun, requestOptions)
      .then(response => response.text())
      .then(result => {
        if(result != null) {
            var coba = JSON.parse(result)
            document.getElementById("col_no_daftar").value = coba.criteria[0];
            document.getElementById("col_nama").value = coba.criteria[1];
            document.getElementById("col_id_pilihan_1").value = coba.criteria[2];
            document.getElementById("col_id_pilihan_2").value = coba.criteria[3];
            document.getElementById("col_id_pilihan_3").value = coba.criteria[4];
            document.getElementById("col_kode_kelompok_bidang").value = coba.criteria[5];
            document.getElementById("col_alamat").value = coba.criteria[6];
            document.getElementById("col_sekolah").value = coba.criteria[7];
            document.getElementById("col_no_telp").value = coba.criteria[9];
        }
        else {
            
        }
        
      }
        )
      .catch(error => {
        document.getElementById("col_no_daftar").value = "";
        document.getElementById("col_nama").value = "";
        document.getElementById("col_id_pilihan_1").value = "";
        document.getElementById("col_id_pilihan_2").value = "";
        document.getElementById("col_id_pilihan_3").value = "";
        document.getElementById("col_kode_kelompok_bidang").value = "";
        document.getElementById("col_alamat").value = "";
        document.getElementById("col_sekolah").value = "";
        document.getElementById("col_no_telp").value = "";
      });

}