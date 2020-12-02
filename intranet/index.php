<?php 
session_start();
error_reporting(0);
$unix_date = strtotime(date('Y-m-d H:i:s'));
$link = $_SERVER['HTTP_HOST'];
$url = "http://$link/intranet/";
// $url = "http://$link/intranet/";

include("class/class.bd.php");
include("class/functions.php");

$_GET['task'] = isset($_GET['task']) ? $_GET['task'] : '';
$titulo = isset($_SESSION["visualiza"]) ? 'Administrador' : 'Iniciar Sesión';
if($_GET["task"]=="validator"){
  $consulta = "SELECT * FROM usuario WHERE codusuario='".$_POST["user"]."' and estado_idestado='1'";
  $correo_existe = executesql($consulta,1);
  
  $consulta = "SELECT * FROM usuario WHERE codusuario='".$_POST["user"]."' AND contrasena='".md5($_POST["password"])."' and estado_idestado='1'";
  $users = executesql($consulta,1);
  $rpta = 2;
  if(!empty($users)){
    $_SESSION["visualiza"]["idtipo_usu"]=$users[0]["idtipo_usu"];
    $_SESSION["visualiza"]["nomusuario"]=$users[0]["nomusuario"];
    $_SESSION["visualiza"]["codusuario"]=$users[0]["codusuario"];
    $_SESSION["visualiza"]["contrasena"]=$users[0]["contrasena"];
    $rpta = 1;
  }elseif (!empty($correo_existe)) {
    $rpta = 3;
  }
  echo $rpta;
  exit();
}elseif($_GET['task']=='recuperar'){
  include('inc/recuperar.php');
}elseif($_GET['task']=='registrar'){
  include('inc/registrar.php');
}elseif($_GET['task'] == 'exportar_excel'){
  if(isset($_SESSION['activate_protection'])){
    unset($_SESSION['activate_protection']);
  }
  $_SESSION['activate_protection'][0]   = true;
  if(isset($_POST['tipo_form']) && $_POST['tipo_form']>0){
    $_SESSION['activate_protection'][1] = $_POST['tipo_form'];
  }
  exit();

}elseif($_GET['task']=='salir'){
  unset($_SESSION['visualiza']);//se elimina la sesion
  gotourl($url);
}

?>
<!DOCTYPE html>
<html>
  <head>
    <!-- <base href="<?php echo $url; ?>"> -->
    <meta charset="utf-8">
    <title><?php echo "Administrador | ".$titulo; ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="favicon.ico">
    <!-- ESTILOS -->
    <link rel="stylesheet" href="dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.css">
    <link rel="stylesheet" href="dist/css/skin-blue.css">
    <link rel="stylesheet" href="dist/css/sweetalert.css">
    <link rel="stylesheet" href="dist/css/dropzone.css">
    <link href="dist/js/magnific-popup/magnific-popup.css" rel="stylesheet">
    <link rel="stylesheet" href="dist/css/main.css?ud=<?php echo $unix_date ; ?>" >
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page skin-blue sidebar-mini">
<?php
$users = array();
if (isset($_SESSION['visualiza'])) {
  $consulta = "SELECT * FROM usuario WHERE codusuario='".$_SESSION["visualiza"]["codusuario"]."' AND contrasena='".$_SESSION["visualiza"]["contrasena"]."' and estado_idestado='1'";
  $users = executesql($consulta,$tipo);
  if (!empty($users)) {
    $_SESSION['rpta'] = 1;
  }
}
if(!empty($users)){
  $_SESSION["base_url"]=$_SERVER['REQUEST_URI'];
  $name = ucwords($_SESSION['visualiza']['nomusuario']);
  $tiu = ucwords($_SESSION['visualiza']['idtipo_usu']);
  require 'blank.php';
}else{
?>
    <div class="login-box">
      <div class="login-logo">
        <b>Administrador</b>
      </div>
      <div class="login-box-body">
        <p class="login-box-msg">Iniciar Sesión</p>
        <form id="entrar" action="javascript:void(0);" method="POST" autocomplete="OFF">
          <div class="form-group has-feedback">
            <input type="text" name="user" class="form-control" placeholder="Usuario" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-5">
              <!-- <a href="#">He olvidado mi contraseña</a> -->
            </div>
            <div class="col-xs-7">
              <input type="submit" value="Iniciar" class="btn btn-primary btn-block btn-flat">
              <div class="break"></div>
              <span class="msg"></span>
            </div><!-- /.col -->
          </div>
        </form>
      </div>
    </div>
<?php } ?>
      <!-- jQuery 2.1.4 -->
      <script src="dist/js/jQuery-2.1.4.min.js"></script>
      <!-- SCRIPTS -->
      <script src="dist/js/jquery-ui.js"></script>
      <script src="dist/js/jquery.ui.touch-punch.min.js"></script>
      <script src="dist/js/jquery.tablesorter.js"></script>
      <script src="dist/js/sweetalert.min.js"></script>
      <script src="dist/js/app.min.js"></script>
      <script src="dist/js/bootstrap.min.js"></script>
      <script src="dist/js/functions.js?ud=<?php echo $unix_date ?>"></script>
      <script src="dist/js/dropzone.js"></script>
      <script src="dist/js/magnific-popup/jquery.magnific-popup.min.js"></script>
      <script src="dist/js/jquery.validate.min.js"></script>
      <?php if($_GET["task"]=='new' && $title=="Productos" || $_GET["task"]=='edit' && $title=="Productos"){  ?>
      <script src="../assets/js/autosize.js"></script>
      <script>autosize(document.querySelectorAll('textarea'));</script>
      <?php } ?>
      <script type="text/javascript">
      $(document).ready(function(){
        if($('#registro').length){ $('#registro').validate(customValidate); }
      });
      </script>
    </body>
</html>