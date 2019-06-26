-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 26-Jun-2019 às 17:48
-- Versão do servidor: 5.7.26
-- versão do PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizzaria`
--
CREATE DATABASE IF NOT EXISTS `pizzaria` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `pizzaria`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_pedido`
--

DROP TABLE IF EXISTS `tb_pedido`;
CREATE TABLE IF NOT EXISTS `tb_pedido` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pizza_id` bigint(20) NOT NULL,
  `telefone` varchar(9) NOT NULL,
  `nome` varchar(500) NOT NULL,
  `endereco` varchar(2000) NOT NULL,
  `entregue` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tb_pizza_tb_pedido_fk` (`pizza_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_pedido`
--

INSERT INTO `tb_pedido` (`id`, `pizza_id`, `telefone`, `nome`, `endereco`, `entregue`) VALUES
(1, 6, '992304707', 'Daniel Fiedler', 'Rua Dez Mil 1998, Eldorado', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_pizza`
--

DROP TABLE IF EXISTS `tb_pizza`;
CREATE TABLE IF NOT EXISTS `tb_pizza` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sabor` varchar(255) NOT NULL,
  `tamanho` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_pizza`
--

INSERT INTO `tb_pizza` (`id`, `sabor`, `tamanho`) VALUES
(3, 'calabresa', 'G'),
(4, 'calabresa', 'G'),
(5, 'calabresa', 'G'),
(6, 'calabresa', 'G'),
(7, 'calabresa', 'P');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
