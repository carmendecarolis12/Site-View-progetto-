<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'].'?doLogout=true';
if ((isset($_SERVER['QUERY_STRING15'])) && ($_SERVER['QUERY_STRING15'] != '')){
  $logoutAction .='&'. htmlentities($_SERVER['QUERY_STRING15']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=='true')){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username15'] = NULL;
  $_SESSION['MM_UserGroup15'] = NULL;
  $_SESSION['PrevUrl15'] = NULL;
  unset($_SESSION['MM_Username15']);
  unset($_SESSION['MM_UserGroup15']);
  unset($_SESSION['PrevUrl15']);
	
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

$MM_restrictGoTo = 'accessoNegatoAreaRiservata.php';
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
<!DOCTYPE HTML>
<html>
	<head>
		<title>AREA RISERVATA</title>
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
						  <h2>area riservata</h2>
						</header>
						<section class="wrapper style5">
							<div class="align-center">
							  <p>Cosa vorresti fare?</p>
							  <a href="GestisciUtente.php" class="button special">Gestire utenti</a>
							  <p></p>
							  <a href="GestisciSensori.php" class="button special">Gestire sensori</a><p></p>
							  <a href="GestisciSiti.php" class="button special">Gestire siti</a>
</div>
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