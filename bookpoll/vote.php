<?php

require 'setup.php';

$id = (int) $_GET['id'];
$op = (int) $_GET['op'];

$poll = $db->queryRow("SELECT * FROM books WHERE id = " . $id);
if( $poll ){

	if( $op == 1 ) $poll->op1++;
	if( $op == 2 ) $poll->op2++;

	$stmt = $db->prepare("UPDATE books SET op1=?, op2=? WHERE id=?");
	$stmt->bind_param("iii", $poll->op1, $poll->op2, $id);
	$stmt->execute();

	header('location: view.php?id=' . $id);
}else{
	header('location: index.php');
}