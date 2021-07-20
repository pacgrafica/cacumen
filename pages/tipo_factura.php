<?php require_once('../Connections/sistemapacgrafica.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login_error.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_plantucarro = "SELECT * FROM plantucarro";
$plantucarro = mysql_query($query_plantucarro, $sistemapacgrafica) or die(mysql_error());
$row_plantucarro = mysql_fetch_assoc($plantucarro);
$totalRows_plantucarro = mysql_num_rows($plantucarro);

mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_plantuinmueble = "SELECT * FROM plantuinmueble";
$plantuinmueble = mysql_query($query_plantuinmueble, $sistemapacgrafica) or die(mysql_error());
$row_plantuinmueble = mysql_fetch_assoc($plantuinmueble);
$totalRows_plantuinmueble = mysql_num_rows($plantuinmueble);

mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_plantumoto = "SELECT * FROM plantumoto";
$plantumoto = mysql_query($query_plantumoto, $sistemapacgrafica) or die(mysql_error());
$row_plantumoto = mysql_fetch_assoc($plantumoto);
$totalRows_plantumoto = mysql_num_rows($plantumoto);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tipo de Factura</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<div class="panel panel-default">
  <div class="panel-heading">Panel heading without title</div>
  <div class="panel-body">
    Panel content
  </div>
</div>    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
       <?php include("includes/menu.php"); ?>
      <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Tipo Factura</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
               
                <div class="list-group">
  <a href="#" class="list-group-item active">
    Factura Pac Grafica
  </a>
      <div class="btn-group btn-group-justified" role="group" aria-label="...">
       
          <div class="btn-group" role="group">
            <a href="add_factura.php"><button type="button" class="btn btn-default">Factura Pac Grafica</button></a>
          </div>
          
  

      </div>
</div>
              
              
              
                 
              
              
               <div class="list-group">
  <a href="#" class="list-group">
   <img src="../images/tucarro.png" width="300" height="52"> </a>
      <div class="btn-group btn-group-justified" role="group" aria-label="...">
        <?php do { ?>
          <div class="btn-group" role="group">
            <a href="factura_tucarro.php?recordID=<?php echo $row_plantucarro['Id_tarifa']; ?>"><button type="button" class="btn btn-default"><?php echo $row_plantucarro['Tipo']; ?></button></a>
          </div>
          <?php } while ($row_plantucarro = mysql_fetch_assoc($plantucarro)); ?>
  

      </div>
</div>




           <div class="list-group">
  <a href="#" class="list-group">
    <img src="../images/tuinmueble.png" width="300" height="54"> </a>
      <div class="btn-group btn-group-justified" role="group" aria-label="...">
        
          <?php do { ?>
            <div class="btn-group" role="group">
              <a href="factura_inmueble.php?recordID=<?php echo $row_plantuinmueble['Id_tarifa']; ?>"><button type="button" class="btn btn-default"><?php echo $row_plantuinmueble['Tipo']; ?></button></a>
            </div>
            <?php } while ($row_plantuinmueble = mysql_fetch_assoc($plantuinmueble)); ?>
          
      </div>
</div>      



 <div class="list-group">
  <a href="#" class="list-group">
    <img src="../images/tumoto.png" width="300" height="41"> </a>
      <div class="btn-group btn-group-justified" role="group" aria-label="...">
        
          
            <?php do { ?>
              <div class="btn-group" role="group">
                <a href="factura_tumoto.php?recordID=<?php echo $row_plantumoto['Id_tarifa']; ?>"><button type="button" class="btn btn-default"><?php echo $row_plantumoto['Tipo']; ?></button></a>
              </div>
              <?php } while ($row_plantumoto = mysql_fetch_assoc($plantumoto)); ?>
            
          
      </div>
</div>    
            
               
               
               
               
               
                
          </div>
            <!-- /.container-fluid -->
      </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
<?php
mysql_free_result($plantucarro);

mysql_free_result($plantuinmueble);

mysql_free_result($plantumoto);
?>
