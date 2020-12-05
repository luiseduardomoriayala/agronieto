<div class="producto"><a href="<?php echo $link;?>">      
  <figure><img src="<?php echo $img_pro; ?>"></figure>
  <div class="descrp">
    <div class="title-pro"><h2 class="gulim bold"><?php echo $row["titulo"]; ?></br></h2></div>
    <p class="gulim bold"><?php echo $row["marca"]; ?></br></p>
    <blockquote class="gulim bold">
<?php $y=$row["costo_promo"];$x=$row["precio"];
echo (!empty($y) && $y !=0 )?"<strike style='padding-right:12px;'>s/".$x."</strike><big>s/".$y."</big>":"<big>s/".$x."</big>";
//Precio final
if(!empty($row["costo_promo"]) && $row["costo_promo"]!="0.00"){ $precio=$row["costo_promo"]; }else{ $precio=$row["precio"]; } 
?>
    </blockquote>
		<!-- 
    <form id ="ruta-<?php echo $row["id_producto"]; ?>" class="add" method="POST" action="process_cart/insert.php" accept-charset="UTF-8">       
      <input type="hidden" name="id"  value="<?php echo $row["id_producto"] ?>">
      <input type="hidden" name="imagen"  value="<?php echo $img_pro; ?>">
      <input type="hidden" name="nombre"  value="<?php echo $row["titulo"]; ?>" id="nombre">        
      <input type="hidden" name="precio"  value="<?php echo $precio; ?>" id="precio">           
      <input type="hidden" value="1" name="cantidad" id="cantidad">
      <div class="large-12 columns" style="margin-top:15px;"><button class="gulim bold btn botones  hola"></button></div>
    </form>
		-->
		<a href="<?php echo $link;?>" target="_blank" class="btn botones pulse"> Ver más</a> 

  </div>
</a></div>