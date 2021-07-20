<!doctype html>
<html class="">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Subir Imagen</title>
</head>
<body>
<?php if ((isset($_POST["enviado"])) && ($_POST["enviado"] == "form1")) { 
   $nombre_archivo = $_FILES['userfile']['name'];
   
   move_uploaded_file($_FILES['userfile']['tmp_name'],"../images/productos/".$nombre_archivo);
   
   ?>
   <script>
    opener.document.form1.<?php echo $_POST["nombrecampo"]; ?>.value="<?php echo $nombre_archivo; ?>";
	self.close(); 
   </script>
   
   
   <?php 
}
else
{?>

<form action="gestionimagenproducto.php" method="post" enctype="multipart/form-data" id="form1" name="form1">

<input name="userfile" type="file" />

<input  type="submit" name="button" id="button" value="Insertar" />
<input name="nombrecampo" type="hidden" value="<?php echo $_GET["campo"]; ?>" />
<input  type="hidden" name="enviado" value="form1" />

</form>
<?php }?>
</body>
</html>
