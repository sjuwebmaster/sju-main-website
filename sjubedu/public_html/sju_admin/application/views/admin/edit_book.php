<?php

		 $sql2= "SELECT title,c_url,c_image  from books where id = $cnid";
		$c_name="";$c_url="";$c_image="";
		$result2 = $this->Sju_management_model->get_results($sql2);
		if($result2)
		{
			foreach($result2 as $row)
				{
					$title 				= $row->title;
					$c_url 	= $row->c_url;
					$c_image 	    = $row->c_image;
				}
		}
					
		?>
					<div class="box border primary">
                  <div class="box-title">
                    <h4><i class="fa fa-bars"></i>Edit Book</h4>
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
                      <legend>Book Details</legend>
                      <div class="form-group">
                        <label class="col-sm-3 control-label"> Title</label>
                        <div class="col-sm-4">
                          <input type="text"  class="form-control" id="c_title" name="c_title" value="<?php echo $title;?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label"> URL</label>
                        <div class="col-sm-4">
                          <input type="text"  class="form-control" id="c_url" name="c_url" value="<?php echo $c_url;?>">
                        </div>
                      </div>
                     
                    <div class="form-group">
                <label class="col-sm-3 control-label"> Image</label>
                <div class="col-sm-4">
                    <input type="file"  class="form-control"  name="c_image" id="c_image" 
                           accept="image/jpeg,image/png,image/webp">
                    
                       <?php  if (!empty($c_image)) {?>
                         <img id="imgPreview"
     src="<?= base_url('assets/admin/uploads/books/thumb/'.$c_image); ?>"
     style="width:120px;border:1px solid #ddd;">
                         
                         <?php }?>
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
    <!-- CUSTOM SCRIPT 
	<script src="<?php echo base_url('assets/admin/');?>js/script.js"></script>-->
	<script src="<?php echo base_url('assets/admin/js/bootstrap-wizard/jquery.bootstrap.wizard.min.js');?>"></script>
    <script src="<?php echo base_url('assets/admin/js/jquery-validate/jquery.validate.min.js');?>"></script>
	<script src="<?php echo base_url('assets/admin/js/bootstrap-wizard/edit_book.js');?>"></script>	
	<script>
		jQuery(document).ready(function() {		
			
			Editbookwizard.init();
		
		});

	</script>
