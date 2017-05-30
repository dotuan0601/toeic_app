-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2017 at 09:02 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beau`
--

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

DROP TABLE IF EXISTS `choices`;
CREATE TABLE `choices` (
  `id` int(10) UNSIGNED NOT NULL,
  `test_id` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_correct` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `choices`
--

INSERT INTO `choices` (`id`, `test_id`, `label`, `content`, `is_correct`, `created_at`, `updated_at`) VALUES
(16, 4, 'A', 'aaaa', 0, '2017-05-23 12:00:19', '2017-05-23 12:00:19'),
(17, 4, 'B', 'bbb', 0, '2017-05-23 12:00:20', '2017-05-23 12:00:20'),
(18, 4, 'C', 'cccc', 1, '2017-05-23 12:00:20', '2017-05-23 12:00:20'),
(19, 4, 'D', 'hỏi hỏi hỏi', 0, '2017-05-23 12:00:21', '2017-05-23 12:00:21');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

DROP TABLE IF EXISTS `levels`;
CREATE TABLE `levels` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `min_point` double NOT NULL DEFAULT '0',
  `max_point` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `name`, `min_point`, `max_point`, `created_at`, `updated_at`) VALUES
(1, 'newbie', 0, 49, '2017-05-22 19:07:40', '2017-05-23 08:53:32'),
(3, 'master', 50, 99, '2017-05-22 19:09:20', '2017-05-23 08:53:46');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_01_07_073615_create_tagged_table', 1),
(2, '2014_01_07_073615_create_tags_table', 1),
(3, '2014_10_12_000000_create_users_table', 1),
(4, '2014_10_12_100000_create_password_resets_table', 1),
(5, '2016_06_29_073615_create_tag_groups_table', 1),
(6, '2016_06_29_073615_update_tags_table', 1),
(7, '2017_05_22_170147_create_levels_table', 2),
(11, '2017_05_22_170147_create_choices_table', 3),
(12, '2017_05_23_153641_new_tests_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tagging_tagged`
--

DROP TABLE IF EXISTS `tagging_tagged`;
CREATE TABLE `tagging_tagged` (
  `id` int(10) UNSIGNED NOT NULL,
  `taggable_id` int(10) UNSIGNED NOT NULL,
  `taggable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tagging_tags`
--

DROP TABLE IF EXISTS `tagging_tags`;
CREATE TABLE `tagging_tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `tag_group_id` int(10) UNSIGNED DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `suggest` tinyint(1) NOT NULL DEFAULT '0',
  `count` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tagging_tag_groups`
--

DROP TABLE IF EXISTS `tagging_tag_groups`;
CREATE TABLE `tagging_tag_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

DROP TABLE IF EXISTS `tests`;
CREATE TABLE `tests` (
  `id` int(10) UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_deleted` smallint(6) NOT NULL DEFAULT '0',
  `point` double NOT NULL DEFAULT '0',
  `level_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `question`, `is_deleted`, `point`, `level_name`, `created_at`, `updated_at`) VALUES
(4, 'Q1111', 0, 5, 'newbie', '2017-05-23 11:59:02', '2017-05-23 12:00:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$SWpxv//Jumn2STl3KMPWpOkhoZcIm3OpVRLhGgU2QkbryKNbSa3ti', 'ZIy9DU2YP9lrbTVrEdZieEPd7KLkkM0bUquJbhd0lGoSaH9pSwk2RpQT8rHZ', '2017-05-22 18:43:11', '2017-05-22 18:43:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `choices`
--
ALTER TABLE `choices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `tagging_tagged`
--
ALTER TABLE `tagging_tagged`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tagging_tagged_taggable_id_index` (`taggable_id`),
  ADD KEY `tagging_tagged_taggable_type_index` (`taggable_type`),
  ADD KEY `tagging_tagged_tag_slug_index` (`tag_slug`);

--
-- Indexes for table `tagging_tags`
--
ALTER TABLE `tagging_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tagging_tags_slug_index` (`slug`),
  ADD KEY `tagging_tags_tag_group_id_foreign` (`tag_group_id`);

--
-- Indexes for table `tagging_tag_groups`
--
ALTER TABLE `tagging_tag_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tagging_tag_groups_slug_index` (`slug`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `choices`
--
ALTER TABLE `choices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tagging_tagged`
--
ALTER TABLE `tagging_tagged`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tagging_tags`
--
ALTER TABLE `tagging_tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tagging_tag_groups`
--
ALTER TABLE `tagging_tag_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tagging_tags`
--
ALTER TABLE `tagging_tags`
  ADD CONSTRAINT `tagging_tags_tag_group_id_foreign` FOREIGN KEY (`tag_group_id`) REFERENCES `tagging_tag_groups` (`id`);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
