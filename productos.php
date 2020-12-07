<?php include 'auten.php'; 
$pagina="productos";
$_SESSION["url"]=url_completa();
$notimg="img/iconos/imagen.jpg"; 
$dir="intranet/files/images/productos/";
$dir2="intranet/files/files/productos/";
$title="";$des="";$img="";
$key="Distribuidor de motosierras, motoguadañas, podadoras de altura, motofumigadoras, pulverizadoras manuales y a motor, Agroforestal Nieto chiclayo, trujillo, lima, peru";
$titulo_h3="";

// $tags="select * from productos where estado_idestado=1 ";

// $tags="select p.*, m.nombre as marca,m.nombre_rewrite as marcarew,m.imagen as imgmarca ";
// if(!empty($_GET["parametro1"])){$tags.= ",ca.nombre as categ, ca.nombre_rewrite as categrew ";}
// if(!empty($_GET["parametro2"])){$tags.= ",s.nombre as sub, s.nombre_rewrite as subrew ";}
// $tags.=" from productos p  INNER JOIN marcas m ON p.id_marca=m.id_marca";
// if(!empty($_GET["parametro1"])){ $tags.=" INNER JOIN categorias ca ON p.idcat=ca.idcat ";}
// if(!empty($_GET["parametro2"])){ $tags.=" INNER JOIN subcategorias s ON p.idsub=s.idsub  ";}
// $tags.=" where p.estado_idestado=1  and ca.estado_idestado=1   ";
// if(!empty($_GET["parametro2"])){ $tags.=" and s.estado_idestado=1  ";}


$tags="select p.*, m.nombre as marca,m.nombre_rewrite as marcarew,m.imagen as imgmarca 
,ca.nombre as categ, ca.nombre_rewrite as categrew ,s.nombre as sub, s.nombre_rewrite as subrew 
 FROM productos p  INNER JOIN marcas m ON p.id_marca=m.id_marca 
 INNER JOIN categorias ca ON p.idcat=ca.idcat 
 INNER JOIN subcategorias s ON p.idsub=s.idsub  
 WHERE p.estado_idestado=1  and ca.estado_idestado=1  and s.estado_idestado=1  ";



if(!empty($_GET["parametro3"])){
  $tags.=" and p.titulo_rewrite='".$_GET["parametro3"]."' ";    
  $detalle=executesql($tags);
  if(!empty($detalle)){ 
    $titulo_h3='<h5 class="gulim bold blanco large-text-left medium-text-left text-center"> '. $detalle[0]["categ"].' / '.$detalle[0]["sub"].': '.$detalle[0]["titulo"].'</h5>';
    $title="Ventas de ". $detalle[0]["titulo"]." | Agroforestal Nieto ";
    $des="Distribuidor de motosierras, motoguadañas, podadoras de altura, motofumigadoras, pulverizadoras manuales y a motor";
    $img=(!empty($detalle[0]["imagen"]))?$dir.$detalle[0]["imagen"]:"";
  }  

}elseif(!empty($_GET["parametro2"])){
	 $tags.=" and ca.nombre_rewrite='".$_GET["parametro1"]."' and s.nombre_rewrite='".$_GET["parametro2"]."' ";    
	$detalle=executesql($tags);
	if(!empty($detalle)){
		$titulo_h3= '<h3 class="monset blanco text-left">Categoría: '.$detalle[0]["categ"].' / '.$detalle[0]["sub"].'</h3>';
		$title="Venta de ".$detalle[0]["categ"]." ".$detalle[0]["sub"]."  | Agroforestal Nieto ";
		$des="Separa tus pedidos ya.Encuentra lo mejor de ".$detalle[0]["marca"]." ".$detalle[0]["sub"]."  | Agroforestal Nieto ";
		$key=$detalle[0]["marca"]." ".$detalle[0]["sub"]." envios a chiclayo,trujillo, lima, todo el peru.";
		$img=(!empty($detalle[0]["imgmarca"]))?"intranet/files/images/subcategorias/".$detalle[0]["imgmarca"]:"";
	}
	 
	 
}elseif(!empty($_GET["parametro1"])){
	
	  $tags.=" and ca.nombre_rewrite='".$_GET["parametro1"]."' GROUP BY p.id_producto ORDER BY p.orden desc ";    
	$detalle=executesql($tags);
	if(!empty($detalle)){
			$titulo_h3= '<h3 class="monset blanco text-left">Categoría: '.$detalle[0]["categ"].'</h3>';
		$title="Encuentra los mejores  ".$detalle[0]["marca"]." | Agroforestal Nieto ";
		$des="Encuentra lo mejor solo en Agroforestal Nieto.";
		$key=$detalle[0]["marca"]." envios a chiclayo,trujillo, lima, todo el peru.";
		$img=(!empty($detalle[0]["imgmarca"]))?"intranet/files/images/categorias/".$detalle[0]["imgmarca"]:"";
	}
	
}else{
  $titulo_h3='<h5 class="gulim bold blanco large-text-left medium-text-left text-center">Nuestros productos:</h5>';
  $detalle=executesql($tags);
  if(!empty($detalle)){    
    $title="Nuestros productos | Agroforestal Nieto";
    $des="Distribuidor de motosierras, motoguadañas, podadoras de altura, motofumigadoras, pulverizadoras manuales y a motor";
    $img="";
  }
}

