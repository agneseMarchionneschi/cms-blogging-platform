-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mag 27, 2021 alle 16:38
-- Versione del server: 10.4.11-MariaDB
-- Versione PHP: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onblog_db`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `backgrounds`
--

CREATE TABLE `backgrounds` (
  `id` int(11) NOT NULL,
  `src` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `backgrounds`
--

INSERT INTO `backgrounds` (`id`, `src`) VALUES
(1, 'grey.jpg'),
(2, 'pink.jpg'),
(3, 'orange.jpg'),
(4, 'green.jpg'),
(5, 'forest.jpg'),
(6, 'pois.jpg'),
(7, 'colors.jpg'),
(8, 'whitepink.jpg'),
(9, 'multicolors.jpg'),
(10, 'yellow.jpg'),
(11, 'greek.jpg'),
(12, 'greekblue.jpg'),
(13, 'cactus.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `blogs`
--

INSERT INTO `blogs` (`id`, `user_id`, `image_id`, `title`, `slug`, `created_at`) VALUES
(16, 28, 14, 'Architettura', 'architettura', '2021-05-05 15:06:27'),
(17, 28, 18, 'Cucina', 'cucina', '2021-05-05 12:30:02'),
(18, 29, 20, 'Design', 'design', '2021-05-05 13:06:27'),
(19, 30, 24, 'Beauty', 'beauty', '2021-05-05 21:36:00'),
(20, 30, 27, 'Arte', 'arte', '2021-05-05 16:15:23'),
(21, 31, 30, 'Elettronica', 'elettronica', '2021-05-05 12:12:43'),
(22, 31, 33, 'Film', 'film', '2021-05-05 19:28:54'),
(23, 32, 37, 'Serie tv ', 'serie tv', '2021-05-05 12:00:19'),
(33, 49, 43, 'Deep Learning', 'deep-learning', '2021-05-11 15:55:41'),
(62, 59, 45, 'Gatti', 'gatti', '2021-05-23 12:10:08'),
(63, 60, 141, 'Giappone 2013', 'giappone', '2021-05-24 13:10:02');

-- --------------------------------------------------------

--
-- Struttura della tabella `coautore`
--

CREATE TABLE `coautore` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `coautore`
--

INSERT INTO `coautore` (`id`, `blog_id`, `user_id`) VALUES
(28, 18, 29),
(29, 19, 29),
(30, 21, 29),
(31, 23, 29),
(35, 33, 29),
(74, 63, 59),
(75, 62, 28);

-- --------------------------------------------------------

--
-- Struttura della tabella `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `body`, `created_at`) VALUES
(71, 29, 24, 'Voglio provarla!', '2020-12-31 11:19:03'),
(72, 29, 22, 'fantasticoooo', '2020-12-31 11:19:32'),
(73, 28, 25, 'Wow', '2020-12-31 11:20:08'),
(74, 28, 26, 'non sapevo questa cosa, grazie!', '2020-12-31 11:22:16'),
(75, 30, 27, 'davvero?', '2020-12-31 11:27:57'),
(76, 30, 26, 'bello!', '2020-12-31 11:28:17'),
(77, 30, 32, 'Voglio saperne ancora!', '2020-12-31 12:16:38'),
(78, 30, 21, 'Una grande artista', '2020-12-31 12:17:12'),
(79, 31, 33, 'Ciao a tutti!', '2020-12-31 12:17:56'),
(80, 31, 21, 'questo post è bellissimo', '2020-12-31 12:18:21');

-- --------------------------------------------------------

--
-- Struttura della tabella `customization`
--

