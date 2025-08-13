
<?php
session_start();
// session_destroy();

include "admin/funciones.php";

aumentarVisita();

$categorias =  obtenerCategorias();

if (isset($_GET['idCategoria'])) {
    session_start();

    $_SESSION['usuario'] = "usuario";
    $_SESSION['idCategoria'] = $_GET['idCategoria'];
    header("Location: jugar.php");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
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
            <img src="icono/lista-de-verificacion.png" alt="juego de preguntas" style="width: 70px; height: 70px;">
            <h1>¡¡BIENVENIDO/A!!</h1>
            <p>¿Quieres poner a prueba tus conocimientos?</p>
            <h3>PON A PRUEBA TUS CONOCIMIENTOS <br> SOBRE LA HISTORIA DEL PARAGUAY </h3>
        </div>
        <br>
        
        <div class="container-right">
            <?php while ($cat = mysqli_fetch_assoc($categorias)):?>
                <div class="categoria">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" id="<?php echo $cat['tema']?>">
                        <input type="hidden" name="idCategoria" value="<?php echo $cat['tema']?>">
                        <button class="btn-go" style="width: 100%; border-radius: 15px; background-color: #fff; font-size: 16px; padding: 20px 40px;">
                            <a href="javascript:{}" title="Iniciar Juego" onclick="document.getElementById(<?php echo $cat['tema']?>).submit(); return false;" style="text-decoration: none; color: black;">
                                <?php echo obtenerNombreTema($cat['tema'])?> - 
                                Iniciar Juego <i class="fa fa-arrow-right"></i>
                            </a>
                        </button>
                        <br>
                        <button style="width: 100%; border-radius: 15px; background-color: #fff; font-size: 16px; padding: 20px 40px; margin-top: 10px;">
                            <a href="rango.php" title="Ver rango de jugadores" style="text-decoration: none; color: black;">
                                Ver rango de jugadores <i class="fas fa-clipboard"></i>
                            </a>
                        </button>
                    </form>
                </div>
            <?php endwhile?>
        </div>
        <footer>
            <a href="index.php">&copy;Copyright 2025 Juan Manuel Saldivar Chaparro & Elias Gastón Gonzáles Villalba</a>
        </footer>
    </div>
</body>
</html>