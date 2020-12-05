<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");
if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"]; 
  $id_del_registro_actual=$_GET["idcat"];
  $criterio_Orden ="";
  nuevoorden($orden_actual, $orden_nuevo, $id_del_registro_actual, "categorias", "idcat", $criterio_Orden);    
  $bd->close();
}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $where=($_GET["task"]=='update') ? " and idcat!='".$_POST["idcat"]."'" : "";
  $urlrewrite=armarurlrewrite($_POST["nombre"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"categorias","idcat","nombre_rewrite",$where);
  $norden=_orden_noticia("","categorias","");
	
  $campos=array("nombre",array("nombre_rewrite",$urlrewrite),'destacado',"estado_idestado");
  if($_GET["task"]=='insert'){
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen']= carga_imagen('files/images/categorias/','imagen','');
      $campos=array_merge($campos,array('imagen'));
    }
    // $_POST['fecha_registro']=fecha_hora(2);
    $_POST["idcat"]=$bd-> inserta_(arma_insert('categorias',array_merge($campos,array(array("orden",$norden))),'POST'));    
  }else{
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/categorias/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/categorias/','imagen','');
      $campos = array_merge($campos,array('imagen'));
    }
    $bd->actualiza_(armaupdate('categorias',array_merge($campos)," idcat='".$_POST["idcat"]."'",'POST'));/*actualizo*/
  } 
  
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
  
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
			echo $sql="select * from categorias where idcat='".$_GET["idcat"]."'";
   $usuario=executesql($sql,0);
  }
?>
<section class="content">
  <div class="row"><div class="col-md-12">         
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Nueva'; ?> Marca</h3>
      </div>
<?php $task_=$_GET["task"]; ?>
      <form action="categorias.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF" onsubmit="return aceptar()">
<?php
if($task_=='edit') create_input("hidden","idcat",$usuario["idcat"],"",$table,"");
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
          <label for="inputPassword3" class="col-sm-2 control-label">Nombre</label>
          <div class="col-sm-6">
            <?php create_input("text","nombre",$usuario["nombre"],"form-control",$table,"required",$agregado); ?>
          </div>
        </div>
        
				<div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Categoria Destacada? <?php // echo $usuario["nombre"].'-'.$usuario['destacado']; ?></label>
            <div class="col-sm-2">
              <select id="destacado" name="destacado" class="form-control" required>  <!-- saco valor desde la BD -->
                <option value="" >--</option>  
                <option value="1" <?php echo ($usuario['destacado'] == 1) ? 'selected' : '' ;?>>Si</option>  
                <option value="2"  <?php echo ($usuario['destacado'] == 2) ? 'selected' : '' ;?>>No</option>
              </select>
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
                  <img style="height:70px;" src="<?php echo "files/images/categorias/".$usuario["imagen"]; ?>" width="200" class="mgt15">
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
    $ide = !isset($_GET['idcat']) ? implode(',', $_GET['chkDel']) : $_GET['idcat'];
    // $publicacion = executesql("SELECT * FROM categorias WHERE idcat IN(".$ide.")");
    // if(!empty($publicacion)){
      // foreach($publicacion as $row){
      // linkde img
      // }
    // } 
    // $bd->actualiza_("DELETE FROM table WHERE idcat IN(".$ide.")");
    $bd->Commit();
    $bd->close();  }
}elseif($_GET["task"]=='ordenar'){
  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $num_afect=$bd->actualiza_("UPDATE categorias SET orden= ".$orden." WHERE idcat = ".$item."");
  }
  $bd->close();  
}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['idcat']) ? $_GET['estado_idestado'] : $_GET['idcat'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $usuario = executesql("SELECT * FROM categorias WHERE idcat IN (".$ide.")");
  if(!empty($usuario))
  foreach($usuario as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE categorias SET estado_idestado=".$state." WHERE idcat=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
}elseif($_GET["task"]=='finder'){
   $sql = "SELECT d.*,e.nombre AS estado  FROM categorias d 
  INNER JOIN estado e ON d.estado_idestado=e.idestado  "; 
    if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (d.nombre LIKE '%".$stringlike."%')"; // es ara buscar escribiend nombres 
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
  $paging->pagina_proceso="categorias.php";
?>
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr role="row">
          <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
          <th class="sort  unafbe">Nombre</th> 
          <th class="sort  unafbe">Destacado</th> 
          <th class="sort cnone" width="80">Imágen</th>
          <th class="sort  "width="70">ESTADO</th>
          <th class="unafbe" width="100">Opciones</th>
        </tr>
      </thead>
      <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
        <tr id="order_<?php echo $detalles["idcat"]; ?>">
          <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["idcat"]; ?>" id="id"></td>
          <td ><?php echo $detalles["nombre"]; ?></td>
          <td ><?php  echo ($detalles['destacado'] == 1)?'SI':'NO'; ?></td>
          <td class="cnone">
            <?php if(!empty($detalles["imagen"])){ ?>
            <img src="<?php echo "files/images/categorias/".$detalles["imagen"]; ?>" alt="<?php echo $detalles["nombre"]; ?>" class="img-responsive">
            <?php }else{ echo "Not Image."; } ?>
          </td>                
          <td class=""><a href="javascript: fn_estado('<?php echo $detalles["idcat"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
          <td><div class="btn-eai btr text-center">
              <a href="<?php echo $_SESSION["base_url"].'&task=edit&idcat='.$detalles["idcat"]; ?>"><i class="fa fa-edit"></i></a>
          </div></td>
        </tr>
<?php endwhile; ?>
      </tbody>
    </table>
    <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  reordenar('categorias.php');
  checked();
  sorter();
});
</script>
<?php }else{ ?>
  <div class="box-body">
    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
      <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
        <div class="bg-gray-light">
          <div class="col-sm-5">
            <div class="btn-eai">
              <a href="<?php echo $link2."&task=new"; ?>"><i class="fa fa-file"></i></a>
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
var link = "categoria";/*la s final se agrega en js fuctions*/
var us = "categoria";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "a";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "la";
var ar = "el";
var id = "idcat";
var mypage = "categorias.php";
</script>
<?php } ?>