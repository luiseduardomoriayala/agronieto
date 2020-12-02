<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='update'){
  $bd=new BD;
  $_POST["estado_entrega"]=1;
  $campos=array("estado_entrega");
  $bd->actualiza_(armaupdate('pedidos',$campos," id_pedido='".$_POST["id_pedido"]."'",'POST'));/*actualizo*/
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);   
}elseif( $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $usuario=executesql("select * from pedidos where id_pedido='".$_GET["id_pedido"]."'",0);
  }
?>

<section class="content">
  <div class="row">
    <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Pedido</h3>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form action="pedidos.php?task=update" class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF">
<?php 
if($task_=='edit') create_input("hidden","id_pedido",$usuario["id_pedido"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link2,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
             <div class="box-body">
<!-- Data Pedido principal... -->
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Datos Pedido
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Estado de Entrega</label>
                          <div class="col-sm-8">
                            <select id="estado_entrega" name="estado_entrega" class="form-control">  <!-- saco valor desde la BD -->
                              <option value="1" <?php echo ($usuario['estado_entrega'] == 1) ? 'selected' : '' ;?>>Entregado</option>  
                              <option value="2"  <?php echo ($usuario['estado_entrega'] == 2) ? 'selected' : '' ;?>>No entregado</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Monto Total </label>
                          <div class="col-sm-6">
                            <?php create_input("text","total",$usuario["total"],"form-control",$table,'disabled',$agregado); ?>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Sub total </label>
                          <div class="col-sm-2">
                            <?php create_input("text","subtotal",$usuario["subtotal"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                          <label for="inputPassword3" class="col-sm-2 control-label">Costo envio </label>
                          <div class="col-sm-2">
                            <?php create_input("text","envio",$usuario["envio"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Fecha  </label>
                          <div class="col-sm-2">
                          <?php create_input("text","fecha_registro",$usuario["fecha_registro"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                          <label for="inputPassword3" class="col-sm-2 control-label">N°productos </label>
                          <div class="col-sm-1">
                            <?php create_input("text","articulos",$usuario["articulos"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Dirección: </label>
                          <div class="col-sm-8">
                            <?php create_input("text","direccion",$usuario["direccion"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Comentarios: </label>
                          <div class="col-sm-8">
                            <?php create_input("textarea","comentario",$usuario["comentario"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
<!-- Data detalle pedido... -->                  
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          Detalle Pedido
                        </a>
                      </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                      <div class="panel-body">
<?php $detallepro=executesql("select li.* , p.imagen as imagen ,p.titulo as titulo from linea_pedido li INNER JOIN productos p ON li.id_producto=p.id_producto where id_pedido='".$_GET["id_pedido"]."'"); ?>                        
                        <table  class="table table-bordered table-striped">
                          <thead>
                            <tr role="row">
                              <th class="sort cnone" width="50">Codigo</th>
                              <th class="sort ">Producto</th>
                              <th class="sort ">N°</th>
                              <th class="sort cnone">Precio</th>
                              <th class="sort cnone">Subtotal</th>
                            </tr>
                          </thead>
                          <tbody id="sort">
            <?php foreach($detallepro as $rowdetalle){ ?>
                            <tr id="order_<?php echo $rowdetalle["id_linea"]; ?>">
                              <td ><?php echo $rowdetalle["id_producto"]; ?></td>
                              <td ><?php echo $rowdetalle["titulo"]; ?></td>
                              <td  ><?php echo $rowdetalle["cantidad"]; ?></td>
                              <td class="cnone">S/ <?php echo $rowdetalle["precio"]; ?></td>
                              <td class="cnone"> S/<?php echo $rowdetalle["subtotal"]; ?></td>
                            </tr>
            <?php } ?>
                          </tbody>
                        </table>
                       
                      </div>
                    </div>
                  </div>
<!-- Data suscritos ... -->                  
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                          Datos Cliente
                        </a>
                      </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">
<?php $detallepro=executesql("select *  from suscritos  where id_suscrito='".$usuario["id_suscrito"]."'"); ?>
                        <table  class="table table-bordered table-striped">
                          <thead>
                            <tr role="row">
                              <th class="sort ">Nombre</th>
                              <th class="sort ">DNI</th>
                              <th class="sort cnone">telefono</th>
                              <th class="sort ">Direccion</th>
                              <th class="sort cnone">email</th>
                            </tr>
                          </thead>
                          <tbody id="sort">
            <?php foreach($detallepro as $rowdetalle){ ?>
                            <tr id="order_<?php echo $rowdetalle["id_linea"]; ?>">                              
                              <td ><?php echo $rowdetalle["nombre"]; ?></td>
                              <td ><?php echo $rowdetalle["dni"]; ?></td>
                              <td ><?php echo $rowdetalle["telefono"]; ?></td>
                              <td ><?php echo $rowdetalle["direccion"]; ?></td>
                              <td ><?php echo $rowdetalle["email"]; ?></td>
                            </tr>
            <?php } ?>
                          </tbody>
                        </table>                        
                      </div>
                    </div>
                  </div>

                </div>

              </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 text-center">
<?php if($_SESSION["visualiza"]["idtipo_usu"]==1){ 
        if($usuario["estado_entrega"]==2){ ?>                  
                    <button type="submit" class="btn bg-blue btn-flat">ENTREGADO</button>
<?php   }
      }
 ?>                              
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link2; ?>');">Cerrar</button>
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
  $ide = !isset($_GET['id_pedido']) ? implode(',', $_GET['chkDel']) : $_GET['id_pedido'];
  $bd->actualiza_("DELETE FROM  linea_pedido WHERE id_pedido IN(".$ide.")");
  $bd->actualiza_("DELETE FROM pedidos WHERE id_pedido IN(".$ide.")");
  $bd->Commit();
  $bd->close();
}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_pedido']) ? $_GET['estado_idestado'] : $_GET['id_pedido'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $usuario = executesql("SELECT * FROM pedidos WHERE id_pedido IN (".$ide.")");
  if(!empty($usuario))
  foreach($usuario as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE pedidos SET estado_idestado=".$state." WHERE id_pedido=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();


}elseif($_GET["task"]=='uestado_pedido'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_pedido']) ? $_GET['idpedido'] : $_GET['id_pedido'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $usuario = executesql("SELECT * FROM pedidos WHERE id_pedido IN (".$ide.")"); //
  if(!empty($usuario))
  foreach($usuario as $reg => $item)
  if ($item['estado_entrega']==1) {
    $state = 2;
  }elseif ($item['estado_entrega']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE pedidos SET estado_entrega=".$state." WHERE id_pedido=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){
  $array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
  $sql= "SELECT pp.*,YEAR(pp.fecha_registro) as anho, MONTH(pp.fecha_registro) as mes, e.nombre AS estado , s.nombre as suscritos FROM pedidos pp 
  INNER JOIN estado e ON pp.estado_idestado=e.idestado 
  INNER JOIN suscritos s ON pp.id_suscrito=s.id_suscrito"; 
  
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND ( s.nombre LIKE '%".$stringlike."%' )"; 
  }
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY pp.orden DESC";
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
  $paging->pagina_proceso="pedidos.php";
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
          <th class="sort cnone" >Cliente</th>
          <th class="sort cnone">Total</th>
          <th class="sort cnone">Articulos</th>
          <th class="sort cnone">Comentario</th>
          <th class="sort cnone" width="100">ENTREGADO</th>
          <th class="unafbe">Opciones</th>
        </tr>
<?php }//if meses 
$fondo_entregar = ($detalles["estado_entrega"] == 2) ? "background:rgba(255,0,0,0.9); color:#fff !important; " : "" ;
?>        
       <tr style="<?php echo $fondo_entregar; ?>">
        <td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
        <td ><?php echo $detalles["suscritos"]; ?></td>
        <td > S/<?php echo $detalles["total"]; ?></td>
        <td > <?php echo $detalles["articulos"]; ?></td>
        <td><?php echo short_name($detalles["comentario"],150); ?></td>
        <td class="cnone"><a href="javascript: fn_estado_pedido('<?php echo $detalles["id_pedido"]; ?>')">
                <?php if($detalles["estado_entrega"]==2){ echo "Por entregar"; }else{ echo "Entregado";} ?></a></td>
        <td>
          <div class="btn-eai btr text-center">
            <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_pedido='.$detalles["id_pedido"]; ?>"><i class="fa fa-edit"></i></a>
<?php if($_SESSION["visualiza"]["idtipo_usu"]==1){ ?>
            <a href="javascript: fn_eliminar('<?php echo $detalles["id_pedido"]; ?>')"><i class="fa
            fa-trash-o"></i></a>
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
  reordenar('pedidos.php');
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
var link = "pedido";/*la s final se agrega en js fuctions*/
var us = "pedido";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_pedido";
var mypage = "pedidos.php";
</script>
<?php } ?>