<?php
session_start();

// Si el usuario no esta logeado lo enviamos al index
if (!$_SESSION['usuario']) {
    header("Location: index.php");
}

include "admin/funciones.php";

// Variables que controlan la partida
$confi = obtenerConfiguracion();
$totalPreguntasPorJuego = $confi['totalPreguntas'];

if (isset($_GET['siguiente'])) { // Ya está jugando
    aumentarRespondidas();

    $respuestaUsuario = $_GET['respuesta'];
    $idPreguntaActual = $_SESSION['idPreguntas'][$_SESSION['numPreguntaActual']];
    $preguntaActual = obtenerPreguntaPorId($idPreguntaActual);

    // Guardar en el historial de respuestas
    $_SESSION['resumen'][] = [
        'pregunta' => $preguntaActual['pregunta'],
        'opcion_a' => $preguntaActual['opcion_a'],
        'opcion_b' => $preguntaActual['opcion_b'],
        'opcion_c' => $preguntaActual['opcion_c'],
        'correcta' => $preguntaActual['correcta'],
        'respuesta_usuario' => $respuestaUsuario
    ];

    // Controlar si es correcta
    if ($_SESSION['respuesta_correcta'] == $respuestaUsuario) {
        $_SESSION['correctas']++;
    }

    $_SESSION['numPreguntaActual']++;

    if ($_SESSION['numPreguntaActual'] < ($totalPreguntasPorJuego)) {
        $preguntaActual = obtenerPreguntaPorId($_SESSION['idPreguntas'][$_SESSION['numPreguntaActual']]);
        $_SESSION['respuesta_correcta'] = $preguntaActual['correcta'];
    } else {
        $_SESSION['incorrectas'] = $totalPreguntasPorJuego - $_SESSION['correctas'];
        $_SESSION['nombreCategoria'] = obtenerNombreTema($_SESSION['idCategoria']);
        $_SESSION['score'] = ($_SESSION['correctas'] * 100) / $totalPreguntasPorJuego;

        // Redirigir al resumen
        header("Location: resumen.php");
        exit();
    }
} else { // Comenzó a jugar
    $_SESSION['correctas'] = 0;
    $_SESSION['numPreguntaActual'] = 0;
    $_SESSION['preguntas'] = obtenerIdsPreguntasPorCategoria($_SESSION['idCategoria']);
    $_SESSION['idPreguntas'] = array();
    $_SESSION['resumen'] = []; // 🔹 Nuevo: inicializar historial

    foreach ($_SESSION['preguntas'] as $idPregunta) {
        array_push($_SESSION['idPreguntas'], $idPregunta['id']);
    }

    shuffle($_SESSION['idPreguntas']);
    $preguntaActual = obtenerPreguntaPorId($_SESSION['idPreguntas'][0]);
    $_SESSION['respuesta_correcta'] = $preguntaActual['correcta'];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PON A PRUEBA TUS CONOCIMIENTOS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="estilo.css">
    <link rel="icon" href="icono/lista-de-verificacion.png">
    <style>
        body {
            margin: 0;
            height: 100vh;
            background: url(img/Bandera-paraguaya.jpeg);
            background-attachment: fixed;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            padding: 100px 10px 0 10px;
        }

        .container-juego {
            position: relative;
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            margin: auto;
            padding: 30px 0 100px 0;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
        }

        #mensaje-respuesta {
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container-juego" id="container-juego">
        <header class="header">
            <div class="categoria">
                <?php echo obtenerNombreTema($preguntaActual['tema']) ?>
            </div>
            <a href="index.php"><i class="fas fa-arrow-left"></i> Volver a inicio</a>
        </header>
        <div class="info">
            <div class="estadoPregunta">
                Pregunta <span class="numPregunta"><?php echo $_SESSION['numPreguntaActual'] + 1 ?></span> de <?php echo $totalPreguntasPorJuego ?>
            </div>
            <h3>
                <?php echo $preguntaActual['pregunta'] ?>
            </h3>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get" autocomplete="off">
                <div class="opciones">
                    <label onclick="seleccionarRespuesta(this)" data-correcta="<?php echo ($preguntaActual['correcta'] == 'A') ? '1' : '0'; ?>" data-respuesta="<?php echo $preguntaActual['opcion_a']; ?>">
                        <p><?php echo $preguntaActual['opcion_a'] ?></p>
                        <input type="radio" name="respuesta" value="A" required>
                    </label>
                    <label onclick="seleccionarRespuesta(this)" data-correcta="<?php echo ($preguntaActual['correcta'] == 'B') ? '1' : '0'; ?>" data-respuesta="<?php echo $preguntaActual['opcion_b']; ?>">
                        <p><?php echo $preguntaActual['opcion_b'] ?></p>
                        <input type="radio" name="respuesta" value="B" required>
                    </label>
                    <label onclick="seleccionarRespuesta(this)" data-correcta="<?php echo ($preguntaActual['correcta'] == 'C') ? '1' : '0'; ?>" data-respuesta="<?php echo $preguntaActual['opcion_c']; ?>">
                        <p><?php echo $preguntaActual['opcion_c'] ?></p>
                        <input type="radio" name="respuesta" value="C" required>
                    </label>
                </div>

                <!-- Contenedor del mensaje -->
                <div id="mensaje-respuesta"></div>

                <div class="boton">
                    <input type="submit" value="Siguiente" name="siguiente" title="Siguiente" style="width: 100%; padding: 20px 40px;">
                </div>
            </form>
        </div>
    </div>

    <script>
    function seleccionarRespuesta(elemento) {
        const esCorrecta = elemento.getAttribute("data-correcta") === "1";
        const mensajeDiv = document.getElementById("mensaje-respuesta");

        // Buscar la respuesta correcta
        const opciones = document.querySelectorAll(".opciones label");
        let respuestaCorrecta = "";
        opciones.forEach(op => {
            if (op.getAttribute("data-correcta") === "1") {
                respuestaCorrecta = op.getAttribute("data-respuesta");
            }
        });

        if (esCorrecta) {
            mensajeDiv.textContent = "¡Respuesta correcta!";
            mensajeDiv.style.color = "green";
        } else {
            mensajeDiv.textContent = `Respuesta incorrecta. La respuesta correcta es: ${respuestaCorrecta}`;
            mensajeDiv.style.color = "red";
        }

        // Ocultar después de 7 segundos
        setTimeout(() => {
            mensajeDiv.textContent = "";
        }, 7000);
    }
    </script>
</body>
</html>
