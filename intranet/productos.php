<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id_producto"];
  $criterio_Orden ="";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "productos", "id_producto", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $norden=_orden_noticia("","productos","");
  $where= " and id_producto !='".$_POST["id_producto"]."' ";
  $urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"productos","id_producto","titulo_rewrite",$where);
  
  $campos=array('idcat','idsub','id_marca',"titulo",array("titulo_rewrite",$urlrewrite),"stock","tipo","igv","precio","costo_promo","garantia","link","puntuales","especificaciones","detalle","estado_idestado");
  // if(isset($_POST['id_marca'])) $campos = array_merge($campos,array('id_marca'));
  $dir  = "files/images/productos/";
  $dir2 = "files/files/productos/";
  
	if($_GET["task"]=='insert'){
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen($dir,'imagen','');
      $campos = array_merge($campos,array('imagen'));
    }   
		$_POST["id_producto"]=$bd->inserta_(arma_insert('productos',array_merge($campos,array(array("orden",$norden))),'POST'));
		
		// echo var_dump(arma_insert('productos',array_merge($campos,array(array("orden",$norden))),'POST'));
		// exit();
		
	}else{
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = $dir.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen($dir,'imagen','');
      $campos = array_merge($campos,array('imagen'));
    }    
		$bd->actualiza_(armaupdate('productos',$campos," id_producto='".$_POST["id_producto"]."'",'POST'));
	}
	$bd->close();
	gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);  
  
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from productos where id_producto='".$_GET["id_producto"]."'",0);
  }
?>
<script src="ckeditor/sample.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="ckfinder/ckfinder.js"></script>

<section class="content">
  <div class="row">
    <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">
                <?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Nueva'; ?> Producto</h3>
            </div>
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form id="registro" action="productos.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST"  enctype="multipart/form-data">
<?php 
if($task_=='edit') create_input("hidden","id_producto",$data_producto["id_producto"],"",$table,""); 

