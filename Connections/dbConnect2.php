<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_dbConnect2 = 'localhost';
$database_dbConnect2 = 'website';
$username_dbConnect2 = 'root';
$password_dbConnect2 = '' ;
$dbConnect2 = mysql_pconnect($hostname_dbConnect2, $username_dbConnect2, $password_dbConnect2) or trigger_error(mysql_error(),E_USER_ERROR); 
?>