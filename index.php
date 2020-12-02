<?php  include ('auten.php'); $_SESSION["url"]=url_completa(); $pagina="";
$meta= array(
'title' => 'Venta de snack de fruta deshidratada, alimento saludable, rico, fitnes /Naynut - Naturalmente Nutritivo',
'keywords' => 'saludable, alimentacion sana, fibra, salud, sano, alimento, nutritivo, snack, fruta, deshidratado, rico, digestivo, dietetico, calorias, bajo en calorias, alimento, fitnes, venta de snack,fruta deshidratada, alimentos saludables, vida sana, manzana deshidratada, piña deshidratada, platano deshidratada, alimento natural, nutritivo, comida saludable, ansiedad, fibra, snack saludables, snack nutritivo',
'description' =>'Venta de snack a base de fruta deshidratados, fruta deshidratada, alimentos saludables, vida sana, manzana deshidratada, piña deshidratada, platano deshidratada, alimento natural, nutritivo, comida saludable, ansiedad, fibra, snack saludables, snack nutritivo Mantente activo y sacia tu ansiedad. '
);
include('inc/header.php');
$notimg='img/img1-no-disponible.jpg'; ?>
<main id="portada" class="margin-interno">
<div class="callout banners text-center">
<?php $banner = executesql("select * from banners where estado_idestado=1 and (imagen is not null or imagen!='') order by orden desc");
if(!empty($banner)){ ?>
  <ul class="no-bullet hide" id="carousel-1">
  <div class="esperando-slider fondo banner-1"></div>
<?php foreach($banner as $row){ 
        $img_ban = !empty($row["imagen"]) ? "url(intranet/files/images/banners/".$row["imagen"].")" : ""; 
        $img_baner2="intranet/files/images/banners/".$row["imagen2"];?>
    <li class="fondo" style="background-image:<?php echo $img_ban; ?>">
      <div class="row">
    <?php if(!empty($row["titulo"])){ ?>
        <div class="large-6 medium-6 small-6 columns texto amatic ">        
          <?php echo $row["titulo"]; ?>
          <a class="btn botones gulim bold" href="productos">Pídelo Hoy</a>
        </div>
    <?php }?>
    <?php if(!empty($row["imagen2"])){?>
        <div class="large-1 medium-1 small-1 columns"></div>
        <div class="large-5 medium-5 small-5 columns wow bounceInLeft"><img src="<?php echo $img_baner2;?>" class=""></div>
    <?php }?>
      </div>
    </li>
<?php } //for?>
  </ul>
<?php }else{ ?>
  <div class="fondo banner-1"></div>
  <div class="fondo banner-2"></div>
  <div class="fondo banner-3"></div>
<?php } ?>
</div>
     			 
<div class="callout callout-1 color-1 ptope"><div class="row text-center">
  <div class="large-12 columns">
	  <div class="large-6 medium-6 columns ptop">
		<h3 class="amatic color-5 bold">La fruta se disfruta</h3>
		<p class="gulim pb">Ideal para consumir En cualquier momento y en cualquier lugar. <strong>Practico y nutritivo</strong>.</p>	
	  </div>
	  <div class="large-6 medium-6 columns">
		<figure class="rel"><img src="img/252.png" class=""></figure>
	  </div>  
  </div> 
 </div></div> 
 
 <div class="callout callout-1 color-1"><div class="row text-center">  
	<div class="large-12 columns">
  <div class="large-6 medium-6 columns block-b">
	<figure class="rel"><img src="img/253.png" class="img-es"></figure>
  </div>
  <div class="large-6 medium-6 columns">
    <h3 class="amatic color-5 bold">Cuídate entre horas</h3>
    <p class="gulim pb">Cuidarte entre horas es muy recomendable, si eliges y consumes el producto adecuado. La fruta deshidratada es <strong>libre de azucares y grasas</strong>. Ahora Naynut te cuida entre horas es la opción más sana en tu día.
	</p>	
  </div> 
  <div class="large-6 medium-6 columns aparecer">
	<figure class="rel"><img src="img/253.png" class="img-es"></figure>
  </div>
  </div>  
</div></div>  

<div class="callout callout-1 color-1"><div class="row text-center">  
  <div class="large-12 columns">
  <div class="large-6 medium-6 columns">
    <h1 class="amatic color-5 bold">Fuente de energía</h1>
    <p class="gulim pb"><strong>Te mantiene activo</strong> y sacia tu ansiedad, te ayuda a mantener un bajo peso corporal. Proporciona <strong>más fibra</strong> y minerales que una fruta fresca</p>
  </div>
  <div class="large-6 medium-6 columns">
	<figure class="rel"><img src="img/251.png" class=""></figure>
  </div>
  </div>
 </div> </div>
 
 <div class="callout callout-1 color-1" style="padding-bottom:40px;"><div class="row text-center">
  
  <div class="large-12 columns">
  	<div class="large-6 medium-6 columns block-b">
	<figure class="rel"><img src="img/254.png" class="img-es"></figure>
  </div>
  <div class="large-6 medium-6 columns">
    <h1 class="amatic color-5 bold">La fruta deshidratada</h1>
    <p class="gulim pb">La deshidratación permite extraer el agua de la fruta conservando su mismo sabor, propiedades y vitaminas. Dando mayor tiempo de vida al producto sin utilizar ningún aditivo.. Fuente de fibra y fructosa.</p>	
  </div>
  
  <div class="large-6 medium-6 columns aparecer">
	<figure class="rel"><img src="img/254.png" class="img-es"></figure>
  </div>
  </div>
  

  


</div></div>

<div class="callout callout-4 fondo text-center"><div class="row"><div class="large-12 columns">
  <h2 class="amatic bold color-1 wow bounceInUp">Naturalmente Nutritivo</h2>
</div></div></div>


 <div class="callout callout-5"><div class="row">
  <div class="large-text-center columns" >
  <h3 class="amatic bold color-1">Temas de interés <a href="blog">(ver más)</a></h3>
  </div>
  <?php   $sql="select * from publicacion order by orden desc limit 0,2";

  $resultado = executesql($sql);
if(!empty($resultado)){
foreach($resultado as $row){
  $url='blog/'.$row['titulo_rewrite'];
  $img= 'intranet/files/images/publicaciones/'.$row['imagen'];
 $meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
  $fecha= strtr(date('\<\s\p\a\n\>d\<\/\s\p\a\n\> M Y',strtotime($row['fecha_registro'])),$meses);
 ?>    
           <div class="large-6 medium-6 columns end pd" >
        <a href="<?php echo $url; ?>">
          <div  class="fondores">
            <figure>
              <img class="img-responsive" src="<?php echo $img; ?>" alt="<?php echo $detalles['titulo']; ?>">
            </figure>
          </div>
          <div >
            <p><?php echo $fecha; ?></p> 
          </div>
          <div class="fii">
            <div class="float-left">
              <h2 class="olig"><?php echo short_name($row['titulo'],70); ?></h2>
              <a href="<?php echo $url; ?>" class="btn botones"><strong> Leer</strong> contenido</a>             
            </div> 
          </div>
        </a>
      </div>
     <?php } } ?>
</div></div>
<div class="callout callout-3 fondo text-center">
  <a class="abs mascara"></a>
  <div class="row"><div class="large-12 columns">
  <h1 class="amatic bold rel blanco">Fruta 100% deshidratada</h1>
</div></div></div>

</main> 
<?php include('inc/footer.php'); ?>