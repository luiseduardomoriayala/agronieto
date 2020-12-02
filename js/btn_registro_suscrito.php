<?php error_reporting(E_ALL);
session_start();
include_once("intranet/class/functions.php");
include_once("intranet/class/class.bd.php"); 
include_once("intranet/class/PHPPaging.lib.php");
$url = 'http://'.$_SERVER['SERVER_NAME'].'/'.( ($_SERVER['SERVER_NAME'] == 'localhost') ? 'mori/tuweb7/naynut/' : 'beta/' ); 

echo $_POST['action']=isset($_POST['action'])?$_POST['action']:'ñe';
$rpta = 2;/*si es error*/
if($_POST['action']=='registro'){ 

$rpta = 1;
}
echo json_encode(array('rpta' => $rpta));
?>