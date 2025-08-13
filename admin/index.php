<?php
session_start();

//Si el usuario no esta logeado lo enviamos al login
if (!$_SESSION['usuarioLogeado']) {
    header("Location: login.php");
}

include "funciones.php";

$totalPreguntas = obtenerTotalPreguntas();
$categorias =  obtenerCategorias();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
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
    <div class="contenedor">
        <header align="center">
            <h1>PON A PRUEBA TUS CONOCIMIENTOS - ADMIN</h1>
        </header>
        <div class="contenedor-info">
            <?php include "nav.php" ?>
            <div class="panel">
                <h2>Panel Principal</h2>
                <hr>
                <div id="dashboard">
                    <div class="card gradiente3" style="width: 100%;">
                        <span class="tema">Total</span>
                        <span class="cantidad"><?php echo $totalPreguntas?></span>
                        <span> Preguntas Registradas</span>
                    </div>

                    <!-- <?php while ($cat = mysqli_fetch_assoc($categorias)):?>
                    <div class="card gradiente1">
                        <span class="tema"><?php echo obtenerNombreTema($cat['tema']);?></span>
                        <span class="cantidad"> <?php echo totalPreguntasPorCategoria($cat['tema']);?></span>
                        <span> Preguntas</span>
                    </div>
                    <?php endwhile ?> -->
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <script>paginaActiva(0);</script>   
</body>
</html>