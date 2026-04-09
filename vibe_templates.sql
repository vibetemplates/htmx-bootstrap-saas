-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 17, 2025 at 11:38 PM
-- Server version: 10.11.13-MariaDB-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vibe_templates`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `action` varchar(100) NOT NULL,
  `target_type` varchar(50) DEFAULT NULL,
  `target_id` int(10) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `user_id`, `action`, `target_type`, `target_id`, `description`, `created_at`) VALUES
(9, 9, 'created', 'task', 47, 'created task \"title 23\"', '2025-10-20 12:06:35'),
(12, 9, 'created', 'task', 50, 'created task \"Wash car\"', '2025-11-10 16:13:35'),
(13, 9, 'created', 'task', 51, 'created task \"Wash car\"', '2025-11-10 16:14:01'),
(14, 9, 'created', 'task', 52, 'created task \"Wash car\"', '2025-11-10 16:14:14'),
(15, 9, 'created', 'task', 53, 'created task \"Define self-driving car cleaning protocol\"', '2025-11-10 16:15:33'),
(16, 9, 'created', 'task', 54, 'created task \"Define self-driving car cleaning protocol\"', '2025-11-10 16:15:42'),
(17, 9, 'logged_in', 'user', NULL, 'User logged in', '2025-11-15 03:12:45'),
(19, 9, 'logged_in', 'user', NULL, 'User logged in', '2025-11-15 15:50:53'),
(20, 9, 'logged_in', 'user', NULL, 'User logged in', '2025-11-15 15:51:19'),
(21, 9, 'logged_in', 'user', NULL, 'User logged in', '2025-11-15 15:52:14'),
(22, 9, 'logged_in', 'user', NULL, 'User logged in', '2025-11-15 15:54:36'),
(23, 9, 'logged_in', 'user', NULL, 'User logged in', '2025-11-15 15:55:41'),
(24, 9, 'logged_in', 'user', NULL, 'User logged in', '2025-11-15 15:56:28'),
(25, 9, 'logged_in', 'user', NULL, 'User logged in', '2025-11-15 15:56:41'),
(26, 9, 'logged_in', 'user', NULL, 'User logged in', '2025-11-15 15:57:24'),
(27, 9, 'logged_in', 'user', NULL, 'User logged in', '2025-11-15 16:19:55'),
(28, 9, 'updated', 'task', 40, 'Changed status from In progress to Review: Record a Reel', '2025-11-15 17:14:19'),
(29, 9, 'logged_in', 'user', NULL, 'User logged in', '2025-11-15 18:20:39'),
(30, 9, 'logged_in', 'user', NULL, 'User logged in', '2025-11-15 22:05:04'),
(31, 9, 'created', 'task', 59, 'Created task: Test Task', '2025-11-15 22:05:24'),
(32, 9, 'created', 'task', 60, 'Created task: Test Task', '2025-11-15 22:05:25'),
(33, 9, 'created', 'task', 61, 'Created task: Test Task', '2025-11-15 22:05:27'),
(34, 9, 'created', 'task', 62, 'Created task: Test Task', '2025-11-15 22:05:27'),
(35, 9, 'created', 'task', 63, 'Created task: Test Task', '2025-11-15 22:05:28'),
(36, 9, 'task_created', 'task', 64, 'Created task: My first task', '2025-11-17 15:44:19'),
(37, 9, 'task_deleted', 'task', 47, 'Deleted task: title 23', '2025-11-17 15:47:28'),
(38, 9, 'task_deleted', 'task', 54, 'Deleted task: Define self-driving car cleaning protocol', '2025-11-17 15:47:49'),
(39, 9, 'task_deleted', 'task', 54, 'Deleted task: Define self-driving car cleaning protocol', '2025-11-17 15:47:58'),
(40, 9, 'task_deleted', 'task', 54, 'Deleted task: Define self-driving car cleaning protocol', '2025-11-17 15:48:40'),
(41, 9, 'task_completed', 'task', 64, 'Completed task: My first task', '2025-11-17 17:01:31'),
(42, 9, 'task_reopened', 'task', 64, 'Reopened task: My first task', '2025-11-17 17:01:42'),
(43, 9, 'task_completed', 'task', 64, 'Completed task: My first task', '2025-11-17 17:03:08'),
(44, 9, 'task_reopened', 'task', 64, 'Reopened task: My first task', '2025-11-17 17:03:09'),
(45, 9, 'task_created', 'task', 65, 'Created task: My Second Task', '2025-11-17 17:25:52'),
(46, 9, 'task_deleted', 'task', 65, 'Deleted task: My Second Task', '2025-11-17 17:35:29'),
(47, 9, 'task_updated', 'task', 64, 'Updated task: My first task (changed: due date)', '2025-11-17 17:44:40'),
(48, 9, 'task_updated', 'task', 64, 'Updated task: My first task (changed: due date)', '2025-11-17 17:49:33'),
(49, 9, 'task_completed', 'task', 64, 'Completed task: My first task', '2025-11-17 17:50:34'),
(50, 9, 'task_updated', 'task', 53, 'Updated task: Define self-driving car cleaning protocol (changed: priority, due date)', '2025-11-17 18:14:41'),
(51, 9, 'task_updated', 'task', 54, 'Updated task: Define self-driving car cleaning protocol (changed: assignee)', '2025-11-17 18:17:03'),
(52, 9, 'task_status_changed', 'task', 43, 'Changed status from \'To Do\' to \'In Progress\' for task: Charge EUC', '2025-11-17 18:49:29'),
(53, 9, 'task_archived', 'task', 64, 'Archived task: My first task', '2025-11-17 19:04:20'),
(54, 9, 'task_archived', 'task', 64, 'Archived task: My first task', '2025-11-17 19:17:00'),
(55, 9, 'task_status_changed', 'task', 43, 'Changed status from \'In Progress\' to \'To Do\' for task: Charge EUC', '2025-11-17 19:19:39'),
(56, 9, 'task_updated', 'task', 47, 'Updated task: title 23 (changed: assignee)', '2025-11-17 19:20:18'),
(57, 9, 'task_updated', 'task', 43, 'Updated task: Charge EUC (changed: due date, category, tags)', '2025-11-17 19:21:21'),
(58, 9, 'task_completed', 'task', 43, 'Completed task: Charge EUC', '2025-11-17 19:21:32'),
(59, 9, 'task_updated', 'task', 39, 'Updated task: My first test (changed: description, due date)', '2025-11-17 19:27:18'),
(60, 9, 'task_created', 'task', 66, 'Created task: First Activity Task', '2025-11-17 19:52:42'),
(61, 9, 'task_status_changed', 'task', 66, 'Changed status from \'To Do\' to \'In Progress\' for task: First Activity Task', '2025-11-17 22:16:01'),
(62, 9, 'task_archived', 'task', 43, 'Archived task: Charge EUC', '2025-11-17 22:16:17');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(10) UNSIGNED NOT NULL,
  `team_id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `all_day` tinyint(1) DEFAULT 0,
  `color` varchar(7) DEFAULT '#3788d8',
  `type` enum('event','meeting','appointment','reminder') DEFAULT 'event',
  `status` enum('scheduled','cancelled','completed') DEFAULT 'scheduled',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_attendees`
--

CREATE TABLE `event_attendees` (
  `id` int(10) UNSIGNED NOT NULL,
  `event_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `response_status` enum('pending','accepted','declined','tentative') DEFAULT 'pending',
  `is_organizer` tinyint(1) DEFAULT 0,
  `notes` text DEFAULT NULL,
  `responded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `related_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `read_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NOT NULL,
  `used_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saved_filters`
--

CREATE TABLE `saved_filters` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `filters` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(128) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` enum('text','number','boolean','json','encrypted') DEFAULT 'text',
  `description` varchar(500) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_type`, `description`, `category`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'SaaS Template', 'text', 'The name of your site', 'general', '2025-09-23 15:19:40', '2025-09-23 15:19:40'),
(2, 'site_description', 'A modern SaaS application template', 'text', 'Brief description of your site', 'general', '2025-09-23 15:19:40', '2025-09-23 15:19:40'),
(3, 'max_file_size', '10485760', 'number', 'Maximum file upload size in bytes', 'limits', '2025-09-23 15:19:40', '2025-09-23 15:19:40'),
(4, 'max_team_members', '50', 'number', 'Maximum members allowed per team', 'limits', '2025-09-23 15:19:40', '2025-09-23 15:19:40'),
(5, 'max_teams_per_user', '10', 'number', 'Maximum teams a user can join', 'limits', '2025-09-23 15:19:40', '2025-09-23 15:19:40'),
(6, 'allow_registration', '1', 'boolean', 'Allow new users to register', 'security', '2025-09-23 15:19:40', '2025-09-23 15:19:40'),
(7, 'require_email_verification', '0', 'boolean', 'Require email verification for new users', 'security', '2025-09-23 15:19:40', '2025-09-23 15:19:40'),
(8, 'session_timeout', '1440', 'number', 'Session timeout in seconds', 'security', '2025-09-23 15:19:40', '2025-09-24 14:15:02'),
(9, 'password_min_length', '8', 'number', 'Minimum password length', 'security', '2025-09-23 15:19:40', '2025-09-24 14:15:02'),
(10, 'enable_notifications', '1', 'boolean', 'Enable system notifications', 'features', '2025-09-23 15:19:40', '2025-09-23 15:19:40'),
(11, 'enable_api', '1', 'boolean', 'Enable API access', 'features', '2025-09-23 15:19:40', '2025-09-23 15:19:40'),
(12, 'api_rate_limit', '100', 'number', 'API rate limit per hour', 'security', '2025-09-23 15:19:40', '2025-09-23 15:19:40'),
(13, 'maintenance_mode', 'off', 'boolean', 'Enable maintenance mode', 'system', '2025-09-23 15:19:40', '2025-09-24 14:15:02'),
(14, 'maintenance_message', 'We are currently performing maintenance. Please check back later.', 'text', 'Message shown during maintenance', 'system', '2025-09-23 15:19:40', '2025-09-23 15:19:40'),
(15, 'smtp_host', '', 'text', 'SMTP server hostname', 'email', '2025-09-23 15:19:40', '2025-09-23 15:19:40'),
(16, 'smtp_port', '587', 'number', 'SMTP server port', 'email', '2025-09-23 15:19:40', '2025-09-23 15:19:40'),
(17, 'smtp_username', '', 'text', 'SMTP username', 'email', '2025-09-23 15:19:40', '2025-09-23 15:19:40'),
(18, 'smtp_password', '', 'encrypted', 'SMTP password', 'email', '2025-09-23 15:19:40', '2025-09-23 15:19:40'),
(19, 'smtp_from_email', '', 'text', 'From email address', 'email', '2025-09-23 15:19:40', '2025-09-23 15:19:40'),
(20, 'smtp_from_name', '', 'text', 'From name for emails', 'email', '2025-09-23 15:19:40', '2025-09-23 15:19:40'),
(21, 'date_format', 'Y-m-d', 'text', 'Date format for display', 'localization', '2025-09-23 15:19:40', '2025-09-24 14:15:02'),
(22, 'time_format', 'H:i:s', 'text', 'Time format for display', 'localization', '2025-09-23 15:19:40', '2025-09-23 15:19:40'),
(23, 'timezone', 'America/New_York', 'text', 'Default timezone', 'localization', '2025-09-23 15:19:40', '2025-09-24 14:15:02'),
(24, 'navigation_layout', 'sidenav', 'text', NULL, NULL, '2025-09-23 15:29:58', '2025-09-23 15:32:25'),
(25, 'max_users', '100', 'text', NULL, NULL, '2025-09-24 14:15:02', '2025-09-24 14:15:02'),
(26, 'default_user_role', 'team_leader', 'text', NULL, NULL, '2025-09-24 14:15:02', '2025-09-24 14:15:02'),
(27, 'user_registration', 'enabled', 'text', NULL, NULL, '2025-09-24 14:15:02', '2025-09-24 14:15:02'),
(28, 'task_auto_archive_days', '30', 'text', NULL, NULL, '2025-09-24 14:15:02', '2025-09-24 14:15:02'),
(29, 'task_priority_levels', 'Low,Medium,High,Critical', 'text', NULL, NULL, '2025-09-24 14:15:02', '2025-09-24 14:15:02'),
(30, 'task_status_options', 'Todo,In Progress,Review,Done', 'text', NULL, NULL, '2025-09-24 14:15:02', '2025-09-24 14:15:02'),
(31, 'default_task_priority', 'Medium', 'text', NULL, NULL, '2025-09-24 14:15:02', '2025-09-24 14:15:02'),
(32, 'email_notifications', 'enabled', 'text', NULL, NULL, '2025-09-24 14:15:02', '2025-09-24 14:15:02'),
(33, 'notification_frequency', 'immediate', 'text', NULL, NULL, '2025-09-24 14:15:02', '2025-09-24 14:15:02');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  `assigned_to` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','in_progress','review','completed','cancelled','archived') DEFAULT 'pending',
  `priority` enum('low','medium','high','critical') DEFAULT 'medium',
  `due_date` date DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `category` varchar(100) DEFAULT NULL COMMENT 'Task category',
  `tags` text DEFAULT NULL COMMENT 'Comma-separated tags',
  `created_by` int(10) UNSIGNED DEFAULT NULL COMMENT 'User ID who created the task',
  `project` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `team_id`, `assigned_to`, `title`, `description`, `status`, `priority`, `due_date`, `completed_at`, `created_at`, `updated_at`, `category`, `tags`, `created_by`, `project`) VALUES
(39, 9, 5, 9, 'My first test', '', 'review', 'medium', '2025-11-20', NULL, '2025-09-26 18:51:42', '2025-11-17 19:27:18', NULL, NULL, NULL, NULL),
(40, 9, 5, NULL, 'Record a Reel', 'Record your morning reel about Retreival Augmented Generation', 'completed', 'medium', '2025-09-26', '2025-11-15 17:18:57', '2025-09-26 18:52:30', '2025-11-15 17:18:57', NULL, NULL, NULL, NULL),
(43, 9, 5, 9, 'Charge EUC', 'It is time to charge the unicycle.', 'archived', 'medium', '2025-11-28', '2025-11-17 19:21:32', '2025-09-26 19:08:45', '2025-11-17 22:16:17', '', '', 9, NULL),
(47, 9, 5, NULL, 'title 23', 'der', 'completed', 'critical', '2025-10-20', '2025-11-17 19:20:18', '2025-10-20 12:06:35', '2025-11-17 19:20:18', NULL, NULL, NULL, NULL),
(50, 9, 5, NULL, 'Wash car', 'Drive the car to the car wash, check your current position in the line, and confirm the cost. Then watch and wait', 'pending', 'medium', '2025-11-11', NULL, '2025-11-10 16:13:35', '2025-11-10 16:13:35', NULL, NULL, NULL, NULL),
(51, 9, 5, NULL, 'Wash car', 'Drive the car to the car wash, check your current position in the line, and confirm the cost. Then watch and wait', 'in_progress', 'critical', '2025-11-11', NULL, '2025-11-10 16:14:01', '2025-11-15 13:59:45', NULL, NULL, NULL, NULL),
(52, 9, 5, NULL, 'Wash car', 'Drive the car to the car wash, check your current position in the line, and confirm the cost. Then watch and wait', 'pending', 'critical', '2025-11-11', NULL, '2025-11-10 16:14:14', '2025-11-10 16:14:14', NULL, NULL, NULL, NULL),
(53, 9, 5, NULL, 'Define self-driving car cleaning protocol', 'Drive the car to the car wash, check your current position in the line, and confirm the cost. Then watch and wait', 'pending', 'low', '2025-11-29', NULL, '2025-11-10 16:15:33', '2025-11-17 18:14:41', NULL, NULL, NULL, NULL),
(54, 9, 5, NULL, 'Define self-driving car cleaning protocol', 'Drive the car to the car wash, check your current position in the line, and confirm the cost. Then watch and wait', 'pending', 'critical', '2025-11-11', NULL, '2025-11-10 16:15:42', '2025-11-17 18:17:03', NULL, NULL, NULL, NULL),
(56, 9, NULL, NULL, 'My First Task', 'My first description', 'pending', 'medium', NULL, NULL, '2025-11-15 18:46:10', '2025-11-17 18:19:45', NULL, NULL, 9, NULL),
(57, 9, NULL, NULL, 'Task', 'Task', 'in_progress', 'medium', NULL, NULL, '2025-11-15 18:46:27', '2025-11-17 18:19:43', NULL, NULL, 9, NULL),
(58, 9, NULL, NULL, 'Test Task', '', 'pending', 'medium', NULL, NULL, '2025-11-15 19:32:08', '2025-11-17 18:19:41', NULL, NULL, 9, NULL),
(59, 9, NULL, NULL, 'Test Task', '', 'pending', 'medium', '2025-11-22', NULL, '2025-11-15 22:05:24', '2025-11-17 18:19:37', NULL, NULL, 9, NULL),
(60, 9, NULL, NULL, 'Test Task', '', 'pending', 'medium', '2025-11-22', NULL, '2025-11-15 22:05:25', '2025-11-17 18:19:34', NULL, NULL, 9, NULL),
(61, 9, NULL, NULL, 'Test Task', '', 'pending', 'medium', '2025-11-22', NULL, '2025-11-15 22:05:27', '2025-11-17 18:19:32', NULL, NULL, 9, NULL),
(62, 9, NULL, NULL, 'Test Task', '', 'pending', 'medium', '2025-11-22', NULL, '2025-11-15 22:05:27', '2025-11-17 18:19:06', NULL, NULL, 9, NULL),
(63, 9, NULL, NULL, 'Test Task', '', 'pending', 'medium', '2025-11-22', NULL, '2025-11-15 22:05:28', '2025-11-17 18:19:03', NULL, NULL, 9, NULL),
(64, 9, 5, 9, 'My first task', 'My First Description', 'archived', 'medium', '2025-11-22', '2025-11-17 18:17:25', '2025-11-17 15:44:19', '2025-11-17 19:17:00', NULL, NULL, 9, NULL),
(66, 9, 5, 9, 'First Activity Task', NULL, 'in_progress', 'medium', '2025-11-29', NULL, '2025-11-17 19:52:42', '2025-11-17 22:16:01', NULL, NULL, 9, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `description`, `created_by`, `created_at`, `updated_at`) VALUES
(5, 'Default Team', NULL, 9, '2025-09-26 18:51:14', '2025-09-26 18:51:14'),
(6, 'Test\'s Team', 'Default team', 16, '2025-11-15 02:58:52', '2025-11-15 02:58:52'),
(11, 'Test Team 1763421886', 'A test team description', 9, '2025-11-17 23:24:46', '2025-11-17 23:24:46'),
(12, 'Super Team', 'This is my super team.', 9, '2025-11-17 23:26:13', '2025-11-17 23:26:13');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role` enum('member','admin') DEFAULT 'member',
  `joined_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `team_id`, `user_id`, `role`, `joined_at`) VALUES
(10, 5, 9, 'member', '2025-09-26 18:51:14'),
(20, 6, 16, 'admin', '2025-11-15 02:58:52'),
(22, 6, 9, 'member', '2025-11-17 22:57:00'),
(24, 11, 9, 'admin', '2025-11-17 23:24:46'),
(25, 12, 9, 'admin', '2025-11-17 23:26:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `current_team` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `role` enum('user','admin','super_admin') DEFAULT 'user',
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `current_team`, `email`, `password`, `first_name`, `last_name`, `username`, `role`, `status`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(9, 5, 'admin@localhost.com', '$2y$12$3ERJcvC8kumCYTseiyNaWeIDzMTPDgLyxJg5t81nPR9OA.xb4WTMq', 'Demo', 'User', NULL, 'admin', 'active', NULL, NULL, '2025-09-25 20:40:08', '2025-11-17 23:07:36'),
(16, NULL, 'testuser@example.com', '$2y$12$sZfkUOXbllC9vufv9dpfJepky0nDm1/2kOXzNTrwKrDUR24vDs2au', 'Test', 'User', NULL, 'user', 'active', NULL, NULL, '2025-11-15 02:58:52', '2025-11-15 02:58:52');

-- --------------------------------------------------------

--
-- Table structure for table `user_settings`
--

CREATE TABLE `user_settings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `value` longtext DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_action` (`action`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_team_id` (`team_id`),
  ADD KEY `idx_created_by` (`created_by`),
  ADD KEY `idx_start_datetime` (`start_datetime`),
  ADD KEY `idx_end_datetime` (`end_datetime`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `event_attendees`
--
ALTER TABLE `event_attendees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_event_user` (`event_id`,`user_id`),
  ADD KEY `idx_event_id` (`event_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_response_status` (`response_status`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_unread` (`user_id`,`is_read`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_token` (`token`),
  ADD KEY `idx_expires_at` (`expires_at`);

--
-- Indexes for table `saved_filters`
--
ALTER TABLE `saved_filters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_filter_name` (`user_id`,`name`),
  ADD KEY `idx_user` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_last_activity` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`),
  ADD KEY `idx_setting_key` (`setting_key`),
  ADD KEY `idx_category` (`category`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_priority` (`priority`),
  ADD KEY `idx_due_date` (`due_date`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_created_by` (`created_by`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_team_member` (`team_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `current_team` (`current_team`);

--
-- Indexes for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_key` (`user_id`,`setting_key`),
  ADD KEY `idx_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event_attendees`
--
ALTER TABLE `event_attendees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saved_filters`
--
ALTER TABLE `saved_filters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_settings`
--
ALTER TABLE `user_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_events_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_attendees`
--
ALTER TABLE `event_attendees`
  ADD CONSTRAINT `fk_attendees_event_id` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_attendees_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_tasks_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `team_members`
--
ALTER TABLE `team_members`
  ADD CONSTRAINT `team_members_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `team_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`current_team`) REFERENCES `teams` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
