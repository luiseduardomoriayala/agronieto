<?php include 'auten.php'; 
$_SESSION["url"]=url_completa();
$pagina="blog";
$meta= array(
  'title' => 'Blog / Naynut - Naturalmente Nutritivo',
  'keywords' => ' ',
  'description' => ' ',
);
include('inc/header.php');?>
<main id="prensa" class="margin-interno">
<div class="callout-f"><div class="row">
  <h5 class="gulim bold blanco text-center">Publicaciones de interés</h5>
</div></div>
<div class="callout callout-1"><div class="row">
  <div class="large-12 columns">
    <div id="listado_prensas" class="load-content">
      <p class="text-center" style="padding-top:100px;">Espere mientras listado se va cargando ...   </p>
    </div>
  </div>				
</div></div>				
</main>				
<?php include('inc/footer.php'); ?>
