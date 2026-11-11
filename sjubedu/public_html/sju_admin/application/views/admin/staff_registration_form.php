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
                    <h4><i class="fa fa-bars"></i>Create Staff</h4>
                  </div>
                  <div class="box-body big">
                    <input type="hidden" id="base_url" value="<?php echo site_url() ?>">
                    <form role="form" method="post" class="form-horizontal" id="addform" autocomplete="off">
                      <legend>Staff Details</legend>
                      <div class="form-group">
                        <label class="col-sm-3 control-label"> Name</label>
                        <div class="col-sm-4">
                          <input type="text"  class="form-control" id="c_name" value="" name="c_name">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label"> Mobile </label>
                        <div class="col-sm-4">
                          <input maxlength="10" type="text"  class="form-control" id="c_mobile" value="" name="c_mobile">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label"> Email</label>
                        <div class="col-sm-4">
                          <input type="text"  class="form-control" id="c_email" value="" name="c_email">
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
<script src="<?php echo base_url('assets/admin/js/bootstrap-dist/js/bootstrap.min.js');?>"></script>

<!-- COOKIE -->
<script type="text/javascript" src="<?php echo base_url('assets/admin/js/jQuery-Cookie/jquery.cookie.min.js');?>"></script>
<!-- SELECT2 -->
<script src="<?php echo base_url('assets/admin/js/bootstrap-wizard/jquery.bootstrap.wizard.min.js');?>"></script>
<script src="<?php echo base_url('assets/admin/js/jquery-validate/jquery.validate.min.js');?>"></script>
<script src="<?php echo base_url('assets/admin/js/bootstrap-wizard/add-staff.js');?>"></script>
<script src="<?php echo base_url('assets/admin/js/swal.js');?>"></script>
<!-- CUSTOM SCRIPT -->
<script src="<?php echo base_url('assets/admin/js/script.js');?>"></script>
<script>
		jQuery(document).ready(function() {		
			App.setPage("add_subcategory");  //Set current page
			App.init(); //Initialise plugins and elements
			AddstaffWizard.init();
		 
					
		
		});

		
	</script>
<!-- /JAVASCRIPTS -->
</body>
</html>