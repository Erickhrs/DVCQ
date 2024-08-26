-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2024 at 11:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dvcdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `adms`
--

CREATE TABLE `adms` (
  `ID` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `UF` char(2) DEFAULT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `since` date DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `psw` char(64) DEFAULT NULL,
  `roles_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `adms`
--

INSERT INTO `adms` (`ID`, `name`, `email`, `UF`, `picture`, `since`, `status`, `psw`, `roles_id`) VALUES
(1, 'Erick Rosa', 'tierickrosa@gmail.com', 'MG', './uploads/668ff1bc5eec2.PNG', '2024-06-11', 1, '$2y$10$MdRJH2R8BXDzrHVnzhtFyegFP5pqFcMc1NIIgGwQeuXnGCHNjiSSW', 1),
(4, 'Marcos', 'adm@gmail.com', 'RR', './uploads/667c7709911a3.png', '2024-06-12', 0, '$2y$10$MdRJH2R8BXDzrHVnzhtFyegFP5pqFcMc1NIIgGwQeuXnGCHNjiSSW', 0);

-- --------------------------------------------------------

--
-- Table structure for table `adms_history`
--

CREATE TABLE `adms_history` (
  `ID` int(11) NOT NULL,
  `adms_ID` int(11) NOT NULL,
  `description` varchar(600) NOT NULL,
  `occurred_at` datetime DEFAULT NULL,
  `importance` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `adms_history`
--

INSERT INTO `adms_history` (`ID`, `adms_ID`, `description`, `occurred_at`, `importance`) VALUES
(1, 1, 'Adicionou uma nova disciplina (DISCIPLINA1)', '2024-08-05 11:18:04', 'BAIXA'),
(4, 1, 'Usuário Erick teste2 inserido', '2024-07-10 19:45:22', 'ALTA'),
(5, 1, 'Usuário Erick teste2 - tierickrosa2@gmail.com deletado.', '2024-07-10 20:53:45', 'ALTA'),
(6, 1, 'Usuário 445826396336 cadastrado', '2024-07-11 02:28:31', 'MÉDIA'),
(7, 1, 'Usuário 445826396336 - 69363969696969@gmail.com deletado.', '2024-07-11 02:28:38', 'ALTA'),
(10, 1, 'Usuário Informações Pessoais cadastrado', '2024-07-11 11:31:48', 'MÉDIA'),
(11, 1, 'Atualizou as informações do seu própio perfil.', '2024-07-11 11:52:44', 'BAIXA'),
(12, 1, 'Usuário Informações Pessoais - sd@gmail.com deletado.', '2024-07-11 14:14:12', 'ALTA'),
(13, 1, 'ADICIONOU UMA NOVA DISCIPLINA(teste)', '2024-07-30 11:53:10', 'MÉDIA'),
(14, 1, 'Adicionou uma nova disciplina (DISCIPLINA4)', '2024-07-30 11:57:13', 'MÉDIA'),
(15, 1, 'Deletou uma disciplina (21)', '2024-07-30 11:59:24', 'MÉDIA'),
(16, 1, 'Deletou uma disciplina (#22DISCIPLINA4)', '2024-07-30 12:00:47', 'ALTA'),
(17, 1, 'Deletou uma disciplina (#19 - DISCIPLINA3)', '2024-07-30 12:01:26', 'ALTA'),
(18, 1, 'Adicionou uma nova disciplina (DISCIPLINA3)', '2024-08-01 11:02:59', 'BAIXA'),
(19, 1, 'Deletou uma disciplina (#23 - DISCIPLINA3)', '2024-08-01 11:03:47', 'ALTA'),
(20, 1, 'Adicionou uma nova disciplina (ASSUNTO2)', '2024-08-01 11:08:38', 'BAIXA'),
(21, 1, 'Adicionou uma nova disciplina (DISCIPLINA3)', '2024-08-01 11:14:06', 'BAIXA'),
(22, 1, 'Adicionou uma novo Assunto (~~~~)', '2024-08-01 11:14:33', 'BAIXA'),
(23, 1, 'Deletou um assunto (#2 - ~~~~)', '2024-08-01 11:14:47', 'ALTA'),
(24, 1, 'Adicionou uma nova banca (banca1)', '2024-08-01 11:25:54', 'BAIXA'),
(25, 1, 'Deletou uma banca (#1 - 0)', '2024-08-01 11:28:00', 'ALTA'),
(26, 1, 'Adicionou uma nova banca (banca2)', '2024-08-01 11:28:11', 'BAIXA'),
(27, 1, 'Deletou uma banca (#2 - 0)', '2024-08-01 11:32:29', 'ALTA'),
(28, 1, 'Adicionou uma nova banca (banca2)', '2024-08-01 11:32:51', 'BAIXA'),
(29, 1, 'Deletou uma banca (#3 - 0)', '2024-08-01 11:34:03', 'ALTA'),
(30, 1, 'Adicionou uma nova banca (edfcdf)', '2024-08-01 11:34:07', 'BAIXA'),
(31, 1, 'Deletou uma banca (#4 - 0)', '2024-08-01 11:37:35', 'ALTA'),
(32, 1, 'Adicionou uma nova banca (banca2)', '2024-08-01 11:38:02', 'BAIXA'),
(33, 1, 'Deletou uma banca (#5 - 0)', '2024-08-01 11:39:51', 'ALTA'),
(34, 1, 'Adicionou uma nova banca (banca2)', '2024-08-01 11:39:54', 'BAIXA'),
(35, 1, 'Adicionou uma nova banca (banca1)', '2024-08-01 11:40:00', 'BAIXA'),
(36, 1, 'Adicionou um novo cargo (cargo1)', '2024-08-01 11:48:40', 'BAIXA'),
(37, 1, 'Adicionou um novo cargo (cargo2)', '2024-08-01 11:48:48', 'BAIXA'),
(38, 1, 'Deletou um cargo (#2 - cargo2)', '2024-08-01 11:48:57', 'ALTA'),
(39, 1, 'Adicionou um novo cargo (cargo2)', '2024-08-01 11:50:43', 'BAIXA'),
(40, 1, 'Deletou um cargo (#3 - cargo2)', '2024-08-01 11:50:51', 'ALTA'),
(41, 1, 'Deletou um cargo (#1 - cargo1)', '2024-08-01 11:51:20', 'ALTA'),
(42, 1, 'Deletou um cargo (#1 - sla)', '2024-08-01 11:51:34', 'ALTA'),
(43, 1, 'Adicionou um novo cargo (cargo1)', '2024-08-01 11:51:40', 'BAIXA'),
(44, 1, 'Deletou um cargo (#4 - cargo1)', '2024-08-01 11:52:01', 'ALTA'),
(45, 1, 'Adicionou um novo cargo (cargo1)', '2024-08-01 11:52:08', 'BAIXA'),
(46, 1, 'Adicionou um novo cargo (cargo2)', '2024-08-01 11:52:11', 'BAIXA'),
(47, 1, 'Deletou um cargo (#7 - cargo2)', '2024-08-01 11:52:20', 'ALTA'),
(48, 1, 'Deletou um cargo (#4 - DISCIPLINA4)', '2024-08-01 11:52:31', 'ALTA'),
(49, 1, 'Deletou um cargo (#5 - cargo1)', '2024-08-01 11:52:39', 'ALTA'),
(50, 1, 'Adicionou uma nova formação (formacao1)', '2024-08-01 11:59:31', 'BAIXA'),
(51, 1, 'Adicionou uma nova formação (formacao2)', '2024-08-01 11:59:36', 'BAIXA'),
(52, 1, 'Deletou uma atuação (#2 - formacao1)', '2024-08-01 11:59:51', 'ALTA'),
(53, 1, 'Deletou uma atuação (#1 - formacao1)', '2024-08-01 12:00:04', 'ALTA'),
(54, 1, 'Adicionou uma nova Atuação (at1)', '2024-08-01 12:12:52', 'BAIXA'),
(55, 1, 'Adicionou uma nova Atuação (at2)', '2024-08-01 12:12:59', 'BAIXA'),
(56, 1, 'Deletou uma atuação (#1 - at1)', '2024-08-01 12:13:34', 'ALTA'),
(57, 1, 'Deletou uma atuação (#2 - at2)', '2024-08-01 12:13:41', 'ALTA'),
(58, 1, 'Adicionou uma nova Atuação (at1)', '2024-08-01 12:13:44', 'BAIXA'),
(59, 1, 'Deletou uma atuação (#3 - at1)', '2024-08-01 12:13:57', 'ALTA'),
(60, 1, 'Adicionou uma nova formação (formacao1)', '2024-08-01 14:02:52', 'BAIXA'),
(61, 1, 'Adicionou uma nova Atuação (at2)', '2024-08-01 14:02:56', 'BAIXA'),
(62, 1, 'Adicionou uma nova disciplina (DISCIPLINA3)', '2024-08-05 11:23:21', 'BAIXA'),
(63, 1, 'Adicionou uma nova disciplina (disciplina2)', '2024-08-05 11:23:24', 'BAIXA'),
(64, 1, 'Adicionou uma novo Assunto (assunto1)', '2024-08-05 11:23:33', 'BAIXA'),
(65, 1, 'Adicionou uma novo Assunto (assunto2)', '2024-08-05 11:23:37', 'BAIXA'),
(66, 1, 'Adicionou uma nova banca (banca1])', '2024-08-05 11:23:42', 'BAIXA'),
(67, 1, 'Adicionou uma nova banca (banca2)', '2024-08-05 11:23:47', 'BAIXA'),
(68, 1, 'Adicionou um novo cargo (cargo1)', '2024-08-05 11:23:52', 'BAIXA'),
(69, 1, 'Adicionou um novo cargo (cargo2)', '2024-08-05 11:23:56', 'BAIXA'),
(70, 1, 'Adicionou uma nova formação (formacao1)', '2024-08-05 11:23:58', 'BAIXA'),
(71, 1, 'Adicionou uma nova formação (formacao2)', '2024-08-05 11:24:00', 'BAIXA'),
(72, 1, 'Adicionou uma nova Atuação (at1)', '2024-08-05 11:24:03', 'BAIXA'),
(73, 1, 'Adicionou uma nova Atuação (at2)', '2024-08-05 11:24:05', 'BAIXA'),
(74, 1, 'Adicionou uma nova disciplina (DISCIPLINA SUPREMA)', '2024-08-05 14:40:16', 'BAIXA'),
(75, 1, 'Criou uma questão VF - DVCQ2', '2024-08-07 14:25:55', 'BAIXA'),
(76, 1, 'Criou uma questão MULT - DVCQ5', '2024-08-07 14:40:48', 'BAIXA'),
(77, 1, 'Criou uma questão MULT - DVCQ5', '2024-08-07 14:42:59', 'BAIXA'),
(78, 1, 'Criou uma questão VF - DVCQ6', '2024-08-07 14:45:06', 'BAIXA');

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `ID` int(11) NOT NULL,
  `questions_ID` varchar(15) NOT NULL,
  `alternative` tinytext NOT NULL,
  `answer` text NOT NULL,
  `correct` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`ID`, `questions_ID`, `alternative`, `answer`, `correct`) VALUES
(96, 'DVCQ3', 'A', 'A Costa do Marfim (em francês: Côte d\'Ivoire), oficial e protocolarmente República de Côte d\'Ivoire,[nota 2] é um país africano, limitado a norte pelo Mali e pelo Burquina Fasso, a leste pelo Gana, a sul pelo Oceano Atlântico e a oeste pela Libéria e pela Guiné. Sua capital é Iamussucro, mas a maior cidade é Abidjã.[6]', 0),
(97, 'DVCQ3', 'B', 'A história da biologia traça o estudo do meio vivo desde a Antiguidade até aos tempos modernos. Embora o conceito de biologia enquanto campo científico único e coeso só tenha surgido no século XIX, as ciências biológicas têm origem nas práticas ancestrais de medicina e de história natural que remontam à Ayurveda, à medicina do Antigo Egito e às obras de Aristóteles e Galeno durante a Antiguidade clássica.', 0),
(98, 'DVCQ3', 'C', '.o fóssil humano mais antigo já encontrado chama-se Lucy por causa da canção \"Lucy in the Sky with Diamonds\" da banda britânica The Beatles?', 0),
(99, 'DVCQ3', 'D', 'Registros arqueológicos mostram que a matemática sempre foi parte da atividade humana. Ela evoluiu a partir de contagens, medições, cálculos e do estudo sistemático de formas geométricas e movimentos de objetos físicos. Raciocínios mais abstratos que envolvem argumentação lógica surgiram com os matemáticos gregos aproximadamente em 300 a.C., notadamente com a obra Os Elementos de Euclides. A necessidade de maior rigor foi percebida e estabelecida por volta do século XIX.', 1),
(101, 'DVCQ3', 'E', 'teste e', 0),
(102, 'DVCQ4', 'A', '<p>amarela</p>', 1),
(103, 'DVCQ4', 'B', '<p>roxa</p>', 0),
(104, 'DVCQ4', 'C', '<p>azul</p>', 0),
(105, 'DVCQ4', 'D', '', 0),
(106, 'DVCQ4', 'E', '<p>preta</p>', 0),
(112, 'DVCQ5', 'A', '<p>n&atilde;o</p>', 0),
(113, 'DVCQ5', 'B', '<p>n&atilde;o</p>', 0),
(114, 'DVCQ5', 'C', '<p>sim</p>', 1),
(115, 'DVCQ5', 'D', '<p>n]ao</p>', 0);

-- --------------------------------------------------------

--
-- Table structure for table `answer_comment`
--

CREATE TABLE `answer_comment` (
  `questions_ID` varchar(15) NOT NULL,
  `adms_ID` int(11) NOT NULL,
  `content` text NOT NULL,
  `likes` int(11) DEFAULT NULL,
  `dislikes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bancas`
--

CREATE TABLE `bancas` (
  `ID` int(11) NOT NULL,
  `banca` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `bancas`
--

INSERT INTO `bancas` (`ID`, `banca`) VALUES
(1, 'banca1]'),
(2, 'banca2');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `ID` int(11) NOT NULL,
  `course` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`ID`, `course`) VALUES
(1, 'formacao1'),
(2, 'formacao2');

-- --------------------------------------------------------

--
-- Table structure for table `disciplines`
--

CREATE TABLE `disciplines` (
  `ID` int(11) NOT NULL,
  `discipline` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `disciplines`
--

INSERT INTO `disciplines` (`ID`, `discipline`) VALUES
(1, 'DISCIPLINA3'),
(2, 'disciplina2'),
(3, 'DISCIPLINA SUPREMA');

-- --------------------------------------------------------

--
-- Table structure for table `job_functions`
--

CREATE TABLE `job_functions` (
  `ID` int(11) NOT NULL,
  `job_function` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `job_functions`
--

INSERT INTO `job_functions` (`ID`, `job_function`) VALUES
(1, 'at1'),
(2, 'at2');

-- --------------------------------------------------------

--
-- Table structure for table `job_roles`
--

CREATE TABLE `job_roles` (
  `ID` int(11) NOT NULL,
  `job_role` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `job_roles`
--

INSERT INTO `job_roles` (`ID`, `job_role`) VALUES
(1, 'cargo1'),
(2, 'cargo2');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `ID` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `log_day` date NOT NULL,
  `log_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `ID` varchar(15) NOT NULL,
  `question` text NOT NULL,
  `adms_ID` int(11) NOT NULL,
  `question_type` varchar(50) NOT NULL,
  `status` varchar(25) NOT NULL,
  `year` year(4) NOT NULL,
  `level` varchar(45) DEFAULT NULL,
  `grade_level` varchar(100) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `subject` varchar(150) NOT NULL,
  `banca` varchar(150) NOT NULL,
  `job_function` varchar(150) NOT NULL,
  `job_role` varchar(150) NOT NULL,
  `course` varchar(150) NOT NULL,
  `discipline` varchar(150) NOT NULL,
  `related_contents` text DEFAULT NULL,
  `keys` varchar(200) DEFAULT NULL,
  `answer` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`ID`, `question`, `adms_ID`, `question_type`, `status`, `year`, `level`, `grade_level`, `created_at`, `subject`, `banca`, `job_function`, `job_role`, `course`, `discipline`, `related_contents`, `keys`, `answer`) VALUES
