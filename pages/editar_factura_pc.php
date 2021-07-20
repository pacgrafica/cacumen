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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE clientes SET Nombre=%s, Identificacion=%s, Direccion=%s, Email=%s, Telefono=%s, Fecha=%s, Factura=%s, Tipocliente=%s, Cantidad=%s, Cantidad2=%s, Cantidad3=%s, Descripcion=%s, Descripcion2=%s, Descripcion3=%s, PrecioUni=%s, PrecipTotal=%s, PrecioUni2=%s, PrecioUni3=%s, PrecioTotal2=%s, PrecioTotal3=%s, Precioletra=%s, SubTotal=%s, Iva=%s, Total=%s WHERE Id_cliente=%s",
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
                       GetSQLValueString($_POST['Id_cliente'], "int"));

  mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
  $Result1 = mysql_query($updateSQL, $sistemapacgrafica) or die(mysql_error());

  $updateGoTo = "imp_factura_ copia.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varfactura_editarfactura = "0";
if (isset($_GET["recordID"])) {
  $varfactura_editarfactura = $_GET["recordID"];
}
mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_editarfactura = sprintf("SELECT * FROM clientes WHERE clientes.Id_cliente = %s", GetSQLValueString($varfactura_editarfactura, "text"));
$editarfactura = mysql_query($query_editarfactura, $sistemapacgrafica) or die(mysql_error());
$row_editarfactura = mysql_fetch_assoc($editarfactura);
$totalRows_editarfactura = mysql_num_rows($editarfactura);

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

$varfactura_editarfactura = "0";
if (isset($_GET["recordID"])) {
  $varfactura_editarfactura = $_GET["recordID"];
}
mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_editarfactura = sprintf("SELECT * FROM clientes WHERE clientes.Id_cliente = %s", GetSQLValueString($varfactura_editarfactura, "int"));
$editarfactura = mysql_query($query_editarfactura, $sistemapacgrafica) or die(mysql_error());
$row_editarfactura = mysql_fetch_assoc($editarfactura);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Editar Factura - Imprimir</title>

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
                        <h1 class="page-header">Editar Factura - Imprimir</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    
                </div>
                <!-- /.row -->
                
                   <!-- /.panel factura-->
 <div class="panel panel-primary">
   <div class="panel-heading">Facturación</div>
   <div class="panel-body">
     <form method="post" name="form2" action="<?php echo $editFormAction; ?>">
