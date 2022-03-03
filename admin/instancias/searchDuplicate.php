<?php 




if($_POST["tipo"] == "producto"){
	require_once '../clases/productos.php';
	$producto = Productos::singleton_productos();
	$resultado = $producto->comprobarProducto($_POST['variable']);

	// print_r($LasCitas);
	echo $resultado;
}

if($_POST["tipo"] == "coleccion"){
	require_once '../clases/colecciones.php';
	$coleccion = Colecciones::singleton_Colecciones();
	$resultado = $coleccion->comprobarColeccion($_POST['variable']);

	// print_r($LasCitas);
	echo $resultado;
}

if($_POST["tipo"] == "telefono"){
	
	$citas = Citas::singleton_citas();
	$cliente = $citas->comprobarTel($_POST['variable']);

	// print_r($LasCitas);
	echo $cliente;
}


 ?>