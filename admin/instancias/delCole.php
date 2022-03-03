<?php
  
#------------------------------------------------------------
#MOVER LOS ARCHIVOS DEL DIRECTORIO ELIMINADO AL DIRECTORIO SIN COLECCION

if(!empty($_POST["id"])){

    require_once '../clases/colecciones.php';
    $cole = Colecciones::singleton_Colecciones();
    $res = $cole->get_coleccion($_POST["id"]);


    # ELIMINAR LA CARPETA CON TODAS LAS IMAGENES
    $resultadoLimpio = strtolower(str_replace(" ","",$res));
    $directorio = '../../imgs/'.$resultadoLimpio;


    # FUNCION PARA BORRAR TODOS LOS ARCHIVOS ALMACENADOS EN LA CARPETA
    function delTree($dir) {
    $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    } 

    if(file_exists($directorio)){
        delTree($directorio);
    }

    # ELIMINAR REGISTRO EN LA TABLA COLECCIONES
    $cole->delColeccion($_POST["id"]);

    # ELIMINAR PRODUCTOS RELACIONADOS CON LA COLECCIÓN
    require_once '../clases/colec_prod.php';
    $setColeProd = ColeProd::singleton_coleProd();
    $respuesta = $setColeProd->IDs($_POST["id"]);

    // print_r($respuesta);

    require_once '../clases/productos.php';
    $producto = Productos::singleton_productos();

    $IDsAModificar = [];
    for ($i=0; $i < count($respuesta); $i++) {
        $IDsAModificar[$i] = $respuesta[$i]["idProd"];
        $producto->delProd($IDsAModificar[$i]);
        $setColeProd->delColeProd($IDsAModificar[$i]);
    }

}








