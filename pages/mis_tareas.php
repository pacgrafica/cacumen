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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tareas SET Estado_tarea=%s, Usuario_modifico=%s, Estado_Cliente=%s, Reporte_Final=%s WHERE Id_tarea=%s",
                       GetSQLValueString($_POST['Estado_tarea'], "text"),
                       GetSQLValueString($_POST['Usuario_modifico'], "text"),
                       GetSQLValueString($_POST['Estado_Cliente'], "text"),
                       GetSQLValueString($_POST['Reporte_Final'], "text"),
                       GetSQLValueString($_POST['Id_tarea'], "int"));

  mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
  $Result1 = mysql_query($updateSQL, $sistemapacgrafica) or die(mysql_error());
}

$maxRows_mistareas = 2;
$pageNum_mistareas = 0;
if (isset($_GET['pageNum_mistareas'])) {
  $pageNum_mistareas = $_GET['pageNum_mistareas'];
}
$startRow_mistareas = $pageNum_mistareas * $maxRows_mistareas;

$varmistareas_mistareas = "0";
if (isset($_GET["recordID"])) {
  $varmistareas_mistareas = $_GET["recordID"];
}
mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_mistareas = sprintf("SELECT * FROM tareas WHERE tareas.Asignacion = %s AND tareas.Estado_tarea = 'Activa'", GetSQLValueString($varmistareas_mistareas, "text"));
$query_limit_mistareas = sprintf("%s LIMIT %d, %d", $query_mistareas, $startRow_mistareas, $maxRows_mistareas);
$mistareas = mysql_query($query_limit_mistareas, $sistemapacgrafica) or die(mysql_error());
$row_mistareas = mysql_fetch_assoc($mistareas);

if (isset($_GET['totalRows_mistareas'])) {
  $totalRows_mistareas = $_GET['totalRows_mistareas'];
} else {
  $all_mistareas = mysql_query($query_mistareas);
  $totalRows_mistareas = mysql_num_rows($all_mistareas);
}
$totalPages_mistareas = ceil($totalRows_mistareas/$maxRows_mistareas)-1;
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mis Tareas</title>

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
      <h1 class="page-header">Mis Tareas</h1>
      </div>
    <!-- /.col-lg-12 -->
    </div>
  
  
  <div class="btn-group">
    
    <button class="btn dropdown-toggle" data-toggle="dropdown">
      Filtrar <span class="caret"></span> 
    </button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu4">
      <li role="presentation" ><a role="menuitem" tabindex="-1" href="lista_tareas.php">Tareas Por Entregar</a></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" href="tareas_entregadas.php">Tareas Entregadas</a></li>
      <li role="presentation" class="disabled"><a role="menuitem" tabindex="-1" href="mis_tareas.php?recordID=<?php echo $_SESSION['MM_Username']?>">Mis Tareas</a></li>
    </ul>
  </div>     
  
  
  <hr>
  <?php if ($totalRows_mistareas > 0) { // Show if recordset not empty ?>
  <?php do { ?>
    <div class="panel panel-primary">
    <div class="panel-heading">Servicio N° <?php echo $row_mistareas['Id_tarea']; ?></div>
    <div class="panel-body">
    <div class="row">
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-body"> <strong> <?php echo $row_mistareas['Nombre_tarea']; ?><br>
          <br>
          </strong> Descripción:<br>
          <?php echo $row_mistareas['Descripcion_tarea']; ?><br>
          <br>
          Observaciones:<br>
          <?php echo $row_mistareas['Observaciones_tarea']; ?><br>
          <br>
          Estado Tarea:<br>
          <strong style="color:#090;"> <?php echo $row_mistareas['Estado_tarea']; ?> </strong><br>
          <br>
          Prioridad:<br>
          <?php echo $row_mistareas['Urgencia_tarea']; ?> </div>
        </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-body"> Datos del Cliente:<br>
          <br>
          Nombre:<br>
          <?php echo $row_mistareas['Nombre_Cliente']; ?><br>
          <br>
          Email:<br>
          <?php echo $row_mistareas['Email_cliente']; ?><br>
          <br>
          Telefono:<br>
          <?php echo $row_mistareas['Telefono_cliente']; ?><br>
          <br>
          Estado Cliente:<br>
          <?php echo $row_mistareas['Estado_cliente']; ?> </div>
        </div>
    </div>
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-body"> Fecha Llegada:<br>
          <?php echo $row_mistareas['Fecha_llegada']; ?><br>
          <br>
          Fecha Entrega:<br>
          <?php echo $row_mistareas['Fecha_Entrega']; ?><br>
          <br>
          Usuario:<br>
          <?php echo $row_mistareas['Usuario_tarea']; ?> </div>
        </div>
    </div>
    <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-body"> Total Cobrado:<br>
        <?php echo $row_mistareas['Total_cobrado']; ?><br>
        <br>
        Total Abonado:<br>
        <?php echo $row_mistareas['Total_Adelanto']; ?><br>
        <br>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right"></td>
      <td><input type="hidden" name="Estado_tarea" value="Entregado" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"></td>
      <td><input type="hidden" name="Usuario_modifico" value="<?php echo $_SESSION['MM_Username']?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"></td>
      <td>Estado del Cliente:
      <p>
        <label>
          <input type="radio" name="Estado_Cliente" value="Excelente" id="Estado_Cliente" required>
          <img src="../images/contento.png" width="33" height="33"> Excelente</label>
        <label>
          <input type="radio" name="Estado_Cliente" value="Muy Bien" id="Estado_Cliente" required>
          <img src="../images/medio.png" width="33" height="33"> Muy Bien</label>
          <label>
          <input type="radio" name="Estado_Cliente" value="Triste" id="Estado_Cliente" required>
          <img src="../images/triste.png" width="33" height="33"> Triste</label>
      </p></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"></td>
      <td><textarea type="txt" name="Reporte_Final" value="" rows="8" cols="60" class="form-control" placeholder="Reporte Final" required></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Entregar Tarea" class="btn btn-success"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="Id_tarea" value="<?php echo $row_mistareas['Id_tarea']; ?>">
</form>
<p>&nbsp;</p>
      </div>
      </div>
     </div>
     </div>
    </div>
    </div>
    <?php } while ($row_mistareas = mysql_fetch_assoc($mistareas)); ?>
    <?php } // Show if recordset not empty ?>
    <?php if ($totalRows_mistareas == 0) { // Show if recordset empty ?>
      No Tienes Tareas Pendientes
  <?php } // Show if recordset empty ?>
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
mysql_free_result($mistareas);
?>
