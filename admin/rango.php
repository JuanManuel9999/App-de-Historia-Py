<?php
session_start();

// Si el usuario no esta logeado lo enviamos al login
if (!$_SESSION['usuarioLogeado']) {
    header("Location: login.php");
}

include "funciones.php";

// Obtengo todos los rangos de jugadores de la bd
$resultado_jugadores = obtenerTodosLosJugadores();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../public/DataTables/datatables.min.css" />
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
                <h2>Rango de Jugadores</h2>
                <hr>
                <section id="listadoPreguntas">
                    <table id="table_range_admin" class="display">
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
                </section>
            </div>
        </div>
    </div>
    
    <script src="script.js"></script>
    <script>paginaActiva(3);</script>
    <script src="../public/jquery/js/jquery-3.7.1.min.js"></script>
    <script src="../public/DataTables/datatables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#table_range_admin').DataTable({
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