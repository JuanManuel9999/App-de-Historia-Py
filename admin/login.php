<?php
session_start();
include "funciones.php";

// Obtengo la configuración para comprobar el usuario y la contraseña
$config = obtenerConfiguracion();

// Pregunto si se presionó el boton ingresar (login)
if (isset($_POST['login'])) {
    // Tomo los datos que vienen del cliente
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Comparo con los datos del usuario guardados en la base de datos
    if (($usuario == $config['usuario']) && ($password == $config['password'])) {
        $_SESSION['usuarioLogeado'] = "Administrador";
        header("Location: index.php");
    } else {
        $mensaje = "* El nombre de usuario o la contraseña son incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="estilo.css">
    <link rel="icon" href="../icono/lista-de-verificacion.png">
    <title>PON A PRUEBA TUS CONOCIMIENTOS - ADMIN</title>
    <style>
        body {
            background: url(../img/Bandera-paraguaya.jpeg);
            background-attachment: fixed;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            padding: 40px;
        }
    </style>
</head>
<body>
    <div class="contenedor-login">
        <h1>SABÍA USTED?</h1>
        <p align="center">Pon a prueba tu conocimiento</p>
        <div class="contenedor-form">
            <h3>Administrador</h3>
            <hr>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" autocomplete="off">
                <div class="fila">
                    <label for="">Usuario:</label>
                    <div class="entrada">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="usuario" placeholder="Nombre de usuario" autofocus>
                    </div>
                   
                </div>
                <div class="fila">
                    <label for="">Contraseña:</label>
                    <div class="entrada">
                        <i class="fa-solid fa-key"></i>
                        <input type="password" name="password" placeholder="Contraseña">
                    </div>
                </div>
                <hr>
                <input type="submit" name="login" value="Ingresar" class="btn" title="Ingresar" style="width: 100%;">
            </form>

            <!-- Mensaje que se mostrará cuando se haya procesado la solicitud en el servidor -->
            <?php if (isset($_POST['login'])) : ?>
                <span class="msj-error-input" style="color: red; font-size: 14px;"> <?php echo $mensaje ?></span>
            <?php endif ?>
        </div>

    </div>
</body>
</html>