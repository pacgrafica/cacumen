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
  $insertSQL = sprintf("INSERT INTO tareas (Nombre_tarea, Nombre_Cliente, Email_cliente, Telefono_cliente, Total_cobrado, Total_Adelanto, debe, Fecha_llegada, Fecha_Entrega, Usuario_tarea, Estado_tarea, Observaciones_tarea, Usuario_modifico, Asignacion, cant1, Descripcion_tarea1, preciounitario1, preciototal1, cant2, Descripcion_tarea2, preciounitario2, preciototal2, cant3, Descripcion_tarea3, preciounitario3, preciototal3, cant4, preciounitario4, preciototal4, Descripcion_tarea4, cant5, preciounitario5, preciototal5, Descripcion_tarea5, categoria, artesuministrado, formatoarte) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Nombre_tarea'], "text"),
                       GetSQLValueString($_POST['Nombre_Cliente'], "text"),
                       GetSQLValueString($_POST['Email_cliente'], "text"),
                       GetSQLValueString($_POST['Telefono_cliente'], "text"),
                       GetSQLValueString($_POST['Total_cobrado'], "text"),
                       GetSQLValueString($_POST['Total_Adelanto'], "text"),
                       GetSQLValueString($_POST['debe'], "text"),
                       GetSQLValueString($_POST['Fecha_llegada'], "text"),
                       GetSQLValueString($_POST['Fecha_Entrega'], "text"),
                       GetSQLValueString($_POST['Usuario_tarea'], "text"),
                       GetSQLValueString($_POST['Estado_tarea'], "text"),
                       GetSQLValueString($_POST['Observaciones_tarea'], "text"),
                       GetSQLValueString($_POST['Usuario_modifico'], "text"),
                       GetSQLValueString($_POST['Asignacion'], "text"),
                       GetSQLValueString($_POST['cant1'], "text"),
                       GetSQLValueString($_POST['Descripcion_tarea1'], "text"),
                       GetSQLValueString($_POST['preciounitario1'], "text"),
                       GetSQLValueString($_POST['preciototal1'], "text"),
                       GetSQLValueString($_POST['cant2'], "text"),
                       GetSQLValueString($_POST['Descripcion_tarea2'], "text"),
                       GetSQLValueString($_POST['preciounitario2'], "text"),
                       GetSQLValueString($_POST['preciototal2'], "text"),
                       GetSQLValueString($_POST['cant3'], "text"),
                       GetSQLValueString($_POST['Descripcion_tarea3'], "text"),
                       GetSQLValueString($_POST['preciounitario3'], "text"),
                       GetSQLValueString($_POST['preciototal3'], "text"),
                       GetSQLValueString($_POST['cant4'], "text"),
                       GetSQLValueString($_POST['preciounitario4'], "text"),
                       GetSQLValueString($_POST['preciototal4'], "text"),
                       GetSQLValueString($_POST['Descripcion_tarea4'], "text"),
                       GetSQLValueString($_POST['cant5'], "text"),
                       GetSQLValueString($_POST['preciounitario5'], "text"),
                       GetSQLValueString($_POST['preciototal5'], "text"),
                       GetSQLValueString($_POST['Descripcion_tarea5'], "text"),
                       GetSQLValueString($_POST['categoria'], "text"),
                       GetSQLValueString($_POST['artesuministrado'], "text"),
                       GetSQLValueString($_POST['formatoarte'], "text"));

  mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
  $Result1 = mysql_query($insertSQL, $sistemapacgrafica) or die(mysql_error());

  $insertGoTo = "emails.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_usuario = "SELECT * FROM usuarios";
$usuario = mysql_query($query_usuario, $sistemapacgrafica) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Agregar Tarea - Cacumen</title>

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
                        <h1 class="page-header">Agregar Nueva Tarea</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                 <div class="panel panel-primary">
   <div class="panel-heading">Nueva Tarea</div>
   <div class="panel-body">
                <form method="POST" name="form1" action="<?php echo $editFormAction; ?>">
                <div class="row">
  <div class="col-md-8">
  <div class="row">
  <div class="col-md-6">
  Fecha Llegada: <input type="date" name="Fecha_llegada" value="" size="32" class="form-control" required> <br>
  </div>
  <div class="col-md-6">
  Fecha Entrega: <input type="date" name="Fecha_Entrega" value="" size="32" class="form-control" required> <br>
  </div>
  </div>
  <input type="text" name="Nombre_tarea" value="" size="32" placeholder="Nombre General de la Tarea" class="form-control"  required><br>
  <div class="row">
  <div class="col-md-2"><input name="cant1" type="text" class="form-control" placeholder="Cantidad" required></div>
  <div class="col-md-4"><textarea name="Descripcion_tarea1" cols="50" rows="5" placeholder="Descripción" class="form-control" MAXLENGTH="80" required></textarea></div>
  <div class="col-md-3"><input name="preciounitario1" type="text" class="form-control" placeholder="Precio Unitario" required></div>
  <div class="col-md-3"><input name="preciototal1" type="text" class="form-control" placeholder="Precio Total" required></div>
</div><br>
<!-- Boton ocultar y desocultar -->
<b>Mas Productos</b>
<input type="checkbox" name="check" id="check" value="1" onChange="javascript:showContent()" />
<div id="content" style="display: none;">
<!-- fin Boton ocultar y desoculta -->
<div class="row">
  <div class="col-md-2"><input name="cant2" type="text" class="form-control" placeholder="Cantidad"></div>
  <div class="col-md-4"><textarea name="Descripcion_tarea2" cols="50" rows="5" placeholder="Descripción" class="form-control" MAXLENGTH="80"></textarea></div>
  <div class="col-md-3"><input name="preciounitario2" type="text" class="form-control" placeholder="Precio Unitario" ></div>
  <div class="col-md-3"><input name="preciototal2" type="text" class="form-control" placeholder="Precio Total"></div>
