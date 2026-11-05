<?php  if(!$this->session->userdata('sju_admin_logged_in'))	 
	      redirect(base_url());
			$username = $this->session->userdata('name'); 
			$userid = $this->session->userdata('userid'); 
			$permission_array = $this->session->userdata('permission_array'); 
			$refer2=explode("/",$_SERVER['REQUEST_URI']);
			$loadedpage2="";
		       $cont2=count($refer2);
			
			if($cont2==3){
				$fnam2=explode("?",$refer2[$cont2-1]);
				 $loadedpage2 = $fnam2[0];
			}
			
			if(in_array($loadedpage2,$permission_array)){
			}
			else   redirect(base_url());
					  
 ?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>Admin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- STYLESHEETS --><!--[if lt IE 9]><script src="js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/css/cloud-admin.css');?>" >
	<link rel="stylesheet" type="text/css"  href="<?php echo base_url('assets/admin/css/themes/default.css');?>" id="skin-switcher" >
	<link rel="stylesheet" type="text/css"  href="<?php echo base_url('assets/admin/css/responsive.cs');?>s" >
    <link rel="stylesheet" type="text/css"  href="<?php echo base_url('assets/admin/css/custom.css');?>" >
    <!-- HUBSPOT MESSENGER -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/js/hubspot-messenger/css/messenger.min.css');?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/js/hubspot-messenger/css/messenger-theme-block.min.cs');?>s" />
	
	<link href="<?php echo base_url('assets/admin/css/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
    <!-- JQUERY -->
	<script src="<?php echo base_url('assets/admin/js/jquery/jquery-2.0.3.min.js');?>"></script>
	<!-- JQUERY UI-->
	<script src="<?php echo base_url('assets/admin/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/hubspot-messenger/js/messenger.min.j');?>s"></script>

	<!-- FONTS -->
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
  
</head>
<body>
	<!-- HEADER -->
	<header class="navbar clearfix navbar-fixed-top" id="header">
		<div class="container">
				<div class="navbar-brand">
					<!-- COMPANY LOGO -->
					<a href="<?php echo base_url();?>home">
                  
					</a>
					<!-- /COMPANY LOGO -->
				
					<!-- SIDEBAR COLLAPSE -->
					<div id="sidebar-collapse" class="sidebar-collapse btn">
						<i class="fa fa-bars" 
							data-icon1="fa fa-bars" 
							data-icon2="fa fa-bars" ></i>
					</div>
					<!-- /SIDEBAR COLLAPSE -->
				</div>
				<!-- NAVBAR LEFT -->
				<!--<ul class="nav navbar-nav pull-left hidden-xs" id="navbar-left">
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-cog"></i>
							<span class="name">Skins</span>
							<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu skins">
							<li class="dropdown-title">
								<span><i class="fa fa-leaf"></i> Theme Skins</span>
							</li>
							<li><a href="#" data-skin="default">Subtle (default)</a></li>
							<li><a href="#" data-skin="night">Night</a></li>
							<li><a href="#" data-skin="earth">Earth</a></li>
							<li><a href="#" data-skin="utopia">Utopia</a></li>
							<li><a href="#" data-skin="nature">Nature</a></li>
							<li><a href="#" data-skin="graphite">Graphite</a></li>
						 </ul>
					</li>
				</ul>-->
				<!-- /NAVBAR LEFT -->
				<!-- BEGIN TOP NAVIGATION MENU -->					
				<ul class="nav navbar-nav pull-right">
					<!-- BEGIN NOTIFICATION DROPDOWN -->	
					<!--<li class="dropdown" id="header-notification">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-bell"></i>
							<span class="badge">7</span>
							
						</a>
						
					</li>-->
					<!-- END NOTIFICATION DROPDOWN -->
					
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown user" id="header-user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<!--							<img class="tecprofilepic" alt="" src="<?php echo base_url();?>user_profile_pic/<?php echo $this->Sju_management_model->get_tech_profile_pic(); ?>" />
-->							<span class="username"><?php echo $username;?></span>
							<i class="fa fa-angle-down"></i>
						</a>
                        
						<ul class="dropdown-menu">
                            <li><a href="<?php echo base_url();?>logout"><i class="fa fa-power-off"></i> Log Out</a></li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
				<!-- END TOP NAVIGATION MENU -->
		</div>
		
		<!-- TEAM STATUS -->
