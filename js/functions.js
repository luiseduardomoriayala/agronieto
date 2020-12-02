function randomNumber(min, max) {
  return Math.floor(Math.random() * (max - min + 1) + min);
}
function fn_listar_items(elemento,options2){
  if($('.'+elemento).length){
    var listado = $('.'+elemento).attr('id'), options1 = { str:'', frm:'&'+$('#frm_listado').serialize(), url:listado+'.php',texto:''};
    $.extend(true, options1, options2);

    var carga_listado = function(){
      $('.'+elemento).html(options1.texto);//mostrar texto antes del proces del ajax
      $.ajax({ url:options1.url,cache:false,type:'post',data:'pagina=1&listado='+listado+options1.frm+options1.str,
        success:function(data){
          $('.'+elemento).html(data);if('cback' in options1){ options1.cback(); }
        }
      });
    };
    carga_listado();
    if('intervalo' in options1){ setInterval(carga_listado,options1.intervalo); }
  }
}
function fn_paginar(var_div, url){
  var div = url.split('?'), div2 = $('#'+var_div);
  $.ajax({ 
    url:div[0],type:'POST',data:'&'+div[1],success:function(data){ div2.html(data); $('html, body').stop().animate({ scrollTop: div2.offset().top-50 }, 600); } 
  });
}

function display(variable,task,idfieldtocharge) {
  $.ajax({ url:'index.php', method:'get', dataType:'json', data:{ variable: variable, task: task }, 
    success: function(json) { 
      var html = '';
      $.each(json,function(i,data){ html+= '<option value="'+data.id+'">'+data.value+'</option>'; });
      $('#'+idfieldtocharge).empty().html(html).change(); 
    }
  });
}

function desplegar(){  
  var r_password = $('#recover-passwd');
      r_password.find('form').get(0).reset();
  if(r_password.hasClass('hide')){ r_password.removeClass('hide'); }else{ r_password.addClass('hide').find('label').remove(); }
}
function soloNumeros(evt){
  evt = (evt) ? evt : event;
  var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode : ((evt.which) ? evt.which : 0));
  var respuesta = true;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) respuesta = false;
  return respuesta;
}
function soloNumeros_precio(evt){
  evt = (evt) ? evt : event;
  var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode : ((evt.which) ? evt.which : 0));
  var respuesta = true;
  if(charCode > 31 && (charCode < 48 || charCode > 57)) respuesta = false;
  if(charCode==46) respuesta = true;
  return respuesta;
}

function posicionarMenu() {
  var altura_1 = $('.banners').outerHeight(true),
  altura_2 = $('header').outerHeight(true);
  if($('.banners').length){ var altura_T = altura_1-altura_2;
  }else{var altura_T =altura_2*0.3;} 
  
  if ($(window).scrollTop() >= altura_T){
      $('header').addClass('flota');
  }else{
      $('header').removeClass('flota');
  } 
}

function load_likes(){
  var ides_productos=[],i,nro;
  $(".megusta").find("span").addClass('f-1');
  $.get("process_cart/load_likes.php", function(data){
    var json = JSON.parse(data);
    if(json.rpta == "isset"){
    //destino
      ides_productos=json.content_product;/*captura las id */
      nro = ides_productos.length;//nro= nro_destinos_pintados
      if(nro => 0 ){//lo q estan se pintan
        for (i = 0; i <= nro; i++) {//recorro las id´s
          $("#producto_"+ides_productos[i]).find('span').removeClass('f-1');
          $("#producto_"+ides_productos[i]).find('span').addClass('f-2');
        }
      }       
  //nro de favoritos productos y pedidos x suscrito
      $(".carga_favoritos").find(".nro_product").find("span").html(json.nro_product);
      $(".carga_favoritos").find(".nro_pedidos").find("span").html(json.nro_pedidos);      
      //end
    }else{//si no hay sesion
      $(".megusta").find("span").removeClass('f-2');
      $(".megusta").find("span").addClass('f-1');
      $(".carga_favoritos").find("span").html('0');//nro de favor x suscrito
    }
  });//get 
}




