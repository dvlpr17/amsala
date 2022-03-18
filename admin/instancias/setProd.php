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


            // Declaramos un  variable con la ruta donde guardaremos los archivos
            $directorio = '../../imgs/'.$lasPartesParticipantes[1];
            
            //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio)){
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
            }

            
   			$name = basename($_FILES["formFile"]["name"][$key]);
		    list($base,$extension) = explode('.',$name);
			$trimmed = strtolower(str_replace(" ","",eliminar_acentos($base)));
		    $newname = $trimmed.time().'.'.$extension;


            //Indicamos la ruta de destino, así como el nombre del archivo
            $target_path = $directorio.'/'.$newname; 
            if($contadorImagenes > 1){
                $lasImagenes .= $target_path.",";
            }else{
                $lasImagenes .= $target_path;
            }
            $contadorImagenes--;
            
            // Abrimos el directorio de destino
            if ($tmp_name == UPLOAD_ERR_OK) {
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


function eliminar_acentos($cadena){
		
    //Reemplazamos la A y a
    $cadena = str_replace(
    array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
    array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
    $cadena
    );

    //Reemplazamos la E y e
    $cadena = str_replace(
    array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
    array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
    $cadena );

    //Reemplazamos la I y i
    $cadena = str_replace(
    array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
    array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
    $cadena );

    //Reemplazamos la O y o
    $cadena = str_replace(
    array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
    array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
    $cadena );

    //Reemplazamos la U y u
    $cadena = str_replace(
    array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
    array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
    $cadena );

    //Reemplazamos la N, n, C y c
    $cadena = str_replace(
    array('Ñ', 'ñ', 'Ç', 'ç'),
    array('N', 'n', 'C', 'c'),
    $cadena
    );
    
    return $cadena;
}