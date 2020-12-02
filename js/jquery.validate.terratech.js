;(function($) {
  $.customPlugin = function(element, options) {
    var defaults = {
      rules               : {},
      messages            : {},
      groups              : {},
      submitHandler       : '',
      //dataConfigV       : {},
      errorLabelContainer : '',
      control_group       : '.control-group',
      highlight           : '',
      success             : '',
      errorPlacement      : function(error,element){ error.insertAfter(element); },
      //send_ajax         : true,
      url                 : 'sendmessage.php',
      type                : 'post',
      key_action          : 'action',
      val_action          : 'registro',
      prex_msg            : 'registro',
      gotourl             : '',
      type_form           : 1,
      type_save           : 1,
      mode_form           : 1, // [1 -> option.send, 2 -> submit, 3 -> (plugin.settings.submitHandler, submit)]
      fn_loading			    : function(){},
      fn_success			    : function(){},
      fn_error			      : function(){},
      placeholder1        : 'Mensaje Enviado',
      placeholder2        : 'No se logró suscribir. Espere unos momentos e inténtelo nuevamente.'
    };

    var plugin = this;
        plugin.settings = {};

    var $element = $(element),
        element  = element;

    plugin.init = function() {
      plugin.settings = $.extend({}, defaults, options);
    };  
  
    plugin.disableFields = function(enable) {
      var attb = '';
      $element.find('input,textarea,select,button').each(function(){ 
        if($(this).is(':submit,button')){ attb = 'disabled'; }else{ attb = 'readonly'; }
        if(enable == 1){ $(this).removeAttr(attb); }else{ $(this).attr(attb,attb); }  
      });
    };

    plugin.send = function() {
      var msgInfo     = $('#'+plugin.settings.prex_msg+'Info'), 
          msgSuccess  = $('#'+plugin.settings.prex_msg+'Success'), 
          msgError    = $('#'+plugin.settings.prex_msg+'Error'),
          action_form = $element.attr('action'),
          type_form   = $element.attr('method'),
          url         = (typeof action_form !== typeof undefined && action_form !== false) ? $element.attr('action') : plugin.settings.url,
          type        = (typeof type_form !== typeof undefined && type_form !== false) ? $element.attr('method') : plugin.settings.type;
            
      if(plugin.settings.type_form == 1) msgInfo.removeClass('hide');

      if(plugin.settings.type_save == 1){ 
        var contentType = 'application/x-www-form-urlencoded', 
            processData = true, 
            data = $element.serialize()+'&'+plugin.settings.key_action+'='+plugin.settings.val_action;
      }else{ 
        var contentType = false, 
            processData = false, 
            data = new FormData($element[0]);
        data.append(plugin.settings.key_action,plugin.settings.val_action);
      }
      plugin.disableFields();
      plugin.settings.fn_loading();
      $.ajax({
        url         : url,
        type        : type,
        data        : data,
        dataType    : 'json',
        contentType : contentType,
        processData : processData,
        success     : function(result){ 					
          plugin.disableFields(1);
          if(plugin.settings.type_form == 1) msgInfo.addClass('hide');
          if(plugin.settings.type_form == 1){
              if(result['rpta'] == 1){//s se logr enviar desde val_actin en main.js
                msgSuccess.removeClass('hide'); 
                msgError.addClass('hide');
                $element.get(0).reset();//limpio formulario
                $element.find('.control-group').removeClass('error success').find('.controls label').remove(); 
                setTimeout(function(){ msgSuccess.addClass('hide'); },8000);//msj desparece en 5seg.
                if(plugin.settings.gotourl != ''){// redireccionmiento
                    document.location.href = plugin.settings.gotourl; 
                }else{
                    document.location.href = result['link_go']; // vlor de sesion url ose en la misma pag dodne se  encuentra             
                }
                plugin.settings.fn_success();
              }else if( result['rpta']== 2){//si es error
                msgError.removeClass('hide');
                msgSuccess.addClass('hide');
                setTimeout(function(){ msgError.addClass('hide'); },8000);
                plugin.settings.fn_error();
              }else{ document.location.href= result['rpta'];}
          }else{ /*para mostrar laceholder , aun no ls utilize*/
            $element.get(0).reset();
            if(result['rpta'] == 1){
              $element.find("input[type='text']").attr('placeholder',plugin.settings.placeholder1).closest('.control')
                      .css({'backgroundColor':'#a5ffa5'});
            }else{
              $element.find("input[type='text']").attr('placeholder',plugin.settings.placeholder2).closest('.control')
                      .css({'backgroundColor':'#ffb2b2'});
            }
          }
        }
      });
    };

    plugin.validate = function() {
      $element.validate({
        submitHandler       : function(form){
          if(plugin.settings.mode_form == 1){
            (typeof plugin.settings.submitHandler === 'function') ? plugin.settings.submitHandler() : plugin.send();//metodo 1
            return false;
          }else{
            if(plugin.settings.mode_form == 3) plugin.settings.submitHandler();/* metodo 3*/

            form.submit();//envia datos
          }
        },
        rules               : plugin.settings.rules,
        messages            : plugin.settings.messages,
        errorLabelContainer : plugin.settings.errorLabelContainer,
        errorPlacement 		  : function(error,element){
          plugin.settings.errorPlacement(error,element);
        },
        highlight           : function (element){
          if(typeof plugin.settings.highlight === 'function'){
            plugin.settings.highlight(element);
          }else{
            $(element).closest(plugin.settings.control_group).removeClass('success').addClass('error');
          }
        },
        success             : function (element){
          if(typeof plugin.settings.success === 'function'){
            plugin.settings.success(element);
          }else{
            element.text('').addClass('valid').closest(plugin.settings.control_group).removeClass('error').addClass('success');
          }
        }
      });
    };

    plugin.init();
  }
  $.fn.customPlugin = function(options) {
    return this.each(function() {
      if (undefined == $(this).data('customPlugin')) {
        var plugin = new $.customPlugin(this, options);
        $(this).data('customPlugin', plugin);
      }
    });
  }
})(jQuery);