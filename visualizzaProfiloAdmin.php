<?php require_once('Connections/dbConnect.php'); ?><?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'].'?doLogout=true';
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != '')){
  $logoutAction .='&'. htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=='true')){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = 'esci.php';
  if ($logoutGoTo) {
    header('Location: $logoutGoTo');
    
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = 'admin';
$MM_donotCheckaccess = 'false';

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(',', $strUsers); 
    $arrGroups = Explode(',', $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == '') && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = 'accessoNegato.php';
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized('',$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = '?';
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, '?')) $MM_qsChar = '&';
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= '?' . $_SERVER['QUERY_STRING'];
  $MM_referrer =check($MM_referrer );
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . 'accesscheck=' . urlencode($MM_referrer);
  header('Location: '. $MM_restrictGoTo); 
  
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

$currentPage = $_SERVER['PHP_SELF'];

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = sprintf('pageNum_Recordset1');
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_dbConnect, $dbConnect);
$query_Recordset1 = 'SELECT * from utenti';
$query_limit_Recordset1 = sprintf('%s LIMIT %d, %d', $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $dbConnect);
 if(!$Recordset1) {
 
  trigger_error(mysql_error());

} else {
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = sprintf('totalRows_Recordset1');
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = '-1';
$colname_Recordset1 = $_SESSION['MM_Username'];
mysql_select_db($database_dbConnect, $dbConnect);
$query_Recordset1 = sprintf('SELECT * FROM utenti WHERE USERNAME = %s', GetSQLValueString($colname_Recordset1, 'text',$dbConnect));
$query_limit_Recordset1 = sprintf('%s LIMIT %d, %d', $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $dbConnect);
 if(!$Recordset1) {
 
  trigger_error(mysql_error());

} else {
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = '';
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode('&', $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, 'pageNum_Recordset1') == false && 
        stristr($param, 'totalRows_Recordset1') == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = '&' . htmlentities(implode('&', $newParams));
  }
}
$queryString_Recordset1 = sprintf('&totalRows_Recordset1=%d%s', $totalRows_Recordset1, $queryString_Recordset1);}}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>visualizza profilo</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
	</head>
<body>

		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<!-- Header -->
<header id="header" class="alt">
						<div class="align-center">
    <input type="Button" Value="< Indietro" onclick="javascript:history.back()">
    </div>
						<h1><a href="Home.php">SITE VIEW</a></h1>
						<nav id="nav">
							<ul>
								<li class="special">
									<a href="#menu" class="menuToggle"><span>Menu</span></a>
									<div id="menu">
									<div id="wrap">
  
  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script src="js/index.js"></script>
									  <ul><?php if(isset($_SESSION['MM_Username'])): ?>
  <b><li><h3><a href="<?php echo $logoutAction ?>">ESCI</a></h3></li></b>
<?php else: ?>
 <b><li><h3><a href="login.php">ENTRA</a></h3></li></b>
<?php endif; ?>
											<li><a href="Home.php">Home</a></li>
											<li><a href="areaRiservata.php">AREA AMMINISTRATORI</a></li>
										    <li><a href="areaPrivata.php">AREA PRIVATA</a></li>
										    <li><a href="info.php" class="more scrolly">info</a></li>
											<li><a href="contattaci.php">CONTATTACI</a></li>
									  </ul>
									</div>
								</li>
							</ul>
						</nav>
		  </header>

			<!-- Main -->
				<article id="main">
				  <header>
					    <h2>profilo personale</h2>
				  </header>
			    </article>
<table width="150" border="1">
  <tr>
    <th scope="row"><b><font color="#FFBF18">NOME:</b></font></th>
  <td><?php  $NOME = $row_Recordset1["NOME"];
          echo htmlspecialchars($NOME) ?></td>
  </tr>
  <tr>
    <th scope="row"><b><font color="#FFBF18">COGNOME:</b></font></th>
      <td><?php
		$COGNOME = $row_Recordset1['COGNOME'];
		echo htmlspecialchars($COGNOME); ?></td>
  </tr>
  <tr>
    <th scope="row"><b><font color="#FFBF18">SESSO:</b></font></th>
   <td><?php
		$SESSO = $row_Recordset1['SESSO'];
		echo htmlspecialchars($SESSO); ?></td>
  </tr>
  <tr>
    <th scope="row"><b><font color="#FFBF18">DATA DI NASCITA:</b></font></th>
    <td><?php 
		$DATADINASCITA = $row_Recordset1['DATA DI NASCITA'];
		echo htmlspecialchars($DATADINASCITA); ?></td>
  </tr>
  <tr>
    <th scope="row"><b><font color="#FFBF18">INDIRIZZO DI RESIDENZA:</b></font></th>
      <td><?php 
		$INDIRIZZODIRESIDENZA = $row_Recordset1['INDIRIZZO DI RESIDENZA'];
		echo htmlspecialchars($INDIRIZZODIRESIDENZA); ?></td>
  </tr>
  <tr>
    <th scope="row"><b><font color="#FFBF18">CITTA' DI RESIDENZA:</b></font></th>
     <td><?php 
		$CITTADIRESIDENZA = $row_Recordset1['CITTA DI RESIDENZA'];
		echo htmlspecialchars($CITTADIRESIDENZA); ?></td>
  </tr>
  <tr>
    <th scope="row"><b><font color="#FFBF18">PROVINCIA:</b></font></th>
    <td><?php 
		$PROVINCIA = $row_Recordset1['PROVINCIA'];
		echo htmlspecialchars($PROVINCIA); ?></td>
  </tr>
  <tr>
    <th scope="row"><b><font color="#FFBF18">CAP:</b></font></th>
    <td><?php 
		$CODICEPOSTALE = $row_Recordset1['CODICE POSTALE'];
		echo htmlspecialchars($CODICEPOSTALE) ?></td>
  </tr>
  <tr>
    <th scope="row"><b><font color="#FFBF18">TELEFONO:</b></font></th>
      <td><?php 
		$TELEFONO = $row_Recordset1['TELEFONO'];
		echo htmlspecialchars($TELEFONO); ?></td>
  </tr>
  <tr>
    <th scope="row"><b><font color="#FFBF18">EMAIL:</b></font></th>
     <td><?php 
		$EMAIL = $row_Recordset1['EMAIL'];
		echo htmlspecialchars($EMAIL); ?></td>
  </tr>
  <tr>
    <th scope="row"><b><font color="#FFBF18">USERNAME:</b></font></th>
   <td><?php 
		$USERNAME = $row_Recordset1['USERNAME'];
		echo htmlspecialchars($USERNAME); ?></td>
  </tr>
  <tr>
    <th scope="row"><b><font color="#FFBF18">PASSWORD:</b></font></th>
     <td><?php 
		$PASSWORD = $row_Recordset1['PASSWORD'];
		echo htmlspecialchars($PASSWORD); ?></td>
  </tr>
</table>	
				<!-- Footer -->
			  
				
	<footer id="footer">
					  <ul class="icons">
							<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
							<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>

							<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
							<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
							<li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
					  </ul>
</footer>

			</div>

		<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/jquery.scrollex.min.js"></script>
	<script src="assets/js/jquery.scrolly.min.js"></script>
	<script src="assets/js/skel.min.js"></script>
	<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
	<script src="assets/js/main.js"></script>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
