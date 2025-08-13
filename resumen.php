<?php
session_start();

// Si el usuario no está logeado lo enviamos al index
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// Aumentamos la estadística
include "admin/funciones.php";
aumentarCompletados();

$resumen = $_SESSION['resumen'];
$correctas = $_SESSION['correctas'];
$incorrectas = $_SESSION['incorrectas'];
$score = $_SESSION['score'];
$categoria = $_SESSION['nombreCategoria'];

// Guardar datos del jugador si presiona "guardar"
if (isset($_GET['guardar'])) {
    include "admin/conexion.php";

    $nombre = htmlspecialchars($_GET['nombre']);
    $puntos_correctos = htmlspecialchars($_GET['puntos_correctos']);
    $puntos_incorrectos = htmlspecialchars($_GET['puntos_incorrectos']);
    $porcentaje = htmlspecialchars($_GET['porcentaje']);

    $query = "INSERT INTO jugadores (id, nombre, puntos_correctos, puntos_incorrectos, porcentaje) VALUES (NULL, '$nombre', '$puntos_correctos', '$puntos_incorrectos', '$porcentaje')";

    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit();
    } else {
        $mensaje = "No se pudo insertar: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PON A PRUEBA TUS CONOCIMIENTOS</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/easy-pie-chart/2.1.6/jquery.easypiechart.min.js" charset="utf-8"></script>
    <link rel="stylesheet" href="estilo.css">
    <link rel="icon" href="icono/lista-de-verificacion.png">
    <style>
        body {
            margin: 0;
            height: 100vh;
            background: url(img/Bandera-paraguaya.jpeg) no-repeat center center fixed;
            background-size: cover;
            padding: 100px 10px 0 10px;
        }

        .container-final {
            max-width: 1000px;
            margin: auto;
            padding: 30px 0 100px 0;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            text-align: center;
        }

        .container-final .info .estadistica .acierto .correctas {
            color:rgb(88, 235, 95);
        }

        .container-final .info .estadistica .acierto .incorrectas {
            color:rgb(144, 21, 17);
        }

        .correctas {
            color: rgb(88, 235, 95);
            font-weight: bold;
        }

        .incorrectas {
            color: rgb(144, 21, 17);
            font-weight: bold;
        }

        .btn {
            cursor: pointer;
            border-radius: 15px;
            background-color: #fff;
            font-size: 16px;
            padding: 20px 40px;
        }

        /* The Modal (background) */

        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.6);
            /* Black w/ opacity */
            z-index: 99;
        }

        /* Modal Content */

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 500px;
            height: auto;
            position: relative;
        }

        .modal-content label {
            display: block;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .modal-content input {
            width: 100%;
            padding: 10px;
            border: 1px solid #c0c0c0;
        }

        .modal-content .btn {
            background: #2d40bf;
            font-size: 16px;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 15px;
            margin: 20px 0;
            transition: .5s;
            cursor: pointer;
        }

        /* The Close Button */

        .close {
            position: absolute;
            right: -50px;
            color: #fff;
            font-size: 28px;
            font-weight: bold;
            border: 2px solid #fff;
            height: 45px;
            width: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close:hover,
        .close:focus {
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container-final">
        <div class="info">
            <h2>RESUMEN DE TU PARTIDA</h2>
            <section>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get" autocomplete="off">
                    <div class="fila">
                        <label>Nombre y Apellido:</label>
                        <input type="text" name="nombre" placeholder="Nombre y Apellido" required autofocus style="width: 100%; height: 40px; margin-top: 10px;">
                    </div>
                    <hr>
                    
                    <div class="estadistica">
                        <div class="acierto">
                            <input type="hidden" name="puntos_correctos" value="<?php echo $_SESSION['correctas'] ?>">
                            <span class="correctas numero"><?php echo $_SESSION['correctas'] ?></span>
                            RESPUESTAS CORRECTAS
                        </div>
                        <div class="acierto">
                            <input type="hidden" name="puntos_incorrectos" value="<?php echo $_SESSION['incorrectas'] ?>">
                            <span class="incorrectas numero"> <?php echo $_SESSION['incorrectas'] ?></span>
                            RESPUESTAS INCORRECTAS
                        </div>
                    </div>
                    
                    <div class="score">
                        <div class="box">
                            <div class="chart" data-percent="<?php echo $_SESSION['score'] ?>" style="color: #000;">
                                <?php echo $_SESSION['score'] ?>%
                            </div>
                            <input type="hidden" name="porcentaje" value="<?php echo $_SESSION['score'] ?>">
                            <h2 style="color: #000;">TU PORCENTAJE DE ACIERTOS</h2>
                        </div>
                    </div>

                    <hr>

                    <input type="submit" value="Registra tu puntaje" name="guardar" class="btn" title="Registra tu puntaje" style="width: 100%;">
                    <input type="button" value="Ver Resumen" name="guardar" class="btn" title="Ver Resumen" onclick="abrirModalResumen();" style="width: 100%; margin-top: 10px;">
                </form>
            </section>
        </div>
    </div>

    <!-- Ventana Modal para ver resumen -->
    <div id="modalResumen" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" onclick="cerrarResumen()">&times;</span>
            <br>
            <table style="font-size: 12px; border: 1px solid #000;" border=1>
                <thead align="center">
                    <tr>
                        <th>Pregunta</th>
                        <th>Tu Respuesta</th>
                        <th>Respuesta Correcta</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody align="center">
                    <?php foreach ($resumen as $r): 
                        $respuestaUsuarioTexto = $r['opcion_' . strtolower($r['respuesta_usuario'])];
                        $respuestaCorrectaTexto = $r['opcion_' . strtolower($r['correcta'])];
                        $esCorrecta = ($r['respuesta_usuario'] == $r['correcta']);
                    ?>
                    <tr class="<?php echo $esCorrecta ? 'correcta' : 'incorrecta'; ?>">
                        <td><?php echo htmlspecialchars($r['pregunta']); ?></td>
                        <td><?php echo htmlspecialchars($respuestaUsuarioTexto); ?></td>
                        <td><?php echo htmlspecialchars($respuestaCorrectaTexto); ?></td>
                        <td><?php echo $esCorrecta ? '✔ Correcta' : '✘ Incorrecta'; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="juego.js"></script>
    <script>
        function abrirModalResumen() {
            modalResumen = document.getElementById("modalResumen");
            modalResumen.style.display = "block";
        }

        function cerrarResumen() {
            modalResumen = document.getElementById("modalResumen");
            modalResumen.style.display = "none";
        }
    </script>
</body>
</html>
