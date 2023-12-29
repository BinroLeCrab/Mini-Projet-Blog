-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 29 déc. 2023 à 10:50
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tp_mini_projet_blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `billets`
--

DROP TABLE IF EXISTS `billets`;
CREATE TABLE IF NOT EXISTS `billets` (
  `id_billet` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `titre_billet` varchar(255) NOT NULL,
  `content_billet` text NOT NULL,
  `pitch` varchar(1000) NOT NULL,
  PRIMARY KEY (`id_billet`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `billets`
--

INSERT INTO `billets` (`id_billet`, `id_user`, `date`, `titre_billet`, `content_billet`, `pitch`) VALUES
(1, 1, '2023-12-19 13:50:06', "✅c\'est un test", 'Petit billet pour test ce que ça donne.\r\n\r\nOn teste des truc, \r\ndes retours à la lignes\r\n\r\n\r\nA voir si ça passe nickel.', '1er test'),
(2, 1, '2023-12-19 13:58:15', 'Test 2', 'Hop un deuxième billets !', 'Test 2'),
(14, 1, '2023-12-26 17:43:29', 'Billet 3', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.</p>', 'Le billet numéros 3'),
(15, 1, '2023-12-26 17:43:42', 'Billet 4', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.</p>', 'Le billet numéros 4');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
  `id_comment` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_billet` int NOT NULL,
  `date_comment` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content_comment` text NOT NULL,
  PRIMARY KEY (`id_comment`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id_comment`, `id_user`, `id_billet`, `date_comment`, `content_comment`) VALUES
(1, 1, 1, '2023-12-20 17:34:45', 'coucou'),
(2, 1, 1, '2023-12-20 17:36:47', 'test 2'),
(24, 1, 15, '2023-12-26 18:33:15', 'test'),
(8, 1, 1, '2023-12-20 17:40:58', 'dfsgsd'),
(7, 1, 1, '2023-12-20 17:40:55', 'fgsdds'),
(9, 1, 1, '2023-12-20 17:42:28', 'dfgvsfsw');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(30) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `motpass` varchar(255) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `autority` int NOT NULL DEFAULT '255',
  PRIMARY KEY (`id`,`login`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `mail`, `motpass`, `nom`, `autority`) VALUES
(1, 'RobRob', 'rob.vigier@gmail.com', '$2y$10$GIzUdwM2T02uFQk9fFabF.N61Z0Yn.xtH4JltCalV.KuqFmI1n7hy', 'Robin', 317),
(2, 'Admin', 'admindublog@gmail.com', '$2y$10$mImekxMStlFeW4KyTmzv1OGtyVIGCuLRk1R3LX6l7lkskSW2NlOwe', 'Propriétaire', 317),
(3, 'toto', 'toto@gmail.com', '$2y$10$URZ8.RsGyrOGpIS90pzA1.UlaYVzO7Yg7RfAOXzdIcrtjPvD7P7PK', 'Thomas', 255),
(4, 'Cyp', 'cyp@gmail.com', '$2y$10$IksFvPXcFKZhpvhZsBy52O2zDLj071C.bW3AIOu/RbxaxlrHLkkXa', 'CypCyp', 255);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
