-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 16, 2025 lúc 02:55 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `esl_resources`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `description`, `created_at`) VALUES
(1, 'Lớp 1', 'Lớp học tiếng Anh cho trẻ em', '2025-02-27 12:30:14'),
(3, 'Lớp 2', 'Lớp học tiếng Anh cho trẻ em', '2025-02-28 13:27:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `documents`
--

INSERT INTO `documents` (`id`, `title`, `file_name`, `file_path`, `uploaded_at`, `user_id`) VALUES
(1, 'Key - CONSONANTS - new.pdf', 'Key - CONSONANTS - new.pdf', '../admin/assets/uploads/Key - CONSONANTS - new.pdf', '2025-03-08 10:34:53', 18),
(2, 'Pronunciation Lesson - new.pdf', 'Pronunciation Lesson - new.pdf', '../admin/assets/uploads/Pronunciation Lesson - new.pdf', '2025-03-08 10:41:48', 18);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `flashcards`
--

CREATE TABLE `flashcards` (
  `id` int(11) NOT NULL,
  `word` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `topic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `flashcards`
--

INSERT INTO `flashcards` (`id`, `word`, `image`, `topic`) VALUES
(1, 'Dog', '../../../admin/assets/images/dog.jpg', 'animals'),
(5, 'Woft', '../../../admin/assets/images/wolf.jpg', 'animals'),
(6, 'Cat', '../../../admin/assets/images/cat.jpg', 'animals'),
(7, 'Mouse', '../../../admin/assets/images/mouse.jpg', 'animals');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `saved_words`
--

CREATE TABLE `saved_words` (
  `id` int(11) NOT NULL,
  `original` varchar(255) NOT NULL,
  `translated` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `saved_words`
--

INSERT INTO `saved_words` (`id`, `original`, `translated`, `created_at`) VALUES
(13, 'dịch', 'pandemic', '2025-02-27 15:31:07'),
(15, 'Tên tôi là Dương', 'My name is Duong', '2025-03-02 13:35:07'),
(17, 'nhà', 'home', '2025-03-12 02:35:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `scores`
--

CREATE TABLE `scores` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `video_file` varchar(255) NOT NULL,
  `audio_file` varchar(255) NOT NULL,
  `lyrics` text NOT NULL,
  `comparison_lyrics` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `songs`
--

INSERT INTO `songs` (`id`, `title`, `video_file`, `audio_file`, `lyrics`, `comparison_lyrics`) VALUES
(9, 'Once I Caught a Fish Alive', 'https://youtu.be/BkDLhJzOx2A', 'https://www.example.com/twinkle.mp3', 'One, Two, Three, Four, Five,\r\nOnce I caught a fish alive,\r\nSix, Seven, Eight, Nine, Ten,\r\nThen I threw him back again.\r\nWhy did you let him go?\r\nBecause he bit my finger so.\r\nWhich finger did he bite?\r\nThis little finger on my right.', 'One, Two, Three, Four, Five,\r\nOnce I caught a fish alive,\r\nSix, Seven, Eight, Nine, Ten,\r\nThen I threw him back again.\r\nWhy did you let him go?\r\nBecause he bit my finger so.\r\nWhich finger did he bite?\r\nThis little finger on my right.'),
(10, 'Twinkle Twinkle Little Star', '', 'https://www.example.com/twinkle.mp3', 'Twinkle, twinkle, little star, How I wonder what you are!', 'twinkle twinkle little star how i wonder what you are'),
(11, 'Let It Be', 'https://youtu.be/Fplyh5t_4S4', 'https://www.example.com/twinkle.mp3', 'When I find myself in times of trouble\r\nMother Mary comes to me\r\nSpeaking words of wisdom, let it be\r\nAnd in my hour of darkness\r\nShe is standing right in front of me\r\nSpeaking words of wisdom, let it be\r\nLet it be, let it be\r\nLet it be, let it be\r\nWhisper words of wisdom, let it be', 'When I find myself in times of trouble\r\nMother Mary comes to me\r\nSpeaking words of wisdom, let it be\r\nAnd in my hour of darkness\r\nShe is standing right in front of me\r\nSpeaking words of wisdom, let it be\r\nLet it be, let it be\r\nLet it be, let it be\r\nWhisper words of wisdom, let it be'),
(12, 'Let It Go', 'https://www.youtube.com/watch?v=moSFlvxnbgk', 'https://www.example.com/let_it_go.mp3', 'The snow glows white on the mountain tonight, not a footprint to be seen...', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','banned') DEFAULT 'active',
  `role` enum('student','teacher') DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `created_at`, `last_login`, `profile_picture`, `status`, `role`) VALUES
(17, 'admin', '$2y$10$Hx6L0zBa5CPNuK1DNC3DdeHI7egVaTqjlrNkFSA2LCqHB7WjzLpM2', 'admin@gmail.com', '2025-02-26 16:30:08', '2025-03-15 12:24:35', NULL, 'active', 'teacher'),
(18, 'student', '$2y$10$wwcU8/WsHqTkcxYOxbZft.dlRb0Fihr4sRuhjGPNMdvshgDMIwOiy', 'student1@gmail.com', '2025-03-02 14:12:11', '2025-03-06 11:20:56', NULL, 'active', 'student');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vocabulary`
--

CREATE TABLE `vocabulary` (
  `id` int(11) NOT NULL,
  `word` varchar(255) NOT NULL,
  `choices` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`choices`)),
  `correct_choice` varchar(255) NOT NULL,
  `topic` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `vocabulary`
--

INSERT INTO `vocabulary` (`id`, `word`, `choices`, `correct_choice`, `topic`, `image`) VALUES
(5, 'Dog', '[\"m\\u00e8o , ch\\u00f3 , chu\\u1ed9t , s\\u00f3i\"]', 'dog.jpg', 'animals', ''),
(22, 'Cat', '[\"m\\u00e8o , ch\\u00f3 , chu\\u1ed9t , s\\u00f3i\"]', 'cat.jpg', 'animals', ''),
(23, 'Woft', '[\"m\\u00e8o , ch\\u00f3 , chu\\u1ed9t , s\\u00f3i\"]', 'wolf.jpg', 'animals', ''),
(24, 'Mouse', '[\"m\\u00e8o , ch\\u00f3 , chu\\u1ed9t , s\\u00f3i\"]', 'mouse.jpg', 'animals', '');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Chỉ mục cho bảng `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Chỉ mục cho bảng `flashcards`
--
ALTER TABLE `flashcards`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `saved_words`
--
ALTER TABLE `saved_words`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `song_id` (`song_id`);

--
-- Chỉ mục cho bảng `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `vocabulary`
--
ALTER TABLE `vocabulary`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `flashcards`
--
ALTER TABLE `flashcards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `saved_words`
--
ALTER TABLE `saved_words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `vocabulary`
--
ALTER TABLE `vocabulary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
