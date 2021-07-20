<?php require_once('../Connections/sistemapacgrafica.php'); 






/* 
Servidor: aquí debe poner la dirección de su servidor, en la mayoría de las compañías es 'localhost' 
Nombre_de_usuario: debe pone su nombre de usuario en el servidor. 
Contraseña: su contraseña. 
*/ 

   mysql_select_db('pacgrafi_cacumen',$sistemapacgrafica); 

/* 
Base_de_datos: nombre de su base de datos. 
*/ 

   $query_Tabla = "SELECT email FROM usuarios ORDER BY Id_usuario ASC"; 
   $Tabla = mysql_query($query_Tabla, $sistemapacgrafica) or die(mysql_error()); 

/* 
Email: es el nombre del campo que requerimos, si ha seguido nuestras instrucciones creando nuestra misma tabla en la base de datos no debe cambiar esto. 
Usuarios: es el nombre de la tabla donde está el campo 'email', si ha seguido nuestras instrucciones creando nuestra misma tabla en base de datos no debe cambiar esto. 
*/ 

   //elaboramos cadena de emails 
  $losemails=""; 
  while ($row_Tabla=mysql_fetch_assoc($Tabla)) { 
   $losemails.=($row_Tabla['email'].", "); 
   } 

  $largo=strlen($losemails); 
   if ($largo>2) 
{ 
   //quitamos ultimos ", " 
   $losemails=substr($losemails,0,$largo-2); 
} 
else 
{ 
   echo "No hay destinatarios!"; 
   die(); 
}; 

// se definen los argumentos de mail( ): 
$asunto='Tienes una Nueva Tarea'; 
$mensaje='<html> 
<head> 
   <title>Boletines informativos cacumen</title> 
</head> 
<body> 
   <p>Tienes una Nueva Tarea</p> 
   
   
    <img id="image" src="http://pacgrafica.com/cacumen/images/pacSaluda.gif" class="image" />
   
   <a href="http://pacgrafica.com/cacumen">Ingresar a Cacumen</a>
</body> 
</html>'; 
/* 
Aquí debe poner su email en formato HTML 
*/ 

$envia='compusoftware47@gmail.com'; 
$remite='contacto@pacgrafica.com,publicidad@pacgrafica.com'; 

/* 
Enviante: Nombre del enviante 
Email_remitente: email que desea mostrar como remitente. 
*/ 

/// Envío del email: 

mail(null, $asunto, $mensaje, "MIME-Version: 1.0 
Content-type: text/html; charset=iso-8859-1 
From: $envia <$remite> 
Bcc: $losemails" . "\r\n") or die("Error al Enviar el Email"); 
echo "<script language='javascript'>
alert('Nueva Tarea Registrada.');
window.location.href = 'http://pacgrafica.com/cacumen/pages/lista_tareas.php';
</script>";
 // 

   mysql_free_result($Tabla); 
   mysql_close($sistemapacgrafica); 


?>
