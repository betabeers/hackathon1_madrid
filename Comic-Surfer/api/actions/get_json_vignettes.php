<?php
include('/home1/lhtwoolc/public_html/comicsurfer/api/tools/connect.php');
$link=connect();

$page_id=$_GET['page_id'];

// Query
$query = sprintf("select vignettes_x1 as 'x1', vignettes_x2 as 'x2', vignettes_y1 as 'y1', vignettes_y2 as 'y2', vignettes_order as 'order', vignettes_sound as 'sound' from vignettes where vignettes_page_id='%s' order by vignettes_order",
            mysql_real_escape_string($page_id));

$v=array();

$r=mysql_query($query, $link);
while($row=mysql_fetch_assoc($r)){
	array_push($v, $row);
}
$json=json_encode($v);

echo $json;
?>