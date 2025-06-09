-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14-Set-2024 às 03:12
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `Sistema_conjunto`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_contatos`
--

CREATE TABLE `tb_contatos` (
  `id_contatos` int(11) NOT NULL,
  `nome_contatos` varchar(150) NOT NULL,
  `fone_contatos` varchar(15) NOT NULL,
  `email_contatos` varchar(200) NOT NULL,
  `foto_contatos` varchar(254) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_contatos`
--

INSERT INTO `tb_contatos` (`id_contatos`, `nome_contatos`, `fone_contatos`, `email_contatos`, `foto_contatos`) VALUES
(4, 'Lucas Costa', '(85) 90000 9999', 'lucas@gmail.com', 'fototeste.jpg'),
(9, 'ZeKa', '(88) 98744 2020', 'zeKa@gmail.com', 'fototeste.jpg'),
(10, 'Júlio aaaaaaaaaaaa', '77777777777', '77julio@yahoo.com.br', '66d8ee6db16ae.jpg'),
(12, 'Carlos pinto', '(85) 98855 4477', 'carlos@bol.com.br', '66d8eecd1a3ba.jpg'),
(13, 'Amanda pppp', '(85) 98855 4488', 'amanda@gmail.com', '66d8f04ce2a83.jpg'),
(15, 'Beatriz 66666', '(85) 98855 4411', 'bia@gmail.com', '66d8f18db2c62.jpg'),
(17, 'Maria Isabel  444', '(85) 999999922', 'maria@gmail.com', '66d8fac2deb04.jpg'),
(48, 'ronaldo', '11111111111', 'abcd@gmail.com', '66e4ae1706599.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `foto_user` varchar(150) NOT NULL,
  `nome_user` varchar(80) NOT NULL,
  `email_user` varchar(100) NOT NULL,
  `senha_user` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `foto_user`, `nome_user`, `email_user`, `senha_user`) VALUES
(1, '602eb69e4a59b.jpg', 'Leandro Costa LTI', 'leandro@gmail.com', 'TVRJek5EVTI='),
(2, '606dc5b620ab8.jpg', 'João Lucas', 'lucas@gmail.com', 'MTIz'),
(3, '602eb77327cd7.jpg', 'Brena', 'brena@gmail.com', 'MTIzNDU2Nzg='),
(4, '604767a0679d5.jpg', 'Maria', 'maria@gmail.com', 'MTIzNDU2'),
(5, '6086c09256741.jpg', 'Lucas Costa', 'lucas@gmail.com', 'cXdlMTIz'),
(8, '66df75f0a30d5.jpg', 'ZeKa tuca', 'asdf@asdfasdf', 'MTIzNA=='),
(9, '66df76317c9b6.jpg', 'Maria Isabel  ', 'asdf@asdfasdf', 'MTIzNA=='),
(11, '66df8b1e3c475.jpg', 'Leocelular', 'asdf@asdfasdf', 'MTIzNA=='),
(12, '66e242c094d8c.jpg', 'LUCAS 2552999', 'lucas@gmail.com', 'MTIzNA=='),
(13, '66e2415d7ad1e.jpg', 'ABCD', 'asdf@asdfasdf', 'MTIzNA==');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_contatos`
--
ALTER TABLE `tb_contatos`
  ADD PRIMARY KEY (`id_contatos`);

--
-- Índices para tabela `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_contatos`
--
ALTER TABLE `tb_contatos`
  MODIFY `id_contatos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de tabela `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
