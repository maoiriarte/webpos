-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-04-2021 a las 21:39:45
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ipos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_category`
--

INSERT INTO `tbl_category` (`cat_id`, `cat_name`) VALUES
(18, 'Ampollas'),
(9, 'Antibioticos'),
(17, 'Anticonceptivos'),
(11, 'Bebés'),
(20, 'Cosméticos'),
(12, 'Cremas'),
(19, 'Gotas'),
(13, 'Jarabes'),
(15, 'Medicamentos Genéricos'),
(21, 'Mujer'),
(10, 'Preservativos'),
(16, 'Sueros'),
(14, 'Suplementos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_invoice`
--

CREATE TABLE `tbl_invoice` (
  `invoice_id` int(11) NOT NULL,
  `cashier_name` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `time_order` varchar(50) NOT NULL,
  `total` float NOT NULL,
  `paid` float NOT NULL,
  `due` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_invoice_detail`
--

CREATE TABLE `tbl_invoice_detail` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` char(6) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL,
  `total` float NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_id` int(11) NOT NULL,
  `product_code` char(6) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_category` varchar(200) NOT NULL,
  `purchase_price` float(10,0) NOT NULL,
  `sell_price` float(10,0) NOT NULL,
  `stock` int(11) NOT NULL,
  `min_stock` int(11) NOT NULL,
  `product_satuan` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `img` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_product`
--

INSERT INTO `tbl_product` (`product_id`, `product_code`, `product_name`, `product_category`, `purchase_price`, `sell_price`, `stock`, `min_stock`, `product_satuan`, `description`, `img`) VALUES
(30, '0007', 'CEP COLGATE ADULTO TIRA', 'Cosméticos', 1400, 2000, 7, 3, '', 'CEPILLOS DE ADULTOS', '6085aa7da62a5.jpg'),
(31, '0008', 'CEPILLO DE  NIÑO BUBA', 'Cosméticos', 750, 1500, 9, 3, '', 'CEPILLOS DE NIÑOS', '6085abb1b4183.jpg'),
(32, '0009', 'COLIK FORTE', 'Mujer', 880, 1400, 15, 4, '', 'PARA COLICOS', '6085ac20562e2.png'),
(33, '00010', 'AMPICILINA 500 MG LA SANTÉ', 'Antibioticos', 260, 600, 99, 10, '', 'INFECCION EN LA MENINGITTIS ', '6085ace6d7c40.jpg'),
(34, '00011', 'BICARBONATO SODIO SOBRES', 'Medicamentos Genéricos', 240, 500, 25, 2, '', 'PARA LA ACIDEZ ESTOMACAL', '6085adcfe9566.jpg'),
(35, '00012', 'DOLEX TAB NIÑO EDAD 2+ ', 'Bebés', 630, 1200, 19, 4, '', 'DOLOR DE NIÑOS', '6085ae6886780.jpg'),
(36, '00013', 'DOLEX GRIPA ', 'Medicamentos Genéricos', 750, 1200, 9, 5, '', 'PARA LA GRIPA ', '6085aeda80ee3.png'),
(37, '00014', 'DOLEX NORMAL 500 MG', 'Medicamentos Genéricos', 470, 700, 15, 10, '', 'PARA LOS DOLORES ', '6085af680fa65.png'),
(38, '00015', 'DOLEX NIÑO JARABE EDAD 7+', 'Bebés', 15900, 17600, 2, 1, '', 'DOLOR DE NIÑOS', '6085b01c089ae.png'),
(39, '00016', 'AZITROMICINA 500 MG AG', 'Antibioticos', 4400, 6500, 3, 2, '', 'INFECCIONES RESPIRATORIAS', '6085b131a023c.jpg'),
(40, '00017', 'ALBENDAZOL 2O0 MG COASPHARMA', 'Medicamentos Genéricos', 4400, 6500, 7, 2, '', 'PARA PARASITOS', '6085b25830806.png'),
(41, '00018', 'CONGESTEX', 'Medicamentos Genéricos', 520, 1200, 19, 5, '', 'PARA LA GRIPA DESCONGESTIONAR', '6085b31f38023.jpg'),
(42, '00019', 'BONFIEST LUA PLUS', 'Medicamentos Genéricos', 2100, 2900, 1, 1, '', 'PARA LA MALUQUERA ', '6085b4aa6aebb.jpg'),
(43, '00020', 'DESLORATADINA 5 MG LAPROFF', 'Medicamentos Genéricos', 440, 700, 36, 10, '', 'Para aliviar los síntomas de fiebre del heno y alergia, incluyendo estornudos; secreción nasal; así como ojos rojos, picazón, lagrimeo en los ojos.', '6085b538a61bf.jpg'),
(44, '00022', 'BETAMETASONA 4 MG AMPOLLA', 'Ampollas', 1200, 2400, 10, 2, '', 'para la inflamación, disminuye la permeabilidad capilar, el edema y la acumulación de mastocitos en sitios de inflamación', '6085b9430ff08.jpg'),
(45, '00023', 'ACIDO SALICILICO ', 'Medicamentos Genéricos', 240, 800, 25, 3, '', 'En la piel se usa para eliminar y prevenir la aparición de espinillas, las manchas en la piel y se usa para tratar enfermedades como la psoriasis', '6085bb56c9035.png'),
(46, '00024', 'ALCOHOL 120 ML PEQUEÑO', 'Cosméticos', 1900, 2500, 1, 1, '', 'ALCOHOL 120 ML PEQUEÑO', '6085bbbe805ba.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_satuan`
--

CREATE TABLE `tbl_satuan` (
  `kd_satuan` int(2) NOT NULL,
  `nm_satuan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_satuan`
--

INSERT INTO `tbl_satuan` (`kd_satuan`, `nm_satuan`) VALUES
(20, 'N/A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(15) NOT NULL,
  `is_active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `username`, `fullname`, `password`, `role`, `is_active`) VALUES
(7, 'farmasalud', 'Liz Gutierrez', '1007183903', 'Admin', 1),
(8, 'Empleado', 'Genesis Chama', '1234abcd..', 'Operator', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_name` (`cat_name`),
  ADD UNIQUE KEY `cat_name_2` (`cat_name`);

--
-- Indices de la tabla `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indices de la tabla `tbl_invoice_detail`
--
ALTER TABLE `tbl_invoice_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_code` (`product_code`,`product_name`);

--
-- Indices de la tabla `tbl_satuan`
--
ALTER TABLE `tbl_satuan`
  ADD PRIMARY KEY (`kd_satuan`),
  ADD UNIQUE KEY `nm_satuan` (`nm_satuan`);

--
-- Indices de la tabla `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT de la tabla `tbl_invoice_detail`
--
ALTER TABLE `tbl_invoice_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT de la tabla `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `tbl_satuan`
--
ALTER TABLE `tbl_satuan`
  MODIFY `kd_satuan` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
