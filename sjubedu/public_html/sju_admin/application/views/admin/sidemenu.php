<?php
		$refer=explode("/",$_SERVER['REQUEST_URI']);
		$cont=count($refer);
		$fnam=explode("?",$refer[$cont-1]);
		$loadedpage = $fnam[0];
$crumb1=$crumb2="";
$slidermenu=$slidermenuopenul=$sliderlink1=$sliderlink2="";
$staffmenu=$staffmenuopenul=$stafflink1=$stafflink2="";
$newsmenu=$newsmenuopenul=$newslink1=$newslink2="";
$eventmenu=$eventmenuopenul=$eventlink1=$eventlink2="";
$booksmenu=$booksmenuopenul=$bookslink1=$bookslink2="";
$announcementmenu=$announcementmenuopenul=$announcementlink1=$announcementlink2="";
$permission_array = $this->session->userdata('permission_array');
$userid = $this->session->userdata('userid'); 

if(!empty($loadedpage)){

		switch($loadedpage){
			
				case 'staff_registration_form': 
				$staffmenu='open';$staffmenuopenul="style='display:block;'"; $stafflink1="class='current'";
				break;
				case 'staff_view': 
				$staffmenu='open';$staffmenuopenul="style='display:block;'"; $stafflink2="class='current'";
				break;
				case 'add_slider': 
				$slidermenu='open';$slidermenuopenul="style='display:block;'"; $sliderlink1="class='current'";
				break;
				case 'slider_view': 
				$slidermenu='open';$slidermenuopenul="style='display:block;'"; $sliderlink2="class='current'";
				break;
				case 'add_news': 
				$newsmenu='open';$newsmenuopenul="style='display:block;'"; $newslink1="class='current'";
				break;
				case 'news_view': 
				$newsmenu='open';$newsmenuopenul="style='display:block;'"; $newslink2="class='current'";
				break;
				case 'add_event': 
				$eventmenu='open';$eventmenuopenul="style='display:block;'"; $eventlink1="class='current'";
				break;
				case 'events_view': 
				$eventmenu='open';$eventmenuopenul="style='display:block;'"; $eventlink2="class='current'";
				break;
				case 'add_book': 
				$booksmenu='open';$booksmenuopenul="style='display:block;'"; $bookslink1="class='current'";
				break;
				case 'books_view': 
				$booksmenu='open';$booksmenuopenul="style='display:block;'"; $bookslink2="class='current'";
				break;
				case 'add_announcement': 
				$announcementmenu='open';$announcementmenuopenul="style='display:block;'"; $announcementlink1="class='current'";
				break;
				case 'announcements_view': 
				$announcementmenu='open';$announcementmenuopenul="style='display:block;'"; $announcementlink2="class='current'";
				break;
			}
}
 $userid = $this->session->userdata('userid');
 $usertype = $this->session->userdata('usertype');
	?><div id="sidebar" class="sidebar">
					<div class="sidebar-menu nav-collapse">
						<div class="divide-20"></div>
						
						
						<!-- SIDEBAR MENU -->
						<ul>
							<li>
								<a href="<?php echo base_url();?>home">
									<i class="fa fa-tachometer fa-fw"></i> <span class="menu-text">Dashboard</span>
								</a>					
							</li>
					
                          <?php
						  if($userid ==1){
							  ?>
                            <li class="has-sub <?php echo $staffmenu;?>">
								<a href="javascript:;" class="">
								<i class="fa fa-bookmark-o fa-fw"></i> <span class="menu-text">Staff Management</span>
								<span class="arrow"></span>
								</a>
								<ul class="sub" <?php echo $staffmenuopenul;?>>
									<li <?php echo $stafflink1;?>><a class="" href="<?php echo base_url();?>staff_registration_form"><span class="sub-menu-text">Create Staff</span></a></li>
                                    	<li <?php echo $stafflink2;?>><a class="" href="<?php echo base_url();?>staff_view"><span class="sub-menu-text">Staff list </span></a></li>
								</ul>
							</li>
					<?php } ?>
                    <?php if (in_array('add_slider', $permission_array) || in_array('slider_view', $permission_array)){?>
						
                     <li class="has-sub <?php echo $slidermenu;?>">
								<a href="javascript:;" class="">
								<i class="fa fa-bookmark-o fa-fw"></i> <span class="menu-text">Slider Management</span>
								<span class="arrow"></span>
								</a>
								<ul class="sub" <?php echo $slidermenuopenul;?>>
                                <?php if (in_array('add_slider', $permission_array) ){?>
									<li <?php echo $sliderlink1;?>><a class="" href="<?php echo base_url();?>add_slider"><span class="sub-menu-text">Add Slider Image</span></a></li>
                                    <?php  } if (in_array('slider_view', $permission_array)){?>
                                    <li <?php echo $sliderlink2;?>><a class="" href="<?php echo base_url();?>slider_view"><span class="sub-menu-text">Slider Image List </span></a></li>
                                    <?php }?>
								</ul>
							</li>
                    
                    <?php } ?>
					
					
					
                    <?php if (in_array('add_news', $permission_array) || in_array('news_view', $permission_array)){?>
                       <li class="has-sub <?php echo $newsmenu;?>">
								<a href="javascript:;" class="">
								<i class="fa fa-bookmark-o fa-fw"></i> <span class="menu-text">News Management</span>
								<span class="arrow"></span>
								</a>
								<ul class="sub" <?php echo $newsmenuopenul;?>>
                                <?php if (in_array('add_news', $permission_array)){?>
									<li <?php echo $newslink1;?>><a class="" href="<?php echo base_url();?>add_news"><span class="sub-menu-text">Add News</span></a></li>
                                    <?php } if (in_array('news_view', $permission_array)){?>
                                    	<li <?php echo $newslink2;?>><a class="" href="<?php echo base_url();?>news_view"><span class="sub-menu-text">News list </span></a></li>
                                        <?php } ?>
								</ul>
							</li>
                            <?php } ?>
                            <?php if (in_array('add_event', $permission_array) || in_array('events_view', $permission_array)){?>
						 <li class="has-sub <?php echo $eventmenu;?>">
								<a href="javascript:;" class="">
								<i class="fa fa-bookmark-o fa-fw"></i> <span class="menu-text">Event Management</span>
								<span class="arrow"></span>
								</a>
								<ul class="sub" <?php echo $eventmenuopenul;?>>
                                 <?php if (in_array('add_event',$permission_array)){?>
									<li <?php echo $eventlink1;?>><a class="" href="<?php echo base_url();?>add_event"><span class="sub-menu-text">Add Event</span></a></li>
                                     <?php } if (in_array('events_view', $permission_array)){?>
                                    	<li <?php echo $eventlink2;?>><a class="" href="<?php echo base_url();?>events_view"><span class="sub-menu-text">Event list </span></a></li>
                                          <?php } ?>
								</ul>
							</li>
                            <?php } 
							
							?>
                            <?php if (in_array('add_announcement', $permission_array) || in_array('announcements_view', $permission_array)){?>
						 <li class="has-sub <?php echo $announcementmenu;?>">
								<a href="javascript:;" class="">
								<i class="fa fa-bookmark-o fa-fw"></i> <span class="menu-text">Announcemet Management</span>
								<span class="arrow"></span>
								</a>
								<ul class="sub" <?php echo $announcementmenuopenul;?>>
                                 <?php if (in_array('add_announcement', $permission_array)){?>
									<li <?php echo $announcementlink1;?>><a class="" href="<?php echo base_url();?>add_announcement"><span class="sub-menu-text">Add Announcemet</span></a></li>
                                     <?php } if (in_array('announcements_view', $permission_array)){?>
                                    	<li <?php echo $announcementlink2;?>><a class="" href="<?php echo base_url();?>announcements_view"><span class="sub-menu-text">Announcemet list </span></a></li>
                                          <?php } ?>
								</ul>
							</li>
                            <?php }
                            if (in_array('add_book', $permission_array) || in_array('books_view', $permission_array)){?>
                             <li class="has-sub <?php echo $booksmenu;?>">
								<a href="javascript:;" class="">
								<i class="fa fa-bookmark-o fa-fw"></i> <span class="menu-text">Books Management</span>
								<span class="arrow"></span>
								</a>
								<ul class="sub" <?php echo $booksmenuopenul;?>>
                                 <?php if (in_array('add_book', $permission_array)){?>
									<li <?php echo $bookslink1;?>><a class="" href="<?php echo base_url();?>add_book"><span class="sub-menu-text">Add Book</span></a></li>
                                     <?php } if (in_array('books_view', $permission_array)){?>
                                    	<li <?php echo $bookslink2;?>><a class="" href="<?php echo base_url();?>books_view"><span class="sub-menu-text">Books list </span></a></li>
                                         <?php } ?>
								</ul>
							</li>
                            <?php } ?>
				</ul>
							
						
						<!-- /SIDEBAR MENU -->
					</div>
				</div>