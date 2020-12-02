<?php include 'auten.php'; 
$pagina="productos";
$_SESSION["url"]=url_completa();
$notimg="img/iconos/imagen.jpg"; 
$dir="intranet/files/images/productos/";
$dir2="intranet/files/files/productos/";
$title="";$des="";$img="";
$key="saludable, alimentacion sana, fibra, salud, sano, alimento, nutritivo, snack, fruta, deshidratado, rico, digestivo, dietetico, calorias, bajo en calorias, alimento, fitnes, venta de snack,fruta deshidratada, alimentos saludables, vida sana, manzana deshidratada, piña deshidratada, platano deshidratada, alimento natural, nutritivo, comida saludable, ansiedad, fibra, snack saludables, snack nutritivo, fitnes chiclayo, trujillo, lima, peru";
$titulo_h3="";

$tags="select * from productos where estado_idestado=1 ";
if(!empty($_GET["parametro1"])){
  $tags.=" and titulo_rewrite='".$_GET["parametro1"]."' ";    
  $detalle=executesql($tags);
  if(!empty($detalle)){ 
    $titulo_h3='<h5 class="amatic bold blanco large-text-left medium-text-left text-center"><a href="productos">Producto</a> / '.$detalle[0]["titulo"].'</h5>';
    $title="Ventas de Snacks de Frutas Deshidratadas, alimento saludable, rico, fitnes". $detalle[0]["titulo"]." /NAYNUT";
    $des="Venta de snack de fruta deshidratada. Los más deliciosos snack de frutas deshidratadas, manzana, piña";
    $img=(!empty($detalle[0]["imagen"]))?$dir.$detalle[0]["imagen"]:"";
  }  
}else{
  $titulo_h3='<h5 class="amatic bold blanco large-text-left medium-text-left text-center">Nuestros productos:</h5>';
  $detalle=executesql($tags);
  if(!empty($detalle)){    
    $title="Ventas de Snacks de Frutas Deshidratadas, alimento saludable, rico, fitnes / NAYNUT - Naturalmente nutritivo";
    $des="Venta de snack de fruta deshidratada. Los más deliciosos snack de frutas deshidratadas, manzana, piña.";
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
if(!empty($_GET["parametro1"])){ //si encuentr directo el producto
  $sql="select * from productos where estado_idestado=1 and titulo_rewrite='".$_GET["parametro1"]."' ";    
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
              <h1 class="amatic"><?php echo $detalle[0]["titulo"];?></h1>
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
              <form id ="ruta-<?php echo $detalle[0]["id_producto"]; ?>" class="add" method="POST" action="process_cart/insert.php" accept-charset="UTF-8">       
                  <input type="hidden" name="id"  value="<?php echo $detalle[0]["id_producto"] ?>">
                  <input type="hidden" name="imagen"  value="<?php echo $imgproduct ; ?>">
                  <input type="hidden" name="nombre"  value="<?php echo $detalle[0]["titulo"]; ?>" id="nombre">        
                  <input type="hidden" name="precio"  value="<?php echo $precio; ?>" id="precio">           
                <label class="osans em" style="color:#FF0000;">Cantidad:</label>
                <input type="number" value="1" min="1" max="100" required onkeypress='javascript:return soloNumeros(event,0);' id="cantidad" name="cantidad" style='width:60px;'>
                <div class="large-12 columns" style="padding-left:0;margin-bottom:25px;">
                  <button class="osans bold btn botones  hola"></button>
                </div><!-- l **12 prod-->
              </form>
               <?php include("inc/compartir_con.php"); ?>
            </div><!-- l6-->
              
            <div class="large-12 contenido columns end">
              <div class="izq aparecer end">
                <div class="llamar">
                  <div class="float-left"><img src="img/iconos/llamar-pro.png"></div>
                  <div class="float-right text-left">
                    <blockquote class="gulim bold color-1">CONSÚLTANOS </br>DIRECTAMENTE </br><span>POR ESTE PRODUCTO</span></blockquote>
                    <h5 class="gulim bold bold" style="color:#060709;">945360531</h5>
                  </div>
                </div>
                <div class="datos-de-envio" style="padding:5px;">
                  <p class="rel osans"><img src="img/iconos/natural.png" class="abs">Productos 100% naturales</p>
                  <p class="rel osans"><img src="img/iconos/delivery.png" class="abs">Envios a nivel nacional.</p>
                </div>         
              </div>
<?php if(!empty($detalle[0]["especificaciones"])){ ?>
              <div class="especi">
                <h4 class="amatic bold">Descripción:</h4>
                <?php echo $detalle[0]["especificaciones"]; ?>
              </div>
<?php }
    if(!empty($detalle[0]["detalle"])){ ?>
              <div class="especi">
                <h4 class="amatic bold">Beneficios:</h4>
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
                <h4 class="amatic bold">Video</h4>
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
              <h5 class="gulim bold bold" style="color:#060709;">945360531</h5>
            </div>
          </div>
          <div class="datos-de-envio" style="padding:5px;">
            <p class="rel osans"><img src="img/iconos/natural.png" class="abs" style="left:8px;">Productos 100% naturales.</p>
            <p class="rel osans"><img src="img/iconos/delivery.png" class="abs">Envios a nivel nacional.</p>
          </div>         
        </div>
<?php }else{ ?>
        <p class="osans em  text-center" style="padding:150px 0;">... No se encontro producto.</p>
<?php }//end detalle producto 
//product relacionados //acomodar esto a
$sql="select * from productos where estado_idestado=1 ORDER BY orden DESC " ;
$relacionados=executesql($sql);
if(!empty($relacionados)){ ?>
        <div class="large-12 relacionados columns">
          <h4 class="amatic bold">PRODUCTOS RELACIONADOS </h4>
          <ul class="no-bullet carousel-3 text-center">
<?php
foreach($relacionados as $row){
  $img_pro=!empty($row["imagen"])?$dir.$row["imagen"]:$notimg;
   $link="productos/".$row["titulo_rewrite"]; ?>                   
          <div class="large-4 medium-4 columns minh-pro end">
     <?php include("inc/producto.php");?>
          </div>       
<?php }//for ?>        
          </ul>
<?php }//si exis relacionados ?>        
        </div><!-- l12 -->         
<?php //end productos relaciondos
}else{ //Listado ?>
  <div class="large-11 large-centered columns">
<?php $sql = "SELECT * from productos WHERE estado_idestado=1 ORDER BY orden DESC ";
      $exsql = executesql($sql);
  if(!empty($exsql)){
    foreach($exsql as $row){
      $img_pro = !empty($row["imagen"])?$dir.$row["imagen"]:$notimg;
      $link="productos/".$row["titulo_rewrite"];
?>        
     <div class="large-4  medium-4 small-6 columns text-center minh-pro end"><?php include("inc/producto.php");?></div>    
<?php }}else{ ?>
    <p class="osans em  text-center color-1" style="padding:100px 0;">No se encontro productos ... </p>
<?php } ?>
  </div>
<?php } ?>
</div></div>        
</main> 
<?php include('inc/footer.php'); ?>