CREATE TABLE `customization` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `sfondo_id` int(11) DEFAULT NULL,
  `header_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `customization`
--

INSERT INTO `customization` (`id`, `blog_id`, `sfondo_id`, `header_id`) VALUES
(10, 16, 8, 10),
(11, 18, 3, 7),
(12, 19, 1, 1),
(13, 21, 7, 3),
(14, 22, 13, 9),
(15, 23, NULL, 5),
(21, 62, 3, 8),
(22, 63, 5, 9);

-- --------------------------------------------------------

--
-- Struttura della tabella `header`
--

CREATE TABLE `header` (
  `id` int(11) NOT NULL,
  `src` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `header`
--

INSERT INTO `header` (`id`, `src`) VALUES
(1, 'music.jpg'),
(2, 'squares.jpg'),
(3, 'heart.jpg'),
(4, 'flowers.jpg'),
(5, 'rainbow.jpg'),
(6, 'pink.jpg'),
(7, 'pictures.jpg'),
(8, 'brown.jpg'),
(9, 'blue.jpg'),
(10, 'sea.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `src` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `images`
--

INSERT INTO `images` (`id`, `src`) VALUES
(3, 'Musica.jpg'),
(4, 'Cucina.jpg'),
(5, 'Arte.jpg'),
(6, 'filosofia.jpg'),
(7, 'Storia.jpg'),
(9, 'urob.jpg'),
(14, 'architettura.jpg'),
(15, 'hadid.jpg'),
(16, 'piano.jpg'),
(17, 'gehry.jpg'),
(18, 'cucina.jpg'),
(19, 'ricetta.jpg'),
(20, 'design.jpg'),
(21, 'winebox.jpg'),
(22, 'poltrona.jpg'),
(23, 'graphicdesign.jpg'),
(24, 'beauty.jpg'),
(25, 'beauty2.jpg'),
(26, 'beauty1.jpg'),
(27, 'Hopper.jpg'),
(28, 'picasso.jpg'),
(29, 'monet.jpg'),
(30, 'elettronica.jpg'),
(31, 'cuffie.jpg'),
(32, 'orologio.jpg'),
(33, 'film.jpg'),
(34, 'leon.jpg'),
(35, 'dicaprio.jpg'),
(36, 'cassa.jpg'),
(37, 'serietv.jpg'),
(38, 'serie1.jpg'),
(39, 'theoffice.jpg'),
(40, 'truman.jpg'),
(41, 'Santi.jpg'),
(43, 'download.jpeg'),
(44, 'unnamed.png'),
(45, 'maxresdefault.jpeg'),
(140, '12-siti-per-vendere-foto.jpeg'),
(141, '324b4526009840f235aeee910171fc99.jpg'),
(142, 'fed166f6c8a931e4293356da3c8fa946.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`) VALUES
(58, 29, 24),
(59, 29, 23),
(60, 29, 22),
(61, 28, 26),
(62, 28, 25),
(63, 28, 27),
(64, 30, 27),
(65, 30, 26),
(66, 30, 32),
(67, 30, 29),
(68, 30, 24),
(69, 30, 21),
(70, 30, 22),
(71, 31, 33),
(72, 31, 21);

-- --------------------------------------------------------

--
-- Struttura della tabella `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `total_views` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `pages`
--

INSERT INTO `pages` (`id`, `total_views`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `page_views`
--

CREATE TABLE `page_views` (
  `visitor_ip` varchar(255) NOT NULL,
  `page_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `page_views`
--

