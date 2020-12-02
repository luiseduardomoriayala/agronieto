<?php error_reporting(E_ALL);
session_start();
include_once("intranet/class/functions.php");
include_once("intranet/class/class.bd.php"); 
include_once("intranet/class/PHPPaging.lib.php");
$url = 'http://'.$_SERVER['SERVER_NAME'].'/'.( ($_SERVER['SERVER_NAME'] == 'localhost') ? 'mori/tuweb7/naynut/' : 'beta/' ); 

$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/
if($_POST['action']=='registro'){ 

@$nombre    = utf8_decode(addslashes($_POST['nombre']));
@$dni     = utf8_decode(addslashes($_POST['dni']));
@$ruc     = utf8_decode(addslashes($_POST['ruc']));
@$telefono  = utf8_decode(addslashes($_POST['telefono']));
@$empresa     = utf8_decode(addslashes($_POST['empresa']));
@$direccion     = utf8_decode(addslashes($_POST['direccion']));
@$email     = utf8_decode(addslashes($_POST['email']));
$mi_email="info@naynut.com";


/*Para Empresa*/
$cabeceras_emp  = "From: NAYNUT Naturalmente Nutritivo <$mi_email> \n" 
. "Reply-To: $mi_email\n";
$cabeceras_emp .= 'MIME-Version: 1.0' . "\r\n";
$cabeceras_emp .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$asunto_emp     = "Nuevo Usuario Registrado-  NAYNUT Naturalmente Nutritivo."; 
$email_to_emp   = $mi_email;
$contenido_emp  = "
<p> Nuevo Usuario Registrado <br />
Nombre: ".$nombre."<br />
Dni: ".$dni."<br />
Ruc: ".$ruc."<br />
Telefono: ".$telefono."<br />
Empresa: ".$empresa."<br />
Direccion: ".$direccion."<br />
Email: ".$email."<br /><br /></p>
<p>* Recomendamos, que proceda a contartar con este nuevo usuario.</p>

";

/*Para Client*/
$cabeceras  = "From: NAYNUT Naturalmente Nutritivo <$mi_email> \n" 
. "Reply-To: $mi_email\n";
$cabeceras .= 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$asunto     = "Bienvenido a NAYNUT Naturalmente Nutritivo."; 
$email_to   = $email;
$contenido  = "
<div style='max-width:795px;margin:0 auto;padding:15px 15px 70px;'>  
	<div style='padding:25px 0;position:relative;'>
		<img src='http://www.naynut.com/img/logo-email.png' style='display:inline-block;'>
		<p style='font-size:30px;line-height:20px;letter-spacing:0;text-align:center;color:#1E3032;margin:0.4rem 0.5rem;padding-left:20px;display:inline-block;top:35%;font-weight:bold;position:absolute;'>
			HOLA AMIGO, BUEN D&Iacute;A! <br />
			<span style='font-size:25px;color:#A5C73F;font-weight:100;'>Bienvenido a nuestra comunidad.</span>
		</p> 
	</div>
	<p style='font-size:18px;line-height:24px;text-align:left;color:#333;padding:0 35px;'><strong>".$nombre." </strong> inicia sesi&oacute;n con los siguientes datos: </br> Usuario: ".$email." <br /> Contraseña: ".$_POST['clave']."<br />
	Puedes empezar a navegar por nuestra web, y conocer nuestra variedad de productos naturalmente nutritivos.<br /><br />
	Ya puedes realizar tus pedidos. Para disfrutar de todo esto: <br />
	Inicia Sesión con ".$email."
	</p>
	<center>
		<a href='http://www.naynut.com/productos' target='_blank' 
			style='text-decoration:none;background:#A5C73F;padding:12px;text-align:center;
							color: #fff;
							font-size:25px;
							width: 300px; MARGIN-TOP: 50px;
							display: block;'>
				Comprar ahora<br />
		</a> 
	</center>
</div>";

$bd = new BD;
$_POST["estado_idestado"]=1;
$_POST["fecha_registro"]=fecha_hora(2);
$_POST["orden"]=_orden_noticia("","suscritos","");
$campos=array("nombre","empresa","email","clave","telefono","dni","ruc","direccion","fecha_registro","orden","estado_idestado");

$_POST["id_suscrito"]=$insertado=$bd->inserta_(arma_insert("suscritos",$campos,"POST"));
$bd->close();
if($insertado > 0) $rpta = 1;
if($rpta == 1){
	$_SESSION["suscritos"]["id_suscrito"] = $_POST["id_suscrito"];
	$_SESSION["suscritos"]["email"] =  $_POST["email"];
	$_SESSION["suscritos"]["nombre"]=$_POST["nombre"];
	if(@mail($email_to, $asunto, $contenido, $cabeceras)){} 
	if(@mail($email_to_emp, $asunto_emp, $contenido_emp, $cabeceras_emp)){} 
}

}
echo json_encode(array('rpta' => $rpta));
?>