<!-- estilo formulario -->
     <div class="row">
  <div class="col-xs-12 col-sm-6 col-md-8">
  
  <input type="text" name="Nombre" value="<?php echo htmlentities($row_editarfactura['Nombre'], ENT_COMPAT, 'utf-8'); ?>" size="32" placeholder="Nombres" class="form-control" required><br>
  <input type="text" name="Identificacion" value="<?php echo htmlentities($row_editarfactura['Identificacion'], ENT_COMPAT, 'utf-8'); ?>" size="32" placeholder="Identificación" class="form-control" required><br>
  <input type="text" name="Direccion" value="<?php echo htmlentities($row_editarfactura['Direccion'], ENT_COMPAT, 'utf-8'); ?>" size="32" placeholder="Dirección" class="form-control" required><br>
  <input  type="email" name="Email" value="<?php echo htmlentities($row_editarfactura['Email'], ENT_COMPAT, 'utf-8'); ?>" size="32" placeholder="E-mail" class="form-control" required><br>
  
  
  </div>
  <div class="col-xs-6 col-md-4">
  
  <input type="text" name="Telefono" value="<?php echo htmlentities($row_editarfactura['Telefono'], ENT_COMPAT, 'utf-8'); ?>" size="32" placeholder="Telefono" class="form-control" required><br>
  <input type="date" name="Fecha" value="<?php echo htmlentities($row_editarfactura['Fecha'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" required><br>
  <input type="text" name="Factura" value="<?php echo htmlentities($row_editarfactura['Factura'], ENT_COMPAT, 'utf-8'); ?>" size="32" placeholder="Factura" class="form-control" required><br>
  <select name="Tipocliente" value="" class="form-control" required><br>
    <option value="" <?php if (!(strcmp("", $row_editarfactura['Tipocliente']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
    <option value="mercadolibre" <?php if (!(strcmp("mercadolibre", $row_editarfactura['Tipocliente']))) {echo "selected=\"selected\"";} ?>>Mercado Libre</option>
    <option value="pacgrafica" <?php if (!(strcmp("pacgrafica", $row_editarfactura['Tipocliente']))) {echo "selected=\"selected\"";} ?>>Pac Grafica</option>
          </select>
  
  </div>
</div>
<div class="row">
  <div class="col-xs-6 col-sm-3">
  
  <textarea name="Descripcion" cols="50" rows="5" class="form-control" placeholder="Descripción" required><?php echo htmlentities($row_editarfactura['Descripcion'], ENT_COMPAT, 'utf-8'); ?> </textarea>
  
  </div>
  <div class="col-xs-6 col-sm-3">
  
  <input type="text" name="Cantidad" value="<?php echo htmlentities($row_editarfactura['Cantidad'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" placeholder="Cantidad" required readonly>
  
  </div>

  <!-- Add the extra clearfix for only the required viewport -->
  <div class="clearfix visible-xs-block"></div>

  <div class="col-xs-6 col-sm-3">
  
  <input type="text" name="PrecioUni" value="<?php echo htmlentities($row_editarfactura['PrecioUni'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" placeholder="Valor Unitario" required readonly>
  
  </div>
  <div class="col-xs-6 col-sm-3">
  
  <input type="text" name="PrecipTotal" value="<?php echo htmlentities($row_editarfactura['PrecipTotal'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" placeholder="Precio Total" required readonly>
  
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
  
  <textarea name="Descripcion2" cols="50" rows="5" class="form-control" placeholder="Descripción 2do Producto"><?php echo htmlentities($row_editarfactura['Descripcion2'], ENT_COMPAT, 'utf-8'); ?></textarea>
  
  </div>
  <div class="col-xs-6 col-sm-3">
  
  <input type="text" name="Cantidad2" value="<?php echo htmlentities($row_editarfactura['Cantidad2'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" placeholder="Cantidad" readonly>
  
  </div>

  <!-- Add the extra clearfix for only the required viewport -->
  <div class="clearfix visible-xs-block"></div>

  <div class="col-xs-6 col-sm-3">
  
  <input type="text" name="PrecioUni2" value="<?php echo htmlentities($row_editarfactura['PrecioUni2'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" placeholder="Valor Unitario" readonly>
  
  </div>
  <div class="col-xs-6 col-sm-3">
  
  <input type="text" name="PrecioTotal2" value="<?php echo htmlentities($row_editarfactura['PrecioTotal2'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" placeholder="Precio Total" readonly>
  
  </div>
</div>

<br>
<div class="row">
  <div class="col-xs-6 col-sm-3">
  
  <textarea name="Descripcion3" cols="50" rows="5" class="form-control" placeholder="Descripción 3 Producto"><?php echo htmlentities($row_editarfactura['Descripcion3'], ENT_COMPAT, 'utf-8'); ?></textarea>
  
  </div>
  <div class="col-xs-6 col-sm-3">
  
  <input type="text" name="Cantidad3" value="<?php echo htmlentities($row_editarfactura['Cantidad3'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" placeholder="Cantidad" readonly>
  
  </div>

  <!-- Add the extra clearfix for only the required viewport -->
  <div class="clearfix visible-xs-block"></div>

  <div class="col-xs-6 col-sm-3">
  
  <input type="text" name="PrecioUni3" value="<?php echo htmlentities($row_editarfactura['PrecioUni3'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" placeholder="Valor Unitario" readonly>
  
  </div>
  <div class="col-xs-6 col-sm-3">
  
  <input type="text" name="PrecioTotal3" value="<?php echo htmlentities($row_editarfactura['PrecioTotal3'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" placeholder="Precio Total" readonly>
  
  </div>
</div>
  <!-- div donde finaliza el ocultamiento -->
</div>
    <!-- div donde finaliza el ocultamiento -->
<br><br>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-8">
  
  <input type="text" name="Precioletra" value="<?php echo htmlentities($row_editarfactura['Precioletra'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" placeholder="Precio Letra" required readonly>
  
  </div>
  <div class="col-xs-6 col-md-4">
  
  <input type="text" name="SubTotal" value="<?php echo htmlentities($row_editarfactura['SubTotal'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" placeholder="Subtotal" required readonly><br>
  <input type="text" name="Iva" value="<?php echo htmlentities($row_editarfactura['Iva'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" placeholder="i.v.a" required readonly><br>
  <input type="text" name="Total" value="<?php echo htmlentities($row_editarfactura['Total'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" placeholder="Total" required readonly>
  </div>
</div>
<input type="submit" value="Guardar Cambios e Imprimir" class="btn btn-info">
<input type="hidden" name="MM_update" value="form2">
       <input type="hidden" name="Id_cliente" value="<?php echo $row_editarfactura['Id_cliente']; ?>">
       <button type="button" class="btn btn-danger" onclick="history.back()">Volver</button>
     </form>
     
        
    
<!-- fin estilo formulario -->   
                  
                 
               

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
mysql_free_result($editarfactura);
?>
