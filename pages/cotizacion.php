<?php 
require_once("send/class.phpmailer.php");

ob_start();
session_start();

// $local = $_POST["v8"];
echo '<style>
.cf {
  overflow: auto;
}
.cf::after {
  content: "";
  clear: both;
  display: table;
}
</style>';
 

$cadena2 = '<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="font-family:Verdana, Geneva, sans-serif; color:#282828; font-size:12px;">
<tr>
<th width="100" align="center" valign="middle">Producto</th>
<th width="100" align="center" valign="middle">Nombre</th>
<th width="100" align="center" valign="middle">Medida</th>
<th width="20" align="center" valign="middle">Cantidad</th>
<th width="100" align="center" valign="middle">Color</th>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>';

# ORDENA EL PEDIDO DE COJINES CON SUS VARIANTES
$r = [];
$salir = "no";

// print_r($_POST["v8"]);

if(!empty($_POST["v8"])){
    $a = explode(',|,',$_POST["v8"]);
    
    
    
    foreach($a as $element){
        $q = [];
        $q = explode(",",$element);
        if($q[0] == 1){
            $w[] = $element;
        }
        if($q[0] == 2){
            for($z=0;$z<count($w);$z++){
                $e = [];
                $e = explode(",",$w[$z]);
                if($e[2] == $q[4]){
                    $r[] = $w[$z];
                    $r[] = $element;
                }else{
                    $r[] = $w[$z];
                }
            }
            $w=[];
            for($s=0;$s<count($r);$s++){
                $w[] = $r[$s];
            }
            $r=[];
        }
    }
}

$q = [];
$parteRuta = [];


foreach($w as $ww){
    
    $q = explode(",",$ww);
    if($q[0] == 1){
        $parteRuta = explode("../",$q[1]);
        $rutaLimpia = "https://dobleerre.com/amsala/".$parteRuta[1];
        $cadena2 .='<tr>';
        $cadena2 .='<td width="100" align="center" valign="middle"><img src="'.$rutaLimpia.'" width="100"></td>';
        $cadena2 .='<td width="100" align="center" valign="middle">'.$q[2].'</td>';
        $cadena2 .='<td width="100" align="center" valign="middle">'.$q[3].'</td>';
        $cadena2 .='<td width="20" align="center" valign="middle">'.$q[4].'</td>';
        $cadena2 .='<td width="100" align="center" valign="middle"><div class="cf" style="display:inline-block;padding:10px 14px;background-color:'.$q[5].';color:'.$q[5].';">x</div></td>';
        $cadena2 .='<tr>';
    }
    if($q[0] == 2){
        $cadena2 .='<tr>';
        $cadena2 .='<td width="100" align="center" valign="middle"></td>';
        $cadena2 .='<td width="100" align="center" valign="middle"></td>';
        $cadena2 .='<td width="100" align="center" valign="middle">'.$q[1].'</td>';
        $cadena2 .='<td width="20" align="center" valign="middle">'.$q[2].'</td>';
        $cadena2 .='<td width="100" align="center" valign="middle"><div class="cf" style="display:inline-block;padding:10px 14px;background-color:'.$q[3].';color:'.$q[3].';margin-bottom:5px;">x</div></td>';
        $cadena2 .='<tr>';
    }
    
}


$cadena2 .='</table>';






$cadena = '
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">

</head>
<body>
    <table border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="">
        <tbody>
            <tr>
                <td width="210" bgcolor="" align="center" style="padding:20px 0;">
                    <img src="http://amsala.com.mx/imgs/varias/amsala.jpg" style="display: inline-block;" width="155" height="85">
                </td>
            </tr>
        </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="font-family:Verdana, Geneva, sans-serif; color:#282828; font-size:12px;">
        <tbody>
            <tr>
                <td width="165" align="left" valign="top" style="border-bottom: 1px solid #282828;">&nbsp;</td>
                <td width="435" align="left" valign="top" style="border-bottom: 1px solid #282828;">&nbsp;</td>
            </tr>
            <tr>
                <td width="140" align="left" valign="top">&nbsp;</td>
                <td width="460" align="left" valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td height="27" align="left" valign="middle"><span class="nom"><strong>Nombre:</strong></span></td>
                <td height="27" align="left" valign="middle">'.$_POST["v1"].'</td>
            </tr>
            <tr>
                <td height="30" align="left" valign="middle"><strong>E-mail:</strong></td>
                <td align="left" valign="middle">'.$_POST["v2"].'</td>
            </tr>
            <tr>
                <td height="30" align="left" valign="middle"><strong>Ciudad:</strong></td>
                <td align="left" valign="middle">'.$_POST["v3"].'</td>
            </tr>
            <tr>
                <td height="30" align="left" valign="middle"><strong>Tel&eacute;fono:</strong></td>
                <td align="left" valign="middle">'.$_POST["v4"].'</td>
            </tr>
            <tr>
                <td height="30" align="left" valign="middle"><strong>Estado:</strong></td>
                <td align="left" valign="middle">'.$_POST["v5"].'</td>
            </tr>
            <tr>
                <td height="30" align="left" valign="middle"><strong>Tipo de Cliente:</strong></td>
                <td align="left" valign="middle">'.$_POST["v6"].'</td>
            </tr>
            <tr>
                <td height="27" align="left" valign="middle"><span class="nom"><strong>Preguntas y/o Comentarios:</strong></span></td>
                <td height="27" align="left" valign="middle">'.$_POST["v7"].'</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td width="165" align="left" valign="top" style="border-bottom: 1px solid #282828;">&nbsp;</td>
                <td width="435" align="left" valign="top" style="border-bottom: 1px solid #282828;">&nbsp;</td>
            </tr>
        </tbody>
        </table>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="font-family:Verdana, Geneva, sans-serif; color:#282828; font-size:12px;">
            <tr>
                <td width="140" align="left" valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td width="140" align="left" valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td height="27" align="center" valign="middle"><span class="nom"><strong style="color:#305496;font-size:18px;">Productos a cotizar:</strong></span></td>
            </tr>
            <tr>
                <td width="140" align="left" valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td align="center" valign="middle">'.$cadena2.'</td>
            </tr>
            <tr>
                <td align="left" valign="top" style="border-bottom: 1px solid #282828;">&nbsp;</td>
            </tr>
        </table>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="font-family:Verdana, Geneva, sans-serif; color:#666; font-size:12px;">
            <tr>
                <td height="43" align="center" style="color:#282828; font-size:11px;">&copy; '.date("Y").' AMSALA.</td>
            </tr>
        </table>
</body>
</html>';


// echo $cadena;

//----------------------------------------------------------------------------------
//  ENVIO DE CORREO

    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';
    $mail->From = $_POST["v2"];
    $mail->FromName = $_POST["v1"];
    $mail->Subject = "Pedidos y cotizaciones";
    $mail->Body = $cadena;
    $mail->IsHTML(true);
    $mail->AddAddress("ventas@amsala.com.mx");
    // $mail->AddAddress("web@dobleerre.com");
    $mail->Send();
    $mail->ClearAddresses();
    $mail->ClearAttachments();



//----------------------------------------------------------------------------------
//  REDIRECCIONAMIENTO

    setcookie( 'contact', "3004KSJDCOW123456", time()+120,"/" );
    header('Location: gracias.html');





 ?>