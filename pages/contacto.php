<?php 


$ip = $_SERVER['REMOTE_ADDR'];
$captcha = $_POST['g-recaptcha-response'];
$secretkey = "";
$respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");

$atributos = json_decode($respuesta, TRUE);



if(!$atributos['success']){
    header("Location: contacto.html");
}else if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $mensaje = $_POST['mensaje'];


    $hoy = date("Y");

    if(empty($nombre)){
        header("Location: contacto.html");
    }
    if(empty($correo)){
        header("Location: contacto.html");
    }
    if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
        header("Location: contacto.html");
    }
    if(empty($telefono)){
        header("Location: contacto.html");
    }
    if(empty($mensaje)){
        header("Location: contacto.html");
    }


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


    //===========================================
    // PHPMailer
    //https://www.youtube.com/watch?v=J4s9DMzUt3I&ab_channel=AbiramL%C3%B3pez
    // Captcha
    // https://www.youtube.com/watch?v=M1jkZx2crBg&ab_channel=C%C3%B3digosdeProgramaci%C3%B3n-MR
    //===========================================
        
        require_once ("phpmailer/clsMail.php");
        $mailSend = new clsMail();
        $enviado =  $mailSend->metEnviar("info@amsala.com.mx",$_POST['nombre'],$_POST['correo'],"Comentarios desde Amsala Web", $cuerpoMensaje);

        header("Location: gracias.html");
        
}else{
    header("Location: contacto.html");

}




