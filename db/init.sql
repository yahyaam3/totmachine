CREATE DATABASE IF NOT EXISTS project3;
USE project3;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `Users`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL UNIQUE,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL UNIQUE,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('TECHNICAL','SUPERVISOR','ADMINISTRATOR') COLLATE utf8mb4_general_ci NOT NULL,
  `reset_token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserció de dades a la taula `Users`
INSERT INTO `Users` (`id_user`, `name`, `surname`, `email`, `username`, `password`, `avatar`, `role`) VALUES
(1, 'admin', 'admin', 'admin@admin.com', 'admin', '$2y$10$CQFvLertjqgZjm1vU1rFIOAOhpTHOrAacXgl/Mz473UubL64NJGgG', NULL, 'ADMINISTRATOR'),
(2, 'tecnico', 'tecnico', 'tecnico@tecnico.com', 'tecnico', '$2y$10$CQFvLertjqgZjm1vU1rFIOAOhpTHOrAacXgl/Mz473UubL64NJGgG', NULL, 'TECHNICAL'),
(3, 'supervisor', 'supervisor', 'supervisor@supervisor.com', 'supervisor', '$2y$10$CQFvLertjqgZjm1vU1rFIOAOhpTHOrAacXgl/Mz473UubL64NJGgG', NULL, 'SUPERVISOR'),
(5, 'Olivia', 'Hamalainen', 'olivia.hamalainen@example.com', 'crazypanda349', '$2y$10$xoOJZM5RCCfDTRr0H0IZuuVGCLLZEptPvYnPvgwZRnXbUq3nWv6V2', 'uploads/users/user_1734026165.jpg', 'TECHNICAL'),
(6, 'Rebeca', 'Prieto', 'rebeca.prieto@example.com', 'blueduck920', '$2y$10$l67ImeIUlQ5m6Ym0sNWGaeuVt331QuwgGLGborZALcZU7gAuk3Iri', 'uploads/users/user_1734026176.jpg', 'TECHNICAL');

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `Machines`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Machines` (
  `id_machine` int NOT NULL AUTO_INCREMENT,
  `model` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `manufacturer` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `serial_number` varchar(100) COLLATE utf8mb4_general_ci NOT NULL UNIQUE,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `qr_url_image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `technician_id` int DEFAULT NULL,
  PRIMARY KEY (`id_machine`),
  CONSTRAINT `fk_machine_technician` FOREIGN KEY (`technician_id`) REFERENCES `Users` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `Incidents`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Incidents` (
  `id_incident` int NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `priority` enum('HIGH','MEDIUM','LOW') COLLATE utf8mb4_general_ci DEFAULT 'MEDIUM',
  `status` enum('WAITING','IN_PROCESS','RESOLVED') COLLATE utf8mb4_general_ci DEFAULT 'WAITING',
  `issued_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `resolved_date` datetime DEFAULT NULL,
  `id_machine` int NOT NULL,
  `id_user` int DEFAULT NULL,
  PRIMARY KEY (`id_incident`),
  CONSTRAINT `fk_incident_machine` FOREIGN KEY (`id_machine`) REFERENCES `Machines` (`id_machine`) ON DELETE CASCADE,
  CONSTRAINT `fk_incident_user` FOREIGN KEY (`id_user`) REFERENCES `Users` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------
-- Estructura de tabla per les altres taules
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Maintenance` (
  `id_maintenance` int NOT NULL AUTO_INCREMENT,
  `type` enum('PREVENTIVE','CORRECTIVE') COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `time_spent` int DEFAULT NULL,
  `id_machine` int NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_maintenance`),
  CONSTRAINT `fk_maintenance_machine` FOREIGN KEY (`id_machine`) REFERENCES `Machines` (`id_machine`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `Notifications` (
  `id_notification` int NOT NULL AUTO_INCREMENT,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `is_read` BOOLEAN DEFAULT FALSE,
  `sent_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_notification`),
  CONSTRAINT `fk_notifications_user` FOREIGN KEY (`id_user`) REFERENCES `Users` (`id_user`) ON DELETE CASCADE
);
