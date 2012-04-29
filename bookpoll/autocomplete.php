<?php

$results = array();

$query = urlencode( $_GET['term'] );
if( $query ){
	$json = json_decode( file_get_contents( 'http://suggestqueries.google.com/complete/search?client=firefox&q=' . $query ) );
	$results = $json[1];
}

echo json_encode( $results );