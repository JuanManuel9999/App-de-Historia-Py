<?php
session_start();

// Si el usuario no esta logeado lo enviamos al login
if (!$_SESSION['usuarioLogeado']) {
    header("Location: login.php");
}

include "funciones.php";

$config = obtenerConfiguracion();

/******************************************************* */
// ACTUALIZAMOSS LA CONFIGURACION
if (isset($_GET['actualizar'])) {
    // Nos conectamos a la base de datos
    include "conexion.php";

    // Tomamos los datos que vienen del formulario
    $usuario = htmlspecialchars($_GET['usuario']);
    $password = htmlspecialchars($_GET['password']);
    $totalPreguntas = $_GET['totalPreguntas'];

    // Armamos el query para actualizar en la tabla configuracion
    $query = "UPDATE config SET usuario='$usuario', password='$password', totalPreguntas='$totalPreguntas' WHERE id='1'";

    // Actualizamos en la tabla configuracion
    if (mysqli_query($conn, $query)) { // Se actualizo correctamente
        $mensaje = "La configuración se actualizó correctamente";
        header("Location: index.php");
    } else {
        $mensaje = "No se pudo actualizar en la Base de Datos" . mysqli_error($conn);
    }
}

// ELIMINAR PREGUNTAS
if (isset($_GET['eliminarPreguntas'])) {
    // Nos conectamos a la base de datos
    include "conexion.php";

    // Sentencia para eliminar los datos de la tabla
    $query = "TRUNCATE TABLE preguntas";

    // Eliminamos los datos de la tabla preguntas
    if (mysqli_query($conn, $query)) { // Se eliminó correctamente
        $mensaje = "Se eliminaron los datos de la tabla preguntas";
        header("Location: index.php");
    } else {
        $mensaje = "No se pudo eliminar en la Base de Datos" . mysqli_error($conn);
    }
}

// ELIMINAMOS LAS PREGUNTAS Y LAS CATEGORIAS
if (isset($_GET['eliminarTodo'])) {
    // Nos conectamos a la base de datos
    include "conexion.php";

    // Sentiencia para eliminar los datos de la tabla
    $query1 ="TRUNCATE TABLE preguntas";
    $query2 ="TRUNCATE TABLE temas";

    // Eliminamos los datos de la tabla preguntas
    if (mysqli_query($conn, $query1)) { // Se eliminó correctamente
        if (mysqli_query($conn, $query2)) { // Se eliminó correctamente
            $mensaje = "Se eliminaron las preguntas y las categorias";
            header("Location: index.php");
        } else {
            $mensaje = "No se pudo eliminar las categorias en la BD" . mysqli_error($conn);
        }
    } else {
        $mensaje = "No se pudo eliminar en la Base de Datos" . mysqli_error($conn);
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
    <title>Configuración</title>
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
    <div class="contenedor">
        <header align="center">
            <h1>PON A PRUEBA TUS CONOCIMIENTOS - ADMIN</h1>
        </header>
        <div class="contenedor-info">
            <?php include "nav.php" ?>
            <div class="panel">
                <h2>Configuración del Administrador</h2>
                <hr>
                <section id="configuracion">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get" autocomplete="off">
                        <div class="fila">
                            <label for="">Usuario:</label>
                            <input type="text" name="usuario" value="<?php echo $config['usuario']?>" required>
                        </div>
                        <div class="fila">
                            <label for="">Password</label>
                            <input type="password" name="password" value="<?php echo $config['password']?>" required>
                        </div>
                        <div class="fila">
                            <label for="">Total Preguntas por Juego</label>
                            <input type="number" name="totalPreguntas" value="<?php echo $config['totalPreguntas']?>" required>
                        </div>
                        <hr>
                        <input type="submit" value="Actualizar Configuración" name="actualizar" class="btn-actualizar">
                    </form>
                </section>

                <h2>Preguntas sobre Historia del Paraguay</h2>
                <hr>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get" class="form-eliminar">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <input type="submit" value="Eliminar todas las preguntas" title="Eliminar todas las preguntas" name="eliminarPreguntas" class="btn-eliminar">
                    <!-- <input type="submit" value="Eliminar Preguntas (Solo se eliminarán las preguntas)" title="Eliminar Preguntas (Solo se eliminarán las preguntas)" name="eliminarPreguntas" class="btn-eliminar"> -->
                    <!-- <input type="submit" value="Eliminar Preguntas sobre Historia del Paraguay" title="Eliminar Preguntas sobre Historia del Paraguay" name="eliminarTodo" class="btn-eliminar"> -->
                </form>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <script>paginaActiva(4);</script> 
</body>
</html>