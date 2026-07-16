-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 17 juil. 2026 à 00:40
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `g-pharma`
--

-- --------------------------------------------------------

--
-- Structure de la table `achats`
--

CREATE TABLE `achats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_produit` bigint(20) UNSIGNED NOT NULL,
  `id_fournisseur` bigint(20) UNSIGNED NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL,
  `statut` varchar(255) NOT NULL DEFAULT 'en_attente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `achats`
--

INSERT INTO `achats` (`id`, `id_produit`, `id_fournisseur`, `quantite`, `prix_unitaire`, `statut`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 90, 1230.00, 'receptionne', '2026-07-09 16:27:34', '2026-07-09 16:28:07'),
(2, 6, 1, 60, 2850.00, 'annule', '2026-07-09 16:29:08', '2026-07-09 16:29:14'),
(3, 7, 4, 150, 3480.00, 'receptionne', '2026-07-09 16:35:30', '2026-07-09 16:37:17'),
(4, 5, 7, 70, 1345.00, 'annule', '2026-07-09 16:36:10', '2026-07-09 16:36:32'),
(5, 4, 2, 23, 1234.00, 'receptionne', '2026-07-09 16:37:41', '2026-07-09 16:39:47'),
(6, 3, 5, 150, 2090.00, 'receptionne', '2026-07-09 16:38:07', '2026-07-09 21:32:50'),
(7, 1, 7, 205, 1500.00, 'en_attente', '2026-07-09 16:38:49', '2026-07-09 16:38:49'),
(8, 6, 1, 34, 1543.00, 'receptionne', '2026-07-09 16:39:40', '2026-07-09 16:39:49'),
(9, 7, 5, 95, 1200.00, 'en_attente', '2026-07-16 21:13:26', '2026-07-16 21:13:26');

-- --------------------------------------------------------

--
-- Structure de la table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 1, 'Création de Vente', 'Bineta a créé une nouvelle vente.', '127.0.0.1', '2026-07-16 21:11:23', '2026-07-16 21:11:23'),
(2, 1, 'Création de Vente', 'Bineta a créé une nouvelle vente.', '127.0.0.1', '2026-07-16 21:11:40', '2026-07-16 21:11:40'),
(3, 3, 'Création de Vente', 'Sanou a créé une nouvelle vente.', '127.0.0.1', '2026-07-16 21:20:13', '2026-07-16 21:20:13'),
(4, 1, 'Création de Vente', 'Bineta a créé une nouvelle vente.', '127.0.0.1', '2026-07-16 21:32:04', '2026-07-16 21:32:04'),
(5, 1, 'Création de Vente', 'Bineta a créé une nouvelle vente.', '127.0.0.1', '2026-07-16 21:32:15', '2026-07-16 21:32:15'),
(6, 3, 'Sécurité', 'Sanou a modifié son mot de passe.', '127.0.0.1', '2026-07-16 22:38:28', '2026-07-16 22:38:28');

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `statut` varchar(255) NOT NULL DEFAULT 'actif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `description`, `image`, `statut`, `created_at`, `updated_at`) VALUES
(1, 'Antalgiques', 'Médicaments utilisés pour soulager la douleur, qu\'elle soit légère ou intense.', NULL, 'actif', '2026-07-07 23:18:06', '2026-07-07 23:21:20'),
(2, 'Antibiotiques', 'Médicaments destinés à traiter les infections causées par des bactéries.', NULL, 'actif', '2026-07-07 23:22:51', '2026-07-07 23:22:51'),
(3, 'Anti-inflammatoires', 'Réduisent l\'inflammation, la douleur et parfois la fièvre', NULL, 'inactif', '2026-07-07 23:25:22', '2026-07-08 19:15:00'),
(4, 'Antipyrétiques', 'Servent à faire baisser la fièvre.', NULL, 'actif', '2026-07-07 23:26:36', '2026-07-07 23:26:36'),
(5, 'Antihistaminiques', 'Utilisés pour soulager les symptômes des allergies, comme les démangeaisons ou les éternuements.', NULL, 'actif', '2026-07-07 23:27:27', '2026-07-07 23:27:27'),
(6, 'Antipaludiques', 'Médicaments destinés à prévenir ou traiter le paludisme.', NULL, 'actif', '2026-07-07 23:28:03', '2026-07-07 23:28:03'),
(7, 'Antidiabétiques', 'Aident à contrôler le taux de sucre dans le sang chez les personnes diabétiques.', NULL, 'actif', '2026-07-07 23:28:47', '2026-07-07 23:28:47'),
(9, 'Contraceptifs', 'Médicaments ou dispositifs utilisés pour prévenir une grossesse.', NULL, 'inactif', '2026-07-08 19:33:48', '2026-07-08 19:33:48');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `statut` varchar(255) NOT NULL DEFAULT 'actif',
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `prenom`, `email`, `adresse`, `telephone`, `statut`, `note`, `created_at`, `updated_at`) VALUES
(4, 'Ba', 'Astou Tomate', 'astoutomate@gmail.com', 'Fass, Rue 24, Dakar', '+221 76 899 12 32', 'actif', '\"Bénéficie du Tiers-Payant à 100%\" ou \"Règlement par prise en charge assurance (Gras Savoye, Saham...)\".', '2026-07-10 01:20:02', '2026-07-10 01:20:02'),
(5, 'Diouf', 'Sokhna Mai', 'sokhnamai@gmail.com', 'Point E, Rue 21, Dakar', '+221 78 335 67 45', 'actif', 'Préfère être livré à domicile le samedi matin\".', '2026-07-10 01:33:58', '2026-07-10 01:33:58'),
(7, 'Ndoye', 'Bineta', 'binetandoye@gmail.com', 'Medina, Rue 22, Dakar', NULL, 'actif', 'Allergies connues : \"Allergique à la Pénicilline\" ou \"Intolérance au Lactose', '2026-07-15 21:40:05', '2026-07-15 21:40:05');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

