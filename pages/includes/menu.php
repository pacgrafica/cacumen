<?php require_once('../Connections/sistemapacgrafica.php'); ?>
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

$varuser_usuarios = "0";
if (isset($_SESSION['MM_UsuarioCacumen'])) {
  $varuser_usuarios = $_SESSION['MM_UsuarioCacumen'];
}
mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_usuarios = sprintf("SELECT * FROM usuarios WHERE usuarios.Id_usuario = %s", GetSQLValueString($varuser_usuarios, "int"));
$usuarios = mysql_query($query_usuarios, $sistemapacgrafica) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);

mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_tareasactivas = "SELECT * FROM tareas WHERE tareas.Estado_tarea = 'Activa'";
$tareasactivas = mysql_query($query_tareasactivas, $sistemapacgrafica) or die(mysql_error());
$row_tareasactivas = mysql_fetch_assoc($tareasactivas);
$totalRows_tareasactivas = mysql_num_rows($tareasactivas);
?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">RD-Cacumen <strong style="color:#CCC; font-size:10px;">10.03</strong></a> 
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
               
                    
                <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="lista_tareas.php">
                        <i class="fa fa-bell fa-fw"></i>(<?php echo $totalRows_tareasactivas ?>) Tareas Pendientes
                    </a>
                    
                </li>
             
              <!-- /.dropdown -->
              <li><h4><?php echo $row_usuarios['nombre']; ?></h4></li>
                <li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                              <img src="../images/<?php echo $row_usuarios['foto']; ?>" width="80" height="80" class="img-circle" /></a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> Datos Usuario</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $logoutAction ?>"><i class="fa fa-sign-out fa-fw"></i> Desconectar</a>
                        </li>
                    </ul>
                </li>
                <!-- /.dropdown -->
                
  </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                         <img src="../images/pacSaluda.gif"  class="img-rounded" ">        
                        
                        
              
                                          <!-- /fin menu derecha -->
                               <!-- /Menu Principal Izquierda -->
                        </li>
                        <li>
                            <a href="index.php"><i class="fa fa-home fa-fw"></i> Inicio</a>
                        </li>
                          <li>
                            <a href="Admin/index.php" target="_blank"><i class="fa fa-user fa-fw"></i>Acceso Admin</a>
                        </li>
                       <li>
                            <a href="#"><i class="fa fa-usd fa-fw"></i>Productos<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="add_productos.php">Agregar Producto</a>
                                </li>
                                <li>
                                    <a href="lista_productos.php">Lista de Productos</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="clientes.php"><i class="fa fa-tasks fa-fw"></i>Clientes</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-edit fa-fw"></i>Tareas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="add_tarea.php">Agregar Tarea</a>
                                </li>
                                <li>
                                    <a href="lista_tareas.php">Lista de Tareas</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                         <li>
                            <a href="cotizaciones.php"><i class="glyphicon glyphicon-th-list"></i> Cotizaciones</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-file fa-fw"></i>Facturas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="tipo_factura.php" target="_blank">Agregar Factura</a>
                                </li>
                                <li>
                                    <a href="facturas_tucarro.php">Facturas tu carro.com</a>
                                </li>
                                <li>
                                    <a href="facturas_pacgrafica.php">Facturas Pac Grafica</a>
                                </li>
                                <li>
                                    <a href="facturas.php">Todas las Facturas</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
<?php
mysql_free_result($usuarios);

mysql_free_result($tareasactivas);
?>
