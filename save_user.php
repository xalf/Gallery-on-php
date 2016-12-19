<?php
    if (isset($_POST['login'])) { 
        $login = $_POST['login']; 
        if ($login == '') { 
            unset($login);
        } 
    } 
    if (isset($_POST['password'])) { 
        $password=$_POST['password']; 
        if ($password =='') { 
            unset($password);
        } 
    }
    if (empty($login) or empty($password)) 
   {
        echo "0";
    }
    $login = stripslashes($login);
    $login = htmlspecialchars($login);
    $password = stripslashes($password);
    $password = htmlspecialchars($password);
    $login = trim($login);
    $password = trim($password);
    require_once 'login.php';
    $db_server = mysql_connect($db_hostname, $db_username, $db_password);
    mysql_set_charset('utf8', $db_server);
    mysql_select_db($db_database);

    $result = mysql_query("SELECT id FROM users WHERE login='$login'",$db_server);
    $myrow = mysql_fetch_array($result);
    if (!empty($myrow['id'])) {
        echo "2";
    }
    $result2 = mysql_query ("INSERT INTO users (login,password) VALUES('$login','$password')");

    if ($result2=='TRUE')
    {
        echo '1';
    } else {
        echo "0";
    }
?>