CREATE TABLE `fournisseurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `statut` varchar(255) NOT NULL DEFAULT 'actif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id`, `nom`, `email`, `adresse`, `telephone`, `statut`, `created_at`, `updated_at`) VALUES
(1, 'Grossiste Pharma Plus', 'pharmaplus@gmail.com', 'Rue 10, Dakar, Sénégal', '+221 77 123 45 67', 'actif', '2026-07-08 23:27:20', '2026-07-08 23:30:16'),
(2, 'Médical Distribution Sénégal', 'infomedis@gmail.com', 'Avenue Bourguiba, Dakar', '+221 76 234 56 78', 'actif', '2026-07-08 23:29:29', '2026-07-08 23:29:29'),
(3, 'Pharma Santé Afrique', 'pharmasante@gmail.com', 'Thiès, Sénégal', '+221 78 345 67 89', 'inactif', '2026-07-08 23:32:59', '2026-07-08 23:32:59'),
(4, 'BioMed Supply', 'biomedsupplyt@gmail.sn', 'Mbour, Sénégal', '+221 70 456 78 90', 'actif', '2026-07-08 23:39:18', '2026-07-08 23:39:18'),
(5, 'Sénégal Médicaments SARL', 'senmed@gmail.com', 'Pikine, Dakar', '+221 75 567 89 01', 'actif', '2026-07-08 23:41:32', '2026-07-08 23:41:32'),
(6, 'MediStock Distribution', 'contact@medistock.sn', 'Saint-Louis, Sénégal', '+221 76 890 12 34', 'inactif', '2026-07-08 23:43:04', '2026-07-08 23:43:04'),
(7, 'Global Pharma Services', 'info@globalpharma.sn', 'Kaolack, Sénégal', '+221 70 901 23 45', 'actif', '2026-07-08 23:44:26', '2026-07-08 23:44:26');

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(39, '0001_01_01_000000_create_users_table', 1),
(40, '0001_01_01_000001_create_cache_table', 1),
(41, '0001_01_01_000002_create_jobs_table', 1),
(42, '2026_05_19_180441_add_role_to_users_table', 1),
(43, '2026_06_08_175117_create_categories_table', 1),
(44, '2026_06_08_175200_create_produits_table', 1),
(45, '2026_06_08_175246_create_produits_variants_table', 1),
(46, '2026_06_08_175303_create_stocks_table', 1),
(47, '2026_06_08_175328_create_fournisseurs_table', 1),
(48, '2026_06_08_175357_create_ventes_table', 1),
(49, '2026_06_08_175407_create_achats_table', 1),
(50, '2026_06_08_175454_create_sales_table', 1),
(51, '2026_06_08_175635_create_sale_items_table', 1),
(52, '2026_06_08_175657_create_customers_table', 1),
(53, '2026_06_08_175715_create_paiements_table', 1),
(54, '2026_06_08_175743_create_notifications_table', 1),
(55, '2026_07_08_213546_add_date_peremption_to_produits_table', 2),
(56, '2026_07_09_210638_add_prix_to_produits_table', 3),
(57, '2026_07_09_214810_add_columns_to_ventes_table', 4),
(58, '2026_07_09_215904_create_vente_details_table', 5),
(59, '2026_07_09_221052_add_columns_to_vente_details_table', 6),
(60, '2026_07_09_231844_rename_customers_to_clients_table', 7),
(61, '2026_07_10_005340_add_note_to_clients_table', 8),
(62, '2026_07_10_012413_add_id_client_to_ventes_table', 9),
(63, '2026_07_16_000121_add_status_and_photo_to_users_table', 10),
(64, '2026_07_16_001120_modify_role_column_in_users_table', 11),
(65, '2026_07_16_184135_create_activity_logs_table', 12);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

