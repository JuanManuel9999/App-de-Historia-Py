<?php
session_start();

// Si el usuario no esta logeado lo enviamos al login
if (!$_SESSION['usuarioLogeado']) {
    header("Location: login.php");
}

include "funciones.php";

// Se presióno el botón Nuevo Tema
if(isset($_GET['nuevoTema'])){
    // Tomamos los datos que vienen del formulario
    $tema = $_GET['nombreTema'];
    $mensaje = agregarNuevoTema($tema);
    header("Location: nuevapregunta.php");
}

/******************************************************* */
// GUARDAMOS LA PREGUNTA
if (isset($_GET['guardar'])) {
    // Nos conectamos a la base de datos
    include "conexion.php";

    // Tomamos los datos que vienen del fosrmulario
    // Elimina texto con formato de etiqueta html
    $pregunta = htmlspecialchars($_GET['pregunta']);
    $opcion_a = htmlspecialchars($_GET['opcion_a']);
    $opcion_b = htmlspecialchars($_GET['opcion_b']);
    $opcion_c = htmlspecialchars($_GET['opcion_c']);
    $id_tema = $_GET['tema'];
    $correcta = $_GET['correcta'];

    // Armamos el query para insertar en la tabla preguntas
    $query = "INSERT INTO preguntas (id, tema, pregunta, opcion_a, opcion_b, opcion_c, correcta) VALUES (NULL, '$id_tema', '$pregunta', '$opcion_a', '$opcion_b', '$opcion_c', '$correcta')";

    // Insertamos en la tabla preguntas
    if (mysqli_query($conn, $query)) { // Se insertó correctamente
        $mensaje = "La pregunta se insertó correctamente";
        header("Location: index.php");
    } else {
        $mensaje = "No se pudo insertar en la Base de Datos" . mysqli_error($conn);
    }
}

// Obtengo todos los temas de la bd
$resultado_temas = obtenerTodosLosTemas();

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
    <div class="contenedor">
        <header align="center">
            <h1>PON A PRUEBA TUS CONOCIMIENTOS - ADMIN</h1>
        </header>
        <div class="contenedor-info">
            <?php include "nav.php" ?>
            <div class="panel">
                <h2>Ingrese la Pregunta</h2>
                <hr>
                <section id="nuevaPregunta">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get" autocomplete="off">
                        <div class="opcion" style="justify-content: center;">
                            <?php while ($row = mysqli_fetch_assoc($resultado_temas)) : ?>
                                <?php if ($row['id'] == 2) : ?>
                                    <input type="hidden" name="tema" value="<?php echo $row['id'] ?>">
                                    Sobre &nbsp;<p style="font-weight: bold;"><?php echo $row['nombre'] ?></p>
                                <?php endif ?>
                            <?php endwhile ?>
                        </div>
                        <div class="fila">
                            <label for="">Pregunta:</label>
                            <textarea name="pregunta" id="" cols="30" rows="10" required autofocus style="resize: none;"></textarea>
                        </div>
                        <div class="opciones">
                            <div class="opcion">
                                <label for="">Opcion A</label>
                                <input type="text" name="opcion_a" id="" required>
                            </div>
                            <div class="opcion">
                                <label for="">Opcion B</label>
                                <input type="text" name="opcion_b" required>
                            </div>
                            <div class="opcion">
                                <label for="">Opcion C</label>
                                <input type="text" name="opcion_c" required>
                            </div>
                        </div>
                        <div class="opcion">
                            <label for="">Correcta</label>
                            <select name="correcta" id="" class="correcta">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                        </div>
                        <hr>
                        <input type="submit" value="Guardar Pregunta" name="guardar" class="btn-guardar">
                    </form>

                    <?php if (isset($_GET['guardar'])) : ?>
                        <span> <?php echo $mensaje ?></span>
                    <?php endif ?>
                </section>
            </div>
        </div>
    </div>

    <!-- Ventana Modal para nuevo Tema -->
    <div id="modalTema" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" onclick="cerrarTema()">&times;</span>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
                <label for="">Agregar Nuevo Tema</label>
                <input type="text"   name="nombreTema" required>
                <input type="submit" name="nuevoTema" value="Guardar Tema" class="btn">
            </form>
        </div>
    </div>

    <script src="script.js"></script>
    <script>paginaActiva(1);</script>
</body>
</html>