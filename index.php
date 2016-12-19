<?php 
	require_once 'login.php';
	require_once 'classes.php';

	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
 	mysql_set_charset('utf8', $db_server);
 	mysql_select_db($db_database);
 	$albumquery = "SELECT * FROM album";
 	$albumresult = mysql_query($albumquery);
 	$albumrows = mysql_num_rows($albumresult);

	$albums = array();
 	for ($i=0; $i < $albumrows; $i++) { 
 		$albums[$i] = new Album(
 			mysql_result($albumresult, $i, 'id'), 
 			mysql_result($albumresult, $i, 'name'), 
 			mysql_result($albumresult, $i, 'image'), 
 			mysql_result($albumresult, $i, 'crop_x'), 
 			mysql_result($albumresult, $i, 'crop_y'));
 	}
	
	require "index.html";
?>