//al cargar la página mostramos el contenido del carrito o un mensaje
//si no tiene contenido, como veremos vamos llamando a esta función
//en cada proceso ya que es la encargada de actualizar el carrit
function content_cart()
{   
	$.get("process_cart/content_cart.php", function(data){
		// var clave = elemento;
		var json = JSON.parse(data);
		var html = "";
		var i = 0,colori="";
		if(json.res == "ok")
		{
			$(".titulo_cesta").html("<h5><small> Cesta de Pedidos.</small></h5>");
    html += " <div class='row'> ";
    //recorro pedidos           
			for(datos in json.content){
         if(i==1){colori="";i=0;}else{colori="style='background:#efefef;'";i++}
          carrito_boton(json.content[datos].id);//envia las id delos q estan dentro del carro
    html += "   <div class='large-12 columns prodcesta large-text-left medium-text-left text-center' "+colori+ ">";
    html += "     <div class='large-2 medium-2 small-2 desaparece columns text-center mpopup-01'> ";
    html += "       <figure><a href='"+ json.content[datos].imagen +"'><img src='"+ json.content[datos].imagen +"'></a></figure> ";
    html += "     </div> ";
    html += "     <div class='large-5 medium-5 small-5 columns cero' style='padding-top:10px;'> ";
    html += "       <p class='osans color-1'>"+ json.content[datos].nombre +"</p> ";
    html += "     </div>  ";
    html += "     <div class='large-2 medium-2 small-2 crece columns' style='padding-top:5px;'> ";
    // html += "       <input type='text' id='cantidad' name='cantidad' min='1' max='100' required  onkeypress='javascript:return soloNumeros(event,0);' value='"+ json.content[datos].cantidad +"'> ";
    html += "       <p>"+ json.content[datos].cantidad +"</p> ";
    html += "     </div> ";
    html += "     <div class='large-2 medium-2 small-2 crece columns' style='padding-top:10px;'> ";
    html += "       <p class='osans color-3' style='font-size:18px;'> S/"+ json.content[datos].precio +" </p> ";
    html += "     </div> ";
    html += "     <div class='large-1 medium-1 small-1  columns' style='padding:5px 8px 0;'> ";
    html += "<td><a href='javascript:void(0)' onclick=\"eliminar('" + json.content[datos].unique_id + "')\"><img src='img/iconos/tacho.png' class='tacho'></a>";
    html += "     </div> ";
    html += "   </div> ";
			}//End for
    html += " </div>";
    //var totalfinal = parseFloat(json.precio_total) + parseFloat(json.content[datos].envio) ;
    var totalfinal = json.precio_total;
    html += " <div  class='large-12 columns large-text-left medium-text-left text-center'  style='padding-top:30px;' >";
    html += "   <h5 class='amatic bold color-1' style='padding-bottom:10px;'>Resumen del pedido</h5>";
    html += "   <p class='osans texto text-left' style='padding-bottom:10px;'>Estimado cliente el <strong>código</strong> del pedido lo recibira en su bandeja de correo.</p>";
    html += "   <p class='osans texto text-left' style='padding-bottom:10px;'>N° productos =<strong> "+json.articulos_total+"</strong></p>";
    html += "   <div class='pleftfor' style='padding-bottom:10px;'>";
    html += "     <p class='osans color-1 ptotal'>Total a pagar: <strong class='color-3' style='padding-left:8px;'> s/"+ json.precio_total +"</strong></p>";
    // html += "     <p class='osans em texto text-right' style='padding-bottom:10px;'>Monto no incluye IGV</p>";
    html += "   </div>";
    html += "   <form action='process_cart/insert_bd.php' method='post' enctype='multipart/form-data'> ";
    html += "     <fieldset>";
    html += "        <input type='hidden' name='total' value='"+totalfinal+"'>";
    html += "        <input type='text' name='direccion' placeholder='Dirección de envio'>";
    html += "       <textarea  name='comentario' placeholder='comentario a pedido'></textarea> ";
    html += "     </fieldset>";
    var cliente = json.id_suscrito;
    if( typeof(cliente) == "undefined" || cliente == null || cliente == ""|| cliente == 0){  //sino esta registrado se abre ventana de registro
    html += "     <a href='iniciar_sesion'  class='btn botones bold osans mpopup-03 enviar-pedido' oncontextmenu='return false' onkeydown='return false'>Realizar pedido.</a>";
    }else{ 
    html += "     <button class='btn botones bold osans enviar-pedido' oncontextmenu='return false' onkeydown='return false'>Realizar pedido</button>";
    }  
    html += "   </form> ";
    // html += "   <p class='osans em rojo' style='padding:10px 8px;'>Monto no incluye IGV</p>";
    html += "   <p class='osans em COLOR-1' style='padding:20px 8px;'>* Revisar en <strong>'CORREO NO DESEADO'</strong> o <strong>'SPAM'</strong> de su bandeja en caso de no ver nuestro correo de respuesta.</p>";
    html += " </div>";
    
		}else{
			$(".titulo_cesta").html("");
			html += "<tbody>";
			html += "<tr>";
			html += "<td>El carrito está vacío.</td>";
			html += "</tr>";
			html += "</tbody>";
		}
		$(".content_cart").html("").append(html);
    $('.mpopup-01').magnificPopup({ type : 'image', delegate : 'a', gallery : { enabled:true } });
    $('.mpopup-03').magnificPopup({ type : 'ajax' });//se declara los js utilizados , copiar igual que en main.js
    precio_total();//Carrito precio total
	});
}

