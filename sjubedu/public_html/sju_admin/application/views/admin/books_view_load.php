<?php
 
 $srchqry="";$count=0;$srcnt=0;
 $brandqry="";
 if($searchcontent){
		$srchqry=" and  (title like '%$searchcontent%' or c_url like '%$searchcontent%')";
		$srcnt++;	
		} else $srchqry="";
		$msg = "";

if($srcnt==2) $and=' and '; else $and='';
if($srcnt>0) $where=' where '; else $where='';
		
 		 $sql1= "SELECT count(*) as cnt from books  where c_status in('Y','N')  $srchqry $brandqry";		
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
			 $sql2= "SELECT id,title,c_url,c_status,created_at from books  
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
								$c_url = $row->c_url;
								
								if (!empty($row->created_at)) {
									$created_at =  date('d-m-Y h:i A', strtotime($row->created_at));
								} else {
									$created_at = '-';
								}
								
								$cst='success';$cstat='Active';$tit='Click to Disable';
									if($c_status=='N') {
										$cst='danger';$cstat='Disabled';$tit='Click to make Active';
									}		
									
?>
											  <tr>
												<td><?php echo $title;?></td>
                                                <td><?php echo $c_url;?></td>
                                                <td><?php echo $created_at;?></td>
												<td><span class="label label-primary editdetail hnd"   id="<?php echo $id;?>"><i class="fa fa-edit"></i> Edit</span> <span id="cr_<?php echo $id;?>" title="<?php echo $tit;?>"  class="hnd statusdiv label cstcr label-<?php echo $cst;?>" ><?php echo $cstat;?></span> <!--<span id="<?php echo $id;?>"   class="hnd c_statusdiv label  label-primary moreview" data-toggle="modal" data-target="#myModal"><i class="fa fa-edit"></i> More view</span>--><span id="r_<?php echo $id;?>"  class="runs"></span></td>
											  </tr>
                                              <?php } ?>
                                              <tr ><td colspan="5"><?php echo $msg; ?></td></tr>
	<?php  } else {?>
											  <tr><td colspan="5">No data found</td></tr>
                                              <?php } ?>
	

