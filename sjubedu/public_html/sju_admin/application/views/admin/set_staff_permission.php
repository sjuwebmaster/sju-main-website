<?php
$sql2= "SELECT n_id,c_name,c_mobile,c_address from staff_master  where n_id=$cnid"; 
			
			$c_fname=$c_mobile=$c_address="";		
						$result2 = $this->Sju_management_model->get_results($sql2);
						if($result2){
							 foreach($result2 as $row)
						  {
								$c_fname = $row->c_name;
								$mid = $row->n_id;
								$c_mobile = $row->c_mobile;	
								$c_address = $row->c_address;
						
						  }
						}
						
						$permission_array=array();
						$sql28= "SELECT permission from permission_master  where user_id=$cnid"; 
			
						$result28 = $this->Sju_management_model->get_results($sql28);
						if($result28){
							 foreach($result28 as $row28)
						  {
								array_push($permission_array,$row28->permission);
						  }
						}

		  $event_menu = array( 
           array (
               "link" =>'add_event',
               "description" =>'Add event',
            ),
			 array (
               "link" =>'events_view',
               "description" =>'Event List',
            )
			);
			
			 $slider_menu = array( 
           array (
               "link" =>'add_slider',
               "description" =>'Add Slider Image',
            ),
			 array (
               "link" =>'slider_view',
               "description" =>'Slider Image List',
            )
			);
			
			$books_menu = array( 
           array (
               "link" =>'add_book',
               "description" =>'Add Book',
            ),
			array (
               "link" =>'books_view',
               "description" =>'Books List',
            )
			);
			
			
			
			$news_menu = array( 
			   array (
				   "link" =>'add_news',
				   "description" =>'Add News',
				),
				array (
				   "link" =>'news_view',
					"description" =>'News List',
				)
			);
			$announcement_menu = array( 
			   array (
				   "link" =>'add_announcement',
				   "description" =>'Add Announcement',
				),
				array (
				   "link" =>'announcements_view',
					"description" =>'Announcement List',
				)
			);
			
			
			

?>

