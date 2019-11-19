-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 19 nov. 2019 à 09:02
-- Version du serveur :  10.4.6-MariaDB
-- Version de PHP :  7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `snowtricks`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `trick_id`, `user_id`, `content`, `created_at`) VALUES
(7, 500, 290, 'autre commentaire', '2019-10-05 08:18:09'),
(8, 500, 290, 'bonjour', '2019-10-05 08:19:34'),
(30, 535, 290, 'etsght', '2019-10-28 15:57:31'),
(31, 535, 290, 't rshdt', '2019-10-28 15:57:34'),
(32, 535, 290, 'ttttttt', '2019-10-28 15:57:39'),
(33, 535, 290, 'uyfgjuyfgju', '2019-10-28 16:00:25'),
(37, 535, 290, 'hello world', '2019-10-29 16:01:16'),
(38, 536, 290, 'Yea genial ce trick !!!!', '2019-10-29 16:04:02'),
(39, 536, 290, 'DFFEZDFEZQF', '2019-10-29 16:04:22'),
(40, 536, 290, 'FZEFZF', '2019-10-29 16:04:26'),
(41, 536, 290, 'SDSFrthrh\r\ntrhrthrth', '2019-10-29 16:04:37'),
(42, 536, 290, 'rthtrhtdrtdtdtdxtsthsth  htsgrh rest h sd er', '2019-10-29 16:04:45'),
(43, 536, 290, 'tht  tsh th th th ht h  t tq  ere', '2019-10-29 16:04:53'),
(44, 536, 290, 'hgtrsh tstrh s htr  ths htr-', '2019-10-29 16:04:59'),
(45, 536, 290, 'rt rh rth hrdsx ht', '2019-10-29 16:05:13'),
(46, 536, 290, 'trshh sh rth hrt h rt h', '2019-10-29 16:05:23'),
(47, 536, 290, 'hrtsh th  sr t hrtsr hsth s', '2019-10-29 16:05:28'),
(48, 536, 290, 'h srhsr th h trh rht', '2019-10-29 16:05:34'),
(49, 536, 290, 'trhrt h  rth', '2019-10-29 16:05:40'),
(50, 536, 290, 'ju\'gbruif greui gurgeuifg ruiefg', '2019-10-30 15:00:20'),
(51, 536, 290, 'reqsgrg youpi', '2019-10-30 15:41:18'),
(52, 536, 290, '<script>alert(\'test\');</script>', '2019-10-30 16:00:17'),
(53, 536, 290, '<script>alert(\'test\');</script>', '2019-10-30 16:00:33'),
(75, 545, 334, 'oihjl;iojloi', '2019-11-11 10:17:53'),
(76, 500, 290, 'hjghufv', '2019-11-18 14:04:32');

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id`, `trick_id`, `url`, `title`) VALUES
(222, 500, 'https://lorempixel.com/640/480/?32267', 'Ab repudiandae adipisci excepturi pariatur veniam repellendus et.'),
(263, 515, 'https://lorempixel.com/640/480/?87229', 'Veritatis distinctio nihil aliquid officiis reiciendis.'),
(264, 515, 'https://lorempixel.com/640/480/?35835', 'Ea molestiae dignissimos ut quia officiis enim ea.'),
(265, 515, 'https://lorempixel.com/640/480/?97478', 'Distinctio qui non recusandae dignissimos.'),
(266, 515, 'https://lorempixel.com/640/480/?42507', 'Velit repellat voluptatibus nihil.'),
(284, 521, 'https://lorempixel.com/640/480/?40736', 'Dicta qui reprehenderit sed voluptas temporibus sit officiis accusantium.'),
(285, 521, 'https://lorempixel.com/640/480/?73244', 'Autem eos maxime ea.'),
(370, 535, '5db6f66954f90.jpeg', 'yopla'),
(371, 535, '5db6f67d1a115.jpeg', 'yopla'),
(372, 536, '5db854d785154.jpeg', 'oijlihguyio'),
(383, 536, '5db96d5c7f43b.jpeg', 'oijlihguyio'),
(393, 535, '5dbc027514cc3.jpeg', 'ftghdftghuyjt');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20190826144903', '2019-08-30 12:12:58'),
('20190826145724', '2019-08-30 12:12:59'),
('20190827113846', '2019-08-30 12:12:59'),
('20190827124431', '2019-08-30 12:13:02'),
('20190902102630', '2019-09-02 10:26:46'),
('20190902120932', '2019-09-02 12:10:21'),
('20190902121131', '2019-09-02 12:11:43'),
('20190902141932', '2019-09-02 14:19:53'),
('20190902151745', '2019-09-02 15:18:04'),
('20191014093020', '2019-10-14 09:30:46'),
('20191014093336', '2019-10-14 09:33:44'),
('20191028151618', '2019-10-28 15:18:18'),
('20191028155229', '2019-10-28 15:52:37'),
('20191030162001', '2019-10-30 16:21:03'),
('20191101112325', '2019-11-01 11:26:17'),
('20191111090839', '2019-11-11 09:12:13'),
('20191111095513', '2019-11-11 09:55:42');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `title`) VALUES
(1, 'ROLE_ADMIN');

-- --------------------------------------------------------

--
-- Structure de la table `role_user`
--

CREATE TABLE `role_user` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`) VALUES
(1, 290);

