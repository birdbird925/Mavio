$('.filter').change(function() {
    if($('.filter:checked').length > 0) {
        $('.product-grid').fadeOut();
        var filterClass = [];
        var priceFilter = '';

        $.each($('.filter:checked'), function(){
            var type = $(this).attr('name');
            var value = $(this).val();

            switch(type) {
                case 'categories':
                    $('.category'+value).fadeIn();
                    break;

                case 'brands':
                    $('.brand'+value).fadeIn();
                    break;
            }
        });
    }
    else {
        $('.product-grid').fadeIn();
    }
});

var addCart = false;
$('.add-cart').on('click', function(e) {
    if(addCart) {
        e.preventDefault();
        return;
    }

    var quantity = $('select[name=quantity]').val();
    var id = $(this).attr('data-id');
    if(quantity == 0){
        $('.status').addClass('error');
        $('.status').text('Select quantity before add it to cart');
    }
    else {
        var addCart = true;
        $.ajax({
            data: {'_token': $('meta[name="csrf-token"]').attr('content')},
            url: '/cart/add/product/'+id+'?quantity='+quantity,
            method: 'post',
            success: function(response){
                addCart = false;
                if($.isNumeric(response)){
                    $('.status').removeClass('error');
                    $('.status').text('Success added to cart');
                }
                else {
                    $('.status').addClass('error');
                    $('.status').text(response);
                }
            }
        });
    }
});
