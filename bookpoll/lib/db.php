<?php

class DB{
	private $link;

	function __construct( $config ){
		extract( $config );
		$this->link = mysqli_connect( $host, $user, $pass, $name, $port ) OR die( mysqli_connect_errno() );
		
		// para evitar problemas con la codificación
		$this->query( "SET lc_time_names = 'es_ES', NAMES 'utf8'" );
	}
	
	function __destruct(){
		@mysqli_close( $this->link );
	}
	
	
	function clean( $str ){
		//return $str = addslashes( $str );
		
		
		
		
		return $str;//mysqli_real_escape_string( $this->link, $str );
	}

	function query( $query ){
	//	echo $query;
		$res = mysqli_query( $this->link, $query );
		echo mysqli_error( $this->link );
		return $res;
	}
	
	function prepare( $query ){
		return $this->link->prepare( $query );
	}

	function queryRow( $query ){
		$res = $this->query( $query );
		$row = (object)$res->fetch_array( MYSQLI_ASSOC );
		return $row;
	}

	function queryOne( $query ){
		$res = $this->query( $query );
		$row = $res->fetch_array( MYSQLI_NUM );
		return $row[0];
	}
	
	function queryAll( $query ){	
		$rows = array();		
		if( $this->link->multi_query( $query ) ){
			do{
				if( $result = $this->link->store_result() ){
					while( $row = $result->fetch_object() ){
						$rows[] = $row;
					}
					$result->free();
				}
			}while( $this->link->next_result() );
		}
		return $rows;		
	}
	
	function getLastID(){
		return $this->queryOne( "SELECT LAST_INSERT_ID()" );
	}
}

?>