<?php  include ('auten.php'); $_SESSION["url"]=url_completa(); $pagina="";
$meta= array(
'title' => 'Distribuidor de motosierras, motoguadañas, podadoras de altura, motofumigadoras, pulverizadoras manuales y a motor | Agroforestal Nieto',
'keywords' => 'Distribuidor de motosierras, motoguadañas, podadoras de altura, motofumigadoras, pulverizadoras manuales y a motor ',
'description' =>'istribuidor de motosierras, motoguadañas, podadoras de altura, motofumigadoras, pulverizadoras manuales y a motor. Además de una amplia variedad de repuestos ORIGINALES. Marcas: STHIL, OREGON, JACTO, SOLO.'
);
include('inc/header.php');
$notimg='img/img1-no-disponible.jpg'; ?>

<div class="callout banners  text-center">
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
        <div class="large-6 medium-6  <?php echo (empty($row["imagen2"]))?' large-offset-6  small-12':' small-6 ';?> columns texto amatic ">        
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
     			 
<main id="portada" class="-interno">
<div class="callout callout-1 color-1 ptope"><div class="row text-center">
  <div class="large-10 large-centered ptop columns">
		<h1 class="amatic color-5 bold">Agroforestal Nieto, en chiclayo, piura, trujillo, lima y todo el Perú. </h1>
		<p class="gulim pb">Distribuidor de motosierras, motoguadañas, podadoras de altura, motofumigadoras, pulverizadoras manuales y a motor. Además de una amplia variedad de repuestos ORIGINALES. Marcas: STHIL, OREGON, JACTO, SOLO.</p>		  
  </div> 
 </div></div> 
 
<div class="callout callout-1 <?php echo !empty($_GET["parametro1"])?'':'fondi';?>"><div class="row">       
   <div class="large-11 large-centered columns">
<?php  
$sql = "SELECT p.*, ca.nombre_rewrite as categrew, m.nombre as  marca  from productos p INNER JOIN  categorias ca ON p.idcat=ca.idcat INNER JOIN marcas m ON p.id_marca=m.id_marca  WHERE p.estado_idestado=1 and m.estado_idestado=1 and ca.estado_idestado=1 ORDER BY p.orden DESC limit 0,9 ";
      $exsql = executesql($sql);
  if(!empty($exsql)){
    foreach($exsql as $row){
      $img_pro = !empty($row["imagen"])?$dir.$row["imagen"]:$notimg;
      $link="productos/".$row["categrew"].'/'.$row["titulo_rewrite"];
			
			for($i=1;$i<10;$i++){
?>        
     <div class="large-4  medium-4 small-6 columns text-center minh-pro end"><?php include("inc/producto.php");?></div> 

		 
<?php  }
		}}else{ ?>
    <p class="osans em  text-center color-1" style="padding:100px 0;">No se encontro productos ... </p>
<?php } ?>
  </div>
</div></div>        


<div class="callout callout-4 fondo text-center"><div class="row"><div class="large-12 columns">
  <h4 class="amatic bold rel blanco">Variedad de soluciones en máquinas, repuestos y accesorios STIHL. Pulverizadoras JACTO.</h4>
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
  <h3 class="amatic bold rel blanco">ESTAMOS AQUÍ PARA USTEDES</h3>
</div></div></div>

</main> 
<?php include('inc/footer.php'); ?>