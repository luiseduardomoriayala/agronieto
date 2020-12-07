<?php include('auten.php');
$_SESSION["url"]=url_completa();
$pagina="blog";$pagina2="con-color";
$publi=executesql("select * from publicacion  where titulo_rewrite='".$_GET["rewrite1"]."' order by orden desc limit 0,1");
if(!empty($publi)){ 
  $nombre=$publi[0]["titulo"];$avance=$publi[0]["avance"];
  $des=short_name($publi[0]["avance"],200);$imggo="intranet/files/images/publicaciones/".$publi[0]["imagen"];
}else{ $nombre="Blog / Naynut - Naturalmente Nutritivo "; $des=$avance="Blog / Naynut - Naturalmente Nutritivo";$imggo=""; }
$meta= array(
		'title' => $nombre,
		'keywords' => $avance,
		'description' => $des,
		'img' => $imggo
	);
include('inc/header.php');
 ?>
  
<?php if(!empty($_GET["rewrite1"])){ ?>
<div id="prensa-cont" class="margin-interno">
  <div class="callout callout-f"><div class="row">
    <h5 class="gulim bold blanco large-6 medium-6 small-6 columns large-text-left text-center" style="padding-top:8px;">BLOG:</h5>  
    <a href="blog" class="large-6 columns gulim btn text-right">RETORNAR</a>
  </div></div> 
  
  <div class="callout callout-2"><div class="row">				
<?php 

$rs =executesql("select * from publicacion  where estado_idestado=1 and  titulo_rewrite='".$_GET['rewrite1']."' ");
if(!empty($rs)){
  foreach($rs as $row){
    $img='intranet/files/images/publicaciones/'.$row['imagen']; 
    $meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
    $fecha= strtr(date('\<\s\p\a\n\>d\<\/\s\p\a\n\> M Y',strtotime($row['fecha_registro'])),$meses); 
 ?>
    <div class="large-12 columns"><div class="row">		
      <div class="large-9 medium-10 large-centered medium-centered columns text-center" itemscope itemtype="http://schema.org/Article" >
        <article>
          <img src="<?php echo $img;?>" class="img-1" alt="<?php echo $row["titulo"];?>" itemprop="image">
          <h1 class="gulim titulo color-1 text-left" ><?php echo $row['titulo']; ?></h1>
        </article>
        <aside>
          <div  id="twete" class="pd">
            <p class="float-left em fecha" itemprop="datePublished"><?php echo $fecha; ?></p>
            <div class=" text-right">
              <p style="display:inline-block;">Compártelo:</p>
              <?php include("inc/compartir_blog.php"); ?>
            </div>
          </div>
        </aside>
        <article>
          <h3 class=" avance text-left" itemprop="name"><?php echo $row['avance']; ?></h3>
          <div class=" text-left" itemprop="description"><?php echo $row['descripcion']; ?>  </div>
        </article>
      </div>
    </div></div><!-- l12 -->
<?php }  } ?> 
  </div></div>	
</div>

<?php } 
 include('inc/footer.php'); ?>