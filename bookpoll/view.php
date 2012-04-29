<?php

require 'setup.php';

$id = (int) $_GET['id'];

$poll = $db->queryRow("SELECT * FROM books WHERE id = " . $id);


function getGBooksRating($title){
	$rating = 0;
	$url = 'https://www.googleapis.com/books/v1/volumes?q=intitle:' . urlencode( $title );
	$json = json_decode( file_get_contents( $url ) );
	$items = $json->items;
	if( $items ){
		$rating = $items[0]->volumeInfo->averageRating;
	}
	return $rating;
}

$rank1 = getGBooksRating($poll->book1);
$rank2 = getGBooksRating($poll->book2);

?>
<html>
<head>
	<title>¿Qué libro recomiendas <?=$poll->book1?> vs <?=$poll->book2?>?</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="css/foundation/stylesheets/foundation.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="css/foundation/stylesheets/app.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">

<h1>¿Qué libro recomiendas <?=$poll->book1?> vs <?=$poll->book2?>?</a></h1>

<div class="box <?php if( $poll->op1 && $poll->op1 > $poll->op2 ): ?>winner<?php endif ?>">
	<b><?=$poll->book1?></b><br/>
	<?=$poll->op1?> votos<br/><br/>
	<a href="vote.php?id=<?=$poll->id?>&op=1" class="small nice button radius blue">Votar</a>
</div>

<div class="box <?php if( $poll->op2 && $poll->op1 < $poll->op2 ): ?>winner<?php endif ?>">
	<b><?=$poll->book2?></b><br/>
	<?=$poll->op2?> votos<br/><br/>
	<a href="vote.php?id=<?=$poll->id?>&op=2" class="small nice button radius blue">Votar</a>
</div>

<br class="clearfix"/>

<h4>Recomendación usuarios google books</h4>

<div class="box <?php if( $rank1 && $rank1 > $rank2 ): ?>winner<?php endif ?>">
	<b><?=$poll->book1?></b><br/>
	<?=$rank1?> puntuación media
</div>

<div class="box <?php if( $rank2 && $rank1 < $rank2 ): ?>winner<?php endif ?>">
	<b><?=$poll->book2?></b><br/>
	<?=$rank2?> puntuación media
</div>

<br class="clearfix"/>

<div class="alert-box">
	Comparte la encuesta con tus amigos:<br/><br/>
	<a href="https://twitter.com/share" class="twitter-share-button" data-lang="es">Twittear</a>
	<div class="fb-like" data-href="http://<?=$_SERVER['HTTP_HOST'].$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false"></div>
</div>

<br/>

<a href="new.php" class="nice small radius button">Crear encuesta</a>

</div>

<!-- share -->
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<div id="fb-root"></div>
<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=136997243090232";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

</body>
</html>