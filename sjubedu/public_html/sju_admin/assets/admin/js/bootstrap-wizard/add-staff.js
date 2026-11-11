var AddstaffWizard = function () {
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
            memoform.validate({
                doNotHideMessage: true,
				errorClass: 'error-span',
                errorElement: 'span',
				ignore: [],      
                rules: {
					
                     c_name:{
							required: true,
							},
					
					c_password:{
							required: true,
							},
				
					c_mobile: {
							required: true,
							digits: true,
							minlength: 10,
							remote: "mobile_number_check"
					     	},
					c_email:{
							required: true,
							email: true,
							},
					
					}, 
				messages:{
				
						c_name:{
							  required:'&nbsp;Please enter name',
						  },
						 
						 c_password:{
							  required:'&nbsp;Please enter password',
						  },
						 c_mobile:{
								required:'Please enter a valid mobile no.',
								digits:'Allow only digits',
								minlength:'Mobile number must have 10 digits',
								remote: "This mobile number is already registered with us"
							},
							 c_email:{
							  required:'&nbsp;Please enter a valid email ID',
							  email:'&nbsp;Please enter a valid email ID',
						  },

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
				
		
			
				$('#formsubmit').click(function(){
					
				if(memoform.valid()){
					$('#formsubmit').prop('disabled', true);
					$("#formsaveloader").html("<img src='"+baseurl+"assets/admin/ajax-loaders/ajax-loader-1.gif' title='Loader' >");
					var datastring = $("#addform").serialize();
							$.ajax({
								type: "POST",
								url: baseurl+"save_staff",
								data: datastring,
								dataType: "json",
								success: function(data) {
									$('#formsubmit').prop('disabled', false);
									$("#formsaveloader").html("");
									 if(data.status== 'success'){
										 $("#addform")[0].reset();
										
										    swal({title: "Success!", icon: "success", text: data.msg,button: true, timer: 20000});
										 }
										 else if(data.status == 'error'){
										    swal({title: "Alert!", icon: "error", text:data.msg , button: true, timer: 20000});
										 }
										 else {
										     swal({title: "Alert!", icon: "error", text: data.msg, button: true, timer: 20000});
										 }
										 
								},
								error: function() {
									 swal({title: "Alert!", icon: "error", text:"Please try after sometime", button: true, timer: 20000});
								}
							});
					
					}				
			});
        }
    };
}();