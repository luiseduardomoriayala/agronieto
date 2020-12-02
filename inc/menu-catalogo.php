<div class="menu_bar osans"> 
  <a href="javascrit:void(0);" class="bt-menu en-linea"><img src="img/iconos/menu-catalogo.png"><h3 class="aconddb">Catalogos</h3></a>
</div>                
<?php $categ=executesql("select * from productos where estado_idestado=1 order by titulo asc"); 
if(!empty($categ)){ ?>               
<nav  class="hide osans"> 
  <ul class="no-bullet fullwidth">
<?php  foreach($categ as $row){ ?>
    <li class="submenu">
      <a href="productos/<?php echo $row["titulo_rewrite"]; ?>" class="lleva-img"><?php echo $row["titulo"]; ?><span class="menu-flecha"></span></a>								
    </li> 
<?php } ?>
  </ul>
</nav> 
<?php }?>               