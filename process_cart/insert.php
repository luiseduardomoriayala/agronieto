<?php //comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	//comprobamos algunos datos
	if(!isset($_POST["id"]) || !is_numeric($_POST["id"])){
		echo json_encode(array(
				"res" 		=> "error", 
				"message" 	=> "El id del producto no es correcto."
				)
		);
	}else{
		require("../class/Carrito.class.php");
		$carrito = new Carrito();		
		$articulo = array(
			"id"			=>		$_POST["id"],
			"cantidad"		=>		$_POST["cantidad"],
			"precio"		=>		$_POST["precio"],
			"nombre"		=>		$_POST["nombre"],
			"imagen"		=>		$_POST["imagen"]
		); 
		$carrito->add($articulo);
		echo json_encode(array("res" => "ok"));
	}
}
 
?>