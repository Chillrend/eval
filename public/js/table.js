$(document).ready(function () {
    $('#table').DataTable({
        scrollX: true,
        autoWidth: false,
        paging: false,
        info: false,
        searching:false,
        responsive:true,
        ordering: false,
    });
});