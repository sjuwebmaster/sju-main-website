<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title> Admin | Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- STYLESHEETS --><!--[if lt IE 9]><script src="js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/css/cloud-admin.css'); ?>" >
	
	<link href="<?php echo base_url('assets/admin/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
	<!-- DATE RANGE PICKER -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/js/bootstrap-daterangepicker/daterangepicker-bs3.css'); ?>" />
	<!-- UNIFORM -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/js/uniform/css/uniform.default.min.css'); ?>" />
	<!-- ANIMATE -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/css/animatecss/animate.min.css'); ?>" />
	<!-- FONTS -->
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
</head>
<body class="login">	
	<!-- PAGE -->
	<section id="page">
			<!-- HEADER -->
			<header>
				<!-- NAV-BAR -->
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div id="logo">
							</div>
						</div>
					</div>
				</div>
				<!--/NAV-BAR -->
			</header>
			<!--/HEADER -->
			<!-- LOGIN -->
			<section id="login" class="visible">
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div class="login-box-plain">
								<h2 class="bigintro">
                                    Sign In</h2>
								<div class="divide-40" style="text-align:center; color:#F00;"><?php
											$CI =& get_instance();

								
								if ($CI->session->flashdata('msg')) echo $CI->session->flashdata('msg');?></div>
								<form role="form" method="post" id="loginform" action="<?php echo site_url('login_check');?>" autocomplete="off">
								  <div class="form-group">
									<label for="exampleInputEmail1">Mobile No.</label>
									<i class="fa fa-envelope"></i>
									<input name="loginusername" type="text" class="form-control" id="loginusername" value="" >
								  </div>
								  <div class="form-group"> 
									<label for="exampleInputPassword1">Password</label>
									<i class="fa fa-lock"></i>
									<input name="loginpassword" type="password" class="form-control" id="loginpassword" value="" >
								  </div>
								  <div class="form-actions">
									
									<button type="submit" class="btn btn-danger">Submit</button>
								  </div>
								</form>
								
								
							</div>
						</div>
					</div>
				</div>
			</section>
			<!--/LOGIN -->
			
	</section>
	<!--/PAGE -->
	<!-- JAVASCRIPTS -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!-- JQUERY -->
	<script src="<?php echo base_url('assets/admin/js/jquery/jquery-2.0.3.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/jQuery-Cookie/jquery.cookie.min.js'); ?>"></script>
	<!-- JQUERY UI-->
	<script src="<?php echo base_url('assets/admin/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.j'); ?>s"></script>
	<!-- BOOTSTRAP -->
	<script src="<?php echo base_url('assets/admin/bootstrap-dist/js/bootstrap.min.js'); ?>"></script>
	
	
	<!-- UNIFORM -->
	<script type="text/javascript" src="<?php echo base_url('assets/admin/js/uniform/jquery.uniform.min.js'); ?>"></script>
	<!-- CUSTOM SCRIPT -->
	<script src="<?php echo base_url('assets/admin/js/script.js'); ?>"></script>
	<script>
		jQuery(document).ready(function() {		
			App.setPage("login");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>
	
</body>
</html>