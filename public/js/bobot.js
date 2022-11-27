var criteria = []; 
var kolom;
var bobot;
refresh('','','')

function refresh() {
    var url = document.getElementById("main-content").getAttribute('url');

    var requestOptions = {
        method: 'GET',
        redirect: 'follow'
      };
      
    fetch(url, requestOptions)
    .then(response => response.text())
    .then(result => {
        var tahun = JSON.parse(result)
        console.log(tahun);
        $("#tahun_terdaftar").empty();
        let tag ='<option selected hidden disabled>Pilih Tahun</option>'
        $("#tahun_terdaftar").append(tag);
        tahun.tahun.forEach(element => {
            let tag ='<option >'+element+'</option>'
            $("#tahun_terdaftar").append(tag);
        });
    })
    .catch(error => console.log('error', error));
}

function sendTahun() {
    var url = document.getElementById("tahun_terdaftar").getAttribute('url');

    var formdata = new FormData();
    formdata.append("tahun", document.getElementById('tahun_terdaftar').value);
    
    var requestOptions = {
      method: 'POST',
      body: formdata,
      redirect: 'follow'
    };
      
    fetch(url, requestOptions)
    .then(response => response.text())
    .then(result => {
        var pend = JSON.parse(result)
        console.log(pend);

        document.getElementById('pendidikan').removeAttribute("disabled");
        document.getElementById('tahap').setAttribute("disabled", true);
        document.getElementById('datatable').setAttribute("hidden", true);


        $("#pendidikan").empty();
        let tag ='<option selected hidden disabled>Pilih Pendidikan</option>'
        $("#pendidikan").append(tag);
        pend.pendidikan.forEach(element => {
            let tag ='<option >'+element+'</option>'
            $("#pendidikan").append(tag);
        });
    })
    .catch(error => console.log('error', error));
}

function sendPend() {
    var url = document.getElementById("pendidikan").getAttribute('url');

    var formdata = new FormData();
    formdata.append("tahun", document.getElementById('tahun_terdaftar').value);
    formdata.append("pendidikan", document.getElementById('pendidikan').value);
    
    var requestOptions = {
      method: 'POST',
      body: formdata,
      redirect: 'follow'
    };
      
    fetch(url, requestOptions)
    .then(response => response.text())
    .then(result => {
        var tahap = JSON.parse(result)
        console.log(tahap.tahap);

        document.getElementById('tahap').removeAttribute("disabled");
        document.getElementById('datatable').setAttribute("hidden", true);


        $("#tahap").empty();
        let tag ='<option selected hidden disabled>Pilih Tahap</option>'
        $("#tahap").append(tag);
        tahap.tahap.forEach(element => {
            switch (element) {
                case 'candidates_tes':
                    tag ='<option value="'+element+'" >Tes</option>'
                    break;
                case 'candidates_pres':
                    tag ='<option value="'+element+'" >Prestasi</option>'
                    break;
                case 'candidates_mand':
                    tag ='<option value="'+element+'" >Mandiri</option>'
                    break;
            }
            $("#tahap").append(tag);
        });
    })
    .catch(error => console.log('error', error));
}

function sendTahap() {
    var url = document.getElementById("tahap").getAttribute('url');

    var formdata = new FormData();
    formdata.append("tahun", document.getElementById('tahun_terdaftar').value);
    formdata.append("pendidikan", document.getElementById('pendidikan').value);
    formdata.append("tahap", document.getElementById('tahap').value);
    
    var requestOptions = {
      method: 'POST',
      body: formdata,
      redirect: 'follow'
    };
    
    fetch(url, requestOptions)
        .then(response => response.text())
        .then(result => {
            dataAPI = JSON.parse(result)
            kolom = dataAPI.criteria;
            console.log(kolom);

            document.getElementById('datatable').removeAttribute("hidden");

            document.getElementById('nilai').setAttribute("disabled", true);
            document.getElementById('bobot').setAttribute("disabled", true);
            document.getElementById('prioritas').setAttribute("disabled", true);
            
            
            $("#kolom").empty();
            let tag ='<option selected hidden>Pilih Kolom</option>'
            $("#kolom").append(tag);
            kolom.forEach(element => {
                let tag ='<option >'+element+'</option>'
                $("#kolom").append(tag);
            });        
        })
      .catch(error => console.log('error', error));
}

function sendKolom() {
    var url = document.getElementById("kolom").getAttribute('url');

    var formdata = new FormData();
    formdata.append("tahun", document.getElementById('tahun_terdaftar').value);
    formdata.append("pendidikan", document.getElementById('pendidikan').value);
    formdata.append("tahap", document.getElementById('tahap').value);
    formdata.append("kolom", document.getElementById('kolom').value);
    
    var requestOptions = {
      method: 'POST',
      body: formdata,
      redirect: 'follow'
    };
    
    fetch(url, requestOptions)
        .then(response => response.text())
        .then(result => {
            dataAPI = JSON.parse(result)
            nilai = dataAPI.nilai;
            console.log(nilai);

            document.getElementById('datatable').removeAttribute("hidden");
            document.getElementById('nilai').removeAttribute("disabled");
            document.getElementById('bobot').setAttribute("disabled", true);
            document.getElementById('prioritas').setAttribute("disabled", true);
            
            $("#nilai").empty();
            let tag ='<option selected hidden>Pilih Nilai</option>'
            $("#nilai").append(tag);
            nilai.forEach(element => {
                let tag ='<option >'+element+'</option>'
                $("#nilai").append(tag);
            });        
        })
        .catch(error => console.log('error', error));
}

function sendNilai() {
    document.getElementById('bobot').removeAttribute("disabled");
    document.getElementById('prioritas').removeAttribute("disabled");
}

var toggle = false

function setPrioritas() {
    if (toggle == false) {
        document.getElementById('bobot').setAttribute("disabled", true);
        toggle = true;
    } else {
        document.getElementById('bobot').removeAttribute("disabled");
        toggle = false;
    }
}

function showForm() {
    document.getElementById('form-bobot').removeAttribute('hidden');
    document.getElementById('form-bobot').focus();
        
}

function tutup(){

    $("#kolom").empty();
    let tag1 ='<option selected hidden>Pilih Kolom</option>'
    $("#kolom").append(tag1);

    $("#nilai").empty();
    let tag ='<option selected hidden>Pilih Nilai</option>'
    $("#nilai").append(tag);

    document.getElementById('nilai').value = 0;


    document.getElementById('datatable').removeAttribute("hidden");
    document.getElementById('nilai').setAttribute("disabled", true);
    document.getElementById('bobot').setAttribute("disabled", true);
    document.getElementById('prioritas').setAttribute("disabled", true);

    document.getElementById('binding').setAttribute('hidden',true);
    sessionStorage.clear();
  }
  