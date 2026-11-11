</header>
<!--/HEADER -->

<!-- PAGE -->
<section id="page">
  <!-- SIDEBAR -->
  <?php  $this->load->view('admin/sidemenu');?>
  <!-- /SIDEBAR -->
  
  <div id="main-content">
    <div class="container">
      <div class="row">
        <div id="content" class="col-lg-12"> 
          <!-- PAGE HEADER-->
          <div class="row">
            <div class="col-sm-12">
              <div class="page-header"> 
                <!-- STYLER --> 
                
                <!-- /STYLER --> 
                <!-- BREADCRUMBS -->
                <ul class="breadcrumb">
                  <li></li>
                </ul>
                <!-- /BREADCRUMBS -->
                <div class="box border primary">
                  <div class="box-title">
                    <h4><i class="fa fa-bars"></i>Add Event</h4>
                  </div>
                  <div class="box-body big">
                    <input type="hidden" id="base_url" value="<?php echo site_url() ?>">
                    <form role="form" method="post" class="form-horizontal" id="addform" autocomplete="off">
                      <legend>Event Details</legend>
                       <div class="form-group" >
                        <label class="col-sm-3 control-label">Show in </label>
                        <div class="col-sm-4">
                        <select name="c_type[]" id="c_type" style="width:100%;" multiple>
    <option value="">Select</option>

    <?php
    $data = [
       'Homepage','Library',
        'School of Business' => ['Commerce', 'Management'],
		'School of Chemical Sciences' => ['Biochemistry', 'Chemistry'],
		'School of Humanities & Social Sciences' => ['Economics', 'History', 'Industrial Relations', 'International Relations, Peace & Public Policy ', 'Political Science', 'Psychology & Counselling', 'Social Science', 'Sociology'],
		'School of Languages & Literatures' => ['English', 'Foreign Language', 'Hindi', 'Journalism', 'Kannada', 'Sanskrit', 'Tamil'],
		'School of Life Sciences' => ['Biology', 'Biotechnology', 'Botany', 'Environemental Science', 'Food Science & Technology', 'Microbiology', 'Zoology'],
		'School of Physical Sciences' => ['Electronics', 'Mathematics', 'Physics', 'Statics'],
		'School of Social Work' => ['Social Work'],
		'School of Communication & Media Studies' => ['School of Communication & Media Studies'],
		'School of Information Technology' => ['Advanced Computing', 'Computer Science'],
		 
    ];

    foreach ($data as $key => $value) {

        if (is_array($value)) {
            echo '<optgroup label="'.$key.'">';
            foreach ($value as $sub) {
                echo '<option value="'.$sub.'">'.$sub.'</option>';
            }
            echo '</optgroup>';
        } else {
            echo '<option value="'.$value.'">'.$value.'</option>';
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
                          <input type="text"  class="form-control" id="event_name" value="" name="event_name">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-3 control-label"> Event details</label>
                        <div class="col-sm-4">
                          <textarea   class="form-control" id="description"  name="description" rows="5" ></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                <label class="col-sm-3 control-label">Cover pic</label>
                <div class="col-sm-4">
                    <input type="file"  class="form-control"  name="c_image" id="c_image" 
                           accept="image/jpeg,image/png,image/webp">
                    <img id="imgPreview" 
                         style="display:none;margin-top:10px;width:120px;border:1px solid #ddd;">
                </div>
            </div>
            
            
            <div class="form-group">
                        <label class="col-sm-3 control-label"> Type</label>
                        <div class="col-sm-4">
                          <input type="radio" value="File" name="c_file_type" checked>&nbsp;File&nbsp;&nbsp;<input type="radio"   value="URL" name="c_file_type">&nbsp;URL&nbsp;&nbsp;<input type="radio" value="Text" name="c_file_type">&nbsp;Text
                        </div>
                      </div>
            
            
           <!-- FILE -->
<div class="form-group file-box">
    <label class="col-sm-3 control-label">Image or PDF</label>
    <div class="col-sm-4">
        <input type="file" class="form-control" name="c_pdf" id="c_pdf" 
               accept="image/jpeg,image/png,image/webp,application/pdf">
        <img id="PDFimgPreview" 
             style="display:none;margin-top:10px;width:120px;border:1px solid #ddd;">
    </div>
</div>

<!-- URL -->
<div class="form-group url-box">
    <label class="col-sm-3 control-label">URL</label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="c_url" name="c_url">
    </div>
</div>

<!-- TEXT -->
<div class="form-group text-box">
    <label class="col-sm-3 control-label">Text</label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="c_text" name="c_text">
    </div>
</div>
            
                    <div class="form-group">
                        <label class="control-label col-md-3">Event Start Date</label>
                        <div class="col-md-4">
                          <input class="form-control " id="d_start_date" type="text" name="d_start_date"  placeholder="Event Start Date" readonly="">
                          <span class="error-span"></span> </div>
                      </div>
                     <div class="form-group">
                        <label class="control-label col-md-3">Event End Date</label>
                        <div class="col-md-4">
                          <input class="form-control " id="d_end_date" type="text" name="d_end_date"  placeholder="Event End Date" readonly="">
                          <span class="error-span"></span> </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label"> Venue</label>
                        <div class="col-sm-4">
                          <input type="text"  class="form-control" id="c_venue" value="" name="c_venue">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label"> Phone</label>
                        <div class="col-sm-4">
                          <input type="text"  class="form-control" id="c_phone" value="" name="c_phone" maxlength="10">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label"> Email</label>
                        <div class="col-sm-4">
                          <input type="text"  class="form-control" id="c_email" value="" name="c_email">
                        </div>
                      </div>
                      
                      
                       <div class="form-group">
                        <label class="col-sm-3 control-label"> Require registration?</label>
                        <div class="col-sm-4">
                          <input type="radio" value="Yes" name="c_registration" >&nbsp;Yes&nbsp;&nbsp;<input type="radio"   value="No" name="c_registration" checked>&nbsp;No
                        </div>
                      </div>
                      <div class="form-group registration-box">
                        <label class="col-sm-3 control-label"> Registration Link</label>
                        <div class="col-sm-4">
                          <input type="text"  class="form-control" id="c_registration_link" value="" name="c_registration_link">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-4">
                          <button id="formsubmit" class="btn btn-success" type="button" >Submit</button>
                          <span id="formsaveloader" class="marginleft"></span> </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /PAGE HEADER --> 
        </div>
      </div>
    </div>
  </div>
</section>
<!-- JAVASCRIPTS -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- SELECT2 -->
<!-- BOOTSTRAP -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/js/jquery-ui-1.10.3.custom/css/custom-theme/jquery-ui-1.10.3.custom.min.css');?>" />


<script src="<?php echo base_url('assets/admin/js/bootstrap-dist/js/bootstrap.min.js');?>"></script>

<!-- COOKIE -->
<script type="text/javascript" src="<?php echo base_url('assets/admin/js/jQuery-Cookie/jquery.cookie.min.js');?>"></script>
<!-- SELECT2 -->
<script type="text/javascript" src="<?php echo base_url('assets/admin/js/select2/select2.min.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/js/select2/select2.min.css');?>" />
<script src="<?php echo base_url('assets/admin/js/bootstrap-wizard/jquery.bootstrap.wizard.min.js');?>"></script>
<script src="<?php echo base_url('assets/admin/js/jquery-validate/jquery.validate.min.js');?>"></script>

<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/js/datepicker/themes/default.min.css');?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/js/datepicker/themes/default.date.min.css');?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/js/datepicker/themes/default.time.min.css');?>" />-->

<!--<script type="text/javascript" src="<?php echo base_url('assets/admin/js/datepicker/picker.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/admin/js/datepicker/picker.date.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/admin/js/datepicker/picker.time.js');?>"></script>-->

<script src="<?php echo base_url('assets/admin/js/bootstrap-wizard/add-event.js');?>"></script>
<script src="<?php echo base_url('assets/admin/js/swal.js');?>"></script>
<!-- CUSTOM SCRIPT -->
<script src="<?php echo base_url('assets/admin/js/script.js');?>"></script>
<script>
		jQuery(document).ready(function() {		
			App.setPage("add_subcategory");  //Set current page
			App.init(); //Initialise plugins and elements
			AddeventWizard.init();
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
				
				function toggleFields(value) {
					$('#c_pdf').val('');
					$('#c_url').val('');
					$('#c_text').val('');
					$('#PDFimgPreview').hide();
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
			
				// 🔥 Show default selected on load
				toggleFields($('input[name="c_file_type"]:checked').val());
			
				// On change
				$('input[name="c_file_type"]').on('change', function () {
					toggleFields($(this).val());
				});
				
				
				 function toggleRegistration(value) {
					if (value === 'Yes') {
						$('.registration-box').show();
					} else {
						$('.registration-box').hide();
						$('#c_registration_link').val(''); // optional clear
					}
				}
			
				// 🔥 initial load (Yes is checked by default)
				toggleRegistration($('input[name="c_registration"]:checked').val());
			
				// on change
				$('input[name="c_registration"]').on('change', function () {
					toggleRegistration($(this).val());
				});

		});

		
	</script>
<!-- /JAVASCRIPTS -->
</body>
</html>