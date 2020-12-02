<?php include 'auten.php'; $pagina="productos";
$_SESSION["url"]=url_completa();
include('inc/header.php'); ?>
<main id="cesta" class="margin-interno">
<div class="callout-f"><div class="row">
<h5 class="amatic bold blanco">Cesta de pedidos</h5>
</div></div>
<div class="callout-1 color-1"><div class="row">
  <div  class="large-6 medium-6 columns padtop">    
    <div  class="content_cart panel radius"></div>
  </div>
  <div  class="large-1  medium-1 columns"></div>
  <div  class="large-5 bancos medium-5 columns">
    <p class="osans texto">Puede realizar tus pagos en la siguiente cuenta:</p>
    <p class="banco rel texto"><img src="img/bbva2.png" class="abs">CUENTA CORRIENTE - SOLES</BR> 
      <strong>0011-02870200252146</strong></br>Titular: <strong>C&P Alimentos Saludables EIRL</strong>
    </p>
    <!--
    <p class="banco rel texto"><img src="img/banco_nacion.png" class="abs">CUENTA DE AHORRO BANCO DE LA NACIÓN - SOLES      </BR> 
      <strong>042 - 50353575</strong></br>Cuenta a nombre de Michito Reyes Izquierdo.
    </p>
    -->
    <p style="border-bottom:2px dotted #ccc;"></p>
    <p class="osans" style='padding-top:10px;'><strong CLASS="rojo">IMPORTANTE:</strong> Luego de realizar el pago, deben proceder a confirmarlo, enviando el codigo de la compra y la imagen del voucher, mediante:</p>
    <div>
      <p class="medios">WhatsApp </br>
        <span class="gulim bold" style="letter-spacing:1px;">945360531</span><img src="img/iconos/was_verde.png">
      </p>
      <p class="medios" style="margin:15px;border-left:1px solid #bbb;height:82px;padding:0;"></p>
      <p class="medios">Correo:</br><span class="gulim bold">ventas@naynut.com</span></p>
    </div>
  </div>
</div></div>
</main> 
<?php include('inc/footer.php'); ?>