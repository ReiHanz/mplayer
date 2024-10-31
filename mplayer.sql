-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2024 at 04:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mplayer`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `user_id`, `message`, `sent_at`) VALUES
(1, 2, 'hai', '2024-09-27 02:31:54'),
(2, 2, 'hallo', '2024-09-27 02:40:52'),
(3, 2, 'tes', '2024-09-27 02:42:50'),
(4, 2, 'tess', '2024-09-27 02:49:24'),
(5, 1, 'hello', '2024-09-27 05:39:35'),
(6, 2, 'tes drive baru', '2024-10-03 02:07:07'),
(7, 1, 'alhamdulillah ya sesuatu', '2024-10-30 02:28:02'),
(8, 2, 'kamana wae bos', '2024-10-30 02:29:29'),
(9, 1, 'tes lagi', '2024-10-30 03:26:25'),
(11, 1, 'gassskeun', '2024-10-30 05:36:24');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `music_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `music_id`) VALUES
(1, 1, 1),
(2, 1, 4),
(3, 1, 4),
(4, 2, 3),
(5, 2, 2),
(6, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `music`
--

CREATE TABLE `music` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `music`
--

INSERT INTO `music` (`id`, `title`, `file_path`, `uploaded_by`) VALUES
(1, 'Pamungkas - One Only', '../uploads/One Only - Pamungkas.mp3', 1),
(2, 'Monolog - Pamungkas', '../uploads/Pamungkas - Monolog.mp3', 1),
(3, 'To The Bone - Pamungkas', '../uploads/Pamungkas - To The Bone.mp3', 1),
(4, 'Pupus - Pamungkas', '../uploads/K, Pamungkas - Pupus X Risalah Hati (Dewa Cover) Studio Version.mp.mp3', 1),
(5, 'Malaikat - Ghea Indrawari', '../uploads/GHEA INDRAWARI - MALAIKAT.mp3', 1),
(6, 'Jiwa yang Bersedih - Ghea Indrawari', '../uploads/Ghea Indrawari - Jiwa Yang Bersedih (Karaoke Version).mp3', 1),
(7, 'Kini Mereka Tahu - Bernadya', '../uploads/Bernadya - Kini Mereka Tahu.mp3', 1),
(8, 'Satu Bulan - Bernadya', '../uploads/Bernadya - Satu Bulan.mp3', 1),
(9, 'Untungnya, Hidup Harus Tetap Berjalan - Bernadya', '../uploads/Bernadya - Untungnya, Hidup Harus Tetap Berjalan.mp3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT '''default.jpg''',
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `birthdate`, `phone`, `address`, `profile_picture`, `role`) VALUES
(1, 'ades', '$2y$10$XTY3qGaDiLLJ1yCY8IEjweLmlT7Y9qROmI/6hFCKrclgVBe5/QU/K', 'ades@gmail.com', '2014-10-01', '+6283825989878', 'garut', 'default.jpg', 'admin'),
(2, 'rei', '$2y$10$r2ftAmYFARKwcRaotIq4z.T.9W1nnTWigv2so6.VKmchPiAbj23rC', '', NULL, NULL, NULL, 'default.png', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `music_id` (`music_id`);

--
-- Indexes for table `music`
--
ALTER TABLE `music`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `music`
--
ALTER TABLE `music`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`music_id`) REFERENCES `music` (`id`);

--
-- Constraints for table `music`
--
ALTER TABLE `music`
  ADD CONSTRAINT `music_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
