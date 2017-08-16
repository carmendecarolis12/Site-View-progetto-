<?php require_once('Connections/dbConnect.php'); ?><?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'].'?doLogout=true';
if ((isset($_SERVER['QUERY_STRING2'])) && ($_SERVER['QUERY_STRING2'] != '')){
  $logoutAction .='&'. htmlentities($_SERVER['QUERY_STRING2']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=='true')){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username2'] = NULL;
  $_SESSION['MM_UserGroup2'] = NULL;
  $_SESSION['PrevUrl2'] = NULL;
  unset($_SESSION['MM_Username2']);
  unset($_SESSION['MM_UserGroup2']);
  unset($_SESSION['PrevUrl2']);
	
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
   $MM_referrer= chdeck( $MM_referrer);
  if (strpos($MM_restrictGoTo, '?')) $MM_qsChar = '&';
  if (isset($_SERVER['QUERY_STRING2']) && strlen($_SERVER['QUERY_STRING2']) > 0) 
  $MM_referrer .= '?' . $_SERVER['QUERY_STRING2'];
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
  $pageNum_Recordset1 = sprintf('pageNum_Recordset1');
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_dbConnect, $dbConnect);
$query_Recordset1 = 'SELECT * FROM utenti ORDER BY ID ASC';
$query_limit_Recordset1 = sprintf('%s LIMIT %d, %d', $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $dbConnect) ;
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
		<title>gestione utente</title>
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
					    <h2>gestisci gli utenti</h2>
					  </header>
					</article>
<table>
<thead>
    <tr>
      <th><b><font color="#FFBF18">ID</th></b></font>
      <th><b><font color="#FFBF18">NOME</th></b></font>
      <th><b><font color="#FFBF18">COGNOME</th></b></font>
      <th><b><font color="#FFBF18">SESSO</th></b></font>
      <th><b><font color="#FFBF18">DATA DI NASCITA</th></b></font>
      <th><b><font color="#FFBF18">INDIRIZZO</th></b></font>
      <th><b><font color="#FFBF18">CITTA'</th></b></font>
      <th><b><font color="#FFBF18">PROVINCIA</th></b></font>
      <th><b><font color="#FFBF18">CAP</th></b></font>
      <th><b><font color="#FFBF18">TELEFONO</th></b></font>
      <th><b><font color="#FFBF18">EMAIL</th></b></font>
      <th><b><font color="#FFBF18">USERNAME</th></b></font>
      <th><b><font color="#FFBF18">PASSWORD</th></b></font>
      <th><b><font color="#FFBF18">TIPO</th></b></font>
      <th></th>
      <th></th>
    </tr></thead>
    <?php do { ?>
    <tr>
    	<td><?php  $ID = $row_Recordset1["ID"];
          echo htmlspecialchars($ID) ?></td>
        <td><?php  $NOME = $row_Recordset1["NOME"];
          echo htmlspecialchars($NOME) ?></td>
        <td><?php
		$COGNOME = $row_Recordset1['COGNOME'];
		echo htmlspecialchars($COGNOME); ?></td>
        <td><?php
		$SESSO = $row_Recordset1['SESSO'];
		echo htmlspecialchars($SESSO); ?></td>
        <td><?php 
		$DATADINASCITA = $row_Recordset1['DATA DI NASCITA'];
		echo htmlspecialchars($DATADINASCITA); ?></td>
        <td><?php 
		$INDIRIZZODIRESIDENZA = $row_Recordset1['INDIRIZZO DI RESIDENZA'];
		echo htmlspecialchars($INDIRIZZODIRESIDENZA); ?></td>
        <td><?php 
		$CITTADIRESIDENZA = $row_Recordset1['CITTA DI RESIDENZA'];
		echo htmlspecialchars($CITTADIRESIDENZA); ?></td>
        <td><?php 
		$PROVINCIA = $row_Recordset1['PROVINCIA'];
		echo htmlspecialchars($PROVINCIA); ?></td>
        <td><?php 
		$CODICEPOSTALE = $row_Recordset1['CODICE POSTALE'];
		echo htmlspecialchars($CODICEPOSTALE) ?></td>
        <td><?php 
		$TELEFONO = $row_Recordset1['TELEFONO'];
		echo htmlspecialchars($TELEFONO); ?></td>
        <td><?php 
		$EMAIL = $row_Recordset1['EMAIL'];
		echo htmlspecialchars($EMAIL); ?></td>
        <td><?php 
		$USERNAME = $row_Recordset1['USERNAME'];
		echo htmlspecialchars($USERNAME); ?></td>
        <td><?php 
		$PASSWORD = $row_Recordset1['PASSWORD'];
		echo htmlspecialchars($PASSWORD); ?></td>
        <td ><?php 
		$TIPO = $row_Recordset1['TIPO'];
		echo htmlspecialchars($TIPO); ?></td>
        <form id="edit"></div><td>
        <font color="#ED4933">
          <a href="modificaUtente.php?ID=<?php echo $row_Recordset1['ID']; ?>">MODIFICA</a>
          </td>
      </form>
        <td> <font color="#ED4933"><a href="eliminaUtente.php?ID=<?php echo $row_Recordset1['ID']; ?>">ELIMINA</a></font></td>
        
          </tr>
          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        <form id="add"></div><a class="button special" href="aggiungiUtente.php?id=<?php echo $row_Recordset1['ID']; ?>">AGGIUNGI</a>
        </form>
  </tbody>
</table>
<div class=align-center>
<font color="#ED4933">
	<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">Primo</a>
	<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Indietro</a>
	<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">Avanti</a>
	<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">Ultimo</a>
	</font>
</div>
</form>
			
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
