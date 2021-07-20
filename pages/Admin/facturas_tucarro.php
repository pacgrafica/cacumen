<?php require_once('../../Connections/sistemapacgrafica.php'); ?>
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

$maxRows_facturastucarro = 12;
$pageNum_facturastucarro = 0;
if (isset($_GET['pageNum_facturastucarro'])) {
  $pageNum_facturastucarro = $_GET['pageNum_facturastucarro'];
}
$startRow_facturastucarro = $pageNum_facturastucarro * $maxRows_facturastucarro;

mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_facturastucarro = "SELECT * FROM clientes WHERE clientes.Tipocliente = 'mercadolibre' ORDER BY clientes.Id_cliente DESC";
$query_limit_facturastucarro = sprintf("%s LIMIT %d, %d", $query_facturastucarro, $startRow_facturastucarro, $maxRows_facturastucarro);
$facturastucarro = mysql_query($query_limit_facturastucarro, $sistemapacgrafica) or die(mysql_error());
$row_facturastucarro = mysql_fetch_assoc($facturastucarro);

if (isset($_GET['totalRows_facturastucarro'])) {
  $totalRows_facturastucarro = $_GET['totalRows_facturastucarro'];
} else {
  $all_facturastucarro = mysql_query($query_facturastucarro);
  $totalRows_facturastucarro = mysql_num_rows($all_facturastucarro);
}
$totalPages_facturastucarro = ceil($totalRows_facturastucarro/$maxRows_facturastucarro)-1;

$queryString_facturastucarro = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_facturastucarro") == false && 
        stristr($param, "totalRows_facturastucarro") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_facturastucarro = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_facturastucarro = sprintf("&totalRows_facturastucarro=%d%s", $totalRows_facturastucarro, $queryString_facturastucarro);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Facturas Mercado Libre</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
       <?php include("menuadmin.php"); ?>
       
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Facturas de Mercado Libre</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row --> 
                Total Facturas: <?php echo $totalRows_facturastucarro ?><br><br>
      
               
                <?php do { ?>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-yellow">
                      <div class="panel-heading">
                        <div class="row">
                          <div class="col-xs-3"> <i class="fa fa-file fa-5x"></i> </div>
                          <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $row_facturastucarro['Factura']; ?></div>
                            <div><?php echo $row_facturastucarro['Nombre']; ?></div>
                            <div><?php echo $row_facturastucarro['Fecha']; ?></div>
                            <div>Estado: <strong style=" text-transform:uppercase;"><?php echo $row_facturastucarro['Estado']; ?></strong></div>
                          </div>
                        </div>
                      </div>
                      <a href="detalles_factura_ml.php?recordID=<?php echo $row_facturastucarro['Id_cliente']; ?>">
                        <div class="panel-footer"> <span class="pull-left">Ver Detalles</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                          <div class="clearfix"></div>
                        </div>
                      </a> </div>
                  </div>
                  <?php } while ($row_facturastucarro = mysql_fetch_assoc($facturastucarro)); ?>
                  <br><br>
                  <table border="0">
                    <tr>
                      <td><?php if ($pageNum_facturastucarro > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_facturastucarro=%d%s", $currentPage, 0, $queryString_facturastucarro); ?>">Primero</a>
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_facturastucarro > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_facturastucarro=%d%s", $currentPage, max(0, $pageNum_facturastucarro - 1), $queryString_facturastucarro); ?>">Anterior</a>
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_facturastucarro < $totalPages_facturastucarro) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_facturastucarro=%d%s", $currentPage, min($totalPages_facturastucarro, $pageNum_facturastucarro + 1), $queryString_facturastucarro); ?>">Siguiente</a>
                          <?php } // Show if not last page ?></td>
                      <td><?php if ($pageNum_facturastucarro < $totalPages_facturastucarro) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_facturastucarro=%d%s", $currentPage, $totalPages_facturastucarro, $queryString_facturastucarro); ?>">&Uacute;ltimo</a>
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
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>

</body>

</html>
<?php
mysql_free_result($facturastucarro);
?>
