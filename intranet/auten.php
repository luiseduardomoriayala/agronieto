<?php session_start();
error_reporting(0);
include_once("class/class.bd.php"); 
include_once("class/functions.php");
include_once("class/class.upload.php");
include_once("class/PHPPaging.lib.php");


$link_pro='index.php?page='.$_GET["page"].'&id_tipopro='.$_GET["id_tipopro"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"];
$link2 = 'index.php?page='.$_GET["page"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"];

if($_GET['task']=='cargar_marcas'){
  $array[] = array('id' => '', 'value' => 'Seleccione');
  $ides_marca=array();  
  $ides_ma=executesql("select * from marcas_x_tipopro WHERE id_tipopro='".$_GET['variable']."' ");
  if(!empty($ides_ma)){
    foreach($ides_ma as $marca){ $ides_marca[]=$marca["id_marca"]; }
  }
  $sql = "select id_marca,nombre from marcas  WHERE id_marca IN (".implode(',',$ides_marca).") and estado_idestado='1' ORDER BY  nombre ASC";
  $consulta = executesql($sql);
  if(!empty($consulta)) foreach($consulta as $row) $array[] = array('id' => $row[0], 'value' => $row[1]);
  echo json_encode($array);
  exit();
}

if($_GET['task']=='cargar_submarcas'){
  $array[] = array('id' => '', 'value' => 'Seleccione');
  $sql = "select id_sub,nombre from sub_marcas  WHERE id_tipopro='".$_GET['var1']."' and id_marca='".$_GET['var2']."'  and estado_idestado='1' ORDER BY  nombre ASC";
  $consulta = executesql($sql);
  if(!empty($consulta)){ foreach($consulta as $row) $array[] = array('id' => $row[0], 'value' => $row[1]);
  }else{
  // $array[] = array('id' => $_GET['var1'], 'value' => $_GET['var2']);
    
  }
  
  echo json_encode($array);
  exit();
}






?>