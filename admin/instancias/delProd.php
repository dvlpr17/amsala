<?php
if(!empty($_POST["prodAEliminar"])){

    # ELIMINAR REGISTRO DE LA TABLA PRODUCTOS
    require_once '../clases/productos.php';
    $producto = Productos::singleton_productos();
    $producto->delProd($_POST["prodAEliminar"]);


    # ELIMINAR REGISTRO DE LA TABLA RELACIÓN PRODUCTO COLECCIÓN
    require_once '../clases/colec_prod.php';
    $setColeProd = ColeProd::singleton_coleProd();
    $setColeProd->delColeProd($_POST["prodAEliminar"]);


    # ELIMINAR ARCHIVOS DE LA CARPETA
    // echo $_POST["imagenes"];
    $imgsDeleted = explode(",", $_POST["imagenes"]);

    foreach ($imgsDeleted as $k2 => $v2) {
        if (file_exists($v2)) {
            unlink($v2);
        }                
    }



}