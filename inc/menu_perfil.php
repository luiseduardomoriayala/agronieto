			<div class="menuperfil_items  text-center">
				<img class="img-perfil" src="<?php echo $image_perfil;?>">
        <div class="carga_favoritos text-left">
<?php 
$bold_datos=(isset($_GET["task"]) && $_GET["task"]=="mis-datos")?'bold':'';
$bold_noti=(!isset($_GET["task"]))?'bold':'';
// $bol_pedido=(isset($_GET["task"]) && $_GET["task"]=="mis-pedidos")?'bold':'';
// $bol_prod=(isset($_GET["task"]) && $_GET["task"]=="mis-productos")?'bold':'';
// $bol_publicar=(isset($_GET["task"]) && $_GET["task"]=="publicar-productos-entregados")?'bold':'';

?>
					<a href="perfil/mis-datos">
						<p class="<?php echo $bold_datos;?>"><img src="img/iconos/ico-perfil.png">Mis Datos</p>
					</a>
          <a href="perfil"><p class="<?php echo $bold_noti;?>"><img src="img/iconos/ico-noticias.png">Ver publicaciones</p></a>
      <!--
         <a href="perfil/mis-pedidos">
						<p class="nro_pedidos <?php/* echo $bol_pedido; */?>"><img src="img/iconos/ico-mis-rutas.png">Mis pedidos (<span></span>)</p>
					</a>
      -->
<?php /*          
          <a href="perfil/mis-productos">
						<p class="nro_product <?php echo $bol_prod;?>"><img src="img/iconos/favorit-0.png">Mis favoritos (<span></span>)</p>
					</a>
          <a href="perfil/publicar-productos-entregados">
						<p class="nro_product <?php echo $bol_publicar;?>"><img src="img/iconos/favorit-0.png">Publicar Entregas (<span></span>)</p>
					</a>
*/?>
          <a href="index?task=cerrar_sesion"><p class=""><img src="img/iconos/ico-cerrar-sesion.png">Cerrar sesión</p></a>
        </div> 
			</div>