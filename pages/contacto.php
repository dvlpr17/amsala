<?php 

require_once 'send/class.phpmailer.php'; // Envio de correos


$hoy = date("Y");
if($_POST['nombre']){

    $cuerpoMensaje = '
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Amsala</title>
</head>

<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="800">
                    <tr>
                        <td align="center" style="padding: 25px 0px;background-color: #fff;">
                            <img src="https://www.amsala.com.mx/imgs/varias/amsala.jpg" alt="Amsala"
                                style="display: block;" />
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#f8f6f5" align="center"
                            style="color: #84796c; margin-top:20px; font-family: Arial, sans-serif;padding:0px 0px 30px
                            0;border-top: 1px solid #c1bcb5;border-left:#c1bcb5 1px solid;border-right:1px solid
                            #c1bcb5;">
                            <h1 style="font-size:30px; margin-top:20px;"><strong>Comentarios </strong></h1>
                            <p><strong>Nombre: </strong>'.$_POST['nombre'].'</p>
                            <p><strong>Teléfono: </strong>'.$_POST['telefono'].'</p>
                            <p><strong>Correo: </strong>'.$_POST['correo'].'</p>
                            <p><strong>Comentarios: </strong>'.$_POST['mensaje'].'</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" bgcolor="#f8f6f5"
                            style="padding: 25px 0px; font-family: Arial, sans-serif;border-bottom: #c1bcb5 1px
                            solid;border-left: 1px solid#c1bcb5;border-right: 1px solid #c1bcb5;color:#84796c;">
                            <p>© '.$hoy.' Amsala</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>'; 

//echo $cuerpoMensaje;

    $asunto = "Amsala Contacto";
    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';
    $mail->From = "info@amsala.com.mx";
    $mail->FromName = 'Amsala';
    $mail->Subject = "=?UTF-8?B?".base64_encode($asunto)."=?=";
    $mail->Body = $cuerpoMensaje;
    $mail->IsHTML(true);



        $recipients = array(
            // 'web@dobleerre.com' => 'Direccion',
            'web@dobleerre.com' => 'Diego Arias'
            // 'oskar@dobleerre.com' => 'Dirección',
            // 'mkt@dobleerre.com' => 'Diseño'
        );

        foreach($recipients as $email => $name){
            $mail->AddAddress($email, $name);
            $mail->Send();
            $mail->ClearAddresses();
        }

    header("Location: gracias.html");


}
