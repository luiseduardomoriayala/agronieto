// Bind the possible Add to Cart btns with event to position top links
;(function($) {
  $(document).ready(function(){
    
  	// FORMULARIO ENTRAR
  	if ($('#entrar').length){ // inicio de sesion
  		$('#entrar').submit(function(e){
  		e.preventDefault();
  		formulario('entrar','validator');
  		return false;
  		});
  		//
  		$('#recuperar').submit(function(e){
  		e.preventDefault();
  		formulario('recuperar','recuperar');
  		return false;
  		});
  	};
  	if ($('#registrar').length){
  		$('#registrar').submit(function(e){
  		e.preventDefault();
  		formulario('registrar','registrar');
  		return false;
  		});
  	}

  	// RECUPERAR
  	$(".rcp").on("click", function() {
  		$('.login').hide(300);
  		$('#recuperar').show('slow');
  	 });

  	$(".exit").on("click", function() {
  		$('.login').show(300);
  		$('#recuperar').hide('slow');
  		//$("#recuperar input[type='email']").val("");
  		$('#recuperar').get(0).reset();
  		$('#recuperar .msg .verror').hide();
  	 });

  	// VIDEO
    $("#link").keyup(function(){
      var iframe = $('.lvideo'),
        mvalor = $(this).val(),
        dividir = mvalor.split('=');
        iframe.hide();
        if(mvalor!=''){
          iframe.show().attr('src','https://www.youtube.com/embed/'+dividir[1]);
        }
    });
    $("#link").trigger('keyup');
    
  	// LISTADO
  	$('#criterio_usu_per').keyup(function(){
  		fn_buscar();
  	});
  	$('#frm_buscar').find('select').change(function(){
  		fn_buscar();
  	});
    if($('#frm_buscar').length) fn_buscar();
  });

})(jQuery);

function formulario (frm,task){
	var form = $('#'+frm), msg = form.find('.msg');
	msg.html('<span class="vload"></span>');
	$.ajax({
		type: 'POST',
		url: 'index?task='+task,
		data: form.serialize(),
		cache: false,
		success: function(rpta){
			var terror = '' , tsuccs ='';
			terror = (task=='validator') ? 'Datos errados.' : ((task=='registrar') ? 'No se pudo crear la cuenta.' : 'No se pudo enviar el mensaje.');
			tsuccs = (task=='validator') ? 'Redirigiendo...' : ((task=='registrar') ? 'Cuenta creada correctamente.' : 'Mensaje enviado correctamente. Por favor revise la <b>Bandeja de su correo</b>.');
			//randy_cancer_30@hotmail.com
			//var tiempo = (task=='validator') ? 800 : 500;
			rpta = parseInt(rpta);
			if(rpta==2){
				msg.html('<span class="verror">'+terror+'</span>')
			}else if(rpta==3){
				msg.html('<span class="verror">Contraseña errada.</span>')
			}else{
				msg.html('<span class="vgood">'+tsuccs+'</span>')
				if(task=='validator' || task=='registrar')
				{
					setTimeout(function(){ document.location.href=''},800);
				}
			}
		}
	});
}

function gotourl(url){
    document.location.href=url;
}

function fn_mostrar_frm_agregar(){
  $("#div_oculto").load(link+"s.php?task=new", function(){
    $.blockUI({
      message: $('#div_oculto'),
      css:{
        top: '20%'
      }
    }); 
  });
};

function fn_delete_all(ide_per){
  swal({
  title: "Quiere continuar?",
  text: "Eliminando est"+l+"s "+link+"s!",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: '#DD6B55',
  confirmButtonText: 'Aceptar',
  closeOnConfirm: false
  },function(){
    var arr = new Array();
    if($('input.chkDel:checked').length){
      $('input.chkDel:checked').each(function(){ 
        arr.push($(this).val());
      });
      compl = '&chkDel[]='+arr;
      $.ajax({
        type: 'GET',
        url: link+'s.php',
        data: 'task=dropselect'+compl,//pass the array to the ajax call
        cache: false,
        success: function(){ 
          fn_buscar();
        }
      })
      .done(function(data) {
        swal("Eliminad"+l+"s!", "L"+l+"s "+link+"s fueron eliminad"+l+"s satisfactoriamente!", "success");
      })
      .error(function(data) {
        swal("Oops", "No hemos podido conectar con el servidor!", "error");
      });
    }else{
      swal('Por favor selecciona los registros a eliminar.','',"error");
    }
  });
}

function fn_eliminar(ide_per){
  swal({
  title: "Quiere continuar?",
  text: "Eliminando est"+l2+" "+us+"!",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: '#DD6B55',
  confirmButtonText: 'Aceptar',
  closeOnConfirm: false
  },function(){
    $.ajax({
      url: link+'s.php',
      data: '&task=drop&'+id+'=' + ide_per,
      type: 'GET',
      success: function(data){
        fn_buscar();
      }
    })
    .done(function(data) {
    swal("Eliminad"+l+"!", pr+" "+us+" fue eliminad"+l+" satisfactoriamente!", "success");
  })
  .error(function(data) {
    swal("Oops", "No hemos podido conectar con el servidor!", "error");
  });
  });
}

