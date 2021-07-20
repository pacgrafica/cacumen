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

$maxRows_listateras = 10;
$pageNum_listateras = 0;
if (isset($_GET['pageNum_listateras'])) {
  $pageNum_listateras = $_GET['pageNum_listateras'];
}
$startRow_listateras = $pageNum_listateras * $maxRows_listateras;

mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_listateras = "SELECT * FROM tareas WHERE tareas.Estado_tarea =  'Activa'  ORDER BY tareas.Id_tarea ASC";
$query_limit_listateras = sprintf("%s LIMIT %d, %d", $query_listateras, $startRow_listateras, $maxRows_listateras);
$listateras = mysql_query($query_limit_listateras, $sistemapacgrafica) or die(mysql_error());
$row_listateras = mysql_fetch_assoc($listateras);

if (isset($_GET['totalRows_listateras'])) {
  $totalRows_listateras = $_GET['totalRows_listateras'];
} else {
  $all_listateras = mysql_query($query_listateras);
  $totalRows_listateras = mysql_num_rows($all_listateras);
}
$totalPages_listateras = ceil($totalRows_listateras/$maxRows_listateras)-1;

$queryString_listateras = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_listateras") == false && 
        stristr($param, "totalRows_listateras") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_listateras = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_listateras = sprintf("&totalRows_listateras=%d%s", $totalRows_listateras, $queryString_listateras);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Lista Tareas - Cacumen</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../dist/css/otros.css" rel="stylesheet">

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
                        <h1 class="page-header">Listado de Tareas</h1>
                    </div>
                    <!-- /.col-lg-12 -->  
                </div>
                
      <div class="btn-group">
  
  <button class="btn dropdown-toggle" data-toggle="dropdown">
    Filtrar <span class="caret"></span> 
  </button>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu4">
  <li role="presentation" class="disabled"><a role="menuitem" tabindex="-1" href="#">Tareas Por Entregar</a></li>
  <li role="presentation"><a role="menuitem" tabindex="-1" href="tareas_entregadas.php">Tareas Entregadas</a></li>
  <li role="presentation"><a role="menuitem" tabindex="-1" href="mis_tareas.php?recordID=<?php echo $_SESSION['MM_Username']?>">Mis Tareas</a></li>
  </ul>
