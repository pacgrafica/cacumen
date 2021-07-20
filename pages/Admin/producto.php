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

$maxRows_listaproductos = 20;
$pageNum_listaproductos = 0;
if (isset($_GET['pageNum_listaproductos'])) {
  $pageNum_listaproductos = $_GET['pageNum_listaproductos'];
}
$startRow_listaproductos = $pageNum_listaproductos * $maxRows_listaproductos;

mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_listaproductos = "SELECT * FROM productos ORDER BY productos.Id_producto ASC";
$query_limit_listaproductos = sprintf("%s LIMIT %d, %d", $query_listaproductos, $startRow_listaproductos, $maxRows_listaproductos);
$listaproductos = mysql_query($query_limit_listaproductos, $sistemapacgrafica) or die(mysql_error());
$row_listaproductos = mysql_fetch_assoc($listaproductos);

if (isset($_GET['totalRows_listaproductos'])) {
  $totalRows_listaproductos = $_GET['totalRows_listaproductos'];
} else {
  $all_listaproductos = mysql_query($query_listaproductos);
  $totalRows_listaproductos = mysql_num_rows($all_listaproductos);
}
$totalPages_listaproductos = ceil($totalRows_listaproductos/$maxRows_listaproductos)-1;

$queryString_listaproductos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_listaproductos") == false && 
        stristr($param, "totalRows_listaproductos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_listaproductos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_listaproductos = sprintf("&totalRows_listaproductos=%d%s", $totalRows_listaproductos, $queryString_listaproductos);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administración - Cacumen</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

 
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
                        <h1 class="page-header">Productos</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    
                    
                  <?php do { ?>
                  <div class="row">
                      <div class="col-md-4"><?php echo $row_listaproductos['Codigo']; ?></div>
                      <div class="col-md-4"><?php echo $row_listaproductos['Concepto']; ?></div>
                      <div class="col-md-4"><a class="btn btn-success" href="editar_producto.php?recordID=<?php echo $row_listaproductos['Id_producto']; ?>">Editar</a></div>
                     
  </div>
                      <?php } while ($row_listaproductos = mysql_fetch_assoc($listaproductos)); ?>
                      <table border="0">
                        <tr>
                          <td><?php if ($pageNum_listaproductos > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_listaproductos=%d%s", $currentPage, 0, $queryString_listaproductos); ?>">Primero</a>
                              <?php } // Show if not first page ?></td>
                          <td><?php if ($pageNum_listaproductos > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_listaproductos=%d%s", $currentPage, max(0, $pageNum_listaproductos - 1), $queryString_listaproductos); ?>">Anterior</a>
                              <?php } // Show if not first page ?></td>
                          <td><?php if ($pageNum_listaproductos < $totalPages_listaproductos) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_listaproductos=%d%s", $currentPage, min($totalPages_listaproductos, $pageNum_listaproductos + 1), $queryString_listaproductos); ?>">Siguiente</a>
                              <?php } // Show if not last page ?></td>
                          <td><?php if ($pageNum_listaproductos < $totalPages_listaproductos) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_listaproductos=%d%s", $currentPage, $totalPages_listaproductos, $queryString_listaproductos); ?>">&Uacute;ltimo</a>
                              <?php } // Show if not last page ?></td>
                        </tr>
                      </table>
                </div>
                <!-- /.row -->
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
mysql_free_result($listaproductos);

?>
