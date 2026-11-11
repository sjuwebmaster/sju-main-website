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
                    <h4><i class="fa fa-bars"></i>Add Slider Image</h4>
                  </div>
                  <div class="box-body big">
                    <input type="hidden" id="base_url" value="<?php echo site_url() ?>">
                    <form role="form" method="post" class="form-horizontal" id="addform" autocomplete="off">
                      <legend>Slider Details</legend>
                      
                      
                      
                            <div class="form-group">
                <label class="col-sm-3 control-label">Image</label>
                <div class="col-sm-4">
                    <input type="file"  class="form-control"  name="c_image" id="c_image" 
                           accept="image/jpeg,image/png,image/webp">
                    <img id="imgPreview" 
                         style="display:none;margin-top:10px;width:120px;border:1px solid #ddd;">
                </div>Home Page Main Banner size 1600 x 702
            </div>
            <div class="form-group">
                        <label class="col-sm-3 control-label"> Title</label>
                        <div class="col-sm-4">
                          <input type="text"  class="form-control" id="c_title" name="c_title" value="" maxlength="255">
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
<script src="<?php echo base_url('assets/admin/js/bootstrap-wizard/add-slider.js');?>"></script>
<script src="<?php echo base_url('assets/admin/js/swal.js');?>"></script>
<!-- CUSTOM SCRIPT -->
<script src="<?php echo base_url('assets/admin/js/script.js');?>"></script>
<script>
		jQuery(document).ready(function() {		
			App.setPage("add_subcategory");  //Set current page
			App.init(); //Initialise plugins and elements
			AddsliderWizard.init();
		
		});

		
	</script>
<!-- /JAVASCRIPTS -->
</body>
</html>