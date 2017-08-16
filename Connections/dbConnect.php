<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_dbConnect = 'localhost';
$database_dbConnect = 'website';
$username_dbConnect = 'root';
$password_dbConnect = '';
$dbConnect = mysql_pconnect($hostname_dbConnect, $username_dbConnect, $password_dbConnect) or trigger_error(mysql_error(),E_USER_ERROR); 
?>