function fn_estado(ide_tes){
  $.ajax({
    url: link+'s.php',
    data: '&task=uestado&estado_idestado=' + ide_tes,
    type: 'GET',
    success: function(state){
      state = parseInt(state);
      if(state==2){
        swal('Usted ha deshabilitado '+ar+' '+us+'.','','error')
      }else if(state==1){
        swal('Usted ha habilitado '+ar+' '+us+'.','','success')
      }
      fn_buscar();
    }
  });
}

function fn_estado_pedido(ide_tes){
  $.ajax({
    url: link+'s.php',
    data: '&task=uestado_pedido&idpedido=' + ide_tes,
    type: 'GET',
    success: function(state){//coje el valor enviado desde le task
      state = parseInt(state);
      if(state==2){
        swal('Pedido pendiente por ser entregado .','','error')
      }else if(state==1){
        swal('Pedido entregado con exito.','','success')
      }
      fn_buscar();
    }
  });
}

function fn_estado_producto(ide_tes){
  $.ajax({
    url: link+'s.php',
    data: '&task=uestado&estado=' + ide_tes,
    type: 'GET',
    success: function(state){
      state = parseInt(state);
      if(state==2){
        swal('Usted ha deshabilitado '+ar+' '+us+'.','','error')
      }else if(state==1){
        swal('Usted ha habilitado '+ar+' '+us+'.','','success')
      }
      fn_buscar();
    }
  });
}

function fn_paginar(var_div, url){
  var div = $("#" + var_div);
    $(div).load(url);
}
  
function repaginar(div,page,str){
  fn_paginar(div, page+'?'+str);  
}

function sorter(){
  $("#example1").tablesorter();
}

function checked(){
  $('.all').change(function (e) {
   if(this.className == 'all'){
       $('.chkDel').prop('checked', this.checked);
   }else{
        $('.all').prop('checked', $('.chkDel:checked').length == $('.chkDel').length);
    }
  });
}

function reordenar(page){
  $('#sort').sortable({
    opacity: 0.6,
    cursor: 'move',
    update: function() {
        var order = $('#sort').sortable("serialize");
        $.ajax({
          url: page, 
          type: 'get',
          data: 'task=ordenar&'+order,
          success: function(){
            // swal('Orden Actualizado','','success');
            fn_buscar();
          }
        });
      }
  });
}

function fn_buscar(){
  var xmlhttp;
  if (window.XMLHttpRequest){
  // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }else{
  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  var str = $("#frm_buscar").serialize();
  xmlhttp.onreadystatechange=function(){
    if (xmlhttp.readyState==4 && xmlhttp.status==200){
      document.getElementById("div_listar").innerHTML=xmlhttp.responseText;
      parseScript(xmlhttp.responseText);
    }
  }
  xmlhttp.open("GET",mypage+'?'+'task=finder&'+str,true);
  xmlhttp.send();
}

function parseScript(strcode) {
  var scripts = new Array(); // Array which will store the script's code
  // Strip out tags
  while(strcode.indexOf('<script') > -1 || strcode.indexOf('</script') > -1) {
    var s = strcode.indexOf('<script');
    var s_e = strcode.indexOf('>',s);
    var e = strcode.indexOf('</script',s);
    var e_e = strcode.indexOf('>',e);
    // Add to scripts array
    scripts.push(strcode.substring(s_e+1,e));
    // Strip from strcode
    strcode = strcode.substring(0,s)+strcode.substring(e_e+1);
  }
  // Loop through every script collected and eval it
  for(var i=0; i<scripts.length; i++) {
    try{ eval(scripts[i]); }
    catch(ex){
    // do what you want here when a script fails
    }
  }
}


function display(archivo,variable,task,idfieldtocharge) { //cargan datos  de un cmb a o tro cmb
  $.ajax({ url:archivo, method:'get', dataType:'json', data:{ variable: variable, task: task }, 
    success: function(json) { 
      console.log(json);
      var html = '';
      $.each(json,function(i,data){ html+= '<option value="'+data.id+'">'+data.value+'</option>'; });
      $('#'+idfieldtocharge).empty().html(html).change(); 
    }
  });
}

function display_2(archivo,var1,var2,task,idfieldtocharge) { //cargan datos  de un cmb a o tro cmb
  $.ajax({ url:archivo, method:'get', dataType:'json', data:{ var1: var1,var2: var2, task: task }, 
    success: function(json) { 
      console.log(json);
      var html = '';
      $.each(json,function(i,data){ html+= '<option value="'+data.id+'">'+data.value+'</option>'; });
      $('#'+idfieldtocharge).empty().html(html).change(); 
    }
  });
}

function soloNumeros(evt,tipo){
  evt = (evt) ? evt : event;
  var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode : ((evt.which) ? evt.which : 0));
  var respuesta = true;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) respuesta = false;
  if(tipo !== undefined && tipo == 2){//si envio el 2 permite decimimale
    if(charCode==46) respuesta = true;
  }
  return respuesta;
}


function fn_exportar(str){
  if(str === undefined) str = '';
  $.ajax({ 
    url:'index.php?task=exportar_excel',type:'POST',data:str,
    success : function(data){ document.location.href = 'exportar.excel.php'; } 
  });
}