</div><br>
<div class="row">
  <div class="col-md-2"><input name="cant3" type="text" class="form-control" placeholder="Cantidad"></div>
  <div class="col-md-4"><textarea name="Descripcion_tarea3" cols="50" rows="5" placeholder="Descripción" class="form-control" MAXLENGTH="80"></textarea></div>
  <div class="col-md-3"><input name="preciounitario3" type="text" class="form-control" placeholder="Precio Unitario" ></div>
  <div class="col-md-3"><input name="preciototal3" type="text" class="form-control" placeholder="Precio Total"></div>
</div><br>
<div class="row">
  <div class="col-md-2"><input name="cant4" type="text" class="form-control" placeholder="Cantidad"></div>
  <div class="col-md-4"><textarea name="Descripcion_tarea4" cols="50" rows="5" placeholder="Descripción" class="form-control" MAXLENGTH="80"></textarea></div>
  <div class="col-md-3"><input name="preciounitario4" type="text" class="form-control" placeholder="Precio Unitario" ></div>
  <div class="col-md-3"><input name="preciototal4" type="text" class="form-control" placeholder="Precio Total"></div>
</div><br>
<div class="row">
  <div class="col-md-2"><input name="cant5" type="text" class="form-control" placeholder="Cantidad"></div>
  <div class="col-md-4"><textarea name="Descripcion_tarea5" cols="50" rows="5" placeholder="Descripción" class="form-control" MAXLENGTH="80"></textarea></div>
  <div class="col-md-3"><input name="preciounitario5" type="text" class="form-control" placeholder="Precio Unitario" ></div>
  <div class="col-md-3"><input name="preciototal5" type="text" class="form-control" placeholder="Precio Total"></div>
</div>
<!-- inicio div ocultar -->
</div>
<!-- fin div ocultarr -->
  </div>
  <div class="col-md-4"><br>
  <input type="text" name="Nombre_Cliente" value="" size="32" placeholder="Nombre Cliente" class="form-control" required><br>
  <input type="email" name="Email_cliente" value="" size="32" placeholder="E-mail" class="form-control" required><br>
  <input type="text" name="Telefono_cliente" value="" size="32" placeholder="Telefono Cliente" class="form-control" required><br>
  <input type="text" name="Total_cobrado" value="" size="32" placeholder="$ Total Cobrado" class="form-control" required><br>
  <input type="text" name="Total_Adelanto" value="" size="32" placeholder="$ Total Adelanto" class="form-control" required><br>
   <input type="text" name="debe" value="" size="32" placeholder="$ Debe" class="form-control" required>
  <br>
  Asignado:
  <select name="Asignacion" id="Asignacion" class="form-control" required>
    <option value=""></option>
  
    <?php
do {  
?>
    <option value="<?php echo $row_usuario['Id_usuario']?>"><?php echo $row_usuario['nombre']?></option>
    <?php
} while ($row_usuario = mysql_fetch_assoc($usuario));
  $rows = mysql_num_rows($usuario);
  if($rows > 0) {
      mysql_data_seek($usuario, 0);
	  $row_usuario = mysql_fetch_assoc($usuario);
  }
?>
  </select>
  <br>
  Categoria:
  <select name="categoria" id="categoria" class="form-control" required>
    <option value=""></option>
    <option value="Impresion">Impresión</option>
    <option value="Estampado">Estampado</option>
    <option value="Diseno 2D y 3D">Diseño 2D y 3D</option>
    <option value="Pieza P.O.P">Pieza P.O.P</option>
    <option value="Web Site">Web Site</option>
    <option value="Senalizacion">Señalización</option>
    <option value="Redes Sociales">Redes Sociales</option>
    <option value="Email Marketing">Email Marketing</option>
    <option value="Video">Video</option>
    <option value="Tarjeta de Presentacion">Tarjeta de Presentación</option>
    <option value="Fotografia">Fotografia</option>
    <option value="Illustracion">Illustración</option>
    <option value="Multimedia">Multimedia</option>
    <option value="Otro">Otro</option>
  </select>
  <br>
  Arte Suministrado:
  <p>
    <label>
      <input type="radio"  name="artesuministrado" value="si" id="artesuministrado" required>
      Si</label>
    <br>
    <label>
      <input type="radio"  name="artesuministrado" value="no" id="artesuministrado" required>
      No</label>
    <br>
  </p>
  <br>
  Formato:
  <input type="text" name="formatoarte" value="" size="32" placeholder="JPG. PNG. PDF" class="form-control">
  <br>
  
  <input type="text" name="Observaciones_tarea" value="" size="32" placeholder="Observaciones" class="form-control">
  
  <input type="hidden" name="Usuario_tarea" value="<?php echo $_SESSION['MM_Username']?>" size="32">
  <input type="hidden" name="Estado_tarea" value="Activa" size="32">
  <input type="hidden" name="Usuario_modifico" value="" size="32">
  </div>
  </div>
  <br><br>
  <input type="submit" value="Agregar Tarea" class="btn btn-info">
                    
                  <input type="hidden" name="MM_insert" value="form1">
                  
                  
                </form>
  
 

   
   </div></div></div>

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
mysql_free_result($usuario);
?>
