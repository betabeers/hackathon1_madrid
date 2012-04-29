<?php
echo PHP_EOL;echo PHP_EOL;

require_once(dirname(__FILE__) . '/../../models/BooksService.php');
require_once(dirname(__FILE__) . '/../../models/BooksParseService.php');

$query = "el señor de los anillos";


$book = new Book('3eb6fff19b5cbc9c5c78b90e5e008961');
//$book->save();
die( var_dump($book));
echo PHP_EOL;echo PHP_EOL;