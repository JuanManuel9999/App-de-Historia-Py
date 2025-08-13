<?php
// Datos del servidor
$server = "localhost";
$username = "root";
$password = "";
$bd	= "bd_quiz";

// Creamos una conexión
$conn = mysqli_connect($server, $username, $password, $bd);

// Verificamos la conexión
if(!$conn){
	die("Ocurrió un error al realizar la conexión:" . mysqli_connect_error());
}
