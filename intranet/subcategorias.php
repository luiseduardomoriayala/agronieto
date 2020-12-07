<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");
if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"]; 
  $id_del_registro_actual=$_GET["idsub"];
  $criterio_Orden ="";
  nuevoorden($orden_actual, $orden_nuevo, $id_del_registro_actual, "subcategorias", "idsub", $criterio_Orden);    
  $bd->close();
}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $where=($_GET["task"]=='update') ? " and idsub!='".$_POST["idsub"]."'" : "";
  $urlrewrite=armarurlrewrite($_POST["nombre"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"subcategorias","idsub","nombre_rewrite",$where);
  $norden=_orden_noticia("","subcategorias","");
  $campos=array('idcat',"nombre",array("nombre_rewrite",$urlrewrite),"estado_idestado");
  if($_GET["task"]=='insert'){
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen']= carga_imagen('files/images/subcategorias/','imagen','');
      $campos=array_merge($campos,array('imagen'));
    }
    // $_POST['fecha_registro']=fecha_hora(2);
    $_POST["idsub"]=$bd-> inserta_(arma_insert('subcategorias',array_merge($campos,array(array("orden",$norden))),'POST'));    
  }else{
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/subcategorias/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/subcategorias/','imagen','');
      $campos = array_merge($campos,array('imagen'));
    }
    $bd->actualiza_(armaupdate('subcategorias',array_merge($campos)," idsub='".$_POST["idsub"]."'",'POST'));/*actualizo*/
  } 
  
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
  
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
   $usuario=executesql("select * from subcategorias where idsub='".$_GET["idsub"]."'",0);
  }
?>
<section class="content">
  <div class="row"><div class="col-md-12">         
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Nueva'; ?> Marca</h3>
      </div>
<?php $task_=$_GET["task"]; ?>
      <form action="subcategorias.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF" onsubmit="return aceptar()">
