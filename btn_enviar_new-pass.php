<?php error_reporting(E_ALL);
session_start();
include_once("intranet/class/functions.php");
include_once("intranet/class/class.bd.php");

$_POST['action'] = isset($_POST['action']) ? $_POST['action'] : '';
$rpta  = 2;
if($_POST['action']=='recovery'){
  $exsql =executesql("select * from suscritos where email='".$_POST["user-pass"]."' and estado_idestado=1");
  if(!empty($exsql)){
    $_POST["clave"] = auto_codigo('',$exsql[0]['email']);    
    @$email     = utf8_decode(addslashes($_POST['user-pass']));
    $mi_email="info@naynut.com";
    //Preparamos el mensaje hacia la web 
    $cabeceras  = "From: NAYNUT Naturalmente Nutritivo. <$mi_email> \n"
     . "Reply-To: $mi_email\n";
    $cabeceras .= 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $asunto     = "Recuperación de contraseña."; 
    $email_to   = $email;
    $contenido  = "
  <div style='max-width:795px;margin:0 auto;padding:15px 15px 70px;'>  
    <div style='padding:25px 0;position:relative;'>
      <img src='http://naynut.com/img/logo-email.png' style='display:inline-block;'>
      <p style='font-size:30px;line-height:20px;letter-spacing:0;text-align:center;color:#00226D;margin:0.4rem 0.5rem;padding-left:20px;display:inline-block;top:35%;font-weight:bold;position:absolute;'>
        HOLA AMIGO, BUEN D&Iacute;A! <br />
        <span style='font-size:25px;color:#D79200;font-weight:100;'>Bienvenido a nuestra comunidad.</span>
      </p> 
    </div>
    <p style='font-size:18px;line-height:24px;text-align:left;color:#333;padding:0 35px;'><strong>".$exsql[0]['nombre']." </strong> tu <strong>nueva contraseña</strong> es: ".$_POST['clave']."<br />
    Puedes empezar a navegar por nuestra web, y conocer nuestra variedad de productos naturalmente nutritivos.<br /><br />
    Ya puedes realizar tus pedidos. Para disfrutar de todo esto: <br />
    Inicia Sesión con ".$email."
    </p>
    <center>
      <a href='http://www.naynut.com/productos' target='_blank' 
        style='text-decoration:none;background:#D79200;padding:12px;text-align:center;
                color: #fff;
                font-size:25px;
                width: 300px; MARGIN-TOP: 50px;
                display: block;'>
          Comprar ahora<br />
      </a> 
    </center>
  </div>
    ";   
    if(@mail($email_to, $asunto, $contenido, $cabeceras)){$rpta =1;}   
    if($rpta == 1){
      $bd=new BD;
      $campos=array('clave');
      $bd->actualiza_(armaupdate('suscritos',$campos," email='".$_POST["user-pass"]."'",'POST'));
      $bd->close();
    }    
  }
}
echo json_encode(array('rpta' => $rpta, 'link_go' => $_POST["link_go"] ));
?>
