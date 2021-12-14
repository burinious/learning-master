-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2019 at 09:03 AM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `email` longtext NOT NULL,
  `salt` longtext NOT NULL,
  `password` longtext NOT NULL,
  `security_code` varchar(100) DEFAULT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(100) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `question_id` varchar(100) NOT NULL,
  `subject_id` varchar(100) NOT NULL,
  `chosen_option` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `student_id`, `question_id`, `subject_id`, `chosen_option`, `created_at`, `updated_at`) VALUES
(1, '2', '1', '6', 'b', '2018-12-28 21:37:09', '2018-12-28 21:37:09'),
(2, '2', '3', '6', 'b', '2018-12-28 21:37:09', '2018-12-28 21:37:09'),
(3, '3', '1', '6', 'b', '2019-01-25 10:24:16', '2019-01-25 10:24:16'),
(4, '3', '3', '6', 'b', '2019-01-25 10:24:16', '2019-01-25 10:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(100) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `tutor_id` varchar(100) NOT NULL,
  `title` longtext NOT NULL,
  `content` longtext NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '0',
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `student_id`, `tutor_id`, `title`, `content`, `status`, `created_at`, `updated_at`) VALUES
(2, '2', '3', 'How can we', 'Please how and when will you be less busy. I need an explanation on Shannon theory<br>', '0', '2018-12-18 13:46:20', '2018-12-18 13:46:20'),
(3, '2', '2', 'pokpo', 'pkp', '1', '2018-12-20 01:12:36', '2018-12-22 20:35:36'),
(4, '7', '4', 'Olabiyi', 'I think this is awesome. Can we chat please?<br>', '1', '2018-12-27 00:47:04', '2018-12-27 00:48:10'),
(5, '7', '3', 'siojiojioj', 'so', '0', '2018-12-27 00:48:53', '2018-12-27 00:48:53'),
(6, '7', '4', 'wow', 'sos', '0', '2018-12-27 00:49:09', '2018-12-27 00:49:09'),
(7, '3', '4', 'BRIEF OBITUARY OF REV. FR. ROBERT DUNDO S.J 1932 -2016', '[psl', '1', '2019-01-25 10:16:46', '2019-01-25 10:18:10'),
(8, '2', '4', 'owdioj', 'sposps', '0', '2019-02-12 17:00:07', '2019-02-12 17:00:07');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_chat`
--

CREATE TABLE `appointment_chat` (
  `id` int(100) NOT NULL,
  `appointment_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointment_chat`
--

INSERT INTO `appointment_chat` (`id`, `appointment_id`, `user_id`, `type`, `content`, `created_at`, `updated_at`) VALUES
(1, '2', '2', 'student', 'This is cool', '2018-12-18 13:46:35', '2018-12-18 13:46:35'),
(2, '2', '2', 'student', 'wow', '2018-12-18 13:46:39', '2018-12-18 13:46:39'),
(3, '3', '2', 'student', 'pok', '2018-12-20 01:12:49', '2018-12-20 01:12:49'),
(4, '3', '2', 'tutor', 'wow', '2018-12-22 20:21:46', '2018-12-22 20:21:46'),
(5, '3', '2', 'student', 'really?', '2018-12-22 20:22:10', '2018-12-22 20:22:10'),
(6, '3', '2', 'tutor', 'yes na', '2018-12-22 20:22:24', '2018-12-22 20:22:24'),
(7, '3', '2', 'student', 'hmmm', '2018-12-22 20:22:32', '2018-12-22 20:22:32'),
(8, '4', '4', 'tutor', 'Okay. whatsup', '2018-12-27 00:47:38', '2018-12-27 00:47:38'),
(9, '4', '7', 'student', 'I am good sir and you?', '2018-12-27 00:47:52', '2018-12-27 00:47:52'),
(10, '4', '4', 'tutor', 'I am fine.', '2018-12-27 00:48:01', '2018-12-27 00:48:01'),
(11, '3', '2', 'tutor', 'wow', '2018-12-27 05:54:29', '2018-12-27 05:54:29'),
(12, '3', '2', 'student', 'cool', '2018-12-27 05:54:36', '2018-12-27 05:54:36'),
(13, '3', '2', 'tutor', 'wow', '2018-12-27 05:55:28', '2018-12-27 05:55:28'),
(14, '3', '2', 'student', 'hmm', '2018-12-27 05:55:35', '2018-12-27 05:55:35'),
(15, '3', '2', 'tutor', 'okayy', '2018-12-27 05:56:49', '2018-12-27 05:56:49'),
(16, '3', '2', 'student', 'hmm', '2018-12-27 05:56:54', '2018-12-27 05:56:54'),
(17, '3', '2', 'tutor', 'oococo', '2018-12-27 05:57:18', '2018-12-27 05:57:18'),
(18, '3', '2', 'tutor', 'cool', '2018-12-27 05:59:43', '2018-12-27 05:59:43'),
(19, '3', '2', 'student', 'okka', '2018-12-27 06:00:06', '2018-12-27 06:00:06'),
(20, '3', '2', 'tutor', 'hmm', '2018-12-27 06:01:27', '2018-12-27 06:01:27'),
(21, '3', '2', 'tutor', 'wowow', '2018-12-27 06:01:41', '2018-12-27 06:01:41'),
(22, '3', '2', 'student', 'agreed', '2018-12-27 06:01:57', '2018-12-27 06:01:57'),
(23, '3', '2', 'student', '?', '2018-12-27 06:02:00', '2018-12-27 06:02:00'),
(24, '3', '2', 'tutor', 'deal!', '2018-12-27 06:02:07', '2018-12-27 06:02:07'),
(25, '7', '4', 'tutor', 'hey', '2019-01-25 10:17:53', '2019-01-25 10:17:53'),
(26, '7', '3', 'student', 'how far', '2019-01-25 10:18:02', '2019-01-25 10:18:02');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(100) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `tutor_id` varchar(100) NOT NULL,
  `subject_id` varchar(100) NOT NULL,
  `title` varchar(200) NOT NULL,
  `path` longtext NOT NULL,
  `size` varchar(100) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `student_id`, `tutor_id`, `subject_id`, `title`, `path`, `size`, `note`, `created_at`, `updated_at`) VALUES
(1, '6', '4', '5', 'Our first publication', 'Computer Science Puzzle.pdf', '352.04 KB', 'cool', '2018-12-27 02:54:08', '2018-12-27 02:54:08'),
(2, '7', '4', '5', 'Our first publication', 'Computer Science Puzzle.pdf', '352.04 KB', 'cool', '2018-12-27 02:54:08', '2018-12-27 02:54:08'),
(3, '2', '4', '5', 'Our first publication', 'Computer Science Puzzle.pdf', '352.04 KB', 'cool', '2018-12-27 02:54:08', '2018-12-27 02:54:08'),
(4, '3', '4', '5', 'spos', '7 Keys to 1000 Times More - Mike Murdock.pdf', '758.99 KB', 'pa', '2019-01-25 10:22:53', '2019-01-25 10:22:53'),
(5, '5', '2', '6', 'iosioaioa', 'Group 11 - Information Theory.pdf', '435.00 KB', 'sopos', '2019-02-22 11:31:39', '2019-02-22 11:31:39'),
(6, '7', '2', '6', 'iosioaioa', 'Group 11 - Information Theory.pdf', '435.00 KB', 'sopos', '2019-02-22 11:31:39', '2019-02-22 11:31:39'),
(7, '2', '2', '6', 'iosioaioa', 'Group 11 - Information Theory.pdf', '435.00 KB', 'sopos', '2019-02-22 11:31:39', '2019-02-22 11:31:39');

-- --------------------------------------------------------

--
-- Table structure for table `ass_solutions`
--

CREATE TABLE `ass_solutions` (
  `id` int(100) NOT NULL,
  `assignment_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `grade` varchar(10) DEFAULT NULL,
  `obtainable` varchar(10) DEFAULT NULL,
  `path` longtext NOT NULL,
  `size` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ass_solutions`
--

INSERT INTO `ass_solutions` (`id`, `assignment_id`, `user_id`, `grade`, `obtainable`, `path`, `size`, `created_at`, `updated_at`) VALUES
(1, '2', '7', '6.5', '10', 'All BSFUI Members(1)(1).pdf', '103.64 KB', '2018-12-27 02:54:45', '2018-12-27 03:27:11'),
(2, '3', '2', NULL, NULL, 'Computer Science Puzzle.pdf', '352.04 KB', '2018-12-27 03:28:07', '2018-12-27 03:28:07'),
(3, '4', '3', '7', '10', 'Character Study of Timothy corrected.docx', '49.00 KB', '2019-01-25 10:23:21', '2019-01-25 10:23:42');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(100) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `tutor_id` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `student_id`, `tutor_id`, `type`, `content`, `created_at`, `updated_at`) VALUES
(1, '2', '3', 'student', 'woo', '2018-12-18 13:52:44', '2018-12-18 13:52:44'),
(2, '2', '2', 'student', 'hi', '2018-12-20 01:12:18', '2018-12-20 01:12:18'),
(3, '2', '2', 'student', 'wow', '2018-12-23 14:48:14', '2018-12-23 14:48:14'),
(4, '2', '2', 'tutor', 'for real', '2018-12-23 14:52:07', '2018-12-23 14:52:07'),
(5, '2', '2', 'student', 'hmm', '2018-12-23 14:52:44', '2018-12-23 14:52:44'),
(6, '2', '2', 'tutor', 'why hmming?', '2018-12-23 14:52:57', '2018-12-23 14:52:57'),
(7, '2', '2', 'student', 'wire', '2018-12-23 14:54:16', '2018-12-23 14:54:16'),
(8, '2', '2', 'tutor', 'Black or red?', '2018-12-23 14:54:29', '2018-12-23 14:54:29'),
(9, '2', '2', 'tutor', 'pink', '2018-12-23 14:58:34', '2018-12-23 14:58:34'),
(11, '5', '2', 'student', 'halol', '2018-12-23 15:13:14', '2018-12-23 15:13:14'),
(13, '5', '3', 'tutor', 'xup', '2018-12-23 15:15:15', '2018-12-23 15:15:15'),
(14, '5', '3', 'student', 'cool', '2018-12-23 15:15:23', '2018-12-23 15:15:23'),
(15, '7', '4', 'student', 'whatsup', '2018-12-27 00:51:09', '2018-12-27 00:51:09'),
(16, '7', '4', 'tutor', 'i am good', '2018-12-27 00:51:17', '2018-12-27 00:51:17'),
(17, '7', '4', 'student', 'cool', '2018-12-27 00:51:23', '2018-12-27 00:51:23'),
(18, '7', '4', 'tutor', 'hmm', '2018-12-27 00:51:29', '2018-12-27 00:51:29'),
(19, '7', '4', 'student', 'This is awesome', '2018-12-27 00:51:37', '2018-12-27 00:51:37'),
(20, '7', '4', 'tutor', 'yeah. thanks man', '2018-12-27 00:51:45', '2018-12-27 00:51:45'),
(21, '2', '4', 'tutor', 'helllo', '2018-12-27 00:52:06', '2018-12-27 00:52:06'),
(22, '2', '4', 'student', 'hi', '2018-12-31 07:39:55', '2018-12-31 07:39:55'),
(23, '3', '4', 'student', 'hwi u', '2019-01-25 10:18:58', '2019-01-25 10:18:58'),
(24, '3', '4', 'tutor', 'i m agood', '2019-01-25 10:19:09', '2019-01-25 10:19:09');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(100) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `name` varchar(25) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `pix` longtext,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `unique_id`, `name`, `user_id`, `type`, `description`, `pix`, `created_at`, `updated_at`) VALUES
(1, '1545268398653850', 'CSC 400L', '2', 'student', 'This is my class', NULL, '2018-12-20 01:13:18', '2018-12-20 01:13:18'),
(5, '1545580436639661', 'NACOSS UI', '3', 'tutor', 'This is the group meant for the department of computer science, University of Ibadan', NULL, '2018-12-23 15:53:56', '2018-12-23 15:53:56'),
(6, '1545582543952439', 'wow', '5', 'student', 'Sposko', NULL, '2018-12-23 16:29:03', '2018-12-23 16:32:17'),
(7, '1545871948127400', 'CSC 400', '7', 'student', 'Coolest', NULL, '2018-12-27 00:52:28', '2018-12-27 01:33:58'),
(8, '1548411598350210', 'CSC 4OOL s', '3', 'student', 'This is us', NULL, '2019-01-25 10:19:58', '2019-01-25 10:21:27'),
(9, '1550834868375308', 'gd', '2', 'tutor', 'fsfsf', NULL, '2019-02-22 11:27:48', '2019-02-22 11:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `group_chat`
--

CREATE TABLE `group_chat` (
  `id` int(100) NOT NULL,
  `group_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_chat`
--

INSERT INTO `group_chat` (`id`, `group_id`, `user_id`, `type`, `content`, `created_at`, `updated_at`) VALUES
(1, '1', '2', 'student', 'moxopx', '2018-12-20 01:13:53', '2018-12-20 01:13:53'),
(2, '5', '3', 'tutor', 'cool', '2018-12-23 15:56:46', '2018-12-23 15:56:46'),
(3, '5', '3', 'tutor', 'whatwhatwhatwhatwhat\r\nwhatwhatwhatwhatwhatwhatwhatwhatwhatwhat\r\nwhatwhatwhatwhatwhatwhatwhatwhatwhatwhat\r\nwhatwhatwhatwhatwhatwhat', '2018-12-23 16:06:51', '2018-12-23 16:06:51'),
(5, '5', '5', 'student', 'cool', '2018-12-23 16:15:09', '2018-12-23 16:15:09'),
(6, '5', '5', 'student', 'and damn harmattanish', '2018-12-23 16:16:04', '2018-12-23 16:16:04'),
(7, '5', '3', 'tutor', 'Really?', '2018-12-23 16:16:12', '2018-12-23 16:16:12'),
(8, '7', '7', 'student', 'hey', '2018-12-27 00:52:53', '2018-12-27 00:52:53'),
(10, '7', '4', 'tutor', 'hi', '2018-12-27 01:35:48', '2018-12-27 01:35:48'),
(11, '8', '4', 'tutor', 'dposkps', '2019-01-25 10:20:58', '2019-01-25 10:20:58'),
(12, '8', '3', 'student', 'spoksp', '2019-01-25 10:21:07', '2019-01-25 10:21:07');

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `id` int(100) NOT NULL,
  `group_id` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_members`
