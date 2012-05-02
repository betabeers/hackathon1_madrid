<?php
include('/home1/lhtwoolc/public_html/comicsurfer/api/tools/connect.php');
$link=connect();

$page_id=mysql_real_escape_string($_POST['page_id']);
$order=mysql_real_escape_string($_POST['vignette']);
$sound=mysql_real_escape_string($_POST['sound']);
$x1=mysql_real_escape_string($_POST['x1']);
$x2=mysql_real_escape_string($_POST['x2']);
$y1=mysql_real_escape_string($_POST['y1']);
$y2=mysql_real_escape_string($_POST['y2']);

if($x1=='' or $x2=='' or $y1=='' or $y2==''){
	json_encode(array('error'=>'falta algo'));
	exit();
}

$s="NULL";
if($sound){
	$r1=mysql_query("select * from sounds where id='$sound'", $link);
	$row1=mysql_fetch_assoc($r1);
	$s="'".$row1['sounds_name']."'";
}

$r=mysql_query("select * from vignettes where vignettes_page_id='$page_id' and vignettes_order='$order'", $link);
if(mysql_num_rows($r)) $query="update vignettes set vignettes_x1='$x1', vignettes_x2='$x2', vignettes_y1='$y1', vignettes_y2='$y2', vignettes_sound=".$s." where vignettes_page_id='$page_id' and vignettes_order='$order'";
else $query="insert into vignettes (vignettes_page_id, vignettes_order, vignettes_x1, vignettes_x2, vignettes_y1, vignettes_y2, vignettes_sound) values ('$page_id', '$order', '$x1', '$x2', '$y1', '$y2', ".$s.")";

mysql_query($query, $link);
?>[]