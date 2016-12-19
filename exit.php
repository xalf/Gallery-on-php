<?php 
session_start();

unset($_SESSION['password']);
unset($_SESSION['login']); 
unset($_SESSION['id']);

exit("<html><head><title>Загрузка..</title><meta http-equiv='Refresh' content='0; URL=index.php'></head></html>");
?>