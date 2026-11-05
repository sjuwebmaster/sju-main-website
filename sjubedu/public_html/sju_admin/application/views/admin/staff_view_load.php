<?php
 
 $srchqry="";$count=0;$srcnt=0;
 $brandqry="";
 if($searchcontent){
		$srchqry=" and  (c_name like '%$searchcontent%' or c_address like '%$searchcontent%' or c_mobile like '%$searchcontent%')";
		$srcnt++;	
		} else $srchqry="";
		$msg = "";

if($srcnt==2) $and=' and '; else $and='';
if($srcnt>0) $where=' where '; else $where='';
		
 		 $sql1= "SELECT count(*) as cnt from staff_master  where c_status in('Y','N') and c_type='staff' $srchqry $brandqry";		
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
			 $sql2= "SELECT n_id,c_name,c_mobile,c_status,c_email from staff_master  
			 where  c_status in('Y','N') and c_type='staff' $srchqry 
			  $brandqry  order by c_status ASC, n_id desc limit $start,10";
			$c_mobile=$c_status=$mbrandid=$n_id=$c_address=$c_state=$n_district=$n_constituency=$c_password="";		
						$result2 = $this->Sju_management_model->get_results($sql2);
						if($result2){
							 foreach($result2 as $row)
						  {
								$c_mobile = $row->c_mobile;
								$n_id = $row->n_id;
								$c_name = $row->c_name;	
								$c_status = $row->c_status;
								$c_email = $row->c_email;
							
								$cst='success';$cstat='Active';$tit='Click to Disable';
									if($c_status=='N') {
										$cst='danger';$cstat='Disabled';$tit='Click to make Active';
									}		
									
?>
											  <tr>
												<td><?php echo $c_name;?></td>
                                                <td><?php echo $c_mobile;?></td>
                                                <td><?php echo $c_email;?></td>
												<td><span class="label label-primary editdetail hnd"   id="<?php echo $n_id;?>"><i class="fa fa-edit"></i> Edit</span> <span id="cr_<?php echo $n_id;?>" title="<?php echo $tit;?>"  class="hnd statusdiv label cstcr label-<?php echo $cst;?>" ><?php echo $cstat;?></span>  <span class="label label-primary setpermission hnd"   id="<?php echo $n_id;?>"><i class="fa fa-edit"></i> Set permission</span><span id="r_<?php echo $n_id;?>"  class="runs"></span></td>
											  </tr>
                                              <?php } ?>
                                              <tr ><td colspan="5"><?php echo $msg; ?></td></tr>
	<?php  } else {?>
											  <tr><td colspan="5">No data found</td></tr>
                                              <?php } ?>
	

