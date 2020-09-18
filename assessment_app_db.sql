-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.26 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table assessment_app.admin_preferences
CREATE TABLE IF NOT EXISTS `admin_preferences` (
  `id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `user_panel` tinyint(1) NOT NULL DEFAULT '0',
  `sidebar_form` tinyint(1) NOT NULL DEFAULT '0',
  `messages_menu` tinyint(1) NOT NULL DEFAULT '0',
  `notifications_menu` tinyint(1) NOT NULL DEFAULT '0',
  `tasks_menu` tinyint(1) NOT NULL DEFAULT '0',
  `user_menu` tinyint(1) NOT NULL DEFAULT '1',
  `ctrl_sidebar` tinyint(1) NOT NULL DEFAULT '0',
  `transition_page` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table assessment_app.admin_preferences: ~0 rows (approximately)
DELETE FROM `admin_preferences`;
/*!40000 ALTER TABLE `admin_preferences` DISABLE KEYS */;
INSERT INTO `admin_preferences` (`id`, `user_panel`, `sidebar_form`, `messages_menu`, `notifications_menu`, `tasks_menu`, `user_menu`, `ctrl_sidebar`, `transition_page`) VALUES
	(1, 0, 0, 0, 0, 0, 1, 0, 0);
/*!40000 ALTER TABLE `admin_preferences` ENABLE KEYS */;

-- Dumping structure for table assessment_app.answer_essay_log
CREATE TABLE IF NOT EXISTS `answer_essay_log` (
  `answer_essay_id` int(10) NOT NULL AUTO_INCREMENT,
  `answer_user_id` int(10) DEFAULT NULL,
  `answer_log_id` int(10) DEFAULT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `answer_question_id` int(10) DEFAULT NULL,
  `answer_assessment_id` int(10) DEFAULT NULL,
  `answer_essay_score` int(10) DEFAULT '0',
  PRIMARY KEY (`answer_essay_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='This is child of the assessment_log table';

-- Dumping data for table assessment_app.answer_essay_log: 1 rows
DELETE FROM `answer_essay_log`;
/*!40000 ALTER TABLE `answer_essay_log` DISABLE KEYS */;
INSERT INTO `answer_essay_log` (`answer_essay_id`, `answer_user_id`, `answer_log_id`, `answer`, `answer_question_id`, `answer_assessment_id`, `answer_essay_score`) VALUES
	(6, 13, 8, 'Matthew Kayode', 6, 112, 5);
/*!40000 ALTER TABLE `answer_essay_log` ENABLE KEYS */;

-- Dumping structure for table assessment_app.answer_log
CREATE TABLE IF NOT EXISTS `answer_log` (
  `answer_id` int(10) NOT NULL AUTO_INCREMENT,
  `answer_assessment_id` int(10) DEFAULT NULL,
  `answer_log_user_id` int(10) DEFAULT NULL,
  `answer_question_type` int(1) DEFAULT NULL,
  `answer_result` int(10) DEFAULT NULL,
  `answer_date_added` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `answer_status` int(1) DEFAULT '0',
  `mark_status` int(1) DEFAULT '0',
  PRIMARY KEY (`answer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='To save the users results ';

-- Dumping data for table assessment_app.answer_log: 5 rows
DELETE FROM `answer_log`;
/*!40000 ALTER TABLE `answer_log` DISABLE KEYS */;
INSERT INTO `answer_log` (`answer_id`, `answer_assessment_id`, `answer_log_user_id`, `answer_question_type`, `answer_result`, `answer_date_added`, `answer_status`, `mark_status`) VALUES
	(7, 98, 13, 98, NULL, '2020-03-04 19:21:01', 1, 0),
	(4, 94, 13, 1, 20, '2019-12-14 13:33:47', 1, 1),
	(8, 112, 13, 2, 0, '2020-03-06 22:47:45', 1, 1),
	(9, 111, 13, 1, 100, '2020-03-07 10:52:37', 1, 1),
	(10, 103, 13, 103, NULL, '2020-03-31 11:39:43', 1, 0);
/*!40000 ALTER TABLE `answer_log` ENABLE KEYS */;

-- Dumping structure for table assessment_app.answer_obj_log
CREATE TABLE IF NOT EXISTS `answer_obj_log` (
  `answer_obj_id` int(10) NOT NULL AUTO_INCREMENT,
  `answer_user_id` int(10) DEFAULT NULL,
  `answer` varchar(50) DEFAULT NULL,
  `answer_log_id` int(10) DEFAULT NULL,
  `answer_question_id` int(10) DEFAULT NULL,
  `answer_assessment_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`answer_obj_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='A child of the answer_log';

-- Dumping data for table assessment_app.answer_obj_log: 8 rows
DELETE FROM `answer_obj_log`;
/*!40000 ALTER TABLE `answer_obj_log` DISABLE KEYS */;
INSERT INTO `answer_obj_log` (`answer_obj_id`, `answer_user_id`, `answer`, `answer_log_id`, `answer_question_id`, `answer_assessment_id`) VALUES
	(18, 13, 'Yes ', 6, 9, 97),
	(16, 13, 'PAAU', 4, 6, 94),
	(17, 13, 'Matthew', 4, 5, 94),
	(15, 13, '300', 4, 4, 94),
	(19, 13, 'algorithms ', 6, 8, 97),
	(20, 13, 'algorithm', 6, 7, 97),
	(21, 13, 'kayode', 9, 15, 111),
	(22, 13, 'computer sci', 9, 16, 111);
/*!40000 ALTER TABLE `answer_obj_log` ENABLE KEYS */;

-- Dumping structure for table assessment_app.assessment_log
CREATE TABLE IF NOT EXISTS `assessment_log` (
  `assessment_id` int(11) NOT NULL AUTO_INCREMENT,
  `assessment_user_id` int(10) DEFAULT NULL,
  `assessment_name` varchar(50) DEFAULT NULL,
  `assessment_sem` int(10) DEFAULT NULL,
  `assessment_course` int(11) DEFAULT NULL,
  `assessment_access` int(1) NOT NULL DEFAULT '0' COMMENT 'no access(0)/access(1)/overdue(2)',
  `no_question` int(11) DEFAULT '0',
  `assessment_type` int(1) DEFAULT NULL COMMENT 'live(1)/deadline(2)',
  `question_type` int(1) DEFAULT NULL COMMENT 'obj(1)/essay(2)',
  `total_mark` int(3) DEFAULT NULL,
  `duration` int(4) DEFAULT NULL,
  `assessment_start_time` datetime DEFAULT NULL,
  `assessment_end_time` datetime DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `assessment_date_added` datetime DEFAULT NULL,
  PRIMARY KEY (`assessment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;

-- Dumping data for table assessment_app.assessment_log: 17 rows
DELETE FROM `assessment_log`;
/*!40000 ALTER TABLE `assessment_log` DISABLE KEYS */;
INSERT INTO `assessment_log` (`assessment_id`, `assessment_user_id`, `assessment_name`, `assessment_sem`, `assessment_course`, `assessment_access`, `no_question`, `assessment_type`, `question_type`, `total_mark`, `duration`, `assessment_start_time`, `assessment_end_time`, `deadline`, `assessment_date_added`) VALUES
	(88, 12, 'First assignment', 19, 7, 2, 0, 1, 1, NULL, 20, '2019-11-24 09:11:00', '2019-11-24 09:11:00', NULL, '2019-11-20 12:51:00'),
	(87, 12, 'examination', 19, 7, 2, 0, 1, 1, NULL, 120, '2019-11-23 10:11:00', '2019-11-23 12:11:00', NULL, '2019-11-20 12:51:00'),
	(86, 12, 'Second assignment', 19, 7, 2, 0, 1, 1, NULL, 20, '2019-11-24 09:11:00', '2019-11-24 09:11:00', NULL, '2019-11-19 07:14:00'),
	(78, 12, 'last test', 19, 6, 2, 0, 2, 1, NULL, NULL, NULL, NULL, '2019-02-03', '2019-11-19 06:54:00'),
	(89, 12, 'Second Test', 19, 7, 0, 0, 1, 2, NULL, 20, NULL, NULL, NULL, '2019-11-20 12:52:00'),
	(90, 12, 'First test', 19, 7, 2, 0, 2, 1, NULL, NULL, NULL, NULL, '2019-02-03', '2019-11-23 10:46:00'),
	(94, 12, 'Examination', 19, 7, 1, 3, 1, 1, 30, 300, '2019-11-28 07:11:00', '2019-11-28 22:11:00', NULL, '2019-11-27 07:46:00'),
	(95, 12, 'New assignment', 19, 7, 0, 2, 1, 2, NULL, 30, NULL, NULL, NULL, '2019-11-27 03:29:00'),
	(96, 12, 'asdf', 19, 7, 1, 4, 1, 1, NULL, NULL, '2020-03-04 18:03:00', '1970-01-01 00:01:00', NULL, '2019-11-27 03:44:00'),
	(98, 12, 'asddfd', 19, 7, 1, 0, 1, 1, 70, 60, '2020-01-06 11:01:00', '2020-01-06 12:01:00', NULL, '2019-11-27 07:46:00'),
	(112, 12, 'TEST V2', 19, 7, 1, 2, 1, 2, NULL, 100, '2020-03-06 19:03:00', '2020-03-06 21:03:00', NULL, '2020-03-06 07:39:00'),
	(102, 12, 'new test 2', 19, 7, 1, 0, 1, 1, NULL, NULL, '2020-03-04 18:03:00', '1970-01-01 00:01:00', NULL, '2020-01-03 07:41:00'),
	(103, 12, 'new test 4', 19, 7, 1, 0, 1, 1, NULL, NULL, '2020-03-04 18:03:00', '1970-01-01 00:01:00', NULL, '2020-01-03 07:55:00'),
	(111, 12, 'TEST V1', 19, 7, 1, 2, 1, 1, 100, 400, '2020-03-07 09:03:00', '2020-03-07 16:03:00', NULL, '2020-03-06 07:37:00'),
	(106, 3, 'TEST V2', 19, 6, 0, 0, 1, 1, 30, 10, NULL, NULL, NULL, '2020-02-19 06:11:00'),
	(107, 3, 'TEST V4', 19, 6, 0, 0, 1, 1, 0, 0, NULL, NULL, NULL, '2020-02-19 06:15:00'),
	(108, 3, 'TEST V3', 19, 6, 0, 0, 1, 1, 30, 15, NULL, NULL, NULL, '2020-02-21 05:11:00');
/*!40000 ALTER TABLE `assessment_log` ENABLE KEYS */;

-- Dumping structure for table assessment_app.essay_question
CREATE TABLE IF NOT EXISTS `essay_question` (
  `essay_question_id` int(10) NOT NULL AUTO_INCREMENT,
  `assessment_essay_id` int(10) DEFAULT NULL,
  `essay_question` varchar(255) DEFAULT NULL,
  `essay_question_date` datetime DEFAULT NULL,
  `essay_question_mark` int(3) DEFAULT '0',
  `essay_score` int(10) DEFAULT '0',
  PRIMARY KEY (`essay_question_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Dumping data for table assessment_app.essay_question: 5 rows
DELETE FROM `essay_question`;
/*!40000 ALTER TABLE `essay_question` DISABLE KEYS */;
INSERT INTO `essay_question` (`essay_question_id`, `assessment_essay_id`, `essay_question`, `essay_question_date`, `essay_question_mark`, `essay_score`) VALUES
	(1, 89, 'Any questions at alls', '2019-11-21 15:04:34', 0, 0),
	(2, 95, 'Tell me anything', '2020-03-02 18:22:45', 20, 0),
	(6, 112, 'what is my full name', '2020-03-06 19:40:25', 5, 0),
	(5, 95, 'Tell me anything', '2020-03-02 18:22:34', 20, 0),
	(7, 112, 'what is the name of your department', '2020-03-06 19:40:47', 5, 0);
/*!40000 ALTER TABLE `essay_question` ENABLE KEYS */;

-- Dumping structure for table assessment_app.groups
CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `bgcolor` char(7) NOT NULL DEFAULT '#607D8B',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table assessment_app.groups: ~3 rows (approximately)
DELETE FROM `groups`;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`id`, `name`, `description`, `bgcolor`) VALUES
	(1, 'admin', 'Adminstrator', '#f44336'),
	(2, 'lecturer', 'General User', '#2196f3'),
	(3, 'student', 'Minmal Users', '#009688');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;

-- Dumping structure for table assessment_app.links
CREATE TABLE IF NOT EXISTS `links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `link_name` varchar(50) DEFAULT NULL,
  `link_des` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table assessment_app.links: 5 rows
DELETE FROM `links`;
/*!40000 ALTER TABLE `links` DISABLE KEYS */;
INSERT INTO `links` (`link_id`, `link_name`, `link_des`) VALUES
	(1, 'Home/index', 'The homepage for public users'),
	(2, 'Message/index', 'Message service'),
	(3, 'Course_reg', 'Course Registeration for lectures and students'),
	(4, 'Assessment', 'For lecturers to create assessment'),
	(5, 'Evaluation', 'For students only');
/*!40000 ALTER TABLE `links` ENABLE KEYS */;

-- Dumping structure for table assessment_app.login_attempts
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table assessment_app.login_attempts: ~0 rows (approximately)
DELETE FROM `login_attempts`;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;

-- Dumping structure for table assessment_app.messaging
CREATE TABLE IF NOT EXISTS `messaging` (
  `messaging_id` int(11) NOT NULL AUTO_INCREMENT,
  `messaging_to` int(10) DEFAULT NULL,
  `messaging_from` int(10) DEFAULT NULL,
  `messaging_body` varchar(255) DEFAULT NULL,
  `messaging_date_added` datetime DEFAULT NULL,
  `view_status` int(1) DEFAULT '0',
  PRIMARY KEY (`messaging_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='child of the conversation log';

-- Dumping data for table assessment_app.messaging: 18 rows
DELETE FROM `messaging`;
/*!40000 ALTER TABLE `messaging` DISABLE KEYS */;
INSERT INTO `messaging` (`messaging_id`, `messaging_to`, `messaging_from`, `messaging_body`, `messaging_date_added`, `view_status`) VALUES
	(2, 12, 13, 'hw fa', '2019-12-04 14:46:13', 1),
	(3, 13, 12, 'Why were you not in my class', '2019-12-03 14:46:13', 1),
	(4, 13, 16, ' hw you', '2019-11-04 15:47:13', 1),
	(6, 12, 16, ' hw you', '2019-11-04 15:47:13', 1),
	(7, 12, 13, 'I was sleeping', '2019-12-07 00:43:57', 1),
	(8, 16, 13, 'Guy I dey', '2019-12-07 01:38:35', 1),
	(9, 16, 12, 'Fine and you', '2019-12-07 18:45:39', 1),
	(12, 13, 12, 'Next monday', '2019-12-14 18:18:29', 1),
	(11, 12, 13, 'Ma please when is your test?', '2019-12-12 18:30:10', 1),
	(13, 12, 13, 'new\r\n', '2020-01-06 11:41:22', 1),
	(14, 13, 12, 'tomorrow is your test', '2020-02-26 15:37:28', 1),
	(18, 12, 13, 'Okay ma', '2020-02-26 19:50:22', 1),
	(16, 13, 12, '10 am dont be late', '2020-02-26 15:51:11', 1),
	(19, 12, 13, 'no p', '2020-02-27 04:53:33', 1),
	(20, 13, 12, 'test', '2020-03-02 18:03:03', 1),
	(21, 13, 12, 'test', '2020-03-02 18:04:29', 1),
	(22, 13, 12, 'tesr', '2020-03-02 18:05:46', 1),
	(23, 12, 13, 'hi', '2020-03-12 10:03:24', 1);
/*!40000 ALTER TABLE `messaging` ENABLE KEYS */;

-- Dumping structure for table assessment_app.notification
CREATE TABLE IF NOT EXISTS `notification` (
  `notification_id` int(20) NOT NULL AUTO_INCREMENT,
  `notification_to` int(20) DEFAULT NULL,
  `notification_course` int(20) DEFAULT NULL,
  `notification_view` int(1) DEFAULT '0',
  `notification_body` varchar(255) DEFAULT NULL,
  `notification_assessment` int(20) DEFAULT NULL,
  `notification_type` int(1) DEFAULT NULL COMMENT '(1) new assessment/(2) result',
  `notification_date_added` datetime DEFAULT NULL,
  PRIMARY KEY (`notification_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- Dumping data for table assessment_app.notification: 20 rows
DELETE FROM `notification`;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
INSERT INTO `notification` (`notification_id`, `notification_to`, `notification_course`, `notification_view`, `notification_body`, `notification_assessment`, `notification_type`, `notification_date_added`) VALUES
	(2, 13, 7, 1, 'YES', NULL, 2, '2019-12-07 03:52:16'),
	(7, 13, 7, 1, 'You have a new assessment on Into. to Computer Programming IIjhgfdfghj to be submitted before December 4th, 2019 00:00:am', 99, 1, '2019-12-07 20:36:30'),
	(8, 13, 7, 1, 'Your result for Into. to Computer Programming II is now available', 94, 2, '2019-12-14 12:33:47'),
	(9, 13, 7, 1, 'You have a new assessment on Into. to Computer Programming II', 94, 1, '2019-12-14 19:25:44'),
	(10, 13, 7, 1, 'You have a new assessment on Into. to Computer Programming II', 98, 1, '2019-12-14 19:51:29'),
	(11, 13, 7, 1, 'You have a new assessment on Into. to Computer Programming IIasd to be submitted before November 30th, 2019 00:00:am', 97, 1, '2019-12-14 19:58:00'),
	(12, 13, 7, 1, 'You have a new assessment on Into. to Computer Programming II60 minutes live asddfd which starts now. ', 98, 1, '2020-01-06 11:49:14'),
	(13, 13, 7, 1, 'You have a new assessment on Into. to Computer Programming IIasd to be submitted before November 30th, 2019 00:00:am', 97, 1, '2020-02-28 05:27:28'),
	(14, 13, 7, 1, 'You have a new assessment on Into. to Computer Programming IIasd to be submitted before November 30th, 2019 00:00:am', 97, 1, '2020-02-28 05:29:25'),
	(15, 13, 7, 1, 'You have a new assessment on Into. to Computer Programming II minutes live new test 2 which starts now. ', 102, 1, '2020-03-04 18:23:16'),
	(16, 18, 7, 0, 'You have a new assessment on Into. to Computer Programming II minutes live new test 2 which starts now. ', 102, 1, '2020-03-04 18:23:16'),
	(17, 13, 7, 1, 'You have a new assessment on Into. to Computer Programming II minutes live new test 4 which starts now. ', 103, 1, '2020-03-04 18:37:22'),
	(18, 18, 7, 0, 'You have a new assessment on Into. to Computer Programming II minutes live new test 4 which starts now. ', 103, 1, '2020-03-04 18:37:22'),
	(19, 13, 7, 1, 'You have a new assessment on Into. to Computer Programming II minutes live asdf which starts now. ', 96, 1, '2020-03-04 18:43:16'),
	(20, 18, 7, 0, 'You have a new assessment on Into. to Computer Programming II minutes live asdf which starts now. ', 96, 1, '2020-03-04 18:43:16'),
	(21, 13, 7, 1, 'You have a new assessment on Into. to Computer Programming II100 minutes live TEST V2 which starts now. ', 112, 1, '2020-03-06 19:41:31'),
	(22, 18, 7, 0, 'You have a new assessment on Into. to Computer Programming II100 minutes live TEST V2 which starts now. ', 112, 1, '2020-03-06 19:41:31'),
	(23, 13, 7, 1, 'You have a new assessment on Into. to Computer Programming II400 minutes live TEST V1 which starts now. ', 111, 1, '2020-03-07 09:47:29'),
	(24, 18, 7, 0, 'You have a new assessment on Into. to Computer Programming II400 minutes live TEST V1 which starts now. ', 111, 1, '2020-03-07 09:47:29'),
	(25, 13, 7, 1, 'Your result for Into. to Computer Programming II is now available', 111, 2, '2020-03-07 09:52:37');
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;

-- Dumping structure for table assessment_app.obj_question
CREATE TABLE IF NOT EXISTS `obj_question` (
  `obj_question_id` int(10) NOT NULL AUTO_INCREMENT,
  `assessment_obj_id` int(10) DEFAULT NULL,
  `obj_question` varchar(50) DEFAULT NULL,
  `obj_option_A` varchar(50) DEFAULT NULL,
  `obj_option_B` varchar(50) DEFAULT NULL,
  `obj_option_C` varchar(50) DEFAULT NULL,
  `obj_option_D` varchar(50) DEFAULT NULL,
  `obj_question_ans` varchar(50) DEFAULT NULL,
  `obj_question_date` datetime DEFAULT NULL,
  PRIMARY KEY (`obj_question_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Dumping data for table assessment_app.obj_question: 12 rows
DELETE FROM `obj_question`;
/*!40000 ALTER TABLE `obj_question` DISABLE KEYS */;
INSERT INTO `obj_question` (`obj_question_id`, `assessment_obj_id`, `obj_question`, `obj_option_A`, `obj_option_B`, `obj_option_C`, `obj_option_D`, `obj_question_ans`, `obj_question_date`) VALUES
	(1, 88, 'what is my name', 'chillie', 'kayode', 'matthews', 'Christiana', 'kayode', '2020-03-02 06:22:15'),
	(2, 88, 'what is my name', 'chilly', 'kayode', 'matthews', 'sohot', 'kayode', '2020-03-02 06:19:25'),
	(3, 88, 'what is my name', 'chillies', 'kayode', 'matthew', 'sohot', 'kayode', '2019-11-21 10:41:00'),
	(4, 94, 'What is level are you', '100', '200', '300', '400', '400', '2019-11-27 07:47:43'),
	(5, 94, 'What is my surname', 'Matthew', 'Kayode', 'James', 'Kenny', 'Matthew', '2019-11-27 07:48:23'),
	(6, 94, 'What is the name of your school', 'KSU', 'PAAU', 'FUL', 'LASU', 'PAAU', '2019-11-27 07:49:39'),
	(14, 96, 'the last question', 'thae ', 'ahveu', 'nvcaef ', 'ahfe', 'nvcaef ', '2020-03-02 05:52:46'),
	(13, 96, 'another question ', 'the ns', 'afn e', 'ene ', 'eke', 'the ns', '2020-03-02 05:43:57'),
	(12, 96, 'This the new question ', 'something', 'something else', 'nothing ', 'nothing else', 'something else', '2020-03-02 05:39:04'),
	(10, 96, 'what is your name?', 'anything', 'something', 'that thing ', 'you will know', 'something', '2019-12-07 18:47:16'),
	(15, 111, 'what is your name', 'chillies ', 'chill', 'sohot', 'kayode', 'kayode', '2020-03-06 19:37:57'),
	(16, 111, 'what is the name of your department', 'computer', 'computer sci', 'maths sci', 'statistics', 'computer sci', '2020-03-06 19:39:12');
/*!40000 ALTER TABLE `obj_question` ENABLE KEYS */;

-- Dumping structure for table assessment_app.permission
CREATE TABLE IF NOT EXISTS `permission` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- Dumping data for table assessment_app.permission: 14 rows
DELETE FROM `permission`;
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
INSERT INTO `permission` (`permission_id`, `page_id`, `group_id`) VALUES
	(20, 1, 3),
	(14, NULL, 3),
	(13, NULL, 2),
	(21, 1, 2),
	(19, 1, 2),
	(22, 3, 2),
	(23, 1, 3),
	(24, 3, 3),
	(25, 1, 2),
	(26, 3, 2),
	(27, 4, 2),
	(28, 1, 3),
	(29, 3, 3),
	(30, 5, 3);
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;

-- Dumping structure for table assessment_app.public_preferences
CREATE TABLE IF NOT EXISTS `public_preferences` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `transition_page` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table assessment_app.public_preferences: ~0 rows (approximately)
DELETE FROM `public_preferences`;
/*!40000 ALTER TABLE `public_preferences` DISABLE KEYS */;
INSERT INTO `public_preferences` (`id`, `transition_page`) VALUES
	(1, 0);
/*!40000 ALTER TABLE `public_preferences` ENABLE KEYS */;

-- Dumping structure for table assessment_app.reg_course
CREATE TABLE IF NOT EXISTS `reg_course` (
  `reg_id` int(10) NOT NULL AUTO_INCREMENT,
  `reg_user_id` int(10) DEFAULT NULL,
  `reg_sem_id` int(10) DEFAULT NULL,
  `reg_course_id` int(10) DEFAULT NULL,
  `reg_level_id` int(10) DEFAULT NULL,
  `reg_department_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`reg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Dumping data for table assessment_app.reg_course: 4 rows
DELETE FROM `reg_course`;
/*!40000 ALTER TABLE `reg_course` DISABLE KEYS */;
INSERT INTO `reg_course` (`reg_id`, `reg_user_id`, `reg_sem_id`, `reg_course_id`, `reg_level_id`, `reg_department_id`) VALUES
	(5, 3, 19, 6, 1, 6),
	(6, 12, 19, 7, NULL, 1),
	(7, 13, 19, 7, 1, 1),
	(13, 18, 19, 7, 1, 1);
/*!40000 ALTER TABLE `reg_course` ENABLE KEYS */;

-- Dumping structure for table assessment_app.school_course
CREATE TABLE IF NOT EXISTS `school_course` (
  `course_id` int(10) NOT NULL AUTO_INCREMENT,
  `course_code` varchar(50) DEFAULT NULL,
  `course_title` varchar(50) DEFAULT NULL,
  `course_unit` int(10) DEFAULT NULL,
  `course_sem` int(10) DEFAULT NULL,
  `course_level_id` int(10) DEFAULT NULL,
  `course_dept_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`course_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table assessment_app.school_course: 6 rows
DELETE FROM `school_course`;
/*!40000 ALTER TABLE `school_course` DISABLE KEYS */;
INSERT INTO `school_course` (`course_id`, `course_code`, `course_title`, `course_unit`, `course_sem`, `course_level_id`, `course_dept_id`) VALUES
	(1, 'MAT 101', 'Elementary Mathematics I', 3, 2, 1, 5),
	(2, 'MAN 101', 'Element of Mangement ', 3, 1, 1, 6),
	(6, 'MAN 102', 'Element of Mangement II', 3, 2, 1, 6),
	(5, 'CSC 101', 'Intro. to Computer Programming', 2, 1, 1, 1),
	(7, 'CSC 102', 'Into. to Computer Programming II', 2, 2, 1, 1),
	(8, 'ACC 101', 'Introduction to Accounting', 3, 1, 1, 8);
/*!40000 ALTER TABLE `school_course` ENABLE KEYS */;

-- Dumping structure for table assessment_app.school_department
CREATE TABLE IF NOT EXISTS `school_department` (
  `department_id` int(10) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(50) DEFAULT NULL,
  `department_year` int(10) DEFAULT NULL,
  `department_faculty_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table assessment_app.school_department: 5 rows
DELETE FROM `school_department`;
/*!40000 ALTER TABLE `school_department` DISABLE KEYS */;
INSERT INTO `school_department` (`department_id`, `department_name`, `department_year`, `department_faculty_id`) VALUES
	(1, 'Computer Science', 4, 2),
	(5, 'Mathematical Science', 4, 2),
	(6, 'Bussiness Administration', 4, 3),
	(7, 'Political Science', NULL, 3),
	(8, 'Accounting', NULL, 3);
/*!40000 ALTER TABLE `school_department` ENABLE KEYS */;

-- Dumping structure for table assessment_app.school_faculty
CREATE TABLE IF NOT EXISTS `school_faculty` (
  `faculty_id` int(11) NOT NULL AUTO_INCREMENT,
  `faculty_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`faculty_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table assessment_app.school_faculty: 3 rows
DELETE FROM `school_faculty`;
/*!40000 ALTER TABLE `school_faculty` DISABLE KEYS */;
INSERT INTO `school_faculty` (`faculty_id`, `faculty_name`) VALUES
	(3, 'Management Sciences'),
	(2, 'Natural Sciences'),
	(4, 'Social Science');
/*!40000 ALTER TABLE `school_faculty` ENABLE KEYS */;

-- Dumping structure for table assessment_app.school_sem
CREATE TABLE IF NOT EXISTS `school_sem` (
  `sem_id` int(10) NOT NULL AUTO_INCREMENT,
  `sem_status` int(1) NOT NULL DEFAULT '0',
  `sem_name` varchar(50) DEFAULT NULL,
  `ses_name` varchar(50) DEFAULT NULL,
  `sem_begin_date` date DEFAULT NULL,
  `sem_end_date` date DEFAULT NULL,
  PRIMARY KEY (`sem_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Dumping data for table assessment_app.school_sem: 4 rows
DELETE FROM `school_sem`;
/*!40000 ALTER TABLE `school_sem` DISABLE KEYS */;
INSERT INTO `school_sem` (`sem_id`, `sem_status`, `sem_name`, `ses_name`, `sem_begin_date`, `sem_end_date`) VALUES
	(17, 1, '2', '2018/19', '2019-11-12', '2019-11-12'),
	(16, 1, '1', '2018/19', '2019-11-12', '2019-11-12'),
	(18, 1, '1', '2019/20', '2019-11-12', '2019-11-12'),
	(19, 0, '2', '2019/20', '2019-11-12', '2019-11-12');
/*!40000 ALTER TABLE `school_sem` ENABLE KEYS */;

-- Dumping structure for table assessment_app.student_level
CREATE TABLE IF NOT EXISTS `student_level` (
  `level_id` int(10) NOT NULL AUTO_INCREMENT,
  `level_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`level_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table assessment_app.student_level: 5 rows
DELETE FROM `student_level`;
/*!40000 ALTER TABLE `student_level` DISABLE KEYS */;
INSERT INTO `student_level` (`level_id`, `level_name`) VALUES
	(1, '100 LEVEL'),
	(2, '200'),
	(3, '300'),
	(4, '400'),
	(5, '500');
/*!40000 ALTER TABLE `student_level` ENABLE KEYS */;

-- Dumping structure for table assessment_app.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `passport` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `matric_no` varchar(8) DEFAULT NULL,
  `department` int(10) DEFAULT NULL,
  `user_level` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- Dumping data for table assessment_app.users: ~10 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `passport`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `matric_no`, `department`, `user_level`) VALUES
	(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', '', NULL, NULL, '3b0XGHAML5Zneld7LbpaVO', 1268889823, 1584767888, 1, 'Admin', 'istrator', 'ADMIN', '080123456789', '17st1014', 5, NULL),
	(2, '::1', 'kayode matthew', '$2y$08$ezifeX5k24YV8AIID7RTGe8ZMrKY4Q0bkkDdjDR4qpTm2zNWBDH1C', NULL, 'kayode@gmail.com', '', NULL, NULL, NULL, NULL, 1572960025, 1573109122, 1, 'Kayode', 'Matthew', 'ksu', '08068128822', '17CS1020', 1, NULL),
	(3, '::1', 'christiana matthew', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', NULL, 'christy@gmail.com', '', NULL, NULL, NULL, 'k2et4xrT5FImO7ykeBVyHO', 1573070452, 1583133309, 1, 'Christiana', 'Matthew', NULL, '08024419292', '', 6, 4),
	(7, '::1', 'michael oni', '$2y$08$3uAvS1V8CTLb00lchQGlIeFmYmwpEBYB.byyqwIdYiAjzCAlGbEXm', NULL, 'michael@gmail.com', '', NULL, NULL, NULL, NULL, 1573381790, 1586810699, 1, 'Michael', 'Oni', NULL, '080123456789', '17CS1026', 1, 4),
	(11, '::1', 'aaron  enape', '$2y$08$Yu4scJ4baSO4NUXUK0pCx.hCIYjOdiqkTbgiaY1IpshD3rFguUJa.', NULL, 'timmyt@gmail.com', '', NULL, NULL, NULL, NULL, 1573414789, 1573414821, 1, 'Aaron ', 'Enape', NULL, '080123456789', '17st1012', 5, 4),
	(12, '::1', 'bamitale matthew', '$2y$08$tlA3KbDUQDtc7C/Pgmwe2.C31oUu8oqSO91gMn853cNuHN1CclM1.', NULL, 'bami@gmail.com', '', NULL, NULL, NULL, 'yi/I1jl38G62r66X1vRnIO', 1573659422, 1585651042, 1, 'Bamitale', 'Matthew', NULL, '080123456789', '', 1, 4),
	(13, '::1', 'kehinde daniel', '$2y$08$UNDbuIeISKaKxYA7tHq/neMSdrx26C5ZrwDt0RkyofmrEBBP2Lpx.', NULL, 'kendan@gmail.com', '20191203103527fdsdfgasdfsd.jpg', NULL, NULL, NULL, '.ysXSwzdjyLlf6FDVBTLbO', 1574841129, 1586810391, 1, 'kehinde', 'Daniel', NULL, '080123456789', '17CS1024', 1, 1),
	(16, '::1', 'michael peter', '$2y$08$2TPl59i.o6fLh74yh2wzzuxGc61TUlIyRhg.KAP/VO3qw6o3DxXOC', NULL, 'michaelp@gmail.com', '2019120310123817MS1022Michael.jpg', NULL, NULL, NULL, NULL, 1575367958, 1575369186, 1, 'Michael', 'Peter', NULL, '090123456789', '17MS1022', 5, NULL),
	(17, '::1', 'christian pulisic', '$2y$08$/rqYNizT1VRboQnRsHXo5eVYfviioEBghyWc/iM7IrfFV8GkuIhnO', NULL, 'christian@gmail.com', '', NULL, NULL, NULL, NULL, 1581112132, NULL, 1, 'Christian', 'Pulisic', NULL, '1234567890', '17MS1041', 5, NULL),
	(18, '::1', 'james reece', '$2y$08$JPMvqlq0bIt9A84qVqeZ/.cXbYTeNgYMIwa2YrblJ.Gl2IWLpGrfK', NULL, 'james@gmail.com', '', NULL, NULL, NULL, NULL, 1583336000, 1583336118, 1, 'james', 'reece', NULL, '080123456789', '17CS1035', 1, 4);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table assessment_app.users_groups
CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- Dumping data for table assessment_app.users_groups: ~10 rows (approximately)
DELETE FROM `users_groups`;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
	(50, 1, 1),
	(38, 2, 3),
	(52, 3, 2),
	(9, 7, 3),
	(51, 11, 2),
	(15, 12, 2),
	(16, 13, 3),
	(19, 16, 3),
	(39, 17, 1),
	(54, 18, 3);
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
