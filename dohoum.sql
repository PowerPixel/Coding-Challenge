CREATE TABLE `challenge` (
  `id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `challenge` (`id`, `start_date`, `end_date`) VALUES
(1, '2020-12-01 00:00:00', '2020-12-31 23:59:59'),
(2, '2021-01-01 00:00:00', '2021-12-31 23:59:59'),
(3, '2021-05-14 07:27:27', '2021-07-02 23:42:35');

CREATE TABLE `composed` (
  `id` int(11) NOT NULL,
  `challenge` int(11) NOT NULL,
  `points_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `composed` (`id`, `challenge`, `points_amount`) VALUES
(1, 1, 0),
(2, 2, 0),
(3, 3, 0);

CREATE TABLE `composed_exercise` (
  `composed_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `composed_exercise` (`composed_id`, `exercise_id`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(2, 7),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 7),
(3, 8);

CREATE TABLE `constrained` (
  `id` int(11) NOT NULL,
  `challenge` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `constrained` (`id`, `challenge`) VALUES
(1, 1);

CREATE TABLE `constrained_language` (
  `constrained_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `constrained_language` (`constrained_id`, `language_id`) VALUES
(1, 1),
(1, 2),
(1, 4),
(1, 7);

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

INSERT INTO `exercise` (`id`, `user`, `exercisestate`, `difficulty`, `description`, `name`, `folder_path`, `submit_date`, `approved_date`) VALUES
(1, 1, 2, 0, 'Un exercice test, pour tester le bon fonctionnement', 'Echo', '/Echo', '2021-01-30 10:11:45', '2021-01-30 10:11:45'),
(2, 3, 1, 2, 'Transformer un nombre entier en son écriture en français', 'Nombre En Lettres', '/NombreEnLettres', '2020-04-25 17:54:18', NULL),
(3, 4, 2, 3, 'Décrypter un code morse!', 'Morse Decoder', '/MorseDecoder', '2020-04-26 12:54:03', '2020-04-26 14:37:27'),
(4, 4, 2, 5, 'Créer votre interpréteur de code brainfuck!', 'Brainfuck Interpreter', '/BrainfuckInterpreter', '2020-04-26 13:37:20', '2021-01-30 10:26:23'),
(5, 1, 3, 3, 'Simulez un jeu de TicTacToe!', 'TicTacToe', '/TicTacToe', '2020-04-28 13:11:33', '2020-04-30 14:12:39'),
(7, 4, 1, 3, 'Réussissez à sortir du labyrinthe !', 'Labyrinth', '/Labyrinth', '2020-04-29 12:30:30', NULL),
(8, 3, 3, 5, NULL, 'Othello', '/Othello', '2020-05-02 14:24:07', '2020-05-02 17:27:27');

CREATE TABLE `exercise_state` (
  `id` int(11) NOT NULL,
  `label` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `exercise_state` (`id`, `label`) VALUES
(1, 'Pending'),
(2, 'Opened'),
(3, 'Closed');

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `language` (`id`, `name`) VALUES
(1, 'Python'),
(2, 'Java'),
(3, 'NodeJS'),
(4, 'C'),
(5, 'C++'),
(6, 'C#'),
(7, 'PHP'),
(8, 'F#'),
(9, 'Rust');

CREATE TABLE `participate` (
  `id` int(11) NOT NULL,
  `user_points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `participate` (`id`, `user_points`) VALUES
(1, 42),
(2, 69),
(3, 123);

CREATE TABLE `participate_challenge` (
  `participate_id` int(11) NOT NULL,
  `challenge_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `participate_challenge` (`participate_id`, `challenge_id`) VALUES
(1, 1),
(2, 2),
(3, 2);

CREATE TABLE `participate_user` (
  `participate_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `participate_user` (`participate_id`, `user_id`) VALUES
(1, 3),
(2, 3),
(3, 4);

CREATE TABLE `restricted` (
  `id` int(11) NOT NULL,
  `exercise` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `restricted` (`id`, `exercise`) VALUES
(1, 2),
(2, 4),
(3, 5),
(4, 8);

CREATE TABLE `restricted_language` (
  `restricted_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `restricted_language` (`restricted_id`, `language_id`) VALUES
(1, 1),
(1, 2),
(1, 4),
(2, 1),
(3, 4),
(3, 5),
(3, 6),
(4, 3),
(4, 7);

-- --------------------------------------------------------

--
-- Structure de la table `solving`
--

CREATE TABLE `solving` (
  `id` int(11) NOT NULL,
  `completed_test_amount` int(11) NOT NULL,
  `last_submitted_code` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `solving`
--

INSERT INTO `solving` (`id`, `completed_test_amount`, `last_submitted_code`) VALUES
(1, 3, 'print(\'Hello World\')'),
(2, 2, 'System.out.println(\"Hello World\");'),
(3, 5, 'printf(\"Hello World\");'),
(4, 0, 'console.log(\"Hello World\");'),
(5, 1, 'echo \"Hello World\";'),
(6, 4, 'std::cout << \"Hello World\";'),
(7, 8, 'Console.WriteLine(\"Hello World\");'),
(8, 7, 'printfn \"Hello World\"'),
(9, 5, 'println!(\"Hello, world!\");'),
(10, 0, '++++++++++[>+++++++>++++++++++>+++>+<<<<-]>++. >+. +++++++. . +++. >++.<<+++++++++++++++. >. +++. ------. --------. >+. >.'),
(11, 0, 'HAI\nCAN HAS STDIO?\nVISIBLE \"HELLO WORLD\"\nKTHXBYE'),
(12, 0, 'Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook! Ook? Ook. Ook? Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook? Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook? Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook? Ook. Ook. Ook? Ook. Ook? Ook. Ook? Ook. Ook? Ook. Ook! Ook! Ook? Ook! Ook. Ook? Ook. Ook. Ook. Ook. Ook! Ook. Ook. Ook? Ook. Ook. Ook! Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook! Ook. Ook! Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook! Ook. Ook. Ook? Ook. Ook. Ook. Ook. Ook! Ook. Ook? Ook. Ook? Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook! Ook. Ook. Ook? Ook! Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook! Ook. Ook! Ook! Ook! Ook! Ook! Ook! Ook! Ook! Ook! Ook! Ook! Ook! Ook! Ook. Ook! Ook! Ook! Ook! Ook! Ook! Ook! Ook! Ook! Ook! Ook! Ook! Ook! Ook! Ook! Ook! Ook! Ook. Ook. Ook? Ook. Ook. Ook! Ook. Ook. Ook? Ook! Ook. Ook? Ook?');

-- --------------------------------------------------------

--
-- Structure de la table `solving_exercise`
--

CREATE TABLE `solving_exercise` (
  `solving_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `solving_exercise`
--

INSERT INTO `solving_exercise` (`solving_id`, `exercise_id`) VALUES
(1, 1),
(2, 3),
(3, 4),
(4, 5),
(5, 8),
(6, 4),
(7, 8),
(8, 1),
(9, 3),
(10, 5),
(11, 3),
(12, 4);

-- --------------------------------------------------------

--
-- Structure de la table `solving_user`
--

CREATE TABLE `solving_user` (
  `solving_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `solving_user`
--

INSERT INTO `solving_user` (`solving_id`, `user_id`) VALUES
(1, 4),
(2, 4),
(3, 3),
(4, 3),
(5, 3),
(6, 3),
(7, 4),
(8, 4),
(9, 3),
(10, 3),
(11, 4),
(12, 3);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `first_name`, `last_name`, `email`, `join_date`) VALUES
(1, 'admin', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$wbHGD5OHSCAOKx4Q5EM1wQ$O0wWibAlYbjqT0w2ZFegXFMhVXgpqlIyob7vNXQnGKg', 'Administrateur', 'Administrateur', 'admin@coding-challenge.com', '2021-01-23 00:00:00'),
(3, 'Azekawa', '[\"ROLE_NEW_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$c0tmOG1pZHFTSHdHWk81cA$y1GM8EwPpi66fckrcnhQtEXPANvhvPZ+hjW+wKwtvqI', 'Medhy', 'DOHOU', 'medhy.dohou@gmail.com', '2021-01-28 19:27:00'),
(4, 'nalo_', '[\"ROLE_NEW_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$LhNXfKF+9cU9E7vpul/y7A$k3OgnoyPsajM7cA+tlrxbJHuLrEVzW1ODmf9Xo0SQXk', 'Émilie', 'Vey', 'nath.v26@gmail.com', '2021-01-29 14:11:00');

--
-- Index pour les tables déchargées
--

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
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

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