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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=sprintf('username');
  $password=sprintf('password');
  $MM_fldUserAuthorization = 'TIPO';
  $MM_redirectLoginSuccess = 'loginSuccesso.php';
  $MM_redirectLoginFailed = 'loginIncorretto.php';
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_dbConnect, $dbConnect);
  $LoginRS__query = sprintf(
 'SELECT USERNAME, PASSWORD, TIPO FROM utenti WHERE USERNAME=%s AND PASSWORD=%s',
  GetSQLValueString($loginUsername, 'text'),
   GetSQLValueString($password, 'text')
);
  
   
  $LoginRS = mysql_query($LoginRS__query, $dbConnect);
     if(!$LoginRS) {
 
  trigger_error(mysql_error());

} else {
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'TIPO');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = rawurlencode($_SESSION['PrevUrl']);
	  $MM_redirectLoginSuccess = check($MM_redirectLoginSuccess);
    }
    header('Location: ' . $MM_redirectLoginSuccess );
  }
  else {
    header('Location: '. $MM_redirectLoginFailed );
  }
}}
?>
<!DOCTYPE HTML>
<html>
<head>
		<title>LOGIN incorretto</title>
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
						  <h2>LOGIN</h2>
						</header>
						<section class="wrapper style5">
							<div class="align-center">
                            <p>Username o password inseriti non corretti, riprova.
                          <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" id="login">
							  <div class="row uniform">
											<div class="6u 12u$(xsmall)">
											  <input type="text" name="username" id="username" placeholder="Username" required/>
											</div>
											<div class="6u$ 12u$(xsmall)">
											  <input type="password" name="password" id="password" placeholder="Password" required/>
											</div>
                              </div><p></p>
                                            <input type="submit" name="submit" id="submit" class="special" value="LOGIN">
</div>
</form>
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