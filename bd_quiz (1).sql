-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-08-2025 a las 01:15:04
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_quiz`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(10) NOT NULL,
  `totalPreguntas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `config`
--

INSERT INTO `config` (`id`, `usuario`, `password`, `totalPreguntas`) VALUES
(1, 'admin', 'admin', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadisticas`
--

CREATE TABLE `estadisticas` (
  `id` int(11) NOT NULL,
  `visitas` int(11) NOT NULL,
  `respondidas` int(11) NOT NULL,
  `completados` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estadisticas`
--

INSERT INTO `estadisticas` (`id`, `visitas`, `respondidas`, `completados`) VALUES
(1, 11, 10, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE `jugadores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `puntos_correctos` int(11) NOT NULL,
  `puntos_incorrectos` int(11) NOT NULL,
  `porcentaje` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`id`, `nombre`, `puntos_correctos`, `puntos_incorrectos`, `porcentaje`) VALUES
(3, 'Manu', 4, 6, 40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` int(11) NOT NULL,
  `tema` int(11) NOT NULL,
  `pregunta` text NOT NULL,
  `opcion_a` text NOT NULL,
  `opcion_b` text NOT NULL,
  `opcion_c` text NOT NULL,
  `correcta` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `tema`, `pregunta`, `opcion_a`, `opcion_b`, `opcion_c`, `correcta`) VALUES
(1, 2, '¿Porqué los primeros habitantes de la tierra eran denominados nómadas?', 'Porque estos habitantes se ubicaban en un solo lugar donde cazaban y se dedicaban a cultivar la tierra', 'Porque los primeros habitantes eran denominados nómadas', 'Porque ellos estaban acostumbrados a ir de un lugar a otro en busca de alimentos', 'C'),
(2, 2, '¿Qué genera la formación de subgrupos independientes?', 'La Unión de dos personas para formar una familia', 'Las formaciones tribales', 'La idea  del hombre de ser independiente, salir de su hogar y formar una familia ', 'B'),
(3, 2, '¿Qué significa tribales?', 'Unión de dos personas con costumbres, tradiciones, origen  étnico o intereses comunes', 'Agrupación de personas con costumbres, tradiciones, origen étnico o intereses diferentes', 'Unión de personas de diferentes nacionalidades, costumbres, etc', 'A'),
(4, 2, '¿Las primeras formas de sociedad son?', 'Sociedad de cazadores', 'Sociedad de recolectores', 'Sociedad de cazadores y recolectores', 'C'),
(5, 2, '¿Fecha de la independencia del Paraguay?', '14 y 15 de Mayo de 1811', '14 y 15 de Mayo de 1813', '14 y 15 de Mayo de 1812', 'A'),
(6, 2, '¿Integrantes del Triunvirato?', 'Fulgencio Yegros, Dr. Francia, Bernardo de  Velazco', 'Fulgencio Yegros, Juan Valeriano Zeballos, Bernardo de Velazco', 'Dr. Francia, Juan Valeriano Zeballos, Bernardo de Velazco', 'C'),
(7, 2, '¿Integrantes de la Junta Superior Gubernativa?', 'Fulgencio Yegros, Dr. Francia, Bernardo de  Velazco, Pedro Juan Caballero y Fernando de la Mora', 'Fulgencio Yegros, Dr. Francia, Bernardo de  Velazco, Pedro Juan Caballero y Xavier Bogarin', 'Fulgencio Yegros, Dr. Francia, Fernando de la Mora, Pedro Juan Caballero y Xavier Bogarin', 'C'),
(8, 2, '¿Integrantes del Consulado?', 'Fulgencio Yegros, Dr. Francia', 'Fulgencio Yegros, Bernardo de Velazco', 'Bernardo de Velazco, Juan Valeriano Zeballos', 'A'),
(9, 2, '¿Corrientes totalitarias en Europa?', 'Fascismo Nacional, Socialismo  Alemán, Comunismo, Franquismo', 'Fascismo Nacional, Socialismo  Alemán, Comunismo, Dictadura', 'Democracia Nacional, Socialismo Alemán, Comunismo', 'A'),
(10, 2, '¿Pensadores o Luchadores Latinoamericanos?', 'Simón Bolivar, José de San Martin, Francisco de Miranda', 'Dr. Francia, José de San Martin, Francisco de Miranda', 'Simón Bolivar, José de San Martin, Fulgencio Yegros', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas`
--

CREATE TABLE `temas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `temas`
--

INSERT INTO `temas` (`id`, `nombre`) VALUES
(1, 'Programación'),
(2, 'Historia del Paraguay'),
(3, 'Biología'),
(4, 'Deportes'),
(5, 'Física'),
(6, 'Comidas típicas');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estadisticas`
--
ALTER TABLE `estadisticas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `temas`
--
ALTER TABLE `temas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estadisticas`
--
ALTER TABLE `estadisticas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `temas`
--
ALTER TABLE `temas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
