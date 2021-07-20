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

$colname_usuarios = "0";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuarios = $_SESSION['MM_Username'];
}
mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_usuarios = sprintf("SELECT * FROM usuarios WHERE Id_usuario = %s", GetSQLValueString($colname_usuarios, "int"));
$usuarios = mysql_query($query_usuarios, $sistemapacgrafica) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);
?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Pac Grafica</a>
            </div>
            

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                         
           
                        <h1><?php echo $_SESSION['MM_Username']?></h1>
                                          <!-- /fin menu derecha -->
                               <!-- /Menu Principal Izquierda -->
                        </li>
                        <li>
                            <a href="index.php"><i class="fa fa-home fa-fw"></i> Inicio</a>
                        </li>
                        <li>
                            <a href="estadisticas.php"><i class="glyphicon glyphicon-usd"></i> Estadisticas</a>
                        </li>
                          <li>
                            <a href="Admin/index.php"><i class="fa fa-user fa-fw"></i>Usuarios</a>
                        </li>
                         <li>
                            <a href="planesmercadolibre.php"><i class="fa fa-list-alt fa-fw"></i>Planes Mercado Libre</a>
                        </li>
                        <li>
                            <a href="clientes.php"><i class="fa fa-tasks fa-fw"></i>Clientes</a>
                        </li>
                        <li>
                        <a href="producto.php"><i class="fa fa-edit fa-fw"></i>Editar Producto
                        </a>
                        </li>
                        <li>
                            <a href="forms.html"><i class="fa fa-edit fa-fw"></i>Tareas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="panels-wells.html">Agregar Tarea</a>
                                </li>
                                <li>
                                    <a href="buttons.html">Lista de Tareas</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
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
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i>Hojas de Estilo<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.php">Login Page</a>
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
?>
