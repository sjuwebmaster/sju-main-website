<?php

$courses = [

"School of Business" => [

[
"id"=>"bcom",
"level"=>"ug",
"name"=>"Bachelor of Commerce (B.Com.)",
"timing"=>"7:00 AM – 12:00 PM",
"entrance"=>"No",

"fee" => '
<table class="fee-table">
<tr>
<th>Particulars</th>
<th>Amount</th>
</tr>

<tr>
<td>Admission Fee</td>
<td>₹10,000</td>
</tr>

<tr>
<td>Tuition Fee</td>
<td>₹75,000 / Year</td>
</tr>

<tr>
<td>Library Fee</td>
<td>₹2,000</td>
</tr>

</table>


'

],

[
"id"=>"bba",
"level"=>"ug",
"name"=>"BBA Strategic Finance",
"timing"=>"12:00 PM – 4:00 PM",
"entrance"=>"Yes",
"fee"=>[
["Tuition Fee","₹92,000 / Year"],
["Admission Fee","₹10,000"]
]
]

],

"School of Chemical Sciences" => [

[
"id"=>"bsc-chem",
"level"=>"ug",
"name"=>"B.Sc Chemistry",
"timing"=>"8:00 AM – 1:00 PM",
"entrance"=>"Yes",
"fee"=>[
["Tuition Fee","₹65,000 / Year"],
["Lab Fee","₹8,000"]
]
],

[
"id"=>"msc-chem",
"level"=>"pg",
"name"=>"M.Sc Chemistry",
"timing"=>"9:00 AM – 2:00 PM",
"entrance"=>"Yes",
"fee"=>[
["Tuition Fee","₹70,000 / Year"],
["Lab Fee","₹10,000"]
]
]

]

];

?>

<!DOCTYPE html>
<html>
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">

<title>All Courses</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f7f7f7;
font-family:Arial;
}

.course-section{
padding:60px 0;
}

/* Sidebar */

.sidebar{
background:#fff;
padding:25px;
border-radius:6px;
}

.sidebar h6{
font-weight:700;
margin-bottom:15px;
}

.sidebar ul{
list-style:none;
padding:0;
}

.sidebar li{
padding:10px;
border-bottom:1px solid #eee;
cursor:pointer;
}

.sidebar li.active{
background:#8b1d2c;
color:#fff;
}

/* School Block */

.school-block{
margin-bottom:40px;
}

.school-title{
font-size:22px;
font-weight:700;
margin-bottom:15px;
}

/* Course item */

.course-item{
background:#fff;
padding:18px;
border-radius:6px;
margin-bottom:15px;
}

.course-title{
display:flex;
justify-content:space-between;
cursor:pointer;
}

.course-title h5{
margin:0;
font-size:17px;
}

.course-content{
max-height:0;
overflow:hidden;
transition:.35s;
margin-top:10px;
}

/* buttons */

.btn-area{
margin-top:12px;
display:flex;
gap:10px;
flex-wrap:wrap;
}

.btn-main{
background:#8b1d2c;
color:#fff;
padding:7px 15px;
border:none;
}

.btn-outline{
border:1px solid #8b1d2c;
color:#8b1d2c;
padding:7px 15px;
}

.btn-fee{
background:#ffc107;
border:none;
padding:7px 15px;
}

/* modal */

.fee-modal{
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,.6);
align-items:center;
justify-content:center;
z-index:999;
}

.fee-box{
background:#fff;
padding:30px;
width:90%;
max-width:600px;
border-radius:6px;
position:relative;
}

.close{
position:absolute;
right:15px;
top:10px;
font-size:20px;
border:none;
background:none;
}

/* fee table */

.fee-table{
width:100%;
border-collapse:collapse;
margin-top:15px;
}

.fee-table th{
background:#8b1d2c;
color:#fff;
padding:10px;
}

.fee-table td{
padding:10px;
border:1px solid #ddd;
}

</style>

</head>
<body>

<section class="course-section">

<div class="container">

<div class="row">

<!-- Sidebar -->

<div class="col-lg-3">

<div class="sidebar">

<h6>Programme Level</h6>

<ul class="level-filter">

<li data-level="all" class="active">All</li>
<li data-level="ug">Undergraduate</li>
<li data-level="pg">Postgraduate</li>
<li data-level="diploma">PG Diploma</li>

</ul>

</div>

</div>


<!-- Course Area -->

<div class="col-lg-9">

<?php foreach($courses as $school=>$list): ?>

<div class="school-block">

<div class="school-title"><?php echo $school; ?></div>

<?php foreach($list as $course): ?>

<div class="course-item" data-level="<?php echo $course['level']; ?>">

<div class="course-title">

<h5><?php echo $course['name']; ?></h5>

<span>+</span>

</div>

<div class="course-content">

<p><b>Batch Timing:</b> <?php echo $course['timing']; ?></p>

<p><b>Entrance Test:</b> <?php echo $course['entrance']; ?></p>

<div class="btn-area">

<button class="btn-main">View Details</button>

<button class="btn-outline">Apply Now</button>

<button class="btn-fee" data-target="<?php echo $course['id']; ?>">Fee</button>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

<?php endforeach; ?>

</div>

</div>

</div>

</section>


<!-- Fee Modals -->

<?php foreach($courses as $school=>$list): ?>
<?php foreach($list as $course): ?>

<div class="fee-modal" id="<?php echo $course['id']; ?>">

<div class="fee-box">

<button class="close">×</button>

<h4><?php echo $course['name']; ?> Fee Structure</h4>

<table class="fee-table">

<tr>
<th>Particulars</th>
<th>Amount</th>
</tr>

<?php foreach($course['fee'] as $row): ?>

<tr>
<td><?php echo $row[0]; ?></td>
<td><?php echo $row[1]; ?></td>
</tr>

<?php endforeach; ?>

</table>

</div>

</div>

<?php endforeach; ?>
<?php endforeach; ?>


<script>

/* Level Filter */

document.querySelectorAll(".level-filter li").forEach(btn=>{

btn.addEventListener("click",function(){

document.querySelectorAll(".level-filter li").forEach(li=>li.classList.remove("active"))

this.classList.add("active")

let level=this.dataset.level

document.querySelectorAll(".course-item").forEach(item=>{

if(level==="all" || item.dataset.level===level){
item.style.display="block"
}
else{
item.style.display="none"
}

})

})

})

/* Accordion */

document.querySelectorAll(".course-title").forEach(title=>{

title.addEventListener("click",function(){

let content=this.nextElementSibling

if(content.style.maxHeight){
content.style.maxHeight=null
}
else{
content.style.maxHeight=content.scrollHeight+"px"
}

})

})

/* Fee Modal */

document.querySelectorAll(".btn-fee").forEach(btn=>{

btn.addEventListener("click",function(){

let id=this.dataset.target
document.getElementById(id).style.display="flex"

})

})

document.querySelectorAll(".close").forEach(btn=>{

btn.addEventListener("click",function(){

this.closest(".fee-modal").style.display="none"

})

})

</script>

</body>
</html>