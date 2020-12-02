<?php  //Envio a 2  correos 
header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL);
require("../class/Carrito.class.php");
require("../intranet/class/functions.php");
require("../intranet/class/class.bd.php"); 
require("../intranet/class/PHPPaging.lib.php");

$url_completa = url_completa();
$url = 'http://'.$_SERVER['SERVER_NAME'].'/'.( ($_SERVER['SERVER_NAME'] == 'localhost') ? 'mori/tuweb7/naynut/' : '' ); 

if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){
  $_POST["id_suscrito"]=$_SESSION["suscritos"]["id_suscrito"] ;
  $email= $_SESSION["suscritos"]["email"];
  $carrito = new Carrito();
	$_POST["subtotal"] = $carrito->precio_total();
	$_POST["articulos"] = $carrito->articulos_total();
  $_POST['fecha_registro'] = fecha_hora(2);
//Generando - Cod venta
$end_venta=executesql("select * from pedidos order by orden desc limit 0,1");
// "CH".1000000.1=> sumar el ultimo valor o count mejor dicho  y sumarle 1 , luegio sumarlo con los 100000 y concatenar y listo guardar .. 
if(!empty($end_venta)){
  $ultima_venta=$end_venta[0]["id_pedido"]+1;  
}else{
  $ultima_venta=1;  
}
IF($ultima_venta<10){
  $_POST["codigo"]= "NN000".$ultima_venta;
}ELSE IF($ultima_venta<100){
  $_POST["codigo"]= "NN00".$ultima_venta;
}ELSE IF($ultima_venta<1000){
  $_POST["codigo"]= "NN0".$ultima_venta;
}ELSE IF($ultima_venta<10000){
  $_POST["codigo"]= "NN".$ultima_venta;
}

//name client
$nclient=executesql("select * from suscritos where id_suscrito='".$_POST["id_suscrito"]."'");
$nombre_suscritos=$nclient[0]["nombre"];
     
//Preparamos el mensaje de contacto
  $email_venta="ventas@naynut.com";
  //para Chiclayo Import
  $cabeceras  = "From: Pedidos Naynut <$email> \n" . "Reply-To: $email\n";
  $cabeceras .= 'MIME-Version: 1.0' . "\r\n";
  $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $email_to =$email_venta;
//para clietne
  $cabeceras_cli  = "From: Ventas Naynut- Naturalmente Nutritivo <$email_venta> \n" . "Reply-To: $email_venta\n";
  $cabeceras_cli .= 'MIME-Version: 1.0' . "\r\n";
  $cabeceras_cli .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $email_to_cli = "$email";//para suscritos
  
  //cuerpo mensaje
  $asunto     =  'Naynut- Naturalmente Nutritivo, tiene un  nuevo pedido';
  $contenido  = "<p> Estimado(a) ".$nombre_suscritos." Naynut- Naturalmente Nutritivo, le hace llegar el detalle de su pedido (<strong>Cod. de Pedido:</strong>".$_POST["codigo"]."): <br></br><br></br> "; 
  if($carrito->get_content()){//detalle del pedido
    foreach($carrito->get_content() as $row){ //recorro carrito
      $nproduct=executesql("select * from productos where id_producto='".$row['id']."'");
      $contenido.=""      
      ."* ".$nproduct[0]["titulo"]."<br></br> "
      ."cantidad=".$row['cantidad']."<br></br> "
      ."precio=".$row['precio']."<br></br> " 
      ."subtotal=".$row['precio']*$row['cantidad']."<br></br> <br></br> "; 
    }
  }
  
  $contenido.=""
  . " <br></br> "
  . " Numero de Articulos: ".$_POST["articulos"]."<br></br> "
  . " -------------------------- <br></br> "
  . " SubTotal: ".$_POST["subtotal"]." <br></br> "
  . " --------------------------<br></br><br> "
  . " Monto Total: ".$_POST["total"]." <br></br>"
  . " -------------------------- <br></br></br></br></br> "
  . " *******- Monto a depositar: <strong>S/".$_POST["total"]."</strong> -******* <br> "
  . " Confirmar pago mediante correo o</br> al WhatsApp: <strong>+51 945 360 531</strong><br> "
  . " ******************************************<br></br></br></br> "
  . " Direcci&oacute;n de envio: ".$_POST["direccion"]." <br></br> "
  . " Comentario: ".$_POST["comentario"]." <br></br><br></br> "
  . " Gracias por realizar su pedido mediante nuestro portal <a href='http://www.naynut.com' target='_blank'>Naynut.com </a></br>"
  . "</p>";
 

//Registramos BD
	if($carrito->get_content()){
      // echo var_dump( $carrito->get_content() );
      // exit();
      $bd=new BD;      
// *Add PEDidos
      $_POST['orden'] = _orden_noticia("","pedidos","");
      $_POST['estado_idestado']='1';
      $campos_pedido=array('id_suscrito','codigo','total','subtotal','articulos','direccion','comentario','estado_idestado','fecha_registro','orden');
      $_POST['id_pedido']=$bd->inserta_(arma_insert("pedidos",$campos_pedido,"POST"));       
//Detalle Pedido
       foreach($carrito->get_content() as $row){ //recorro carrito
            $_POST['orden'] = _orden_noticia("","linea_pedido","");
            $_POST['id_producto']=  $row['id']; 
            $_POST['cantidad']=  $row['cantidad']; 
            $_POST['precio']=  $row['precio']; 
            $_POST['subtotal']=  $row['precio']*$row['cantidad']; 
            $campos_detalle=array('id_pedido','id_producto','cantidad','precio','subtotal','orden','estado_idestado'); 
            $bd->inserta_(arma_insert("linea_pedido",$campos_detalle,"POST"));
        }
// Endd linea_pedido
      $bd->close();
    }// if $carrito
    unset($_SESSION["carrito"]);//despues de todo el proceso reinicio el carrito
    
//Enviamos el mensaje y comprobamos el resultado
?>
  <script type='text/javascript'>
<?php
  if(@mail($email_to_cli, $asunto, $contenido, $cabeceras_cli)){//envio para cliente msj
  }
  if(@mail($email_to, $asunto, $contenido, $cabeceras)){
    echo "alert('Gracias por realizar su pedido con Codigo: ".$_POST["codigo"]."');document.location=('".$url."');";  
  }else{ //error
    echo "alert('*Gracias por realizar su pedido con Codigo: ".$_POST["codigo"]."');document.location=('".$url."');";  
  }
?>
  </script> 
  
  
<?php } else{  // si no existe sesion deusuario ?>
<script type='text/javascript'>
<?php   echo "alert('Inicie sesion para poder comprar');document.location=('".$url."');"; ?>
</script>
<?php }  ?>
