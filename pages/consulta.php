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
$query_resbuscadorvarias = "SELECT * FROM clientes WHERE (Identificacion like '%".$_POST['busca']."%') OR( Nombre like '%".$_POST['busca']."%') or (Factura like '%".$_POST['busca']."%')";
$resbuscadorvarias = mysql_query($query_resbuscadorvarias, $sistemapacgrafica) or die(mysql_error());
$row_resbuscadorvarias = mysql_fetch_assoc($resbuscadorvarias);
$totalRows_resbuscadorvarias = mysql_num_rows($resbuscadorvarias);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body>
<form method="POST" action="consulta.php"> 
	<strong>Palabra clave:</strong> <input name="busca" type="text" id="busca" size="20"><br><br> 
	<input type="submit" value="Buscar" name="buscar"> 
</form> 
    <?php do { ?>
        <?php if ($totalRows_resbuscadorvarias > 0) { // Show if recordset not empty ?>
          <?php echo $row_resbuscadorvarias['Nombre']; ?> <br />
          <?php echo $row_resbuscadorvarias['Identificacion']; ?><br />
          <?php echo $row_resbuscadorvarias['Id_cliente']; ?><br />
          <?php } // Show if recordset not empty ?>
<br />
<?php } while ($row_resbuscadorvarias = mysql_fetch_assoc($resbuscadorvarias)); ?>
</body>
</html>
<?php
mysql_free_result($resbuscadorvarias);
?>
