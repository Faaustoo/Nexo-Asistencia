-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para asistencias
CREATE DATABASE IF NOT EXISTS `asistencias` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `asistencias`;

-- Volcando estructura para tabla asistencias.alumnos
CREATE TABLE IF NOT EXISTS `alumnos` (
  `id_alumno` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `id_materia` int DEFAULT NULL,
  PRIMARY KEY (`id_alumno`),
  KEY `fk_id_materia` (`id_materia`),
  CONSTRAINT `fk_id_materia` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla asistencias.alumnos: ~22 rows (aproximadamente)
INSERT INTO `alumnos` (`id_alumno`, `nombre`, `apellido`, `dni`, `email`, `fecha_nacimiento`, `id_materia`) VALUES
	(1, 'Valentino', 'Andrade', '35123456', 'valentino.andrade@example.com', '1999-03-12', 1),
	(2, 'Lucas', 'Cedres', '34876543', 'lucas.cedres@example.com', '1998-09-07', 1),
	(3, 'Facundo', 'Figun', '40123789', 'facundo.figun@example.com', '2000-11-25', 1),
	(4, 'Luca', 'Giordano', '32456789', 'luca.giordano@example.com', '1997-06-02', 1),
	(5, 'Bruno', 'Godoy', '36789123', 'bruno.godoy@example.com', '1999-01-18', 1),
	(6, 'Agustin', 'Gomez', '33567890', 'agustin.gomez@example.com', '1996-04-30', 1),
	(7, 'Brian', 'Gonzalez', '35678901', 'brian.gonzalez@example.com', '1997-12-05', 1),
	(8, 'Federico', 'Guigou Scottini', '37890123', 'federico.guigou@example.com', '1998-08-15', 1),
	(9, 'Luna', 'Marrano', '38901234', 'luna.marrano@example.com', '1999-03-10', 1),
	(10, 'Giuliana', 'Mercado Aviles', '33345678', 'giuliana.mercado@example.com', '1995-10-22', 1),
	(11, 'Lucila', 'Mercado Ruiz', '32567890', 'lucila.mercado@example.com', '1996-12-08', 1),
	(12, 'Angel', 'Murillo', '34890123', 'angel.murillo@example.com', '1998-02-27', 1),
	(13, 'Juan', 'Nissero', '36123456', 'juan.nissero@example.com', '1999-07-17', 1),
	(14, 'Fausto', 'Parada', '35234567', 'fausto.parada@example.com', '1996-08-21', 1),
	(15, 'Ignacio', 'Piter', '32789012', 'ignacio.piter@example.com', '1996-05-19', 1),
	(16, 'Tomas', 'Planchon', '40456789', 'tomas.planchon@example.com', '2000-09-03', 1),
	(17, 'Elisa', 'Ronconi', '31678123', 'elisa.ronconi@example.com', '1995-01-24', 1),
	(18, 'Exequiel', 'Sanchez', '33234567', 'exequiel.sanchez@example.com', '1998-04-11', 1),
	(19, 'Melina', 'Schimpf Baldo', '33789456', 'melina.schimpf@example.com', '1996-10-09', 1),
	(20, 'Diego', 'Segovia', '34567890', 'diego.segovia@example.com', '1997-02-13', 1),
	(21, 'Camila', 'Sittner', '36456789', 'camila.sittner@example.com', '1999-08-20', 1),
	(22, 'Yamil', 'Villa', '35345678', 'yamil.villa@example.com', '1998-06-28', 1);

-- Volcando estructura para tabla asistencias.asistencias
CREATE TABLE IF NOT EXISTS `asistencias` (
  `id_asistencia` int NOT NULL AUTO_INCREMENT,
  `id_alumno` int NOT NULL,
  `id_materia` int NOT NULL,
  `fecha` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_asistencia`),
  KEY `asistencias_ibfk_1` (`id_alumno`),
  KEY `asistencias_ibfk_2` (`id_materia`),
  CONSTRAINT `asistencias_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE CASCADE,
  CONSTRAINT `asistencias_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla asistencias.asistencias: ~0 rows (aproximadamente)

-- Volcando estructura para tabla asistencias.instituciones
CREATE TABLE IF NOT EXISTS `instituciones` (
  `id_institucion` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `CUE` varchar(20) NOT NULL,
  `id_profesor` int NOT NULL,
  PRIMARY KEY (`id_institucion`),
  UNIQUE KEY `CUE` (`CUE`),
  KEY `id_profesor` (`id_profesor`),
  CONSTRAINT `instituciones_ibfk_1` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id_profesor`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla asistencias.instituciones: ~1 rows (aproximadamente)
INSERT INTO `instituciones` (`id_institucion`, `nombre`, `direccion`, `CUE`, `id_profesor`) VALUES
	(1, 'Sedes', 'santa fe 74', '123', 1);

-- Volcando estructura para tabla asistencias.materias
CREATE TABLE IF NOT EXISTS `materias` (
  `id_materia` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `id_institucion` int DEFAULT NULL,
  PRIMARY KEY (`id_materia`),
  KEY `fk_institucion` (`id_institucion`),
  CONSTRAINT `fk_institucion` FOREIGN KEY (`id_institucion`) REFERENCES `instituciones` (`id_institucion`) ON DELETE CASCADE,
  CONSTRAINT `materias_ibfk_1` FOREIGN KEY (`id_institucion`) REFERENCES `instituciones` (`id_institucion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla asistencias.materias: ~1 rows (aproximadamente)
INSERT INTO `materias` (`id_materia`, `nombre`, `id_institucion`) VALUES
	(1, 'programacion II', 1);

-- Volcando estructura para tabla asistencias.notas
CREATE TABLE IF NOT EXISTS `notas` (
  `id_nota` int NOT NULL AUTO_INCREMENT,
  `id_alumno` int DEFAULT NULL,
  `id_materia` int DEFAULT NULL,
  `parcial1` decimal(5,2) DEFAULT NULL,
  `parcial2` decimal(5,2) DEFAULT NULL,
  `trabajo_final` decimal(5,2) DEFAULT NULL,
  `condicion` enum('libre','promocion','regular') DEFAULT 'regular',
  PRIMARY KEY (`id_nota`),
  KEY `notas_ibfk_1` (`id_alumno`),
  KEY `notas_ibfk_2` (`id_materia`),
  CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE CASCADE,
  CONSTRAINT `notas_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla asistencias.notas: ~22 rows (aproximadamente)
INSERT INTO `notas` (`id_nota`, `id_alumno`, `id_materia`, `parcial1`, `parcial2`, `trabajo_final`, `condicion`) VALUES
	(1, 1, 1, 0.00, 0.00, 0.00, 'regular'),
	(2, 2, 1, 0.00, 0.00, 0.00, 'regular'),
	(3, 3, 1, 0.00, 0.00, 0.00, 'regular'),
	(4, 4, 1, 0.00, 0.00, 0.00, 'regular'),
	(5, 5, 1, 0.00, 0.00, 0.00, 'regular'),
	(6, 6, 1, 0.00, 0.00, 0.00, 'regular'),
	(7, 7, 1, 0.00, 0.00, 0.00, 'regular'),
	(8, 8, 1, 0.00, 0.00, 0.00, 'regular'),
	(9, 9, 1, 0.00, 0.00, 0.00, 'regular'),
	(10, 10, 1, 0.00, 0.00, 0.00, 'regular'),
	(11, 11, 1, 0.00, 0.00, 0.00, 'regular'),
	(12, 12, 1, 0.00, 0.00, 0.00, 'regular'),
	(13, 13, 1, 0.00, 0.00, 0.00, 'regular'),
	(14, 14, 1, 0.00, 0.00, 0.00, 'regular'),
	(15, 15, 1, 0.00, 0.00, 0.00, 'regular'),
	(16, 16, 1, 0.00, 0.00, 0.00, 'regular'),
	(17, 17, 1, 0.00, 0.00, 0.00, 'regular'),
	(18, 18, 1, 0.00, 0.00, 0.00, 'regular'),
	(19, 19, 1, 0.00, 0.00, 0.00, 'regular'),
	(20, 20, 1, 0.00, 0.00, 0.00, 'regular'),
	(21, 21, 1, 0.00, 0.00, 0.00, 'regular'),
	(22, 22, 1, 0.00, 0.00, 0.00, 'regular');

-- Volcando estructura para tabla asistencias.profesores
CREATE TABLE IF NOT EXISTS `profesores` (
  `id_profesor` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `numero_legajo` varchar(20) NOT NULL,
  PRIMARY KEY (`id_profesor`),
  UNIQUE KEY `dni` (`dni`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `numero_legajo` (`numero_legajo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla asistencias.profesores: ~1 rows (aproximadamente)
INSERT INTO `profesores` (`id_profesor`, `nombre`, `apellido`, `dni`, `email`, `contrasena`, `numero_legajo`) VALUES
	(1, 'Javier', 'Parra', '12345678', 'javier@gmail.com', '$2y$10$KWB2.uRutC12Of9meEKYbeBDfn4XwVLxKxu9avNwFGWwN4UzERFn6', '1');

-- Volcando estructura para tabla asistencias.ram
CREATE TABLE IF NOT EXISTS `ram` (
  `porcentaje_promocion` decimal(5,2) NOT NULL,
  `porcentaje_regular` decimal(5,2) NOT NULL,
  `nota_promocion` float NOT NULL,
  `nota_regular` float NOT NULL,
  `id_institucion` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla asistencias.ram: ~1 rows (aproximadamente)
INSERT INTO `ram` (`porcentaje_promocion`, `porcentaje_regular`, `nota_promocion`, `nota_regular`, `id_institucion`) VALUES
	(70.00, 60.00, 7, 6, 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
