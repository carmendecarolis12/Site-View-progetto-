<?php require_once('Connections/dbConnect.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'].'?doLogout=true';
if ((isset($_SERVER['QUERY_STRING13'])) && ($_SERVER['QUERY_STRING13'] != '')){
  $logoutAction .='&'. htmlentities($_SERVER['QUERY_STRING13']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=='true')){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username13'] = NULL;
  $_SESSION['MM_UserGroup13'] = NULL;
  $_SESSION['PrevUrl13'] = NULL;
  unset($_SESSION['MM_Username13']);
  unset($_SESSION['MM_UserGroup13']);
  unset($_SESSION['PrevUrl13']);
	
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
  if (isset($_SERVER['QUERY_STRING13']) && strlen($_SERVER['QUERY_STRING13']) > 0) 
  $MM_referrer .= '?' . $_SERVER['QUERY_STRING13'];
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

if ((isset($_POST['MM_insert'])) && ($_POST['MM_insert'] == 'form1')) {
  $insertSQL = sprintf('INSERT INTO utenti (NOME, COGNOME, SESSO, `DATA DI NASCITA`, `INDIRIZZO DI RESIDENZA`, `CITTA DI RESIDENZA`, PROVINCIA, `CODICE POSTALE`, TELEFONO, EMAIL, USERNAME, PASSWORD, TIPO) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)',
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
                       sprintf('TIPO', 'text'));

  mysql_select_db($database_dbConnect, $dbConnect);
  $Result1 = mysql_query($insertSQL, $dbConnect);
     if(!$Result1) {
 
  trigger_error(mysql_error());

} else {

  $insertGoTo = 'GestisciUtente.php';
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? '&' : '?';
	
    $insertGoTo .= rawurlencode($_SERVER['QUERY_STRING']);
	$insertGoTo = check($insertGoTo);
  }
  header(sprintf('Location: %s', $insertGoTo));
}}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>aggiungi utente</title>
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
						  <h2>aggiungi un utente</h2>
						</header>
	<section class="wrapper style5">
							<div class="align-center">
	  <p>Inserire i dati del nuovo utente (tutti i campi sono obbligatori).</p>
      <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
        <table align="center">
          <tr valign="baseline">
            <td nowrap align="right">NOME:</td>
            <td><input type="text" name="NOME" value="" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">COGNOME:</td>
            <td><input type="text" name="COGNOME" value="" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">SESSO:</td>
            <td><input type="text" name="SESSO" value="" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">DATA DI NASCITA:</td>
            <td><input type="text" name="DATA_DI_NASCITA" value="" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">INDIRIZZO:</td>
            <td><input type="text" name="INDIRIZZO_DI_RESIDENZA" value="" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">CITTA':</td>
            <td><input type="text" name="CITTA_DI_RESIDENZA" value="" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">PROVINCIA:</td>
            <td><input type="text" name="PROVINCIA" value="" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">CAP:</td>
            <td><input type="text" name="CODICE_POSTALE" value="" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">TELEFONO:</td>
            <td><input type="text" name="TELEFONO" value="" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">EMAIL:</td>
            <td><input type="text" name="EMAIL" value="" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">USERNAME:</td>
            <td><input type="text" name="USERNAME" value="" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">PASSWORD:</td>
            <td><input type="text" name="PASSWORD" value="" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">TIPO:</td>
            <td><input type="text" name="TIPO" value="" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">&nbsp;</td>
            <td><input type="submit" class="special" value="AGGIUNGI"></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1">
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