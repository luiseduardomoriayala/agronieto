<?php $_url = "";
if(isset($_GET["page"]) && $_GET["page"]!=""){
  switch($_GET["page"]){
    case "novedades":
      $_url="publicaciones.php";
      break;
    case "banners":
    case "productos":
    case "galeria_productos":
    case "pedidos":
    case "suscriptores":
    case "usuarios":
      $_url=$_GET["page"].".php";
      break;  
    default:
      $_url="index.php";
      $section="0";           
      break;  
  }    
}

$tab=array(
  "Contenido"=>array(
     "banners"   => array(url=>"index.php?page=banners"),
     "Publicaciones"   => array(url=>"index.php?page=novedades") 
    ), 
  "Productos"=>array(
       "ver"   => array(url=>"index.php?page=productos")
            ),
  "Pedidos"=>array(
       "Ver"   => array(url=>"index.php?page=pedidos")
            ),
  "Suscritos"=>array(
       "Suscritos"   => array(url=>"index.php?page=suscriptores")
            ),              
  "Sistema"=>array( "Usuarios"=>array(url=>"index.php?page=usuarios") )
); ?>
<div class="wrapper">
  <header class="main-header">
    <a href="<?php echo $url; ?>" class="logo">
      <span class="logo-mini"><b>A</b>C</span>
      <span class="logo-lg">Administrador de Contenidos</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">     
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>      
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">         
          <li class="dropdown user user-menu">
            <a href="<?php echo $url; ?>?task=salir">
              <?php echo $name."<br><small>("; echo ($tiu==1) ? 'Administrador' : 'Invitado'; echo ")</small>"; ?> | Salir</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
		<!-- <img src="dist/img/logo.png" class="" alt=""> -->
        </div>
      </div>     
      <ul class="sidebar-menu">
        <li class="header">SECCIONES</li>
<?php
foreach ($tab as $parenttab => $modules){
  $issue_parenttab = isset($_GET['parenttab']);
  $isset_array = is_array($modules);
?>
        <li class="treeview <?php if($issue_parenttab && $parenttab==$_GET["parenttab"]){ echo "active"; } ?>">
          <a href="<?php echo $isset_array ? 'javascript:void(0);' : $modules.'&module='.$parenttab.'&parenttab='.$parenttab; ?>">
            <i class="fa fa-link"></i> <span><?php echo $parenttab; ?></span>
            <?php if($isset_array){ ?>
            <i class="fa fa-angle-left pull-right"></i>
            <?php } ?>
          </a>
<?php
if(is_array($modules)){
?>
          <ul class="treeview-menu">
<?php
  foreach ($modules as $module => $array) {
    $issue_module = isset($_GET['module']);
?>
            <li class="<?php if($issue_module && $module==$_GET["module"]){ echo "active"; } ?>">
              <a href="<?php echo $array["url"]; ?>&module=<?php echo $module; ?>&parenttab=<?php echo $parenttab; ?>" class="<?php if($issue_module && $module==$_GET["module"]){ echo "active"; } ?>">
                <i class="fa fa-files-o"></i><span><?php echo $module; ?></span>
              </a>
            </li>
<?php } ?>
          </ul>
<?php } ?>
        </li>
<?php } ?>
      </ul>
    </section>  
  </aside>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Bienvenido<small><?php echo $name; ?></small></h1>
    </section>    
    <section class="content">
      <div class="box">
        <?php if(isset($_GET["module"])){ ?>
        <div class="box-header">
          <h3 class="box-title">Sección &raquo; <?php echo $_GET["module"]; ?></h3>
        </div>
        <?php } ?>
        <?php if($_url!="") include($_url); ?>
      </div>
    </section>
  </div>
  <footer class="main-footer">
    <small>Copyright &copy; 2018. Todos los Derechos Reservados. -  Desarrollado por:  <a href="http://www.Tuweb7.com" target="_blank">Tuweb7.com</a></small>
  </footer>
</div>
