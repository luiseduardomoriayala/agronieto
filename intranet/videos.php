<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["idvideo"];
  $criterio_Orden ="";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "videos", "idvideo", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert'){
  $bd=new BD;
  $urlrewrite=armarurlrewrite($_POST["nombre_video"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"videos","idvideo","nombrevideo_rewrite");

  $norden=_orden_noticia("","videos","");
  $campos=array("nombre_video", array("nombrevideo_rewrite",$urlrewrite), "link", "estado_idestado", array("orden",$norden)); 
  $sql=arma_insert("videos",$campos,"POST");        
  $numregistros=$bd->inserta_($sql);
  $bd->close();

  if($numregistros<=0){
    gotoUrl($_POST["urlfailed"]."&error");
  }else{
    gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
  }

}elseif($_GET["task"]=='update'){
  $bd=new BD;
  $urlrewrite=armarurlrewrite($_POST["nombre_video"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"videos","idvideo","nombrevideo_rewrite","and idvideo!='".$_POST["idvideo"]."'");

  $where.=" idvideo='".$_POST["idvideo"]."'";
  $campos=array("nombre_video", array("nombrevideo_rewrite",$urlrewrite), "link", "estado_idestado"); 
  $query=armaupdate("videos",$campos,$where,"POST");
  $numupdates=$bd->actualiza_($query);
  $bd->close();
  
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
  
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from videos where idvideo='".$_GET["idvideo"]."'",0);
  }
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">
                <?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Nuevo'; ?> Video</h3>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form action="videos.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" autocomplete="OFF">
<?php 
if($task_=='edit') create_input("hidden","idvideo",$data_producto["idvideo"],"",$table,""); 

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
                    <?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_producto["estado_idestado"],""); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Nombre Video</label>
                  <div class="col-sm-6">
                    <?php create_input("text","nombre_video",$data_producto["nombre_video"],"form-control",$table,"required",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Enlace Video</label>
                  <div class="col-sm-6">
                    <?php create_input("text","link",$data_producto["link"],"form-control",$table,"required",$agregado); ?>
                  <iframe frameborder="0" width="100%" height="260" class="lvideo"></iframe>
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
              </div>
            </form>
          </div><!-- /.box -->
        </div><!--/.col (right) -->
  </div>
</section><!-- /.content -->
<?php
}elseif($_GET["task"]=='dropselect'){
  $bd = new BD;
  $bd->Begin();
  $chkDel = implode(",",str_replace('chkDel','',$_GET["chkDel"])); $chkDel_ex = explode(",",$chkDel); $chkDel_ct = count(explode(",",$chkDel));
  
  for($i=0;$i<$chkDel_ct;$i++){
    $num_afect+=$bd->actualiza_("delete from videos where idvideo='".$chkDel_ex[$i]."'");
  }
  
  $bd->Commit();
  $bd->close();
  
  if($numupdates<=0){echo "Error: eliminando registro"; exit;}
  
}elseif($_GET["task"]=='drop'){
  $bd = new BD;
  $bd->Begin();

  $num_afect=$bd->actualiza_("delete from videos where idvideo='".$_GET["idvideo"]."'");
  
  $bd->Commit();
  $bd->close();
  
  if($num_afect<=0){echo "Error: eliminando registro"; exit;}

}elseif($_GET["task"]=='ordenar'){
  $bd = new BD;

  $_GET['order'] = array_reverse($_GET['order']);

  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $num_afect=$bd->actualiza_("UPDATE videos SET orden= ".$orden." WHERE idvideo = ".$item."");
  }

  $bd->close();

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['idvideo']) ? $_GET['estado_idestado'] : $_GET['idvideo'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $videos = executesql("SELECT * FROM videos WHERE idvideo IN (".$ide.")");
  if(!empty($videos))
  foreach($videos as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE videos SET estado_idestado=".$state." WHERE idvideo=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){

  $sql.= "SELECT c.*,e.nombre AS estado FROM videos c INNER JOIN estado e ON c.estado_idestado=e.idestado ";
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " WHERE c.nombre_video LIKE '%".$stringlike."%'";
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
  $paging->pagina_proceso="videos.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
                  <th class="sort">NOMBRE VIDEO</th>
                  <th class="cnone">ENLACE VIDEO</th>
                  <th class="sort cnone">ESTADO</th>
                  <th class="unafbe">Opciones</th>
                </tr>
              </thead>
              <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
                <tr id="order_<?php echo $detalles["idvideo"]; ?>">
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["idvideo"]; ?>"></td>
                  <td><?php echo $detalles["nombre_video"]; ?></td>
                  <td class="cnone"><a href="<?php echo $detalles["link"]; ?>" target="_blank">Ver Video</a></td>
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["idvideo"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td>
                    <div class="btn-eai btr">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&idvideo='.$detalles["idvideo"]; ?>"><i class="fa fa-edit"></i></a>
                      <a href="javascript: fn_eliminar('<?php echo $detalles["idvideo"]; ?>')"><i class="fa fa-trash-o"></i></a>
                    </div>
                  </td>
                </tr>
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="dist/js/jquery-ui.js"></script>
<script src="dist/js/jquery.tablesorter.js"></script>
<script>
$(function(){
  reordenar('videos.php');
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
                    <a href="javascript:fn_delete_all();"><i class="fa fa-trash-o"></i></a>
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
var link = "video";
var us = "video";
var l = "o";
var l2 = "e";
var pr = "El";
var ar = "el";
var id = "idvideo";
var mypage= "videos.php";
</script>
<?php } ?>