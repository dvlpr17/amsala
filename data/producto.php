<?php

if(isset($_GET['id'])) {

    require_once '../admin/clases/productos.php';
    $producto = Productos::singleton_productos();
    $res = $producto->get_producto($_GET['id']);
    echo json_encode($res, JSON_UNESCAPED_UNICODE);

}