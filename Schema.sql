-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Sam 08 Novembre 2014 à 20:33
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `siteperso`
--

-- --------------------------------------------------------

--
-- Structure de la table `liste_bd`
--

CREATE TABLE IF NOT EXISTS `liste_bd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total` int(11) NOT NULL,
  `possede` int(11) NOT NULL,
  `fini` tinyint(1) NOT NULL,
  `prochaine_sortie` date NOT NULL,
  `titre` varchar(60) NOT NULL,
  `img_path` varchar(126) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `liste_bd`
--

INSERT INTO `liste_bd` (`id`, `total`, `possede`, `fini`, `prochaine_sortie`, `titre`, `img_path`) VALUES
(3, 19, 13, 1, '2014-11-08', 'XIII', 'assets/1.jpeg'),
(4, 72, 71, 0, '2015-01-07', 'One Piece', 'assets/op.png'),
(5, 32, 32, 0, '0000-00-00', 'Hunter x Hunter', 'assets/hxh.jpg'),
(6, 22, 19, 0, '0000-00-00', 'The Walking Dead', 'assets/twd.jpg'),
(13, 22, 17, 1, '0000-00-00', 'Fullmetal Alchemist', 'http://luniversdeshadene.u.l.f.unblog.fr/files/2010/03/fmagroup1.jpg'),
(14, 17, 14, 0, '0000-00-00', 'Test', 'http://luniversdeshadene.u.l.f.unblog.fr/files/2010/03/fmagroup1.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
