<?php
#LIPIAR EL NOMBRE DE LA COLECCION PARA ASIGNAR A LA CARPETA
$trimmed = eliminar_acentos(strtolower(str_replace(" ","",$_POST['valor'])));
// echo $trimmed;


#CREAR EL DIRECTORIO DONDE SE VAN A GUARDAR LAS IMAGENES
$directorio = '../../imgs/'.$trimmed;

// Validamos si la ruta de destino existe, en caso de no existir la creamos
if(!file_exists($directorio)){
    mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
}

#REGISTRAR EN LA BD EL NOMBRE DE LA COLECCIÓN
require_once '../clases/colecciones.php';
$cole = Colecciones::singleton_Colecciones();
$cole->setColeccion($_POST['valor'], $trimmed);


/////////////////////////////////////////////////////////
// HELPERS
/////////////////////////////////////////////////////////
function camelCase($string, $dontStrip = []){
    return lcfirst(str_replace(' ', '', ucwords(preg_replace('/^a-z0-9'.implode('',$dontStrip).']+/', ' ',$string))));
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
