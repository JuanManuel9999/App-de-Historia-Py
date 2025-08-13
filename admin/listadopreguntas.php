<?php
session_start();

// Si el usuario no esta logeado lo enviamos al login
if (!$_SESSION['usuarioLogeado']) {
    header("Location: login.php");
}

include "funciones.php";

// Obtengo todos los temas de la bd
$resultado_preguntas = obtenerTodasLasPreguntas();

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

        .pintarVerde {
            font-weight: bold;
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
                <h2>Listado de Preguntas</h2>
                <small style="color: blue;">Obs.: Las respuestas tachadas hacen referencia a las respuestas correctas.</small>
                <hr>
                <section id="listadoPreguntas">
                    <table id="table_preguntas_admin" class="display">
                        <thead align="center">
                            <tr>
                                <th>#</th>
                                <th>Pregunta</th>
                                <th>Respuestas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $cont = 1;
                                while ($row = mysqli_fetch_assoc($resultado_preguntas)) { ?>
                                    <tr>
                                        <td><?php echo $cont++; ?></td>
                                        <td><?php echo $row['pregunta'] ?></td>
                                        <td>
                                            <div>
                                                <div class="caja <?php if($row['correcta'] == 'A'){ echo 'pintarVerde';}?>">A - <?php echo $row['opcion_a']?></div>
                                            </div>
                                            <div>
                                                <span class="caja <?php if($row['correcta'] == 'B'){ echo 'pintarVerde';}?>">B - <?php echo $row['opcion_b']?></span>
                                            </div>
                                            <div>
                                                <span class="caja <?php if($row['correcta'] == 'C'){ echo 'pintarVerde';}?>">C - <?php echo $row['opcion_c']?></span>
                                            </div>
                                        </td>
                                        <td align="center">
                                            <i class="fa-solid fa-pen-to-square" title="Editar pregunta" onclick="editarPregunta(<?php echo $row['id']?>)" style="color: blue; cursor: pointer;"></i>
                                            -
                                            <i class="fa-solid fa-trash" title="Eliminar pregunta" onclick="abrirModalEliminar(<?php echo $row['id']?>)" style="color: red; cursor: pointer;"></i>
                                        </td>
                                    </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>
    
    <!-- Modal para la eliminación de una Pregunta -->
    <div id="modalPregunta" class="modal">
        <!-- Modal content -->
        <div class="modal-content" style="text-align: center;">
            <p>¿Está seguro que desea eliminar la siguiente pregunta?</p>
            <hr>
            <div align="center">
                <button onclick="eliminarPregunta()" class="btn">Si, confirmar</button>
                <button onclick="cerrarEliminar()" class="btn">Cancelar</button>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <script>paginaActiva(2);</script>
    <script src="../public/jquery/js/jquery-3.7.1.min.js"></script>
    <script src="../public/DataTables/datatables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#table_preguntas_admin').DataTable({
                "pageLength": 5,
                "language": {
                    "emptyTable": "No hay datos",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrando _MENU_ Preguntas",
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