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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_facturaspacgrafica = 20;
$pageNum_facturaspacgrafica = 0;
if (isset($_GET['pageNum_facturaspacgrafica'])) {
  $pageNum_facturaspacgrafica = $_GET['pageNum_facturaspacgrafica'];
}
$startRow_facturaspacgrafica = $pageNum_facturaspacgrafica * $maxRows_facturaspacgrafica;

mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_facturaspacgrafica = "SELECT * FROM clientes WHERE clientes.Tipocliente =  'pacgrafica'";
$query_limit_facturaspacgrafica = sprintf("%s LIMIT %d, %d", $query_facturaspacgrafica, $startRow_facturaspacgrafica, $maxRows_facturaspacgrafica);
$facturaspacgrafica = mysql_query($query_limit_facturaspacgrafica, $sistemapacgrafica) or die(mysql_error());
$row_facturaspacgrafica = mysql_fetch_assoc($facturaspacgrafica);

if (isset($_GET['totalRows_facturaspacgrafica'])) {
  $totalRows_facturaspacgrafica = $_GET['totalRows_facturaspacgrafica'];
} else {
  $all_facturaspacgrafica = mysql_query($query_facturaspacgrafica);
  $totalRows_facturaspacgrafica = mysql_num_rows($all_facturaspacgrafica);
}
$totalPages_facturaspacgrafica = ceil($totalRows_facturaspacgrafica/$maxRows_facturaspacgrafica)-1;$maxRows_facturaspacgrafica = 10;
$pageNum_facturaspacgrafica = 0;
if (isset($_GET['pageNum_facturaspacgrafica'])) {
  $pageNum_facturaspacgrafica = $_GET['pageNum_facturaspacgrafica'];
}
$startRow_facturaspacgrafica = $pageNum_facturaspacgrafica * $maxRows_facturaspacgrafica;

mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_facturaspacgrafica = "SELECT * FROM clientes WHERE clientes.Tipocliente =  'pacgrafica' ORDER BY clientes.Id_cliente DESC";
$query_limit_facturaspacgrafica = sprintf("%s LIMIT %d, %d", $query_facturaspacgrafica, $startRow_facturaspacgrafica, $maxRows_facturaspacgrafica);
$facturaspacgrafica = mysql_query($query_limit_facturaspacgrafica, $sistemapacgrafica) or die(mysql_error());
$row_facturaspacgrafica = mysql_fetch_assoc($facturaspacgrafica);

if (isset($_GET['totalRows_facturaspacgrafica'])) {
  $totalRows_facturaspacgrafica = $_GET['totalRows_facturaspacgrafica'];
} else {
  $all_facturaspacgrafica = mysql_query($query_facturaspacgrafica);
  $totalRows_facturaspacgrafica = mysql_num_rows($all_facturaspacgrafica);
}
$totalPages_facturaspacgrafica = ceil($totalRows_facturaspacgrafica/$maxRows_facturaspacgrafica)-1;

$queryString_facturaspacgrafica = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_facturaspacgrafica") == false && 
        stristr($param, "totalRows_facturaspacgrafica") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_facturaspacgrafica = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_facturaspacgrafica = sprintf("&totalRows_facturaspacgrafica=%d%s", $totalRows_facturaspacgrafica, $queryString_facturaspacgrafica);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Facturas Pac Grafica</title>

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
    <![endif]-->

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
                        <h1 class="page-header">Facturas Pac Grafica</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row --> 
                Total Facturas: <?php echo $totalRows_facturaspacgrafica ?><br><br>
                
                <?php do { ?>
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                        <div class="row">
                          <div class="col-xs-3">
                            <i class="fa fa-file fa-5x"></i>
                            </div>
                          <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $row_facturaspacgrafica['Factura']; ?></div>
                            <div><?php echo $row_facturaspacgrafica['Nombre']; ?></div>
                            <div><?php echo $row_facturaspacgrafica['Fecha']; ?></div>
                             <div>Estado: <strong style=" text-transform:uppercase;"><?php echo $row_facturaspacgrafica['Estado']; ?></strong></div>
                            </div>
                          </div>
                        </div>
                      <a href="detalles_factura.php?recordID=<?php echo $row_facturaspacgrafica['Id_cliente']; ?>">
                        <div class="panel-footer">
                          <span class="pull-left">Ver Detalles</span>
                          <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                          <div class="clearfix"></div>
                          </div>
                      </a>
                      </div>
                  </div>
                  <?php } while ($row_facturaspacgrafica = mysql_fetch_assoc($facturaspacgrafica)); ?>
                  <table border="0">
                    <tr>
                      <td><?php if ($pageNum_facturaspacgrafica > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_facturaspacgrafica=%d%s", $currentPage, 0, $queryString_facturaspacgrafica); ?>" class="btn btn-default">Primero</a>
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_facturaspacgrafica > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_facturaspacgrafica=%d%s", $currentPage, max(0, $pageNum_facturaspacgrafica - 1), $queryString_facturaspacgrafica); ?>" class="btn btn-default">Anterior</a>
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_facturaspacgrafica < $totalPages_facturaspacgrafica) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_facturaspacgrafica=%d%s", $currentPage, min($totalPages_facturaspacgrafica, $pageNum_facturaspacgrafica + 1), $queryString_facturaspacgrafica); ?>" class="btn btn-default">Siguiente</a>
                          <?php } // Show if not last page ?></td>
                      <td><?php if ($pageNum_facturaspacgrafica < $totalPages_facturaspacgrafica) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_facturaspacgrafica=%d%s", $currentPage, $totalPages_facturaspacgrafica, $queryString_facturaspacgrafica); ?>" class="btn btn-default">&Uacute;ltimo</a>
                          <?php } // Show if not last page ?></td>
                    </tr>
                  </table>
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
mysql_free_result($facturaspacgrafica);
?>
