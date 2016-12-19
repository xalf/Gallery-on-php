<?php
	require_once 'login.php';
	require_once 'classes.php';

	$albumid = $_GET['album'];
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
 	mysql_set_charset('utf8', $db_server);
 	mysql_select_db($db_database);
 	$queryImage = "SELECT * FROM image WHERE album=" . $albumid;
 	$resultImage = mysql_query($queryImage);
 	$rowsImage = mysql_num_rows($resultImage);

 	$images = array();
 	for ($i=0; $i < $rowsImage; $i++) { 
 		$images[$i] = new Image(mysql_result($resultImage, $i, 'id'),
 			mysql_result($resultImage, $i, 'image'),
 			mysql_result($resultImage, $i, 'album'));
 	}

 	$albumquery = "SELECT name FROM album WHERE id=" . $albumid;
 	$albumresult = mysql_query($albumquery);

 	$albumname = mysql_result($albumresult, 0);

	require "gallery.html";
?>