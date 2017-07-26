
var cartControl = false;
$('.cart-container .minus, .cart-container .plus, .cart-container .remove-control').on('click', function(e){
    if(cartControl) {
        e.preventDefault();
        return;
    }

    var error = $(this).closest('tr').find('.error');
    var id = $(this).attr('data-id');
    var action = $(this).hasClass('minus') ? 'minus' : ($(this).hasClass('plus') ? 'plus' : 'remove');
    cartControl = true;
    $.ajax({
        data: {'_token': $('meta[name="csrf-token"]').attr('content')},
        url: '/cart/product/'+id+'/'+action,
        method: 'post',
        success: function(response){
            if(response == '')
                location.reload();
            else {
                cartControl = false;
                error.text(response);
            }
        }
    });
});
