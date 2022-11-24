var url = document.getElementById("main-content").getAttribute('url'); 

function gantiTahun() {
    var tahun_terdaftar = document.getElementById("tahun_terdaftar").value
    location.replace(url + '?tahun=' + tahun_terdaftar)
}