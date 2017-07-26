$('.required-confirm').on('click', function(e) {
    e.preventDefault();
    var form = $(this).closest('form');

    swal({
        title: "Are you sure?",
        text: "Take this action may affect user shopping experience",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel pls!",
        closeOnConfirm: false
    },
    function(isConfirm){
        if (isConfirm) {form.submit();}
    });
});


$('#data-table').DataTable({
    "paging":    false,
    "info":      false,
    "aaSorting": [],
    columnDefs: [
        {
            "targets": [ 0, 1, 2, 3 ],
            "className": 'mdl-data-table__cell--non-numeric'
        },
        {
            "targets": [0,1],
            "orderable": false,
        }
    ],
});

$('#data-table').on( 'click', 'tbody tr', function () {
    window.location.href = $(this).attr('href');
});
