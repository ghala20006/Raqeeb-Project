-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 25 أبريل 2026 الساعة 03:45
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `raqeeb`
--

-- --------------------------------------------------------

--
-- بنية الجدول `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'admin', 'admin@raqeeb.com', '1234', '2026-04-18 17:05:54'),
(2, 'admin', 'admin@gmail.com', '1234', '2026-04-18 17:05:54');

-- --------------------------------------------------------

--
-- بنية الجدول `alerts`
--

CREATE TABLE `alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `alert_type` varchar(50) DEFAULT NULL,
  `alert_message` text DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `vehicle_id` (`vehicle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- إرجاع أو استيراد بيانات الجدول `alerts`
--

INSERT INTO `alerts`
(`id`, `vehicle_id`, `user_id`, `alert_type`, `alert_message`, `latitude`, `longitude`, `created_at`)
VALUES
(1, NULL, NULL, 'نعاس', 'تم اكتشاف نعاس السائق', NULL, NULL, '2026-04-22 16:19:35');
-- --------------------------------------------------------

--
-- بنية الجدول `alert_media`
--

CREATE TABLE `alert_media` (
  `id` int(11) NOT NULL,
  `alert_id` int(11) DEFAULT NULL,
  `media_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `speed` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `recorded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `locations`
--

INSERT INTO `locations` (`id`, `user_id`, `vehicle_id`, `latitude`, `longitude`, `speed`, `created_at`, `recorded_at`) VALUES
(1, 5, NULL, '24.7136', '46.6753', NULL, '2026-04-22 19:21:01', '2026-04-22 19:21:01');

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `system_status` varchar(50) DEFAULT 'نشط',
  `driver_status` varchar(50) DEFAULT 'طبيعي',
  `camera_status` varchar(50) DEFAULT 'متصل'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `system_status`, `driver_status`, `camera_status`) VALUES
(5, 'aaa', 'aaa@gmail.com', '1234', '2026-04-21 18:08:53', 'نشط', 'طبيعي', 'متصل');

-- --------------------------------------------------------

--
-- بنية الجدول `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `plate_number` varchar(50) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `plate` varchar(50) DEFAULT NULL,
  `car_type` varchar(100) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `vehicles`
--
INSERT INTO vehicles (`id` , `user_id` , `plate_number` , `model` , `plate` , `car_type` , `size` , `year` , `color`) VALUES 
(1,5,'1234','Toyota Corolla','أ ب ج 1234','سيدان','صغيرة',2023,'أسود');

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
--

--
-- Indexes for table `alert_media`
--
ALTER TABLE `alert_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alert_id` (`alert_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--


--
-- AUTO_INCREMENT for table `alert_media`
--
ALTER TABLE `alert_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`);

--
-- قيود الجداول `alert_media`
--
ALTER TABLE `alert_media`
  ADD CONSTRAINT `alert_media_ibfk_1` FOREIGN KEY (`alert_id`) REFERENCES `alerts` (`id`);

--
-- قيود الجداول `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`);

--
-- قيود الجداول `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
