<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"]; 
  $id_del_registro_actual=$_GET["id_suscrito"];
  $criterio_Orden ="";
  nuevoorden($orden_actual, $orden_nuevo, $id_del_registro_actual, "suscritos", "id_suscrito", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert'){
 	$bd=new BD;       
	$bd->inserta_(arma_insert("suscritos",array("email"),"POST"));
  $bd->close();

  if($ninsert<=0){
    gotoUrl($_POST["urlfailed"]."&error");
  }else{
    gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
  }

}elseif($_GET["task"]=='update'){
  $bd=new BD;
    $campos=array("email","estado_idestado"); 
$where.=" id_suscrito='".$_POST["id_suscrito"]."'";	
  $query=armaupdate("suscritos",$campos,$where,"POST");
  
  $numupdates=$bd->actualiza_($query);
  $bd->close();
  
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
  
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $usuario=executesql("select * from suscritos where id_suscrito='".$_GET["id_suscrito"]."'",0);
  }
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">
                <?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Nuevo'; ?> Suscriptores</h3>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form action="suscriptores.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" autocomplete="OFF">
<?php 
if($task_=='edit') create_input("hidden","id_suscrito",$usuario["id_suscrito"],"",$table,"");
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
                  <label for="inputPassword3" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-6">
                    <?php create_input("text","email",$usuario["email"],"form-control",$table,"required",$agregado); ?>
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
  $chkDel = implode(",",str_replace('chkDel','',$_GET["chkDel"]));
  $chkDel_ex = explode(",",$chkDel);
  $chkDel_ct = count(explode(",",$chkDel));
  
  for($i=0;$i<$chkDel_ct;$i++){
    $num_afect+=$bd->actualiza_("delete from suscritos where id_suscrito='".$chkDel_ex[$i]."'");
  }  
  $bd->Commit();
  $bd->close(); 
  if($numupdates<=0){echo "Error: eliminando registro"; exit;}
  
}elseif($_GET["task"]=='drop'){
  $bd = new BD;
  $bd->Begin();

  $num_afect=$bd->actualiza_("delete from suscritos where id_suscrito='".$_GET["id_suscrito"]."'");
  
  $bd->Commit();
  $bd->close();
  
  if($num_afect<=0){echo "Error: eliminando registro"; exit;}

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_suscrito']) ? $_GET['estado_idestado'] : $_GET['id_suscrito'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $usuario = executesql("SELECT * FROM suscritos WHERE id_suscrito IN (".$ide.")");
  if(!empty($usuario))
  foreach($usuario as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE suscritos SET estado_idestado=".$state." WHERE id_suscrito=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){
	$array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
  $sql.= "SELECT c.*,YEAR(fecha_registro) as anho, MONTH(fecha_registro) as mes, e.nombre AS estado FROM suscritos c,estado e  WHERE c.estado_idestado=e.idestado ";
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (id_suscrito like '%".$stringlike."%' OR email LIKE '%".$stringlike."%')";
  }
	 $sql.=" ORDER BY fecha_registro DESC";
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("criterio_mostrar","task","criterio_usu_per");
  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->ejecutar();
  $paging->pagina_proceso="suscriptores.php";
?>
		<table id="example1" class="table table-bordered table-striped">
			<tbody id="sort">

<?php 
		while ($detalles = $paging->fetchResultado()): 
			if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
				$array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
?>
				<tr class="lleva-mes">
					<td colspan="9"><h6><?php echo strtoupper(strtr(date('M Y',strtotime($detalles['fecha_registro'])),$meses)); ?></h6></td>
				</tr>
				<tr role="row">
					<th width="30">Día</th>
					<th class="sort cnone">Suscriptor</th>
					<th class="sort cnone">Pais</th>
					<th class="sort cnone">ESTADO</th>
					<th class="unafbe">Opciones</th>
				</tr>
<?php }//if meses ?>
				<tr>
					<td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
					<td><?php echo $detalles["email"]; ?></td>
					<td><?php echo $detalles["pais"]; ?></td>
					<td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_suscrito"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
					<td>
						<div class="btn-eai btr">
							<a href="<?php echo $_SESSION["base_url"].'&task=edit&id_suscrito='.$detalles["id_suscrito"]; ?>"><i class="fa fa-edit"></i></a>
<?php if($_SESSION["visualiza"]["idtipo_usu"]==1){ ?>              
							<a href="javascript: fn_eliminar('<?php echo $detalles["id_suscrito"]; ?>')"><i class="fa fa-trash-o"></i></a>
<?php } ?>              
						</div>
					</td>
				</tr>
			</tbody>
<?php endwhile; ?>
		</table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  reordenar('suscriptores.php');
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
                  <div class="btn-eai">Descargar Listado
                    <a href="javascript:fn_exportar('tipo_form=1');"><i class="fa fa-file-excel-o"></i></a>
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
var link = "suscriptore";/*la s final se agrega en js fuctions*/
var us = "suscriptor";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_suscrito";
var mypage = "suscriptores.php";
</script>
<?php } ?>