create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_pro,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
				<div class="box-body">
					<div class="form-group">
					  <label for="inputEmail3" class="col-sm-2 control-label">Estado</label>
					  <div class="col-sm-6">
						<?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_producto["estado_idestado"],""); ?>
					  </div>
					</div>
					
							
					<div class="form-group">
					  <label for="inputEmail3" class="col-sm-2 control-label">CATEGORÍA</label>
						<div class="col-sm-3 criterio_buscar">
									<?php crearselect("idcat", "select idcat,nombre from categorias where estado_idestado=1 order by nombre asc", 'class="form-control" requerid  onchange="javascript:display(\'productos.php\',this.value,\'cargar_subcategorias\',\'idsub\')"', $data_producto["idcat"], "-- categorias --"); ?>
						</div>
					</div>
							
					<div class="form-group">
					  <label for="inputEmail3" class="col-sm-2 control-label">SUB_CATEGORÍA</label>
					  <div class="col-sm-6">
							<?php if($task_=='edit'){  $sql="select idsub,nombre from subcategorias WHERE idcat='".$data_producto["idcat"]."' "; ?>
								<select name="idsub" id="idsub" class="form-control" >
									<option value="" >-- subcateg. --</option>
									<?php 
											$listaprov=executesql($sql);
											foreach($listaprov as $data){ ?>
										<option value="<?php echo $data['idsub']; ?>" <?php echo ($data['idsub']==$data_producto["idsub"])?'selected':'';?> > <?php echo $data['nombre']?></option>
											<?php } ?>
								</select>
							
							<?php }else{ ?>
							<select name="idsub" id="idsub" class="form-control" ><option value="" selected="selected">-- subcateg. --</option></select>
							<?php } ?>
						</div>
					</div>      

					
					<div class="form-group">
					  <label for="inputEmail3" class="col-sm-2 control-label">Marca</label>
					  <div class="col-sm-6">
						<?php crearselect("id_marca","select id_marca, nombre from marcas where estado_idestado=1 order by orden desc",'class="form-control"',$data_producto["id_marca"]," -- seleccione --"); ?>
					  </div>
					</div>
					<div class="form-group">
					  <label for="inputPassword3" class="col-sm-2 control-label">Título</label>
					  <div class="col-sm-6">
						<?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"required",$agregado); ?>
					  </div>
					</div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Destacado:</label>
            <div class="col-sm-2">
              <select id="tipo" name="tipo" class="form-control" required>  <!-- saco valor desde la BD -->
                <option value="" >--</option>  
                <option value="1" <?php echo ($data_producto['tipo'] == 1) ? 'selected' : '' ;?>>Si</option>  
                <option value="2"  <?php echo ($data_producto['tipo'] == 2) ? 'selected' : '' ;?>>No</option>
              </select>
            </div>
            <label for="inputEmail3" class="col-sm-1 control-label">Stock:</label>
            <div class="col-sm-2">
              <select id="stock" name="stock" class="form-control" required>  <!-- saco valor desde la BD -->
                <option value="" >--</option>  
                <option value="1" <?php echo ($data_producto['stock'] == 1) ? 'selected' : '' ;?>>Si</option>  
                <option value="2"  <?php echo ($data_producto['stock'] == 2) ? 'selected' : '' ;?>>No</option>
              </select>
            </div>
            <label for="inputEmail3" class="col-sm-1 control-label" required>Inc. IGV</label>
            <div class="col-sm-2">
              <select id="igv" name="igv" class="form-control">  <!-- saco valor desde la BD -->
                <option value="" >--</option>  
                <option value="1" <?php echo ($data_producto['igv'] == 1) ? 'selected' : '' ;?>>Si</option>  
                <option value="2"  <?php echo ($data_producto['igv'] == 2) ? 'selected' : '' ;?>>No</option>
              </select>
            </div>
					</div>
          
           <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Precio S/. </label>
              <div class="col-sm-2">
                <?php create_input("text","precio",$data_producto["precio"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,2);'"); /* el 2 permite poner  decmales */?> 
              </div>
              <label for="inputPassword3" class="col-sm-2 control-label">Promoción S/.</label>
              <div class="col-sm-2">
                <?php create_input("text","costo_promo",$data_producto["costo_promo"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,2);'"); ?>
              </div>
            </div>
          
          <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Imágen </label>
              <div class="col-sm-6">
                <input type="file" name="imagen" id="imagen" class="form-control" >
                 <p style="color:red;">Tamaño referencial:500px ancho x 452px altura</p>

                <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                  if($data_producto["imagen"]!=""){ 
                ?>
                  <img src="<?php echo "files/images/productos/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
                <?php } ?> 
              </div>
          </div>
          
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Enlace Video</label>
            <div class="col-sm-6">
              <?php create_input("text","link",$data_producto["link"],"form-control",$table,"",$agregado); ?>
            <iframe frameborder="0" width="100%" height="260" class="lvideo"></iframe>
            </div>
          </div>


          <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Características puntuales:</label>
              <div class="col-sm-8">
                <?php create_input("textarea","puntuales",$data_producto["puntuales"],"",$table,$agregado);  ?>
                <script>
                var editor11 = CKEDITOR.replace('puntuales',{toolbar:[['Bold','Italic','Underline','-','BulletedList']]});
                CKFinder.setupCKEditor( editor13, 'ckfinder/' );
                </script> 
              </div>
          </div>
          <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Descripcion:</label>
              <div class="col-sm-8">
                <?php create_input("textarea","especificaciones",$data_producto["especificaciones"],"",$table,$agregado);  ?>
                <script>
                var editor11 = CKEDITOR.replace('especificaciones');
                CKFinder.setupCKEditor( editor12, 'ckfinder/' );
                </script> 
              </div>
          </div>
          <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Equipamiento:</label>
              <div class="col-sm-8">
                <?php create_input("textarea","detalle",$data_producto["detalle"],"",$table,$agregado);  ?>
                <script>
                var editor11 = CKEDITOR.replace('detalle');
                CKFinder.setupCKEditor( editor11, 'ckfinder/' );
                </script> 
              </div>
          </div>
      </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <button type="submit" class="btn bg-blue btn-flat">Guardar</button>
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link_pro; ?>');">Cancelar</button>
                  </div>
                </div>
              </div>
            </form>
          </div><!-- /.box -->
        </div><!--/.col (right) -->
  </div>
</section><!-- /.content -->
<?php
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_producto']) ? implode(',', $_GET['chkDel']) : $_GET['id_producto'];
  $product = executesql("SELECT * FROM productos WHERE id_producto IN(".$ide.")");
  if(!empty($product)){
    foreach($product as $row){
      $dire ='productos/';
      $pfile = 'files/images/'.$dire.$row['imagen']; if(file_exists($pfile) && !empty($row['imagen'])){ unlink($pfile); }
      $pfile = 'files/galeria/productos/'.$row['id_producto']; if(file_exists($pfile)){ rrmdir($pfile); }
    }
  } 
  $bd->actualiza_("DELETE FROM galeria_producto WHERE id_producto IN(".$ide.")");
  $bd->actualiza_("DELETE FROM productos WHERE id_producto IN(".$ide.")");
  $bd->Commit();
  $bd->close();

  if($num_afect<=0){echo "Error: eliminando registro"; exit;}

}elseif($_GET["task"]=='ordenar'){
  $bd = new BD;

  $_GET['order'] = array_reverse($_GET['order']);

  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $num_afect=$bd->actualiza_("UPDATE productos SET orden= ".$orden." WHERE id_producto = ".$item."");
  }

  $bd->close();

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_producto']) ? $_GET['estado_idestado'] : $_GET['id_producto'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $productos = executesql("SELECT * FROM productos WHERE id_producto IN (".$ide.")");
  if(!empty($productos))
  foreach($productos as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE productos SET estado_idestado=".$state." WHERE id_producto=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){

  $sql = "SELECT p.*, c.nombre as categ, s.nombre as subcateg, e.nombre as estado FROM productos p INNER JOIN estado e ON p.estado_idestado=e.idestado 
INNER JOIN categorias c ON p.idcat=c.idcat  
LEFT JOIN subcategorias s ON p.idsub=s.idsub  
  ";
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " where p.titulo LIKE '%".$stringlike."%' or c.nombre LIKE '%".$stringlike."%' or s.nombre LIKE '%".$stringlike."%' ";
  }
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY p.orden DESC";
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");
  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->ejecutar();
  $paging->pagina_proceso="productos.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
                  <th class="sort">CATEG</th>
                  <th class="sort">SUBCATEG</th>
                  <th class="sort">TITULO</th>
                  <th class="sort">Imagen</th>
                  <th class="sort">Precio</th>
                  <th class="sort">Precio Oferta</th>
                  <th class="sort cnone">ESTADO</th>
                  <th class="unafbe">Opciones</th>
                </tr>
              </thead>
              <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
                <tr id="order_<?php echo $detalles["id_producto"]; ?>">
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["id_producto"]; ?>"></td>
                  <td><?php echo $detalles["categ"]; ?></td>
                  <td><?php echo $detalles["subcateg"]; ?></td>
                  <td><?php echo $detalles["titulo"]; ?></td>
                  <td class="cnone">
                    <?php if(!empty($detalles["imagen"])){ ?>
                    <img src="<?php echo "files/images/productos/".$detalles["imagen"]; ?>" class="img-responsive">
                    <?php }else{ echo "Not Image."; } ?>
                  </td>                                  
                  <td><?php echo $detalles["precio"]; ?></td>
                  <td><?php echo $detalles["costo_promo"]; ?></td>
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_producto"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td>
                    <div class="btn-eai btr">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_producto='.$detalles["id_producto"]; ?>"><i class="fa fa-edit"></i></a>
                      <a href="index.php?page=galeria_productos&id_producto=<?php echo $detalles['id_producto']; ?>&module=Productos&parenttab=Registrar"><i class="fa fa-picture-o"></i></a>
<?php if($_SESSION["visualiza"]["idtipo_usu"]==1 ){ ?>                      
                      <a href="javascript: fn_eliminar('<?php echo $detalles["id_producto"]; ?>')"><i class="fa fa-trash-o"></i></a>
<?php } ?>                      
                      
                    </div>
                  </td>
                </tr>
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  reordenar('productos.php');
  checked();
  sorter();
});
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <input type="hidden" name="id_tipopro" value="<?php echo $_GET["id_tipopro"];?>">
              <div class="bg-gray-light">
                <div class="col-sm-10">
                  <div class="btn-eai">
                    <a href="<?php echo $link_pro."&task=new"; ?>"><i class="fa fa-file"></i></a>
              <!-- <a href="javascript:fn_delete_all();"><i class="fa fa-trash-o"></i></a> -->
                  </div>
                </div>
                <div class="break"></div>
                <div class="col-sm-3 criterio_buscar">
                  <label for="">Criterio</label>
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,$agregados); ?>
                </div>
                <div class="col-sm-3 criterio_mostrar">
                  <label for="">N° Registros</label>
                  <?php select_sql("nregistros"); ?>
                </div>
              </div>
            </form>
            <div class="row">
              <div class="col-sm-12">
                <div id="div_listar"></div>
                <div id="div_oculto" style="display: none;"></div>
              </div>
            </div>
            </div>
        </div>
<script>
var link = "producto";
var us = "producto";
var l = "e";
var l2 = "o";
var pr = "el";
var ar = "el";
var id = "id_producto";
var mypage = "productos.php";
</script>
<?php } ?>