INSERT INTO `page_views` (`visitor_ip`, `page_id`) VALUES
('::1', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `blog_id`, `image_id`, `title`, `body`, `slug`, `created_at`) VALUES
(21, 28, 16, 15, 'Zara Hadid', 'Zaha Hadid &egrave stata un\'architetta e designer irachena naturalizzata britannica. Ha ricevuto il Premio Pritzker nel 2004 e il Premio Stirling nel 2010 e nel 2011. &egrave stata una delle capofila e massime esponenti della corrente decostruttivista.', 'Zaha-Hadid', '2021-05-05 11:04:12'),
(22, 28, 16, 16, 'Renzo Piano', 'Renzo Piano (Genova, 14 settembre 1937) &egrave un architetto e senatore italiano. Residente a Parigi, &egrave considerato uno degli architetti pi&ugrave influenti, prolifici e attivi a livello internazionale del XX e XXI secolo, vincitore di numerosi premi, tra cui il Premio Pritzker consegnatogli dal Presidente degli Stati Uniti Bill Clinton alla Casa Bianca nel 1998[2][3] e della medaglia d\'oro AIA nel 2008.', 'Piano', '2021-05-05 11:05:53'),
(23, 28, 16, 17, 'Gehry', 'Il Guggenheim Museum Bilbao &egrave un museo di arte contemporanea situato in un edificio progettato dall\'architetto canadese Frank O. Gehry si trova a Bilbao nei Paesi Baschi, nel nord della Spagna. Il Guggenheim di Bilbao &egrave uno dei vari musei della Fondazione Solomon R.', 'Gehry', '2021-05-04 11:07:32'),
(24, 28, 17, 19, 'Caprese', 'L’Insalata Caprese &egrave un antipasto freddo ed estivo, tipico dalla cucina campana a base di pomodoro, mozzarella, olio extravergine, origano e basilico fresco! Pochi ingredienti che assemblati sapientemente tra loro, danno vita in 5 minuti  ad una delizia eccezionale! che pensate, nasce a Capri nel 1920, nel famoso Hotel Quisisana in occasione di una cena organizzata per il poeta Filippo Tommaso Marinetti, fondatore del manifesto futurista.', 'carbonara', '2021-05-05 11:11:10'),
(25, 29, 18, 21, 'WineBox', 'winebox dal design moderno', 'winebox', '2021-05-05 11:16:59'),
(26, 29, 18, 22, 'Poltrona di design', 'Poltrona dal design moderno', 'poltrona', '2021-05-05 11:17:45'),
(27, 29, 18, 23, 'Graphic Design', 'il graphic design', 'il-diario-di-jk-awa', '2021-05-05 11:21:27'),
(28, 30, 19, 25, 'Jade Roller', 'Il rullo di giada produce sulla pelle del viso un effetto lifting importante essendo in grado di favorire la microcircolazione e il drenaggio linfatico ottimizzando allo stesso tempo la produzione di collagene', 'rullo', '2021-05-05 11:26:04'),
(29, 30, 19, 26, 'Maschera Viso', 'Dette anche maschere di pulizia, servono per contrastare la formazione di punti neri, per restringere i pori dilatati, e per ridurre la sovra-produzione di sebo. Per questo motivo, le maschere purificanti sono indicate principalmente per la pelle mista e/o grassa.', 'maschere', '2021-05-05 11:27:23'),
(30, 30, 20, 28, 'Picasso ', 'Pablo Ruiz y Picasso, semplicemente noto come Pablo Picasso, &egrave stato un pittore e scultore spagnolo di fama mondiale, considerato uno dei protagonisti assoluti della pittura del XX secolo.', 'Picasso-', '2021-05-05 12:06:05'),
(31, 30, 20, 29, 'Monet', 'Oscar-Claude Monet &egrave stato un pittore francese, considerato uno dei fondatori dell\'impressionismo francese e certamente il pi&ugrave coerente e prolifico del movimento.', 'Monet', '2021-05-05 12:07:31'),
(32, 31, 21, 31, 'Cuffie di design', 'cuffie di design alla moda senza fili', 'cuffie', '2021-05-05 12:14:25'),
(33, 30, 21, 32, 'smartwatch', 'smartwatch Apple molto alla moda', 'orologio', '2021-05-05 12:16:00'),
(34, 31, 22, 34, 'Lèon ', 'Matilde ha dodici anni e ha perso la famiglia, sterminata da una cosca mafiosa. Leon &egrave un sicario introverso e poco istruito. Tra i due nasce un rapporto di amicizia e sostegno in un universo ostile e violento.', 'leon', '2021-05-05 12:22:20'),
(35, 31, 22, 35, 'The Wolf of Wall Street', 'The Wolf of Wall Street &egrave un film del 2013 diretto e prodotto da Martin Scorsese. La pellicola, adattamento cinematografico dell\'autobiografia Il lupo di Wall Street pubblicata negli Stati Uniti nel settembre 2007 e in Italia nel gennaio 2014, narra l\'ascesa e la caduta di Jordan Belfort, spregiudicato broker newyorkese interpretato da Leonardo DiCaprio alla sua quinta collaborazione con Scorsese. Fulcro della pellicola &egrave la sua vita fatta di eccessi che lo porteranno poi a una rovinosa caduta.', 'Scorsese', '2021-05-05 12:23:57'),
(36, 31, 21, 36, 'Cassa bluetooth ', 'cassa bluetooth di design', 'cassa', '2021-05-05 12:24:54'),
(37, 32, 23, 38, 'The Handmaid&#39;s Tale', 'serie televisiva statunitense del 2017, ideata da Bruce Miller e basata sul romanzo distopico del 1985 Il racconto dell\'ancella, dell\'autrice canadese Margaret Atwood.', 'ancella', '2021-05-05 13:13:14'),
(38, 29, 23, 39, 'The office ', 'serie televisiva statunitense creata da Greg Daniels. Si tratta del remake americano dell\'omonima serie cult britannica, ideata e scritta da Ricky Gervais e Stephen Merchant e trasmessa dal 2001 al 2003.', 'office-', '2021-05-05 13:26:21'),
(39, 31, 22, 40, 'The Truman Show', ' film del 1998 diretto da Peter Weir, su soggetto di Andrew Niccol, e interpretato da Jim Carrey, fino ad allora conosciuto principalmente per ruoli comici in film demenziali', 'truman', '2021-01-01 17:39:07'),
(62, 49, 33, 44, 'Reti Neurali', 'Nel campo dell\'apprendimento automatico, una rete neurale artificiale (in inglese artificial neural network, abbreviato in ANN o anche come NN) &egrave; un modello computazionale composto di &quot;&lt;b&gt;neuroni&lt;/b&gt;&quot; artificiali, ispirato vagamente dalla semplificazione di una rete neurale biologica.', 'reti-neurali', '2021-05-11 15:58:41'),
(98, 60, 63, 142, 'test2', 'test 2 post', 'test2', '2021-05-24 13:15:38'),
(99, 59, 62, 41, 'gatto rosso', 'il gatto rosso è un\'animale molto curioso, affettuoso con il proprio padrone e aggressivo nei confronti degli estranei. Ama coccolarsi corpo a corpo con il proprio padrone ed è molto protettivo nei suoi confronti, a volte anche possessivo.', 'gattorosso', '2021-05-25 13:15:38');