('DVCQ2', '<p>o c&eacute;u &eacute; azul?</p>', 1, 'tf', '1', '2026', 'medio', 'médio', '2024-08-07', '2', '2', '1-2', '2', '1-2', '2-3', '<p>www.google.com.br</p>', 'FORTALEZA', '1'),
('DVCQ3', '<p><strong>Banana</strong>,&nbsp;<strong>pacoba</strong>&nbsp;ou&nbsp;<strong>pacova</strong><sup id=\"cite_ref-1\"><a href=\"https://pt.wikipedia.org/wiki/Banana#cite_note-1\">[1]</a></sup>&nbsp;&eacute; uma&nbsp;<a title=\"Pseudobaga\" href=\"https://pt.wikipedia.org/wiki/Pseudobaga\">pseudobaga</a>&nbsp;da&nbsp;<a title=\"Bananeira\" href=\"https://pt.wikipedia.org/wiki/Bananeira\">bananeira</a>, uma planta&nbsp;<a title=\"Herb&aacute;cea\" href=\"https://pt.wikipedia.org/wiki/Herb%C3%A1cea\">herb&aacute;cea</a>&nbsp;vivaz&nbsp;<a title=\"Acaule\" href=\"https://pt.wikipedia.org/wiki/Acaule\">acaule</a>&nbsp;da fam&iacute;lia&nbsp;<a title=\"Musaceae\" href=\"https://pt.wikipedia.org/wiki/Musaceae\">Musaceae</a>&nbsp;(g&eacute;nero&nbsp;<em>Musa</em>&nbsp;- al&eacute;m do g&eacute;nero&nbsp;<em><a title=\"Ensete\" href=\"https://pt.wikipedia.org/wiki/Ensete\">Ensete</a></em>, que produz as chamadas \"falsas bananas\"). S&atilde;o cultivadas em 130 pa&iacute;ses. Origin&aacute;rias do&nbsp;<a title=\"Sudeste da &Aacute;sia\" href=\"https://pt.wikipedia.org/wiki/Sudeste_da_%C3%81sia\">sudeste da &Aacute;sia</a>&nbsp;s&atilde;o atualmente cultivadas em praticamente todas as regi&otilde;es&nbsp;<a title=\"Clima tropical\" href=\"https://pt.wikipedia.org/wiki/Clima_tropical\">tropicais</a>&nbsp;do planeta.</p>', 1, 'mult', '1', '1988', 'medio', 'fundamental-médio-superior', '2024-08-06', '2', '1', '1-2', '2', '1-2', '1-2', 'https://en.wikipedia.org/wiki/Links_(web_browser)', 'FORTALEZA COGNATUS', 'D'),
('DVCQ4', '<p>que cor &eacute; a banana?</p>', 1, 'mult', '1', '1999', 'facil', 'fundamental-médio', '2024-08-07', '2', '2', '1-2', '1', '1-2', '1-2', '', 'ffrfr', 'A'),
('DVCQ5', '<p>tudo bem?</p>', 1, 'mult', '1', '1995', 'medio', 'superior', '2024-08-07', '2', '1', '2', '2', '1', '2', '<p>sed</p>', 'ffrfr', 'C'),
('DVCQ6', '<p>O SOL &Eacute; BRANCO!</p>', 1, 'tf', '1', '1998', 'dificil', 'fundamental-médio', '2024-08-07', '2', '2', '1', '2', '2', '2-3', '', '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'adm'),
(0, 'mod');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `ID` int(11) NOT NULL,
  `subject` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`ID`, `subject`) VALUES
