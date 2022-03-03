<?php


if(!empty($_POST["laNueva"])){
    // echo "La nueva carpeta: ".$_POST["laNueva"];
    // echo "La vieja carpeta: ".$_POST["laAnterior"];
    $newNameFolder = str_replace(" ","",strtolower($_POST["laNueva"]));

    # Modificar los productos afectados con el cambio
    
    # - Obtener Ids de productos de la tabla coleccion productos
    require_once '../clases/colec_prod.php';
    $setColeProd = ColeProd::singleton_coleProd();
    $LosIDs = $setColeProd->IDs($_POST["id"]);

    $IDsAModificar = [];
    for ($i=0; $i < count($LosIDs); $i++) { 
        $IDsAModificar[] = $LosIDs[$i]["idProd"];
    }

    
    # - Cambiar la ruta de las imagenes de cada uno de los productos
    require_once '../clases/productos.php';
    $producto = Productos::singleton_productos();
    $resp = $producto->cambioDeColeccion($IDsAModificar, $newNameFolder, $_POST["laAnterior"]);

    # Cambiar el nombre de la colección
    require_once '../clases/colecciones.php';
    $cole = Colecciones::singleton_Colecciones();
    $cole->updateColeccion($_POST["laNueva"], $newNameFolder, $_POST["id"]);

    # Renombrar la carpeta
    rename('../../imgs/'.$_POST["laAnterior"], '../../imgs/'.$newNameFolder);

}