$meta= array(
  'title' => $title,
  'keywords' => $key,
  'description' => $des,
  'img' => $img
);
include('inc/header.php'); ?>
<main id="categ" class="margin-interno">
<div class="callout-f"><div class="row">
<?php echo $titulo_h3;?>
</div></div>
<div class="callout callout-1 <?php echo !empty($_GET["parametro1"])?'':'fondi';?>"><div class="row">      
<?php 
if(!empty($_GET["parametro3"])){ //si encuentr directo el producto
  $sql="select * from productos where estado_idestad o=1 and titulo_rewrite='".$_GET["parametro2"]."' "; 
	
		$sql="select p.*  from productos p  INNER JOIN categorias c ON p.idcat=c.idcat ";
$sql.="  LEFT JOIN subcategorias s ON p.idsub=s.idsub ";
$sql.=" where p.estado_idestado=1 and c.estado_idestado=1 and s.estado_idestado=1 and ".(!empty($_POST["buscar"]) ? " p.titulo like '%".$_POST["buscar"]."%'" : "p.titulo_rewrite='".$_GET["parametro3"]."'")."";   
	

  // echo $sql; 

	
  $detalle=executesql($sql);
  if(!empty($detalle)){
    $imgproduct=$img=(!empty($detalle[0]["imagen"]))?$dir.$detalle[0]["imagen"]:$notimg;
?>       
        <div class="large-8 medium-8 columns end"><div class="row">
            <div class="large-6 medium-6 small-6 imagenes columns end">
              <div class="fotos foto-principal">
                <figure class="mpopup-01"><a href="<?php echo $img;?>"><img src="<?php echo $img;?>" class="verticalalignmiddle"></a></figure>
              </div>        
<?php //imagenes adicionales
 $galeria = executesql("select * from galeria_producto where id_producto='".$detalle[0]["id_producto"]."' order by orden desc");
    if(!empty($galeria)){
      foreach($galeria as $row){
        if(!empty($row["imagen"])){
              $imagenes="intranet/files/galeria/productos/".$row["id_producto"]."/".$row["imagen"];
 ?>        
              <div class="large-3 medium-3 small-3 columns end cero">
                <div class="fotos foto-adicionales">
                  <figure class="mpopup-01"><a href="<?php echo $imagenes; ?>"><img src="<?php echo $imagenes; ?>" class="verticalalignmiddle"></a></figure>
                </div>
              </div>
<?php }}}//end galeria  ?>        
           
        <!-- imagenes adicionales -->
            
            </div><!-- l6 -->
            <div class="large-6  medium-6 small-6 detalle columns end">
              <h1 class="gulim"><?php echo $detalle[0]["titulo"];?></h1>
          <!--<p class="osans" style="display:block;padding-bottom:8px;">tipo: <span CLASS="color-3">fruto seco</span></p>-->
              <?php echo $detalle[0]["puntuales"];?>
              <p class="osans text-center stock" >
<?php if($detalle[0]["stock"]==1){ ?> <img src="img/iconos/aspa.png" style="padding-right:10px;">En stock
<?php }else{ ?> <img src="img/iconos/aspa.png" style="padding-right:10px;">A pedido<?php } ?>
              </p>
<?php if($detalle[0]["igv"]==1){ ?> <p class="osans text-center igv"> Incluye IGV</p>
<?php }else{ ?> <p class="osans text-center igv"> No incluye IGV</p><?php } ?>
      
              <div class="precio">
<?php if(!empty($detalle[0]["costo_promo"]) && $detalle[0]["costo_promo"]!="0.00"){
       $precio=$detalle[0]["costo_promo"]; ?>
                <p  class="osans"><strike style='padding-right:15px;'>S/<?php echo $detalle[0]["precio"]; ?></strike>S/<?php echo $detalle[0]["costo_promo"]; ?></p>
<?php }else{ $precio=$detalle[0]["precio"]; ?>
                <p  class="osans">S/<?php echo $detalle[0]["precio"]; ?></p>
<?php } ?>
              </div>
					<!-- 
              <form id ="ruta-<?php echo $detalle[0]["id_producto"]; ?>" class="add" method="POST" action="process_cart/insert.php" accept-charset="UTF-8">       
                  <input type="hidden" name="id"  value="<?php echo $detalle[0]["id_producto"] ?>">
                  <input type="hidden" name="imagen"  value="<?php echo $imgproduct ; ?>">
                  <input type="hidden" name="nombre"  value="<?php echo $detalle[0]["titulo"]; ?>" id="nombre">        
                  <input type="hidden" name="precio"  value="<?php echo $precio; ?>" id="precio">           
                <label class="osans em" style="color:#FF0000;">Cantidad:</label>
                <input type="number" value="1" min="1" max="100" required onkeypress='javascript:return soloNumeros(event,0);' id="cantidad" name="cantidad" style='width:60px;'>
                <div class="large-12 columns" style="padding-left:0;margin-bottom:25px;">
                  <button class="osans bold btn botones  hola"></button>
                </div>
              </form>
					-->
								<div class="lleva_botones "  >
										<a href="https://api.whatsapp.com/send?phone=<?php echo $num_wsp;?>&text=<?php echo $texto_cambiado;?>" target="_blank"  class="btn botones btnwsp pulse"> <img src="img/icowsp.png"> Solicitar</a>
										<a href="tel:<?php echo $num_wsp;?>" target="_blank" class="btn botones pulse"> Llamar</a> 
								</div>	
							
							
               <?php include("inc/compartir_con.php"); ?>
            </div><!-- l6-->
              
            <div class="large-12 contenido columns end">
              <div class="izq aparecer end">
                <div class="llamar">
                  <div class="float-left"><img src="img/iconos/llamar-pro.png"></div>
                  <div class="float-right text-left">
                    <blockquote class="gulim bold color-1">CONSÚLTANOS </br>DIRECTAMENTE </br><span>POR ESTE PRODUCTO</span></blockquote>
                    <h5 class="gulim bold bold" style="color:#060709;">945250434</h5>
                  </div>
                </div>
                <div class="datos-de-envio" style="padding:5px;">
                  <p class="rel osans"><img src="img/iconos/natural.png" class="abs">Productos 100% confiables</p>
                  <p class="rel osans"><img src="img/iconos/delivery.png" class="abs">Envios a nivel nacional.</p>
                </div>         
              </div>
<?php if(!empty($detalle[0]["especificaciones"])){ ?>
              <div class="especi">
                <h4 class="gulim bold">Descripción:</h4>
                <?php echo $detalle[0]["especificaciones"]; ?>
              </div>
<?php }
    if(!empty($detalle[0]["detalle"])){ ?>
              <div class="especi">
                <h4 class="gulim bold">Beneficios:</h4>
                <?php echo $detalle[0]["detalle"]; ?>
              </div>
<?php }//existe detalle 
    if(!empty($detalle[0]["link"])){ 
      if(!empty($detalle[0]["link"])){
        $video= explode('watch?v=',$detalle[0]["link"]);
        $clemb= strpos($video[1],'&');
        $embed=($clemb !==false) ? substr($video[1],0,$clemb) : $video[1];
?>
              <div class="video">
                <h4 class="gulim bold">Video</h4>
                <div class="lleva-video">
                  <div class="responsive-embed widescreen">
                    <iframe width="100%" height="265" src="https://www.youtube.com/embed/<?php echo $embed; ?>" frameborder="0" allowfullscreen></iframe>
                  </div>
                </div>
              </div>
<?php }//video
    }//existe video?>
            </div>
        </div></div>
        <div class="large-4 medium-4 izq ocultar columns end">
          <div class="llamar">
            <div class="float-left"><img src="img/iconos/llamar-pro.png"></div>
            <div class="float-right text-left">
              <blockquote class="gulim bold color-1">CONSÚLTANOS </br>DIRECTAMENTE </br><span>POR ESTE PRODUCTO</span></blockquote>
              <h5 class="gulim bold bold" style="color:#060709;">945250434</h5>
            </div>
          </div>
          <div class="datos-de-envio" style="padding:5px;">
            <p class="rel osans"><img src="img/iconos/natural.png" class="abs" style="left:8px;">Productos 100% confiables.</p>
            <p class="rel osans"><img src="img/iconos/delivery.png" class="abs">Envios a nivel nacional.</p>
          </div>         
        </div>
<?php }else{ ?>
        <p class="osans em  text-center" style="padding:150px 0;">... No se encontro producto.</p>
<?php }//end detalle producto 
//product relacionados //acomodar esto a

// $sql = "SELECT p.*, ca.nombre_rewrite as categrew, m.nombre as  marca  from productos p INNER JOIN  categorias ca ON p.idcat=ca.idcat INNER JOIN marcas m ON p.id_marca=m.id_marca  WHERE p.estado_idestado=1 and m.estado_idestado=1 and ca.estado_idestado=1 ORDER BY p.orden DESC limit 0,9 ";

	$sql = "SELECT p.*, m.nombre as marca,m.nombre_rewrite as marcarew, ca.nombre as categ, ca.nombre_rewrite as categrew, s.nombre as sub, s.nombre_rewrite as subrew  FROM productos p INNER JOIN marcas m ON p.id_marca=m.id_marca  INNER JOIN categorias ca ON p.idcat=ca.idcat LEFT JOIN subcategorias s ON p.idsub=s.idsub  WHERE  p.estado_idestado=1 and m.estado_idestado=1 and ca.estado_idestado=1 and    s.nombre_rewrite='".$_GET["parametro2"]."' ";


$relacionados=executesql($sql);
if(!empty($relacionados)){ ?>
        <div class="large-12 relacionados columns">
          <h4 class="gulim bold">PRODUCTOS RELACIONADOS </h4>
          <ul class="no-bullet carousel-3 text-center">
<?php
foreach($relacionados as $row){
  $img_pro=!empty($row["imagen"])?$dir.$row["imagen"]:$notimg;
   $link="productos/".$row["categrew"].'/'.$row["subrew"].'/'.$row["titulo_rewrite"]; ?>                   
          <div class="large-4 medium-4 columns minh-pro end">
     <?php include("inc/producto.php");?>
          </div>       
<?php }//for ?>        
          </ul>
<?php }//si exis relacionados ?>        
        </div><!-- l12 -->         
<?php //end productos relaciondos


}elseif( !empty($_GET["parametro1"]) || !empty($_GET["parametro2"]) || !empty($_POST["buscar"])){ 

// }elseif( !empty($_GET["parametro1"]) || !empty($_POST["buscar"])){ 



$sql = "SELECT p.*, m.nombre as marca,m.nombre_rewrite as marcarew ";
$sql.= ", ca.nombre as categ, ca.nombre_rewrite as categrew,  s.nombre as sub, s.nombre_rewrite as subrew  "; // si hay syb_categ
$sql.=" FROM productos p INNER JOIN marcas m ON p.id_marca=m.id_marca  ";
$sql.= " INNER JOIN  categorias ca ON p.idcat=ca.idcat  "; // si hay syb_categ
$sql.=" LEFT JOIN subcategorias s ON p.idsub=s.idsub  ";

$sql.=" WHERE  p.estado_idestado=1 and m.estado_idestado=1 and ca.estado_idestado=1 and s.estado_idestado=1 ";


  // $sql = "SELECT p.*,c.nombre as marca,c.nombre_rewrite as marcarew,s.nombre as sub,s.nombre_rewrite as subrew FROM productos p INNER JOIN categoria_subcate_productos csp ON csp.id_producto = p.id_producto INNER JOIN marcas c ON csp.id_marca=c.id_marca INNER JOIN submarcas s ON csp.id_sub=s.id_sub  WHERE p.estado_idestado=1 and c.estado_idestado=1  ";
  

	if(!empty($_GET["parametro2"])){
		$sql.=" and ca.nombre_rewrite='".$_GET["parametro1"]."' and s.nombre_rewrite='".$_GET["parametro2"]."'  ";
		
	}elseif(!empty($_GET["parametro1"])){
		// $sql.= " and ca.nombre_rewrite='".$_GET["parametro1"]."' GROUP BY p.id_producto  " ;
		 $sql.= " and ca.nombre_rewrite='".$_GET["parametro1"]."'  " ;
		
	}elseif(!empty($_POST["buscar"])){
		$sql.= " and ( p.titulo like '%".$_POST["buscar"]."%' or  ca.nombre like '%".$_POST["buscar"]."%' or  s.nombre like '%".$_POST["buscar"]."%' or m.nombre like '%".$_POST["buscar"]."%' ) " ;
		// $sql.= " and p.titulo like '%".$_POST["buscar"]."%' or  m.nombre like '%".$_POST["buscar"]."%'  " ;  
	}else{
		$sql.= "  "; 
	} 
	 
 $sql.= " ORDER BY p.orden DESC ";

// echo $sql;

$exsql = executesql($sql);
?>

  <div class="large-12  columns">
<?php 

		if(!empty($exsql)){
			foreach($exsql as $row){
      $img_pro = !empty($row["imagen"])?$dir.$row["imagen"]:$notimg;
      $link="productos/".$row["categrew"].'/'.$row["subrew"].'/'.$row["titulo_rewrite"];
			
					
?>        
     <div class="large-3  medium-4 small-6 columns text-center minh-pro end"><?php include("inc/producto.php");?></div>    
<?php	 

			}
		}else{ ?>
    <p class="osans em  text-center color-1" style="padding:100px 0;">No se encontro productos ... </p>
<?php } ?>
  </div>
	
	
<?php 
}else{ // listamos todos ?>
  <div class="large-12  columns">
<?php  
 $sql = "SELECT p.*, ca.nombre_rewrite as categrew, s.nombre_rewrite as subrew, m.nombre as  marca  from productos p 
INNER JOIN  categorias ca ON p.idcat=ca.idcat 
INNER JOIN subcategorias s ON p.idsub=s.idsub 
INNER JOIN marcas m ON p.id_marca=m.id_marca 
 WHERE p.estado_idestado=1 and m.estado_idestado=1 and ca.estado_idestado=1 and s.estado_idestado=1 ORDER BY p.orden DESC  ";

      $exsql = executesql($sql);
  if(!empty($exsql)){
    foreach($exsql as $row){
      $img_pro = !empty($row["imagen"])?$dir.$row["imagen"]:$notimg;
      $link="productos/".$row["categrew"].'/'.$row["subrew"].'/'.$row["titulo_rewrite"];
			
						
			// for($i=1;$i<10;$i++){   
			// }
?>        
     <div class="large-3  medium-4 small-6 columns text-center minh-pro end"><?php include("inc/producto.php");?></div>    
<?php 

		}}else{ ?>
    <p class="osans em  text-center color-1" style="padding:100px 0;">No se encontro productos ... </p>
<?php } ?>
  </div>
	
<?php 
} // if genreal ?>

</div></div>        
</main> 
<?php include('inc/footer.php'); ?>