(1, 'assunto1'),
(2, 'assunto2');

-- --------------------------------------------------------

--
-- Table structure for table `uf`
--

CREATE TABLE `uf` (
  `ID` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `shortName` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `CPF` varchar(12) DEFAULT NULL,
  `CNPJ` varchar(15) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `UF` char(2) DEFAULT NULL,
  `CEP` int(8) DEFAULT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `since` date DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `psw` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `name`, `email`, `phone`, `CPF`, `CNPJ`, `address`, `district`, `city`, `UF`, `CEP`, `picture`, `birth`, `since`, `status`, `psw`) VALUES
(1, 'Erick Rosa', 'tierickrosa@gmail.com', '31982405362', '16914071608', NULL, 'rua antonio de paiva meirelles - 117', 'Serra Verde', 'Belo Horizonte', 'MG', NULL, NULL, '2004-04-21', '2024-08-12', 1, '$2y$10$MdRJH2R8BXDzrHVnzhtFyegFP5pqFcMc1NIIgGwQeuXnGCHNjiSSW');

-- --------------------------------------------------------

--
-- Table structure for table `users_answers`
--

CREATE TABLE `users_answers` (
  `users_ID` int(11) NOT NULL,
  `questions_ID` varchar(15) NOT NULL,
  `answer` varchar(600) DEFAULT NULL,
  `answer_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adms`
--
ALTER TABLE `adms`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `adms_history`
--
ALTER TABLE `adms_history`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_historic_adms1_idx` (`adms_ID`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_answers_questions1_idx` (`questions_ID`);

--
-- Indexes for table `answer_comment`
--
ALTER TABLE `answer_comment`
  ADD PRIMARY KEY (`questions_ID`,`adms_ID`),
  ADD KEY `fk_answer_comment_adms1_idx` (`adms_ID`);

--
-- Indexes for table `bancas`
--
ALTER TABLE `bancas`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `disciplines`
--
ALTER TABLE `disciplines`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `job_functions`
--
ALTER TABLE `job_functions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `job_roles`
--
ALTER TABLE `job_roles`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `uf`
--
ALTER TABLE `uf`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`),
  ADD UNIQUE KEY `shortName_UNIQUE` (`shortName`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `phone_UNIQUE` (`phone`),
  ADD UNIQUE KEY `CPF_UNIQUE` (`CPF`),
  ADD UNIQUE KEY `CNPJ_UNIQUE` (`CNPJ`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indexes for table `users_answers`
--
ALTER TABLE `users_answers`
  ADD PRIMARY KEY (`users_ID`,`questions_ID`),
  ADD KEY `fk_users_answers_users1_idx` (`users_ID`),
  ADD KEY `fk_users_answers_questions1_idx` (`questions_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adms`
--
ALTER TABLE `adms`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `adms_history`
--
ALTER TABLE `adms_history`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `bancas`
--
ALTER TABLE `bancas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `disciplines`
--
ALTER TABLE `disciplines`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `job_functions`
--
ALTER TABLE `job_functions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_roles`
--
ALTER TABLE `job_roles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adms`
--
ALTER TABLE `adms`
  ADD CONSTRAINT `fk_adms_roles` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `adms_history`
--
ALTER TABLE `adms_history`
  ADD CONSTRAINT `fk_historic_adms1` FOREIGN KEY (`adms_ID`) REFERENCES `adms` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `fk_answers_questions1` FOREIGN KEY (`questions_ID`) REFERENCES `questions` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `answer_comment`
--
ALTER TABLE `answer_comment`
  ADD CONSTRAINT `fk_answer_comment_adms1` FOREIGN KEY (`adms_ID`) REFERENCES `adms` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_answer_comment_questions1` FOREIGN KEY (`questions_ID`) REFERENCES `questions` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `fk_questions_adms1` FOREIGN KEY (`adms_ID`) REFERENCES `adms` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users_answers`
--
ALTER TABLE `users_answers`
  ADD CONSTRAINT `fk_users_answers_questions1` FOREIGN KEY (`questions_ID`) REFERENCES `questions` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_answers_users1` FOREIGN KEY (`users_ID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
