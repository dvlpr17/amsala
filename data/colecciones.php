<?php

//----------------------------------------------------------
// REGRESA LAS TODAS LAS COLECCIONES
//----------------------------------------------------------
require_once '../admin/clases/colecciones.php';
$cole = Colecciones::singleton_Colecciones();
$res = $cole->get_colecciones();
echo json_encode($res, JSON_UNESCAPED_UNICODE);
