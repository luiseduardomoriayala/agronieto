<?php error_reporting(0);
session_start();
include_once("intranet/class/functions.php");
include_once("intranet/class/class.bd.php"); 
include_once("intranet/class/PHPPaging.lib.php");
$url_completa = url_completa();
$url = 'http://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? '/mori/tuweb7/w2020/agronieto/' : '/agronieto/' ); 

$dir="intranet/files/images/productos/";
$dir2="intranet/files/files/productos/";

/*Whats - Llamar*/
/*Whats - Llamar*/
$num_cel='51945250434';
$num_wsp='51945250434';

$host3=$_SERVER["HTTP_HOST"];$url3=$_SERVER["REQUEST_URI"];
$fin='http://'.$host3.$url3;
$texinfo = 'Hola, me interesa este producto que vi en la web de Agronieto.com. '.$fin;
$texto_cambiado = str_replace(" ", "%20", $texinfo); 

if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ //ide_suscrito	&& img_perfil
	$ide_suscrito=$_SESSION["suscritos"]["id_suscrito"];
	$perfil=executesql("select * from suscritos where id_suscrito=".$ide_suscrito." ");
	$image_perfil=!empty($perfil[0]["imagen"])?'intranet/files/images/suscritos/'.$perfil[0]["imagen"]:'img/ico-perfil.png';
} 
 
if(isset($_GET["task"]) && !empty($_GET["task"])){ 
  if($_GET["task"] == "valida_email"){ //registro crear clientes ..main.js
    $consultando=executesql("select * from suscritos where email='".$_POST["envio_usuario"]."'");
    echo !empty($consultando) ? 'false' : 'true';
    exit();
  }
  if($_GET["task"] == "cerrar_sesion" ){
    unset($_SESSION["suscritos"]);
    header('Location:'.$_SESSION["url"].'');
    exit();
  } //cerrando sesion  
}

$not_img="img/iconos/no-disponible.jpg";
?>