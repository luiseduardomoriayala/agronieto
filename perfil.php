<?php include('auten.php');
$_SESSION["url"]=url_completa();
$pagina="perfil";$pagina2="con-color";
$meta= array(
		'title' => 'Mi Perfil / Chiclayo Import',
		'keywords' => 'venta de zapatillas y accesorios deportivos de las mejores marcas del mundo.',
		'description' => 'venta de zapatillas y accesorios deportivos de las mejores marcas del mundo.',
	);  
include('inc/header.php');
if(!empty($_SESSION["suscritos"]["id_suscrito"])){
  //ide_suscrito	viene desde el auten.php
?>
<main id="perfil" class="margin-interno">
	<div class="callout callout-1">
		<div id="menu_perfil" class="large-2 menu_perfil columns block-b">
<?php include("inc/menu_perfil.php");?>
		</div>
		<div class="large-10 columns">		
<?php 
if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"]) ){ // verifico sesion
  $fav=array();//para capturar los  fav 
  if(isset($_GET["task"]) && !empty($_GET["task"])){
    //** Mis Datos
    if(!empty($_GET["task"]) && $_GET["task"]=="mis-datos"){ ?>
		<section class="row" style="padding-top:30px;">
			<div class="large-8 medium-10 large-centered medium-centered columns">
				<h2  class="amatic bold color-1 marg-titu">Editar perfil</h2>
				<form action="btn_update_data_perfil.php" method="post" enctype="multipart/form-data" autocomplete="off">
				<fieldset class="text-left">
				<div class="row">
					<div class="large-12 update_img columns">
						<input type="hidden"  name="url"  value="<?php echo $_SESSION["url"];?>">
						<input type="hidden"  name="id"  value="<?php echo $ide_suscrito;?>">
						<input type="hidden"  name="imagen_ant"  value="<?php echo $perfil[0]["imagen"];?>">												
						<article class="rel">    
							<figure><img src="<?php echo $image_perfil; ?>"></figure>
							<div class="file-upload">
									<label for="imagen" class="rel precio_product blanco">
										<span class=" abs uploader"></span>
										Actualizar foto del</br> perfil
									</label>			
									<input id="imagen" name="imagen" class="upload" type="file">
							</div>
						</article>						
					</div>
					<div class="large-12 columns">
						<label class="osans">Nombre:</label>
						<input type="text"  name="nombre" required value="<?php echo $perfil[0]["nombre"];?>">
					</div>
          <div class="large-12 columns"> 
						<label class="osans">DNI:</label>
						<input type="text" onkeypress='javascript:return soloNumeros(event,0);' name="dni" minlength="8" maxlength="8" value="<?php echo $perfil[0]["dni"];?>" >
					</div>
          <div class="large-12 columns"> 
						<label class="osans">Telefono:</label>
						<input type="text" onkeypress='javascript:return soloNumeros(event,0);' name="telefono" value="<?php echo $perfil[0]["telefono"];?>" >
					</div>
          <div class="large-12 columns"> 
						<label class="osans">RUC:</label>
						<input type="text" onkeypress='javascript:return soloNumeros(event,0);' name="ruc" minlength="11" maxlength="11" value="<?php echo $perfil[0]["ruc"];?>" >
					</div>
					<div class="large-12 columns">
						<label class="osans">Empresa:</label>
						<input type="text"  name="empresa" value="<?php echo $perfil[0]["empresa"];?>">
					</div>
          <div class="large-12 columns">
						<label class="osans">Dirección:</label>
						<input type="text"  name="direccion" value="<?php echo $perfil[0]["direccion"];?>">
					</div>
					<div class="large-12 columns">
						<label class="osans">Referencia:</label>
						<input type="text"  name="referencia" value="<?php echo $perfil[0]["referencia"];?>">
					</div>
					<div class="large-12 columns end"> 
						<label class="osans">Contraseña:</label>
						<input type="password"  name="clave" >
					</div>
					<div class="large-12 columns end"> 
						<button class="btn botones">Guardar</button>	
					</div>    
				</div>    
				</fieldset>
				</form>
			</div>
		</section>	<!-- end row  -->
      		   
<?php 	//** Destinos
    }elseif(!empty($_GET["task"]) && $_GET["task"]=="mis-productos"){ 
      $fav_des=executesql("select * from favoritos_productos where id_suscrito='".$ide_suscrito."'");
      if(!empty($fav_des)){ foreach($fav_des as $des){ $fav[]=$des["id_producto"];}
        $sql_product="SELECT p.*,t.nombre_rewrite as tiporew,m.nombre as marca, m.nombre_rewrite as marcarew
FROM productos p
INNER JOIN tipo_producto t ON p.id_tipopro = t.id_tipopro
INNER JOIN marcas m ON p.id_marca = m.id_marca
WHERE p.estado_idestado=1 and id_producto IN (".implode(',',$fav).") 
ORDER BY p.titulo asc";
        $productos=executesql($sql_product);
        if(!empty($productos)){ //destinos?>
        <div class="fondo banner-1"></div><!-- para perfi lempresa si va baner-->
					<h4 class="amatic color-1 bold text-center" style="padding-left:15px;padding-top:25px;">Mis Productos favoritos</h4>
          <div class="row text-center">
<?php   foreach($productos as $row){
    $img_pro=!empty($row["imagen"])?"intranet/files/images/productos/".$row["imagen"]:$notimg;
    $link="productos/".$row["tiporew"]."/".$row["marcarew"]."/".$row["titulo_rewrite"];
 ?>          
            <div class="large-3 medium-3 small-4 columns minh-pro end">
              <?php include("inc/producto.php");?>
            </div>  
            <div class="large-3 medium-3 small-4 columns minh-pro end">
              <?php include("inc/producto.php");?>
            </div>  
            <div class="large-3 medium-3 small-4 columns minh-pro end">
              <?php include("inc/producto.php");?>
            </div>  
            <div class="large-3 medium-3 small-4 columns minh-pro end">
              <?php include("inc/producto.php");?>
            </div>        
<?php   } ?>    
          </div><!-- *row-->    
<?php
        }else{ ?>
        <div class="text-center cero-registro">
          <p class="texto em osans">Lo sentimos no se encontro resultados, porfavor REPORTANOS.</p>
          <a href="reporte_error" class="mpopup-03 color-1">Reportar error.</a>
        </div>
<?php   
        }//end isset destinos
      }else{//si no tiene destinos fav. ?>
        <div class="text-center cero-registro">
          <p class="texto em osans">No tienes destinos favoritos...</p>
          <a href="destinos">Empieza añadir haciendo "Click" en ♥</a>
        </div>
<?php 
      }//end fav des 
    
    }elseif(!empty($_GET["task"]) && $_GET["task"]=="publicar-productos-entregados"){ 
      $productos_entregados=executesql("select * from productos_entregados where id_suscrito='".$ide_suscrito."'");
      if(!empty($productos_entregados)){ ?>
      
      
<?php }else{ ?>
        <div class="text-center cero-registro">
          <p class="texto em osans">No tienes imagenes registradas...</p>
          <a href="destinos">Empieza añadir imagenes de tus productos entregados & Solicita un Descuento ♥</a>
          <?php include('registrar_imagenes_pedidos_entregados.php');?>
        </div>
<?php }  
    }//end vlor del task 

  }else{ //listo noticias sino hay tasks?>
  <div id="prensa">
    <h3 class="amatic bold texto text-center">Ultimas noticias</h3>
<div id="listado_prensas" class="load-content"><p class="text-center">Espere mientras listado se va cargando ...</p></div>
  </div>
<?php 	} ?>
<?php 
}else{ // !isset SeSSion?>
	<script type='text/javascript'>
	<?php echo "alert('Por favor, Inicie Sesión :D');document.location=('".$url."');"; ?>
	</script>
<?php } ?>
		</div>
		
		
<!-- en problemas enviar al correo soporte@lambayequeturismo 
  -campos: comentario,ver si foto  
  -abrrir en flotante ;

  -->
    
	</div>
</main> 
<?php include('inc/footer.php');
 }else{//sino existe sesion ?>
   
<script type='text/javascript'>
<?php echo "alert('Por favor, Inicie Sesión');document.location=('".$url."');"; ?>
</script>
 <?php } ?>