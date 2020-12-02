<?php
//comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
 
	require("../class/Carrito.class.php");
	$carrito = new Carrito();
	$precio_total = $carrito->precio_total();
	$articulos_total = $carrito->articulos_total();
	$id_suscrito = $carrito->id_suscrito(); //Extraigo el id_suscrito de la funcion id_suscrito , dentro de Class
	if($carrito->get_content()){
		echo json_encode(array(
				"res" 				=> 	"ok", 
				"content" 			=> 	$carrito->get_content(),
				"precio_total" 		=> 	$precio_total,
				"articulos_total" 	=> 	$articulos_total,
				"id_suscrito" 	=> 	$id_suscrito //asigno el valor de la funcion al json
			)
		);	
	}else{
		echo json_encode(array("res" => "empty"));
	}
    
}
?>