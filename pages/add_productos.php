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
  $insertSQL = sprintf("INSERT INTO productos (Codigo, Concepto, Descripcion, Precio_Distribuidor, Precio_PacGrafica, Categoria, Imagen, Usuario) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Codigo'], "text"),
                       GetSQLValueString($_POST['Concepto'], "text"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString($_POST['Precio_Distribuidor'], "text"),
                       GetSQLValueString($_POST['Precio_PacGrafica'], "text"),
                       GetSQLValueString($_POST['Categoria'], "text"),
                       GetSQLValueString($_POST['Imagen'], "text"),
					   GetSQLValueString($_POST['Usuario'], "text"));

  mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
  $Result1 = mysql_query($insertSQL, $sistemapacgrafica) or die(mysql_error());

  $insertGoTo = "lista_productos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_ultimocodigo = "SELECT productos.Codigo FROM productos ORDER BY productos.Codigo DESC";
$ultimocodigo = mysql_query($query_ultimocodigo, $sistemapacgrafica) or die(mysql_error());
$row_ultimocodigo = mysql_fetch_assoc($ultimocodigo);
$totalRows_ultimocodigo = mysql_num_rows($ultimocodigo);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cacumen - Agregar  Productos</title>

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






    <script>
function subirimagen(nombrecampo)
{

self.name = 'opener';
remote = open('gestionimagenproducto.php?campo='+nombrecampo, 'remote',
'width=400,height=150,location=no,scrollbars=yes,menubars=no,toolbars=no,resizable=yes,fullscren=no, status=yes');

remote.focus();


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
                        <h1 class="page-header">Agregar Producto</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                
   
   
              <div class="panel panel-primary">
   <div class="panel-heading">Agregar Produto</div>
   <div class="panel-body">
   
   
                <div class="row">
                <div class="col-md-8">
                  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                  
                    
                  <input type="text" name="Concepto" value="" size="32" placeholder="Concepto" class="form-control" required>
                     <br>
                    <textarea name="Descripcion" cols="50" rows="5" placeholder="Descripción" class="form-control"></textarea>
                       <br>
                       <input type="text" name="Imagen" value="" size="32" placeholder="img" class="form-control" required>
                      <input type="button" name="button" id="button"  class="btn btn-success" value="Seleccionar Imagen" onClick="javascript:subirimagen('Imagen');">
                      <strong style="color:#FB0000">(Tamaño Pixeles: 500x500 / Peso <= 30 KB)</strong>
                      <input type="hidden" name="Usuario" value="<?php echo $_SESSION['MM_Username']?>" size="32"  class="form-control">
                      
                  <p>&nbsp;</p>
                </div>
                <div class="col-md-4">
                <input type="text" name="Codigo" value="" size="32" placeholder="Codigo" class="form-control" required>
               <strong style="color:#F00;"> El Ultimo Codigo Fue: <?php echo $row_ultimocodigo['Codigo']; ?></strong>
                  <br>
                <input type="text" name="Precio_Distribuidor" value="" size="32" placeholder="Precio Distribuidor" class="form-control" required>
                  <br>
                     <input type="text" name="Precio_PacGrafica" value="" size="32" placeholder="Precio Pac Grafica" class="form-control" required>
                       <br>
                   
                  <select name="Categoria" class="form-control">
                  <option value="">Seleccione la Categoria</option>
                  <option value="Impresiones">Impresiones</option>
                  <option value="Carnetización">Carnetización</option>
                  <option value="Sellos">Sellos</option>
                  <option value="Material pop">Material pop</option>
                  <option value="Desarrollo Web">Desarrollo Web</option>
                  <option value="Dotaciones">Dotaciones</option>
                  <option value="Señalización">Señalización</option>
                  <option value="Avisos Led">Avisos Led</option>
                  <option value="Estampados">Estampados</option>
                  <option value="Tecnologia">Tecnologia</option>
                  <option value="Otros">Otros</option>
                  </select>
                  
                
                
                
                </div>
                </div>
   
   
                  <input type="submit" value="Agregar Producto" class="btn btn-info">
                  <input type="hidden" name="MM_insert" value="form1">
                  </form>
   
   
   </div></div>
   
   
   
                
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
mysql_free_result($ultimocodigo);
?>
