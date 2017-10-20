-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 20-Out-2017 às 19:50
-- Versão do servidor: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gainholder`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `id_login` int(11) DEFAULT NULL,
  `nome_completo` varchar(255) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '( 1 - P, 2 - B)',
  `tipo` int(11) DEFAULT '1' COMMENT '( 1 - ADMIN, 2 - Colunista, 3 - Usuário Site)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `administradores`
--

INSERT INTO `administradores` (`id`, `id_login`, `nome_completo`, `foto_perfil`, `status`, `tipo`) VALUES
(1, 1, 'Administrador', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `colunistas`
--

CREATE TABLE `colunistas` (
  `id` int(11) NOT NULL,
  `id_login` int(11) DEFAULT NULL,
  `nome_completo` varchar(255) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `descricao` text,
  `status` int(11) DEFAULT NULL,
  `tipo` int(11) NOT NULL DEFAULT '2' COMMENT '( 1 - ADMIN, 2 - Colunista, 3 - Usuário Site)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `conteudos`
--

CREATE TABLE `conteudos` (
  `id_conteudo` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `texto` text,
  `data_publicacao` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL COMMENT '1 - Conteúdo/2 - Artigo',
  `id_autor` int(11) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`id_login`, `email`, `senha`, `status`) VALUES
(1, 'admin@handgran.com', '4e7d489b49ec93dbf53ce37aee778593', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `login_erros`
--

CREATE TABLE `login_erros` (
  `id` int(11) NOT NULL,
  `dataTentativa` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `modulos`
--

CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL,
  `id_pai` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icone` varchar(255) NOT NULL,
  `status` int(11) DEFAULT NULL COMMENT '( 1 L, 2 B )'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `modulos`
--

INSERT INTO `modulos` (`id_modulo`, `id_pai`, `nome`, `url`, `icone`, `status`) VALUES
(1, 0, 'Gerenciar Acessos', '', 'fa-lock', 1),
(2, 1, 'Administradores', 'administradores', '', 1),
(3, 1, 'Colunistas', 'colunistas', '', 1),
(4, 0, 'Gerenciar Clientes', 'clientes', 'fa-users', 1),
(5, 0, 'Gerenciar Notícias', '', 'fa-newspaper-o', 1),
(6, 5, 'Conteúdos', 'conteudos', '', 1),
(7, 5, 'Artigos', 'artigos', '', 1),
(8, 0, 'Gerenciar Categorias', 'categorias', 'fa-list', 1),
(9, 0, 'Gerenciar Soluções', 'solucoes', 'fa-info', 1),
(10, 0, 'Gerenciar Assinaturas', 'assinaturas', 'fa-pencil', 1),
(11, 0, 'Gerenciar Configurações', 'configuracoes', 'fa-cog', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissoes`
--

CREATE TABLE `permissoes` (
  `id_permissao` int(11) NOT NULL,
  `id_login` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `permissoes`
--

INSERT INTO `permissoes` (`id_permissao`, `id_login`, `id_modulo`, `status`) VALUES
(1, 1, 2, 1),
(2, 1, 4, 1),
(3, 1, 3, 1),
(4, 1, 6, 1),
(5, 1, 7, 1),
(6, 1, 8, 1),
(7, 1, 9, 1),
(8, 1, 10, 1),
(9, 1, 11, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `solucoes`
--

CREATE TABLE `solucoes` (
  `id_solucao` int(11) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `banner_titulo` varchar(255) NOT NULL,
  `banner_descricao` text,
  ` titulo` varchar(255) DEFAULT NULL,
  `texto` text,
  `status` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tags`
--

CREATE TABLE `tags` (
  `id_tag` int(11) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tags_conteudos`
--

CREATE TABLE `tags_conteudos` (
  `id` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL,
  `id_conteudo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `tipo_legislacao` int(11) NOT NULL COMMENT '( 1- PF, 2 - PJ)',
  `nome_completo` varchar(255) NOT NULL,
  `cpf` int(11) NOT NULL,
  `rg` int(13) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `celular` varchar(45) DEFAULT NULL,
  `genero` varchar(45) DEFAULT NULL COMMENT '( M, F)',
  `id_login` int(11) DEFAULT NULL,
  `id_endereco` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL COMMENT '( 1 - ADMIN, 2 - Colunista, 3 - Usuário site )'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_login_idx` (`id_login`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `colunistas`
--
ALTER TABLE `colunistas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `colunista_login_idx` (`id_login`);

--
-- Indexes for table `conteudos`
--
ALTER TABLE `conteudos`
  ADD PRIMARY KEY (`id_conteudo`),
  ADD KEY `conteudos_categorias_idx` (`id_categoria`),
  ADD KEY `conteudos_autores_idx` (`id_autor`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indexes for table `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Indexes for table `permissoes`
--
ALTER TABLE `permissoes`
  ADD PRIMARY KEY (`id_permissao`),
  ADD KEY `permissao_login_idx` (`id_login`),
  ADD KEY `permissao_pagina_idx` (`id_modulo`);

--
-- Indexes for table `solucoes`
--
ALTER TABLE `solucoes`
  ADD PRIMARY KEY (`id_solucao`),
  ADD KEY `solucoes_categorias_idx` (`id_categoria`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id_tag`,`tag`);

--
-- Indexes for table `tags_conteudos`
--
ALTER TABLE `tags_conteudos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tags_tag_idx` (`id_tag`),
  ADD KEY `tags_conteudo_idx` (`id_conteudo`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `usuario_login_idx` (`id_login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `colunistas`
--
ALTER TABLE `colunistas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `conteudos`
--
ALTER TABLE `conteudos`
  MODIFY `id_conteudo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `permissoes`
--
ALTER TABLE `permissoes`
  MODIFY `id_permissao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `solucoes`
--
ALTER TABLE `solucoes`
  MODIFY `id_solucao` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id_tag` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tags_conteudos`
--
ALTER TABLE `tags_conteudos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `administradores`
--
ALTER TABLE `administradores`
  ADD CONSTRAINT `admin_login` FOREIGN KEY (`id_login`) REFERENCES `login` (`id_login`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `colunistas`
--
ALTER TABLE `colunistas`
  ADD CONSTRAINT `colunista_login` FOREIGN KEY (`id_login`) REFERENCES `login` (`id_login`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `conteudos`
--
ALTER TABLE `conteudos`
  ADD CONSTRAINT `conteudos_autores` FOREIGN KEY (`id_autor`) REFERENCES `colunistas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `conteudos_categorias` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `permissoes`
--
ALTER TABLE `permissoes`
  ADD CONSTRAINT `permissao_login` FOREIGN KEY (`id_login`) REFERENCES `login` (`id_login`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `permissao_modulo` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`);

--
-- Limitadores para a tabela `solucoes`
--
ALTER TABLE `solucoes`
  ADD CONSTRAINT `solucoes_categorias` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tags_conteudos`
--
ALTER TABLE `tags_conteudos`
  ADD CONSTRAINT `tags_conteudo` FOREIGN KEY (`id_conteudo`) REFERENCES `conteudos` (`id_conteudo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tags_tag` FOREIGN KEY (`id_tag`) REFERENCES `tags` (`id_tag`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuario_login` FOREIGN KEY (`id_login`) REFERENCES `login` (`id_login`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
