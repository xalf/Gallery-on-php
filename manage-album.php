<?php
	require_once 'login.php';
	require_once 'classes.php';
 	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
 	mysql_set_charset('utf8', $db_server);
 	mysql_select_db($db_database);
 	$albumquery = "SELECT * FROM album";
 	$albumresult = mysql_query($albumquery);
 	$albumrows = mysql_num_rows($albumresult);

 	if($albumrows!=0){
	 	$queryImage = "SELECT * FROM image WHERE album=" . mysql_result($albumresult, 0, 'id');
	 	$resultImage = mysql_query($queryImage);
	 	$rowsImage = mysql_num_rows($resultImage);

	 	$albums = array();
	 	for ($i=0; $i < $albumrows; $i++) { 
	 		$albums[$i] = new Album(
	 			mysql_result($albumresult, $i, 'id'), 
	 			mysql_result($albumresult, $i, 'name'), 
	 			mysql_result($albumresult, $i, 'image'), 
	 			mysql_result($albumresult, $i, 'crop_x'), 
	 			mysql_result($albumresult, $i, 'crop_y'));
	 	}

	 	$images = array();
	 	for ($i=0; $i < $rowsImage; $i++) { 
	 		$images[$i] = new Image(mysql_result($resultImage, $i, 'id'),
	 			mysql_result($resultImage, $i, 'image'),
	 			mysql_result($resultImage, $i, 'album'));
	 	}
	 }

	require "manage-album.html";
?>