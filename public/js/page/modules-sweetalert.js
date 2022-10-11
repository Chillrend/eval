"use strict";

$("#swal-1").click(function() {
    swal('Hello');
});

$("#swal-2").click(function() {
    swal('Good Job', 'You clicked the button!', 'success');
});

$("#swal-3").click(function() {
    swal('Good Job', 'You clicked the button!', 'warning');
});

$("#swal-4").click(function() {
    swal('Good Job', 'You clicked the button!', 'info');
});

$("#swal-5").click(function() {
    swal('Good Job', 'You clicked the button!', 'error');
});

$("#swal-6").click(function() {
    swal({
            title: 'Apakah Anda Yakin?',
            text: 'Data yang telah disimpan tidak bisa diubah. Silahkan periksa data kembali! ',
            icon: 'warning',
            buttons: true,
        })
        .then((saveData) => {
            if (saveData) {
                swal("Berhasil!", "Data Berhasil Disimpan!", "success",);
                window.location = "preview-prestasi";
            } else {
                swal({
                    buttons: false,
                    timer: 10000,
                });
            }
        });
});

$("#swal-7").click(function() {
    swal({
        title: 'What is your name?',
        content: {
            element: 'input',
            attributes: {
                placeholder: 'Type your name',
                type: 'text',
            },
        },
    }).then((data) => {
        swal('Hello, ' + data + '!');
    });
});

$("#swal-8").click(function() {
    swal('This modal will disappear soon!', {
        buttons: false,
        timer: 3000,
    });
});