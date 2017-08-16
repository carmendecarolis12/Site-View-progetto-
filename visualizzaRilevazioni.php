<?php
/* dichiariamo alcune importanti variabili per collegarci al data[]base */
$DBhost = "localhost";
$DBuser = "root";
$DBpass = "";
$DBName = "website";

/* specifichiamo il nome della nostra tabella */
$table = "rilevazioni";

/* Connettiamoci al data[]base */
$f = mysql_pconnect($DBhost,$DBuser,$DBpass);
if(!$f) {
  
  trigger_error("Impossibile collegarsi al server", E_USER_NOTICE);

} else {
$f = mysql_select_db("$DBName") ;
if(!$f) {
  
  trigger_error("Impossibile connettersi al data[]base $DBName", E_USER_NOTICE);

} else {

/* impostiamo la query e cerchiamo solo le amiche donne...*/
$record=mysql_query("SELECT * FROM $table ORDER BY RAND() LIMIT 10");
$i=0;
while($row = mysql_fetch_assoc($record)){
$b[] = $row['STRINGA'];
$aString[]= substr($b[$i], strpos($b[$i],'>')+2, (strlen($b[$i]) - 1) -(strpos($b[$i],'>')+2));
$a = str_split($aString[$i]);
$id[] = substr($b[$i], 1, strpos($b[$i],'>')-1);
$tipoMarca[] = substr($id[$i],strlen($id[$i])-4, strlen($id[$i]));

if(strpos($aString[$i],'.')){
    if (strcmp($tipoMarca[$i],"1122")==0){
		$marca[] = "Nesa";
        $tipo[] = "Sensore temperatura";
        $ora[] = $a[0] . "" . $a[1] . ":" . $a[2] . "" . $a[3];
        $data[] = $a[5] . "" . $a[6] . "/" . $a[7] . "" . $a[8] . "/" . $a[9] . "" . $a[10] . "" . $a[11] . "" . $a[12];
        $valore[] = substr($aString[$i],14,strpos($aString[$i],'>')-14);
        $descrizione[] = substr($aString[$i],strpos($aString[$i],'<')+1,strlen($aString[$i]));
    }else if (strcmp($tipoMarca[$i],"2233")==0){
		$marca[] = "Ams";
        $tipo[] = "Sensore umidita'";
        $data[] = $a[0] . "" . $a[1] . "/" . $a[2] . "" . $a[3] . "/" . $a[4] . "" . $a[5] . "" . $a[6] . "" .$a[7];
        $ora[] = $a[9] . "" . $a[10] . ":" . $a[11] . "" . $a[12];
        $valore[] = substr($aString[$i],14,strpos($aString[$i],'>')-14);
        $descrizione[] = substr($aString[$i],strpos($aString[$i],'<')+1,strlen($aString[$i]));
    }else if (strcmp($tipoMarca[$i],"1144")==0){
		$marca[] = "Nesa";
        $tipo[] = "Sensore concentrazione gas CO2";
        $ora[] = $a[0] . "" . $a[1] . ":" . $a[2] . "" . $a[3] . ":" . $a[4] . "" . $a[5];
        $valore[] = substr($aString[$i],7,(strlen($aString[$i])-29)-7);
        $data[] = substr($aString[$i],strlen($aString[$i])-28,(strlen($aString[$i])-26)-(strlen($aString[$i])-28)) . "/" . substr($aString[$i],strlen($aString[$i])-26,(strlen($aString[$i])-24)-(strlen($aString[$i])-26)) . "/" . substr($aString[$i],strlen($aString[$i])-24,strpos($aString[$i],'>')-(strlen($aString[$i])-24));
        $descrizione[] = substr($aString[$i],strpos($aString[$i],'<')+1,strlen($aString[$i])-(strpos($aString[$i],'<')+1));
    }else if (strcmp($tipoMarca[$i],"3355")==0){
		$marca[] = "Luchsinger";
        $tipo[] = "Sensore radiazione solare";
        $data[] = $a[6] ."". $a[7] ."/". $a[4] ."". $a[5] ."/". $a[0] ."". $a[1] ."". $a[2] ."". $a[3];
        $ora[] = $a[9] . "" . $a[10] . ":" . $a[11] . "" . $a[12] . ":" . $a[13] . "" . $a[14];
        $valore[] = substr($aString[$i],16,strpos($aString[$i],'>')-16);
        $descrizione[] = substr($aString[$i],strpos($aString[$i],'<')+1,strlen($aString[$i])-(strpos($aString[$i],'<')+1));
    }
}else{
    $marca[] = $tipo[] = $data[] = $ora[] = $valore[] = "  -  ";
    $descrizione[] = substr($aString[$i],strpos($aString[$i],'<')+1, strlen($aString[$i]));
}

$i++;
}}}
?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "esci.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    
  }
}
?>

<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "cliente";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "accessoNegato.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING']; 
  $MM_referrer =check($MM_referrer );
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer); 
  header("Location: ". $MM_restrictGoTo); 
  
}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>rilevazioni</title>
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
				    <h2>rilevazioni dei sensori</h2>
				  </header>
			    </article>
<table>
<thead>
    <tr>
      <th><b><font color="#FFBF18">MARCA</th></b></font>
      <th><b><font color="#FFBF18">TIPO</th></b></font>
      <th><b><font color="#FFBF18">DATA</th></b></font>
      <th><b><font color="#FFBF18">ORA</th></b></font>
      <th><b><font color="#FFBF18">VALORE</th></b></font>
      <th><b><font color="#FFBF18">DESCRIZIONE</th></b></font>
    </tr></thead>
    <tbody>
    <?php for($i=0;$i<10;$i++){ ?>
    <tr>
    	 <td><?php 
		$MARCA = htmlspecialchars($marca[$i]);
		print $MARCA; ?></td>
        <td><?php
        $TIPO = htmlspecialchars($tipo[$i]);
		print $TIPO; ?></td>
        <td><?php
        $DATA = htmlspecialchars($data[$i]);
		print $DATA; ?></td>
        <td><?php
        $ORA = htmlspecialchars($ora[$i]);
		print $ORA; ?></td>
        <td><?php
        $VALORE = htmlspecialchars($valore[$i]);
		print $VALORE; ?></td>
        <td><?php
        $DESCRIZIONE = htmlspecialchars($descrizione[$i]);
		print $DESCRIZIONE; ?></td>
        
    </tr>
    <?php ;} ?>
</tbody>
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