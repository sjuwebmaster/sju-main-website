
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
										<li>
											<i class="fa fa-home"></i>
											<a href="#">Home</a>
										</li>
										<li>Dashboard</li>
									</ul>
									<!-- /BREADCRUMBS -->
									<div class="box border primary">
											<div class="box-title">
										
												<h2>Welcome</h2>
												
											</div>		

                                        									
												<div class="col-md-12" style="margin-top:25px;">
								<div class="row">
								<?php 
								$usertype = $this->session->userdata('usertype');
							?>
                                <a href="<?php echo base_url();?>staff_registration_form">
								  <div class="col-lg-6">
									 <div class="dashbox panel panel-default">
										<div class="panel-body">
										   <div class="panel-left red">
												<i class="fa fa-gavel fa-3x"></i>
										   </div>
										   <div class="panel-right">
												<div class="number">Add staff<?php
                                             
												?></div>
												<div class="title"></div>
										   </div>
										</div>
									 </div>
								  </div>
                                  </a>
                                <a href="<?php echo base_url();?>staff_view">
								  <div class="col-lg-6">
									 <div class="dashbox panel panel-default">
										<div class="panel-body">
										   <div class="panel-left red">
												<i class="fa fa-users fa-3x"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><?php
                                              echo  $result = $this->Sju_management_model->get_staff_count();
												?></div>
												<div class="title">Total Staff</div>
										   </div>
										</div>
									 </div>
								  </div>
                                  </a>
                                  
								<?php  ?>
								</div>
						
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
   
	<!-- BOOTSTRAP -->
	<script src="<?php echo base_url('assets/admin/js/bootstrap-dist/js/bootstrap.min.js'); ?>"></script>
	<!-- COOKIE -->
	<script type="text/javascript" src="<?php echo base_url('assets/admin/js/jQuery-Cookie/jquery.cookie.min.js');?>"></script>
    <!-- SELECT2 --    <!-- CUSTOM SCRIPT -->
	<script src="<?php echo base_url('assets/admin/js/script.js');?>"></script>
	<script>
		jQuery(document).ready(function() {		
			App.setPage("add_subcategory");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>
	<!-- /JAVASCRIPTS -->
</body>
</html>