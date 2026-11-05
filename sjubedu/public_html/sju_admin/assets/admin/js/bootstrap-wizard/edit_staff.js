var EditstaffWizard = function () {
    return {
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }
			   var handleMessengeralert = function (tp,msg) {
		
			var mytheme ='block';
			var mypos = 'messenger-on-top';
			//Set theme
			Messenger.options = {
				extraClasses: 'messenger-fixed '+mypos,
				theme: mytheme
			}
			//Call
			Messenger().post({
				message:msg,
				showCloseButton: true,
				type:tp
			});
		} 
			
            var addform = $('#addform');
			var baseurl=$('#base_url').val();
			/*$("#qualification").select2({
                placeholder: "Select qualification"
            });
			$("#upline_manager").select2({
                placeholder: "Select upline_manager"
            });*/
			
			
            
			/*-----------------------------------------------------------------------------------*/
			/*	Validate the form elements
			/*-----------------------------------------------------------------------------------*/
			
            addform.validate({
                doNotHideMessage: true,
				errorClass: 'error-span',
                errorElement: 'span',
				ignore: [],     
                rules: {
                    c_name:{
							required: true,
							},
					 c_mobile:{
							required: true,
							},
					c_email:{
							required: true,
							},
					
							
				},
				messages:{
					c_name:{
							  required:'&nbsp;Please enter name',
							
						  },
					c_mobile:{
							  required:'&nbsp;Please enter Mobile Number',
						  },
					c_email:{
							  required:'&nbsp;Please enter Email',
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
                        .closest('.form-group').removeClass('has-error').addClass('has-succSess'); 
                }	
            });
					$('#formsubmit').click(function(){
						if(addform.valid()){
							$("#formsaveloader").html("<img src='"+baseurl+"assets/admin/ajax-loaders/ajax-loader-1.gif' title='Loader' >");
							var datastring = $("#addform").serialize();
							$.ajax({
								type: "POST",
								url: baseurl+"update_staff",
								data: datastring,
								dataType: "json",
								success: function(data) {
									$("#formsaveloader").html("");
									 if(data.status == 'success'){
										   swal({title: "Success!", icon: "success", text: data.msg, button: true, timer: 20000});
										 }
										  else if(data.status == 'error'){
										    swal({title: "Alert!", icon: "error", text:data.msg , button: true, timer: 20000});
										 }
										 else {
										     swal({title: "Alert!", icon: "error", text: "Please try again later", button: true, timer: 20000});
										 }
									},
								error: function() {
									swal({title: "Alert!", icon: "error", text: "Please try again later", button: true, timer: 20000});
								}
							});
					}
			});
        }
    };
}();