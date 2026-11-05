<?php

		 $sql2= "SELECT event_name,description,d_start_date,c_image,c_type,d_end_date,c_file_type,c_pdf,c_url,c_text,
 		c_registration,c_registration_link,c_venue,c_phone,c_email  from events where id = $cnid";
		$event_name="";$description="";$c_address="";
		$result2 = $this->Sju_management_model->get_results($sql2);
		if($result2)
		{
			foreach($result2 as $row)
				{
					$event_name 				= $row->event_name;
					$description 	= $row->description;
					$c_image 	    = $row->c_image;
					//$c_type 	    = $row->c_type;
					
					$c_file_type 	    = $row->c_file_type;
					$c_pdf 	    = $row->c_pdf;
					$c_url 	    = $row->c_url;
					$c_text 	    = $row->c_text;
					$c_registration 	    = $row->c_registration;
					$c_registration_link 	    = $row->c_registration_link;
					$c_venue 	    = $row->c_venue;
					$c_phone 	    = $row->c_phone;
					$c_email 	    = $row->c_email;
					$ext ="";
					if($c_file_type=="File"){

               				$ext = strtolower(pathinfo($c_pdf, PATHINFO_EXTENSION));

              }

					
					
					
					if (!empty($row->d_start_date) && $row->d_start_date != '0000-00-00') {
									$d_start_date =  date('d-m-Y', strtotime($row->d_start_date));
								} else {
									$d_start_date = '';
								}
					if (!empty($row->d_end_date) && $row->d_end_date != '0000-00-00') {
									$d_end_date =  date('d-m-Y', strtotime($row->d_end_date));
								} else {
									$d_end_date = '';
								}
								
								
								
								$c_department_array = array();
								
								$sql2D= "SELECT c_department  from event_departments where events_id = $cnid";
								$c_department="";
								$result2D = $this->Sju_management_model->get_results($sql2D);
								if($result2D)
								{
									foreach($result2D as $rowD)
										{
											$c_department_array[] = $rowD->c_department; 
											
										}
								}
				}
		}
		?>
					<div class="box border primary">
                  <div class="box-title">
                    <h4><i class="fa fa-bars"></i>Edit Event</h4>
                    <div class="tools">												
		<a id="closeedit" class="remove closeedit" href="javascript:;">
			<i class="fa fa-times"></i>
		</a>
	</div>
                  </div>
                  <div class="box-body big">
                    <input type="hidden" id="base_url" value="<?php echo site_url() ?>">
                    
                    
                    <form role="form" method="post" class="form-horizontal" id="addform" autocomplete="off">
                    <input type="hidden" name="editid" value="<?php echo $cnid;?>" />
                      <legend>Event Details</legend>
                      <div class="form-group" >
                        <label class="col-sm-3 control-label">Show in </label>
                        <div class="col-sm-4">
                        
    <select name="c_type[]" id="c_type" style="width:100%;" multiple>

<?php

$data = [
	'Homepage','Library',
    'School of Business' => ['Commerce', 'Management'],
    'School of Chemical Sciences' => ['Biochemistry', 'Chemistry'],
    'School of Humanities & Social Sciences' => [
        'Economics', 'History', 'Industrial Relations',
        'International Relations, Peace & Public Policy',
        'Political Science', 'Psychology & Counselling',
        'Social Science', 'Sociology'
    ],
    'School of Languages & Literatures' => [
        'English', 'Foreign Language', 'Hindi', 'Journalism',
        'Kannada', 'Sanskrit', 'Tamil'
    ],
    'School of Life Sciences' => [
        'Biology', 'Biotechnology', 'Botany',
        'Environemental Science', 'Food Science & Technology',
        'Microbiology', 'Zoology'
    ],
    'School of Physical Sciences' => [
        'Electronics', 'Mathematics', 'Physics', 'Statics'
    ],
    'School of Social Work' => ['Social Work'],
    'School of Communication & Media Studies' => ['School of Communication & Media Studies'],
    'School of Information Technology' => ['Advanced Computing', 'Computer Science'],
];



foreach ($data as $key => $value) {

    // If it is a normal value (Homepage / Library)
    if (!is_array($value)) {

        $selected = (in_array(trim($value), $c_department_array)) ? 'selected' : '';

        echo '<option value="'.$value.'" '.$selected.'>'.$value.'</option>';

    } 
    // If it is an optgroup
    else {

        echo '<optgroup label="'.$key.'">';

        foreach ($value as $sub) {

            $selected = (in_array(trim($sub), $c_department_array)) ? 'selected' : '';

            echo '<option value="'.$sub.'" '.$selected.'>'.$sub.'</option>';
        }

        echo '</optgroup>';
    }
}