-- --------------------------------------------------------

--
-- Struttura della tabella `temi_blog`
--

CREATE TABLE `temi_blog` (
  `id` int(11) NOT NULL,
  `tema_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `temi_blog`
--

INSERT INTO `temi_blog` (`id`, `tema_id`, `blog_id`) VALUES
(1, 12, 18),
(2, 11, 17),
(3, 3, 16),
(4, 16, 19),
(5, 2, 20),
(6, 17, 21),
(7, 18, 22),
(8, 5, 23),
(19, 28, 33),
(53, 39, 62),
(54, 1, 63);

-- --------------------------------------------------------

--
-- Struttura della tabella `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `topics`
--

INSERT INTO `topics` (`id`, `nome`, `slug`) VALUES
(1, 'Personale', 'personale'),
(2, 'Arte', 'arte'),
(3, 'Architettura', 'architettura'),
(4, 'Beauty', 'beauty'),
(5, 'Serie tv', 'Serie tv'),
(6, 'Pittura', 'pittura'),
(7, 'Elettronica', 'elettronica'),
(11, 'Cucina', 'cucina'),
(12, 'Design', 'design'),
(16, 'prodotti', 'prodotti'),
(17, 'Tecnologia', 'tecnologia'),
(18, 'Film', 'Film'),
(28, 'Informatica', 'informatica'),
(29, 'Analisi di Dati', 'analisi-di-dati'),
(39, 'Gatti', 'gatti');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cellulare` varchar(255) NOT NULL,
  `documento` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `cellulare`, `documento`, `created_at`) VALUES
(28, 'Elena', 'elena@email.com', '$2y$10$IC1Zj/7M76LDyP57r9aeOuMmKti82fAnbvGBZ31wUco3UwkJLsRU2', '3759430674', 'ax9347534', '2021-05-05 10:59:53'),
(29, 'Niccolo', 'niccolo@email.com', '$2y$10$5sDyeZDpF.xhLgi.ALL7vOYfZHAjibUL55PNZO8y961w7iBW.7wpW', '0684739505', 'ay213134325', '2021-05-05 11:12:04'),
(30, 'Agnese', 'agnese@email.com', '$2y$10$wSlx5qRYzeQEoVB5nzoXyOI0pd1Lq3QgW0kKCuQhVgWqnq6QdWvoq', '4534636347', 'ay453463', '2021-05-05 11:23:11'),
(31, 'Anna', 'anna@email.it', '$2y$10$J6RYpyPhoVF1H0/AmQ.d9ODJ.zO9NIw/f3H3LHE.28AofIeOU8tlW', '323465362', 'ax3252352', '2021-05-05 12:08:45'),
(32, 'pino', 'pino@email.com', '$2y$10$.0jFrC2vBv3HFB77vfxJluH.x.j7YNK9PPWp6.0B6bSJQFO2Bny1i', '2534637674', 'ax23542526', '2021-05-05 12:28:23'),
(49, 'agne', 'agnese.marchionneschi@gmail.co', '$2y$10$YqU0f317qQf.JwHDQQQ9LuCimBUPpv5wDgfKxaqOBuD3tb/bRkNIW', '3335892425', '345345', '2021-05-11 15:54:36'),
(51, 'agnes', 'agnes@gmail.com', '$2y$10$ErZQZ7VNsYB.74dbA4zHtuRPJ9IOjorg5XSXbr3ZDSUt8af6sndFi', '4353245', 'afggr', '2021-05-20 19:41:42'),
(59, 'admin', 'admin@gmail.com', '$2y$10$EWOLgo0O4K6p/8DAzUYk9eZrH4R9YvK/d3qnrAyhY.KD4qaozAag.', '343', '45wf', '2021-05-20 21:07:22'),
(60, 'test', 'test@gmail.com', '$2y$10$JOn6NfpJkm/z7Hn1sDbxM.A57Ir1xu1FKatnmXK9KlQveAK83lGfm', '2432434', '236fg', '2021-05-24 13:07:26');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `backgrounds`
--
ALTER TABLE `backgrounds`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `image_id` (`image_id`);

--
-- Indici per le tabelle `coautore`
--
ALTER TABLE `coautore`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_id` (`blog_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indici per le tabelle `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indici per le tabelle `customization`
--
ALTER TABLE `customization`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_id` (`blog_id`),
  ADD KEY `sfondo_id` (`sfondo_id`),
  ADD KEY `header_id` (`header_id`);

--
-- Indici per le tabelle `header`
--
ALTER TABLE `header`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indici per le tabelle `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `page_views`
--
ALTER TABLE `page_views`
  ADD KEY `page_id` (`page_id`);

--
-- Indici per le tabelle `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `blog_id` (`blog_id`),
  ADD KEY `image_id` (`image_id`);

--
-- Indici per le tabelle `temi_blog`
--
ALTER TABLE `temi_blog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tema_id` (`tema_id`),
  ADD KEY `blog_id` (`blog_id`);

--
-- Indici per le tabelle `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `backgrounds`
--
ALTER TABLE `backgrounds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT per la tabella `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT per la tabella `coautore`
--
ALTER TABLE `coautore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT per la tabella `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

--
-- AUTO_INCREMENT per la tabella `customization`
--
ALTER TABLE `customization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT per la tabella `header`
--
ALTER TABLE `header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT per la tabella `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT per la tabella `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT per la tabella `temi_blog`
--
ALTER TABLE `temi_blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT per la tabella `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `blogs_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `coautore`
--
ALTER TABLE `coautore`
  ADD CONSTRAINT `coautore_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coautore_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `customization`
--
ALTER TABLE `customization`
  ADD CONSTRAINT `customization_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customization_ibfk_2` FOREIGN KEY (`sfondo_id`) REFERENCES `backgrounds` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customization_ibfk_3` FOREIGN KEY (`header_id`) REFERENCES `header` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `page_views`
--
ALTER TABLE `page_views`
  ADD CONSTRAINT `page_views_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `posts_ibfk_3` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `temi_blog`
--
ALTER TABLE `temi_blog`
  ADD CONSTRAINT `temi_blog_ibfk_1` FOREIGN KEY (`tema_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `temi_blog_ibfk_2` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
