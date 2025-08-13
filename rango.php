
<?php
session_start();

include "./admin/funciones.php";

// Obtengo todos los rangos de jugadores de la bd
$resultado_jugadores = obtenerTodosLosJugadores();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="public/DataTables/datatables.min.css" />
    <link rel="stylesheet" href="estilo.css">
    <link rel="icon" href="icono/lista-de-verificacion.png">
    <title>QUIZ GAME</title>
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

        .container {
            position: relative;
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            margin: auto;
            padding: 30px 0 100px 0;
            /* From https://css.glass */
            background: rgba(255, 255, 255, 0.7);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .container .top {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container .top h3 {
            text-align: center;
        }

        .container .left h3 {
            text-align: center;
            letter-spacing: 2px;
            position: relative;
            animation: aparecer 1.5s forwards;
        }

        .container .container-right {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container" id="cantainer">
        <div class="top">
            <h3>RANGO DE POSICIONES</h3>
        </div>
        
        <div class="container-right">
            <table id="table_range" class="display">
                <thead align="center">
                    <tr>
                        <th>#</th>
                        <th>Jugador</th>
                        <th>Puntaje Obtenido</th>
                        <th>Porcentaje de acierto</th>
                    </tr>
                </thead>
                <tbody align="center">
                    <?php 
                        $cont = 1;
                        while ($row = mysqli_fetch_assoc($resultado_jugadores)) { ?>
                            <tr>
                                <?php if ($row['porcentaje'] >= 80) { ?>
                                    <td style="background-color: gold; font-weight: bold;"><?php echo $cont++; ?></td>
                                    <td style="background-color: gold; font-weight: bold;"><?php echo $row['nombre'] ?></td>
                                    <td style="background-color: gold; font-weight: bold;"><?php echo $row['puntos_correctos'] ?></td>
                                    <td style="background-color: gold; font-weight: bold;"><?php echo $row['porcentaje'] . '%' ?></td>
                                <?php } else if ($row['porcentaje'] >= 50 && $row['porcentaje'] <= 79) { ?>
                                    <td style="background-color: sandybrown; font-weight: bold;"><?php echo $cont++; ?></td>
                                    <td style="background-color: sandybrown; font-weight: bold;"><?php echo $row['nombre'] ?></td>
                                    <td style="background-color: sandybrown; font-weight: bold;"><?php echo $row['puntos_correctos'] ?></td>
                                    <td style="background-color: sandybrown; font-weight: bold;"><?php echo $row['porcentaje'] . '%' ?></td>
                                <?php } else if ($row['porcentaje'] >= 0 && $row['porcentaje'] <= 49) { ?>
                                    <td><?php echo $cont++; ?></td>
                                    <td><?php echo $row['nombre'] ?></td>
                                    <td><?php echo $row['puntos_correctos'] ?></td>
                                    <td><?php echo $row['porcentaje'] . '%' ?></td>
                                <?php } ?>
                            </tr>
                    <?php } ?>
                </tbody>
            </table>

            <hr>
            <button style="width: 25%; border-radius: 15px; background-color: #fff; font-size: 16px; padding: 20px 40px;">
                <a href="index.php" title="Volver a inicio" style="text-decoration: none; color: black;">
                    <i class="fas fa-arrow-left"></i> Volver a inicio
                </a>
            </button>
        </div>
        <footer>
            <a href="index.php">&copy;Copyright 2025 Juan Manuel Saldivar Chaparro & Elias Gastón Gonzáles Villalba</a>
        </footer>
    </div>
    <script src="public/jquery/js/jquery-3.7.1.min.js"></script>
    <script src="public/DataTables/datatables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#table_range').DataTable({
                "pageLength": 5,
                "language": {
                    "emptyTable": "No hay datos",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrando _MENU_ Jugadores",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "responsive": true, "lengthChange": true, "autoWidth": false,
                searching: false,
                info: false
            });
        });
    </script>
</body>
</html>