--

INSERT INTO `group_members` (`id`, `group_id`, `type`, `user_id`, `created_at`, `updated_at`) VALUES
(2, '1', 'student', '3', '2018-12-20 01:13:18', '2018-12-20 01:13:18'),
(3, '1', 'tutor', '2', '2018-12-20 01:13:18', '2018-12-20 01:13:18'),
(4, '1', 'student', '2', '2018-12-20 01:13:18', '2018-12-20 01:13:18'),
(16, '5', 'student', '5', '2018-12-23 15:53:56', '2018-12-23 15:53:56'),
(17, '5', 'student', '2', '2018-12-23 15:53:56', '2018-12-23 15:53:56'),
(18, '5', 'tutor', '2', '2018-12-23 15:53:56', '2018-12-23 15:53:56'),
(19, '5', 'tutor', '3', '2018-12-23 15:53:56', '2018-12-23 15:53:56'),
(21, '5', 'student', '3', '2018-12-23 16:24:02', '2018-12-23 16:24:02'),
(22, '6', 'student', '3', '2018-12-23 16:29:03', '2018-12-23 16:29:03'),
(23, '6', 'student', '2', '2018-12-23 16:29:03', '2018-12-23 16:29:03'),
(24, '6', 'tutor', '3', '2018-12-23 16:29:03', '2018-12-23 16:29:03'),
(25, '6', 'tutor', '2', '2018-12-23 16:29:03', '2018-12-23 16:29:03'),
(26, '6', 'student', '5', '2018-12-23 16:29:03', '2018-12-23 16:29:03'),
(31, '7', 'student', '7', '2018-12-27 00:52:29', '2018-12-27 00:52:29'),
(82, '7', 'student', '5', '2018-12-27 01:31:26', '2018-12-27 01:31:26'),
(85, '7', 'student', '6', '2018-12-27 01:33:36', '2018-12-27 01:33:36'),
(86, '7', 'student', '2', '2018-12-27 01:33:36', '2018-12-27 01:33:36'),
(87, '7', 'tutor', '1', '2018-12-27 01:33:36', '2018-12-27 01:33:36'),
(88, '7', 'student', '3', '2018-12-27 01:33:51', '2018-12-27 01:33:51'),
(89, '7', 'tutor', '2', '2018-12-27 01:33:51', '2018-12-27 01:33:51'),
(91, '7', 'tutor', '4', '2018-12-27 01:35:30', '2018-12-27 01:35:30'),
(92, '8', 'student', '6', '2019-01-25 10:19:58', '2019-01-25 10:19:58'),
(93, '8', 'student', '5', '2019-01-25 10:19:58', '2019-01-25 10:19:58'),
(94, '8', 'student', '2', '2019-01-25 10:19:58', '2019-01-25 10:19:58'),
(95, '8', 'tutor', '2', '2019-01-25 10:19:58', '2019-01-25 10:19:58'),
(96, '8', 'student', '3', '2019-01-25 10:19:58', '2019-01-25 10:19:58'),
(97, '8', 'student', '7', '2019-01-25 10:20:27', '2019-01-25 10:20:27'),
(98, '8', 'tutor', '4', '2019-01-25 10:20:27', '2019-01-25 10:20:27'),
(99, '9', 'student', '7', '2019-02-22 11:27:48', '2019-02-22 11:27:48'),
(100, '9', 'student', '6', '2019-02-22 11:27:48', '2019-02-22 11:27:48'),
(101, '9', 'student', '3', '2019-02-22 11:27:48', '2019-02-22 11:27:48'),
(102, '9', 'tutor', '2', '2019-02-22 11:27:48', '2019-02-22 11:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(100) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `tutor_id` varchar(100) NOT NULL,
  `subject_id` varchar(100) NOT NULL,
  `title` varchar(200) NOT NULL,
  `path` longtext NOT NULL,
  `size` varchar(100) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `student_id`, `tutor_id`, `subject_id`, `title`, `path`, `size`, `note`, `created_at`, `updated_at`) VALUES
