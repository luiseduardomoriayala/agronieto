<?php error_reporting(E_ALL);
if(!isset($_SESSION)){
session_start();
}
include_once("intranet/class/functions.php");
include_once("intranet/class/class.bd.php"); 
include_once("intranet/class/PHPPaging.lib.php");
if(!empty($_POST["email"])){
$existesuscritos=executesql("select * from suscritos where email='".$_POST["email"]."'");
if(!empty($existesuscritos)){
  $verificar=executesql("select * from suscritos  where email='".$_POST["email"]."'  and estado_idestado=1");
  if(!empty($verificar)){
    $iniciar=executesql("select * from suscritos  where email='".$_POST["email"]."' and  clave='".$_POST["clave"]."' and estado_idestado=1");
    if(!empty($iniciar)){
        $_SESSION["suscritos"]["id_suscrito"] = $iniciar[0]["id_suscrito"]; // se creo sesion del suscritos
        $_SESSION["suscritos"]["email"] = $iniciar[0]["email"];
        $_SESSION["suscritos"]["nombre"] = !empty($iniciar[0]["email"])?$iniciar[0]["nombre"]:$iniciar[0]["email"];
?>
<script type='text/javascript'>
<?php echo "document.location=('".$_SESSION["url"]."');";?>
</script>
<?php }else{ ?>
<p class="osans color-1 text-center">Error en contraseña. </p>
<?php   }//error contraseña
    }else{ ?>
<p class="osans color-1 text-center">Cliente fue Desabilitado</p>
<?php }// valida estado
}else{ ?>
<p id="desaparecer" class="osans color-1 text-center">Cliente no registrado ...</p>
<?php }// valida existencia
}else{  ?>
<p class="osans color-1 text-center"></p>
<?php }//si emal esta vacio  ?>
