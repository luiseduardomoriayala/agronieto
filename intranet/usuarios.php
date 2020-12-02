<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["idusuario"];
  $criterio_Orden ="";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "usuario", "idusuario", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert'){
  $bd=new BD;
  $contrasena=md5($_POST["contrasena"]);
  $norden=_orden_noticia("","usuario","");
  $campos=array("estado_idestado","idtipo_usu","codusuario","nomusuario", "email", array("contrasena",$contrasena), array("fecha_ingreso",fecha_hora(2)), array("orden",$norden));  
  $sql=arma_insert("usuario",$campos,"POST");       
  $ninsert=$bd->inserta_($sql);
  $bd->close();

  if($ninsert<=0){
    gotoUrl($_POST["urlfailed"]."&error");
  }else{
    gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
  }

}elseif($_GET["task"]=='update'){
  $bd=new BD;
  if($_POST["contrasena"]=="") $contrasena=$_POST["contrasena_ant"];
  else $contrasena=md5($_POST["contrasena"]);
  $where.=" idusuario='".$_POST["idusuario"]."'";
  $campos=array("estado_idestado","codusuario","nomusuario", "email", array("contrasena",$contrasena));
  $query=armaupdate("usuario",$campos,$where,"POST");
  $numupdates=$bd->actualiza_($query);
  $bd->close();
  
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
  
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $usuario=executesql("select * from usuario where idusuario='".$_GET["idusuario"]."'",0);
  }
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">
                <?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Nuevo'; ?> Usuario</h3>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form action="usuarios.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" autocomplete="OFF">
<?php 
if($task_=='edit') create_input("hidden","idusuario",$usuario["idusuario"],"",$table,"");
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
                <?php if($_GET['task']=='new'){ ?>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Tipo Usuario</label>
                  <div class="col-sm-6">
                    <?php crearselect("idtipo_usu","select * from tipo_usuario order by nombre_tipousu desc",'class="form-control"',$usuario["idtipo_usu"],""); ?>
                  </div>
                </div>
                <?php } ?>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Nombre Completo</label>
                  <div class="col-sm-6">
                    <?php create_input("text","nomusuario",$usuario["nomusuario"],"form-control",$table,"required",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">E-mail</label>
                  <div class="col-sm-6">
                    <input type="email" id="email" name="email" class="form-control" required value="<?php echo $usuario["email"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Usuario</label>
                  <div class="col-sm-6">
                    <?php create_input("text","codusuario",$usuario["codusuario"],"form-control",$table,"required",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Contraseña</label>
                  <div class="col-sm-6">
                    <?php 
                    create_input("password","contrasena","","form-control",$table,$agregado);
                    create_input("hidden","contrasena_ant",$usuario["contrasena"],"",$table,$agregado); ?>
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
    $num_afect+=$bd->actualiza_("delete from usuario where idusuario='".$chkDel_ex[$i]."'");
  }
  
  $bd->Commit();
  $bd->close();
  
  if($numupdates<=0){echo "Error: eliminando registro"; exit;}
  
}elseif($_GET["task"]=='drop'){
  $bd = new BD;
  $bd->Begin();

  $num_afect=$bd->actualiza_("delete from usuario where idusuario='".$_GET["idusuario"]."'");
  
  $bd->Commit();
  $bd->close();
  
  if($num_afect<=0){echo "Error: eliminando registro"; exit;}

}elseif($_GET["task"]=='ordenar'){
  $bd = new BD;

  $_GET['order'] = array_reverse($_GET['order']);

  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $num_afect=$bd->actualiza_("UPDATE usuario SET orden= ".$orden." WHERE idusuario = ".$item."");
  }

  $bd->close();

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['idusuario']) ? $_GET['estado_idestado'] : $_GET['idusuario'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $usuario = executesql("SELECT * FROM usuario WHERE idusuario IN (".$ide.")");
  if(!empty($usuario))
  foreach($usuario as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE usuario SET estado_idestado=".$state." WHERE idusuario=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){

  $sql.= "SELECT u.*, t.nombre_tipousu AS tipo_usuario, e.nombre AS estado FROM usuario u, tipo_usuario t, estado e ";
  $sql.= " WHERE u.estado_idestado=e.idestado AND u.idtipo_usu=t.idtipo_usu ";
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (codusuario like '%".$stringlike."%' OR nomusuario LIKE '%".$stringlike."%')";
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
  $paging->pagina_proceso="usuarios.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
                  <th class="sort cnone">TIPO USUARIO</th>
                  <th class="sort">NOMBRES COMPLETOS</th>
                  <th class="sort cnone">E-MAIL</th>
                  <th class="sort cnone">USUARIO</th>
                  <th class="sort cnone">ESTADO</th>
                  <th class="unafbe">Opciones</th>
                </tr>
              </thead>
              <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
                <tr id="order_<?php echo $detalles["idusuario"]; ?>">
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["idusuario"]; ?>" id="id"></td>
                  <td class="cnone"><?php echo $detalles["tipo_usuario"]; ?></td>
                  <td><?php echo $detalles["nomusuario"]; ?></td>
                  <td class="cnone"><?php echo $detalles["email"]; ?></td>
                  <td class="cnone"><?php echo $detalles["codusuario"]; ?></td>
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["idusuario"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td>
                    <div class="btn-eai btr">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&idusuario='.$detalles["idusuario"]; ?>"><i class="fa fa-edit"></i></a>
                      <a href="javascript: fn_eliminar('<?php echo $detalles["idusuario"]; ?>')"><i class="fa fa-trash-o"></i></a>
                    </div>
                  </td>
                </tr>
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  reordenar('usuarios.php');
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
var link = "usuario";
var us = "usuario";
var l = "o";
var l2 = "e";
var pr = "El";
var ar = "al";
var id = "idusuario";
var mypage = "usuarios.php";
</script>
<?php } ?>