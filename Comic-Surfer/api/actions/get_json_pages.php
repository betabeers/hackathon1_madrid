<?php
include('/home1/lhtwoolc/public_html/comicsurfer/api/tools/connect.php');
$link=connect();

$comic_id=$_GET['comic_id'];

// Query
$query = sprintf("select id, pages_image as 'image', pages_order as 'order' from pages where pages_comic_id='%s' order by pages_order",
            mysql_real_escape_string($comic_id));

$v=array();

$r=mysql_query($query, $link);
while($row=mysql_fetch_assoc($r)){
	array_push($v, $row);
}
$json=json_encode($v);

echo $json;
?>