INSERT INTO `user` (`id`, `username`, `roles`, `password`, `first_name`, `last_name`, `email`, `join_date`, `api_key`) VALUES
(1, 'admin', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$wbHGD5OHSCAOKx4Q5EM1wQ$O0wWibAlYbjqT0w2ZFegXFMhVXgpqlIyob7vNXQnGKg', 'Administrateur', 'Administrateur', 'admin@coding-challenge.com', '2021-01-23 00:00:00', '4ca8de8561893f54aadc9cd4bb59b8e7'),
(3, 'Azekawa', '[\"ROLE_NEW_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$c0tmOG1pZHFTSHdHWk81cA$y1GM8EwPpi66fckrcnhQtEXPANvhvPZ+hjW+wKwtvqI', 'Medhy', 'DOHOU', 'medhy.dohou@gmail.com', '2021-01-28 19:27:00', '37166aaec812602bdb6482b81119f6c0'),
(4, 'nalo_', '[\"ROLE_NEW_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$LhNXfKF+9cU9E7vpul/y7A$k3OgnoyPsajM7cA+tlrxbJHuLrEVzW1ODmf9Xo0SQXk', 'Émilie', 'Vey', 'nath.v26@gmail.com', '2021-01-29 14:11:00', '7140517eb65ff21d452eaf6d49553b53');
INSERT INTO `challenge` (`id`, `start_date`, `end_date`) VALUES
(1, '2020-12-01 00:00:00', '2020-12-31 23:59:59'),
(2, '2021-01-01 00:00:00', '2021-12-31 23:59:59'),
(3, '2021-05-14 07:27:27', '2021-07-02 23:42:35');

INSERT INTO `composed` (`id`, `challenge`, `points_amount`) VALUES
(1, 1, 0),
(2, 2, 0),
(3, 3, 0);

INSERT INTO `exercise_state` (`id`, `label`) VALUES
(1, 'Pending'),
(2, 'Opened'),
(3, 'Closed');

INSERT INTO `exercise` (`id`, `user`, `exercisestate`, `difficulty`, `description`, `name`, `folder_path`, `submit_date`, `approved_date`) VALUES
(1, 1, 2, 0, 'Un exercice test, pour tester le bon fonctionnement', 'Echo', '/Echo', '2021-01-30 10:11:45', '2021-01-30 10:11:45'),
(2, 3, 1, 2, 'Transformer un nombre entier en son écriture en français', 'Nombre En Lettres', '/NombreEnLettres', '2020-04-25 17:54:18', NULL),
(3, 4, 2, 3, 'Décrypter un code morse!', 'Morse Decoder', '/MorseDecoder', '2020-04-26 12:54:03', '2020-04-26 14:37:27'),
(4, 4, 2, 5, 'Créer votre interpréteur de code brainfuck!', 'Brainfuck Interpreter', '/BrainfuckInterpreter', '2020-04-26 13:37:20', '2021-01-30 10:26:23'),
(5, 1, 3, 3, 'Simulez un jeu de TicTacToe!', 'TicTacToe', '/TicTacToe', '2020-04-28 13:11:33', '2020-04-30 14:12:39'),
(7, 4, 1, 3, 'Réussissez à sortir du labyrinthe !', 'Labyrinth', '/Labyrinth', '2020-04-29 12:30:30', NULL),
(8, 3, 3, 5, NULL, 'Othello', '/Othello', '2020-05-02 14:24:07', '2020-05-02 17:27:27');


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

INSERT INTO `constrained` (`id`, `challenge`) VALUES
(1, 1);

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

INSERT INTO `constrained_language` (`constrained_id`, `language_id`) VALUES
(1, 1),
(1, 2),
(1, 4),
(1, 7);




INSERT INTO `participate` (`id`, `user_points`) VALUES
(1, 42),
(2, 69),
(3, 123);

INSERT INTO `participate_challenge` (`participate_id`, `challenge_id`) VALUES
(1, 1),
(2, 2),
(3, 2);

INSERT INTO `participate_user` (`participate_id`, `user_id`) VALUES
(1, 3),
(2, 3),
(3, 4);

INSERT INTO `restricted` (`id`, `exercise`) VALUES
(1, 2),
(2, 4),
(3, 5),
(4, 8);

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

