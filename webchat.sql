-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 13, 2022 lúc 11:01 AM
-- Phiên bản máy phục vụ: 10.4.17-MariaDB
-- Phiên bản PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webchat`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) NOT NULL,
  `msgid` bigint(60) NOT NULL,
  `sender` bigint(20) NOT NULL,
  `receiver` bigint(20) NOT NULL,
  `message` text NOT NULL,
  `files` text DEFAULT NULL,
  `date` datetime NOT NULL,
  `seen` int(11) NOT NULL DEFAULT 0,
  `received` int(11) NOT NULL DEFAULT 0,
  `deleted_sender` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_receiver` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`id`, `msgid`, `sender`, `receiver`, `message`, `files`, `date`, `seen`, `received`, `deleted_sender`, `deleted_receiver`) VALUES
(1, 0, 2209356475645175023, 523148480791044, 'chào tuấn', NULL, '2022-04-13 10:01:12', 1, 1, 0, 0),
(2, 0, 2209356475645175023, 9223372036854775807, 'chào vũ', NULL, '2022-04-13 10:01:21', 0, 0, 0, 0),
(3, 0, 2209356475645175023, 168707638, 'chào trang', NULL, '2022-04-13 10:01:36', 1, 1, 0, 1),
(5, 0, 523148480791044, 2209356475645175023, 'chào trường nha', NULL, '2022-04-13 10:14:24', 1, 1, 0, 0),
(6, 0, 168707638, 2209356475645175023, 'chào trường nha', NULL, '2022-04-13 10:28:27', 1, 1, 1, 0),
(7, 0, 168707638, 2209356475645175023, 'cậu khỏe không ?', NULL, '2022-04-13 10:28:32', 1, 1, 1, 0),
(8, 0, 2209356475645175023, 168707638, 'tớ vẫn khỏe', NULL, '2022-04-13 10:31:18', 0, 1, 0, 0),
(9, 0, 2209356475645175023, 523148480791044, 'cậu vẫn ổn chứ ?', NULL, '2022-04-13 10:34:20', 0, 0, 0, 0),
(10, 0, 2209356475645175023, 523148480791044, 'sức khỏe cậu thế nào rồi ?', NULL, '2022-04-13 10:39:04', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `password` varchar(64) NOT NULL,
  `image` varchar(500) NOT NULL,
  `date` datetime NOT NULL,
  `online` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `userid`, `username`, `email`, `gender`, `password`, `image`, `date`, `online`) VALUES
(3, 523148480791044, 'Dịp Lâm Tuấn', 'diplamtuan@gmail.com', 'Male', '25d55ad283aa400af464c76d713c07ad', 'uploads/lamtuan.jpg', '2022-03-28 06:32:50', 0),
(4, 9223372036854775807, 'Tạ Minh Vũ', 'taminhvu@gmail.com', 'Male', '25d55ad283aa400af464c76d713c07ad', 'uploads/minhvu.jpg', '2022-03-28 06:33:16', 0),
(5, 2209356475645175023, 'Võ Quang Trường ', 'voquangtruong@gmail.com', 'Male', '25d55ad283aa400af464c76d713c07ad', 'uploads/quangtruong.jpg', '2022-03-28 06:34:03', 0),
(6, 168707638, 'Võ Ngọc Minh Trang ', 'vongocminhtrang@gmail.com', 'on', '25d55ad283aa400af464c76d713c07ad', 'uploads/minhtrang.jpg', '2022-03-28 06:53:19', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender` (`sender`),
  ADD KEY `receiver` (`receiver`),
  ADD KEY `date` (`date`),
  ADD KEY `deleted_sender` (`deleted_sender`),
  ADD KEY `deleted_receiver` (`deleted_receiver`),
  ADD KEY `seen` (`seen`),
  ADD KEY `msgid` (`msgid`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `username` (`username`),
  ADD KEY `email` (`email`),
  ADD KEY `online` (`online`),
  ADD KEY `date` (`date`),
  ADD KEY `gender` (`gender`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
