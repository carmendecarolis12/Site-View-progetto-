<?php require_once('Connections/dbConnect.php'); ?><?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'].'?doLogout=true';
if ((isset($_SERVER['QUERY_STRING8'])) && ($_SERVER['QUERY_STRING8'] != '')){
  $logoutAction .='&'. htmlentities($_SERVER['QUERY_STRING8']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=='true')){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username8'] = NULL;
  $_SESSION['MM_UserGroup8'] = NULL;
  $_SESSION['PrevUrl8'] = NULL;
  unset($_SESSION['MM_Username8']);
  unset($_SESSION['MM_UserGroup8']);
  unset($_SESSION['PrevUrl8']);
	
  $logoutGoTo = 'esci.php';
  if ($logoutGoTo) {
    header('Location: $logoutGoTo');
    
  }
}
?>
<?php
if (!function_exists('GetSQLValueString')) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = '', $theNotDefinedValue = '') 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists('mysql_real_escape_string') ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case 'text':
      $theValue = ($theValue != '') ? "'" . $theValue . "'" : 'NULL';
      break;    
    case 'long':
    case 'int':
      $theValue = ($theValue != '') ? intval($theValue) : 'NULL';
      break;
    case 'double':
      $theValue = ($theValue != '') ? doubleval($theValue) : 'NULL';
      break;
    case 'date':
      $theValue = ($theValue != '') ? "'" . $theValue . "'" : 'NULL';
      break;
    case 'defined':
      $theValue = ($theValue != '') ? $theDefinedValue : $theNotDefinedValue;
      break;
	  default:
	 	 echo "inserire un tipo text, long, int, double, data o defined";
  }
  return $theValue;
}
}

if ((isset($_GET['ID'])) && ($_GET['ID'] != '')) {
  $deleteSQL = sprintf('DELETE FROM utenti WHERE ID=%s',
                       sprintf('ID', 'int'));

  mysql_select_db($database_dbConnect, $dbConnect);
  $Result1 = mysql_query($deleteSQL, $dbConnect) ;
     if(!$Result1) {
 
  trigger_error(mysql_error());

} else {

  $deleteGoTo = 'GestisciUtente.php';
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? '&' : '?';
    $deleteGoTo .= rawurlencode($_SERVER['QUERY_STRING']);
	$deleteGoTo =check($deleteGoTo );
  }
  header(sprintf('Location: %s', $deleteGoTo));
}

$colname_Recordset1 = '-1';
if (isset($_GET['ID'])) {
  $colname_Recordset1 = sprintf('ID');
}
mysql_select_db($database_dbConnect, $dbConnect);
$query_Recordset1 = sprintf('SELECT * FROM utenti WHERE ID = %s', GetSQLValueString($colname_Recordset1, 'int'));
$Recordset1 = mysql_query($query_Recordset1, $dbConnect) ;
   if(!$Recordset1) {
 
  trigger_error(mysql_error());

} else {
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_free_result($Recordset1);}}
?>
