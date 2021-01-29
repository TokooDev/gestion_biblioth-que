-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 20 Décembre 2018 à 15:12
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `bibiotheque`
--

-- --------------------------------------------------------

--
-- Structure de la table `archives`
--

CREATE TABLE IF NOT EXISTS `archives` (
  `id_arch` int(11) NOT NULL AUTO_INCREMENT,
  `id_lecteur` int(11) NOT NULL,
  `id_livre` int(11) NOT NULL,
  `date_empt` date NOT NULL,
  `date_ret` date NOT NULL,
  PRIMARY KEY (`id_arch`),
  KEY `fk_lecteurs` (`id_lecteur`),
  KEY `fk_livres` (`id_livre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=15 ;

--
-- Contenu de la table `archives`
--

INSERT INTO `archives` (`id_arch`, `id_lecteur`, `id_livre`, `date_empt`, `date_ret`) VALUES
(1, 1, 2, '2018-12-11', '2019-01-10'),
(4, 1, 3, '2018-12-11', '2019-01-10'),
(5, 3, 2, '2018-12-11', '2019-01-10'),
(6, 2, 3, '2018-12-12', '2019-01-11'),
(7, 1, 7, '2018-12-17', '2019-01-16'),
(8, 1, 4, '2018-12-17', '2019-01-16'),
(9, 1, 2, '2018-12-18', '2019-01-17'),
(10, 1, 3, '2018-12-18', '2019-01-17'),
(11, 3, 4, '2018-12-20', '2019-01-19'),
(12, 3, 5, '2018-12-20', '2019-01-19'),
(13, 6, 4, '2018-12-20', '2019-01-19'),
(14, 10, 7, '2018-12-20', '2019-01-19');

-- --------------------------------------------------------

--
-- Structure de la table `emprunts`
--

CREATE TABLE IF NOT EXISTS `emprunts` (
  `id_emprunt` int(11) NOT NULL AUTO_INCREMENT,
  `id_lecteur` int(11) NOT NULL,
  `id_livre` int(11) NOT NULL,
  `date_emprunt` date NOT NULL,
  `date_retour` date NOT NULL,
  `penalite` int(255) NOT NULL,
  PRIMARY KEY (`id_emprunt`),
  KEY `fk_lecteur` (`id_lecteur`),
  KEY `fk_livre` (`id_livre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=15 ;

--
-- Contenu de la table `emprunts`
--

INSERT INTO `emprunts` (`id_emprunt`, `id_lecteur`, `id_livre`, `date_emprunt`, `date_retour`, `penalite`) VALUES
(5, 3, 2, '2018-12-11', '2018-12-13', 1320),
(6, 2, 3, '2018-12-12', '2018-12-10', 1320),
(9, 1, 2, '2018-12-18', '2019-01-17', 0),
(10, 1, 3, '2018-12-18', '2019-01-17', 0),
(11, 3, 4, '2018-12-20', '2019-01-19', 0),
(12, 3, 5, '2018-12-20', '2018-12-16', 0),
(13, 6, 4, '2018-12-20', '2019-01-19', 0),
(14, 10, 7, '2018-12-20', '2019-01-19', 0);

-- --------------------------------------------------------

--
-- Structure de la table `lecteurs`
--

CREATE TABLE IF NOT EXISTS `lecteurs` (
  `id_lecteur` int(11) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(60) COLLATE utf8_bin NOT NULL,
  `nom` varchar(25) COLLATE utf8_bin NOT NULL,
  `adresse` varchar(255) COLLATE utf8_bin NOT NULL,
  `cni` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_lecteur`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=11 ;

--
-- Contenu de la table `lecteurs`
--

INSERT INTO `lecteurs` (`id_lecteur`, `prenom`, `nom`, `adresse`, `cni`) VALUES
(1, 'abdoulaye', 'sall', 'Boke', '1322199655'),
(2, 'becaye', 'keita', 'km', '1322199656'),
(3, 'mohamed', 'faye', 'fass', '1322199657'),
(4, 'youssou', 'diallo', 'fass', '1322199658'),
(5, 'ouley', 'dia', 'fan', '1322199659'),
(6, 'coumba', 'ndiay', 'hlm', '1322199645'),
(7, 'marylen', 'manga', 'GY', '13221996457'),
(8, 'khoudia', 'seck', 'malika', '13221996487'),
(9, 'sokhna', 'gueye', 'yoff', '13221996345'),
(10, 'madiop', 'sarr', 'kebemer', '1322456788');

-- --------------------------------------------------------

--
-- Structure de la table `librairie`
--

CREATE TABLE IF NOT EXISTS `librairie` (
  `id_lib` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(60) COLLATE utf8_bin NOT NULL,
  `adresse` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_lib`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=8 ;

--
-- Contenu de la table `librairie`
--

INSERT INTO `librairie` (`id_lib`, `nom`, `adresse`) VALUES
(1, 'LPD', 'hlm'),
(2, 'LPTD', 'sandaga'),
(3, 'librairie papeterie dara dji', 'colobane'),
(4, 'librairie papeterie thissane', 'ouakam'),
(5, 'librairie papeteriebokenabe', 'fouta'),
(6, 'librairie ousmane', 'gwaye'),
(7, 'librairie oumar dia', 'pikine');

-- --------------------------------------------------------

--
-- Structure de la table `livres`
--

CREATE TABLE IF NOT EXISTS `livres` (
  `id_livre` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8_bin NOT NULL,
  `auteurs` varchar(255) COLLATE utf8_bin NOT NULL,
  `maison_edition` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_lib` int(11) NOT NULL,
  `nombre_pages` int(60) NOT NULL,
  `stock` int(255) NOT NULL,
  `prix` int(255) NOT NULL,
  PRIMARY KEY (`id_livre`),
  KEY `fk_lib` (`id_lib`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

--
-- Contenu de la table `livres`
--

INSERT INTO `livres` (`id_livre`, `titre`, `auteurs`, `maison_edition`, `id_lib`, `nombre_pages`, `stock`, `prix`) VALUES
(2, 'Une vie de boy', 'tokosel', 'Hamathan Senegal', 1, 136, 5, 10000),
(3, 'Une si longue lettre', 'Mariama BA', 'Harmathan france', 2, 345, 20, 10000),
(4, 'une vie sans vie', 'alboury', 'le saloum', 2, 350, 5, 12000),
(5, 'le bonheur', 'youssou', 'Harmathan france', 3, 350, 20, 10000),
(6, 'mon oncle', 'mohamed', 'Harmathan senegal', 4, 1000, 30, 15000),
(7, 'la beautÃ©', 'tokosel', 'senegal home', 5, 120, 30, 15000),
(8, 'maasina', 'elhadji', 'fouta dev', 2, 120, 30, 15000);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(60) COLLATE utf8_bin NOT NULL,
  `nom` varchar(25) COLLATE utf8_bin NOT NULL,
  `login` varchar(60) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=11 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_user`, `prenom`, `nom`, `login`, `password`) VALUES
(1, 'Abdoulaye', 'SALL', 'admin', 'admin'),
(2, 'tokosel', 'sall', 'tokosel', 'tokosel'),
(3, 'coumba', 'ndong', 'coumba', 'coumba'),
(4, 'ouley', 'dia', 'ouley', 'ouley'),
(5, 'assane', 'ndiaye', 'assane', 'assane'),
(6, 'mohamed', 'mboup', 'mouha', 'mouha'),
(7, 'salif', 'ndiaye', 'salif', 'salif'),
(8, 'sokhna', 'gueye', 'sokhna', 'sokhna'),
(9, 'Alassane  Amadou', 'ANNE', 'ndeuss', 'ndeuss'),
(10, 'becaye', 'keita', 'becaye', 'becaye');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `archives`
--
ALTER TABLE `archives`
  ADD CONSTRAINT `fk_lecteurs` FOREIGN KEY (`id_lecteur`) REFERENCES `lecteurs` (`id_lecteur`),
  ADD CONSTRAINT `fk_livres` FOREIGN KEY (`id_livre`) REFERENCES `livres` (`id_livre`);

--
-- Contraintes pour la table `emprunts`
--
ALTER TABLE `emprunts`
  ADD CONSTRAINT `fk_lecteur` FOREIGN KEY (`id_lecteur`) REFERENCES `lecteurs` (`id_lecteur`),
  ADD CONSTRAINT `fk_livre` FOREIGN KEY (`id_livre`) REFERENCES `livres` (`id_livre`);

--
-- Contraintes pour la table `livres`
--
ALTER TABLE `livres`
  ADD CONSTRAINT `fk_lib` FOREIGN KEY (`id_lib`) REFERENCES `librairie` (`id_lib`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
