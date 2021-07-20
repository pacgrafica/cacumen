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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO clientes (Nombre, Identificacion, Direccion, Email, Telefono, Fecha, Factura, Tipocliente, Cantidad, Cantidad2, Cantidad3, Descripcion, Descripcion2, Descripcion3, PrecioUni, PrecipTotal, PrecioUni2, PrecioUni3, PrecioTotal2, PrecioTotal3, Precioletra, SubTotal, Iva, Total, Impreso, Estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Nombre'], "text"),
                       GetSQLValueString($_POST['Identificacion'], "text"),
                       GetSQLValueString($_POST['Direccion'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Telefono'], "text"),
                       GetSQLValueString($_POST['Fecha'], "text"),
                       GetSQLValueString($_POST['Factura'], "text"),
                       GetSQLValueString($_POST['Tipocliente'], "text"),
                       GetSQLValueString($_POST['Cantidad'], "text"),
                       GetSQLValueString($_POST['Cantidad2'], "text"),
                       GetSQLValueString($_POST['Cantidad3'], "text"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString($_POST['Descripcion2'], "text"),
                       GetSQLValueString($_POST['Descripcion3'], "text"),
                       GetSQLValueString($_POST['PrecioUni'], "text"),
                       GetSQLValueString($_POST['PrecipTotal'], "text"),
                       GetSQLValueString($_POST['PrecioUni2'], "text"),
                       GetSQLValueString($_POST['PrecioUni3'], "text"),
                       GetSQLValueString($_POST['PrecioTotal2'], "text"),
                       GetSQLValueString($_POST['PrecioTotal3'], "text"),
                       GetSQLValueString($_POST['Precioletra'], "text"),
                       GetSQLValueString($_POST['SubTotal'], "text"),
                       GetSQLValueString($_POST['Iva'], "text"),
                       GetSQLValueString($_POST['Total'], "text"),
					   GetSQLValueString($_POST['Impreso'], "text"),
					   GetSQLValueString($_POST['Estado'], "text"));

  mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
  $Result1 = mysql_query($insertSQL, $sistemapacgrafica) or die(mysql_error());

  $insertGoTo = "imp_factura.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}



mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_listaultimasfacturas = "SELECT * FROM clientes ORDER BY clientes.Id_cliente DESC";
$listaultimasfacturas = mysql_query($query_listaultimasfacturas, $sistemapacgrafica) or die(mysql_error());
$row_listaultimasfacturas = mysql_fetch_assoc($listaultimasfacturas);
$totalRows_listaultimasfacturas = mysql_num_rows($listaultimasfacturas);

$varcliente_resultadobus = "xxx";
if (isset($_POST["dato"])) {
  $varcliente_resultadobus = $_POST["dato"];
}
mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_resultadobus = sprintf("SELECT * FROM clientes WHERE clientes.Identificacion LIKE %s OR clientes.Nombre LIKE  %s ", GetSQLValueString("%" . $varcliente_resultadobus . "%", "text"),GetSQLValueString("%" . $varcliente_resultadobus . "%", "text"));
$resultadobus = mysql_query($query_resultadobus, $sistemapacgrafica) or die(mysql_error());
$row_resultadobus = mysql_fetch_assoc($resultadobus);
$totalRows_resultadobus = mysql_num_rows($resultadobus);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Nueva Factura</title>

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

<script type="text/javascript">
    function showContent() {
        element = document.getElementById("content");
        check = document.getElementById("check");
        if (check.checked) {
            element.style.display='block';
        }
        else {
            element.style.display='none';
        }
    }
</script>
 

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
                        <h1 class="page-header">Factura Pac Grafica</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
        
  <!-- /.buscador -->
            <div class="panel panel-default">
  <div class="panel-body">
    <form name="buscador" action="" method="post">
    <input id="dato" name="dato" type="text" class="form-control" placeholder="Buscar por Identificación o Nombres">
    <br>
    <input type="submit" class="btn btn-info" id="buscar" name="buscar" value="Buscar">
    </form>
  </div>
</div>
            
<!-- /. fin buscador -->

 
 <!-- /.panel factura-->
 <div class="panel panel-primary">
   <div class="panel-heading">Facturación</div>
   <div class="panel-body">
     <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
<!-- estilo formulario -->
     <div class="row">
  <div class="col-xs-12 col-sm-6 col-md-8">
  
  <input type="text" name="Nombre" value="<?php echo $row_resultadobus['Nombre']; ?>" onKeyUp="this.value=this.value.toUpperCase();" size="32" placeholder="Nombres" class="form-control" required><br>
  <input type="text" name="Identificacion" value="<?php echo $row_resultadobus['Identificacion']; ?>" size="32" placeholder="Identificación" class="form-control" required><br>
  <input type="text" name="Direccion" value="<?php echo $row_resultadobus['Direccion']; ?>" size="32" placeholder="Dirección" class="form-control" required><br>
  <input  type="email" name="Email" value="<?php echo $row_resultadobus['Email']; ?>" size="32" placeholder="E-mail" class="form-control" required><br>
  
  
  </div>
  <div class="col-xs-6 col-md-4">
  
  <input type="text" name="Telefono" value="<?php echo $row_resultadobus['Telefono']; ?>"  size="32" placeholder="Telefono" class="form-control" required><br>
  <input type="date" name="Fecha" value="" size="32" class="form-control" required><br>
  <input type="text" name="Factura" value="" size="32" placeholder="Factura" onKeyUp="this.value=this.value.toUpperCase();" class="form-control" required>
  <strong style="color:#F00;">Ultima Factura Fue: <?php echo $row_listaultimasfacturas['Factura']; ?></strong><br>
  <select name="Tipocliente" value="" class="form-control" required><br>
          <option value="pacgrafica">Pac Grafica</option>
          </select>
  
  </div>
</div>
<div class="row">
  <div class="col-xs-6 col-sm-3">
  
  <textarea name="Descripcion" cols="50" rows="5" class="form-control" placeholder="Descripción" required></textarea>
  
  </div>
  <div class="col-xs-6 col-sm-3">
  
  <input type="text" name="Cantidad" value="" size="32" class="form-control" placeholder="Cantidad" required>
  
  </div>

  <!-- Add the extra clearfix for only the required viewport -->
  <div class="clearfix visible-xs-block"></div>

  <div class="col-xs-6 col-sm-3">
  
  <input type="text" name="PrecioUni" value="" size="32" class="form-control" placeholder="Valor Unitario" required>
  
  </div>
  <div class="col-xs-6 col-sm-3">
  
  <input type="text" name="PrecipTotal" value="" size="32" class="form-control" placeholder="Precio Total" required>
  
  </div>
</div>
<br>
<!-- Boton ocultar y desocultar -->
<b>Mas Productos</b>
<input type="checkbox" name="check" id="check" value="1" onChange="javascript:showContent()" />
<div id="content" style="display: none;">

<!-- fin Boton ocultar y desoculta -->
<div class="row">
  <div class="col-xs-6 col-sm-3">
  
  <textarea name="Descripcion2" cols="50" rows="5" class="form-control" placeholder="Descripción 2do Producto" ></textarea>
  
  </div>
  <div class="col-xs-6 col-sm-3">
  
  <input type="text" name="Cantidad2" value="" size="32" class="form-control" placeholder="Cantidad">
  
  </div>

  <!-- Add the extra clearfix for only the required viewport -->
  <div class="clearfix visible-xs-block"></div>

  <div class="col-xs-6 col-sm-3">
  
  <input type="text" name="PrecioUni2" value="" size="32" class="form-control" placeholder="Valor Unitario">
  
  </div>
  <div class="col-xs-6 col-sm-3">
  
  <input type="text" name="PrecioTotal2" value="" size="32" class="form-control" placeholder="Precio Total">
  
  </div>
</div>

<br>
<div class="row">
  <div class="col-xs-6 col-sm-3">
  
  <textarea name="Descripcion3" cols="50" rows="5" class="form-control" placeholder="Descripción 3 Producto"></textarea>
  
  </div>
  <div class="col-xs-6 col-sm-3">
  
  <input type="text" name="Cantidad3" value="" size="32" class="form-control" placeholder="Cantidad">
  
  </div>

  <!-- Add the extra clearfix for only the required viewport -->
  <div class="clearfix visible-xs-block"></div>

  <div class="col-xs-6 col-sm-3">
  
  <input type="text" name="PrecioUni3" value="" size="32" class="form-control" placeholder="Valor Unitario">
  
  </div>
  <div class="col-xs-6 col-sm-3">
  
  <input type="text" name="PrecioTotal3" value="" size="32" class="form-control" placeholder="Precio Total">
  
  </div>
</div>
  <!-- div donde finaliza el ocultamiento -->
</div>
    <!-- div donde finaliza el ocultamiento -->
<br><br>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-8">
  
  <input type="text" name="Precioletra" value="" size="32" class="form-control" placeholder="Precio Letra" required>
  <input type="hidden" name="Impreso" value="<?php echo $_SESSION['MM_Username']?>" size="32" class="form-control">
  <input type="hidden" name="Estado" value="Activa" size="32" class="form-control">
  </div>
  <div class="col-xs-6 col-md-4">
  
  <input type="text" name="SubTotal" value="" size="32" class="form-control" placeholder="Subtotal" required><br>
  <input type="text" name="Iva" value="" size="32" class="form-control" placeholder="i.v.a" required><br>
  <input type="text" name="Total" value="" size="32" class="form-control" placeholder="Total" required>
  </div>
</div>

<input type="submit" value="Agregar Factura" class="btn btn-info" >
<input type="hidden" name="MM_insert" value="form1">
     </form>
     
     



  <!-- fin estilo formulario -->   
     
<p>&nbsp;</p>
   </div></div>
 <!-- /. Fin panel Resultados-->
 
 
 
 
 



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
mysql_free_result($listaultimasfacturas);

mysql_free_result($resultadobus);
?>
