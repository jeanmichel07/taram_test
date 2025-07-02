-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 02 juil. 2025 à 21:55
-- Version du serveur : 5.7.14
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_taram`
--

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `selling_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `purchase_price`, `created_at`, `updated_at`, `selling_price`) VALUES
(2, 'Produit A', 'Description du produit A', '55.65', '2025-07-02 10:02:30', '2025-07-02 10:02:30', '60.00'),
(3, 'Produit B', 'Description du Produit B', '53.23', '2025-07-02 10:03:41', '2025-07-02 10:03:41', '60.00'),
(4, 'Produit C', 'Description Produit C', '40.50', '2025-07-02 10:41:19', '2025-07-02 10:41:19', '50.00'),
(5, 'Produit D', 'Description Produit D', '10.00', '2025-07-02 10:42:48', '2025-07-02 10:42:48', '17.00'),
(6, 'Produit E', 'Description Produit E', '25.75', '2025-07-02 10:43:48', '2025-07-02 10:43:48', '30.00'),
(7, 'Product 1', 'Description pour Produit 1', '50.00', '2025-07-02 21:29:58', '2025-07-02 21:29:58', '57.00'),
(8, 'Product 2', 'Description pour Produit 2', '46.00', '2025-07-02 21:29:58', '2025-07-02 21:29:58', '54.00'),
(9, 'Product 3', 'Description pour Produit 3', '59.00', '2025-07-02 21:29:58', '2025-07-02 21:29:58', '67.00'),
(10, 'Product 4', 'Description pour Produit 4', '46.00', '2025-07-02 21:29:58', '2025-07-02 21:29:58', '53.00'),
(11, 'Product 5', 'Description pour Produit 5', '14.00', '2025-07-02 21:29:58', '2025-07-02 21:29:58', '23.00');

-- --------------------------------------------------------

--
-- Structure de la table `product_purchase`
--

CREATE TABLE `product_purchase` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product_purchase`
--

INSERT INTO `product_purchase` (`id`, `purchase_id`, `product_id`, `quantity`, `unit_price`, `created_at`) VALUES
(1, 1, 2, 10, '55.00', '2025-07-02 10:13:49'),
(2, 1, 3, 20, '53.00', '2025-07-02 10:13:49'),
(3, 1, 4, 15, '40.00', '2025-07-02 10:13:49'),
(4, 1, 5, 30, '10.00', '2025-07-02 10:13:49'),
(5, 1, 6, 15, '25.00', '2025-07-02 10:13:49'),
(6, 2, 2, 10, '55.00', '2025-07-02 10:57:34'),
(7, 2, 3, 20, '53.00', '2025-07-02 10:57:34'),
(8, 2, 4, 15, '40.00', '2025-07-02 10:57:34'),
(9, 2, 5, 30, '10.00', '2025-07-02 10:57:34'),
(10, 2, 6, 15, '25.00', '2025-07-02 10:57:34'),
(11, 3, 2, 10, '55.00', '2025-07-02 19:24:29'),
(12, 3, 3, 20, '53.00', '2025-07-02 19:24:29'),
(13, 3, 4, 15, '40.00', '2025-07-02 19:24:29'),
(14, 3, 5, 30, '10.00', '2025-07-02 19:24:29'),
(15, 3, 6, 15, '25.00', '2025-07-02 19:24:29'),
(16, 4, 2, 10, '55.00', '2025-07-02 21:42:15'),
(17, 4, 3, 10, '53.00', '2025-07-02 21:42:15'),
(18, 4, 4, 10, '40.00', '2025-07-02 21:42:15'),
(19, 4, 5, 10, '10.00', '2025-07-02 21:42:15'),
(20, 4, 6, 10, '25.00', '2025-07-02 21:42:15'),
(21, 4, 7, 10, '50.00', '2025-07-02 21:42:15'),
(22, 4, 8, 10, '46.00', '2025-07-02 21:42:15'),
(23, 4, 9, 10, '59.00', '2025-07-02 21:42:15'),
(24, 4, 10, 10, '46.00', '2025-07-02 21:42:15'),
(25, 4, 11, 10, '14.00', '2025-07-02 21:42:15');

-- --------------------------------------------------------

--
-- Structure de la table `provider`
--

CREATE TABLE `provider` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `provider`
--

INSERT INTO `provider` (`id`, `name`, `address`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Jean Michel RAJAOSON', 'Amboaroy', '0328782507', 'tombokely@gmail.com', '2025-07-01 15:21:44', NULL),
(2, 'Fournisseur 1', 'Address18', '0321250266', 'fournisseur1@email.test', '2025-07-02 21:29:58', '2025-07-02 21:29:58'),
(3, 'Fournisseur 2', 'Address6', '0332720584', 'fournisseur2@email.test', '2025-07-02 21:29:58', '2025-07-02 21:29:58'),
(4, 'Fournisseur 3', 'Address19', '0322963708', 'fournisseur3@email.test', '2025-07-02 21:29:58', '2025-07-02 21:29:58'),
(5, 'Fournisseur 4', 'Address15', '034731713', 'fournisseur4@email.test', '2025-07-02 21:29:58', '2025-07-02 21:29:58'),
(6, 'Fournisseur 5', 'Address6', '0342334159', 'fournisseur5@email.test', '2025-07-02 21:29:58', '2025-07-02 21:29:58');

-- --------------------------------------------------------

--
-- Structure de la table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `provider_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `purchase`
--

