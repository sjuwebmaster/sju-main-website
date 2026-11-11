</header>
	<!--/HEADER -->
	
	<!-- PAGE -->
	<section id="page">
				<!-- SIDEBAR -->
				<?php $this->load->view('admin/sidemenu');?>
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
									<div class="box border primary" id="maincontentdiv">
									<div class="box-title">
										<h4><i class="fa fa-table"></i>News list</h4>
										<div class="tools" style="width:50% !important;">
											<div class="col-xs-12"><input  type="text" id="searchcontent" class="form-control searchinputclass" placeholder="Search" autocomplete="off"></div>
										</div>
									</div>
									<div class="box-body  tablescroll"><div class="loading"></div>
										<table width="100%" class="table table-bordered tablescrolld">
											<thead>
											  <tr>
												<th width="21%">Title</th>
												<th width="52%">News</th>
												<th width="12%">Added on</th>
												<th width="15%">Options</th>
											  </tr>
											</thead>
											<tbody id="contentdiv">
											  
											</tbody>
										  </table>
									</div>
								</div>
                                <div id="editcontentdiv"></div>
								</div>
							</div>
						</div>
						<!-- /PAGE HEADER -->
					</div>
				</div>
			</div>
		</div>
	</section>
<div class="modal" id="myModal">
				 <div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
										<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
												<h4 class="modal-title">More details</h4>
														  </div>
												<div class="modal-body">
														<p>O
												</div>
								
		</div><!-- /.modal-content -->
	</div>
</div>
    <!-- JAVASCRIPTS -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!-- BOOTSTRAP -->
	<script src="<?php echo base_url('assets/admin/js/bootstrap-dist/js/bootstrap.min.js');?>"></script>	
	<script type="text/javascript" src="<?php echo base_url('assets/admin/js/jQuery-Cookie/jquery.cookie.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/admin/js/select2/select2.min.js');?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/js/select2/select2.min.css');?>" />
	<script src="<?php echo base_url('assets/admin/js/script.js');?>"></script>
	<script>
			
		jQuery(document).ready(function() {	

			App.setPage("sub_category_view");  //Set current page
			App.init(); //Initialise plugins and elements
			
			function loadcontent(page){
				var searchcontent=$('#searchcontent').val();
						$('.loading').html("<img src='<?php echo base_url('assets/admin/ajax-loaders/loading-big.gif');?>' title='Loading'>").fadeIn('fast');
							$.post('<?php echo base_url('news_view_load');?>',{
								page:page,searchcontent:searchcontent
							},function(data){
								if(data){
									$('.loading').html("");
                                $("#contentdiv").html(data);
								}
							}); 
			}
			loadcontent(1);
			$("#searchcontent").keyup(function(){
				 loadcontent(1);
			});
		
			 $('#contentdiv').on('click','.goto',function(){
                    var page = $(this).attr('p');
                    loadcontent(page);
			});
			$('#contentdiv').on('click','.cstcr',function(){
					var cid = $(this).attr('id');
					var cnid = cid.split('_');
					var cls = $(this).attr('class');
					var sttit='Click to make Active';
					if(cls=='hnd statusdiv label cstcr label-danger') sttit='Click to Disable';
					var ust ='N'; var apclass='hnd statusdiv label cstcr label-danger';var ctxt='Disabled';
					if(cls=='hnd statusdiv label cstcr label-danger'){ ust ='Y'; apclass='hnd statusdiv label cstcr label-success';ctxt='Active';  }
					$("#r_"+cnid[1]).html("<img src='<?php echo base_url('assets/admin/ajax-loaders/ajax-loader.gif');?>'/>");
					$.post('<?php echo site_url('update_news_status');?>',{
								cnid:cnid[1],ust:ust
							},function(data){
								if(data){ 
									if(data.match('ok')){
								$('#cr_'+cnid[1]).removeClass().addClass(apclass).text(ctxt).attr('title',sttit);
								$("#r_"+cnid[1]).html("");
									}else {
										$("#r_"+cnid[1]).html("Please try again");
									}
								}
							});
				});
					$('#contentdiv').on('click','.editdetail',function(){
					var cid = $(this).attr('id');
					$("#r_"+cid).html("<img src='<?php echo base_url('assets/admin/ajax-loaders/ajax-loader.gif');?>'/>");
					$.post('<?php echo base_url('edit_news');?>',{
								cnid:cid
							},function(data){
								if(data){
									$("#r_"+cid).html("");
									$('#maincontentdiv').hide();
									$('#editcontentdiv').show().html(data);
								}
							});
				});
			$('#editcontentdiv').on('click','.closeedit',function(){
				$("#maincontentdiv").show();
				$("#editcontentdiv").hide();
			}); 
		});
	
	</script>
	<!-- /JAVASCRIPTS -->
</body>
</html>