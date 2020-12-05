<?php $unix_date = strtotime(date('Y-m-d H:i:s')); ?>
<!DOCTYPE html>
<html class="no-js" lang="es-ES">
<head>
<base href="<?php echo $url;?>"/>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo (isset($meta)?$meta['title']:'Agroforestal NIETO');?></title>
<meta property="og:site_name" content="Agroforestal NIETO"/>
<meta property="og:locale" content="es_ES"/>
<meta property="og:type" content="website"/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:title" content="Agroforestal NIETO"/>
<?php if(isset($meta)){ foreach($meta as $k => $v){ if($k!="img"){ ?>	
<meta name="<?php echo $k;?>" content="<?php echo $v;?>"/>
<?php if($k!="keywords"){//Para fb share--> ?>
<meta property="og:<?php echo $k;?>" content="<?php echo $v;?>"/>
<?php }  }	}	} ?>
<meta property="og:image" content="<?php echo (isset($meta) && !empty($meta['img']))?$url.$meta['img']:$url.'img/naynut.png';?>"/> 
<meta name="author" content="Ing.moriayala@gmail.com - Tuweb7.com"/>  
<!-- Favicons -->
<link rel="shortcut icon" href="favicon.png">
<link rel="apple-touch-icon" href="apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-144x144.png">
<link rel="stylesheet" href="css/foundation.css" />
<link href="js/vendor/lightslider/lightslider.min.css" rel="stylesheet">
<link href="js/vendor/magnific-popup/magnific-popup.css" rel="stylesheet">
<link rel="stylesheet" href="css/animate.css"/>
<link rel="stylesheet" href="css/main.css?ud=<?php echo $unix_date ; ?>"/>
</head>
<body id="top">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v3.0';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- menu responsive "left"  -->
<div class="block-n position-left off-canvas-absolute " id="offCanvasLeftSplit1" data-off-canvas>
<?php if(!empty($_SESSION["suscritos"]["id_suscrito"])){ ?>
  <div class="fondo banner-1">
    <img class="img-perfil-movi" src="<?php echo $image_perfil;?>">
    <?php if(!empty($perfil[0]["nombre"])){ ?><p class="bold name_perfil"><?php echo $perfil[0]["nombre"]; ?></p><?php } ?>
    <p class="name_perfil"><?php echo $perfil[0]["email"]; ?></p>
  </div>
<?php } ?>  
  <nav> 
    <ul class="no-bullet osans bold fullwidth">
<?php 
/*
if(empty($_SESSION["suscritos"]["id_suscrito"])){ ?>
     <li>
        <a href="iniciar_sesion" class="mpopup-03 block-n" style="background:#EAEAEA;color:#003333;" oncontextmenu='return false' onkeydown='return false'>
        <img src="img/iconos/login.png" class="img-sesion-movi">Iniciar sesión
        </a>
      </li>
<?php }//sesion
*/
?>
			<li class="<?php echo ("index"== $pagina)?'active-menu':''; ?>"><a href="<?php echo $url;?>">INICIO </a></li>  
						<li class="<?php echo ("nosotros"== $pagina)?'active-menu':''; ?>"><a href="nosotros">NOSOTROS </a></li> 
						
					<?php 
						$categ=executesql("select * from categorias where estado_idestado=1 order by orden desc");
						if(!empty($categ)){ ?>
							<li class="submenu sub_personal <?php echo $active; ?>">
								<a  class="lleva-img" > Productos <img src="img/iconos/menu-catalogo-blanco.png" style="padding-left:8px;"> <!-- <span class="menu-flecha"></span> --></a>
								<ul class="no-bullet children text-center">
									<?php 
										foreach($categ as $categoria){ 
											$active = ($categoria["nombre_rewrite"]== $pagina)?'active-menu':''; 
									?>
												<li class="<?php echo $active;?>"><a href="productos/<?php echo $categoria["nombre_rewrite"]; ?>"><?php echo $categoria["nombre"]; ?></a></li>				
									<?php	} ?>						
								</ul>
							</li>	
					<?php	} ?>	
						
						<li class="<?php echo ("blog"== $pagina)?'active-menu':''; ?>"><a href="blog">BLOG </a></li>  
						<li class="<?php echo ("contacto"== $pagina)?'active-menu':''; ?>"><a href="contacto">CONTÁCTENOS </a></li>  
						
			
    </ul>
		
 <?php if(!empty($_SESSION["suscritos"]["id_suscrito"])){ ?>
    <div id="menu_perfil" class="large-2 menu_perfil columns block-n">
      <?php include("inc/menu_perfil.php");?>
    </div>
<?php }//isset SsSION ?>
  </nav> 
