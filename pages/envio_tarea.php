<?php
$Nombre_tarea = $_POST['Nombre_tarea'];
$Descripcion_tarea = $_POST['Descripcion_tarea'];
$Nombre_Cliente = $_POST['Nombre_Cliente'];
$Email_cliente = $_POST['Email_cliente'];
$Telefono_cliente = $_POST['Telefono_cliente'];
$Total_cobrado = $_POST['Total_cobrado'];
$Total_Adelanto = $_POST['Total_Adelanto'];
$Fecha_llegada = $_POST['Fecha_llegada'];
$Fecha_Entrega = $_POST['Fecha_Entrega'];
$Usuario_tarea = $_POST['Usuario_tarea'];
$Estado_tarea = $_POST['Estado_tarea'];
$Observaciones_tarea = $_POST['Observaciones_tarea'];
$Usuario_modifico = $_POST['Usuario_modifico'];
$Urgencia_tarea = $_POST['Urgencia_tarea'];
$Estado_cliente = $_POST['Estado_cliente'];
$formcontent=" De: $Usuario_tarea \n Telefono: $Telefono_cliente \n Email: $Email_cliente \n Nombre Cliente: $Nombre_Cliente \n Total Cobrado: $Total_cobrado ";
$recipient = "publicidad@pacgrafica.com,compusoftware47@gmail.com,mariachicharrosbogota@gmail.com";
$subject = "Tienes una Nueva Tarea por Entregar";
$mailheader = "From: $email \r\n";
mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
  
if ($_POST['submit']) {
if (mail($para, $titulo, $msjCorreo, $header)) {
echo "<script language='javascript'>
alert('Mensaje Enviado, En Momentos Nos comunicaremos con Ud muchas gracias.');
window.location.href = 'http://mariachisdebogota.co/';
</script>";
} else {
echo 'Falló el envio';
}
}
?>