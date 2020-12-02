<?php $unix_date = strtotime(date('Y-m-d H:i:s'));include("auten.php");?>
<main id="reg_suscrito"><div class="callout callout-1 sesion"><div class="row"><div class="large-12 columns">
  <ul class="accordion" data-responsive-accordion-tabs="tabs medium-tabs large-tabs">
<li class="accordion-item is-active" data-accordion-item>
  <a href="#" class="accordion-title" oncontextmenu='return false' onkeydown='return false'>INICIAR SESIÓN</a>
  <div class="accordion-content text-center" data-tab-content>
    <form id="frm_listado" method="post" enctype="multipart/form-data" autocomplete="OFF"><fieldset><div class="row"><div class="large-12 columns">
      <input type="email" name="email" required autocomplete="off" placeholder="Correo electrónico">
      <input type="password" name="clave" autocomplete="off" required placeholder="Contraseña">
      <button class="boton-1 botones gulim">Ingresar</button>	
    </div></div></fieldset></form>
    <div id="listado_iniciarsesion" class="load-content"><p class="text-center">Verificando los datos ...</p></div>
    <p class="gulim color-1 olvidaste"><a href="#" class="recover">¿Olvidaste tu contraseña?</a></p>
    <div class="hide recover-passwd">
      <form id="frm4" action="btn_enviar_new-pass" method="post" enctype="multipart/form-data">
        <fieldset>
          <label>Correo electr&oacute;nico <span>(*)</span></label>
          <input type="hidden" name="link_go" value="<?php echo $_SESSION["url"];?>">
          <div class="control"><input type="text" name="user-pass"></div>
          <button class="botones gulim boton-1">Recuperar Contrase&ntilde;a</button>
          <div class="callout primary hide" id="recoveryInfo">Procesando datos...</div>
          <div class="callout alert hide" id="recoveryError">No se logró recuperar su contraseña.<br />Espere unos momentos e inténtelo nuevamente.</div>
          <div class="callout success hide" id="recoverySuccess">Su nueva contraseña se ha enviado a su correo.</div>
        </fieldset>
      </form>
    </div>
    <p class="osans color-1 bold"><a href="registrate">¿Eres nuevo? Regístrate aquí</a></p>
  </div>
</li>
  </ul>
</div></div></div></main> 
<script src="js/foundation.min.js"></script>
<script>$(document).foundation();</script>
<script src="js/main.js?ud=<?php echo $unix_date; ?>"></script>  