(1, '2', '3', '4', 'List of BSFUI Members', 'All BSFUI Members.pdf', '104KB', 'This is the material', '2018-12-11 08:32:35', '2018-12-11 08:32:35'),
(2, '2', '2', '5', 'How to write a professional proposal', 'Proposal.docx', '29KB', 'This is the proposal', '2018-12-13 09:30:35', '2018-08-13 09:30:35'),
(5, '5', '2', '6', 'wow', 'Character Study of Timothy corrected.docx', '49.00 KB', 'cpool aldn cool', '2018-12-23 14:04:42', '2018-12-23 14:04:42'),
(6, '3', '2', '6', 'wow', 'Character Study of Timothy corrected.docx', '49.00 KB', 'cpool aldn cool', '2018-12-23 14:04:42', '2018-12-23 14:04:42'),
(7, '7', '4', '5', 'cool', 'All BSFUI Members(1).pdf', '103.64 KB', 'ssopsk', '2018-12-27 02:06:24', '2018-12-27 02:06:24'),
(8, '5', '4', '5', 'ososi', '7 Days Behind the Veil_ Throne  - John Paul Jackson_160518040343.pdf', '529.82 KB', 'pospos', '2019-01-25 10:21:55', '2019-01-25 10:21:55'),
(9, '6', '4', '5', 'ososi', '7 Days Behind the Veil_ Throne  - John Paul Jackson_160518040343.pdf', '529.82 KB', 'pospos', '2019-01-25 10:21:55', '2019-01-25 10:21:55'),
(10, '7', '4', '5', 'ososi', '7 Days Behind the Veil_ Throne  - John Paul Jackson_160518040343.pdf', '529.82 KB', 'pospos', '2019-01-25 10:21:55', '2019-01-25 10:21:55'),
(11, '3', '4', '5', 'spos', '7 Keys to 1000 Times More - Mike Murdock.pdf', '758.99 KB', 'spos', '2019-01-25 10:22:17', '2019-01-25 10:22:17');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(100) NOT NULL,
  `subject_id` varchar(100) NOT NULL,
  `tutor_id` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `question` longtext NOT NULL,
  `a` longtext,
  `b` longtext,
  `c` longtext,
  `d` longtext,
  `answer` varchar(100) DEFAULT NULL,
  `answer_long` longtext,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `subject_id`, `tutor_id`, `type`, `question`, `a`, `b`, `c`, `d`, `answer`, `answer_long`, `created_at`, `updated_at`) VALUES