-- --------------------------------------------------------

--
-- Structure de la table `trick`
--

CREATE TABLE `trick` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variety_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick`
--

INSERT INTO `trick` (`id`, `titre`, `description`, `slug`, `author_id`, `created_at`, `modified_at`, `cover_image`, `variety_id`) VALUES
(500, 'Aut necessitatibus.', 'Et earum quia saepe vitae eum. Nostrum enim nulla eaque asperiores. Illo vero sit expedita mollitia dolores. Rerum perferendis sit eligendi aut veritatis. Et reprehenderit incidunt aut quia. Exercitationem dolor repudiandae exercitationem quam labore quae. Eaque sit occaecati odit deserunt molestias. Autem et non voluptas labore id delectus voluptatum.', 'aut-necessitatibus.', 290, '1982-12-29 20:39:35', NULL, '', 1),
(515, 'Nihil aut ut.', 'Aliquam eius culpa et sint ex dolore nam. Optio dicta molestias qui iste repellendus nesciunt sed. Aut repudiandae deleniti neque autem cumque. Aut animi quis soluta aut. Sed quod autem dolorem laudantium quae. Architecto rerum consequatur suscipit excepturi esse officia. Nemo provident ex maxime omnis esse. Qui in incidunt ut praesentium sed quisquam. Similique quos debitis enim quos voluptas mollitia occaecati. Non numquam maiores quia aut. Magni eaque consequatur nisi explicabo aut numquam.', 'nihil-aut-ut.', 320, '2001-04-06 07:18:37', NULL, '', 1),
(521, 'Hic quaerat voluptate.', 'Recusandae provident aperiam labore consequatur ut.', 'hic-quaerat-voluptate.', 320, '1994-02-26 02:43:20', NULL, '', 1),
(535, 'new trick yts g', 'Le lorem ipsum (également appelé faux-texte, lipsum, ou bolo bolo) est, en imprimerie, une suite de mots sans signification utilisée à titre provisoire pour calibrer une mise en page, le texte définitif venant remplacer le faux-texte dès qu\'il...', 'new-trick-yts-g', 290, '2019-10-28 10:16:38', '2019-10-28 15:39:05', '5db6f59bc2d12.jpeg', 1),
(536, 'new trickuj r yuyj ut yyk ,', 'jguhk,jf, guh g,kfgkrffh krht fk ur cfrtuhjkuh ,kyuhj,ftryj,uyj fruy j, ,unuy fj, jguhk,jf, guh g,kfgkrffh krht fk ur cfrtuhjkuh ,kyuhj,ftryj,uyj fruy j, ,unuy fj, jguhk,jf, guh g,kfgkrffh krht fk ur cfrtuhjkuh ,kyuhj,ftryj,uyj fruy j, ,unuy fj, jguhk,jf, guh g,kfgkrffh krht fk ur cfrtuhjkuh ,kyuhj,ftryj,uyj fruy j, ,unuy fj, jguhk,jf, guh g,kfgkrffh krht fk ur cfrtuhjkuh ,kyuhj,ftryj,uyj fruy j, ,unuy fj,', 'new-trickuj-r-yuyj-ut-yyk-,', 290, '2019-10-28 15:30:00', '2019-11-03 11:36:30', '5db7097857463.jpeg', 2),
(543, 'Switch-stance and fakie', 'The terms switch-stance (switch) and fakie are often used interchangeably in snowboarding, though there is a distinct difference. The switch identifier refers to any trick that a snowboarder performs with their back foot forward, or the reverse of their natural stance. A snowboarder can also be said to be riding switch while traveling opposite from their natural stance when no trick is being performed. At this time, the leading tip of their board is referred to as the nose.\r\n\r\nAlternatively, the identifier fakie has its origin in skateboarding, a discipline where the feet are not attached to the board, but where the skateboarder\'s natural stance includes positioning the trailing foot on the kicked tail of the skateboard. On a skateboard, fakie refers to an instance where the skateboarder is traveling backward, but their feet remain in the same position on the skateboard as their natural stance.\r\n\r\nSnowboarders will distinguish between fakie and switch, even though their feet never change position on the snowboard. The term switch is far more common when describing snowboard tricks, and a switch trick is any trick that is initiated switch-stance. Landing switch means that the snowboarder has landed with their back foot forwards.\r\n\r\nThe term fakie will sometimes refer to landing a trick or maneuver performed on a skateboard. An air-to-fakie, for instance, would be a straight air on a vertical feature with no rotation, and re-entering the same transition. The rider would land fakie and would, therefore, be riding switch. Another common way that the term fakie is used is when the identifier switch creates a redundant description. For example, much like skateboarding\'s conventions, a snowboarder would say fakie ollie, rather than switch nollie.', 'switch-stance-and-fakie', 290, '2019-11-11 09:23:29', NULL, '5dc92891807bc.jpeg', 1),
(544, 'Goofy cool', 'Rides with right foot forward in natural stance.[1]\r\n\r\nIdentifying whether a snowboarder is a regular stance or goofy stance rider is important to determine which trick is being performed. For example, if the rider enters a jump with left foot leading and performs one-and-a-half revolutions in the counterclockwise direction, the trick is known as a frontside 540 for a regular rider, and a cab 540 (or switch frontside 540) for a goofy rider.', 'goofy-cool', 290, '2019-11-11 09:24:04', '2019-11-18 14:02:32', '5dc928b455e6c.jpeg', 1),
(545, 'Switch-stance', 'a fafaqez fa\"f \'efzerf r\"faqrefzerfez ff v er cer fv,a fafaqez fa\"f \'efzerf r\"faqrefzerfez ff v er cer fva fafaqez fa\"f \'efzerf r\"faqrefzerfez ff v er cer fva fafaqez fa\"f \'efzerf r\"faqrefzerfez ff v er cer fva fafaqez fa\"f \'efzerf r\"faqrefzerfez ff v er cer fv', 'switch-stance', 334, '2019-11-11 10:17:46', NULL, NULL, 1),
(546, 'Test nouveau trickf f f', 'zfzefzef zf zfz zef zfe z f ezf ezfze ez', 'test-nouveau-trickf-f-f', 290, '2019-11-18 14:01:41', '2019-11-18 14:01:58', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid` int(11) NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `valid`, `token`, `created_at`) VALUES
(290, 'Aurelien', 'Bichotte', 'linux.aurelien@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$WE80ZFNzai5QVnFyay8yaA$2Y8/aa0JSd5a7KA1S8r5EhuNhEPsSS6IvPxBWj/+auU', 1, 'e37becca8a7eef521055c5f0d16f2d1d', '0000-00-00 00:00:00'),
(320, 'Amya', 'Romaguera', 'felix.ondricka@yahoo.com', '$argon2id$v=19$m=65536,t=4,p=1$dHpsbVNPVi5XNU8zZldRYQ$VcR4FZSry//K5wC1PnNFXwfTgb13N2nMqv1xApQpN2o', 1, 'cb32b2e7d172a8c48b212b05a792eaaf', '0000-00-00 00:00:00'),
(326, 'Baker', 'Raphaëlle', 'raph_baker@hotmail.com', '$argon2id$v=19$m=65536,t=4,p=1$cXVNL3FiUklnV3c1SXVjcw$bCsiWPm/mJE5AyoHcEo40GCYhA1tYh9jKEpeEyt7mhs', 1, '6599ec29526c7f61f98c2670748fc2d1', '0000-00-00 00:00:00'),
(331, 'ovh', 'ovhmail', 'aurelien.bichotte@aurelien-bichotte.fr', '$argon2id$v=19$m=65536,t=4,p=1$MU1MbGt6bmZuQ241Q24uWA$wcHh3ICT+66f4oZbYJtGtFj0IFEFBN3MnFKnl2DIsKM', 1, '$2y$10$fY66d3VRujA8RCnTKQWxROGY2ZjKr1M.Lm/EIiIzJIAuQOYtLlOOy', '0000-00-00 00:00:00'),
(334, 'maxime', 'ovhmail', 'aurel.bichop@laposte.net', '$argon2id$v=19$m=65536,t=4,p=1$SWVURGQ5MUxkZ1FyL1hNLw$GAPRju4XO5+oPyYDKU4okkzNE03XfqKVqBfxyJwCt5w', 1, '$2y$10$a/5ZkZvShaMZdDaWgnJn7eAkc9ol9tvq4jR.aqdRYWtgxQvP/wYsi', '2019-11-11 10:12:58');