<div class="box border primary">
  <div class="box-title">
    <h4><i class="fa fa-bars"></i>Set permission for <?php echo $c_fname;?></h4>
    <div class="tools"> <a class="remove closeedit" href="javascript:;"> <i class="fa fa-times"></i> </a> </div>
  </div>
  <div class="box-body big">
    <form role="form" class="form-horizontal" id="addform">
      <input type="hidden" name="editid" id="editid" value="<?php echo $mid;?>">
      <div class="tab-pane active" id="tab1">
        <div class="panel-group" id="accordion">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1_1">Slider Management </a> </h3>
            </div>
            <div id="collapse1_1" class="panel-collapse collapse in">
               <?php
			foreach($slider_menu as $row_menu5) {
				$menu5 = $row_menu5['link'];
				$menu_desc5 = $row_menu5['description'];
				if(in_array($menu5,$permission_array))
					$chk5='checked="checked"'; 
					else $chk5='';
			?>
              <div class="panel-body">
                <input <?php echo $chk5;?> type="checkbox" name="setpermission" value="<?php echo $menu5;?>"/>
                <?php echo $menu_desc5;?></div>
              <?php
			}
			?>
            </div>
          </div>
        </div>
      </div>
      <br/>
      <div class="tab-pane" id="tab1">
        <div class="panel-group" id="accordion2">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse1_2">News management</a> </h3>
            </div>
            <div id="collapse1_2" class="panel-collapse collapse in">
              <?php
			foreach($news_menu as $row_menu) {
				$menu = $row_menu['link'];
				$menu_desc = $row_menu['description'];
				if(in_array($menu,$permission_array))
					$chk='checked="checked"'; 
					else $chk='';
			?>
              <div class="panel-body">
                <input <?php echo $chk;?> type="checkbox" name="setpermission" value="<?php echo $menu;?>"/>
                <?php echo $menu_desc;?></div>
              <?php
			}
			?>
             
            </div>
          </div>
        </div>
      </div>
      <br />
      <div class="tab-pane active" id="tab3">
        <div class="panel-group" id="accordion3">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse1_3">Event Management </a> </h3>
            </div>
            <div id="collapse1_3" class="panel-collapse collapse in">
            <?php
			foreach($event_menu as $row_menu2) {
				$menu2 = $row_menu2['link'];
				$menu_desc2 = $row_menu2['description'];
				if(in_array($menu2,$permission_array))
					$chk3='checked="checked"'; 
					else $chk3='';
			?>
              <div class="panel-body">
             
               <input <?php echo $chk3;?> type="checkbox" name="setpermission" value="<?php echo $menu2;?>"/>
                <?php echo $menu_desc2;?></div>
                 <?php
			}
					?>
            </div>
          </div>
        </div>
      </div>
      <br />
      <div class="tab-pane active" id="tab4">
        <div class="panel-group" id="accordion4">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapse1_4">Books Manegement</a> </h3>
            </div>
            <div id="collapse1_4" class="panel-collapse collapse in">
            <?php
			foreach($books_menu as $row_menu3) {
				$menu3 = $row_menu3['link'];
				$menu_desc3 = $row_menu3['description'];
				if(in_array($menu3,$permission_array))
					$chk4='checked="checked"'; 
					else $chk4='';
			?>
              <div class="panel-body">
               <input <?php echo $chk4;?> type="checkbox" name="setpermission" value="<?php echo $menu3;?>"/>
                <?php echo $menu_desc3;?></div>
                 <?php
				}
			?>
            </div>
          </div>
        </div>
      </div>
      <br />
      <div class="tab-pane active" id="tab5">
        <div class="panel-group" id="accordion5">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion5" href="#collapse1_5">Announcement Manegement</a> </h3>
            </div>
            <div id="collapse1_4" class="panel-collapse collapse in">
            <?php
			foreach($announcement_menu as $row_menu33) {
				$menu33 = $row_menu33['link'];
				$menu_desc33 = $row_menu33['description'];
				if(in_array($menu33,$permission_array))
					$chk43='checked="checked"'; 
					else $chk43='';
			?>
              <div class="panel-body">
               <input <?php echo $chk43;?> type="checkbox" name="setpermission" value="<?php echo $menu33;?>"/>
                <?php echo $menu_desc33;?></div>
                 <?php
				}
			?>
            </div>
          </div>
        </div>
      </div>
      <br />
     
	  
	  
	  
      <div class="form-group">
        <div class="col-sm-4">
          <button class="btn btn-success" type="button" id="formsubmit">Submit</button>
          <span id="formsaveloader" class="marginleft"></span> </div>
      </div>
    </form>
  </div>
</div>
<script>
		jQuery(document).ready(function() {		
			
	
			$('#formsubmit').click(function(){
				var editid = $('#editid').val();
				var checkedValues = $('input[name=setpermission]:checked').map(function()
					{
						return $(this).val();
					}).get();
				if(checkedValues==''){
					//$('#loadapprove').html('Please select atleast one user');
					handleMessengeralert('error','Please select atleast one permission')
				} else {
					$('#formsubmit').prop('disabled', true);
					$("#formsaveloader").html("<img src='<?php echo base_url('assets/admin/ajax-loaders/ajax-loader-1.gif');?>' title='Loader' >");
						$.ajax({
						type: "POST",
						url: '<?php echo base_url();?>save_staff_permission',
						data: {editid: editid,c_permission:checkedValues
						,'isAjax':true},
						dataType:'json',
						success: function(data) {
							if(data){
									$("#formsaveloader").html("");
									$('#formsubmit').prop('disabled', false);
									$("#formsaveloader").html("");
									
									 if (data.status === true || data.status === 'success') {
                  
												swal({
													title: "Success!",
													icon: "success",
													text: 'Permission set successfully',
													button: true,
													timer: 20000
												});
											} else {
												swal({
													title: "Alert!",
													icon: "error",
													text: 'Please try after sometime',
													button: true,
													timer: 20000
												});
											}
									
									
									
									}
							}
						});
					
					}
			});
		});
	</script> 