CREATE TABLE `paiements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_categorie` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prix` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `stock_min` int(11) NOT NULL DEFAULT 0,
  `stock_max` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `date_peremption` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `id_categorie`, `code`, `nom`, `prix`, `description`, `stock_min`, `stock_max`, `image`, `date_peremption`, `created_at`, `updated_at`) VALUES
(1, 2, 'MED-1003', 'Amoxicilline 500 mg', 0, 'Gélules destinées au traitement des infections bactériennes. Boîte de 12 gélules.', 30, 200, 'produits/9C4M8fMhWPQRCq0fwHOD3p9yPXmwXIJDxMW5JPWE.jpg', NULL, '2026-07-08 20:40:35', '2026-07-08 20:51:50'),
(2, 1, 'MED-1004', 'Ibuprofène 400 mg', 1350, 'Comprimés anti-inflammatoires indiqués pour soulager la douleur, l\'inflammation et la fièvre.', 20, 237, 'produits/Z2yxff6tfA9WfGWmEI9QV0yEtxUwTF341sphayvj.jpg', NULL, '2026-07-08 20:42:46', '2026-07-16 21:11:40'),
(3, 6, 'MED-1005', 'Vitamine C 1000 mg', 2500, 'Comprimés effervescents contribuant au renforcement du système immunitaire', 20, 165, 'produits/tOruYsEYdAQJmeUSHvWxk3XKYa1cOxYfYd55scwN.jpg', '2026-07-26', '2026-07-08 20:47:35', '2026-07-16 21:32:15'),
(4, 6, 'MED-1006', 'Sirop Toux Plus', 1495, 'Sirop indiqué pour calmer la toux sèche chez l\'adulte et l\'enfant selon les recommandations.', 10, 44, 'produits/UuLCWm2HCaOMibr3CLKBcBAlcIzTuVPbsCpZ0r71.jpg', '2026-07-23', '2026-07-08 21:00:29', '2026-07-15 21:41:04'),
(5, 5, 'MED-1007', 'Loratadine 10 mg', 1500, 'Comprimés utilisés pour soulager les allergies saisonnières.', 15, 11, 'produits/EE6B7NVD79qpMU22qfH5JKDUWaufEfN172Igwlx3.jpg', NULL, '2026-07-08 21:08:55', '2026-07-15 21:41:04'),
(6, 4, 'MED-1008', 'Oméprazole 20 mg', 3050, 'Gélules réduisant l\'acidité de l\'estomac.', 20, 173, 'produits/DxYovClNGGdOOzUxKEYTYZ0yIK2hjQiKgcHt0GWr.jpg', '2028-11-22', '2026-07-08 21:21:32', '2026-07-16 20:40:38'),
(7, 7, 'MED-1009', 'Metformine 850 mg', 4080, 'Comprimés utilisés dans le traitement du diabète de type 2.', 20, 350, 'produits/TK0CqkdWzQcGQLMvkLxNfnmkhJKLWVhxiQOelbry.jpg', '2026-09-23', '2026-07-08 21:23:44', '2026-07-16 20:40:01'),
(8, 4, 'MED-1013', 'Paracétamol Sirop', 1435, 'Sirop pédiatrique pour réduire la fièvre et soulager la douleur.', 10, 150, 'produits/poNNHe7VOVup7ewT4ZEzdd09LFENvCNiA2wNqGAQ.jpg', '2027-10-23', '2026-07-16 20:39:15', '2026-07-16 20:39:15');

-- --------------------------------------------------------

--
-- Structure de la table `produits_variants`
--

CREATE TABLE `produits_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('KtghvnNhpCYfrahpDsVNF2ndWH9eELweRsl3WOOs', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicFlrSVpjZDhQOHlKRDFLcjljMFRtODB4a3FGRnB2RUpOaDhvYTh5dSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dzIjtzOjU6InJvdXRlIjtzOjEwOiJsb2dzLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1784241546);

