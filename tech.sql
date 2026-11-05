-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le : Jeu 05 Novembre 2026 à 13:49
-- Version du serveur: 5.5.16
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `tech`
--

-- --------------------------------------------------------

--
-- Structure de la table `bd_menu`
--

CREATE TABLE IF NOT EXISTS `bd_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `description` text,
  `prix` decimal(10,2) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `disponibilite` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `bd_menu`
--

INSERT INTO `bd_menu` (`id`, `nom`, `description`, `prix`, `image_path`, `disponibilite`) VALUES
(15, 'Spaghetti ', 'Spaghettis bolognaise ', '4.50', '1777239942_spaghetti.jpg', 0),
(16, 'couscous', 'couscous tunisien ', '5.00', '1777299721_COUSCOUS.jpg', 1),
(17, 'salade', 'saladee', '3.00', '1777301469_SALADE.jpg', 1),
(18, 'ma9arouna crevette ðŸ¦ ', 'bennnn bennn bennaaa', '65.00', '1777761043_tlchargement.jpg', 1),
(19, 'pepsi soda', 'sodaaaaaaaaaaa', '3.00', '1777761753_pepsi.jpg', 1),
(20, 'jus fraise ðŸ“ ', 'jawwwwwwwww', '8.00', '1777761787_images.jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `details` text NOT NULL,
  `prix_total` decimal(10,2) NOT NULL,
  `type_service` enum('sur place','emporte') NOT NULL,
  `num_table` int(11) DEFAULT NULL,
  `statut` enum('en attente','pret','payee') DEFAULT 'en attente',
  `date_heure` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Contenu de la table `commandes`
--

INSERT INTO `commandes` (`id`, `details`, `prix_total`, `type_service`, `num_table`, `statut`, `date_heure`) VALUES
(24, '2x couscous, 1x Spaghetti ', '14.50', 'emporte', 0, 'payee', '2026-04-27 14:23:28'),
(25, '2x salade, 1x pizza, 1x Spaghetti ', '22.50', 'emporte', 0, 'payee', '2026-04-27 14:57:03'),
(26, '2x salade, 2x ma9arouna crevette ðŸ¦ , 4x pepsi soda, 1x jus fraise ðŸ“ ', '156.00', '', 2, 'payee', '2026-05-02 22:44:08'),
(27, '1x jus fraise ðŸ“ , 2x salade', '14.00', '', 5, 'payee', '2026-10-22 21:56:16');

-- --------------------------------------------------------

--
-- Structure de la table `demandes`
--

CREATE TABLE IF NOT EXISTS `demandes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `statut` varchar(20) DEFAULT 'en_attente',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Contenu de la table `demandes`
--

INSERT INTO `demandes` (`id`, `username`, `password`, `role`, `statut`) VALUES
(41, 'xx', 'c6f057b86584942e415435ffb1fa93d4', 'chef', 'accepte'),
(42, 'basma', '202cb962ac59075b964b07152d234b70', 'caissier', 'accepte'),
(43, 'zeinebb', 'c6f057b86584942e415435ffb1fa93d4', 'chef', 'accepte'),
(44, 'Chef1', '698d51a19d8a121ce581499d7b701668', 'chef', 'accepte'),
(45, 'MR chef', 'cbb4581ba3ada1ddef9b431eef2660ce', 'chef', 'accepte'),
(46, 'MR caissier', '2252da4c605711aed52d74e98d5732a0', 'caissier', 'accepte'),
(47, 'MR finance', '57336afd1f4b40dfd9f5731e35302fe5', 'caissier', 'accepte'),
(48, 'MR cuisine', 'e82f13bac2f6a28114843bc9d819f68a', 'chef', 'accepte'),
(49, 'Stoura', '202cb962ac59075b964b07152d234b70', 'caissier', 'accepte'),
(50, 'Sahar', '250cf8b51c773f3f8dc8b4be867a9a02', 'chef', 'accepte'),
(51, 'Ons', '4533c91f5dfccfcc923b403b623f0428', 'chef', 'accepte'),
(52, 'yosser', 'e6f190f0b5b703cc2506a51abdf9ca33', 'caissier', 'accepte'),
(53, 'yossra', '202cb962ac59075b964b07152d234b70', 'chef', 'accepte'),
(54, 'ons', '202cb962ac59075b964b07152d234b70', 'caissier', 'accepte'),
(55, 'ons', '202cb962ac59075b964b07152d234b70', 'caissier', 'accepte');

-- --------------------------------------------------------

--
-- Structure de la table `tables_restaurant`
--

CREATE TABLE IF NOT EXISTS `tables_restaurant` (
  `id` int(11) NOT NULL,
  `statut` enum('libre','occupe') DEFAULT 'libre',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tables_restaurant`
--

INSERT INTO `tables_restaurant` (`id`, `statut`) VALUES
(1, 'libre'),
(2, 'occupe'),
(3, 'libre'),
(4, 'libre'),
(5, 'occupe'),
(6, 'libre'),
(7, 'occupe'),
(8, 'libre'),
(9, 'libre');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(18, 'xx', 'c6f057b86584942e415435ffb1fa93d4', 'chef'),
(19, 'basma', '202cb962ac59075b964b07152d234b70', 'caissier'),
(20, 'zeineb', '123456', 'chef'),
(21, 'zeinebb', 'c6f057b86584942e415435ffb1fa93d4', 'chef'),
(22, 'Chef1', '698d51a19d8a121ce581499d7b701668', 'chef'),
(23, 'MR finance', '57336afd1f4b40dfd9f5731e35302fe5', 'caissier'),
(24, 'MR chef', 'cbb4581ba3ada1ddef9b431eef2660ce', 'chef'),
(25, 'Stoura', '202cb962ac59075b964b07152d234b70', 'caissier'),
(26, 'Sahar', '250cf8b51c773f3f8dc8b4be867a9a02', 'chef'),
(27, 'Ons', '4533c91f5dfccfcc923b403b623f0428', 'chef'),
(28, 'MR caissier', '2252da4c605711aed52d74e98d5732a0', 'caissier'),
(29, 'MR cuisine', 'e82f13bac2f6a28114843bc9d819f68a', 'chef'),
(30, 'yosser', 'e6f190f0b5b703cc2506a51abdf9ca33', 'caissier'),
(31, 'yossra', '202cb962ac59075b964b07152d234b70', 'chef'),
(32, 'ons', '202cb962ac59075b964b07152d234b70', 'caissier'),
(33, 'ons', '202cb962ac59075b964b07152d234b70', 'caissier');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
