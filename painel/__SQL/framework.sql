-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 13-Dez-2016 às 13:08
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `framework`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuarioId` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `permissoes` varchar(255) NOT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_login_idx` (`usuarioId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`id`, `usuarioId`, `email`, `senha`, `permissoes`, `status`) VALUES
(1, 1, 'tiagoelhouri@palupa.com', '21232f297a57a5a743894a0e4a801fc3', 'a:2:{i:0;s:1:"1";i:1;s:1:"2";}', 1),
(2, 2, 'admin@palupa.com.br', '4e7d489b49ec93dbf53ce37aee778593', 'a:2:{i:0;s:1:"1";i:1;s:1:"2";}', 1),
(3, 3, 'jose@palupa.com.br', '202cb962ac59075b964b07152d234b70', 'a:2:{i:0;s:1:"1";i:1;s:1:"2";}', 1),
(4, 4, 'teste@email.com.br', '202cb962ac59075b964b07152d234b70', '', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `login_erros`
--

CREATE TABLE IF NOT EXISTS `login_erros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dataTentativa` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `modulos`
--

CREATE TABLE IF NOT EXISTS `modulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `modulos`
--

INSERT INTO `modulos` (`id`, `nome`, `url`, `status`) VALUES
(1, 'Gerenciar Administradores', 'administradores', 1),
(2, 'Gerenciar Usuários', 'usuarios', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `nivel`
--

CREATE TABLE IF NOT EXISTS `nivel` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `nivel`
--

INSERT INTO `nivel` (`id`, `nome`) VALUES
(1, 'Administrador'),
(2, 'Comum'),
(3, 'Eventos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nivelId` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `fotoPerfil` varchar(255) NOT NULL,
  `sexo` varchar(45) NOT NULL,
  `dataNascimento` date NOT NULL,
  `telefone` varchar(100) DEFAULT NULL,
  `celular` varchar(100) DEFAULT NULL,
  `cpf` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nivel_usuario_idx` (`nivelId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nivelId`, `nome`, `fotoPerfil`, `sexo`, `dataNascimento`, `telefone`, `celular`, `cpf`) VALUES
(1, 1, 'Tiago El Houri', '', 'masculino', '1993-09-14', '(41)3669-8369', '(41)9770-1394', '098.128.099-45'),
(2, 1, 'Administrador Palupa', '', 'masculino', '2015-05-01', '(41) 9842-0361', '', '695.913.650-47'),
(3, 1, 'Jose Gusthavo', 'c2F1ZGUuanBnMTEwMQ==.jpg', 'masculino', '1994-02-17', '(41) 9658-4125', '(41) 9856-3443', '084.369.258-78'),
(4, 2, 'TESTE', 'Ym9sZXRlSWNvbmUuanBnMTU3OQ==.jpg', ' ', '2011-11-11', ' ', ' ', ' ');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `usuario_login` FOREIGN KEY (`usuarioId`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `nivel_usuario` FOREIGN KEY (`nivelId`) REFERENCES `nivel` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
