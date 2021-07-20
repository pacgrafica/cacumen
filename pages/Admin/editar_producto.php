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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE productos SET Codigo=%s, Concepto=%s, Descripcion=%s, Precio_Distribuidor=%s, Precio_PacGrafica=%s, Categoria=%s, Imagen=%s, Usuario=%s WHERE Id_producto=%s",
                       GetSQLValueString($_POST['Codigo'], "text"),
                       GetSQLValueString($_POST['Concepto'], "text"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString($_POST['Precio_Distribuidor'], "text"),
                       GetSQLValueString($_POST['Precio_PacGrafica'], "text"),
                       GetSQLValueString($_POST['Categoria'], "text"),
                       GetSQLValueString($_POST['Imagen'], "text"),
                       GetSQLValueString($_POST['Usuario'], "text"),
                       GetSQLValueString($_POST['Id_producto'], "int"));

  mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
  $Result1 = mysql_query($updateSQL, $sistemapacgrafica) or die(mysql_error());

  $updateGoTo = "producto.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varproducto_editarproducto = "0";
if (isset($_GET["recordID"])) {
  $varproducto_editarproducto = $_GET["recordID"];
}
mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_editarproducto = sprintf("SELECT * FROM productos WHERE productos.Id_producto = %s", GetSQLValueString($varproducto_editarproducto, "text"));
$editarproducto = mysql_query($query_editarproducto, $sistemapacgrafica) or die(mysql_error());
$row_editarproducto = mysql_fetch_assoc($editarproducto);
$totalRows_editarproducto = mysql_num_rows($editarproducto);
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
                        <h1 class="page-header">Editar Producto</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                      <table align="center">
                        <tr valign="baseline">
                          <td nowrap align="right">Codigo:</td>
                          <td><input type="text" name="Codigo" value="<?php echo htmlentities($row_editarproducto['Codigo'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Concepto:</td>
                          <td><input type="text" name="Concepto" value="<?php echo htmlentities($row_editarproducto['Concepto'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right" valign="top">Descripcion:</td>
                          <td><textarea name="Descripcion" cols="50" rows="5"><?php echo htmlentities($row_editarproducto['Descripcion'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Precio_Distribuidor:</td>
                          <td><input type="text" name="Precio_Distribuidor" value="<?php echo htmlentities($row_editarproducto['Precio_Distribuidor'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Precio_PacGrafica:</td>
                          <td><input type="text" name="Precio_PacGrafica" value="<?php echo htmlentities($row_editarproducto['Precio_PacGrafica'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Categoria:</td>
                          <td><input type="text" name="Categoria" value="<?php echo htmlentities($row_editarproducto['Categoria'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Imagen:</td>
                          <td><input type="text" name="Imagen" value="<?php echo htmlentities($row_editarproducto['Imagen'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Usuario:</td>
                          <td><input type="text" name="Usuario" value="<?php echo htmlentities($row_editarproducto['Usuario'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">&nbsp;</td>
                          <td><input type="submit" value="Actualizar registro"></td>
                        </tr>
                      </table>
                      <input type="hidden" name="MM_update" value="form1">
                      <input type="hidden" name="Id_producto" value="<?php echo $row_editarproducto['Id_producto']; ?>">
                    </form>
                    <p>&nbsp;</p>
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
mysql_free_result($editarproducto);
?>
