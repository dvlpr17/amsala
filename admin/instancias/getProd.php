<?php 

require_once '../clases/productos.php';

$producto = Productos::singleton_productos();
$res = $producto->get_producto($_POST['id']);

// print_r($res);
echo json_encode($res);

 ?>