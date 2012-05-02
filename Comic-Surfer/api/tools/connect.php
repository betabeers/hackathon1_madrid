<?php
function connect(){ 
	   if (!($link=mysql_connect("localhost","**","**"))){ 
		  echo "Error conectando a la base de datos."; 
		  exit(); 
	   } 
	   if (mysql_select_db("**",$link)){ 
		  $n=0;//mysql_query("SET NAMES 'utf8'"); #IMPORTANTE!
	   }else exit();
	   
	   
	   return $link;
}//
?>