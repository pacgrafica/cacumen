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

$vartarifa_plantucarro = "0";
if (isset($_GET["recordID"])) {
  $vartarifa_plantucarro = $_GET["recordID"];
}
mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_plantucarro = sprintf("SELECT * FROM plantucarro WHERE plantucarro.Id_tarifa = %s", GetSQLValueString($vartarifa_plantucarro, "text"));
$plantucarro = mysql_query($query_plantucarro, $sistemapacgrafica) or die(mysql_error());
$row_plantucarro = mysql_fetch_assoc($plantucarro);
$totalRows_plantucarro = mysql_num_rows($plantucarro);

mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_plantuinmueble = "SELECT * FROM plantuinmueble";
$plantuinmueble = mysql_query($query_plantuinmueble, $sistemapacgrafica) or die(mysql_error());
$row_plantuinmueble = mysql_fetch_assoc($plantuinmueble);
$totalRows_plantuinmueble = mysql_num_rows($plantuinmueble);

mysql_select_db($database_sistemapacgrafica, $sistemapacgrafica);
$query_plantumoto = "SELECT * FROM plantumoto";
$plantumoto = mysql_query($query_plantumoto, $sistemapacgrafica) or die(mysql_error());
$row_plantumoto = mysql_fetch_assoc($plantumoto);
$totalRows_plantumoto = mysql_num_rows($plantumoto);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
        <?php include("menuadmin.php"); ?>
            <!-- /.navbar-top-links -->

    
      <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Planes Mercado Libre</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                
               
             



          
          <?php echo $row_plantucarro['Tipo']; ?>
          
          
          
          
                
                
                
                
          </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>

</body>

</html>
<?php
mysql_free_result($plantucarro);

mysql_free_result($plantuinmueble);

mysql_free_result($plantumoto);
?>
