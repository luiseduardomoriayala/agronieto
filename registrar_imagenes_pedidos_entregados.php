<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="intranet/dist/css/skin-blue.css">
<link rel="stylesheet" href="intranet/dist/css/sweetalert.css">
<link rel="stylesheet" href="intranet/dist/css/dropzone.css">
<link href="intranet/dist/js/magnific-popup/magnific-popup.css" rel="stylesheet">
<link rel="stylesheet" href="intranet/dist/css/main.css?ud=<?php echo $unix_date ; ?>" >
<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id_image"];
  $criterio_Orden ="";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "productos_entregados", "id_image", $criterio_Orden);    
  $bd->close();

}elseif($_GET['task']=='insert'){
  $bd=new BD;

	$car = (isset($_POST['id_suscrito']) AND $_POST['id_suscrito']>0) ? $_POST['id_suscrito'] : 0;//el cero es para productos_entregados de empresas
    $dir = "intranet/files/images/entrega_de_productos/".$car.'/';
    $norden=_orden_noticia("","productos_entregados","");
    $campos= array("id_suscrito",array("orden", $norden), array("estado_idestado", 1));
	
	if(isset($_FILES['file']) && !empty($_FILES['file']['name'])){
      $_POST['imagen'] = carga_imagen($dir,'file','');
      $campos = array_merge($campos,array('imagen'));
    }
	
	
	$sql=arma_insert("productos_entregados",$campos,"POST");
      $bd->inserta_($sql);
    $bd->close();

}elseif($_GET['task']=='update'){
    
    $bd = new BD;
    if(isset($_POST['nombre'])){
        // echo var_dump($_POST['nombre']);
        // exit;
        foreach($_POST['nombre'] as $k => $row){
           $bd->actualiza_( armaupdate('productos_entregados',array(array("nombre",$row[0]))," id_image='".$k."'",'POST')); /*actualizo*/
        }
    }
    $bd->close();
    gotoUrl("perfil/publicar-productos-entregados");  
 
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  
  $bd = new BD;
  $bd->Begin();
  $id_image = !isset($_GET['id_image']) ? implode(',', $_GET['chkDel']) : $_GET['id_image'];
  $productos = executesql("SELECT id_suscrito,imagen FROM productos_entregados WHERE id_image IN(".$id_image.")");
  if(!empty($productos)){
    foreach($productos as $row){
      $pfile = 'intranet/files/images/entrega_de_productos/'.$row['id_suscrito'].'/'.$row['imagen']; 
      if(file_exists($pfile) && !empty($row['imagen'])) unlink($pfile);
    }
  }

  $bd->actualiza_("DELETE FROM productos_entregados WHERE id_image IN(".$id_image.")");

  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='ordenar'){
  $bd = new BD;

  $_GET['order'] = array_reverse($_GET['order']);

  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $num_afect=$bd->actualiza_("UPDATE productos_entregados SET orden= ".$orden." WHERE id_image = ".$item."");
  }

}elseif($_GET["task"]=='finder'){

  $sql.= "SELECT i.*, e.nombre AS estado FROM productos_entregados i inner join  estado e ";
  $sql.= " WHERE i.estado_idestado=e.idestado ";
  $sql.= isset($_GET['id_suscrito']) ? " AND i.id_suscrito='".$_GET['id_suscrito']."'" : '';
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  
  $sql.= " ORDER BY orden DESC";
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  //$numregistro=1; 
  //if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $ip = 1500;
  // $mantenerVar=array("criterio_mostrar","task");
  // $paging->mantenerVar($mantenerVar);
  $paging->porPagina(fn_filtro($ip));
  $paging->ejecutar();
  $paging->pagina_proceso="registrar_imagenes_pedidos_entregados.php";
?>
       <form action="registrar_imagenes_pedidos_entregados.php?task=update" class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF">
            <input type="hidden" name="id_suscrito" value="<?php echo $ide_suscrito;?>">    
            <div class="box-body">
              <div class="dai">
                <input type="checkbox" id="chkDel" class="all">&nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="javascript:fn_delete_all();"><i class="fa fa-trash-o"></i></a>
                <button  style="margin-left:20px;">Guardar</button>
              </div>
              <div class="gallery">
                <ul id="sort" class="reorder_ul reorder-photos-list">
  <?php while ($detalles = $paging->fetchResultado()): ?>
                  <li id="order_<?php echo $detalles['id_image']; ?>" class="ui-sortable-handle">
                    <a href="javascript: fn_eliminar('<?php echo $detalles["id_image"]; ?>')"><i class="fa fa-trash-o delete_image"></i></a>
                    <img src="intranet/files/images/entrega_de_productos/<?php echo $detalles['id_suscrito']."/".$detalles['imagen']; ?>">
                    <?php create_input("text","nombre[".$detalles['id_image']."][]",$detalles["nombre"],"form-control",$table,"","Placeholder='Nombre Imágen'"); ?>
                    <div class="break"></div>
                    <input type="checkbox" name="chkDel[]" class="chk_image chkDel" value="<?php echo $detalles["id_image"]; ?>">
                  </li>
  <?php endwhile; ?>
                </ul>
              </div>
            </div>
        </form>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  reordenar('registrar_imagenes_pedidos_entregados.php');
  checked();
});
</script>
<?php }else{ ?>

<section class="content">
  <div class="row">
    <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">
                Galería de Imágenes</h3>
                <p style="color:red;">Tamaño recomendado: 246px ancho x 265px altura</p>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div id="example1_wrapper">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="image_upload_div">
                      <form action="registrar_imagenes_pedidos_entregados.php?task=insert" id="frm_buscar" class="dropzone">                  
                        <input type="hidden" name="id_suscrito" value="<?php echo $ide_suscrito; ?>">
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="div_listar"></div>
            <div id="div_oculto" style="display: none;"></div>
          </div><!-- /.box -->
        </div><!--/.col (right) -->
  </div>
</section><!-- /.content -->
<script>
var accept = ".png, .jpg, .jpeg, .JPG, .PNG, .JPEG";
var msj = "Click o arrastra tus imágenes para subirlas.";
var link = "registrar_imagenes_pedidos_entregado";
var us = "imagen";
var l = "a";
var l2 = "a";
var pr = "La";
var ar = "la";
var id = "id_image";
var mypage = "registrar_imagenes_pedidos_entregados.php";
</script>
<?php } ?>

<!-- jQuery 2.1.4 -->
<script src="intranet/dist/js/jQuery-2.1.4.min.js"></script>
<!-- SCRIPTS -->
<script src="intranet/dist/js/jquery-ui.js"></script>
<script src="intranet/dist/js/jquery.ui.touch-punch.min.js"></script>
<script src="intranet/dist/js/jquery.tablesorter.js"></script>
<script src="intranet/dist/js/sweetalert.min.js"></script>
<script src="intranet/dist/js/app.min.js"></script>
<script src="intranet/dist/js/bootstrap.min.js"></script>
<script src="intranet/dist/js/functions.js?ud=<?php echo $unix_date ?>"></script>
<script src="intranet/dist/js/dropzone.js"></script>
<script src="intranet/dist/js/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="intranet/dist/js/jquery.validate.min.js"></script>