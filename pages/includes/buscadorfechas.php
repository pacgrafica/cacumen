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

mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_buscadorfechas = "SELECT * FROM clientes WHERE clientes.Fecha BETWEEN 'desde' AND 'hasta' ORDER BY Id_cliente  ASC";
$buscadorfechas = mysql_query($query_buscadorfechas, $sistemapacgrafica) or die(mysql_error());
$row_buscadorfechas = mysql_fetch_assoc($buscadorfechas);
$totalRows_buscadorfechas = mysql_num_rows($buscadorfechas);

mysql_free_result($buscadorfechas);
?>
     <!-- /.buscador -->
            <div class="panel panel-default">
  <div class="panel-body">
     <input type="text" placeholder="Buscar Nombre o Identificación" id="bs-prod" /> 
            <input type="date" id="desde"/> Hasta&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" id="hasta"/>
  </div>
</div>
            
<!-- /. fin buscador -->
<?php echo $row_buscadorfechas['Nombre']; ?>
<?php echo $row_buscadorfechas['Identificacion']; ?><?php echo $row_buscadorfechas['Fecha']; ?>