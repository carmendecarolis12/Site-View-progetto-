<?php require_once('Connections/dbConnect.php'); ?><?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'].'?doLogout=true';
if ((isset($_SERVER['QUERY_STRING26'])) && ($_SERVER['QUERY_STRING26'] != '')){
  $logoutAction .='&'. htmlentities($_SERVER['QUERY_STRING26']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=='true')){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username26'] = NULL;
  $_SESSION['MM_UserGroup26'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username26']);
  unset($_SESSION['MM_UserGroup26']);
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
  $MM_referrer = check($MM_referrer);
  if (strpos($MM_restrictGoTo, '?')) $MM_qsChar = '&';
  if (isset($_SERVER['QUERY_STRING26']) && strlen($_SERVER['QUERY_STRING26']) > 0) 
  $MM_referrer .= '?' . $_SERVER['QUERY_STRING26'];
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= '?' . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST['MM_update'])) && ($_POST['MM_update'] == 'form1')) {
  $updateSQL = sprintf('UPDATE utenti SET NOME=%s, COGNOME=%s, SESSO=%s, `DATA DI NASCITA`=%s, `INDIRIZZO DI RESIDENZA`=%s, `CITTA DI RESIDENZA`=%s, PROVINCIA=%s, `CODICE POSTALE`=%s, TELEFONO=%s, EMAIL=%s, USERNAME=%s, PASSWORD=%s WHERE ID=%s',
                       sprintf('NOME', 'text'),
                       sprintf('COGNOME', 'text'),
                       sprintf('SESSO', 'text'),
                       sprintf('DATA_DI_NASCITA', 'text'),
                       sprintf('INDIRIZZO_DI_RESIDENZA', 'text'),
                       sprintf('CITTA_DI_RESIDENZA', 'text'),
                       sprintf('PROVINCIA', 'text'),
                       sprintf('CODICE_POSTALE', 'int'),
                       sprintf('TELEFONO', 'int'),
                       sprintf('EMAIL', 'text'),
                       sprintf('USERNAME', 'text'),
                       sprintf('PASSWORD', 'text'),
                       sprintf('ID', 'int'));

  mysql_select_db($database_dbConnect, $dbConnect);
  $Result1 = mysql_query($updateSQL, $dbConnect);
if(!$Result1) {
  
  trigger_error(mysql_error());

} else {


  $updateGoTo = 'areaPrivataAdmin.php';
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? '&' : '?';
	
    $updateGoTo .= rawurlencode($_SERVER['QUERY_STRING']);
	$updateGoTo = check($updateGoTo);
  }
  header(sprintf('Location: %s', $updateGoTo));
}

$colname_Recordset1 = '-1';
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = sprintf('MM_Username');
}
mysql_select_db($database_dbConnect, $dbConnect);
$query_Recordset1 = sprintf('SELECT * FROM utenti WHERE USERNAME = %s', GetSQLValueString($colname_Recordset1, 'text'));
$Recordset1 = mysql_query($query_Recordset1, $dbConnect);
if(!$Recordset1) {
  
  trigger_error(mysql_error());

} else {
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
mysql_free_result($Recordset1);
}}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>modifica dati personali</title>
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
    <header id="header">
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
						  <h2>modifica dati personali</h2>
						</header>
	<section class="wrapper style5">
    <div class="align-center">
							  <p>Inserire i dati nei campi da modificare</p>
							  </div>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <table align="center">
        <tr valign="baseline">
          <td nowrap align="right">NOME:</td>
          <td><input type="text" name="NOME" value="<?php echo htmlentities($row_Recordset1['NOME'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">COGNOME:</td>
          <td><input type="text" name="COGNOME" value="<?php echo htmlentities($row_Recordset1['COGNOME'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">SESSO:</td>
          <td><input type="text" name="SESSO" value="<?php echo htmlentities($row_Recordset1['SESSO'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">DATA DI NASCITA:</td>
          <td><input type="text" name="DATA_DI_NASCITA" value="<?php echo htmlentities($row_Recordset1['DATA DI NASCITA'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">INDIRIZZO DI RESIDENZA:</td>
          <td><input type="text" name="INDIRIZZO_DI_RESIDENZA" value="<?php echo htmlentities($row_Recordset1['INDIRIZZO DI RESIDENZA'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">CITTA':</td>
          <td><input type="text" name="CITTA_DI_RESIDENZA" value="<?php echo htmlentities($row_Recordset1['CITTA DI RESIDENZA'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">PROVINCIA:</td>
          <td><input type="text" name="PROVINCIA" value="<?php echo htmlentities($row_Recordset1['PROVINCIA'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">CAP:</td>
          <td><input type="text" name="CODICE_POSTALE" value="<?php echo htmlentities($row_Recordset1['CODICE POSTALE'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">TELEFONO:</td>
          <td><input type="text" name="TELEFONO" value="<?php echo htmlentities($row_Recordset1['TELEFONO'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">EMAIL:</td>
          <td><input type="text" name="EMAIL" value="<?php echo htmlentities($row_Recordset1['EMAIL'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">USERNAME:</td>
          <td><input type="text" name="USERNAME" value="<?php echo htmlentities($row_Recordset1['USERNAME'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">PASSWORD:</td>
          <td><input type="text" name="PASSWORD" value="<?php echo htmlentities($row_Recordset1['PASSWORD'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">&nbsp;</td>
          <td><input type="submit" class="special" value="Salva"></td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form1">
      <input type="hidden" name="ID" value="<?php echo $row_Recordset1['ID']; ?>">
    </form>
    <p>&nbsp;</p>
    </section>
					</article>

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


