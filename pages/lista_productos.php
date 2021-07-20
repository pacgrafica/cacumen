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

$maxRows_listaproductos = 6;
$pageNum_listaproductos = 0;
if (isset($_GET['pageNum_listaproductos'])) {
  $pageNum_listaproductos = $_GET['pageNum_listaproductos'];
}
$startRow_listaproductos = $pageNum_listaproductos * $maxRows_listaproductos;

mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_listaproductos = "SELECT * FROM productos ORDER BY productos.Id_producto DESC";
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

    <title>Lista Productos - Cacumen</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../dist/css/otros.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

	
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
                        <h1 class="page-header">Lista de Productos</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                
                 <div class="col-lg-6">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Ingrese el Codigo...">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button">Buscar</button>
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<br>
<table border="0">
      <tr>
        <td><?php if ($pageNum_listaproductos > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_listaproductos=%d%s", $currentPage, 0, $queryString_listaproductos); ?>" class="btn btn-default">Primero</a>
            <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_listaproductos > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_listaproductos=%d%s", $currentPage, max(0, $pageNum_listaproductos - 1), $queryString_listaproductos); ?>" class="btn btn-default">Anterior</a>
            <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_listaproductos < $totalPages_listaproductos) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_listaproductos=%d%s", $currentPage, min($totalPages_listaproductos, $pageNum_listaproductos + 1), $queryString_listaproductos); ?>" class="btn btn-default">Siguiente</a>
            <?php } // Show if not last page ?></td>
        <td><?php if ($pageNum_listaproductos < $totalPages_listaproductos) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_listaproductos=%d%s", $currentPage, $totalPages_listaproductos, $queryString_listaproductos); ?>" class="btn btn-default">&Uacute;ltimo</a>
            <?php } // Show if not last page ?></td>
      </tr>
    </table>

<hr>


  
    <div class="row">
    <?php do { ?>
      <div class="col-md-4">
        <div class="thumbnail">
        
        <img src="../images/productos/<?php echo $row_listaproductos['Imagen']; ?>" alt="..." width="300" height="300" >
        
        <div align="center">
        <strong style="color:#00F;">Codigo: <?php echo $row_listaproductos['Codigo']; ?></strong>
        
        <div class="panel">
          <a href="#login_form?recordID=<?php echo $row_listaproductos['Id_producto']; ?>" class="btn btn-primary" role="button" >Ver</a>
          </div> 
          
         </div> 
        
        <!--- pop up  con la informacion-->
        <a href="#x" class="overlay" id="login_form?recordID=<?php echo $row_listaproductos['Id_producto']; ?>"></a>
        <div class="popup">
          
		  
          
          <img src="../images/productos/<?php echo $row_listaproductos['Imagen']; ?>" width="300">
          <br> <br>
          Nombre: <br><?php echo $row_listaproductos['Concepto']; ?> <br><br>
          Codigo: <br><?php echo $row_listaproductos['Codigo']; ?> <br><br>
          Descripción: <br><?php echo $row_listaproductos['Descripcion']; ?> <br><br>
          Precio Distribuidor: <br><?php echo $row_listaproductos['Precio_Distribuidor']; ?> <br><br>
          Precio PacGrafica: <br><?php echo $row_listaproductos['Precio_PacGrafica']; ?> <br><br>
          Categoria: <br><?php echo $row_listaproductos['Categoria']; ?> <br><br>
          
          <a class="close" href="#close"></a>
          </div>
            </div>
        </div>
      <!--- Fin pop up  con la informacion-->
     
       <?php } while ($row_listaproductos = mysql_fetch_assoc($listaproductos)); ?>
    </div>
   
   

 
    
       
    

      
      
    
    
    
<!-- /.row -->
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
mysql_free_result($listaproductos);
?>
