<?php  include 'auten.php'; $pagina="contacto";
$_SESSION["url"]=url_completa();
$meta= array(
'title' =>'Contáctenos | Agroforestal Nieto ',
'keywords' =>'',
'description' =>''
);
 include('inc/header.php'); ?>
<main id="contacto" class="margin-interno">
<div class="callout banners"><div class="fondo fondo2 banner-contacto"></div></div>
<div class="callout-f"><div class="row">
  <h5 class="gulim bold blanco text-center">Contáctenos</h5>
</div></div>
<div class="callout callout-2 text-center"><div class="row">
  <div class="large-10 large-centered medium-10 medium-centered columns">
    <p class="osans">Si desea obtener más ventasrmación sobre nuestros productos, puede enviarnos un mensaje mediante nuestro formulario o mediante nuestros datos de contacto.</p>
    <div class="datos">
     <p class="osans"><span><img src="img/iconos/tele-con.png"></span>Llámanos </br> 950 918 773 - 946 877 484 </br></p>
     <p class="osans"><a href="mailto:nietocomercio@hotmail.com"><span><img src="img/iconos/correo-con.png"></span>nietocomercio@hotmail.com </br>  agroforestalnieto2019@gmail.com</a></p>
		 
		</div>
  </div>
  <div class="large-8 medium-8 columns text-left">
    <h3 class="gulim bold color-1">Formulario de contacto:</h3>
    <form  action="enviar.php" method="post" enctype="multipart/form-data">
      <fieldset>
        <div class="row">
          <div class="large-6 columns">
            <label class="osans">Nombre *:</label>
            <input type="text" required name="nombre">
          </div>
          <div class="large-6 columns">
            <label class="osans">Correo Electrónico * :</label>
            <input type="email" name="correo">
          </div>
          <div class="large-6 columns">
            <label class="osans">Telefono:</label>
            <input  type="text" maxlength="18" onkeypress='javascript:return soloNumeros(event,0);'  name="telefono">
          </div>
          <div class="large-6 columns">
            <label class="osans">Ciudad / País:</label>
            <input  type="text"  name="ciudad">
          </div>
          <div class="large-12 columns">
            <label class="osans">Asunto *:</label>
            <input  type="text"  name="asunto">
          </div>
        </div>
        <label class="osans">Mensaje *:</label>
        <textarea required name="comments"></textarea>
        <button class="btn botones osans"> Enviar</button>	
      </fieldset>
    </form>
  </div>
  <div class="large-4 medium-4 columns">
    <div class="fb-page" data-href="https://www.facebook.com/agroforestalnietoeirl//" data-tabs="timeline" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/agroforestalnietoeirl//" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/agroforestalnietoeirl//">Agroforestal Nieto </a></blockquote></div>
  </div>
</div>
</div>
</main> 
<?php include('inc/footer.php'); ?>