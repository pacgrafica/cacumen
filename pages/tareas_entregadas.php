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

$maxRows_tareasentregadas = 1;
$pageNum_tareasentregadas = 0;
if (isset($_GET['pageNum_tareasentregadas'])) {
  $pageNum_tareasentregadas = $_GET['pageNum_tareasentregadas'];
}
$startRow_tareasentregadas = $pageNum_tareasentregadas * $maxRows_tareasentregadas;

mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_tareasentregadas = "SELECT * FROM tareas WHERE tareas.Estado_tarea =  'Entregado ' ORDER BY tareas.Id_tarea DESC";
$query_limit_tareasentregadas = sprintf("%s LIMIT %d, %d", $query_tareasentregadas, $startRow_tareasentregadas, $maxRows_tareasentregadas);
$tareasentregadas = mysql_query($query_limit_tareasentregadas, $sistemapacgrafica) or die(mysql_error());
$row_tareasentregadas = mysql_fetch_assoc($tareasentregadas);

if (isset($_GET['totalRows_tareasentregadas'])) {
  $totalRows_tareasentregadas = $_GET['totalRows_tareasentregadas'];
} else {
  $all_tareasentregadas = mysql_query($query_tareasentregadas);
  $totalRows_tareasentregadas = mysql_num_rows($all_tareasentregadas);
}
$totalPages_tareasentregadas = ceil($totalRows_tareasentregadas/$maxRows_tareasentregadas)-1;

$queryString_tareasentregadas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_tareasentregadas") == false && 
        stristr($param, "totalRows_tareasentregadas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_tareasentregadas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_tareasentregadas = sprintf("&totalRows_tareasentregadas=%d%s", $totalRows_tareasentregadas, $queryString_tareasentregadas);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tareas Entregadas</title>

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
                        <h1 class="page-header">Tareas Entregadas</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                
                <div class="btn-group">
  
  <button class="btn dropdown-toggle" data-toggle="dropdown">
    Filtrar <span class="caret"></span> 
  </button>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu4">
  <li role="presentation"><a role="menuitem" tabindex="-1" href="lista_tareas.php">Tareas Por Entregar</a></li>
  <li role="presentation" class="disabled"><a role="menuitem" tabindex="-1" href="tareas_entregadas.php">Tareas Entregadas</a></li>
  <li role="presentation"><a role="menuitem" tabindex="-1" href="mis_tareas.php?recordID=<?php echo $_SESSION['MM_Username']?>">Mis Tareas</a></li>
  </ul>
</div>     

 
       <hr>
       <div class="panel panel-primary">
                <div class="panel-heading">Tarea N° <?php echo $row_tareasentregadas['Id_tarea']; ?></div>
                <div class="panel-body">
                    
                  <?php do { ?>
                  <div class="row">
                    <div class="col-md-8">
                        
                      <div class="panel panel-default">
                        <div class="panel-body">
                          <strong>
                          <?php echo $row_tareasentregadas['Nombre_tarea']; ?><br><br>
                          </strong>
                          Descripción:<br>
                          <?php echo $row_tareasentregadas['Descripcion_tarea']; ?><br><br>
                          Observaciones:<br>
                          <?php echo $row_tareasentregadas['Observaciones_tarea']; ?><br><br>
                          Estado Tarea:<br>
                          <strong style="color:#f41100;">
                          <?php echo $row_tareasentregadas['Estado_tarea']; ?>
                          </strong><br><br>
                          Prioridad:<br>
                          <?php echo $row_tareasentregadas['Urgencia_tarea']; ?>
                        </div>
                      </div>
                        
                    </div>
                    <div class="col-md-4">
                        
                      <div class="panel panel-default">
                        <div class="panel-body">
                          Datos del Cliente:<br><br>
                          Nombre:<br>
                          <?php echo $row_tareasentregadas['Nombre_Cliente']; ?><br><br>
                          Email:<br>
                          <?php echo $row_tareasentregadas['Email_cliente']; ?><br><br>
                          Telefono:<br>
                          <?php echo $row_tareasentregadas['Telefono_cliente']; ?><br><br>
                          Estado Cliente:<br>
                          <?php echo $row_tareasentregadas['Estado_cliente']; ?>
                        </div>
                      </div>
                        
                        
                        
                        
                        
                        
                    </div>
                    <div class="col-md-8">
                        
                      <div class="panel panel-default">
                        <div class="panel-body">
                          Fecha Llegada:<br>
                          <?php echo $row_tareasentregadas['Fecha_llegada']; ?><br><br>
                          Fecha Entrega:<br>
                          <?php echo $row_tareasentregadas['Fecha_Entrega']; ?><br><br>
                          Usuario que registro la tarea:<br>
                          <?php echo $row_tareasentregadas['Usuario_tarea']; ?>
                            
                        </div>
                      </div>
                        
<div class="panel panel-info">
  <div class="panel-body">
  <strong>Reporte Final:</strong><br>  
    Estado del Cliente: <?php echo $row_tareasentregadas['Estado_Cliente']; ?><br>
    
    <?php echo $row_tareasentregadas['Reporte_Final']; ?>
  </div>
</div>
                        
                        
                        
                        
                    </div>
                    <div class="col-md-4">
                        
                        
                      <div class="panel panel-default">
                        <div class="panel-body">
                          Total Cobrado:<br>
                          <?php echo $row_tareasentregadas['Total_cobrado']; ?><br><br>
                          Total Abonado:<br>
                          <?php echo $row_tareasentregadas['Total_Adelanto']; ?><br><br>
                          Usuario que entrego la tarea:<br>
                          <?php echo $row_tareasentregadas['Usuario_modifico']; ?><br><br>
                          Asignado:<br>
                          <?php echo $row_tareasentregadas['Asignacion']; ?>
                        </div>
                      </div>
                        
                        
                        

                        
                        
                        
                      <p>&nbsp;</p>
                    </div>
                  </div>
                    <?php } while ($row_tareasentregadas = mysql_fetch_assoc($tareasentregadas)); ?>
                   
                </div>
  </div>
               
                
                
                
                 <table border="0">
                      <tr>
                        <td><?php if ($pageNum_tareasentregadas > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_tareasentregadas=%d%s", $currentPage, 0, $queryString_tareasentregadas); ?>" class="btn btn-default">Primero</a>
                            <?php } // Show if not first page ?></td>
                        <td><?php if ($pageNum_tareasentregadas > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_tareasentregadas=%d%s", $currentPage, max(0, $pageNum_tareasentregadas - 1), $queryString_tareasentregadas); ?>" class="btn btn-default">Anterior</a>
                            <?php } // Show if not first page ?></td>
                        <td><?php if ($pageNum_tareasentregadas < $totalPages_tareasentregadas) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_tareasentregadas=%d%s", $currentPage, min($totalPages_tareasentregadas, $pageNum_tareasentregadas + 1), $queryString_tareasentregadas); ?>" class="btn btn-default">Siguiente</a>
                            <?php } // Show if not last page ?></td>
                        <td><?php if ($pageNum_tareasentregadas < $totalPages_tareasentregadas) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_tareasentregadas=%d%s", $currentPage, $totalPages_tareasentregadas, $queryString_tareasentregadas); ?>" class="btn btn-default">&Uacute;ltimo</a>
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
mysql_free_result($tareasentregadas);
?>
