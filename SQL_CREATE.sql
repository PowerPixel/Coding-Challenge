CREATE TABLE `challenge` (
  `id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `composed` (
  `id` int(11) NOT NULL,
  `challenge` int(11) NOT NULL,
  `points_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `composed_exercise` (
  `composed_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `constrained` (
  `id` int(11) NOT NULL,
  `challenge` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `constrained_language` (
  `constrained_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `exercise` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `exercisestate` int(11) NOT NULL,
  `difficulty` int(11) NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `submit_date` datetime NOT NULL,
  `approved_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `exercise_state` (
  `id` int(11) NOT NULL,
  `label` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `participate` (
  `id` int(11) NOT NULL,
  `user_points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `participate_challenge` (
  `participate_id` int(11) NOT NULL,
  `challenge_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `participate_user` (
  `participate_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `restricted` (
  `id` int(11) NOT NULL,
  `exercise` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `restricted_language` (
  `restricted_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `solving` (
  `id` int(11) NOT NULL,
  `completed_test_amount` int(11) NOT NULL,
  `last_submitted_code` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `solving_exercise` (
  `solving_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `solving_user` (
  `solving_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL,
  `api_key` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour la table `challenge`
--
ALTER TABLE `challenge`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `composed`
--
ALTER TABLE `composed`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_6CA7B389D7098951` (`challenge`);

--
-- Index pour la table `composed_exercise`
--
ALTER TABLE `composed_exercise`
  ADD PRIMARY KEY (`composed_id`,`exercise_id`),
  ADD KEY `IDX_EFAFD5EDFFF2E63` (`composed_id`),
  ADD KEY `IDX_EFAFD5EDE934951A` (`exercise_id`);

--
-- Index pour la table `constrained`
--
ALTER TABLE `constrained`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_988EB062D7098951` (`challenge`);

--
-- Index pour la table `constrained_language`
--
ALTER TABLE `constrained_language`
  ADD PRIMARY KEY (`constrained_id`,`language_id`),
  ADD KEY `IDX_77644ED1C3D7DA79` (`constrained_id`),
  ADD KEY `IDX_77644ED182F1BAF4` (`language_id`);

--
-- Index pour la table `exercise`
--
ALTER TABLE `exercise`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AEDAD51C8D93D649` (`user`),
  ADD KEY `IDX_AEDAD51CA793C052` (`exercisestate`);

--
-- Index pour la table `exercise_state`
--
ALTER TABLE `exercise_state`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `participate`
--
ALTER TABLE `participate`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `participate_challenge`
--
ALTER TABLE `participate_challenge`
  ADD PRIMARY KEY (`participate_id`,`challenge_id`),
  ADD KEY `IDX_9D5C58E35FE98FC0` (`participate_id`),
  ADD KEY `IDX_9D5C58E398A21AC6` (`challenge_id`);

--
-- Index pour la table `participate_user`
--
ALTER TABLE `participate_user`
  ADD PRIMARY KEY (`participate_id`,`user_id`),
  ADD KEY `IDX_5203D6C95FE98FC0` (`participate_id`),
  ADD KEY `IDX_5203D6C9A76ED395` (`user_id`);

--
-- Index pour la table `restricted`
--
ALTER TABLE `restricted`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C7CC8047AEDAD51C` (`exercise`);

--
-- Index pour la table `restricted_language`
--
ALTER TABLE `restricted_language`
  ADD PRIMARY KEY (`restricted_id`,`language_id`),
  ADD KEY `IDX_14830432BAC54862` (`restricted_id`),
  ADD KEY `IDX_1483043282F1BAF4` (`language_id`);

--
-- Index pour la table `solving`
--
ALTER TABLE `solving`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `solving_exercise`
--
ALTER TABLE `solving_exercise`
  ADD PRIMARY KEY (`solving_id`,`exercise_id`),
  ADD KEY `IDX_52EB07E143DA0C5B` (`solving_id`),
  ADD KEY `IDX_52EB07E1E934951A` (`exercise_id`);

--
-- Index pour la table `solving_user`
--
ALTER TABLE `solving_user`
  ADD PRIMARY KEY (`solving_id`,`user_id`),
  ADD KEY `IDX_B4074BB143DA0C5B` (`solving_id`),
  ADD KEY `IDX_B4074BB1A76ED395` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_8D93D649C912ED9D` (`api_key`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `challenge`
--
ALTER TABLE `challenge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `composed`
--
ALTER TABLE `composed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `constrained`
--
ALTER TABLE `constrained`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `exercise`
--
ALTER TABLE `exercise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `exercise_state`
--
ALTER TABLE `exercise_state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `participate`
--
ALTER TABLE `participate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `restricted`
--
ALTER TABLE `restricted`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `solving`
--
ALTER TABLE `solving`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `composed`
--
ALTER TABLE `composed`
  ADD CONSTRAINT `FK_6CA7B389D7098951` FOREIGN KEY (`challenge`) REFERENCES `challenge` (`id`);

--
-- Contraintes pour la table `composed_exercise`
--
ALTER TABLE `composed_exercise`
  ADD CONSTRAINT `FK_EFAFD5EDE934951A` FOREIGN KEY (`exercise_id`) REFERENCES `exercise` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EFAFD5EDFFF2E63` FOREIGN KEY (`composed_id`) REFERENCES `composed` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `constrained`
--
ALTER TABLE `constrained`
  ADD CONSTRAINT `FK_988EB062D7098951` FOREIGN KEY (`challenge`) REFERENCES `challenge` (`id`);

--
-- Contraintes pour la table `constrained_language`
--
ALTER TABLE `constrained_language`
  ADD CONSTRAINT `FK_77644ED182F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_77644ED1C3D7DA79` FOREIGN KEY (`constrained_id`) REFERENCES `constrained` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `exercise`
--
ALTER TABLE `exercise`
  ADD CONSTRAINT `FK_AEDAD51C8D93D649` FOREIGN KEY (`user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_AEDAD51CA793C052` FOREIGN KEY (`exercisestate`) REFERENCES `exercise_state` (`id`);

--
-- Contraintes pour la table `participate_challenge`
--
ALTER TABLE `participate_challenge`
  ADD CONSTRAINT `FK_9D5C58E35FE98FC0` FOREIGN KEY (`participate_id`) REFERENCES `participate` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_9D5C58E398A21AC6` FOREIGN KEY (`challenge_id`) REFERENCES `challenge` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `participate_user`
--
ALTER TABLE `participate_user`
  ADD CONSTRAINT `FK_5203D6C95FE98FC0` FOREIGN KEY (`participate_id`) REFERENCES `participate` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_5203D6C9A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `restricted`
--
ALTER TABLE `restricted`
  ADD CONSTRAINT `FK_C7CC8047AEDAD51C` FOREIGN KEY (`exercise`) REFERENCES `exercise` (`id`);

--
-- Contraintes pour la table `restricted_language`
--
ALTER TABLE `restricted_language`
  ADD CONSTRAINT `FK_1483043282F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_14830432BAC54862` FOREIGN KEY (`restricted_id`) REFERENCES `restricted` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `solving_exercise`
--
ALTER TABLE `solving_exercise`
  ADD CONSTRAINT `FK_52EB07E143DA0C5B` FOREIGN KEY (`solving_id`) REFERENCES `solving` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_52EB07E1E934951A` FOREIGN KEY (`exercise_id`) REFERENCES `exercise` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `solving_user`
--
ALTER TABLE `solving_user`
  ADD CONSTRAINT `FK_B4074BB143DA0C5B` FOREIGN KEY (`solving_id`) REFERENCES `solving` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B4074BB1A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;