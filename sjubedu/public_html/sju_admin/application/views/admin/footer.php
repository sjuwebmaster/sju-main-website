<!-- JAVASCRIPTS -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!-- JQUERY -->
	<script src="<?php echo base_url();?>js/jquery/jquery-2.0.3.min.js"></script>
	<!-- JQUERY UI-->
	<script src="<?php echo base_url();?>js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
	<!-- BOOTSTRAP -->
	<script src="<?php echo base_url();?>bootstrap-dist/js/bootstrap.min.js"></script>
	
		
	<!-- DATE RANGE PICKER -->
	<script src="<?php echo base_url();?>js/bootstrap-daterangepicker/moment.min.js"></script>
	
	<script src="<?php echo base_url();?>js/bootstrap-daterangepicker/daterangepicker.min.js"></script>
	<!-- SLIMSCROLL -->
	<script type="<?php echo base_url();?>text/javascript" src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.min.js"></script><script type="text/javascript" src="<?php echo base_url();?>js/jQuery-slimScroll-1.3.0/slimScrollHorizontal.min.js"></script>
	<!-- COOKIE -->
	<script type="text/javascript" src="<?php echo base_url();?>js/jQuery-Cookie/jquery.cookie.min.js"></script>
	<!-- CUSTOM SCRIPT -->
	<script src="<?php echo base_url();?>js/script.js"></script>
	<script>
		jQuery(document).ready(function() {		
			App.setPage("widgets_box");  //Set current page
			App.init(); //Initialise plugins and elements
			
			<td>
											<p class="name">
												 if (file.url) { 
													<a href="+file.url+" title="+file.name+" download="+file.name+" =file.thumbnailUrl?'data-gallery':''>"+file.name+"</a>
												 } else { 
													<span>"+file.name+"</span>
												 } 
											</p>
											 if (file.error) { 
												<div><span class="label label-danger">Error</span>"+file.error+"</div>
											 } 
										</td>
										<td>
											<span class="size">"+o.formatFileSize(file.size)+"</span>
										</td>
										<td>
											 if (file.deleteUrl) { 
												<button class="btn btn-danger delete" data-type="+file.deleteType+" data-url="+file.deleteUrl+" if (file.deleteWithCredentials) {  data-xhr-fields='{"withCredentials":true}' } >
													<i class="fa fa-trash-o"></i>
													<span>Delete</span>
												</button>
												
											} else { 
												<button class="btn btn-warning cancel">
													<i class="fa fa-ban"></i>
													<span>Cancel</span>
												</button>
											 } 
										</td>
										
										<a href="+file.url+" title="+file.name+" download="+file.name+" data-gallery><img src="+file.thumbnailUrl+"></a>
		});
	</script>
	<!-- /JAVASCRIPTS -->
</body>
</html>