</div>
<!-- end menu left  -->

<header><div class=" franja2 row"><div class="large-12 columns callout-buscar">
  <div class="float-left">
    <a href="<?php echo $url;?>" class="logo"><img src="img/iconos/logo.png" alt="Agroforestal NIETO"/></a>
  </div>
  <div class="float-right">
    <div class="float-right aparecer">
      <button type="button" class=" menu_bar block-n" data-toggle="offCanvasLeftSplit1"><img src="img/iconos/menu_movil.png" class=""></button>
    </div>  
<!--
    <li class="aparecer" style="padding-right:18px;"><a href="cesta"><img src="img/iconos/cesta.png"><span class="em color-1 monto_total" style="font-size:16px;">(s/ 350)</span></a></li>   
-->		
    <div class="float-right ocultar">
      <nav  class="hide amatic bold"> 
        <ul class="no-bullet fullwidth">
						<li class="<?php echo ("index"== $pagina)?'active-menu':''; ?>"><a href="<?php echo $url;?>">INICIO </a></li>  
						<li class="<?php echo ("nosotros"== $pagina)?'active-menu':''; ?>"><a href="nosotros">NOSOTROS </a></li> 
						
					<?php 
						$categ=executesql("select * from categorias where estado_idestado=1 order by orden desc");
						if(!empty($categ)){ ?>
							<li class="submenu sub_personal <?php echo $active; ?>">
								<a  class="lleva-img" > Productos <img src="img/iconos/menu-catalogo.png" style="padding-left:8px;"> <!-- <span class="menu-flecha"></span> --></a>
								<ul class="no-bullet children text-center">
									<?php 
										foreach($categ as $categoria){ 
											$active = ($categoria["nombre_rewrite"]== $pagina)?'active-menu':''; 
									?>
												<li class="<?php echo $active;?>"><a href="productos/<?php echo $categoria["nombre_rewrite"]; ?>"><?php echo $categoria["nombre"]; ?></a></li>				
									<?php	} ?>						
								</ul>
							</li>	
					<?php	} ?>	
						
						<li class="<?php echo ("blog"== $pagina)?'active-menu':''; ?>"><a href="blog">BLOG </a></li>  
						<li class="<?php echo ("contacto"== $pagina)?'active-menu':''; ?>"><a href="contacto">CONTÁCTENOS </a></li>  
						


<?php 
/*
if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ ?>            
          <li><a class="llamar-menu-xl block-b">
            <?php if(!empty($perfil[0]["nombre"])){ ?>
              <p class=" name_perfil"><?php echo $perfil[0]["nombre"]; ?><span></span></p>
            <?php }else{ ?> <p class="name_perfil"><?php echo $perfil[0]["email"]; ?><span></span></p><?php } ?>
            </a>
            <div id="menu_perfil" class="large-2 medium-2 menu_perfil columns osans block-b hide">
              <img src="img/iconos/flecha-arriba.png" class="flecha-arriba">
              <?php include("inc/menu_perfil.php");?>
            </div>
          </li>
<?php }else{ ?>
          <li><a href="iniciar_sesion" class="mpopup-03" oncontextmenu='return false' onkeydown='return false'>INICIAR SESIÓN</a></li>    
<?php } ?>


          <li style="padding-right:18px;"><a href="cesta"><img src="img/iconos/cesta.png"><span class="gulim em monto_total" style="font-size:13.5px;"></span></a></li> 
*/ ?>

        </ul>
      </nav>
    </div>    
  </div>      
</div></div></header>