-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 06 أبريل 2026 الساعة 17:35
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
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- بنية الجدول `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `inventory`
--

INSERT INTO `inventory` (`id`, `item_name`, `quantity`, `status`) VALUES
(1, 'جهاز كمبيوتر', 3000, 'متوفر'),
(2, 'طابعة', 1200, 'متوفر'),
(3, 'شاشة', 1200, 'متوفر'),
(4, 'فاكس', 800, 'متوفر'),
(5, 'قلم طابعة', 1500, 'متوفر');

-- --------------------------------------------------------

--
-- بنية الجدول `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `priority` enum('عالية','متوسطة','منخفضة') NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('قيد التوزيع','ملغي','قيد التنفيذ','تم التوصيل') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `department` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `technician_id` int(11) DEFAULT NULL,
  `request_type` enum('أنظمة','شبكات','أجهزة') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `requests`
--

INSERT INTO `requests` (`id`, `employee_name`, `item_id`, `priority`, `description`, `status`, `created_at`, `department`, `user_id`, `technician_id`, `request_type`) VALUES
(53, '', 3, 'عالية', '..', 'ملغي', '2025-01-07 08:38:33', 'الادارة', 30, 29, 'أنظمة'),
(57, '', 1, 'عالية', '..', 'قيد التنفيذ', '2025-01-26 08:13:08', '.', 2, 29, 'أجهزة'),
(60, '', 1, 'عالية', '..', 'قيد التنفيذ', '2025-01-26 08:44:39', '.', 2, 29, 'أجهزة'),
(62, '', 3, 'متوسطة', 'ةة', 'ملغي', '2025-01-28 11:50:06', 'ةةة', 2, 29, 'شبكات'),
(63, '', 2, 'عالية', 'و', 'قيد التوزيع', '2025-01-28 11:50:25', 'و', 2, NULL, 'شبكات'),
(64, '', 2, 'عالية', 'ةة', 'قيد التوزيع', '2025-01-28 11:50:33', 'ةة', 2, NULL, 'شبكات'),
(65, '', 1, 'عالية', 'تعديل الانترنت', 'تم التوصيل', '2025-02-12 06:23:57', 'الادارة', 2, 29, 'شبكات');

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee','technician','distributor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `email`, `full_name`, `username`, `password`, `role`) VALUES
(1, 'admin.A@gmail.com', 'أحمد الأحمد', 'admin', '$2y$10$lVI70Gk3N4k9ia2uORe5X.tDWTxHOayuCr0hmZyRsOcKzuxdae.uu', 'admin'),
(2, 'T1_alert@gmail.com', 'ABDOUALAZIZ', 'user1', '$2y$10$oLCZuVLXzsFzgRGeCtebH.TKVZ/I4s9fOoUbV2AP0Oy1XcsAzxCUq', 'employee'),
(23, 'HNN@gmail.com', 'HANAN H M', 'Hanan', '$2y$10$e5chvpsTKYyB4r1CmreipuNZ8w7EP2MF9RpNGoGyfjIBXNOl3YvXm', 'employee'),
(24, 'NN@gmail.com', ' Nora Ahmed ', 'User_name123', '$2y$10$2h4a1pL614RWzTA4TIxVxOXwIxhPWnUeGg1MBFnXVYta5m5l8T012', 'employee'),
(26, 'tech2@mail.com', 'أحمد الجابر', 'tech2', 'hashed_password', 'technician'),
(29, 'techn@mail.com', 'AHMED AL ', 'techn2', '$2y$10$925RbWr4y6LzQoAO1/0/x.FKQgoS6WTTfd1ohrKERFlwiPnz4axE6', 'technician'),
(30, 'fatima77@gmail.com', 'Fatima Ahmed', '54fatima', '$2y$10$Gug2Ltd3f7i84Tih1xCpY.YJ9RdZ88.1DtBJWtIxGKrB3rXp60vqe', 'employee'),
(37, 'wo12@gmail.com', 'N1 N2 N3', 'n1', '$2y$10$v.budmIo8Rl.xlizb7A3nejkRIHVXhTYOLuS1QHCrxnHiV9U7k6Mm', 'employee'),
(40, 'dddd@gmail.com', 'موزع االطلبات', 'dist123', '$2y$10$FYHZFFn0jZoadR40/FKaMeLxAY6rzy23HIzvg7qBQjjKRodGLiZKe', 'distributor'),
(41, 'fasa@gmail.com', 'fa', 'fasa', '$2y$10$8nRW.MbgZleQirXbM7x2ouZJaVysRJATZRx2oGBrRhZTS22Ls/lO2', 'employee');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `inventory` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
