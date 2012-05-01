<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php
include('/Users/juancarlos/Dropbox/comicSurfer/Site/api/tools/connect.php');
$link=connect();

$comic_id=1;

$r=mysql_query("select * from comics where id='$comic_id'", $link);
$row=mysql_fetch_assoc($r);
$nop=$row['comics_nop'];

$page_id=1;
if($_GET['page']) $page_id=$_GET['page'];

$r=mysql_query("select * from pages where id='$page_id'", $link);
$row=mysql_fetch_assoc($r);
$nov=$row['pages_nov'];
$page_image=$row['pages_image'];
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Comic Surfer - Admin</title>

<link rel="stylesheet" type="text/css" media="screen" href="/api/plugins/image_area_select/css/imgareaselect-animated.css" /> 
<script src="/api/js/jquery.js"></script>
<script src="/api/plugins/image_area_select/scripts/jquery.imgareaselect.pack.js"></script>

</style>
</head>

<body>

<script>
var ias;
$(function(){
    ias=$("#cropping_main").imgAreaSelect({ onSelectChange: set_coordinates, instance:true });
	
	$('#nov').change(function(){//alert($(this).val());
		load_vignette($(this).val());
	});
	load_vignette(1);
});

function load_vignette(order){
	$.post(
		'/api/actions/get_vignette.php',
		{page_id:<?= $page_id ?>, order:order},
		function(data){
			if(data['x1']!==undefined){//alert(data);
				ias.setSelection(data['x1'], data['y1'], data['x2'], data['y2'], true);
				ias.setOptions({ show: true });
				ias.update();
				
				$("#x1").val(data['x1']);  
				$("#y1").val(data['y1']); 
				$("#x2").val(data['x2']);  
				$("#y2").val(data['y2']);
				
				if(data['sound']=='') data['sound']=0;
				$('#sound').val(data['sound']);
			}
		}, 'json'
	);
}//

function set_coordinates(img, selection) {
    $("#x1").val(selection.x1);  
    $("#y1").val(selection.y1); 
    $("#x2").val(selection.x2);  
    $("#y2").val(selection.y2);   
} 

function save_vignette(){
        var x1 = $("#x1").val();
        var y1 = $("#y1").val();
        var x2 = $("#x2").val();
        var y2 = $("#y2").val();
		
		var page_id = $("#page_id").val();
		var vignette = $("#nov").val();
		var sound = $("#sound").val();
		
		if(x1=='' || y1=='' || x2=='' || y2==''){
			alert('Faltan datos');
			return;
		}
		
	    $.post(
			'/api/actions/save_vignette.php',
			{page_id:page_id, vignette:vignette, sound:sound, x1:x1, y1:y1, x2:x2, y2:y2},
			function(data){
				if(data['error']===undefined){
					//alert('ok');
				}else alert(data['error']);
			}//, 'json'
		);
}//
</script>

<!-- uso exclusivo del plugin. no modificar -->
<input type="hidden" id="x1" value="0" />
<input type="hidden" id="y1" value="0" />
<input type="hidden" id="x2" value="0" />
<input type="hidden" id="y2" value="0" />
<!-- -->

<div align="center">
<div align="left" style="width:900px;">

<h1>Cómic Surfer</h1>

<h2><b>Páginas de "PARDILLOS": </b>
<?php if($page_id!=1){ ?><a href="?page=1">1</a><?php }else echo '1'; ?>&nbsp;&nbsp;
<?php if($page_id!=2){ ?><a href="?page=2">2</a><?php }else echo '2'; ?>&nbsp;&nbsp;
<?php if($page_id!=3){ ?><a href="?page=3">3</a><?php }else echo '3'; ?>&nbsp;&nbsp;
</h2>

<input type="hidden" id="page_id" value="<?= $page_id ?>" />
<div>
	<div style="margin-bottom:20px;">
		<h2>Selecciona las viñetas de esta página</h2>
		<div>
			<select id="nov">
				<?php
				for($i=1; $i<=$nov; ++$i){
					?><option value="<?= $i ?>"><?= $i ?></option><?php
				}
				?>
			</select>
			&nbsp;&nbsp;
			<select id="sound">
				<option id="0">Sin sonido</option>
				<?php
				$r1=mysql_query("select * from sounds", $link);
				while($row1=mysql_fetch_assoc($r1)){
					?><option value="<?= $row1['id'] ?>"><?= $row1['sounds_name'] ?></option><?php
				}
				?>
			</select>
			&nbsp;&nbsp;<input type="button" value="Guardar" onclick="save_vignette();" />
		</div>
	</div>
	
	<div style="margin-bottom:20px; cursor:crosshair;" id="cropping_main_layer"><img id="cropping_main" src="/api/pages/<?= $page_image ?>" /></div>
</div>

<?php
/*
$v=array();
$r=mysql_query("select vignettes_x1 as 'x1', vignettes_x2 as 'x2', vignettes_y1 as 'y1', vignettes_y2 as 'y2' from vignettes", $link);
while($row=mysql_fetch_assoc($r)){
	array_push($v, $row);
}
$json=json_encode($v);
echo $json;
*/
?>

</div>
</div>

</body>
</html>
