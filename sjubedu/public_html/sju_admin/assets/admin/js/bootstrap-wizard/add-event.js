var AddeventWizard = function () {
    return {
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }
			
			
            var memoform = $('#addform');
    
	//COVER PIC
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



/////////////////////////////////////PDF


$('#c_pdf').on('change', function () {

    if (!this.files || !this.files[0]) {
        return;
    }

    let file = this.files[0];
    let ext  = file.name.split('.').pop().toLowerCase();

    // TYPE CHECK
    if ($.inArray(ext, ['jpg', 'jpeg', 'png', 'webp', 'pdf']) === -1) {
        swal({
            title: "Invalid file",
            icon: "error",
            text: "Only JPG, JPEG, PNG, WEBP or PDF files are allowed"
        });
        this.value = '';
        $('#PDFimgPreview').hide();
        $('#pdfPreview').remove();
        return;
    }

    // SIZE CHECK (3MB)
    if (file.size > 3145728) {
        swal({
            title: "File too large",
            icon: "error",
            text: "File size must be less than 3MB"
        });
        this.value = '';
        $('#PDFimgPreview').hide();
        $('#pdfPreview').remove();
        return;
    }

    // REMOVE OLD PDF PREVIEW
    $('#pdfPreview').remove();

    // IMAGE PREVIEW
    if (ext !== 'pdf') {
        let reader = new FileReader();
        reader.onload = function (e) {
            $('#PDFimgPreview').attr('src', e.target.result).show();
        };
        reader.readAsDataURL(file);
    } 
    // PDF PREVIEW
    else {
        $('#PDFimgPreview').hide();

        let pdfHtml = `
            <div id="pdfPreview" style="margin-top:10px;">
                <p>📄 ${file.name}</p>
            </div>
        `;
        $('#c_pdf').after(pdfHtml);
    }
});

			
	$.validator.addMethod("fileExtension", function(value, element) {
    let ext = value.split('.').pop().toLowerCase();
    return this.optional(element) || ['jpg','jpeg','png','webp','pdf'].includes(ext);
}, "Only JPG, JPEG, PNG, WEBP or PDF files are allowed");

$.validator.addMethod("fileSize", function(value, element) {
    if (element.files.length === 0) {
        return true;
    }
    return element.files[0].size <= 3145728; // 3MB
}, "File size must be less than 3MB");	

	//URL VALIDATION
	
	
	$.validator.addMethod("validUrl", function(value, element) {
    return this.optional(element) ||
        /^(https?:\/\/)?([\w-]+\.)+[\w-]{2,}(\/.*)?$/.test(value);
}, "Please enter a valid URL");
	
	
			/*-----------------------------------------------------------------------------------*/
			/*	Validate the form elements
			/*-----------------------------------------------------------------------------------*/
			var baseurl=$('#base_url').val();
            memoform.validate({
                doNotHideMessage: true,
				errorClass: 'error-span',
                errorElement: 'span',
				ignore: [],      
                rules: {
					
					    'c_type[]':{
							required: true,
							}, 
					 c_email:{
							email: true
							},
                     event_name:{
							required: true,
							minlength: 2,
							},
				
					description:{
							required: true,
							minlength: 2,
						
							},		
					d_start_date:{
							required: true,
							 },
					d_end_date:{
							required: true,
							 },
					c_image: {
							required: true,
							imageExtension: true,
							imageSize: true
						},
						c_pdf: {
								required: function () {
									return $('input[name="c_file_type"]:checked').val() === 'File';
								},
								fileExtension: true,
								fileSize: true
							},
					
							c_url: {
								required: function () {
									return $('input[name="c_file_type"]:checked').val() === 'URL';
								},
								validUrl: true
							},
					
							c_text: {
								required: function () {
									return $('input[name="c_file_type"]:checked').val() === 'Text';
								}
							},
								c_registration_link: {
								required: function () {
									return $('input[name="c_registration"]:checked').val() === 'Yes';
								},
								validUrl: true
							}
					}, 
				messages:{
						'c_type[]':{
							  required:'&nbsp;Please choose where to show',
						},
						c_email:{
							email: "Please enter a valid email address"
						},
						event_name:{
							  required:'&nbsp;Please enter Event Title',
							  	minlength:'Event Title must have minimum 2 characters ',
						  },
						 
						  description:{
							  required:'&nbsp;Please enter Event details',
							  minlength:'Event details must have minimum 2 characters ',
						  },
							d_start_date:{
							  required:'&nbsp;Please Choose Event Start Date',
							},
							d_end_date:{
							  required:'&nbsp;Please Choose Event End Date',
							},
							c_image: {
							required:'&nbsp;Please Choose an Image',
							imageExtension: 'Only JPG, JPEG, PNG or WEBP allowed',
							imageSize: 'Image size must be less than 2MB'
						},
						c_pdf: {
							required:'&nbsp;Please Choose an Image or PDF file',
							fileExtension: 'Only JPG, JPEG, PNG ,WEBP or PDF allowed',
							fileSize: 'Image size must be less than 3MB'
						},
				
						c_url:{
							  required:'&nbsp;Please enter a valid url'
						  },
						  c_text:{
							  required:'&nbsp;Please enter text'
						  },
						   c_registration_link: {
								required: "Please enter registration link",
								valid_url: "Enter a valid URL"
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
            url: baseurl + "save_event",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,

            success: function (data) {
                $('#formsubmit').prop('disabled', false);
                $("#formsaveloader").html("");

                if (data.status === true || data.status === 'success') {
                    $("#addform")[0].reset();
					$('#addform div.has-success').removeClass('has-success');
                    $('#imgPreview').hide();
					$('#pdfPreview').hide();
					$('#PDFimgPreview').hide();
					$('#c_type').val([]).trigger('change');
					$('.url-box, .text-box').hide();
					$('.file-box').show();
					$('.registration-box').hide();
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