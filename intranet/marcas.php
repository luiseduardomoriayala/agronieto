<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");
if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"]; 
  $id_del_registro_actual=$_GET["id_marca"];
  $criterio_Orden ="";
  nuevoorden($orden_actual, $orden_nuevo, $id_del_registro_actual, "marcas", "id_marca", $criterio_Orden);    
  $bd->close();
}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $where=($_GET["task"]=='update') ? " and id_marca!='".$_POST["id_marca"]."'" : "";
  $urlrewrite=armarurlrewrite($_POST["nombre"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"marcas","id_marca","nombre_rewrite",$where);
  $norden=_orden_noticia("","marcas","");
  $campos=array("nombre",array("nombre_rewrite",$urlrewrite),"estado_idestado");
  if($_GET["task"]=='insert'){
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen']= carga_imagen('files/images/marcas/','imagen','');
      $campos=array_merge($campos,array('imagen'));
    }
    // $_POST['fecha_registro']=fecha_hora(2);
    $_POST["id_marca"]=$bd-> inserta_(arma_insert('marcas',array_merge($campos,array(array("orden",$norden))),'POST'));    
  }else{
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/marcas/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/marcas/','imagen','');
      $campos = array_merge($campos,array('imagen'));
    }
    $bd->actualiza_(armaupdate('marcas',array_merge($campos)," id_marca='".$_POST["id_marca"]."'",'POST'));/*actualizo*/
  } 
  $bd->actualiza_("DELETE FROM  marcas_x_tipopro WHERE id_marca='".$_POST["id_marca"]."'");  //elimnado y agrenado nuevamnete los marcas x tipos
  if (isset($_POST['tipos'])){
    foreach($_POST['tipos'] as  $v){
      $campos= array('id_marca',array('id_tipopro',$v));
      $bd->inserta_(arma_insert('marcas_x_tipopro',$campos,'POST'));
    }
  }  
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
  
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
   $usuario=executesql("select * from marcas where id_marca='".$_GET["id_marca"]."'",0);
  }
?>
<section class="content">
  <div class="row"><div class="col-md-12">         
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Nueva'; ?> Marca</h3>
      </div>
<?php $task_=$_GET["task"]; ?>
      <form action="marcas.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF">
<?php
if($task_=='edit') create_input("hidden","id_marca",$usuario["id_marca"],"",$table,"");
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
          <label for="inputEmail3" class="col-sm-2 control-label">Tipos de producto:</label>
          <div class="col-md-4 ">
            <p class="control-label" style="color:red !important;">(Mantener presionado Ctrl, para selecionar)</p>
              <?php 
              $tipos=array();
              $array= executesql("select * from marcas_x_tipopro where id_marca='".$usuario["id_marca"]."'");
              if(!empty($array)) foreach($array as $row) $tipos[]=$row['id_tipopro'];
              ?>
             <?php crearselect("tipos[]","select id_tipopro, nombre from tipo_producto where estado_idestado='1' ORDER BY  nombre ASC ",'class="form-control"  style="height:300px;" multiple',$tipos); ?>
          </div>             
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Nombre</label>
          <div class="col-sm-6">
            <?php create_input("text","nombre",$usuario["nombre"],"form-control",$table,"required",$agregado); ?>
          </div>
        </div>
        
        <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Imágen</label>
              <div class="col-sm-3">
                <input type="file" name="imagen" id="imagen" class="form-control">
                <?php create_input("hidden","imagen_ant",$usuario["imagen"],"",$table,$agregado); 
                  if($usuario["imagen"]!=""){ 
                ?>
                  <img style="height:70px;" src="<?php echo "files/images/marcas/".$usuario["imagen"]; ?>" width="200" class="mgt15">
                <?php } ?> 
              </div>
        </div>    
      </div>
      <div class="box-footer">
        <div class="form-group">
          <div class="col-sm-10 pull-right">
            <button type="submit" class="btn bg-blue btn-flat">Guardar</button>
            <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link2; ?>');">Cancelar</button>
          </div>
        </div>
      </div>      </form>    </div><!-- /.box -->
  </div></div><!--row / col12 -->
</section><!-- /.content -->
<?php
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  if($_SESSION["visualiza"]["idtipo_usu"]==1){      $bd = new BD;
    $bd->Begin();
    $ide = !isset($_GET['id_marca']) ? implode(',', $_GET['chkDel']) : $_GET['id_marca'];
    // $publicacion = executesql("SELECT * FROM marcas WHERE id_marca IN(".$ide.")");
    // if(!empty($publicacion)){
      // foreach($publicacion as $row){
      // linkde img
      // }
    // } 
    // $bd->actualiza_("DELETE FROM table WHERE id_marca IN(".$ide.")");
    $bd->Commit();
    $bd->close();  }
}elseif($_GET["task"]=='ordenar'){
  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $num_afect=$bd->actualiza_("UPDATE marcas SET orden= ".$orden." WHERE id_marca = ".$item."");
  }
  $bd->close();  
}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_marca']) ? $_GET['estado_idestado'] : $_GET['id_marca'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $usuario = executesql("SELECT * FROM marcas WHERE id_marca IN (".$ide.")");
  if(!empty($usuario))
  foreach($usuario as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE marcas SET estado_idestado=".$state." WHERE id_marca=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
}elseif($_GET["task"]=='finder'){
   $sql = "SELECT d.*,e.nombre AS estado  FROM marcas d 
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
  $paging->pagina_proceso="marcas.php";
?>
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr role="row">
          <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
          <th class="sort  unafbe">Nombre</th> 
          <th class="sort cnone" width="60">Imágen</th>
          <th class="sort  "width="60">ESTADO</th>
          <th class="unafbe" width="100">Opciones</th>
        </tr>
      </thead>
      <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
        <tr id="order_<?php echo $detalles["id_marca"]; ?>">
          <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["id_marca"]; ?>" id="id"></td>
          <td ><?php echo $detalles["nombre"]; ?></td>
          <td class="cnone">
            <?php if(!empty($detalles["imagen"])){ ?>
            <img src="<?php echo "files/images/marcas/".$detalles["imagen"]; ?>" alt="<?php echo $detalles["nombre"]; ?>" class="img-responsive">
            <?php }else{ echo "Not Image."; } ?>
          </td>                
          <td class=""><a href="javascript: fn_estado('<?php echo $detalles["id_marca"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
          <td><div class="btn-eai btr text-center">
         <?php if($_SESSION["visualiza"]["idtipo_usu"]==1 || $_SESSION["visualiza"]["idtipo_usu"]==2){ ?>
              <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_marca='.$detalles["id_marca"]; ?>"><i class="fa fa-edit"></i></a>
         <?php } ?>
          </div></td>
        </tr>
<?php endwhile; ?>
      </tbody>
    </table>
    <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  reordenar('marcas.php');
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
var link = "marca";/*la s final se agrega en js fuctions*/
var us = "marca";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "a";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "la";
var ar = "el";
var id = "id_marca";
var mypage = "marcas.php";
</script>
<?php } ?>