-- --------------------------------------------------------

--
-- Structure de la table `variety`
--

CREATE TABLE `variety` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `variety`
--

INSERT INTO `variety` (`id`, `title`) VALUES
(1, 'categorie1'),
(2, 'categorie2');

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`id`, `trick_id`, `title`, `url`) VALUES
(136, 536, 'youtube', 'https://www.youtube.com/embed/1CH68gBGHOk'),
(142, 536, 'daily', 'https://www.dailymotion.com/embed/video/x7n9l3m'),
(144, 536, 'youtube', 'https://www.youtube.com/embed/NRq0i6hw9Eo'),
(148, 536, 'daily', 'https://www.youtube.com/embed/sgelWahGKYM'),
(153, 535, 'daily', 'https://www.dailymotion.com/embed/video/x7m3ksg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526CB281BE2E` (`trick_id`),
  ADD KEY `IDX_9474526CA76ED395` (`user_id`);

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C53D045FB281BE2E` (`trick_id`);

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`role_id`,`user_id`),
  ADD KEY `IDX_332CA4DDD60322AC` (`role_id`),
  ADD KEY `IDX_332CA4DDA76ED395` (`user_id`);

--
-- Index pour la table `trick`
--
ALTER TABLE `trick`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D8F0A91EF675F31B` (`author_id`),
  ADD KEY `IDX_D8F0A91E78C2BC47` (`variety_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `variety`
--
ALTER TABLE `variety`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CC7DA2CB281BE2E` (`trick_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=394;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `trick`
--
ALTER TABLE `trick`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=547;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=335;

--
-- AUTO_INCREMENT pour la table `variety`
--
ALTER TABLE `variety`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_9474526CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_C53D045FB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `FK_332CA4DDA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_332CA4DDD60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `trick`
--
ALTER TABLE `trick`
  ADD CONSTRAINT `FK_D8F0A91E78C2BC47` FOREIGN KEY (`variety_id`) REFERENCES `variety` (`id`),
  ADD CONSTRAINT `FK_D8F0A91EF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `FK_7CC7DA2CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
