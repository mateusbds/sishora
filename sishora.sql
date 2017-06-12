-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 24-Maio-2017 às 16:29
-- Versão do servidor: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sishorav3`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `activities`
--

CREATE TABLE `activities` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ESSE CAMPO SERVE APENAS PARA CRIAR O RELACIONAMENTO ENTRE atividades_aluno E aluno',
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `activitycomphours`
--

CREATE TABLE `activitycomphours` (
  `id` int(11) NOT NULL,
  `hours` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `actuations`
--

CREATE TABLE `actuations` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `actuations`
--

INSERT INTO `actuations` (`id`, `name`) VALUES
(2, 'Pesquisa'),
(5, 'Ensino'),
(6, 'Extensão');

-- --------------------------------------------------------

--
-- Estrutura da tabela `courses`
--

CREATE TABLE `courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` bigint(255) DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `qntHours` int(11) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `course_id` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `grades_activities`
--

CREATE TABLE `grades_activities` (
  `id` int(11) NOT NULL,
  `activity_id` int(10) UNSIGNED NOT NULL,
  `grade_id` int(11) NOT NULL,
  `amount` float UNSIGNED NOT NULL,
  `unit` varchar(40) NOT NULL,
  `compHours` int(11) NOT NULL,
  `limite` float UNSIGNED NOT NULL,
  `actuation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `grades_actuations`
--

CREATE TABLE `grades_actuations` (
  `actuation_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `percentPerHour` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `profiles`
--

CREATE TABLE `profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `profiles`
--

INSERT INTO `profiles` (`id`, `name`) VALUES
(1, 'Administrador'),
(3, 'Aluno'),
(2, 'Coordenador');

-- --------------------------------------------------------

--
-- Estrutura da tabela `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `ano` int(11) NOT NULL,
  `semestre` int(11) NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `grade_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `profile_id` int(10) UNSIGNED NOT NULL,
  `activitycomphour_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `email`, `grade_id`, `team_id`, `profile_id`, `activitycomphour_id`) VALUES
(1, 'admin', '$2y$10$7UDgtAPVHuIbGfi8notCpOiiJvXwgCZcl92dDPsH4Qpqw02RmgYau', 'admin', 'admin@admin.com', NULL, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_grades_activities`
--

CREATE TABLE `users_grades_activities` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `grades_activity_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `carga_horaria` int(10) UNSIGNED NOT NULL,
  `carga_aproveitada` float NOT NULL,
  `instituicao` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `validated` smallint(1) DEFAULT '2',
  `obs` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activitycomphours`
--
ALTER TABLE `activitycomphours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `actuations`
--
ALTER TABLE `actuations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades_activities`
--
ALTER TABLE `grades_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades_actuations`
--
ALTER TABLE `grades_actuations`
  ADD PRIMARY KEY (`actuation_id`,`grade_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `perfil_UNIQUE` (`name`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_grades_activities`
--
ALTER TABLE `users_grades_activities`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ESSE CAMPO SERVE APENAS PARA CRIAR O RELACIONAMENTO ENTRE atividades_aluno E aluno', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `activitycomphours`
--
ALTER TABLE `activitycomphours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `actuations`
--
ALTER TABLE `actuations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `grades_activities`
--
ALTER TABLE `grades_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `users_grades_activities`
--
ALTER TABLE `users_grades_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