INSERT INTO `purchase` (`id`, `provider_id`, `total_amount`, `created_at`, `updated_at`) VALUES
(1, 1, '2913.00', '2025-07-02 10:13:49', '2025-07-02 10:13:49'),
(2, 2, '2913.00', '2025-07-02 10:57:34', '2025-07-02 10:57:34'),
(3, 3, '2913.00', '2025-07-02 19:24:29', '2025-07-02 19:24:29'),
(4, 3, '4000.00', '2025-07-02 21:42:15', '2025-07-02 21:42:15');

-- --------------------------------------------------------

--
-- Structure de la table `purchase_condition`
--

CREATE TABLE `purchase_condition` (
  `id` int(11) NOT NULL,
  `provider_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `delivery_time` int(11) NOT NULL,
  `min_quantity` int(11) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `purchase_condition`
--

INSERT INTO `purchase_condition` (`id`, `provider_id`, `product_id`, `price`, `delivery_time`, `min_quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '20.00', 4, 10, '2025-07-02 20:40:50', '2025-07-02 20:40:50');

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 2, 45, '2025-07-02 10:02:30', '2025-07-02 21:42:15'),
(2, 3, 80, '2025-07-02 10:03:41', '2025-07-02 21:42:15'),
(3, 4, 45, '2025-07-02 10:41:20', '2025-07-02 21:42:15'),
(4, 5, 75, '2025-07-02 10:42:48', '2025-07-02 21:42:15'),
(5, 6, 45, '2025-07-02 10:43:49', '2025-07-02 21:42:15'),
(6, 7, 10, '2025-07-02 21:42:15', '2025-07-02 21:42:15'),
(7, 8, 10, '2025-07-02 21:42:15', '2025-07-02 21:42:15'),
(8, 9, 10, '2025-07-02 21:42:15', '2025-07-02 21:42:15'),
(9, 10, 10, '2025-07-02 21:42:15', '2025-07-02 21:42:15'),
(10, 11, 10, '2025-07-02 21:42:15', '2025-07-02 21:42:15');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`) VALUES
(1, 'admin25', '[\"ROLE_ADMIN\"]', '$2y$13$QVN0Z3HEhTjyUKKV.MVptOzUEakTAJot4PX0k3hKvD9CBewYLMSMC');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `product_purchase`
--
ALTER TABLE `product_purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AAA7BBAC558FBEB9` (`purchase_id`),
  ADD KEY `IDX_AAA7BBAC4584665A` (`product_id`);

--
-- Index pour la table `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6117D13BA53A8AA` (`provider_id`);

--
-- Index pour la table `purchase_condition`
--
ALTER TABLE `purchase_condition`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_389A7A88A53A8AA` (`provider_id`),
  ADD KEY `IDX_389A7A884584665A` (`product_id`);

--
-- Index pour la table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4B3656604584665A` (`product_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_USERNAME` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `product_purchase`
--
ALTER TABLE `product_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `provider`
--
ALTER TABLE `provider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `purchase_condition`
--
ALTER TABLE `purchase_condition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `product_purchase`
--
ALTER TABLE `product_purchase`
  ADD CONSTRAINT `FK_AAA7BBAC4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_AAA7BBAC558FBEB9` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`id`);

--
-- Contraintes pour la table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `FK_6117D13BA53A8AA` FOREIGN KEY (`provider_id`) REFERENCES `provider` (`id`);

--
-- Contraintes pour la table `purchase_condition`
--
ALTER TABLE `purchase_condition`
  ADD CONSTRAINT `FK_389A7A884584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_389A7A88A53A8AA` FOREIGN KEY (`provider_id`) REFERENCES `provider` (`id`);

--
-- Contraintes pour la table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `FK_4B3656604584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
