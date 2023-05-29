/*This file exists in order for users to create the tables needed for this application to run correctly.*/
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
CREATE DATABASE IF NOT EXISTS `vacation_request_database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `vacation_request_database`;

DROP TABLE IF EXISTS `mail`;
CREATE TABLE `mail` (
  `id` int(11) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `recipient_email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `vacation_request_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin','employee') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `user_type`) VALUES
(1, 'John', 'Doe2222', 'john@example.com', 'password1', 'employee'),
(2, 'Jane', 'Smith1', 'jane@example.com', 'password2', 'admin');

DROP TABLE IF EXISTS `vacation_request`;
CREATE TABLE `vacation_request` (
  `id` int(11) NOT NULL,
  `vacation_start` date NOT NULL,
  `vacation_end` date NOT NULL,
  `reason` text NOT NULL,
  `date_submitted` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('approved','pending','denied') NOT NULL DEFAULT 'pending',
  `days_requested` int(11) DEFAULT NULL,
  `requesting_employee_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `mail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vacation_request_id` (`vacation_request_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `vacation_request`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `mail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

ALTER TABLE `vacation_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;


ALTER TABLE `mail`
  ADD CONSTRAINT `mail_ibfk_1` FOREIGN KEY (`vacation_request_id`) REFERENCES `vacation_request` (`id`);