(1, '6', '2', 'multiple', 'Who is the president of Nigeria', 'Muhammed Buhari', 'Jubril', 'Atiku', 'Obasanjo', 'a', NULL, '2018-12-28 19:20:06', '2018-12-28 19:20:06'),
(3, '6', '2', 'multiple', 'When is this year\'s election', 'January', 'Feburary', 'March', 'April', 'c', NULL, '2018-12-28 19:42:15', '2018-12-28 20:05:18'),
(4, '6', '2', 'boolean', 'Is God dead?', NULL, NULL, NULL, NULL, 'false', NULL, '2019-02-22 11:33:43', '2019-02-22 11:33:43');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(100) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `tutor_id` varchar(100) NOT NULL,
  `rating` varchar(255) NOT NULL,
  `feedback` longtext,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `student_id`, `tutor_id`, `rating`, `feedback`, `created_at`, `updated_at`) VALUES
(1, '2', '3', '3', 'cool', '2018-12-18 13:44:14', '2018-12-18 13:44:14'),
(2, '7', '4', '3', 'cool', '2018-12-27 00:46:31', '2018-12-27 00:46:31'),
(3, '7', '2', '2', 'bad', '2018-12-27 00:50:45', '2018-12-27 00:50:45');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(100) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `surname` longtext NOT NULL,
  `firstname` longtext NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `salt` longtext NOT NULL,
  `password` longtext NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT '1',
  `class` varchar(100) NOT NULL,
  `pix` longtext,
  `address` longtext,
  `type` varchar(100) DEFAULT 'student',
  `about` longtext,
  `security_code` longtext,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `surname`, `firstname`, `email`, `phone`, `salt`, `password`, `status`, `class`, `pix`, `address`, `type`, `about`, `security_code`, `created_at`, `updated_at`) VALUES
