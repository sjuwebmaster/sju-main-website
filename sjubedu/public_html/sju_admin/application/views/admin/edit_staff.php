<div class="box border primary">
											<div class="box-title">
												<h4><i class="fa fa-bars"></i>Edit staff</h4>
												<div class="tools">												
		<a id="closeedit" class="remove closeedit" href="javascript:;">
			<i class="fa fa-times"></i>
		</a>
	</div>
											</div>
	<div class="box-body big">
		<input type="hidden" id="base_url" value="<?php echo base_url() ?>">
		<form role="form" method="post" class="form-horizontal" id="addform" autocomplete="off" >
									
	 <?php
	     $username = $this->session->userdata('name');
	     $cyear=date('y');
	
		 $sql2= "SELECT c_name,c_mobile,c_email from staff_master where n_id = $cnid";
		$c_name="";$c_mobile="";$c_address="";
		$result2 = $this->Sju_management_model->get_results($sql2);
		if($result2)
		{
			foreach($result2 as $row)
				{
					$c_name 				= $row->c_name;
					$c_mobile 				= $row->c_mobile;
					$c_email 				= $row->c_email;
			
					
					
				}
		}
	?>
	
																				
                                          <div class="form-group">
											<label class="col-sm-3 control-label"> Name </label>
												<div class="col-sm-4">
												<input type="hidden" name="editid" value="<?php echo $cnid;?>" />
												<input type="text"  class="form-control" id="c_name" value="<?php echo $c_name; ?>" name="c_name">
												 </div>
                                             </div>
                                      <div class="form-group">
											<label class="col-sm-3 control-label"> Mobile </label>
												<div class="col-sm-4">
												  <input maxlength="10" type="text"  class="form-control" id="c_mobile" value="<?php echo $c_mobile; ?>" name="c_mobile">
												 </div>
                                             </div>
											 
											 <div class="form-group">
											<label class="col-sm-3 control-label"> Email</label>
												<div class="col-sm-4">
												  <input type="text"  class="form-control" id="c_email" value="<?php echo $c_email; ?>" name="c_email">
												 </div>
                                             </div>
											 
											
								
											 <div class="form-group">
											<label class="col-sm-3 control-label"> Password</label>
												<div class="col-sm-4">
												  <input name="c_password" type="text"  class="form-control" id="c_password" value="" maxlength="20">
												 </div>
                                             </div>
								
				
											 
												<div class="form-group">
													<label class="col-sm-3 control-label"></label>
														<div class="col-sm-4">
  															<button id="formsubmit" class="btn btn-success" type="button" >Save changes</button>	
															<button  class="btn btn-danger closeedit" type="button" >Close</button>
                                                            <span id="formsaveloader" class="marginleft"></span>															
                                                        </div>
                                                  </div>
              									</form>
                                                <input type="hidden" id="base_url" value="<?php echo site_url() ?>">
						</div>
</div>
    <!-- JAVASCRIPTS -->

    <script src="<?php echo base_url('assets/admin/js/swal.js');?>"></script>
    <!-- CUSTOM SCRIPT 
	<script src="<?php echo base_url('assets/admin/');?>js/script.js"></script>-->
	<script src="<?php echo base_url('assets/admin/js/bootstrap-wizard/jquery.bootstrap.wizard.min.js');?>"></script>
    <script src="<?php echo base_url('assets/admin/js/jquery-validate/jquery.validate.min.js');?>"></script>
	<script src="<?php echo base_url('assets/admin/js/bootstrap-wizard/edit_staff.js');?>"></script>	
	<script>
		jQuery(document).ready(function() {		

			EditstaffWizard.init();
							
		});
	</script>
