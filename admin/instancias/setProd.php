<?php

if(!empty($_POST["nombre"])){

    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    // ORDEN DE LOS DATOS PARA ALMACENAR
    // nombre, composicion, colores, imagenes, medidas, descripcion
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-

    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    # ORDEN DE NOMBRE, COMPOSICION, COLORES
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    $prod_data = [];
    $prod_data[] = $_POST["nombre"];
    $prod_data[] = $_POST["composicion"];
    $prod_data[] = $_POST["losColores"];


    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    # ORDEN DE IMAGENES
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    $lasPartesParticipantes = explode(",",$_POST["lasColecciones"]);
    // echo $lasPartesParticipantes[0];
    // echo "<br>";
    // echo $lasPartesParticipantes[1];
    // echo "<br>";

    $lasImagenes = "";
    $contadorImagenes = count($_FILES["formFile"]['tmp_name']); 
    foreach($_FILES["formFile"]['tmp_name'] as $key => $tmp_name) {
        if($_FILES["formFile"]["name"][$key]) {

            $filename = $_FILES["formFile"]["name"][$key]; //Obtenemos el nombre original del archivo
            $source = $_FILES["formFile"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
            

            // Declaramos un  variable con la ruta donde guardaremos los archivos
            $directorio = '../../imgs/'.$lasPartesParticipantes[1];
            
            //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio)){
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
            }
            
            //Indicamos la ruta de destino, así como el nombre del archivo
            $target_path = $directorio.'/'.$filename; 
            if($contadorImagenes > 1){
                $lasImagenes .= $target_path.",";
            }else{
                $lasImagenes .= $target_path;
            }
            $contadorImagenes--;
            
            //Abrimos el directorio de destino
            $dir=opendir($directorio); 
            if ($tmp_name == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["formFile"]["tmp_name"][$key];
                $name = basename($_FILES["formFile"]["name"][$key]);
                move_uploaded_file($tmp_name, $target_path);
            }

        }
    }
    $prod_data[] = $lasImagenes;

    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    # ORDEN DE MEDIDAS, DESCRIPCION
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    $medidas="";
    foreach ($_POST as $key => $value) {
        if($key == "medida"){
            $contadorMedidas = count($value);
            foreach ($value as $k) {
                if($contadorMedidas > 1){
                    $medidas .= $k.',';
                }else{
                    $medidas .= $k;
                }
                $contadorMedidas--;
            }
        }
    }
    $prod_data[] = $medidas;
    $prod_data[] = $_POST["descripcion"];
    // print_r($prod_data);



    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    # ALMACENAR EL PROCUDUCTO EN BASE DE DATOS Y RECIBIR SU ID
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    require_once '../clases/productos.php';
    $producto = Productos::singleton_productos();
    $res = $producto->setProd($prod_data);
    $theLastId = $res[(count($res)-1)]["id"];

    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    # ALMACENAR LA RELACIÓN ENTRE EL PRODUCTO Y LA COLECCIÓN
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    require_once '../clases/colec_prod.php';
    $setColeProd = ColeProd::singleton_coleProd();
    $setColeProd->setColeProd($lasPartesParticipantes[0],$theLastId);


    header("Location: admin.php");

}else{
    header("Location: admin.php");
}