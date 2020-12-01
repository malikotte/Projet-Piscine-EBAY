-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 20 avr. 2020 à 12:50
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `login`
--

-- --------------------------------------------------------

--
-- Structure de la table `acheteurs`
--

DROP TABLE IF EXISTS `acheteurs`;
CREATE TABLE IF NOT EXISTS `acheteurs` (
  `id_acheteur` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id_acheteur`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `idadmin` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`idadmin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`idadmin`, `email`, `password`) VALUES
(1, 'admin@ece.fr', '$2y$10$V5egyrWSiGSeHweZ/BP.UOAc/a9WKF6eyysTXRCbdqG9TjfzY8y1y');

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

DROP TABLE IF EXISTS `adresse`;
CREATE TABLE IF NOT EXISTS `adresse` (
  `id_adresse` int(11) NOT NULL AUTO_INCREMENT,
  `AdresseLigne1` varchar(255) NOT NULL,
  `AdresseLigne2` varchar(255) DEFAULT NULL,
  `Ville` varchar(255) NOT NULL,
  `CP` int(11) NOT NULL,
  `Pays` varchar(255) NOT NULL,
  `Tel` int(11) NOT NULL,
  `id_acheteur` int(11) NOT NULL,
  PRIMARY KEY (`id_adresse`),
  KEY `adresse_ibfk_1` (`id_acheteur`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `carte_bancaire`
--

DROP TABLE IF EXISTS `carte_bancaire`;
CREATE TABLE IF NOT EXISTS `carte_bancaire` (
  `type_carte` varchar(255) NOT NULL,
  `numero_carte` int(255) NOT NULL,
  `nom_carte` varchar(255) NOT NULL,
  `date_expiration` date NOT NULL,
  `cvv` int(11) NOT NULL,
  `id_acheteur` int(11) NOT NULL,
  PRIMARY KEY (`numero_carte`),
  KEY `id_acheteur` (`id_acheteur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `items_achat`
--

DROP TABLE IF EXISTS `items_achat`;
CREATE TABLE IF NOT EXISTS `items_achat` (
  `item_nom` varchar(255) NOT NULL,
  `itemcat` varchar(255) NOT NULL,
  `itemphoto` varchar(255) NOT NULL,
  `item_desc` varchar(255) NOT NULL,
  `prix` int(255) NOT NULL,
  `id_vendeur` int(11) NOT NULL,
  PRIMARY KEY (`item_nom`),
  KEY `id_vendeur` (`id_vendeur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `items_enchere`
--

DROP TABLE IF EXISTS `items_enchere`;
CREATE TABLE IF NOT EXISTS `items_enchere` (
  `item_nom` varchar(255) NOT NULL,
  `itemcat` varchar(255) NOT NULL,
  `itemphoto` varchar(255) NOT NULL,
  `item_desc` varchar(255) NOT NULL,
  `prix` int(11) NOT NULL,
  `id_vendeur` int(11) NOT NULL,
  `date_debut` date NOT NULL DEFAULT current_timestamp(),
  `date_fin` date NOT NULL,
  PRIMARY KEY (`item_nom`),
  KEY `id_vendeur` (`id_vendeur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `items_negociation`
--

DROP TABLE IF EXISTS `items_negociation`;
CREATE TABLE IF NOT EXISTS `items_negociation` (
  `item_nom` varchar(255) NOT NULL,
  `itemcat` varchar(255) NOT NULL,
  `itemphoto` varchar(255) NOT NULL,
  `item_desc` varchar(255) NOT NULL,
  `id_vendeur` int(11) NOT NULL,
  PRIMARY KEY (`item_nom`),
  KEY `id_vendeur` (`id_vendeur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `notif_acheteur`
--

DROP TABLE IF EXISTS `notif_acheteur`;
CREATE TABLE IF NOT EXISTS `notif_acheteur` (
  `id_notifacheteur` int(11) NOT NULL AUTO_INCREMENT,
  `Statut` varchar(255) NOT NULL,
  `Nomitem` varchar(255) NOT NULL,
  `Prixitem` int(50) NOT NULL,
  `id_acheteur` int(11) NOT NULL,
  `id_vendeur` int(11) NOT NULL,
  PRIMARY KEY (`id_notifacheteur`),
  KEY `id_vendeur` (`id_vendeur`),
  KEY `id_acheteur` (`id_acheteur`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `notif_vendeur`
--

DROP TABLE IF EXISTS `notif_vendeur`;
CREATE TABLE IF NOT EXISTS `notif_vendeur` (
  `id_notifvendeur` int(11) NOT NULL AUTO_INCREMENT,
  `Statut` varchar(255) NOT NULL,
  `Nomitem` varchar(255) NOT NULL,
  `Prixitem` int(50) NOT NULL,
  `id_vendeur` int(11) NOT NULL,
  `id_acheteur` int(11) NOT NULL,
  PRIMARY KEY (`id_notifvendeur`),
  KEY `id_vendeur` (`id_vendeur`),
  KEY `id_acheteur` (`id_acheteur`)
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=latin1 COMMENT='id_vendeur';

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id_panier` int(11) NOT NULL AUTO_INCREMENT,
  `Prix` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `id_acheteur` int(11) NOT NULL,
  PRIMARY KEY (`id_panier`),
  KEY `id_acheteur` (`id_acheteur`)
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `proposition_enchere`
--

DROP TABLE IF EXISTS `proposition_enchere`;
CREATE TABLE IF NOT EXISTS `proposition_enchere` (
  `id_propenchere` int(11) NOT NULL AUTO_INCREMENT,
  `Prixpropose` int(50) NOT NULL,
  `Prixprecedent` int(50) DEFAULT 0,
  `nomItem` varchar(255) NOT NULL,
  `id_acheteur` int(11) NOT NULL,
  `id_vendeur` int(11) NOT NULL,
  PRIMARY KEY (`id_propenchere`),
  KEY `id_acheteur` (`id_acheteur`),
  KEY `id_vendeur` (`id_vendeur`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `proposition_offre`
--

DROP TABLE IF EXISTS `proposition_offre`;
CREATE TABLE IF NOT EXISTS `proposition_offre` (
  `id_proposition` int(11) NOT NULL AUTO_INCREMENT,
  `prix` int(11) NOT NULL,
  `Nbessais` int(11) NOT NULL DEFAULT 5,
  `nomOffre` varchar(255) NOT NULL,
  `id_vendeur` int(11) NOT NULL,
  `id_acheteur` int(11) NOT NULL,
  PRIMARY KEY (`id_proposition`),
  KEY `id_vendeur` (`id_vendeur`),
  KEY `id_acheteur` (`id_acheteur`)
) ENGINE=InnoDB AUTO_INCREMENT=219 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `vendeurs`
--

DROP TABLE IF EXISTS `vendeurs`;
CREATE TABLE IF NOT EXISTS `vendeurs` (
  `id_vendeur` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `banniere` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_vendeur`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `adresse`
--
ALTER TABLE `adresse`
  ADD CONSTRAINT `adresse_ibfk_1` FOREIGN KEY (`id_acheteur`) REFERENCES `acheteurs` (`id_acheteur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `carte_bancaire`
--
ALTER TABLE `carte_bancaire`
  ADD CONSTRAINT `carte_bancaire_ibfk_1` FOREIGN KEY (`id_acheteur`) REFERENCES `acheteurs` (`id_acheteur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `items_achat`
--
ALTER TABLE `items_achat`
  ADD CONSTRAINT `items_achat_ibfk_1` FOREIGN KEY (`id_vendeur`) REFERENCES `vendeurs` (`id_vendeur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `items_enchere`
--
ALTER TABLE `items_enchere`
  ADD CONSTRAINT `items_enchere_ibfk_1` FOREIGN KEY (`id_vendeur`) REFERENCES `vendeurs` (`id_vendeur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `items_negociation`
--
ALTER TABLE `items_negociation`
  ADD CONSTRAINT `items_negociation_ibfk_1` FOREIGN KEY (`id_vendeur`) REFERENCES `vendeurs` (`id_vendeur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notif_acheteur`
--
ALTER TABLE `notif_acheteur`
  ADD CONSTRAINT `notif_acheteur_ibfk_1` FOREIGN KEY (`id_vendeur`) REFERENCES `vendeurs` (`id_vendeur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notif_acheteur_ibfk_2` FOREIGN KEY (`id_acheteur`) REFERENCES `acheteurs` (`id_acheteur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notif_vendeur`
--
ALTER TABLE `notif_vendeur`
  ADD CONSTRAINT `notif_vendeur_ibfk_2` FOREIGN KEY (`id_vendeur`) REFERENCES `vendeurs` (`id_vendeur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`id_acheteur`) REFERENCES `acheteurs` (`id_acheteur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `proposition_enchere`
--
ALTER TABLE `proposition_enchere`
  ADD CONSTRAINT `proposition_enchere_ibfk_1` FOREIGN KEY (`id_acheteur`) REFERENCES `acheteurs` (`id_acheteur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proposition_enchere_ibfk_2` FOREIGN KEY (`id_vendeur`) REFERENCES `vendeurs` (`id_vendeur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `proposition_offre`
--
ALTER TABLE `proposition_offre`
  ADD CONSTRAINT `proposition_offre_ibfk_1` FOREIGN KEY (`id_vendeur`) REFERENCES `vendeurs` (`id_vendeur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proposition_offre_ibfk_2` FOREIGN KEY (`id_acheteur`) REFERENCES `acheteurs` (`id_acheteur`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
