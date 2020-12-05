<?php include("auten.php");
//Importamos las variables del formulario de contacto
@$nombre    = utf8_decode(addslashes($_POST['nombre']));
@$telefono  = utf8_decode(addslashes($_POST['telefono']));
@$ciudad  = utf8_decode(addslashes($_POST['ciudad']));
@$asunto  = utf8_decode(addslashes($_POST['asunto']));
@$email     = utf8_decode(addslashes($_POST['correo']));
@$mensaje   = utf8_decode(addslashes($_POST['comments']));
 
//Preparamos el mensaje de contacto
$cabeceras  = "From: Mensaje desde la web. AgroNieto <$email> \n" //La persona que envia el correo
 . "Reply-To: $email\n";
$cabeceras .= 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
$email_to   = "ventas@agronieto.com"; 
$contenido  = "<p>$nombre ha enviado un mensaje desde la web </p>"
. "<p>"
. "Nombre: ".$nombre."<br />"
. "Email: ".$email."<br />"
. "Ciudad: ".$ciudad."<br />"
. ( !empty($telefono) ? "Tel&eacute;fono: ".$telefono."<br />" : '' )
. "Asunto: ".$asunto."<br /><br />"
. "Mensaje:<br />".$mensaje
. "</p>";
//Enviamos el mensaje y comprobamos el resultado
?>
<script type='text/javascript'>
<?php
if(@mail($email_to, $asunto, $contenido, $cabeceras)){
	echo "alert('Gracias, su mensaje fue enviado correctamente.');document.location=('".$_SESSION["url"]."');";
}else{
	echo "alert('Error: Su informaci\u00F3n no pudo ser enviada, intente m\u00E1s tarde.');document.location=('".$_SESSION["url"]."');";
}
?>
</script>