</div>     

 
       <hr>         
                
                
                
              
              <div class="row">
    <?php do { ?>
      <div class="col-md-6">
        <div class="thumbnail">
        
      <h4><?php echo $row_listateras['Nombre_tarea']; ?></h4><br>
      Cliente: <?php echo $row_listateras['Nombre_Cliente']; ?><br>
      Estado: <strong style="color:#090;"><?php echo $row_listateras['Estado_tarea']; ?></strong><br>
      N° Servicio: <strong style="color:#F00;"><?php echo $row_listateras['Id_tarea']; ?></strong>
        
        
        <div class="panel">
          <a href="#login_form?recordID=<?php echo $row_listateras['Id_tarea']; ?>" class="btn btn-primary" role="button" >Ver</a>
          
          <A href="JavaScript:window.open('imp_recibo.php?recordID=<?php echo $row_listateras['Id_tarea']; ?>','foforofos','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0,width=screen.width,height=screen.height,top=0,left=0');">Imprimir</A>  
          
          </div> 
        
        <!--- pop up  con la informacion-->
        <a href="#x" class="overlay" id="login_form?recordID=<?php echo $row_listateras['Id_tarea']; ?>"></a>
        <div class="popup">
        
          <!--- contenido mostrar-->
          <h4><?php echo $row_listateras['Nombre_tarea']; ?></h4><br>
   <strong>Productos:</strong>
   		      <br>
  <div class="row">
  <div class="col-md-3">Cantidad</div>
  <div class="col-md-3">Descripción</div>
  <div class="col-md-3">Precio Unitario</div>
  <div class="col-md-3">Precio Total</div>
  
  
  <div class="col-md-2"><?php echo $row_listateras['cant1']; ?></div>
  <div class="col-md-5"><?php echo $row_listateras['Descripcion_tarea1']; ?></div>
  <div class="col-md-2"><?php echo $row_listateras['preciounitario1']; ?></div>
  <div class="col-md-2"><?php echo $row_listateras['preciototal1']; ?></div>
  
  <div class="col-md-2"><?php echo $row_listateras['cant2']; ?></div>
  <div class="col-md-5"><?php echo $row_listateras['Descripcion_tarea2']; ?></div>
  <div class="col-md-2"><?php echo $row_listateras['preciounitario2']; ?></div>
  <div class="col-md-2"><?php echo $row_listateras['preciototal2']; ?></div>
  
  <div class="col-md-2"><?php echo $row_listateras['cant3']; ?></div>
  <div class="col-md-5"><?php echo $row_listateras['Descripcion_tarea3']; ?></div>
  <div class="col-md-2"><?php echo $row_listateras['preciounitario3']; ?></div>
  <div class="col-md-2"><?php echo $row_listateras['preciototal3']; ?></div>
  
  <div class="col-md-2"><?php echo $row_listateras['cant4']; ?></div>
  <div class="col-md-5"><?php echo $row_listateras['Descripcion_tarea4']; ?></div>
  <div class="col-md-2"><?php echo $row_listateras['preciounitario4']; ?></div>
  <div class="col-md-2"><?php echo $row_listateras['preciototal4']; ?></div>
  
  <div class="col-md-2"><?php echo $row_listateras['cant5']; ?></div>
  <div class="col-md-5"><?php echo $row_listateras['Descripcion_tarea5']; ?></div>
  <div class="col-md-2"><?php echo $row_listateras['preciounitario5']; ?></div>
  <div class="col-md-2"><?php echo $row_listateras['preciototal5']; ?></div>
  </div>
   		  <strong>Observaciones:</strong>
		  <?php echo $row_listateras['Observaciones_tarea']; ?><br>
           <strong>Total Cobrado:</strong>
		  <?php echo $row_listateras['Total_cobrado']; ?><br>
          <strong>Total Adelanto:</strong>
		  <?php echo $row_listateras['Total_Adelanto']; ?><br>
          <strong>Debe:</strong>
		  <?php echo $row_listateras['debe']; ?><br><br>
          <strong>Cliente:</strong>
          <?php echo $row_listateras['Nombre_Cliente']; ?><br>
          <strong>Email:</strong>
		  <?php echo $row_listateras['Email_cliente']; ?><br>
          <strong>Telefono:</strong>
		  <?php echo $row_listateras['Telefono_cliente']; ?><br>
          <strong>Fecha de Llegada:</strong>
          <?php echo $row_listateras['Fecha_llegada']; ?><br>
          <strong>Fecha de Entrega:</strong>
		  <?php echo $row_listateras['Fecha_Entrega']; ?><br>
          <strong>Usuario que Ingreso la Tarea:</strong>
		  <?php echo $row_listateras['Usuario_tarea']; ?><br>
          <strong>Asignado:</strong>
          <?php echo $row_listateras['Asignacion']; ?><br><br>
          
          <strong>Categoria:</strong>
          <?php echo $row_listateras['categoria']; ?><br>
          <strong>Arte Suministrado:</strong>
          <?php echo $row_listateras['artesuministrado']; ?><br>
          <strong>Formato:</strong>
          <?php echo $row_listateras['formatoarte']; ?><br><br>
          
         
      
          
          
          
          
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
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
      <td><br><br><input type="submit" value="Entregar Tarea" class="btn btn-success"></td>
    </tr>
  </table>
  <input type="hidden" name="Id_tarea" value="<?php echo $row_listateras['Id_tarea']; ?>">
  <input type="hidden" name="MM_update" value="form1">
</form>
          
          <!--- fin contenido mostrar--> 
      
          
          
          
          <a class="close" href="#close"></a>
          </div>
            </div>
        </div>
      <!--- Fin pop up  con la informacion-->
     
                <?php } while ($row_listateras = mysql_fetch_assoc($listateras)); ?>
       
    </div>
              
              
              
                
                
                
                <table border="0">
                  <tr>
                    <td><?php if ($pageNum_listateras > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_listateras=%d%s", $currentPage, 0, $queryString_listateras); ?>" class="btn btn-default">Primero</a>
                        <?php } // Show if not first page ?></td>
                    <td><?php if ($pageNum_listateras > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_listateras=%d%s", $currentPage, max(0, $pageNum_listateras - 1), $queryString_listateras); ?>" class="btn btn-default">Anterior</a>
                        <?php } // Show if not first page ?></td>
                    <td><?php if ($pageNum_listateras < $totalPages_listateras) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_listateras=%d%s", $currentPage, min($totalPages_listateras, $pageNum_listateras + 1), $queryString_listateras); ?>" class="btn btn-default">Siguiente</a>
                        <?php } // Show if not last page ?></td>
                    <td><?php if ($pageNum_listateras < $totalPages_listateras) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_listateras=%d%s", $currentPage, $totalPages_listateras, $queryString_listateras); ?>" class="btn btn-default">&Uacute;ltimo</a>
                        <?php } // Show if not last page ?></td>
                  </tr>
                </table>
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
mysql_free_result($listateras);
?>
