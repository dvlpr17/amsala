<?php 

//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
// ORDEN DE LOS DATOS PARA ALMACENAR
// nombre, composicion, colores, imagenes, medidas, descripcion
//~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
if(!empty($_POST["n"])){

    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    # ORDEN DE NOMBRE, COMPOSICION, COLORES
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    $prod_data = [];
    $prod_data[] = $_POST["n"];
    $prod_data[] = $_POST["compo"];
    $prod_data[] = $_POST["respaldoColores"];


    $lasPartesParticipantes = explode(",", $_POST["respaldoCole"]);

    // echo $lasPartesParticipantes[0];
    // echo "<br>";
    // echo $lasPartesParticipantes[1];
    // echo "<br>";



    //=====================================================================
    // ELIMINAR IMAGENES ANTERIORES SI LAS HAY
    //=====================================================================
    if(!empty($_POST["imgsEliminadas"])){

        # BORRAR DE LA BASE DE DATOS
        // echo "Fotos registradas en BD: ".$_POST["imgsAComparar"]."<br>";
        // echo "Fotos a retirar: ".$_POST["imgsEliminadas"]."<br><br>";
        
        
        # SEPARAR LISTA DE IMAGENES LAS QUE SE BORRAN Y LAS QUE SE QUEDAN
        $imgsSaved = explode(",", $_POST["imgsAComparar"]);
        $imgsDeleted = explode(",", $_POST["imgsEliminadas"]);

        $result = array_diff($imgsSaved, $imgsDeleted);
        $ElResult = array_values($result);

        for ($i=0; $i < count($ElResult); $i++) { 
            if($i==0){
                $fotosFinales = $ElResult[$i]; 
            }else{
                $fotosFinales .= ",".$ElResult[$i]; 
            }
        }

        # BORRADO DE IMAGENES        
        foreach ($imgsDeleted as $k2 => $v2) {
            if (file_exists($v2)) {
                unlink($v2);
            }                
        }

    }else if(!empty($_POST["imgsAComparar"])){
        $fotosFinales = $_POST["imgsAComparar"];
    }



//=====================================================================
// SUBIR IMAGENES SELECCIONADAS
//=====================================================================

    $lasImagenes = "";
    $contadorImagenes = count($_FILES["respaldoImagenes"]['tmp_name']);
    foreach($_FILES["respaldoImagenes"]['tmp_name'] as $key => $tmp_name) {
        // echo $_FILES["respaldoImagenes"]["name"][$key];
        if($_FILES["respaldoImagenes"]["name"][$key]) {

            // Declaramos un  variable con la ruta donde guardaremos los archivos
            $directorio = '../../imgs/'.$lasPartesParticipantes[1];
            
            //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio)){
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
            }

   			$name = basename($_FILES["respaldoImagenes"]["name"][$key]);
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

    if(empty($lasImagenes)){
        if(!empty($fotosFinales)){
            $lasImagenes .= $fotosFinales;
        }
    }else{
        if(!empty($fotosFinales)){
            $lasImagenes .= ",".$fotosFinales;
        }
    }



    
    # MOVER ARCHIVOS A LA CARPETA $lasPartesParticipantes[1]
    //https://stackoverflow.com/questions/19139434/php-move-a-file-into-a-different-folder-on-the-server
    
    # SI LA COLECCIÓN CAMBIO MOVER LAS IMAGENES DE CARPETA
    if($_POST["respCole"] != $lasPartesParticipantes[1]){

        $path = '../../imgs/'.$lasPartesParticipantes[1];

        if(!file_exists($path)){
            mkdir($path, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
        }


        $nuevaRuta = str_replace($_POST["respCole"], $lasPartesParticipantes[1], $lasImagenes);
        $destino = explode(",",$nuevaRuta);
        $origen = explode(",",$lasImagenes);
        $cont=0;
        foreach($destino as $file){
            rename($origen[$cont],$file);
            $cont++;
        }
        
        $lasImagenes = $nuevaRuta;

        require_once '../clases/colec_prod.php';
        $setColeProd = ColeProd::singleton_coleProd();
        $setColeProd->updateColeProd($lasPartesParticipantes[0],$_POST["ElId"]);

    }




    $prod_data[] = $lasImagenes;

    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    # ORDEN DE MEDIDAS Y DESCRIPCIÓN
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    $medidas="";
    foreach ($_POST as $key => $value) {
        if($key == "respaldoMed"){
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
    $prod_data[] = $_POST["des"];
    $prod_data[] = $_POST["ElId"];

    // echo "<pre>";
    // print_r($prod_data);
    // echo "</pre>";

    // echo $_POST["respaldoCole"];

    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    # ALMACENAR EL PROCUDUCTO EN BASE DE DATOS Y RECIBIR SU ID
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    require_once '../clases/productos.php';
    $producto = Productos::singleton_productos();
    $producto->updateProd($prod_data);

    
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