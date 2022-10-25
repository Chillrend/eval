//accordion
$("#bt-close").click(function() {
    $("#hero-awal").toggle("blind", 800);
});

$('#collapase-accordion').on('click', function(e) {

    $("#panel-body-3").toggle(800);
});

$('#row-prestasi').on('click', function(e) {

    $("#row-tabel-prestasi").toggle(800);
});

$('#row-prodi').on('click', function(e) {

    $("#row-tabel-prodi").toggle(800);
});



//modal

$("#modal-1").fireModal({
    body: 'Modal body text goes here.'
});