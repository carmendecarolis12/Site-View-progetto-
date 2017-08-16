<?php require_once('Connections/dbConnect.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'].'?doLogout=true';
if ((isset($_SERVER['QUERY_STRING5'])) && ($_SERVER['QUERY_STRING5'] != '')){
  $logoutAction .='&'. htmlentities($_SERVER['QUERY_STRING5']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=='true')){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username5'] = NULL;
  $_SESSION['MM_UserGroup5'] = NULL;
  $_SESSION['PrevUrl5'] = NULL;
  unset($_SESSION['MM_Username5']);
  unset($_SESSION['MM_UserGroup5']);
  unset($_SESSION['PrevUrl5']);
	
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

mysql_select_db($database_dbConnect, $dbConnect);
$query_Recordset1 = 'SELECT * from utenti';
$Recordset1 = mysql_query($query_Recordset1, $dbConnect) ;
   if(!$Recordset1) {
 
  trigger_error(mysql_error());

} else {
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);}
?>
<!DOCTYPE HTML>
<html>
<head><meta charset="UTF-8">
		<title>SITE VIEW</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<link rel="stylesheet" href="css/style.css">
	</head>
		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<!-- Header -->
    <header id="header">
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
										    <li><a href="#three" class="more scrolly">info</a></li>
											<li><a href="contattaci.php">CONTATTACI</a></li>
			
									  </ul>
									</div>
								</li>
							</ul>
						</nav>
			  </header>

				<!-- Banner -->
					<section id="banner">
						<div class="inner">
						  <h2>Site View</h2>
						  <p>Controlla i tuoi siti </p>
						  <p>ovunque tu sia</p>
						</div>
						<a href="#three" class="more scrolly"></a>
					</section>

				<!-- One -->
			  

				<!-- Three -->
					<section id="three" class="wrapper style3 special">
						<div class="inner">
						  <header class="major">
						    <h2 name="info">CHI SIAMO?</h2>
							  <p>Siamo un'azienda volta all'uso di sistemi basati su Iot.</p>
							  <p>Permettiamo ai nostri clienti di monitorare i loro siti attraverso sensori ambientali di nostra produzione semplicemente collegandosi su questo sito da ogni tipo di dispositivo, in modo da poter visualizzare le rilevazioni in qualsiasi luogo ci si trovi.<br>
						    </p>
							</header>
							
						</div>
					</section>

				<!-- CTA -->
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
