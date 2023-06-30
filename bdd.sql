-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 25, 2023 at 06:16 PM
-- Server version: 8.0.33-0ubuntu0.22.04.2
-- PHP Version: 8.1.2-1ubuntu2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gigachad`
--

-- --------------------------------------------------------

--
-- Table structure for table `exercises`
--

CREATE TABLE `exercises` (
  `id` int NOT NULL,
  `title` varchar(64) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `fichier` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Un lien vers un fichier vidéo ou image qui décrit l''exercice'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `exercises`
--

INSERT INTO `exercises` (`id`, `title`, `description`, `fichier`) VALUES
(1, 'Jumping jacks', 'This dynamic full-body exercise is a popular warm-up that increases body temperature, aerobic capacity, and strength.', NULL),
(2, 'Bicycle crunch', 'The bicycle crunch is a dynamic exercise that strengthens the core, lower abdominals, and lower back. The movement also improves stability, balance and coordination.', NULL),
(3, 'Barbell deadlift', 'The barbell deadlift builds total-body strength by targeting the lower back, hamstrings, quads, and glutes. The exercise also increases core strength and stability.', NULL),
(4, 'Plank', 'The plank is a basic bodyweight exercise that strengthens the core as well as the upper and lower body muscle groupes. This isometric training exercise builds a full-body foundation while also improving joint stability.', NULL),
(5, 'Pull up', 'The pull-up is a challenging bodyweight movement that develops the entire back while strengthening the biceps, forearms, and core. The pull-up also increases stability throughout the shoulders. To ensure full back engagement, start each rep from a dead hang (arms fully extended) and pull your elbows into your ribcage and squeeze your lats as you pull your body up.', NULL),
(6, 'Barbell back squat', 'The back squat is a basic barbell strength exercise for the lower body with an emphasis on the quads, hamstrings, and glutes. The exercise also strengthens the entire core. The squat allows for heavy weights and overloads your entire body, which has been shown to increase testosterone and growth hormone, making it one of the best mass building exercises.', NULL),
(7, 'Dumbbell lying triceps extension', 'Dumbbell lying triceps extensions increase strength in the triceps. Performing the exercise with dumbbells will achieve muscular balance on both sides of the body.', NULL),
(8, 'Jog', NULL, NULL),
(9, 'Alternating dumbbell biceps curl', 'The alternating dumbbell biceps curls develop size and strength of the biceps and forearms. The alternating of each arm eliminates any muscular imbalances on each side.', NULL),
(10, 'Side plank', 'This exercise builds strength by fighting against gravity, which adds and extra balance challenge.', NULL),
(11, 'Jump rope', 'Jumping rope is a full body conditioning drill that develops foot work, speed and agility. This exercise also improves cardiovascular endurance and coordination.', NULL),
(12, 'Crunch', 'The cable crunch is a core strengthening exercise that targets the entire abdominal region. The exercise also improves stability in the lower back and hips.', NULL),
(13, 'Single leg deadlift with barbell', 'The single-leg deadlift with barbell builds leg and back strength while improving core stability, balance, and coordination.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `groupes`
--

CREATE TABLE `groupes` (
  `id` int NOT NULL,
  `idCoach` int NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `groupes`
--

INSERT INTO `groupes` (`id`, `idCoach`, `name`) VALUES
(1, 3, 'Profs'),
(3, 1, 'Beginners');

-- --------------------------------------------------------

--
-- Table structure for table `group_workout`
--

CREATE TABLE `group_workout` (
  `id` int NOT NULL,
  `idGroup` int NOT NULL,
  `idWorkout` int NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `group_workout`
--

INSERT INTO `group_workout` (`id`, `idGroup`, `idWorkout`, `date`) VALUES
(1, 3, 1, '2023-06-23'),
(2, 1, 2, '2023-06-24');

-- --------------------------------------------------------

--
-- Table structure for table `performances`
--

CREATE TABLE `performances` (
  `id` int NOT NULL,
  `idUser` int NOT NULL,
  `idWorkout` int NOT NULL,
  `idExercice` int NOT NULL,
  `nbRep` int NOT NULL DEFAULT '0',
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `performances`
--

INSERT INTO `performances` (`id`, `idUser`, `idWorkout`, `idExercice`, `nbRep`, `date`) VALUES
(2, 8, 1, 11, 30, '2023-06-23'),
(3, 8, 1, 4, 0, '2023-06-23'),
(4, 5, 2, 8, 3, '2023-06-24'),
(5, 6, 2, 8, 4, '2023-06-24'),
(6, 5, 2, 11, 50, '2023-06-24'),
(7, 6, 2, 11, 40, '2023-06-24'),
(8, 8, 1, 8, 2, '2023-06-23'),
(9, 7, 1, 10, 0, '2023-06-23');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int NOT NULL,
  `idUser` int NOT NULL,
  `idCoach` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `idUser`, `idCoach`) VALUES
(2, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `idCoach` int DEFAULT NULL,
  `isCoach` tinyint(1) NOT NULL DEFAULT '0',
  `login` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Pseudo de l''utilisateur',
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `idCoach`, `isCoach`, `login`, `password`) VALUES
(1, NULL, 1, 'Kevin', 'kevin'),
(2, NULL, 0, 'James', 'james'),
(3, NULL, 1, 'Michel', 'michel'),
(4, NULL, 1, 'Samir', 'samir'),
(5, 3, 0, 'tom', 'web'),
(6, 3, 0, 'isa', 'bdd'),
(7, NULL, 0, 'Steve', 'steve'),
(8, 1, 0, 'Jean', 'jean');

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE `user_group` (
  `id` int NOT NULL,
  `idUser` int NOT NULL,
  `idGroup` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`id`, `idUser`, `idGroup`) VALUES
(1, 6, 1),
(2, 5, 1),
(3, 7, 3);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_groupes`
-- (See below for the actual view)
--
CREATE TABLE `v_groupes` (
`id` int
,`idCoach` int
,`name` varchar(32)
,`login` varchar(16)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_performances`
-- (See below for the actual view)
--
CREATE TABLE `v_performances` (
`id` int
,`idUser` int
,`idWorkout` int
,`idExercice` int
,`nbRep` int
,`date` date
,`nomWorkout` varchar(32)
,`nomExercise` varchar(64)
,`nomUser` varchar(16)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_requests`
-- (See below for the actual view)
--
CREATE TABLE `v_requests` (
`id` int
,`idUser` int
,`idCoach` int
,`nomUser` varchar(16)
,`nomCoach` varchar(16)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_user_group`
-- (See below for the actual view)
--
CREATE TABLE `v_user_group` (
`id` int
,`idUser` int
,`idGroup` int
,`login` varchar(16)
,`nomGroupe` varchar(32)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_workouts`
-- (See below for the actual view)
--
CREATE TABLE `v_workouts` (
`id` int
,`idCoach` int
,`name` varchar(32)
,`login` varchar(16)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_workout_exercise`
-- (See below for the actual view)
--
CREATE TABLE `v_workout_exercise` (
`id` int
,`idWorkout` int
,`idExercise` int
,`duration` time
,`position` int
,`name` varchar(32)
,`title` varchar(64)
,`description` text
,`fichier` varchar(256)
,`idCoach` int
,`login` varchar(16)
);

-- --------------------------------------------------------

--
-- Table structure for table `workouts`
--

CREATE TABLE `workouts` (
  `id` int NOT NULL,
  `idCoach` int NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `workouts`
--

INSERT INTO `workouts` (`id`, `idCoach`, `name`) VALUES
(1, 1, 'Leg day'),
(2, 4, 'Warm-up'),
(3, 1, 'Abs fat');

-- --------------------------------------------------------

--
-- Table structure for table `workout_exercise`
--

CREATE TABLE `workout_exercise` (
  `id` int NOT NULL,
  `idWorkout` int NOT NULL,
  `idExercise` int NOT NULL,
  `duration` time NOT NULL,
  `position` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `workout_exercise`
--

INSERT INTO `workout_exercise` (`id`, `idWorkout`, `idExercise`, `duration`, `position`) VALUES
(1, 1, 8, '00:15:00', 0),
(2, 1, 4, '00:05:00', 1),
(3, 1, 11, '00:10:00', 2),
(4, 1, 10, '00:05:00', 3),
(5, 2, 8, '00:10:00', 0),
(6, 2, 11, '00:10:00', 1),
(7, 3, 12, '00:05:00', 0),
(8, 3, 2, '00:05:00', 1),
(9, 3, 13, '00:10:00', 2);

-- --------------------------------------------------------

--
-- Structure for view `v_groupes`
--
DROP TABLE IF EXISTS `v_groupes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`admin`@`localhost` SQL SECURITY DEFINER VIEW `v_groupes`  AS SELECT `g`.`id` AS `id`, `g`.`idCoach` AS `idCoach`, `g`.`name` AS `name`, `u`.`login` AS `login` FROM (`groupes` `g` join `users` `u` on((`g`.`idCoach` = `u`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_performances`
--
DROP TABLE IF EXISTS `v_performances`;

CREATE ALGORITHM=UNDEFINED DEFINER=`admin`@`localhost` SQL SECURITY DEFINER VIEW `v_performances`  AS SELECT `p`.`id` AS `id`, `p`.`idUser` AS `idUser`, `p`.`idWorkout` AS `idWorkout`, `p`.`idExercice` AS `idExercice`, `p`.`nbRep` AS `nbRep`, `p`.`date` AS `date`, `w`.`name` AS `nomWorkout`, `e`.`title` AS `nomExercise`, `u`.`login` AS `nomUser` FROM (((`performances` `p` join `workouts` `w` on((`p`.`idWorkout` = `w`.`id`))) join `exercises` `e` on((`p`.`idExercice` = `e`.`id`))) join `users` `u` on((`p`.`idUser` = `u`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_requests`
--
DROP TABLE IF EXISTS `v_requests`;

CREATE ALGORITHM=UNDEFINED DEFINER=`admin`@`localhost` SQL SECURITY DEFINER VIEW `v_requests`  AS SELECT `r`.`id` AS `id`, `r`.`idUser` AS `idUser`, `r`.`idCoach` AS `idCoach`, `u`.`login` AS `nomUser`, `uu`.`login` AS `nomCoach` FROM ((`requests` `r` join `users` `u` on((`r`.`idUser` = `u`.`id`))) join `users` `uu` on((`r`.`idCoach` = `uu`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_user_group`
--
DROP TABLE IF EXISTS `v_user_group`;

CREATE ALGORITHM=UNDEFINED DEFINER=`admin`@`localhost` SQL SECURITY DEFINER VIEW `v_user_group`  AS SELECT `ug`.`id` AS `id`, `ug`.`idUser` AS `idUser`, `ug`.`idGroup` AS `idGroup`, `u`.`login` AS `login`, `g`.`name` AS `nomGroupe` FROM ((`user_group` `ug` join `users` `u` on((`ug`.`idUser` = `u`.`id`))) join `groupes` `g` on((`ug`.`idGroup` = `g`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_workouts`
--
DROP TABLE IF EXISTS `v_workouts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`admin`@`localhost` SQL SECURITY DEFINER VIEW `v_workouts`  AS SELECT `w`.`id` AS `id`, `w`.`idCoach` AS `idCoach`, `w`.`name` AS `name`, `u`.`login` AS `login` FROM (`workouts` `w` join `users` `u` on((`w`.`idCoach` = `u`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_workout_exercise`
--
DROP TABLE IF EXISTS `v_workout_exercise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`admin`@`localhost` SQL SECURITY DEFINER VIEW `v_workout_exercise`  AS SELECT `we`.`id` AS `id`, `we`.`idWorkout` AS `idWorkout`, `we`.`idExercise` AS `idExercise`, `we`.`duration` AS `duration`, `we`.`position` AS `position`, `w`.`name` AS `name`, `e`.`title` AS `title`, `e`.`description` AS `description`, `e`.`fichier` AS `fichier`, `u`.`id` AS `idCoach`, `u`.`login` AS `login`, `e` . `title` AS `nomExercice` FROM (((`workout_exercise` `we` join `workouts` `w` on((`we`.`idWorkout` = `w`.`id`))) join `exercises` `e` on((`we`.`idExercise` = `e`.`id`))) join `users` `u` on((`w`.`idCoach` = `u`.`id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groupes`
--
ALTER TABLE `groupes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCoach` (`idCoach`);

--
-- Indexes for table `group_workout`
--
ALTER TABLE `group_workout`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idGroup` (`idGroup`),
  ADD KEY `idWorkout` (`idWorkout`);

--
-- Indexes for table `performances`
--
ALTER TABLE `performances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idExercice` (`idExercice`),
  ADD KEY `idWorkout` (`idWorkout`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idCoach` (`idCoach`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCoach` (`idCoach`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idGroup` (`idGroup`);

--
-- Indexes for table `workouts`
--
ALTER TABLE `workouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCoach` (`idCoach`);

--
-- Indexes for table `workout_exercise`
--
ALTER TABLE `workout_exercise`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idExercise` (`idExercise`),
  ADD KEY `idWorkout` (`idWorkout`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exercises`
--
ALTER TABLE `exercises`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `groupes`
--
ALTER TABLE `groupes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `group_workout`
--
ALTER TABLE `group_workout`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `performances`
--
ALTER TABLE `performances`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `workouts`
--
ALTER TABLE `workouts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `workout_exercise`
--
ALTER TABLE `workout_exercise`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `groupes`
--
ALTER TABLE `groupes`
  ADD CONSTRAINT `groupes_ibfk_1` FOREIGN KEY (`idCoach`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `group_workout`
--
ALTER TABLE `group_workout`
  ADD CONSTRAINT `group_workout_ibfk_1` FOREIGN KEY (`idGroup`) REFERENCES `groupes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_workout_ibfk_2` FOREIGN KEY (`idWorkout`) REFERENCES `workouts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `performances`
--
ALTER TABLE `performances`
  ADD CONSTRAINT `performances_ibfk_2` FOREIGN KEY (`idExercice`) REFERENCES `exercises` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `performances_ibfk_3` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `performances_ibfk_4` FOREIGN KEY (`idWorkout`) REFERENCES `workouts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`idCoach`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_group`
--
ALTER TABLE `user_group`
  ADD CONSTRAINT `user_group_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_group_ibfk_2` FOREIGN KEY (`idGroup`) REFERENCES `groupes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `workouts`
--
ALTER TABLE `workouts`
  ADD CONSTRAINT `workouts_ibfk_1` FOREIGN KEY (`idCoach`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `workout_exercise`
--
ALTER TABLE `workout_exercise`
  ADD CONSTRAINT `workout_exercise_ibfk_1` FOREIGN KEY (`idExercise`) REFERENCES `exercises` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workout_exercise_ibfk_2` FOREIGN KEY (`idWorkout`) REFERENCES `workouts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;