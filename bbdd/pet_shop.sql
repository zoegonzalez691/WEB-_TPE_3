-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-10-2024 a las 23:34:15
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
-- Base de datos: `pet_shop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `especie_animal` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `especie_animal`, `descripcion`) VALUES
(1, 'Felinos', 'Productos aptos para felinos de diferentes edades y razas'),
(2, 'Roedores', 'Productos para roedores como hamsters o cobayos, entre otros'),
(9, 'Caninos', 'Productos para la calidad de vida de caninos'),
(10, 'Peces', 'Producto para animales acuaticos de agua dulce');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen` varchar(250) NOT NULL,
  `fk_categoria` int(11) NOT NULL,
  `precio` float NOT NULL,
  `destacado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `imagen`, `fk_categoria`, `precio`, `destacado`) VALUES
(1, 'Casa-Rascador', 'Casa y rascador apto para gatos. \r\nAltura: 54cm \r\nViene tambien con un colgante para que juegue. \r\nColor a eleccion (Disponible en rosa, rojo, azul, violeta, naranja)', 'https://i.pinimg.com/236x/9f/3e/56/9f3e5682517588df04b6f4d398d3cdb1.jpg', 1, 25690, 1),
(2, 'Casa-Jaula para hamster', 'Jaula de tamaño considerable para que le des a tu hmaster la calidad de vida que mrece. \r\nCuenta con diferentes niveles para que el hasmter pueda divertirse.\r\nDisponibles en 5 diferentes colores.', 'https://i.pinimg.com/236x/86/77/e5/8677e5fa317970fddae3a47dbe37389b.jpg', 2, 17890, 0),
(5, 'Comedero Elevado ', 'Comedero elevado, de 30cm para perros de raza grande.\r\nApto para la prevencion de enfermedades relacionadas a la columna.', 'https://i.pinimg.com/564x/ae/9a/87/ae9a8752535d8a00ec151006133a94b9.jpg', 9, 0, 1),
(6, 'Huesos de colores', 'Huesos para cachorros de tela, apto para los dientes. Disponibles en diferentes colores (azul, verde, rosa, rojo, amarillo)', 'https://i.pinimg.com/474x/37/2d/9d/372d9ddbb3ffd1ebf1df4cfb1f549084.jpg', 9, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(200) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `es_admin` tinytext DEFAULT NULL,
  `contraseña` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `nombre`, `mail`, `es_admin`, `contraseña`) VALUES
(1, 'Webadmin', 'webadmin@gmail.com', 'si', '$2y$10$yELDzZN/41wsn/kn5jpRhOGXt9MGcalVhmUgdr5PsTJGWk54IZbiG');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_categoria` (`fk_categoria`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`fk_categoria`) REFERENCES `categorias` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
