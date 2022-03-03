<?php 

require 'serverside.php';
$table_data = new TableData();
//get('nombre de la vista','ordenado por',(Los datos a mostrar))
echo $table_data->get('vp','id', array('id','nombre','composicion','colores','medidas','de','imagen','nombrecole'));

//REFERENCIA
//https://es.stackoverflow.com/questions/237941/crear-una-vistas-en-mysql-con-m%C3%BAltiples-tablas
//CREA UNA VISTA CON LA RELACIÓN ENTRE DOS TABLAS PRODUCTOS Y COLECCION TIENEN EN COMUN RELACOLEPROD
// LA VISTA MUESTRA LOS DATOS DEL PRODUCTO Y EL NOMBRE DE LA COLECCIÓN A LA QUE PERTENECE
//CREATE OR REPLACE VIEW `vp` AS SELECT productos.id,productos.nombre,productos.composicion,productos.colores,productos.imagen,productos.medidas,productos.de,colecciones.nombrecole FROM `productos` LEFT JOIN (`relacoleprod`,`colecciones`) ON (productos.id = relacoleprod.idProd AND relacoleprod.idCole = colecciones.id);