(2, '927635', 'Oniosun', 'Ayodele', 'heywire4u@gmail.com', '08132016744', '$2a$05$908Ps238OBfa7vdS37z/Y$', '$2a$05$908Ps238OBfa7vdS37z/Y.9whN7inNhEaEKYZtIj2gl6nWpjFqKei', '1', 'sss1', '927635.jpg', 'ISI', 'student', 'I am a child of God', NULL, '2018-12-05 08:32:35', '2018-12-18 14:13:08'),
(3, '914303', 'Olatigbe', 'Busayo', 'admin@ccrnigeria.org', '0818289209', '$2a$05$t2zQJvpKIX51tFtd0DHKL$', '$2a$05$t2zQJvpKIX51tFtd0DHKL.roYi3mPET1h34E3MNViIfpLNDYbDEs2', '1', 'sss1', NULL, NULL, 'student', NULL, NULL, '2018-12-05 08:33:19', '2018-12-05 08:33:19'),
(5, '732200', 'Ebhiomelen', 'Ofure', 'ofure@gmail.com', '09028929', '$2a$05$JtuiSKENREnBfw2nPwgCs$', '$2a$05$JtuiSKENREnBfw2nPwgCs.Pf8pt.cw6TDbozSk8o0rqdR0XhsGpaG', '1', 'sss1', NULL, NULL, 'student', NULL, NULL, '2018-12-05 08:43:20', '2018-12-05 08:43:20'),
(6, '529014', 'Oladele', 'kolade', 'kolade@gmail.com', '08132016746', '$2a$05$4zwE/04EcxxOPbDo5unDM$', '$2a$05$4zwE/04EcxxOPbDo5unDM.I80Ui0p3s2bozUjE7shLeJkaesZDXcq', '1', 'sss2', NULL, NULL, 'student', NULL, NULL, '2018-12-27 00:37:42', '2018-12-27 00:37:42'),
(7, '505380', 'olamide', 'olaiya', 'olaiya@gmail.com', '08022892929', '$2a$05$lB/0BrzY/rSmYI5HVyub/$', '$2a$05$lB/0BrzY/rSmYI5HVyub/.NLmV80qVK5gSS094r7IhWf1Jrs99/Fm', '1', 'sss3', '505380.jpg', 'UI', 'student', 'I am a man', NULL, '2018-12-27 00:39:00', '2018-12-27 00:45:09');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(100) NOT NULL,
  `name` longtext NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'English Language', '2018-12-17 15:25:25', '2018-12-17 15:25:25'),