?>

</select>

                          
                          <span for="c_type" class="error-span"></span> </div>
                        <div id="loadsub2"></div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label"> Event Title</label>
                        <div class="col-sm-4">
                          <input type="text"  class="form-control" id="event_name" value="<?php echo $event_name;?>" name="event_name">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-3 control-label"> Event details</label>
                        <div class="col-sm-4">
                          <textarea   class="form-control" id="description"  name="description" rows="5" ><?php echo $description;?></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                <label class="col-sm-3 control-label"> Image</label>
                <div class="col-sm-4">
                    <input type="file"  class="form-control"  name="c_image" id="c_image" 
                           accept="image/jpeg,image/png,image/webp">
                    
                       <?php  if (!empty($c_image)) {?>
                         <img id="imgPreview"
     src="<?= base_url('assets/admin/uploads/events/original/'.$c_image); ?>"
     style="width:120px;border:1px solid #ddd;">
                         
                         <?php }?>
                </div>
            </div>
            
            
            
             <div class="form-group">
                        <label class="col-sm-3 control-label"> Type</label>
                        <div class="col-sm-4">
                       
                            
                            <input type="radio" value="File" name="c_file_type"
                            <?php if($c_file_type == 'File') echo 'checked'; ?> >
                            &nbsp;File&nbsp;&nbsp;
                            
                            <input type="radio" value="URL" name="c_file_type"
                            <?php if($c_file_type == 'URL') echo 'checked'; ?> >
                            &nbsp;URL&nbsp;&nbsp;
                            
                            <input type="radio" value="Text" name="c_file_type"
                            <?php if($c_file_type == 'Text') echo 'checked'; ?> >
                            &nbsp;Text
                        </div>
                      </div>
            
            
           <!-- FILE -->
<div class="form-group file-box">
    <label class="col-sm-3 control-label">Image or PDF</label>
    <div class="col-sm-4">
        <input type="file" class="form-control" name="c_pdf" id="c_pdf" 
               accept="image/jpeg,image/png,image/webp,application/pdf">
        <img id="PDFimgPreview" 
             style="margin-top:10px;width:120px;border:1px solid #ddd;">
    </div>
</div>

<!-- URL -->
<div class="form-group url-box">
    <label class="col-sm-3 control-label">URL</label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="c_url" name="c_url" value="<?php echo $c_url;?>">
    </div>
</div>

<!-- TEXT -->
<div class="form-group text-box">
    <label class="col-sm-3 control-label">Text</label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="c_text" name="c_text" value="<?php echo $c_text;?>">
    </div>
</div>
            
                    <div class="form-group">
                        <label class="control-label col-md-3">Event Start Date</label>
                        <div class="col-md-4">
                          <input class="form-control " id="d_start_date" type="text" name="d_start_date"  placeholder="Event Start Date" readonly="" value="<?php echo $d_start_date;?>">
                          <span class="error-span"></span> </div>
                      </div>
                     <div class="form-group">
                        <label class="control-label col-md-3">Event End Date</label>
                        <div class="col-md-4">
                          <input class="form-control " id="d_end_date" type="text" name="d_end_date"  placeholder="Event End Date" readonly="" value="<?php echo $d_end_date;?>">
                          <span class="error-span"></span> </div>
                      </div>
                      
                      
                       <div class="form-group">
                        <label class="col-sm-3 control-label"> Venue</label>
                        <div class="col-sm-4">
                          <input type="text"  class="form-control" id="c_venue" value="<?php echo $c_venue;?>" name="c_venue">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label"> Phone</label>
                        <div class="col-sm-4">
                          <input type="text"  class="form-control" id="c_phone" value="<?php echo $c_phone;?>" name="c_phone" maxlength="10">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label"> Email</label>
                        <div class="col-sm-4">
                          <input type="text"  class="form-control" id="c_email" value="<?php echo $c_email;?>" name="c_email">
                        </div>
                      </div>
                      
                      
                       <div class="form-group">
                        <label class="col-sm-3 control-label"> Require registration?</label>
                        <div class="col-sm-4">
                          <input type="radio" value="Yes" name="c_registration" <?php if($c_registration == 'Yes') echo 'checked'; ?> >&nbsp;Yes&nbsp;&nbsp;<input type="radio"   value="No" name="c_registration" <?php if($c_registration == 'No') echo 'checked'; ?>>&nbsp;No
                        </div>
                      </div>
                      <div class="form-group registration-box">
                        <label class="col-sm-3 control-label"> Registration Link</label>
                        <div class="col-sm-4">
                          <input type="text"  class="form-control" id="c_registration_link" value="<?php echo $c_registration_link;?>" name="c_registration_link">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-4">
                          <button id="formsubmit" class="btn btn-success" type="button" >Submit</button>
                          <button  class="btn btn-danger closeedit" type="button" >Close</button>
                          <span id="formsaveloader" class="marginleft"></span> </div>
                      </div>
                    </form>
                    
                    
                    
                    
                  </div>
                </div>
