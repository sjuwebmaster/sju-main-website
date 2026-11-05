<?php
 
 $srchqry="";$count=0;$srcnt=0;
 $brandqry="";
 if($searchcontent){
		$srchqry=" and  (title like '%$searchcontent%' or description like '%$searchcontent%')";
		$srcnt++;	
		} else $srchqry="";
		$msg = "";

if($srcnt==2) $and=' and '; else $and='';
if($srcnt>0) $where=' where '; else $where='';
		
 		 $sql1= "SELECT count(*) as cnt from announcements  where c_status in('Y','N')  $srchqry $brandqry";		
						$result1 = $this->Sju_management_model->get_results($sql1);
							 foreach($result1 as $row)
						  {
								$count = $row->cnt;
						  }
$cur_page = $page;
$page -= 1;
$per_page = 10;
$previous_btn = true;
$next_btn = true;
$first_btn = true;
$last_btn = true;
$start = $page * $per_page;						  
$no_of_paginations = ceil($count / $per_page);
if ($cur_page >= 7) {
    $start_loop = $cur_page - 3;
    if ($no_of_paginations > $cur_page + 3)
        $end_loop = $cur_page + 3;
    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
        $start_loop = $no_of_paginations - 6;
        $end_loop = $no_of_paginations;
    } else {
        $end_loop = $no_of_paginations;
    }
} else {
    $start_loop = 1;
    if ($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}
 $msg .= "<div style='margin-left:35%;text-align:center;margin-top:5px; float:left;' >
 <ul class='pagination pagination-sm no-margin'>";
// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
    $msg .= "<li p='$pre' class='userpagination goto'><a>«</a></li>";
} else if ($previous_btn) {
    $msg .= "<li class=''><a>«</a></li>";
}
for ($i = $start_loop; $i <= $end_loop; $i++) {
    if ($cur_page == $i)
        $msg .= "<li p='$i'  class='userpagination active goto'><a>{$i}</a></li>";
    else
        $msg .= "<li p='$i'  class='userpagination goto'><a>{$i}</a></li>";
}
// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;
    $msg .= "<li p='$nex' class='userpagination goto'><a>»</a></li>";
} else if ($next_btn) {
    $msg .= "<li class=''><a>»</a></li>";
}
 $msg .= "</ul></div>";
			 $sql2= "SELECT id,title,description,c_status,created_at from announcements  
			 where  c_status in('Y','N')  $srchqry 
			  $brandqry  order by id  desc limit $start,10";
			$title=$c_status=$mbrandid=$id=$description=$c_state=$n_district=$n_constituency=$c_password="";		
						$result2 = $this->Sju_management_model->get_results($sql2);
						if($result2){
							 foreach($result2 as $row)
						  {
								$title = $row->title;
								$id = $row->id;
								$c_status = $row->c_status;
								$description = $row->description;
								
								if (!empty($row->created_at)) {
									$created_at =  date('d-m-Y h:i A', strtotime($row->created_at));
								} else {
									$created_at = '-';
								}
								
								$cst='success';$cstat='Active';$tit='Click to Disable';
									if($c_status=='N') {
										$cst='danger';$cstat='Disabled';$tit='Click to make Active';
									}		
									

									$description_array = explode(" ", $description);
									$description_sentence = array_chunk($description_array, 10);


									
?>
											  <tr>
												<td><?php echo $title;?></td>
                                                <td><?php //echo $description;
												foreach ($description_sentence as $descriptions) {
													echo implode(" ", $descriptions) . "<br><br>";
												}
												
												?></td>
                                                <td><?php echo $created_at;?></td>
												<td><span class="label label-primary editdetail hnd"   id="<?php echo $id;?>"><i class="fa fa-edit"></i> Edit</span> <span id="cr_<?php echo $id;?>" title="<?php echo $tit;?>"  class="hnd statusdiv label cstcr label-<?php echo $cst;?>" ><?php echo $cstat;?></span> <span id="r_<?php echo $id;?>"  class="runs"></span></td>
											  </tr>
                                              <?php } ?>
                                              <tr ><td colspan="5"><?php echo $msg; ?></td></tr>
	<?php  } else {?>
											  <tr><td colspan="5">No data found</td></tr>
                                              <?php } ?>
	

<script>
$(document).ready(function (){
	

$('.moreview').click( function(e) {

	 $('#myModal').find('.modal-body').html("<img src='ajax-loaders/loading-big.gif' title='ajax-loaders/loading-big.gif' >");
           var  essayId=$(this).attr('id');
       		 $.ajax({
            cache: false,
            type: 'POST',
            url: 'more_mobile',
            data: 'EID=' + essayId,
            success: function(data) {
                 $('#myModal').find('.modal-body').html(data);
            }
        });
    })
});
	</script>