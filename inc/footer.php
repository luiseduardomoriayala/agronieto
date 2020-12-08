
<div class="ocultarwsp">
  <a style="position: absolute;bottom:0;z-index:999;width:50%;letter-spacing:1px;font-size:15px;text-align:center;background:#49CD60;padding:10px;margin:6px 0 0;color:white;" href="https://api.whatsapp.com/send?phone=51950918773&text=<?php echo $texto_cambiado;?>" target="_blank"><strong>WHATSAPP</strong></a>
  <a style="position:absolute;bottom:0;left:50%;z-index:999;letter-spacing:1px;font-size:15px;text-align:center;width:50%;background:#1ea7dd;padding:10px;color:white;margin:6px 0 0;" href="tel:+51950918773"><strong>LLAMAR</strong></a>
</div>

<footer class="salsa">
	<div class="row large-text-left  text-center ">
	<!-- 
		<div class=" large-3 medium-3 columns text-center ">
      <a href="<?php echo $url;?>"><img src="img/iconos/logo-fo.png" style="padding-bottom:15px;"><p class="em">"Naturalmente Nutritivo"</p></a>
		</div>	
		-->
    <div class="mi-altura large-3 medium-3 columns p-top">      
			
      <p class="osans dire">	<b>Ubícanos:</b></br>
				Sede principal:  </br> Tahuantinsuyo 1036 Chiclayo, JLO </br> </br>
				Sucursal: </br> AV. Luiz Gonzales 1599, Urb. San Luis, Chiclayo, Chiclayo </p>
		</div>	

    <div class="mi-altura large-3 medium-3 columns p-top">      
      <img src="img/iconos/delivery-fo.png" style="padding-bottom:8px;">
      <p class="osans dire">Envios a todo el Perú. </br>Estamos en Chiclayo</p>
		</div>	
		
		<div class="mi-altura large-4 medium-4 columns p-top">
      <p>Contáctanos:</br></p>
      <p class="bold"><img src="img/iconos/cel_movi.png" style="padding-right:7px;">+51 950918773</p>      
      <p class="bold"><img src="img/iconos/was.png" style="padding-right:7px;">+51 950918773</p>      
      <p><a href="mailto: nietocomercio@hotmail.com" target="_blank"><span class="color-2 bold"> nietocomercio@hotmail.com </br>  agroforestalnieto2019@gmail.com</span></a></p>
		</div>
		<div class="mi-altura large-2 medium-2 sociales columns p-top">
      <a href="blog"><p class="osans">* Blog</p></a>
      <span style="font-size:14px;display:block;padding-bottom:10px;">Síguenos en:</span>
      <li><a href="https://www.facebook.com/agroforestalnietoeirl/" target="_blank"><img src="img/iconos/fb.png"></a></li>
<!--         
			 <li><a href="" target="_blank"><img src="img/iconos/you.png"></a></li>
				<li><a href="https://www.linkedin.com/company-beta/24930765/" target="_blank"><img src="img/iconos/in.png"></a></li>
-->
		</div>
	</div>      
	<div class="creditos"><div class="row">
    <div class="large-12 medium-12 columns">
      <span class="float-left" style=""> © 2021 Agroforestal Nieto. Todos los derechos reservados.</span>
      <span class="float-right" style=""> Desarrollo: <a  class="" href="https://www.tuweb7.com" target="_blank"><img src="img/iconos/by.png"></a></span>
    </div>	
  </div></div>
</footer>
<p id="back-top"><a href="#top"><span></span></a></p>
	
<script src="js/vendor/jquery.min.js"></script>
<script src="js/foundation.min.js"></script>
<script>$(document).foundation();</script>
<script src="js/vendor/rem.min.js"></script>
<script src="js/vendor/lightslider/lightslider.js"></script>
<script src="js/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  if($('#ventana-emergente-1').length){
    $.magnificPopup.open({ items:{ src:'#ventana-emergente-1',type:'inline' },closeOnBgClick:false,enableEscapeKey:false,fixedContentPos:true,callbacks: {
    beforeOpen:function(){ $('html').addClass('mfp-helper'); }, close:function(){ $('html').removeClass('mfp-helper'); } } });
    $('#ventana-emergente-1').find('a:not(.redireccionamiento)').on('click',function(){
      var el = $(this);
          el.parent().find('.formulario').show();
          el.remove();
    });
    $('#ventana-emergente-1').find('.mfp-close').on('click',function(){ $.magnificPopup.close(); });
  }
});
</script>
<script src="js/vendor/jquery.validate.min.js"></script>
<script src="js/jquery.validate.terratech.js"></script>
<script src="js/functions.js?ud=<?php echo $unix_date; ?>"></script>
<script src="js/wow.min.js"></script>
<script>new WOW().init();</script>
<script src="js/main.js?ud=<?php echo $unix_date; ?>"></script>    
</body>
</html>