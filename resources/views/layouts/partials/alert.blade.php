@if(count($errors) > 0)
    <script>
    $.notify({
        icon: 'pe-7s-warning',
        message: "{{ $errors->first() }}"
    },{
        type: 'warning',
        timer: 4000,
        placement: {
            from: 'bottom',
            align: 'center'
        }
    });
    </script>
@endif
