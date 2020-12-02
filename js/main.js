$(document).ready(function(){
  // Lightslider
  var customSlider = { item:1, speed:400, slideMargin:0, auto:true, loop:true, pager:false, pause:4000};
  if($('#carousel-1').length){
    var s1 = $('#carousel-1');
      customSlider['controls'] = false;  
      customSlider['pager'] = true;
      customSlider['onBeforeStart'] = function(){ s1.removeClass('hide').closest('.banners').find('.esperando-slider').remove(); };
      s1.lightSlider(customSlider);
  }
  customSlider['controls'] = true;  
  customSlider['pager'] = false;

  if($('.carousel-3').length){
    var sp = $('.carousel-3');
        customSlider['item']     = 4;
        customSlider['pause']     =3000;
        customSlider['controls'] = true;
        customSlider['onBeforeStart'] = function(){ sp.removeClass('hide'); };
        customSlider['responsive']    = [ { breakpoint:1440, settings:{ item:4, slideMargin:0 } },
                                  { breakpoint:935, settings:{ item:3, slideMargin:0 } }, 
                                  { breakpoint:600, settings:{ item:2, slideMargin:0 } } ,
                                  { breakpoint:390, settings:{ item:1, slideMargin:0 } } 
                                ];
        sp.lightSlider(customSlider);
  }
	
  customSlider['pause']     = 8000;

//registro 
if($('#registro_suscrito').length){
  var frm2 = $('#registro_suscrito');
    frm2.customPlugin({ 
      rules:{ 
        email :{ remote:{ url:'index.php?task=valida_email', type:'post', data:{envio_usuario:function(){ return $('#email').val();}} }},
        // telefono :{ minlength:6 },
        dni    : { minlength:8,maxlength:8},
        ruc    : { minlength:11,maxlength:11 },
        clave    : { minlength:8  },
        clave2   : { equalTo:'#clave'}
      },
      messages :{ 
        email    : { remote:'ya existe correo'  },
        dni    : { minlength:'Mínino 8 caracteres',maxlength:'Ingrese no mas de 8 caracteres'  },
        ruc    : { minlength:'Mínino 11 caracteres',maxlength:'Ingrese no mas de 11 caracteres'  },
        clave    : { minlength:'Mínino 8 caracteres'},
        clave2   : { equalTo:'Contraseñas no coinciden.'}
      },
  // mode_form : 2,
      prex_msg  : 'registro',
      val_action: 'registro', 
      gotourl   : 'productos', 
      url       : 'btn_registro_suscrito.php'
    }).data('customPlugin').validate();
}

// Recuperar contraseña  
if($('#frm4').length){
  var frm4 = $('#frm4');
      frm4.customPlugin({
        rules      : { user: { required:true, email:true } },
        prex_msg  : 'recovery',
        val_action: 'recovery',
        gotourl   : '' 
      }).data('customPlugin').validate();
}
var nrecover=1;
$(document).on("click", ".recover", function(e){
  e.preventDefault();
  nrecover++;
  if(nrecover==2){$('#reg_suscrito').find('.recover-passwd').removeClass('hide');
  }else{$('#reg_suscrito').find('.recover-passwd').addClass('hide');nrecover=1;}  
});
  
	// Mapa Google
if($('.googlemaps').length){
  $('.googlemaps').each(function() {
    var el = $(this), miData = el.data('position'),
        latitude    = miData['lat'], longitude = miData['lng'],
        mapMarkers  = { 'markers': [ { 'latitude' : latitude, 'longitude' : longitude } ] };
        el.mapmarker({
          zoom:17, center:latitude+','+longitude, dragging:1, mousewheel:0, markers:mapMarkers, featureType:'all', visibility:'on', elementType:'geometry'
        });
  });
}//ultimo mapa2017
  
// Magnific Popup
if($('.mpopup-01').length){ $('.mpopup-01').magnificPopup({ type : 'image', delegate : 'a', gallery : { enabled:true } }); } 
if($('.mpopup-02').length){ $('.mpopup-02').magnificPopup({ type : 'iframe' }); } /* efecto ventana emergente ara video*/
$('.mpopup-03').magnificPopup({ type : 'ajax' });//emergente

// Listados
fn_listar_items('load-content',{frm:''});//para listar prensa sin formnulario
$('#frm_listado').on('submit',function(){ //para listar rutas cn formulario
  fn_listar_items('load-content',{texto:'<p class="text-center">Cargando resultados ... </p>'});
  return false;
});
  

if($('.banners').find('li.active').length){
  $('.large-6').addClass('wow bounceInUp');
}else{
  $('.large-6').removeClass('wow bounceInUp');  
}
 
//Llmando al menu en XL
var vm=1;  
$(document).on("click", ".llamar-menu-xl", function(e){
  e.preventDefault();
  vm++;
  if(vm==2){
    $('header').find('#menu_perfil').removeClass('hide');
  }else{ $('header').find('#menu_perfil').addClass('hide');vm=1;}
});  

  //Favoritos/Like Producto
$('.fav-des').addClass('hide');
$(document).on("click", ".favori-destino", function(e){
  e.preventDefault();
  var el = $(this);
  var str='', div = el.attr('id').split('_');//split divide separa por (-)
  if(div[0]=="producto"){
    str= '&id_producto='+div[1];//envio id al process ..
  }else{
		//añadir el new
	}
  
  if(el.find(".f-2").length){
    str=str+"&pintado=yes";
  }
  //show msj add
  el.find('.fav-des').removeClass('hide');
  setTimeout(function(){ el.find('.fav-des').addClass('hide'); },2000);//msj desparece en 5seg.  
  //++like
  $.ajax({url:'process_cart/insert_like_favoritos.php',data:str,type:'post',success:function(data){
    var json = JSON.parse(data);
    el.find('.megusta').find('p').text(json.rpta);
    el.find('.fav-des').find('p').text(json.msj);
    //cambio icono  
    el.find('.megusta').find('span').removeClass(json.quitar);  
    el.find('.megusta').find('span').addClass(json.add); 
    //nro de favoritos x suscrito
    $(".carga_favoritos").find(".nro_product").find("span").html(json.nro_product);
    $(".carga_favoritos").find(".nro_pedidos").find("span").html(json.nro_pedidos);
  }});     
});

  
 // para añadir al carrito ..
$(".add").on("submit", function(e){
e.preventDefault();
var el = $(this) , div = el.attr('id').split('-') , envioid =div[1];//split divide separa por (-)
  $.ajax({
    type: $(this).attr("method"),
        url: $(this).attr("action"),
        data: $(this).serialize(),
        beforeSend: function(){ },
        success: function(data){
          var json = JSON.parse(data);
          if(json.res == "ok"){ 
            content_cart();
            carrito_boton(envioid);
            // precio_total();//Carrito precio total
          }else{  alert(json.message); }	
        },
        
        error: function(){alert("Error"); }
  })
});
  
//función para vaciar el contenido del carrito
$(document).on("click", ".destroy", function(e){
  e.preventDefault();
  $.post("process_cart/destroy.php", function(){
    //llamamos a la función content_cart() para actualizar el carrito
    content_cart();
    carrito_boton();
    // precio_total();//Carrito precio total
  });
})

  
// ########################
// BACK TO TOP FUNCTION
// ########################
  
// fade in #back-top

$(window).scroll(function(){
  if($(this).scrollTop() > 700){
    $('#back-top').fadeIn();
  }else{
    $('#back-top').fadeOut();
  }
});
// scroll body to 0px on click
$('#back-top a').click(function(){
  $('body,html').animate({ scrollTop:0 }, 500);
  return false;
});
// scroll body to 0px on click
$('#goto a').click(function(){
  $('body,html').animate({ scrollTop:600 }, 500);
  return false;
});
$(".scroll").click(function(event){		
  event.preventDefault();
  $('html,body').animate({scrollTop:$(this.hash).offset().top - 35}, 500);
});		

$(window).scroll(function(){
  posicionarMenu();
});  
    
// Menú
main(); 
load_likes();
content_cart(); //el abrir la página ya mostramos el contenido del carrito
carrito_boton(); //Carrito botones
// precio_total();//Carrito precio total
     
});


/*para submenu*/
var contador = 1;
function main() {
  var menu_bar  = $('.menu_bar'),
      submenu   = $('.submenu');
      menu_bar.find('a').on('click',function(e){ /*va a*/
        var contentwidth = $(window).width();
        if(contentwidth <= 864){
          contador = (contador == 1) ? 0 : 1;
          $(this).parent().next().toggleClass('hide');
          e.preventDefault();
        }
      });
      submenu.find('> a').on('click',function(e){/*en find va el q contene el submenu */
        var contentwidth = $(window).width();
        if(contentwidth <= 864){
          var mysubmenu  = $(this).parent();
              mychildren = mysubmenu.find('> .children');
              mychildren.slideToggle(); 
          e.preventDefault();
        }
      });
      $(window).on('mouseleave',function(){
        var contentwidth = $(window).width();
        if(contentwidth > 865){
          submenu.find('.children').removeAttr('style');
          contador = 1;
          $('nav').removeAttr('style');
        }
      });
}