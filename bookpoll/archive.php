<?php

require 'setup.php';
$polls = $db->queryAll("SELECT * FROM books");

?>
<html>
<head>
	<title>Encuestas anteriores - Bookpoll</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="css/foundation/stylesheets/foundation.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="css/foundation/stylesheets/app.css" type="text/css" media="screen" />
</head>
<body>


<div class="container">

<h1>Encuestas anteriores</h1>

<ul>
	<?php foreach( $polls as $poll ): ?>
	
		<li><a href="view.php?id=<?=$poll->id?>"><?=$poll->book1?> vs <?=$poll->book2?></a></li>
	
	<?php endforeach ?>

</ul>

<a href="new.php" class="nice small radius blue button">Crear encuesta</a>

</div>

</body>
</html>