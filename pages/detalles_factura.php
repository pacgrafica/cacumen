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

$vardetalle_detallesfactura = "0";
if (isset($_GET["recordID"])) {
  $vardetalle_detallesfactura = $_GET["recordID"];
}
mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_detallesfactura = sprintf("SELECT * FROM clientes WHERE clientes.Id_cliente = %s", GetSQLValueString($vardetalle_detallesfactura, "int"));
$detallesfactura = mysql_query($query_detallesfactura, $sistemapacgrafica) or die(mysql_error());
$row_detallesfactura = mysql_fetch_assoc($detallesfactura);
$totalRows_detallesfactura = mysql_num_rows($detallesfactura);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Detalles Factura</title>

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
                        <h1 class="page-header">Detalles de la Factura: <?php echo $row_detallesfactura['Factura']; ?></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                
                
           <li class="list-group-item list-group-item-info">
           <strong>Nombre:</strong> <?php echo $row_detallesfactura['Nombre']; ?><br>
           <strong>Identificaión:</strong> <?php echo $row_detallesfactura['Identificacion']; ?><br>
           <strong>Dirección:</strong> <?php echo $row_detallesfactura['Direccion']; ?><br><br>
           <strong>E-mail:</strong> <?php echo $row_detallesfactura['Email']; ?><br>
           <strong>Telefono:</strong> <?php echo $row_detallesfactura['Telefono']; ?><br>
           <strong>Fecha:</strong> <?php echo $row_detallesfactura['Fecha']; ?><br><br>
           <strong>Tipo Cliente:</strong> <?php echo $row_detallesfactura['Tipocliente']; ?><br>
           <strong>Productos:</strong><br><br>
           <?php echo $row_detallesfactura['Cantidad']; ?> <?php echo $row_detallesfactura['Descripcion']; ?><br>
           <?php echo $row_detallesfactura['Cantidad2']; ?> <?php echo $row_detallesfactura['Descripcion2']; ?><br>
           <?php echo $row_detallesfactura['Cantidad3']; ?> <?php echo $row_detallesfactura['Descripcion3']; ?><br><br><br>
           <strong>Precio Letra:</strong>  <?php echo $row_detallesfactura['Precioletra']; ?><br><br>
           <strong>SubTotal:</strong> <?php echo $row_detallesfactura['SubTotal']; ?><br>
           <strong>I.V.A:</strong> <?php echo $row_detallesfactura['Iva']; ?><br>
           <strong>Total:</strong> <?php echo $row_detallesfactura['Total']; ?><br><br>
           
           <strong>Impreso por:</strong> <?php echo $row_detallesfactura['Impreso']; ?><br><br>
           
           <a href="editar_factura_pc.php?recordID=<?php echo $row_detallesfactura['Id_cliente']; ?>">
           <button type="button" class="btn btn-primary">Editar e Imprimir</button>
           </a>
<button type="button" class="btn btn-danger" onclick="history.back()">Volver</button>
           </li>
                
                
                
                
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
mysql_free_result($detallesfactura);
?>
