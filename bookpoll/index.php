<?php

require 'setup.php';
$polls = $db->queryAll("SELECT * FROM books LIMIT 10");

?>
<html>
<head>
	<title>Bookpoll</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="css/foundation/stylesheets/foundation.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="css/foundation/stylesheets/app.css" type="text/css" media="screen" />
	
	<link rel="stylesheet" href="js/jquery/css/ui-lightness/jquery-ui-1.8.19.custom.css" />
	<script src="js/jquery/js/jquery-1.7.2.min.js"></script>
	<script src="js/jquery/js/jquery-ui-1.8.19.custom.min.js"></script>
</head>
<body>


<div class="container">

<h1>¿Que libro me recomiendas?</h1>

<br/>

<form action="new.php" method="post">

Libro 1 <input name="book1" id="book1" /> &nbsp; &nbsp; &nbsp;
Libro 2 <input name="book2" id="book2" /> &nbsp; &nbsp; &nbsp;
<input type="submit" value="Publicar encuesta" class="nice small radius blue button"/>

</form>

<br/>

<b>Encuestas anteriores</b>

<br/><br/>

<?php if( $polls ): ?>
	<ul>
	<?php foreach( $polls as $poll ): ?>
		<li><a href="view.php?id=<?=$poll->id?>"><?=$poll->book1?> vs <?=$poll->book2?></a></li>
	<?php endforeach ?>
		<li><a href="archive.php">Encuestas anteriores</a></li>
	</ul>
<?php else: ?>
	<p>No hay resultados</p>
<?php endif ?>

</div>


<script>
$(function() {

	$( "#book1" ).focus().autocomplete({
		source: "autocomplete.php",
		minLength: 3,
		select: function( event, ui ) {
			$(this).val( ui.item );
		}
	});
	
	$( "#book2" ).autocomplete({
		source: "autocomplete.php",
		minLength: 3,
		select: function( event, ui ) {
			$(this).val( ui.item );
		}
	});
});
</script>

</body>
</html>