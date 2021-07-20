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

$varcliente_varfactura = "0";
if (isset($_GET["recordID"])) {
  $varcliente_varfactura = $_GET["recordID"];
}
mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_varfactura = sprintf("SELECT * FROM clientes WHERE clientes.Id_cliente = %s", GetSQLValueString($varcliente_varfactura, "text"));
$varfactura = mysql_query($query_varfactura, $sistemapacgrafica) or die(mysql_error());
$row_varfactura = mysql_fetch_assoc($varfactura);
$totalRows_varfactura = mysql_num_rows($varfactura);
?>
<html><head>
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
<meta http-equiv="Content-Type" content="text/html">
<meta charset="utf-8">
<body>
<div style="z-index:-1; width:2550px; height:2000px;">

<div style="z-index:3; position:absolute; margin-top: 312px; margin-left:195px; font-size:20px; text-transform:uppercase;"><strong><?php echo $row_varfactura['Nombre']; ?></strong></div>
<div style="z-index:3; position:absolute; margin-top: 345px; margin-left:170px; font-size:20px;"><strong><?php echo $row_varfactura['Identificacion']; ?></strong></div>
<div style="z-index:3; position:absolute; margin-top:380px; margin-left:220px; font-size:20px;"><strong><?php echo $row_varfactura['Direccion']; ?></strong></div>
<div style="z-index:3; position:absolute; margin-top:380px; margin-left:610px; font-size:20px;"><strong><?php echo $row_varfactura['Email']; ?></strong></div>

<div style="z-index:3; position:absolute; margin-top: 220px; margin-left:970px;font-size:20px;"><strong><?php echo $row_varfactura['Fecha']; ?></strong></div>
<div style="z-index:3; position:absolute;  margin-top: 315px; margin-left:970px;font-size:20px;"><strong><?php echo $row_varfactura['Fecha']; ?></strong></div>
<div style="z-index:3; position:absolute; margin-top: 360px; margin-left:970px; font-size:20px;"><strong>Pedido</strong></div>
<div style="z-index:3; position:absolute; margin-top: 415px; margin-left:970px; font-size:20px;"><strong>Convenido</strong></div>

<div style="z-index:3; position:absolute; margin-top: 550px; margin-left:100px; font-size:20px;"><strong><?php echo $row_varfactura['Cantidad']; ?></strong></div>
<div style="z-index:3; position:absolute; margin-top: 550px; margin-left:300px; font-size:20px;"><strong><?php echo $row_varfactura['Descripcion']; ?></strong></div>
<div style="z-index:3; position:absolute; margin-top: 650px; margin-left:100px; font-size:20px;"><strong><?php echo $row_varfactura['Cantidad2']; ?></strong></div>
<div style="z-index:3; position:absolute; margin-top: 650px; margin-left:300px; font-size:20px;"><strong><?php echo $row_varfactura['Descripcion2']; ?></strong></div>
<div style="z-index:3; position:absolute; margin-top: 750px; margin-left:100px; font-size:20px;"><strong><?php echo $row_varfactura['Cantidad3']; ?></strong></div>
<div style="z-index:3; position:absolute; margin-top: 750px; margin-left:300px; font-size:20px;"><strong><?php echo $row_varfactura['Descripcion3']; ?></strong></div>
<div style="z-index:3; position:absolute;  margin-top: 550px; margin-left:870px; font-size:20px;"><strong><?php echo $row_varfactura['PrecioUni']; ?></strong></div>
<div style="z-index:3; position:absolute; margin-top: 550px; margin-left:1020px; font-size:20px;"><strong><?php echo $row_varfactura['PrecipTotal']; ?></strong></div>
<div style="z-index:3; position:absolute;  margin-top: 650px; margin-left:870px; font-size:20px;"><strong><?php echo $row_varfactura['PrecioUni2']; ?></strong></div>
<div style="z-index:3; position:absolute; margin-top: 650px; margin-left:1020px; font-size:20px;"><strong><?php echo $row_varfactura['PrecioTotal2']; ?></strong></div>
<div style="z-index:3; position:absolute;  margin-top: 750px; margin-left:870px; font-size:20px;"><strong><?php echo $row_varfactura['PrecioUni3']; ?></strong></div>
<div style="z-index:3; position:absolute; margin-top: 750px; margin-left:1020px; font-size:20px;"><strong><?php echo $row_varfactura['PrecioTotal3']; ?></strong></div>

<div style="z-index:3; position:absolute; margin-top: 1240px; margin-left:1030px; font-size:20px;"><strong><?php echo $row_varfactura['SubTotal']; ?></strong></div>
<div style="z-index:3; position:absolute;  margin-top: 1280px; margin-left:1030px; font-size:20px;"><strong><?php echo $row_varfactura['Iva']; ?></strong></div>
<div style="z-index:3; position:absolute; margin-top: 1315px; margin-left:1030px; font-size:20px;"><strong><?php echo $row_varfactura['Total']; ?></strong></div>

<div style="z-index:3; position:absolute; margin-top: 1260px; margin-left:200px; font-size:20px;text-transform:uppercase;"><strong><?php echo $row_varfactura['Precioletra']; ?></strong></div>

<b>Cacumen / Impreso por: <?php echo $_SESSION['MM_Username']?></b>
<input type="checkbox" name="check" id="check" value="1" onChange="javascript:showContent()" />
<div id="content" style="display: none;">

<div style="z-index:1; "><img src="../images/2.png"></div>
<div style="z-index:1; "><img src="../images/3.jpg"></div>

</div>

</div>

</body></html>
<?php
mysql_free_result($varfactura);
?>
