-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Client :  mysql51-116.perso
-- Généré le :  Ven 16 Janvier 2015 à 14:11
-- Version du serveur :  5.1.73-2+squeeze+build1+1-log
-- Version de PHP :  5.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `brikabror`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `texte` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `note` double NOT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `utilisateur_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_67F068BCB1E7706E` (`restaurant_id`),
  KEY `IDX_67F068BCFB88E14F` (`utilisateur_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

--
-- Contenu de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `texte`, `note`, `restaurant_id`, `utilisateur_id`) VALUES
(22, 'Sympa le steak/frite a 3e!', 3.5, 33, 8),
(23, 'lol.', 0, 33, 9),
(24, 'fidele a sa reputation', 1, 33, 10);

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_id` int(11) DEFAULT NULL,
  `name` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C53D045FB1E7706E` (`restaurant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=48 ;

--
-- Contenu de la table `image`
--

INSERT INTO `image` (`id`, `restaurant_id`, `name`, `path`) VALUES
(37, 33, '0', 'img/1421101077.jpg'),
(38, 34, '0', 'img/1421234449.jpg'),
(39, 35, '0', 'img/1421234946.jpg'),
(40, 35, '1', 'img/14212349461.jpg'),
(41, 36, '0', 'img/1421235259.jpg'),
(42, 36, '1', 'img/14212352591.jpg'),
(43, 37, '0', 'img/1421235444.jpg'),
(44, 37, '1', 'img/14212354441.jpg'),
(45, 38, '0', 'img/1421241512.jpg'),
(46, 39, '0', 'img/1421242662.jpg'),
(47, 39, '1', 'img/14212426621.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `restaurant`
--

CREATE TABLE IF NOT EXISTS `restaurant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `x` double NOT NULL,
  `y` double NOT NULL,
  `note` double DEFAULT NULL,
  `ville` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `rue` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `cp` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=40 ;

--
-- Contenu de la table `restaurant`
--

INSERT INTO `restaurant` (`id`, `nom`, `description`, `x`, `y`, `note`, `ville`, `rue`, `cp`) VALUES
(33, 'R.U', 'Tres bon rapport/qualite prix.', 4.07055962830782, 48.268303536229, 1.5, 'Rosieres-pres-Troyes', '10 rue Marie Curie', '10430'),
(34, 'L''italien', 'Specialite Italienne (Pizza)', 4.07263465225697, 48.2934428457901, NULL, 'Troyes', '5 Viardin St', '10000'),
(35, 'Mc Donald UTT', 'Restauration rapide. Specialites americaines.', 4.06017377972603, 48.2672874135073, NULL, 'Rosières-près-Troyes', 'Rocade Ouest', '10430'),
(36, 'Mc Donald UTT', 'Specialites americaines', 1.89449217170477, 47.9089524697309, NULL, 'Orléans', '37 Coulmiers St', '45000'),
(37, 'Mc Donald', 'Specialites americaines', 4.04121223837137, 48.2649406351319, NULL, 'Rosières-près-Troyes', '45 Gabriel Deheurles Ave', '10430'),
(38, 'Pizzeria', 'De bonnes pizzas.', 1.41540069133043, 43.5998103259133, NULL, 'Toulouse', '101-103 Grande Bretagne Ave', '31300'),
(39, 'Le pan de bois', 'un resto gastronomique sympa', 4.10690356045961, 48.2391026598054, NULL, 'Buchères', '14 Avenue des Martyrs du 24 Août', '10800');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `pwd` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `login`, `pwd`) VALUES
(8, 'seb', '$2a$08$Dl9wc6blJr8bmlTM4Rk1NuSwq8yncjMuLK2.oZqn4Db6kQpZUZHOq'),
(9, 'seb77340', '$2a$08$SOyygI8oNLErPAV9srAOf.nC/FvQ6vQqp8rQ0Q7UHBbaIwIl75J0m'),
(10, 'jbboisseau', '$2a$08$kUhbm25bpip.p7bGu8H8w.cRwzan6MKntuxmgAbR8.G.D62GUt2M2');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_fav_restaurant`
--

CREATE TABLE IF NOT EXISTS `utilisateur_fav_restaurant` (
  `user_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`restaurant_id`),
  KEY `IDX_5D7DF661A76ED395` (`user_id`),
  KEY `IDX_5D7DF661B1E7706E` (`restaurant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `utilisateur_fav_restaurant`
--

INSERT INTO `utilisateur_fav_restaurant` (`user_id`, `restaurant_id`) VALUES
(8, 33),
(10, 33);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_67F068BCB1E7706E` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`),
  ADD CONSTRAINT `FK_67F068BCFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_C53D045FB1E7706E` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`);

--
-- Contraintes pour la table `utilisateur_fav_restaurant`
--
ALTER TABLE `utilisateur_fav_restaurant`
  ADD CONSTRAINT `FK_5D7DF661A76ED395` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `FK_5D7DF661B1E7706E` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
