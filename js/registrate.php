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
  <h3 class="gulim bold blanco text-center">Regístrate</h3>
</div></div>  
<div class="callout callout-2 fondo"><div class="row">
  <div class="large-6 medium-6 columns pbot"><div class="fondi">
  <blockquote class="gulim bold color-1">Formulario de registro:</blockquote>
  <form id="registro_suscrito" method="post" enctype="multipart/form-data" autocomplete="off"><fieldset>      
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
        <input  type="text" onkeypress='javascript:return soloNumeros(event,0);' placeholder="Celular /Teléfono Fijo"  name="telefono">
        <input id="empresa" type="text" name="empresa" placeholder="Nombre de Empresa">
        <input id="direccion" type="text" name="direccion" required placeholder="Dirección">
        <input id="email" type="email" name="email" placeholder=" Correo electrónico">
        <input id="clave" type="password" name="clave" required placeholder="Contraseña">
        <input id="clave2" type="password" name="clave2" required placeholder="Confirmar Contraseña">
        <button class="gulim bold hvr-bounce-in botones">Registrar</button>
      </div>
    </div>
    <div class="hide" id="registroInfo" >Procesando ...</div>
    <div class="hide" id="registroSuccess" >Gracias por registrarte.</div>
    <div class="hide" id="registroError" >Lo sentimos se perdio la conexion con el servidor ...</div>
    <div class="hide" id="registroYaexiste">Correo de Usuario ya registrado...</div>
  </fieldset></form>
  </div></div>
  <div class="large-6 medium-6 columns text-left pbot">
    <blockquote class="color-1 bold gulim">Beneficios:</blockquote>
    <p class="osans rel">Naynut Naturalmente Nutritivo, Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas imperdiet, orci quis venenatis tristique, tellus lacus scelerisque risus, id tincidunt neque nulla eget nulla. Mauris vitae velit faucibus, eleifend nibh nec, lobortis urna. Sed gravida ornare neque, a pulvinar eros scelerisque sit amet. Aliquam porta vehicula nibh, a molestie tortor gravida vitae. Donec quis porta enim, non facilisis arcu. Sed convallis non quam at congue. Nunc vel dui sollicitudin, pellentesque arcu ut, fermentum mauris. Donec eu ultricies ante, sit amet vestibulum purus.</p>
  </div>
</div></div>
</main> 
<?php include("inc/footer.php");
}else{ header('Location:'.$url.'');exit(); } ?>