(2, 'Mathematics', '2018-12-17 15:25:25', '2018-12-17 15:25:25'),
(3, 'Chemistry', '2018-12-17 15:25:25', '2018-12-17 15:25:25'),
(4, 'Physics', '2018-12-17 15:25:25', '2018-12-17 15:25:25'),
(5, 'Government', '2018-12-17 15:25:25', '2018-12-17 15:25:25'),
(6, 'Economics', '2018-12-17 15:25:25', '2018-12-17 15:25:25'),
(7, 'Literature', '2018-12-17 15:25:25', '2018-12-17 15:25:25'),
(8, 'Business Studies', '2018-12-17 15:25:25', '2018-12-17 15:25:25'),
(9, 'CRS', '2018-12-17 15:25:25', '2018-12-17 15:25:25'),
(10, 'Biology', '2018-12-17 15:25:25', '2018-12-17 15:25:25');

-- --------------------------------------------------------

--
-- Table structure for table `tutors`
--

CREATE TABLE `tutors` (
  `id` int(100) NOT NULL,
  `subject_id` varchar(100) NOT NULL,
  `tutor_id` varchar(100) NOT NULL,
  `surname` longtext NOT NULL,
  `firstname` longtext NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `salt` longtext NOT NULL,
  `password` longtext NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT '0',
  `about` longtext,
  `pix` longtext,
  `address` longtext,
  `type` varchar(100) NOT NULL DEFAULT 'tutor',
  `security_code` longtext,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`id`, `subject_id`, `tutor_id`, `surname`, `firstname`, `phone`, `email`, `salt`, `password`, `status`, `about`, `pix`, `address`, `type`, `security_code`, `created_at`, `updated_at`) VALUES