<!-- JAVASCRIPTS -->
<script src="<?php echo base_url('assets/admin/js/swal.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/js/jquery-ui-1.10.3.custom/css/custom-theme/jquery-ui-1.10.3.custom.min.css');?>" />
    <!-- CUSTOM SCRIPT 
	<script src="<?php echo base_url('assets/admin/');?>js/script.js"></script>-->
	<script src="<?php echo base_url('assets/admin/js/bootstrap-wizard/jquery.bootstrap.wizard.min.js');?>"></script>
    <script src="<?php echo base_url('assets/admin/js/jquery-validate/jquery.validate.min.js');?>"></script>
	<script src="<?php echo base_url('assets/admin/js/bootstrap-wizard/edit-event.js');?>"></script>	
	<script>
		jQuery(document).ready(function() {		
			
			EditeventWizard.init();
			$('#c_type').select2();
		$("#d_start_date").datepicker({
				dateFormat: 'dd-mm-yy',
				changeMonth: true,
				changeYear: true,//minDate:0,
				onSelect: function(){
					$('#d_end_date').datepicker('option', 'minDate', $("#d_start_date").datepicker("getDate"));
				}
				});
				
				$("#d_end_date").datepicker({
				dateFormat: 'dd-mm-yy',
				changeMonth: true,
				changeYear: true,//minDate:0,
				minDate:  new Date()
				});	
				
				
				 var fileType = "<?php echo $c_file_type; ?>";   // value from DB
			
				toggleFields(fileType);   // show correct box on page load
			
				$('input[name="c_file_type"]').on('change', function () {
					toggleFields($(this).val());
				});
				
				function toggleFields(value) {
					//$('#c_pdf').val('');
					//$('#c_url').val('');
					//$('#c_text').val('');
					//$('#PDFimgPreview').hide();
					$('.file-box, .url-box, .text-box').hide();
			
					if (value === 'File') {
						$('.file-box').show();
					} 
					else if (value === 'URL') {
						$('.url-box').show();
					} 
					else if (value === 'Text') {
						$('.text-box').show();
					}
					
				}
			
				// ðŸ"¥ Show default selected on load
				toggleFields($('input[name="c_file_type"]:checked').val());
			
				// On change
				$('input[name="c_file_type"]').on('change', function () {
					toggleFields($(this).val());
				});
				
			var c_file_type = "<?php echo $c_file_type; ?>";
			var ext = "";
			if(c_file_type=='File')	{
					
				var ext = "<?php echo $ext; ?>";
				
// IMAGE PREVIEW
if (ext !== 'pdf') {


        $('#PDFimgPreview').attr('src', 'assets/admin/uploads/events/pdf/<?php echo $c_pdf;?>').show();
 

   // reader.readAsDataURL(file);
} 
// PDF PREVIEW
else {

    $('#PDFimgPreview').hide();

    let pdfHtml = `
        <div id="pdfPreview" style="margin-top:10px;">
            <p>&#128196; <?php echo $c_pdf;?></p>
        </div>
    `;

    $('#c_pdf').after(pdfHtml);
}
				
		}	
		else {
		 $('#PDFimgPreview').hide();	
		}
				
				
				
				 function toggleRegistration(value) {
					if (value === 'Yes') {
						$('.registration-box').show();
					} else {
						$('.registration-box').hide();
						$('#c_registration_link').val(''); // optional clear
					}
				}
			
				// ðŸ"¥ initial load (Yes is checked by default)
				toggleRegistration($('input[name="c_registration"]:checked').val());
			
				// on change
				$('input[name="c_registration"]').on('change', function () {
					toggleRegistration($(this).val());
				});

		});

	</script>
