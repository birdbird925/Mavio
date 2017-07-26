// public
var counter = 0;
Dropzone.options.dropzoneForm = {
    paramName: "file",
    uploadMultiple: false,
    parallelUploads: 100,
    maxFilesize: 2,
    addRemoveLinks: false,
    clickable: '#dz-upload-triggle',
    dictFileTooBig: 'is bigger than 2MB',

    error: function(file, response) {
        $('.dz-preview.empty').last().remove();
        var errorMsg = "\""+file.name+"\" ";
        if(typeof response == 'string')
            errorMsg += response;
        else
            errorMsg += response.message;

        $.notify({
    		icon: 'pe-7s-attention',
    		message: errorMsg
    	},{
    		type: 'warning',
    		timer: 4000,
    		placement: {
    			from: 'bottom',
    			align: 'center'
    		}
    	});
    },
    success: function(file, done) {
        var imageWrapper = $('.dz-preview.empty').first();
        imageWrapper.find('.dz-image-preview').html('<img id="'+done.id+'" src="'+done.image+'" draggable="true" ondragstart="drag(event)" ondrop="dropToSwap(event)" ondragover="allowDrop(event)"/>');
        imageWrapper.attr('image-id', done.id);
        imageWrapper.append('<a href="#" class="dz-remove" data-dz-remove>Remove</a>');
        imageWrapper.toggleClass('empty');

        var productImage = $('input[name="productImage"]').val();

        if(productImage == '')
            var imageArray = [done.id];
        else {
            var imageArray = productImage.split(',');
            imageArray.push(done.id);
        }

        $('input[name="productImage"]').val(imageArray.toString());
    }
}

// remove link click
$("#dropzone-form").on("click", '.dz-remove', function (e) {
    e.preventDefault();
    e.stopPropagation();
    var element = $(this).parent('.dz-preview');
    var imageID = element.attr('image-id');
    var token = $('meta[name="csrf-token"]').attr('content');
    // is in edit mode, pendding to remove picture until user click save
    if($('input[name="deleteImage"]').get(0)) {
        var deleteImage = $('input[name="deleteImage"]').val();
        var imageArray = deleteImage.split(',');
        imageArray = imageArray.push(imageID);

        $('input[name="deleteImage"]').val(imageArray.toString());
    }
    else {
        $.ajax({
            data: {_token: token, id: imageID},
            url: '/image/delete',
            method: 'POST',
            dataType: 'text',
            error: function(a, b, c){
                console.log(a.responseText);
            },
            success: function(response){
                console.log('deleted image');
            }
        });
    }

    element.remove();

    var productImage = $('input[name="productImage"]').val();
    var imageArray = productImage.split(',');
    var newImageArray = [];
    $.each(imageArray, function(index, value) {
        if(value != imageID)
            newImageArray.push(value);
    });

    $('input[name="productImage"]').val(newImageArray.toString());

    if(newImageArray.toString() == '')
        $('.dropzone').toggleClass('dz-started');
});


// drag and drop
function allowDrop(e) {
    e.preventDefault();
}

function drag(e) {
    e.dataTransfer.setData("id", e.target.id);
}

function dropToSwap(e) {
    e.preventDefault();
    var dragImageID = e.dataTransfer.getData("id");
    var dragImageWrapper = $('#'+dragImageID).parent();
    var dragImage = dragImageWrapper.html();

    var dropImageID = e.target.id;
    var dropImageWrapper = $('#'+dropImageID).parent();
    var dropImage = dropImageWrapper.html();

    dragImageWrapper.parent().attr('image-id', dropImageID);
    dragImageWrapper.html(dropImage);
    dropImageWrapper.parent().attr('image-id', dragImageID);
    dropImageWrapper.html(dragImage);

    var productImage = $('input[name="productImage"]').val();
    var imageArray = productImage.split(',');
    var newImageArray = [];
    $.each(imageArray, function(index, value) {
        if(value == dragImageID)
            newImageArray.push(dropImageID);
        else if(value == dropImageID)
            newImageArray.push(dragImageID);
        else
            newImageArray.push(value);
    });
    $('input[name="productImage"]').val(newImageArray.toString());
}