<?php
if($task_=='edit') create_input("hidden","idsub",$usuario["idsub"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link2,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
      <div class="box-body">
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Estado</label>
          <div class="col-sm-6">
            <?php crearselect("estado_idestado","select * from estado",'class="form-control"',$usuario["estado_idestado"],""); ?>
          </div>
        </div>
				<div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Categoria</label>
          <div class="col-sm-6">
            <?php crearselect("idcat","select idcat, nombre from categorias where estado_idestado=1 ",'class="form-control" required',$usuario["idcat"]," -- selecione  --"); ?>
          </div>
        </div>        
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Nombre</label>
          <div class="col-sm-6">
            <?php create_input("text","nombre",$usuario["nombre"],"form-control",$table,"required",$agregado); ?>
          </div>
        </div>
        
<?php /*
        <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Imágen</label>
              <div class="col-sm-3">
                <input type="file" name="imagen" id="imagen" class="form-control">
                <?php create_input("hidden","imagen_ant",$usuario["imagen"],"",$table,$agregado); 
                  if($usuario["imagen"]!=""){ 
                ?>
                  <img style="height:70px;" src="<?php echo "files/images/subcategorias/".$usuario["imagen"]; ?>" width="200" class="mgt15">
                <?php } ?> 
              </div>
        </div> 
*/ ?>

      </div>
      <div class="box-footer">
        <div class="form-group">
          <div class="col-sm-10 pull-right">
            <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
            <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link2; ?>');">Cancelar</button>
          </div>
        </div>
      </div>    
<script>	
function aceptar(){
	var nam1=document.getElementById("nombre").value;		
	// var nam6=document.getElementById("imagen").value;
	
	if(nam1 !=''){									
		alert("Registrando  .. click en aceptar y esperar..");							
		document.getElementById("btnguardar").disabled=true;			
	}else{		
		alert("Recomendación: Ingresa al menos el nombre  :)");
		return false; //el formulario no se envia		
	}
	
}				
</script>
			</form>    </div><!-- /.box -->
  </div></div><!--row / col12 -->
</section><!-- /.content -->
<?php
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  if($_SESSION["visualiza"]["idtipo_usu"]==1){      $bd = new BD;
    $bd->Begin();
    $ide = !isset($_GET['idsub']) ? implode(',', $_GET['chkDel']) : $_GET['idsub'];
    // $publicacion = executesql("SELECT * FROM subcategorias WHERE idsub IN(".$ide.")");
    // if(!empty($publicacion)){
      // foreach($publicacion as $row){
      // linkde img
      // }
    // } 
    // $bd->actualiza_("DELETE FROM table WHERE idsub IN(".$ide.")");
    $bd->Commit();
    $bd->close();  }
}elseif($_GET["task"]=='ordenar'){
  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $num_afect=$bd->actualiza_("UPDATE subcategorias SET orden= ".$orden." WHERE idsub = ".$item."");
  }
  $bd->close();  
	
}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['idsub']) ? $_GET['estado_idestado'] : $_GET['idsub'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $usuario = executesql("SELECT * FROM subcategorias WHERE idsub IN (".$ide.")");
  if(!empty($usuario))
  foreach($usuario as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE subcategorias SET estado_idestado=".$state." WHERE idsub=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
	
}elseif($_GET["task"]=='finder'){
   $sql = "SELECT d.*,e.nombre AS estado, m.nombre as marca  FROM subcategorias d 
  INNER JOIN categorias m ON m.idcat=d.idcat  INNER JOIN estado e ON d.estado_idestado=e.idestado  "; 
    if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (d.nombre LIKE '%".$stringlike."%')"; // es ara buscar escribiend nombres 
  }
	 if (!empty($_GET['categ_search'])) {
        $sql .= " AND d.idcat = " . $_GET['categ_search'];
    }

  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY orden DESC";
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
  $paging->pagina_proceso="subcategorias.php";
?>
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr role="row">
          <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
          <th class="sort  unafbe">Categoria</th> 
          <th class="sort  unafbe">Nombre</th> 
          <th class="sort  "width="70">ESTADO</th>
          <th class="unafbe" width="100">Opciones</th>
        </tr>
      </thead>
      <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
        <tr id="order_<?php echo $detalles["idsub"]; ?>">
          <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["idsub"]; ?>" id="id"></td>
          <td ><?php echo $detalles["marca"]; ?></td>
          <td ><?php echo $detalles["nombre"]; ?></td>                      
          <td class=""><a href="javascript: fn_estado('<?php echo $detalles["idsub"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
          <td><div class="btn-eai btr text-center">
         <?php if($_SESSION["visualiza"]["idtipo_usu"]==1 || $_SESSION["visualiza"]["idtipo_usu"]==2){ ?>
              <a href="<?php echo $_SESSION["base_url"].'&task=edit&idsub='.$detalles["idsub"]; ?>"><i class="fa fa-edit"></i></a>
         <?php } ?>
          </div></td>
        </tr>
<?php endwhile; ?>
      </tbody>
    </table>
    <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  reordenar('subcategorias.php');
  checked();
  sorter();
});
</script>
<?php }else{ ?>
  <div class="box-body">
    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
      <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
        <div class="bg-gray-light">
          <div class="col-sm-2">
            <div class="btn-eai">
              <a href="<?php echo $link2."&task=new"; ?>" style="color:#fff;"><i class="fa fa-file"></i> Nuevo</a>
            </div>
          </div>
          <div class="col-sm-3 criterio_buscar">
							<?php crearselect("categ_search", "select idcat,nombre from categorias where estado_idestado=1 order by nombre asc", 'class="form-control" ', '', "-- categorias. --"); ?>
					</div>         
          <div class="col-sm-3 criterio_mostrar">
            <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="buscar"'); ?>
          </div>
					<div class="col-sm-3 criterio_mostrar">
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
var link = "submarca";/*la s final se agrega en js fuctions*/
var us = "submarca";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "a";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "la";
var ar = "el";
var id = "idsub";
var mypage = "subcategorias.php";
</script>
<?php } ?>