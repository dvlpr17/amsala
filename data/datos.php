<?php

if(isset($_GET['id'])) {

    require_once '../admin/clases/productos.php';
    $producto = Productos::singleton_productos();
    $res = $producto->prodPorColeccion($_GET['id']);
    echo json_encode($res, JSON_UNESCAPED_UNICODE);

}

/*
//----------------------------------------------------------
// REGRESA LAS TODAS LAS COLECCIONES
//----------------------------------------------------------
echo "<br><br>";
require_once '../admin/clases/colecciones.php';
$cole = Colecciones::singleton_Colecciones();
$res = $cole->get_colecciones();
for($i=0;$i<count($res);$i++){
    echo '<a href="?id='.$res[$i]['id'].'">'.$res[$i]['nombrecole'].'</a><br>';
}
*/