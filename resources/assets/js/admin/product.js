// product data table
$('#productTable').DataTable({
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

$('#productTable').on( 'click', 'tbody tr', function () {
    window.location.href = $(this).attr('href');
});

// tag inputs
if($('input[name="tag"]').get(0)){
    $('input[name="tag"]').tagsInput({
        'defaultText': '',
        'width': '100%',
        'height': 'auto',
    });
}

// save product button clicked
$('#btnSaveProduct').click(function() {
    var formData = {};
    var errorMsg = '';
    // title validation
    var title = $('input[name="title"]').val();
    if(title.trim() == '') errorMsg += '<li>Product title can\'t be blank</li>';
    // product image validation
    var images = $('input[name="productImage"]').val();
    if(images == '') errorMsg += '<li>At least upload one photo as product image</li>';
    // price validation
    var price = $('input[name="price"]').val();
    if(price <= 0 || price == '') errorMsg += '<li>Product price can\'t be blank and it must bigger than zero</li>';
    // compare price validation
    var compare_price = $('input[name="compare_price"]').val();
    if(compare_price != '' && compare_price <= price) errorMsg += '<li>Product compare price must bigger than product price</li>';
    var quantity = $('input[name="quantity"]').val();

    if(errorMsg != '') {
        $.notify({
    		icon: 'pe-7s-attention',
    		message: '<ul>'+errorMsg+'</ul>'
    	},{
    		type: 'warning',
    		timer: 4000,
    		placement: {
    			from: 'bottom',
    			align: 'center'
    		}
    	});
    }
    else {
        formData._token = $('meta[name="csrf-token"]').attr('content');
        formData.title = title;
        formData.description = CKEDITOR.instances.description.getData();
        formData.images = images;
        formData.visible = (($('input[name="visible"]').is(':checked')) ? 1 : 0);
        formData.type = $('input[name="type"]').val();
        formData.vendor = $('input[name="vendor"]').val();
        formData.tag = $('input[name="tag"]').val();
        formData.price = price;
        formData.compare_price = compare_price;
        formData.quantity = (quantity == '' ? 0 : quantity );
        // update product mode
        if($('input[name="deleteImage"]').get(0)) {
            var id = $("#btnSaveProduct").attr('data-id');
            formData.deleteImages = $('input[name="deleteImage"]').val();
            formData._method = "put";
            $.ajax({
                data: formData,
                url: '/admin/product/'+id,
                method: 'post',
                dataType: 'json',
                error: function(a, b, c){
                    console.log(a.responseText);
                },
                success: function(response){
                    $.notify({
                		icon: 'pe-7s-bell',
                		message: 'Product successful updated'
                	},{
                		type: 'success',
                		timer: 3000,
                		placement: {
                			from: 'top',
                			align: 'right'
                		}
                	});
                    setTimeout(function(){ window.location.href = "/admin/product"; }, 1000);
                }
            });
        }
        else {
            $.ajax({
                data: formData,
                url: '/admin/product',
                method: 'POST',
                dataType: 'json',
                error: function(a, b, c){
                    console.log(a.responseText);
                },
                success: function(response){
                    $.notify({
                		icon: 'pe-7s-bell',
                		message: 'Product successful created'
                	},{
                		type: 'success',
                		timer: 3000,
                		placement: {
                			from: 'top',
                			align: 'right'
                		}
                	});
                    setTimeout(function(){ window.location.href = "/admin/product"; }, 1000);
                }
            });
        }
    }
});
