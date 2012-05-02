<?php
include('/home1/lhtwoolc/public_html/comicsurfer/api/tools/connect.php');
$link=connect();

$page_id=$_POST['page_id'];
$order=$_POST['order'];

// Query
$query = sprintf("select vignettes_x1 as 'x1', vignettes_x2 as 'x2', vignettes_y1 as 'y1', vignettes_y2 as 'y2', vignettes_sound as 'sound' from vignettes where vignettes_page_id='%s' and vignettes_order='%s'",
            mysql_real_escape_string($page_id),
            mysql_real_escape_string($order));

$vjson=array();

$r=mysql_query($query, $link);
if(mysql_num_rows($r)){
	$row=mysql_fetch_assoc($r);
	if($row['sound']){
		$r1=mysql_query("select id from sounds where sounds_name='".$row['sound']."'", $link);
		$row1=mysql_fetch_assoc($r1);
		$row['sound']=$row1['id'];
	}
	$vjson=$row;
}

echo json_encode($vjson);
?>