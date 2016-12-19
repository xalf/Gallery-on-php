<?php
	require_once 'login.php';
	require_once 'classes.php';

	function deletealbum(){
		global $db_hostname, $db_username, $db_password, $db_database;
		$albumid = $_GET['album'];
		$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	 	mysql_set_charset('utf8', $db_server);
	 	mysql_select_db($db_database);
	 	$albumquery = "DELETE FROM album WHERE id=" . $albumid;
	 	$queryImage = "DELETE FROM image WHERE album=" . $albumid;
	 	$responseresult = mysql_query("SELECT name FROM album WHERE id=" . $albumid);
	 	$responsedata = mysql_result($responseresult, 0);
	 	$response = array(mysql_query($albumquery)&&mysql_query($queryImage), $responsedata);
	 	echo json_encode($response);
	}

	function getalbum(){
		global $db_hostname, $db_username, $db_password, $db_database;
		$albumid = $_GET['album'];
		$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	 	mysql_set_charset('utf8', $db_server);
	 	mysql_select_db($db_database);

	 	$albumquery = "SELECT * FROM album WHERE id=" . $albumid;
	 	$albumresult = mysql_query($albumquery);
	 	
	 	$imagequery = "SELECT * FROM image WHERE album=" . $albumid;
	 	$imageresult = mysql_query($imagequery);
	 	$rowsImage = mysql_num_rows($imageresult);
	 	$imagearray = array();
	 	for ($i=0; $i < $rowsImage; $i++) { 
	 		$imagearray[$i] = array(
	 			mysql_result($imageresult, $i, 'id'), 
	 			mysql_result($imageresult, $i, 'image'));
	 	}

	 	$request = array(mysql_result($albumresult, 0, 'id'), 
	 		mysql_result($albumresult, 0, 'name'), 
	 		mysql_result($albumresult, 0, 'image'), 
	 		mysql_result($albumresult, 0, 'crop_x'), 
	 		mysql_result($albumresult, 0, 'crop_y'),
	 		$imagearray);
	 	
	 	echo json_encode($request);
	}

	function editalbum(){
		global $db_hostname, $db_username, $db_password, $db_database;
		$albumid = $_POST['album'];
		$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	 	mysql_set_charset('utf8', $db_server);
	 	mysql_select_db($db_database);

	 	$uploaddir = "images/";
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
		move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);

	 	$responseresult = mysql_query("UPDATE album SET image='" . basename($_FILES['userfile']['name']) . "' WHERE id=" . $albumid);
	 	$testquery = mysql_query("SELECT * FROM album WHERE id=" . $albumid);
	 	$testresult = mysql_result($testquery, 0, 'image');
	 	$response = array($responseresult, basename($_FILES['userfile']['name']), $testresult);	
	 	echo json_encode($response);
	}

	function addalbum(){
		global $db_hostname, $db_username, $db_password, $db_database;
		$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	 	mysql_set_charset('utf8', $db_server);
	 	mysql_select_db($db_database);

		$testquery = "SELECT count(*) FROM album WHERE name='" . $_POST['name'] . "'";
 		$testresult = mysql_query($testquery);
 		$testrows = mysql_result($testresult,0);
		if($testrows!=0){
			echo '';
			return;
		}
		
	 	$uploaddir = 'images/';
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
		move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);

	 	$albumquery = "INSERT INTO `album` (`name`, `image`, `crop_x`, `crop_y`) VALUES ('" . $_POST['name'] . "', '" . basename($_FILES['userfile']['name']) . "', '" . $_POST['crop_x'] . "', '" . $_POST['crop_y'] . "');";
	 	echo mysql_query($albumquery);
	}

	function addimage(){
		global $db_hostname, $db_username, $db_password, $db_database;
		$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	 	mysql_set_charset('utf8', $db_server);
	 	mysql_select_db($db_database);

	 	$testquery = "SELECT count(*) FROM image WHERE image='" . basename($_FILES['userfile']['name']) . "' && album='" . $_POST['album'] . "'";
 		$testresult = mysql_query($testquery);
 		$testrows = mysql_result($testresult,0);
		if($testrows!=0){
			echo '';
			return;
		}

		$uploaddir = 'images/';
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
		move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);

	 	$albumquery = "INSERT INTO `image` (`image`, `album`) VALUES ('" . basename($_FILES['userfile']['name']) . "', '" . $_POST['album'] . "');";
	 	$responseresult = mysql_query($albumquery);
	 	$imageid = mysql_query("SELECT * FROM image WHERE image='" . basename($_FILES['userfile']['name']) . "'");
	 	$imageid = mysql_result($imageid, 0, 'id');
	 	$response = array($responseresult, basename($_FILES['userfile']['name']), $_POST['album'], $imageid);	
	 	echo json_encode($response);
	}

	function deleteimage(){
		global $db_hostname, $db_username, $db_password, $db_database;
		$albumid = $_GET['album'];
		$imageid = $_GET['image'];
		$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	 	mysql_set_charset('utf8', $db_server);
	 	mysql_select_db($db_database);

	 	$queryImage = "DELETE FROM image WHERE album=" . $albumid . " && id=" . $imageid;
	 	$responseresult = mysql_query("SELECT image FROM image WHERE id=" . $imageid);
	 	$responsedata = mysql_result($responseresult, 0);
	 	$response = array(mysql_query($queryImage), $responsedata);
	 	echo json_encode($response);
	}

	call_user_func($_REQUEST['method']);
?>