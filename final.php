<?php
session_start();

// Si el usuario no está logeado lo enviamos al index
if (!$_SESSION['usuario']) {
    header("Location:index.php");
    exit();
}

// Aumentamos la estadística
include "admin/funciones.php";
aumentarCompletados();

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PON A PRUEBA TUS CONOCIMIENTOS - Resultado</title>
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
    </style>
</head>
<body>
    <div class="container-final">
        <div class="info">
            <h2>RESULTADO FINAL</h2>
            <section>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get" autocomplete="off">
                    <div class="fila">
                        <label>Nombre y Apellido:</label>
                        <input type="text" name="nombre" placeholder="Nombre y Apellido" required autofocus style="width: 100%;">
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
                            <h2 style="color: #000;">PORCENTAJE DE ACIERTOS</h2>
                        </div>
                    </div>

                    <hr>

                    <input type="submit" value="Registra tu puntaje" name="guardar" class="btn" title="Registra tu puntaje" style="width: 100%;">
                </form>
            </section>
        </div>
    </div>
    <script src="juego.js"></script>
</body>
</html>
