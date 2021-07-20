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

$varrecibo_recibo = "0";
if (isset($_GET["recordID"])) {
  $varrecibo_recibo = $_GET["recordID"];
}
mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_recibo = sprintf("SELECT * FROM tareas WHERE tareas.Id_tarea = %s", GetSQLValueString($varrecibo_recibo, "int"));
$recibo = mysql_query($query_recibo, $sistemapacgrafica) or die(mysql_error());
$row_recibo = mysql_fetch_assoc($recibo);
$totalRows_recibo = mysql_num_rows($recibo);
?>
<style>
body{font-family:myriad pro condensed;}
img{
	z-index:1;}
</style>
<meta charset="utf-8">
<div style="z-index:3; position:absolute; margin-top: 190px; margin-left:90px; font-size:20px; text-transform:uppercase; font-family:myriad pro condensed;"><?php echo $row_recibo['Nombre_Cliente']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 190px; margin-left:490px; font-size:20px;">
<?php echo $row_recibo['Email_cliente']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 190px; margin-left:930px; font-size:20px;">
<?php echo $row_recibo['Telefono_cliente']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 435px; margin-left:870px; font-size:20px;">
<?php echo $row_recibo['Total_cobrado']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 468px; margin-left:870px; font-size:20px;">
<?php echo $row_recibo['Total_Adelanto']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 500px; margin-left:870px; font-size:20px;">
<?php echo $row_recibo['debe']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 150px; margin-left:110px; font-size:20px; text-transform:uppercase;">
<?php echo $row_recibo['Fecha_llegada']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 165px; margin-left:110px; font-size:20px; text-transform:uppercase;">
<?php echo $row_recibo['Fecha_Entrega']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 470px; margin-left:65px; font-size:20px;">
<?php echo $row_recibo['Observaciones_tarea']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 40px; margin-left:550px; font-size:25px; color:#004f83;">
<?php echo $row_recibo['Id_tarea']; ?></div>


<div style="z-index:3; position:absolute; margin-top: 250px; margin-left:110px; font-size:20px; text-transform:uppercase;">
<?php echo $row_recibo['cant1']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 280px; margin-left:110px; font-size:20px; text-transform:uppercase;">
<?php echo $row_recibo['cant2']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 320px; margin-left:110px; font-size:20px; text-transform:uppercase;">
<?php echo $row_recibo['cant3']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 360px; margin-left:110px; font-size:20px; text-transform:uppercase;">
<?php echo $row_recibo['cant4']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 400px; margin-left:110px; font-size:20px; text-transform:uppercase;">
<?php echo $row_recibo['cant5']; ?></div>


<div style="z-index:3; position:absolute; margin-top: 250px; margin-left:210px; font-size:20px;">
<?php echo $row_recibo['Descripcion_tarea1']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 280px; margin-left:210px; font-size:20px;">
<?php echo $row_recibo['Descripcion_tarea2']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 320px; margin-left:210px; font-size:20px;">
<?php echo $row_recibo['Descripcion_tarea3']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 360px; margin-left:210px; font-size:20px;">
<?php echo $row_recibo['Descripcion_tarea4']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 400px; margin-left:210px; font-size:20px;">
<?php echo $row_recibo['Descripcion_tarea5']; ?></div>


<div style="z-index:3; position:absolute; margin-top: 250px; margin-left:730px; font-size:20px; text-transform:uppercase;">
<?php echo $row_recibo['preciounitario1']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 280px; margin-left:730px; font-size:20px; text-transform:uppercase;">
<?php echo $row_recibo['preciounitario2']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 320px; margin-left:730px; font-size:20px; text-transform:uppercase;">
<?php echo $row_recibo['preciounitario3']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 360px; margin-left:730px; font-size:20px; text-transform:uppercase;">
<?php echo $row_recibo['preciounitario4']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 400px; margin-left:730px; font-size:20px; text-transform:uppercase;">
<?php echo $row_recibo['preciounitario5']; ?></div>



<div style="z-index:3; position:absolute; margin-top: 250px; margin-left:870px; font-size:20px;">
<?php echo $row_recibo['preciototal1']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 280px; margin-left:870px; font-size:20px;">
<?php echo $row_recibo['preciototal2']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 320px; margin-left:870px; font-size:20px;">
<?php echo $row_recibo['preciototal3']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 360px; margin-left:870px; font-size:20px;">
<?php echo $row_recibo['preciototal4']; ?></div>
<div style="z-index:3; position:absolute; margin-top: 400px; margin-left:870px; font-size:20px;">
<?php echo $row_recibo['preciototal5']; ?></div>

<div style="z-index:3; position:absolute; margin-top: 320px; margin-left:1030px; font-size:20px;">
<?php echo $row_recibo['formatoarte']; ?></div>

<img src="../images/orden.jpg" width="1276" height="551">
<?php
mysql_free_result($recibo);
?>
