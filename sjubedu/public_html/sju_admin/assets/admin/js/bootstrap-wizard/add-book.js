var AddbooksWizard = function () {
    return {
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }
			
			
            var memoform = $('#addform');
    
			/*-----------------------------------------------------------------------------------*/
			/*	Validate the form elements
			/*-----------------------------------------------------------------------------------*/
			var baseurl=$('#base_url').val();
			
		$('#c_image').on('change', function () {

    if (!this.files || !this.files[0]) {
        return;
    }

    let file = this.files[0];
    let ext  = file.name.split('.').pop().toLowerCase();

    // TYPE CHECK
    if ($.inArray(ext, ['jpg', 'jpeg', 'png', 'webp']) === -1) {
        swal({
            title: "Invalid file",
            icon: "error",
            text: "Only JPG, JPEG, PNG or WEBP images are allowed"
        });
        this.value = '';
        $('#imgPreview').hide();
        return;
    }

    // SIZE CHECK (3MB)
    if (file.size > 3145728) {
        swal({
            title: "File too large",
            icon: "error",
            text: "Image size must be less than 3MB"
        });
        this.value = '';
        $('#imgPreview').hide();
        return;
    }

    // PREVIEW (ONLY VALID IMAGE)
    let reader = new FileReader();
    reader.onload = function (e) {
        $('#imgPreview').attr('src', e.target.result).show();
    };
    reader.readAsDataURL(file);
});

			
			$.validator.addMethod(
    "imageExtension",
    function (value, element) {
        if (element.files.length === 0) {
            return true; // optional image
        }
        let ext = value.split('.').pop().toLowerCase();
        return $.inArray(ext, ['jpg', 'jpeg', 'png', 'webp']) !== -1;
    },
    "Only JPG, JPEG, PNG or WEBP images are allowed"
);

$.validator.addMethod(
    "imageSize",
    function (value, element) {
        if (element.files.length === 0) {
            return true;
        }
        return element.files[0].size <= 3145728; // 3MB
    },
    "Image size must be less than 3MB"
);

			$.validator.addMethod("validUrl", function(value, element) {
    return this.optional(element) ||
        /^(https?:\/\/)?([\w-]+\.)+[\w-]{2,}(\/.*)?$/.test(value);
}, "Please enter a valid URL");
			
			
            memoform.validate({
                doNotHideMessage: true,
				errorClass: 'error-span',
                errorElement: 'span',
				ignore: [],      
                rules: {
					
					
                     c_url:{
						 validUrl: true
							},
				
					c_title:{
							required: true,
							minlength: 2,
						
							},	
					 c_image: {
							imageExtension: true,
							imageSize: true
						}	
					
					}, 
				messages:{
				
						c_url:{
							  required:'&nbsp;Please enter a valid url'
						  },
						 
						  c_title:{
							  required:'&nbsp;Please enter title',
							  minlength:'Title must have minimum 2 characters ',
						  },
						
							c_image: {
							imageExtension: 'Only JPG, JPEG, PNG or WEBP allowed',
							imageSize: 'Image size must be less than 2MB'
						}
				},
                                
			
              
                invalidHandler: function (event, validator) { 
                    //alert_success.hide();
                   // alert_error.show();
                },

                highlight: function (element) { 
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); 
                },

                unhighlight: function (element) { 
                    $(element)
                        .closest('.form-group').removeClass('has-error'); 
                },

                success: function (label) {
				 
                        label.addClass('valid') 
                        .closest('.form-group').removeClass('has-error').addClass('has-success'); 
                   
                }	
                
            });
				
	
			
			
			$('#formsubmit').click(function () {

    if (memoform.valid()) {

        $('#formsubmit').prop('disabled', true);
        $("#formsaveloader").html(
            "<img src='" + baseurl + "assets/admin/ajax-loaders/ajax-loader-1.gif'>"
        );

        let formData = new FormData($('#addform')[0]);

        $.ajax({
            type: "POST",
            url: baseurl + "save_book",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,

            success: function (data) {
                $('#formsubmit').prop('disabled', false);
                $("#formsaveloader").html("");

                if (data.status === true || data.status === 'success') {
                    $("#addform")[0].reset();
                    $('#imgPreview').hide();

                    swal({
                        title: "Success!",
                        icon: "success",
                        text: data.msg,
                        button: true,
                        timer: 20000
                    });
                } else {
                    swal({
                        title: "Alert!",
                        icon: "error",
                        text: data.msg,
                        button: true,
                        timer: 20000
                    });
                }
            },

            error: function () {
                $('#formsubmit').prop('disabled', false);
                $("#formsaveloader").html("");

                swal({
                    title: "Alert!",
                    icon: "error",
                    text: "Please try after sometime",
                    button: true,
                    timer: 20000
                });
            }
        });
    }
});
			
			
        }
    };
}();