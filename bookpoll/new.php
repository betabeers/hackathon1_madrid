<?php

require 'setup.php';

$book1 = strip_tags( $_POST['book1'] );
$book2 = strip_tags( $_POST['book2'] );

if( $book1 && $book2 ){

	// publish book poll
	$stmt = $db->prepare("INSERT INTO books(book1,book2,date) VALUES (?,?,NOW())");
	$stmt->bind_param("ss", $book1, $book2);
	$stmt->execute();
	
	// go to book poll
	$id = $db->getLastID();
	header('location: view.php?published&id=' . $id);

}else{

	header('location: index.php');

}