function precio_total(){   
	$.get("process_cart/content_cart.php", function(data){
		var json = JSON.parse(data);
		var html = "";
		if(json.res == "ok"){
      //var totalfinal = parseFloat(json.precio_total) + parseFloat(json.content[datos].envio) ;
			$(".monto_total").html("(s/ "+json.precio_total+")");
		}else{
			$(".monto_total").html("(s/ 0.00)");
		}
	});
}
//función para eliminar una fila
function eliminar(unique_id)
{
	$.post("process_cart/remove_product.php",{unique_id : unique_id}, function(data){
		var json = JSON.parse(data);
		if(json.res == "ok")
		{
			//llamamos a la función content_cart() para actualizar el carrito
      carrito_boton(unique_id);//envio id para quitar le clase del texto.
			content_cart();
		}else{
			alert("error");
		}	
	});
}

// para añadir al carrito ..
function carrito_boton(envioid) {
     var entro,texto,ides=[],i,nro ;
 
    $.get("process_cart/content_cart.php", function(data){
      var json = JSON.parse(data);
      
      if(json.res == "ok"){
        
        $(".hola").text("Añadir a pedido ");//a todos para cuando aya F5 , no pierdan el texto
        for(datos in json.content){
          if(json.content[datos].id == envioid){  entro=1; ides.push(envioid);/*captura las id del car en un [] */}
            else{ $("#ruta-"+envioid).find('button').removeClass('btn-activo');/* sino esta en car , anulamos la clase */ }
          }           
          texto = (entro == 1) ? " Eliminar de pedido" : "no esta dentro del carro";  
      }else{//si esta vacio:empty
            $(".hola").removeClass('btn-activo');//si car esta vacio, eliminar las clases 
            $(".hola").text("Añadir a pedido ");
      }
      
      nro = ides.length;
      if(nro => 0 ){//lo q estan en el carro se cambiana a eloiminar
        for (i = 0; i <= nro; i++) {
          $(".btn-activo").html(texto);
          $("#ruta-"+ides[i]).find('button').addClass('btn-activo');//lo q estan en el carro se cambiana a eloiminar
        }
      }
      
    });//get
  
} 