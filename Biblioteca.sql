-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 25, 2018 at 01:52 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "-03:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Biblioteca`
--

-- --------------------------------------------------------

--
-- Table structure for table `Articulos`
--

CREATE TABLE `Articulos` (
  `ID_Articulo` int(11) NOT NULL,
  `Descripcion` varchar(45) COLLATE utf8_bin NOT NULL,
  `Fecha_Alta` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Clientes`
--

CREATE TABLE `Clientes` (
  `ID_Cliente` int(11) NOT NULL,
  `ID_Tipo_Usuario` int(11) NOT NULL,
  `Nombre` varchar(75) COLLATE utf8_bin NOT NULL,
  `Apellido` varchar(75) COLLATE utf8_bin NOT NULL,
  `Direccion` varchar(75) COLLATE utf8_bin NOT NULL,
  `Localidad` varchar(75) COLLATE utf8_bin NOT NULL,
  `Telefono` varchar(75) COLLATE utf8_bin NOT NULL,
  `Fecha_Alta` datetime NOT NULL,
  `Correo` varchar(255) COLLATE utf8_bin NOT NULL,
  `Usuario` varchar(255) COLLATE utf8_bin NOT NULL,
  `Clave` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Clientes`
--

INSERT INTO `Clientes` (`ID_Cliente`, `ID_Tipo_Usuario`, `Nombre`, `Apellido`, `Direccion`, `Localidad`, `Telefono`, `Fecha_Alta`, `Correo`, `Usuario`, `Clave`) VALUES
(1, 1, 'Cristian', 'Leguizamón', 'Av. Directorio 2687', 'Flores', '1123912921', '2018-11-24 15:31:25', 'cristianleguizamon37@gmail.com', 'pudinero', '$2y$10$i.MRhDFCCe/pTtilcNodi.IS/5/gCsrfnxz.KGjXSTRtpQyO89v8K'),
(2, 2, 'Don', 'Magoya', 'Calle Falsa 123', 'Springfield', '12345678', '2018-11-25 09:08:05', 'correofalso@123.com', 'magoya', '$2y$10$E9gx4Vgnf1P9Pd/MkfgMfuWwppocyLumAqn/6eE3jEKoG/L0x6JAe');

-- --------------------------------------------------------

--
-- Table structure for table `Descuentos`
--

CREATE TABLE `Descuentos` (
  `ID_Cliente` int(11) NOT NULL,
  `Cant_Libros` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Facturas`
--

CREATE TABLE `Facturas` (
  `ID_Factura` int(11) NOT NULL,
  `ID_Cliente` int(11) NOT NULL,
  `Fecha` datetime NOT NULL,
  `Importe` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Precios`
--

CREATE TABLE `Precios` (
  `ID_Articulo` int(11) NOT NULL,
  `Precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Stock`
--

CREATE TABLE `Stock` (
  `ID_Articulo` int(11) NOT NULL,
  `Stock_Actual` int(11) NOT NULL,
  `Stock_Minimo` int(11) NOT NULL,
  `Stock_Reponer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Tipo_Usuarios`
--

CREATE TABLE `Tipo_Usuarios` (
  `ID_Tipo_Usuario` int(11) NOT NULL,
  `Descripcion` varchar(75) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Tipo_Usuarios`
--

INSERT INTO `Tipo_Usuarios` (`ID_Tipo_Usuario`, `Descripcion`) VALUES
(1, 'Administrador'),
(2, 'Cliente');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Articulos`
--
ALTER TABLE `Articulos`
  ADD PRIMARY KEY (`ID_Articulo`);

--
-- Indexes for table `Clientes`
--
ALTER TABLE `Clientes`
  ADD PRIMARY KEY (`ID_Cliente`);

--
-- Indexes for table `Descuentos`
--
ALTER TABLE `Descuentos`
  ADD KEY `ID_Cliente` (`ID_Cliente`);

--
-- Indexes for table `Facturas`
--
ALTER TABLE `Facturas`
  ADD PRIMARY KEY (`ID_Factura`),
  ADD KEY `ID_Cliente` (`ID_Cliente`);

--
-- Indexes for table `Precios`
--
ALTER TABLE `Precios`
  ADD KEY `ID_Articulo` (`ID_Articulo`);

--
-- Indexes for table `Stock`
--
ALTER TABLE `Stock`
  ADD KEY `ID_Articulo` (`ID_Articulo`);

--
-- Indexes for table `Tipo_Usuarios`
--
ALTER TABLE `Tipo_Usuarios`
  ADD PRIMARY KEY (`ID_Tipo_Usuario`),
  ADD UNIQUE KEY `ID_Tipo_Usuario` (`ID_Tipo_Usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Articulos`
--
ALTER TABLE `Articulos`
  MODIFY `ID_Articulo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Clientes`
--
ALTER TABLE `Clientes`
  MODIFY `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Facturas`
--
ALTER TABLE `Facturas`
  MODIFY `ID_Factura` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Descuentos`
--
ALTER TABLE `Descuentos`
  ADD CONSTRAINT `Descuentos_ibfk_1` FOREIGN KEY (`ID_Cliente`) REFERENCES `Clientes` (`ID_Cliente`);

--
-- Constraints for table `Facturas`
--
ALTER TABLE `Facturas`
  ADD CONSTRAINT `Facturas_ibfk_1` FOREIGN KEY (`ID_Cliente`) REFERENCES `Clientes` (`ID_Cliente`);

--
-- Constraints for table `Precios`
--
ALTER TABLE `Precios`
  ADD CONSTRAINT `Precios_ibfk_1` FOREIGN KEY (`ID_Articulo`) REFERENCES `Articulos` (`ID_Articulo`);

--
-- Constraints for table `Stock`
--
ALTER TABLE `Stock`
  ADD CONSTRAINT `Stock_ibfk_1` FOREIGN KEY (`ID_Articulo`) REFERENCES `Articulos` (`ID_Articulo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