-- --------------------------------------------------------

--
-- Structure de la table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `statut` varchar(255) NOT NULL DEFAULT 'actif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `photo`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `statut`) VALUES
(1, 'Bineta', 'admin@gmail.com', 'profile_photos/Egjeov4DdMHjzZQeMnETk3nkr1Dm3BKjwc7UMjY3.jpg', 'admin', NULL, '$2y$12$9q4qvoRmQXYhIMiO56fij.Hf2Kz0D16i9lBSsAqYaLB512r8e6tcO', NULL, '2026-06-08 19:47:07', '2026-07-16 18:03:35', 'actif'),
(2, 'Binette', 'binette@gmail.com', NULL, 'user', NULL, '$2y$12$D8DwI5cBIbwVahfbdwnbyuBiE62hIoxbq8G0uFAKwNmll9oi8f0Lu', NULL, '2026-06-08 19:47:07', '2026-07-16 20:42:05', 'inactif'),
(3, 'Sanou', 'sanou@gmail.com', 'profile_photos/1vRDg7TN9OIXm8L5qtS8QzwrqezfutR3CRdxOneM.jpg', 'manager', NULL, '$2y$12$pGZHKtdhPp8JWf4zKBNlw.k4sciiIc/xcq4MpSWS66luwe6QVhHLG', NULL, '2026-06-08 19:47:08', '2026-07-16 22:38:28', 'actif'),
(4, 'Ndeye Ndiaye', 'ndeyendiaye@gmail.com', NULL, 'vendeur', NULL, '$2y$12$0z13jOyqjOfUnyvRBg9CbuD.q3L1w04cQQaUxa2N1NNDvNW/ByNWC', NULL, '2026-07-16 00:14:12', '2026-07-16 00:15:51', 'inactif');

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

CREATE TABLE `ventes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_client` bigint(20) UNSIGNED DEFAULT NULL,
  `numero_facture` varchar(255) NOT NULL,
  `montant_total` int(11) NOT NULL,
  `montant_recu` int(11) NOT NULL,
  `rendu_monnaie` int(11) NOT NULL,
  `statut` varchar(255) NOT NULL DEFAULT 'complete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ventes`
--

