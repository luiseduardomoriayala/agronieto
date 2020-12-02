<?php 
include('auten.php');
require("intranet/class/class.upload.php"); 
  $bd= new BD;
  $campos=array("nombre",'dni','ruc',"empresa","referencia","direccion","telefono");
	if(!empty($_POST["clave"])){ $campos=array_merge($campos,array("clave"));}
	$dir='intranet/files/images/suscritos/';
	if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
		$path = $dir.$_POST['imagen_ant'];
		if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
		$_POST['imagen'] = carga_imagen($dir,'imagen','');
		$campos = array_merge($campos,array('imagen'));
	}
	$bd->actualiza_(armaupdate("suscritos",$campos," id_suscrito='".$_POST["id"]."'",'POST'));//update 
  $bd->close();
?>
<script>  
  <?php echo "document.location=('".$_POST["url"]."');"; ?>
</script>  

