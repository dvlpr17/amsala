<?php

require_once 'clases/log.php';



if(isset($_SESSION['am11012022'])){header("Location:instancias/admin.php");}
if(isset($_POST['nombre']))
{
    $nick = $_POST['nombre'];
    $password = $_POST['password'];
    //accedemos al método usuarios y los mostramos
    $instanciaUsuario = Log::singleton_Log();
    $usuario = $instanciaUsuario->comprobarCredenciales($nick,$password);
    
    if($usuario == TRUE){
        header("Location:instancias/admin.php");
    }
}



?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>AMSALA</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/log_style.css">
</head>
<body>


    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-3">
                <img class="img-fluid" src="../imgs/varias/amsala.jpg">
            </div>
        </div>
        <form id="form_contacto" class="form-signin" name="form_contacto" action="index.php" method="post">
            <label for="name" class="sr-only">Nombre de Usuario</label>
            <input type="text" id="nombre" class="form-control" placeholder="Nombre de usuario" required autofocus name="nombre">
            <label for="inputPassword" class="sr-only">Clave</label>
            <input type="password" id="inputPassword" class="form-control mt-2" placeholder="Clave" required name="password">
            <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">Enviar</button>
        </form>

    </div> <!-- /container -->


    <footer class="container">
        <div class="row">
            <div class="col-12">
                <p class="text-center">© 
                    <script type="text/javascript">var d = new Date(); document.write(d.getFullYear());</script> AMSALA
                </p>
            </div>
        </div>
    </footer>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js"></script>

</body>
</html>