INSERT INTO `ventes` (`id`, `id_client`, `numero_facture`, `montant_total`, `montant_recu`, `rendu_monnaie`, `statut`, `created_at`, `updated_at`) VALUES
(3, NULL, 'FAC-20260709221410', 3850, 5000, 1150, 'complete', '2026-07-09 22:14:10', '2026-07-09 22:14:10'),
(4, NULL, 'FAC-20260710015000', 3995, 5000, 1005, 'annule', '2026-07-10 01:50:00', '2026-07-10 01:59:50'),
(5, NULL, 'FAC-20260710015914', 6495, 10000, 3505, 'complete', '2026-07-10 01:59:14', '2026-07-10 01:59:14'),
(6, NULL, 'FAC-20260710021438', 9545, 10000, 455, 'complete', '2026-07-10 02:14:38', '2026-07-10 02:14:38'),
(7, 7, 'FAC-20260715214104', 7190, 10000, 2810, 'complete', '2026-07-15 21:41:04', '2026-07-15 21:41:04');

-- --------------------------------------------------------

--
-- Structure de la table `vente_details`
--

CREATE TABLE `vente_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_vente` bigint(20) UNSIGNED NOT NULL,
  `id_produit` bigint(20) UNSIGNED NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_unitaire` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `vente_details`
--

INSERT INTO `vente_details` (`id`, `id_vente`, `id_produit`, `quantite`, `prix_unitaire`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 1, 1350, '2026-07-09 22:14:10', '2026-07-09 22:14:10'),
(2, 3, 3, 1, 2500, '2026-07-09 22:14:10', '2026-07-09 22:14:10'),
(3, 4, 3, 1, 2500, '2026-07-10 01:50:00', '2026-07-10 01:50:00'),
(4, 4, 4, 1, 1495, '2026-07-10 01:50:00', '2026-07-10 01:50:00'),
(5, 5, 3, 2, 2500, '2026-07-10 01:59:14', '2026-07-10 01:59:14'),
(6, 5, 4, 1, 1495, '2026-07-10 01:59:14', '2026-07-10 01:59:14'),
(7, 6, 3, 2, 2500, '2026-07-10 02:14:38', '2026-07-10 02:14:38'),
(8, 6, 4, 1, 1495, '2026-07-10 02:14:38', '2026-07-10 02:14:38'),
(9, 6, 6, 1, 3050, '2026-07-10 02:14:38', '2026-07-10 02:14:38'),
(10, 7, 2, 2, 1350, '2026-07-15 21:41:04', '2026-07-15 21:41:04'),
(11, 7, 4, 2, 1495, '2026-07-15 21:41:04', '2026-07-15 21:41:04'),
(12, 7, 5, 1, 1500, '2026-07-15 21:41:04', '2026-07-15 21:41:04');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `achats`
--
ALTER TABLE `achats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `achats_id_produit_foreign` (`id_produit`),
  ADD KEY `achats_id_fournisseur_foreign` (`id_fournisseur`);

--
-- Index pour la table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fournisseurs_email_unique` (`email`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `produits_code_unique` (`code`),
  ADD KEY `produits_id_categorie_foreign` (`id_categorie`);

--
-- Index pour la table `produits_variants`
--
ALTER TABLE `produits_variants`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ventes_numero_facture_unique` (`numero_facture`),
  ADD KEY `ventes_id_client_foreign` (`id_client`);

--
-- Index pour la table `vente_details`
--
ALTER TABLE `vente_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vente_details_id_vente_foreign` (`id_vente`),
  ADD KEY `vente_details_id_produit_foreign` (`id_produit`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `achats`
--
ALTER TABLE `achats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `produits_variants`
--
ALTER TABLE `produits_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `ventes`
--
ALTER TABLE `ventes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `vente_details`
--
ALTER TABLE `vente_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `achats`
--
ALTER TABLE `achats`
  ADD CONSTRAINT `achats_id_fournisseur_foreign` FOREIGN KEY (`id_fournisseur`) REFERENCES `fournisseurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `achats_id_produit_foreign` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produits_id_categorie_foreign` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD CONSTRAINT `ventes_id_client_foreign` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `vente_details`
--
ALTER TABLE `vente_details`
  ADD CONSTRAINT `vente_details_id_produit_foreign` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vente_details_id_vente_foreign` FOREIGN KEY (`id_vente`) REFERENCES `ventes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
