<?php include('auten.php');
if(!isset($_SESSION["suscritos"]["id_suscrito"]) && empty($_SESSION["suscritos"]["id_suscrito"])){ 
$_SESSION["url"]=url_completa();$pagina="registro";
$meta= array(
'title' =>'Únete a Naynut, Naturalmente nutritivo',
'keywords' =>'',
'description' =>'',
'img'=>'');
include('inc/header.php'); ?>
<main id="reg_suscrito" class="margin-interno">
<div class="callout-f"><div class="row">
  <h5 class="amatic bold blanco text-center">Regístrate y empieza a comprar :)</h5>
</div></div>  
<div class="callout callout-2"><div class="row">
  <div class="large-6 medium-6 columns pbot"><div class="fondi">
  <blockquote class="amatic bold color-1">Formulario de registro:</blockquote>
  <form id="registro_suscrito" action="btn_registro_suscrito" method="post" enctype="multipart/form-data" autocomplete="off"><fieldset>      
    <div class="row">
      <div class="large-12 columns">
        <input type="text" required name="nombre" placeholder="Nombre y Apellidos">
      </div>
      <div class="large-6 medium-6 columns">
        <input id="dni" onkeypress='javascript:return soloNumeros(event,0);' maxlength="8" type="text" name="dni" required placeholder="DNI">
      </div>
      <div class="large-6 medium-6 columns">
        <input id="ruc" onkeypress='javascript:return soloNumeros(event,0);' maxlength="11" type="text" name="ruc" placeholder="RUC">
      </div>
      <div class="large-12 columns">
        <input  type="text" onkeypress='javascript:return soloNumeros(event,0);' placeholder="Celular o Teléfono Fijo"  name="telefono">
        <input id="empresa" type="text" name="empresa" placeholder="Nombre de Empresa">
        <input id="direccion" type="text" name="direccion" required placeholder="Dirección">
        <input id="email" type="email" name="email" placeholder=" Correo electrónico">
        <input id="clave" type="password" name="clave" required placeholder="Contraseña">
        <input id="clave2" type="password" name="clave2" required placeholder="Confirmar Contraseña">
        <button class="gulimn hvr-bounce-in botones">Registrar</button>
      </div>
    </div>
    <div class="hide" id="registroInfo" >Procesando ...</div>
    <div class="hide" id="registroSuccess" >Gracias por registrarte.</div>
    <div class="hide" id="registroError" >Lo sentimos se perdio la conexion con el servidor ...</div>
    <div class="hide" id="registroYaexiste">Correo de Usuario ya registrado...</div> 

  </fieldset></form>
  </div></div>
  <div class="large-6 medium-6 columns text-left pbot">
    <img src="img/productos.png" style="padding-bottom:25px;">
     <h3 class="color-1 amatic bold">Beneficios de consumir frutas deshidratadas:</h3>
<p class="rel"><span></span>Son especialmente ricas en fibra y potasio.</p>
<p class="rel"><span></span>Intervienen en la prevención de las enfermedades cardiovasculares y el cáncer.</p>
<p class="rel"><span></span>Ideales para deportistas que buscan recuperarse después de un esfuerzo muy intenso.</p>
<p class="rel"><span></span>Son una excelente fuente de energía gracias a su alto contenido en hidratos de carbono simples, que destacan por aportar energía rápidamente.</p>
<p class="rel"><span></span>Son ideales en caso de anemia, en especial cuando se consumen junto con alimentos ricos en vitamina C, principalmente porque esta vitamina ayuda a mejorar la absorción del hierro.</p>
  </div>
</div></div>
</main> 
<?php include("inc/footer.php");
}else{ header('Location:'.$url.'');exit(); } ?>