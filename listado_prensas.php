<?php
include('auten.php');
  $sql="select * from publicacion   order by orden desc ";

$custom = array();
$custom['sql'] = $sql;
$custom['div'] = 'listado_prensas';
$custom['params'] = isset($_POST) ?array_keys($_POST) : array();
$custom['pages']  = 4;

$paging = configurar_paginador($custom);

if($paging->numTotalRegistros>0){
?>
            <div class="row">
<?php while ($detalles = $paging->fetchResultado()):      
      $url='blog/'.$detalles['titulo_rewrite']; 
			$img= 'intranet/files/images/publicaciones/'.$detalles['imagen'];
      
$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
$fecha= strtr(date('\<\s\p\a\n\>d\<\/\s\p\a\n\> M Y',strtotime($detalles['fecha_registro'])),$meses);

 ?>    
      <div class="large-6 gulim medium-6 columns end pd" >
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
              <h2 class="gulim"><?php echo short_name($detalles['titulo'],100); ?></h2>
              <a href="<?php echo $url; ?>" class="btn botones"><strong> Leer</strong> contenido</a>             
            </div> 
          </div>
        </a>
      </div>

<?php endwhile; ?>
            </div>
            <div class="pagination" role="navigation" arial-label="Pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<?php
  }else{ echo "<p class='text-center' style='padding:70px 0;'>No se encontro publicaciones ...</p>";}
?>