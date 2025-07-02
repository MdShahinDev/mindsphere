-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2025 at 04:32 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mindspheredb`
--

-- --------------------------------------------------------

--
-- Table structure for table `ai_chat_history`
--

CREATE TABLE `ai_chat_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `response` varchar(255) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ai_chat_history`
--

INSERT INTO `ai_chat_history` (`id`, `user_id`, `message`, `response`, `created_at`) VALUES
(1, 28, 'what is the name of capital city of bangladesh', 'The capital city of Bangladesh is **Dhaka** (also spelled **Dacca**).  \n\n### Key Facts about Dhaka:\n- **Population**: Over 21 million people (metropolitan area), making it one of the world\'s most densely populated cities.\n- **History**: It served as the M', '0000-00-00'),
(2, 28, 'how to write code hello world?', 'Here\'s how to write \"Hello, World!\" in various programming languages:\n\n### 1. **Python**\n```python\nprint(\"Hello, World!\")\n```\n**Run:** Save as `hello.py` ➜ `python hello.py`\n\n### 2. **Java**\n```java\npublic class HelloWorld {\n    public static void main(St', '0000-00-00'),
(3, 28, 'What is the name of capital city of bangladesh', 'The capital city of Bangladesh is **Dhaka** (also spelled **ঢাকা** in Bengali).  \n\nIt is the largest city in the country and serves as the political, economic, and cultural center of Bangladesh. Dhaka is known for its vibrant history, bustling markets, an', '0000-00-00'),
(4, 28, 'what is the name of bangladesh prime minister?', 'The current Prime Minister of Bangladesh is **Sheikh Hasina Wazed**. She has held this position since January 2009, currently serving her **fourth consecutive term** following her party\'s victory in the January 2024 general election.  \n\nShe is also the **', '0000-00-00'),
(5, 28, 'what is the name of prime misnister in bangladesh?', 'The current Prime Minister of Bangladesh is **Sheikh Hasina Wazed** (Bengali: শেখ হাসিনা ওয়াজেদ). She has held this position since January 2009. Sheikh Hasina is the leader of the **Bangladesh Awami League** and has served multiple terms as Prime Ministe', '0000-00-00'),
(6, 28, 'what is the capital city of bangladesh?', 'The capital city of Bangladesh is **Dhaka** (also spelled **Dacca**).  \n\n### Key Details:\n- **Status**: Dhaka serves as the political, economic, and cultural center of Bangladesh.\n- **Population**: Over 21 million in the metro area (one of the world\'s mos', '0000-00-00'),
(7, 28, 'Where is located United International University?', 'United International University (UIU) is located in **Dhaka, Bangladesh**. Its permanent campus address is:\n\n**United International University**  \nHouse 80, Road 8/A (Satmasjid Road)  \nDhanmondi, Dhaka - 1209  \nBangladesh  \n\n**Key Details:**  \n- 📍 **Regio', '0000-00-00'),
(8, 28, 'what is the name of capital city of bangladesh?', 'The capital city of Bangladesh is Dhaka.', '0000-00-00'),
(9, 28, 'write the name of pm in bangladesh', 'The current Prime Minister of Bangladesh is Sheikh Hasina.', '0000-00-00'),
(10, 28, 'what is the name of capital city of bangladesh', 'The capital city of Bangladesh is Dhaka.', '0000-00-00'),
(11, 28, 'what is the name of pm in bangladesh', 'As of October 2021, the Prime Minister of Bangladesh is Sheikh Hasina.', '0000-00-00'),
(12, 28, 'how to write hello worl in javascript?', 'To write \"Hello, World!\" in JavaScript, you can use the following code snippet:\n\n```javascript\nconsole.log(\"Hello, World!\");\n```\n\nYou can run this code in a JavaScript environment (such as a browser console or a Node.js environment) to see \"Hello, World!\"', '0000-00-00'),
(13, 28, 'how to install node js in my local machine', 'To install Node.js on your local machine, you can follow these steps:\n\n1. Visit the official Node.js website at https://nodejs.org.\n2. On the homepage, you will find the latest version of Node.js available for download. Click on the \"Downloads\" button.\n3.', '0000-00-00'),
(14, 28, 'write about united international university', '## United International University (UIU): A Beacon of Higher Education in Bangladesh\n\nUnited International University (UIU) stands as a prominent private university in Bangladesh, dedicated to providing quality higher education and fostering a dynamic lea', '0000-00-00'),
(15, 28, 'write about recent incedent of uiu', 'Unfortunately, your request is too broad for me to provide a specific answer. \"UIU\" could refer to many different things, and without more context, I can\'t determine which one you\'re interested in.\n\nTo help me answer your question about a \"recent incident', '0000-00-00'),
(16, 28, 'in this month about student reform', 'To give you the most relevant information about student reform this month, I need a little more context! \"Student reform\" is a broad topic. Could you tell me which month you\'re referring to?\n\nOnce I know the month, I can look for specific news and develop', '0000-00-00'),
(17, 28, 'in this month jun 2025', 'June 2025 falls on a **Sunday**.\n\nHere\'s a breakdown:\n\n*   **June 1, 2025 is a Sunday.**\n*   **June 30, 2025 is a Monday.**', '0000-00-00'),
(18, 28, 'june 25', 'June 25th. What about it? What information are you looking for regarding June 25th?\n\nFor example, are you interested in:\n\n*   **Holidays or observances on June 25th?**\n*   **Historical events that happened on June 25th?**\n*   **Famous birthdays on June 25', '0000-00-00'),
(19, 28, 'name of moque in bangladesh', 'There are many beautiful mosques in Bangladesh. Here are some of the most famous and historically significant ones:\n\n*   **Sixty Dome Mosque (Shat Gombuj Masjid):** Located in Bagerhat, this UNESCO World Heritage site is a magnificent example of Mughal ar', '0000-00-00'),
(20, 28, 'victory day of bangladesh', 'Victory Day of Bangladesh is celebrated every year on **December 16th**.\n\nIt commemorates the victory of the Allied forces (Mukti Bahini and Indian forces) over the Pakistani forces in the Bangladesh Liberation War of 1971. This victory led to the indepen', '0000-00-00'),
(21, 28, 'name of central bank of bangladesh', 'The central bank of Bangladesh is called **Bangladesh Bank**.', '0000-00-00'),
(22, 28, 'who is billal hossain hridoy?', 'I cannot find any information about a person named \"Billal Hossain Hridoy.\" It\'s possible that:\n\n*   **The name is spelled differently.** There might be a slight variation in the spelling that would lead to different search results.\n*   **The person is no', '0000-00-00'),
(23, 28, '2+ 2 how', '2 + 2 = 4', '0000-00-00'),
(24, 28, 'are you sure?', 'As a large language model, I am an AI. I am still under development, and I am always learning. I am not sure about everything, but I will do my best to provide you with accurate and helpful information.\n\nIf you have a specific question or concern, please ', '0000-00-00'),
(25, 28, 'write about uiu', 'UIU is a common abbreviation that can stand for a few different things, and without more context, it\'s hard to know exactly which \"UIU\" you\'re referring to. However, based on common usage, here are the most likely possibilities:\n\n**1. University of South ', '0000-00-00'),
(26, 28, 'united internation university', 'I couldn\'t find any information about a university officially named \"United International University.\"\n\nIt\'s possible that:\n\n*   **The name is slightly different:** There might be a similar-sounding university with a slightly different name.\n*   **It\'s a ', '0000-00-00'),
(27, 28, 'write about united international university', 'United International University (UIU) is a private university located in Dhaka, Bangladesh. Established in 1999, it has grown to become a well-respected institution known for its commitment to academic excellence and its focus on producing well-rounded gr', '0000-00-00'),
(28, 28, 'where is located?', 'I can\'t tell you where \"it\" is located because you haven\'t told me what \"it\" is.\n\nPlease tell me what you\'re interested in, and I\'ll do my best to help you find its location. For example, you could ask:\n\n*   \"Where is the Eiffel Tower located?\"\n*   \"Where', '0000-00-00'),
(29, 28, 'where is located united international university', 'United International University (UIU) is located in **Dhaka, Bangladesh**.\n\nMore specifically, its permanent campus is situated in **Bashundhara, Dhaka**.', '0000-00-00'),
(30, 28, 'name of asian sea', 'There are many seas with \"Asian\" in their names or that are located in Asia. To give you the most accurate answer, could you provide a little more context? For example, are you thinking of:\n\n*   **A specific region of Asia?** (e.g., East Asia, Southeast A', '0000-00-00'),
(31, 28, 'who is billal hossain hridoy?', 'I couldn\'t find any prominent public figures or notable individuals named \"Billal Hossain Hridoy.\" It\'s possible that this person is:\n\n*   **A private individual:** Many people have this name, but they may not be public figures.\n*   **Known within a speci', '0000-00-00'),
(32, 28, 'hi', 'Hi there! How can I help you today?', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `habit_log`
--

CREATE TABLE `habit_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `habit_category` varchar(50) DEFAULT NULL,
  `habit_name` varchar(100) DEFAULT NULL,
  `habit_value_text` varchar(100) DEFAULT NULL,
  `habit_value_score` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `habit_log`
--

INSERT INTO `habit_log` (`id`, `user_id`, `date`, `habit_category`, `habit_name`, `habit_value_text`, `habit_value_score`, `timestamp`) VALUES
(150, 29, '2025-06-28', 'health', 'drink_water', '100ml', 1, '2025-06-28 18:12:52'),
(151, 29, '2025-06-28', 'health', 'exercise', '10 mins', 2, '2025-06-28 18:12:52'),
(152, 29, '2025-06-28', 'health', 'sound_sleep', 'Less than 6 hrs', 2, '2025-06-28 18:12:52'),
(153, 29, '2025-06-28', 'health', 'blood_pressure', 'Normal', 5, '2025-06-28 18:12:52'),
(154, 29, '2025-06-28', 'health', 'meal', 'Skipped', 0, '2025-06-28 18:12:52'),
(155, 29, '2025-06-28', 'wellness', 'meditation', '5 mins', 2, '2025-06-28 18:12:59'),
(156, 29, '2025-06-28', 'wellness', 'journaling', 'Yes', 5, '2025-06-28 18:12:59'),
(157, 29, '2025-06-28', 'wellness', 'gratitude', 'Noted', 5, '2025-06-28 18:12:59'),
(158, 29, '2025-06-28', 'wellness', 'mood_checkin', 'Happy', 5, '2025-06-28 18:12:59'),
(159, 29, '2025-06-28', 'wellness', 'clam_breathing', '3 mins', 3, '2025-06-28 18:12:59'),
(160, 29, '2025-06-28', 'productivity', 'work_hours', 'Less than 4 hrs', 2, '2025-06-28 18:13:06'),
(161, 29, '2025-06-28', 'productivity', 'social_media_usage', '0 Min', 5, '2025-06-28 18:13:06'),
(162, 29, '2025-06-28', 'productivity', 'task_done', '1', 1, '2025-06-28 18:13:06'),
(163, 29, '2025-06-28', 'productivity', 'pomodoro_session', '1', 1, '2025-06-28 18:13:06'),
(164, 29, '2025-06-28', 'productivity', 'break_time', 'Short', 5, '2025-06-28 18:13:06'),
(165, 29, '2025-06-28', 'learning', 'reading', 'None', 1, '2025-06-28 18:13:11'),
(166, 29, '2025-06-28', 'learning', 'course', 'Not Started', 0, '2025-06-28 18:13:11'),
(167, 29, '2025-06-28', 'learning', 'smart_recall', 'Anki Done', 5, '2025-06-28 18:13:11'),
(168, 29, '2025-06-28', 'learning', 'new_skill', 'Watched', 2, '2025-06-28 18:13:11'),
(169, 29, '2025-06-28', 'learning', 'learn_and_log', 'Notes Taken', 5, '2025-06-28 18:13:11'),
(195, 29, '2025-06-28', 'wellness', 'meditation', '30 mins', 5, '2025-06-28 19:22:53'),
(196, 29, '2025-06-28', 'wellness', 'journaling', 'Yes', 5, '2025-06-28 19:22:53'),
(197, 29, '2025-06-28', 'wellness', 'gratitude', 'Noted', 5, '2025-06-28 19:22:53'),
(198, 29, '2025-06-28', 'wellness', 'mood_checkin', 'Happy', 5, '2025-06-28 19:22:53'),
(199, 29, '2025-06-28', 'wellness', 'clam_breathing', '5 mins', 5, '2025-06-28 19:22:53'),
(255, 29, '2025-06-28', 'health', 'drink_water', '3L', 5, '2025-06-28 20:08:05'),
(256, 29, '2025-06-28', 'health', 'exercise', '1 hour', 5, '2025-06-28 20:08:05'),
(257, 29, '2025-06-28', 'health', 'sound_sleep', 'More than 8 hrs', 5, '2025-06-28 20:08:05'),
(258, 29, '2025-06-28', 'health', 'blood_pressure', 'Normal', 5, '2025-06-28 20:08:05'),
(259, 29, '2025-06-28', 'health', 'meal', '3 meals', 5, '2025-06-28 20:08:05'),
(260, 29, '2025-06-29', 'health', 'drink_water', '3L', 5, '2025-06-28 20:09:23'),
(261, 29, '2025-06-29', 'health', 'exercise', '1 hour', 5, '2025-06-28 20:09:23'),
(262, 29, '2025-06-29', 'health', 'sound_sleep', 'More than 8 hrs', 5, '2025-06-28 20:09:23'),
(263, 29, '2025-06-29', 'health', 'blood_pressure', 'Normal', 5, '2025-06-28 20:09:23'),
(264, 29, '2025-06-29', 'health', 'meal', '3 meals', 5, '2025-06-28 20:09:23'),
(265, 29, '2025-06-29', 'productivity', 'work_hours', 'More than 8 hrs', 5, '2025-06-28 20:11:47'),
(266, 29, '2025-06-29', 'productivity', 'social_media_usage', '0 Min', 5, '2025-06-28 20:11:47'),
(267, 29, '2025-06-29', 'productivity', 'task_done', '5+', 5, '2025-06-28 20:11:47'),
(268, 29, '2025-06-29', 'productivity', 'pomodoro_session', '10', 5, '2025-06-28 20:11:47'),
(269, 29, '2025-06-29', 'productivity', 'break_time', 'Short', 5, '2025-06-28 20:11:47');

-- --------------------------------------------------------

--
-- Table structure for table `habit_score`
--

CREATE TABLE `habit_score` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `habit_score`
--

INSERT INTO `habit_score` (`id`, `user_id`, `score`, `date`) VALUES
(29, 29, 107, '2025-06-28'),
(30, 29, 66, '2025-06-29'),
(31, 29, 78, '2025-06-29');

-- --------------------------------------------------------

--
-- Table structure for table `motivational_quotes`
--

CREATE TABLE `motivational_quotes` (
  `id` int(11) NOT NULL,
  `time_period` varchar(20) NOT NULL,
  `quote` text NOT NULL,
  `author` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `motivational_quotes`
--

INSERT INTO `motivational_quotes` (`id`, `time_period`, `quote`, `author`) VALUES
(1, 'morning', 'Every morning we are born again. What we do today is what matters most.', 'Buddha'),
(2, 'morning', 'Rise up, start fresh, see the bright opportunity in each new day.', 'Dr. Shahin'),
(3, 'morning', 'The morning was full of sunlight and hope.', 'Kate Chopin'),
(4, 'morning', 'Your future is created by what you do today, not tomorrow.', 'Robert Kiyosaki'),
(5, 'morning', 'Success comes to those who wake up with determination and go to bed with satisfaction.', 'Rashed'),
(6, 'noon', 'Midday is a checkpoint — ask yourself if you\'re still aligned with your goals.', 'Unknown'),
(7, 'noon', 'The sun shines brightest at noon. Let your passion do the same.', 'Unknown'),
(8, 'noon', 'You’ve already come halfway through the day — don’t stop now.', 'Unknown'),
(9, 'noon', 'Noon is a gentle reminder: the morning is gone, the evening is yet to come. Make now count.', 'Unknown'),
(10, 'noon', 'Keep going. The energy you bring now fuels your evening success.', 'Unknown'),
(11, 'afternoon', 'Don’t count the hours — make the hours count.', 'Unknown'),
(12, 'afternoon', 'Afternoon light reminds us: there’s still time to shine today.', 'Unknown'),
(13, 'afternoon', 'Every productive afternoon is a step closer to your vision.', 'Unknown'),
(14, 'afternoon', 'Energy may dip, but discipline keeps you going.', 'Unknown'),
(15, 'afternoon', 'A calm afternoon is the reward of a focused morning.', 'Unknown'),
(16, 'evening', 'The day may be ending, but your potential never sleeps.', 'Unknown'),
(17, 'evening', 'Let the setting sun remind you that every end can be beautiful.', 'Unknown'),
(18, 'evening', 'Take pride in how far you’ve come today, and plan boldly for tomorrow.', 'Unknown'),
(19, 'evening', 'Evenings are for healing the soul and setting intentions.', 'Unknown'),
(20, 'evening', 'Success is built in the quiet preparation of the evening.', 'Unknown'),
(21, 'night', 'Night is the time to recharge your soul and reset your goals.', 'Jhonny'),
(22, 'night', 'Let gratitude be the pillow on which you kneel to say your nightly prayer.', 'Maya Angelou'),
(23, 'night', 'Dream big tonight, work hard tomorrow.', 'Shahin'),
(24, 'night', 'Sleep is not an escape. It’s preparation.', 'Hridoy'),
(25, 'night', 'A rested mind births the strongest ideas. Honor your rest.', 'Unknown');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_skill`
--

CREATE TABLE `personal_skill` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `grade` int(11) NOT NULL,
  `assessed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal_skill`
--

INSERT INTO `personal_skill` (`id`, `user_id`, `skill_name`, `grade`, `assessed`) VALUES
(5, 27, 'Public Speaking', 3, 0),
(6, 27, 'Driving', 4, 0),
(7, 28, 'Public Speaking', 5, 1),
(8, 20, 'Public Speaking', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pomodoro_sessions`
--

CREATE TABLE `pomodoro_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `professional_skill`
--

CREATE TABLE `professional_skill` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `grade` int(11) NOT NULL,
  `assessed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professional_skill`
--

INSERT INTO `professional_skill` (`id`, `user_id`, `skill_name`, `grade`, `assessed`) VALUES
(1, 27, 'Team Work', 4, 0),
(2, 27, 'Python', 5, 0),
(4, 28, 'Machine Learning', 4, 1),
(5, 20, 'NEXT JS', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `duration` varchar(100) NOT NULL,
  `priority` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `due_date` date DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `time_worked` time NOT NULL,
  `progress` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `profession` varchar(255) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `username`, `password`, `profession`, `location`, `avatar`, `created_at`) VALUES
(1, 'rashed1', 'rashed1@gmail.com', 'rashed1', '$2y$10$76jqX7o.bU2Bie8J78lfC.68J2ww8B.deiWj0ZyPfm60SQ1bUHJ72', '', 'Dhaka, Bangladesh', NULL, NULL),
(2, 'rashed2', 'rashed2@gmail.com', 'rashed2', '$2y$10$jMYvDGesld8w7iRE0iyiFuq476UE6LU/4OHVe0jID0f/WKDklwUwS', '', NULL, NULL, NULL),
(3, 'rashed3', 'rashed3@gmail.com', 'rashed3', '$2y$10$HkIYbANgIeUgmwA8F./aV.HEVm3RD2TIElpUdHZml9YlsRUoX4t1K', '', NULL, NULL, NULL),
(4, 'rashed4', 'rashed4@gmail.com', 'rashed4', '$2y$10$gQ/rgdaawmY9v6l5RxXZl.6j28DqXPczDXlH/FcvvKJZ1M/c.v8RG', '', NULL, NULL, NULL),
(5, 'rashed4', 'rashed4@gmail.com', 'rashed4', '$2y$10$EJaIYf.t7eTonxAlCt1JRejZC06BJpXo3dBnfgO8vvROEZRKoryCS', '', NULL, NULL, NULL),
(6, 'rashed6', 'rashed6@gmail.com', 'rashed6', '$2y$10$ILeyuXBmeeqDMQnew8GAm.J.3mbULgmShE9KHGDPwx56pswygBSRK', '', NULL, NULL, NULL),
(7, 'rashed7', 'rashed7@gmail.com', 'rashed7', '$2y$10$AifBdwdIjvdjSysOjmt/3.IfmyEbbxot08Wv19XRAl6hBDw1AxbSe', '', NULL, NULL, NULL),
(8, 'rashed8', 'rashed8@gmail.com', 'rashed8', '$2y$10$/UNj6YMXdQ1ILYMtSdkLHuKb8H5c69YJNqwpj6fvDlQ4huECpP2li', '', NULL, NULL, NULL),
(9, 'rashed9', 'rashed9@gmail.com', 'rashed9', '$2y$10$vfacvp77TR/xxh3LyJiQDuiD9qNCYWaa4nzdU3n0/O8eOVdyeB7Qm', '', NULL, NULL, NULL),
(10, 'rashed10', 'rashed10@gmail.com', 'rashed10', '$2y$10$S8SGPd7Vlc6NjeEBsIWN/OUL5JnjhwvjpZue.56wGnP94AlIh3L06', '', NULL, NULL, NULL),
(11, 'rashed11', 'rashed11@gmail.com', 'rashed11', '$2y$10$jpB8zHwPPksDD.7/Pju6te22F6nCJ5kVRQ/bA.GuXD7vjRDsoglg2', '', NULL, NULL, NULL),
(12, 'rashed12', 'rashed12@gmail.com', 'rashed12', '$2y$10$aPqsTJIMSf8lOevf6me6NOgK5HQ2Z1m3e0PjEIXUVzzUREmxahO3q', '', NULL, NULL, NULL),
(13, 'rashed13', 'rashed13@gmail.com', 'rashed13', '$2y$10$XZB8LezEr3IOhnZCt267GObpDPTImbTGPIm.l7EN3PFdovmF9Mb5W', '', NULL, NULL, NULL),
(14, 'rashed14', 'rashed14@gmail.com', 'rashed14', '$2y$10$Ihl2IynIUwNoUkK5.ospWeHm9BlGLQJ4Wn3a0piqyCmYNRU1pDKou', '', NULL, NULL, NULL),
(15, 'Rashed15', 'rashed15@gmail.com', 'rashed15', '$2y$10$XbmQzxYRmNUMhldm4Y5s6.h45ppqlHXhjxIOpqhSoDlAm8PWjnbJy', '', NULL, NULL, NULL),
(17, 'Akash', 'akash@gmail.com', 'akash1', '$2y$10$TzhlD40tv1gn.kw/8i1bJ.x.w8Usn4LZmwJ1vCGDOWIONfQC3Hb8W', '', 'Rajshahi, Bangladesh', NULL, NULL),
(18, 'Rashed20', 'rashed20@gmail.com', 'rashed20', '$2y$10$Y3HTW.kuiYlIlRhGzj4qUemQRnywVFN6b266TkEXCVT4g63L/B8qa', '', NULL, NULL, NULL),
(19, 'Rashed21', 'rashed21@gmail.com', 'rashed21', '$2y$10$63zAi1gwadNdgCC0pqDu/ehbpjk1va.DBIOp1hL.qqYelipP3fNkS', '', NULL, NULL, NULL),
(20, 'Shahin', 'shahin@gmail.com', 'shahin', '$2y$10$cXMT/qSsQ8LZl86zV6UT1OnYItv/HGA4Jo3r5tNsbPJ3gKguBvYIa', '', 'Gopalganj, Bangladesh', '../uploads/avatar_685772e13c5888.70417754.jpg', NULL),
(21, 'Jhonny', 'jhonny@gmail.com', 'jhonny', '$2y$10$vZbdBuvPkE3XIegcYsne6eGiCfD5IhNslHhkdq7OqYUCkDVAMgME2', '', NULL, NULL, NULL),
(27, 'Rifat Islam', 'rifat@gmail.com', 'rifat', '$2y$10$bIQWZ/vX5qG..jYRP4hpquzYGJpK/q5wBBFvYF2iTTY1.0TjK9f56', '', 'Dhaka, Bangladesh', '../uploads/avatar_685405153f2a28.14731786.jpg', NULL),
(28, 'Hridoy', 'h@m.com', 'Hridoy', '$2y$10$EPdgYhL1ap.BsuKec2G4nuLG2mGE7c2.MhkPWD8u9JoeE9iIyXWK2', 'Software Engineer', 'Dhaka, Bangladesh', '../uploads/avatar_68544618a1db17.56718882.jpg', NULL),
(29, 'Jhon', 'j@g.com', 'jhon', '$2y$10$fRZ7c2mD59ho530htEW.x.zOIQT4Pf2JOyE6hXtarQ.8x1tX1ey2C', '', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ai_chat_history`
--
ALTER TABLE `ai_chat_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `habit_log`
--
ALTER TABLE `habit_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_habit_log_users` (`user_id`);

--
-- Indexes for table `habit_score`
--
ALTER TABLE `habit_score`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `motivational_quotes`
--
ALTER TABLE `motivational_quotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notification_users` (`user_id`);

--
-- Indexes for table `personal_skill`
--
ALTER TABLE `personal_skill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_personal_skill_users` (`user_id`);

--
-- Indexes for table `pomodoro_sessions`
--
ALTER TABLE `pomodoro_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pomodoro_sessions_users` (`user_id`),
  ADD KEY `fk_pomodoro_sessions_tasks` (`task_id`);

--
-- Indexes for table `professional_skill`
--
ALTER TABLE `professional_skill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_professional_skill_users` (`user_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tasks_users` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ai_chat_history`
--
ALTER TABLE `ai_chat_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `habit_log`
--
ALTER TABLE `habit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

--
-- AUTO_INCREMENT for table `habit_score`
--
ALTER TABLE `habit_score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `motivational_quotes`
--
ALTER TABLE `motivational_quotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_skill`
--
ALTER TABLE `personal_skill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pomodoro_sessions`
--
ALTER TABLE `pomodoro_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `professional_skill`
--
ALTER TABLE `professional_skill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `habit_log`
--
ALTER TABLE `habit_log`
  ADD CONSTRAINT `fk_habit_log_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `fk_notification_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `personal_skill`
--
ALTER TABLE `personal_skill`
  ADD CONSTRAINT `fk_personal_skill_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `pomodoro_sessions`
--
ALTER TABLE `pomodoro_sessions`
  ADD CONSTRAINT `fk_pomodoro_sessions_tasks` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
  ADD CONSTRAINT `fk_pomodoro_sessions_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `professional_skill`
--
ALTER TABLE `professional_skill`
  ADD CONSTRAINT `fk_professional_skill_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_tasks_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