(1, '1', '206495', 'Ayodele', 'Abraham', '09029291829', 'ayodele@gmail.com', '$2a$05$SCIALswnIUdnFqZNBfAQE$', '$2a$05$SCIALswnIUdnFqZNBfAQE.n20UOliKNFoy4IFmxyYDwVjyikIXRdq', '0', '', NULL, NULL, 'tutor', NULL, '2018-12-05 09:12:15', '2018-12-05 09:12:15'),
(2, '6', '117413', 'Olatigbe', 'Busayo', '08189292929', 'busayo@gmail.com', '$2a$05$ZvqrZnPfVbY5FGYHsT3rI$', '$2a$05$ZvqrZnPfVbY5FGYHsT3rI.VZrWtqwF0dAxCQjR21gxdH4igXhmsGG', '0', '', NULL, NULL, 'tutor', NULL, '2018-12-05 09:17:09', '2018-12-05 09:17:09'),
(3, '6', '018938', 'Ologundudu', 'Toluwase', '08192928190', 'tolu@gmail.com', '$2a$05$BVNBayWa.10KeNzP30efS$', '$2a$05$BVNBayWa.10KeNzP30efS.0ufKDucQJBDaMqmVYm3oguxeAfdEj6y', '0', 'sp[ls[', '018938.jpg', 's[sp[', 'tutor', NULL, '2018-12-05 09:22:34', '2018-12-23 16:33:40'),
(4, '5', '426903', 'oladele', 'koladele', '0902829829', 'koladele@gmail.com', '$2a$05$OteQdLjIJE17.JtBiPg/5$', '$2a$05$OteQdLjIJE17.JtBiPg/5.qISylqZccU.0lu6i4hIxJ7CuRmS7XPu', '0', NULL, NULL, NULL, 'tutor', NULL, '2018-12-27 00:43:19', '2018-12-27 00:43:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_chat`
--
ALTER TABLE `appointment_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ass_solutions`
--
ALTER TABLE `ass_solutions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_chat`
--
ALTER TABLE `group_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tutors`
--
ALTER TABLE `tutors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `appointment_chat`
--
ALTER TABLE `appointment_chat`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `ass_solutions`
--
ALTER TABLE `ass_solutions`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `group_chat`
--
ALTER TABLE `group_chat`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tutors`
--
ALTER TABLE `tutors`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
