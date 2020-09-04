-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 17, 2013 at 09:16 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cidemo`
--

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE IF NOT EXISTS `quizzes` (
  `quiz_id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_title` varchar(1000) NOT NULL,
  `description` text NOT NULL,
  `publish_status` enum('0','1') NOT NULL COMMENT '0-unpublished, 1-published',
  `status` enum('-1','0','1') NOT NULL COMMENT '0-inactive, 1-active, -1-delete',
  `created_datetime` datetime NOT NULL,
  `updated_datetime` datetime NOT NULL,
  PRIMARY KEY (`quiz_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `quizzes`
--


-- --------------------------------------------------------

--
-- Table structure for table `quizzes_questions`
--

CREATE TABLE IF NOT EXISTS `quizzes_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `quizzes_questions`
--


-- --------------------------------------------------------

--
-- Table structure for table `quiz_categories`
--

CREATE TABLE IF NOT EXISTS `quiz_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_title` varchar(500) NOT NULL,
  `parent_category_id` int(11) NOT NULL COMMENT '0-means root category',
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `status` enum('-1','0','1') NOT NULL COMMENT '0-inactive, 1-active, -1-delete',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `quiz_categories`
--

INSERT INTO `quiz_categories` (`category_id`, `category_title`, `parent_category_id`, `lang_id`, `status`) VALUES
(1, 'Mathemetics category', 0, 1, '1'),
(2, 'Physics category', 0, 1, '1'),
(3, 'Chemistry category', 0, 1, '1'),
(4, 'Misc category', 0, 1, '1'),
(5, 'Maths sub category 1', 1, 1, '1'),
(6, 'Maths sub category 2', 1, 1, '1'),
(7, 'Physics sub category 1', 2, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_chapters`
--

CREATE TABLE IF NOT EXISTS `quiz_chapters` (
  `chapter_id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_name` varchar(500) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `status` enum('-1','0','1') NOT NULL COMMENT '0-inactive, 1-active, -1-delete',
  PRIMARY KEY (`chapter_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `quiz_chapters`
--

INSERT INTO `quiz_chapters` (`chapter_id`, `chapter_name`, `subject_id`, `lang_id`, `status`) VALUES
(1, 'Ch 1 Mathemetics category sub 1', 1, 1, '1'),
(2, 'Ch 1 Maths sub category 1 sub 1', 2, 1, '1'),
(3, 'Ch 2 Maths sub category 1 sub 1', 2, 1, '1'),
(4, 'Ch 1 Maths sub category 2 sub 1', 3, 1, '1'),
(5, 'Ch 2 Maths sub category 2 sub 1', 3, 1, '1'),
(6, 'Misc sub ch 1', 6, 1, '1'),
(7, 'Chemistry sub ch 1', 5, 1, '1'),
(8, 'Chemistry sub ch 2', 5, 1, '1'),
(9, 'Misc sub ch 2', 6, 1, '1'),
(10, 'Ch 1 Physics sub category 1 sub 1', 4, 1, '1'),
(11, 'Ch 1 Physics sub category 2 sub 1', 3, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE IF NOT EXISTS `quiz_questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `status` enum('-1','0','1') NOT NULL COMMENT '0-inactive, 1-active, -1-delete',
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`question_id`, `question`, `chapter_id`, `lang_id`, `status`) VALUES
(1, 'Que 1 Mathemetics category sub 1 ch 1', 1, 1, '1'),
(2, 'Que 2 Mathemetics category sub 1 ch 1', 1, 1, '1'),
(3, 'Que 1 Maths sub category 1 sub 1 Ch 1', 2, 1, '1'),
(4, 'Que 1 Maths sub category 2 sub 1 Ch 2', 5, 1, '1'),
(5, 'Que 1 Chemistry sub ch 1', 7, 1, '1'),
(6, 'Que 1 Chemistry sub ch 2', 8, 1, '1'),
(7, 'Que 1 Misc sub ch 1', 6, 1, '1'),
(8, 'Que 2 Misc sub ch 1', 6, 1, '1'),
(9, 'Que 1 Misc sub ch 2', 9, 1, '1'),
(10, 'Que 1 Ch 1 Physics sub category 1 sub 1', 10, 1, '1'),
(11, 'Que 2 Ch 1 Physics sub category 1 sub 1', 10, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question_options`
--

CREATE TABLE IF NOT EXISTS `quiz_question_options` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `option` varchar(1000) NOT NULL,
  `is_correct_answer` enum('0','1') NOT NULL COMMENT '0-no, 1-yes',
  `lang_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `quiz_question_options`
--

INSERT INTO `quiz_question_options` (`option_id`, `question_id`, `option`, `is_correct_answer`, `lang_id`) VALUES
(1, 1, 'option 1', '0', 1),
(2, 1, 'option 2', '1', 1),
(3, 1, 'option 3', '0', 1),
(4, 1, 'option 4', '0', 1),
(5, 2, 'option 1', '0', 1),
(6, 2, 'option 2', '0', 1),
(7, 2, 'option 3', '0', 1),
(8, 2, 'option 4', '1', 1),
(9, 3, 'option 1', '0', 1),
(10, 3, 'option 2', '0', 1),
(11, 3, 'option 3', '1', 1),
(12, 3, 'option 4', '0', 1),
(13, 4, 'option 1', '1', 1),
(14, 4, 'option 2', '0', 1),
(15, 4, 'option 3', '0', 1),
(16, 4, 'option 4', '0', 1),
(17, 5, 'option 1', '0', 1),
(18, 5, 'option 2', '1', 1),
(19, 5, 'option 3', '0', 1),
(20, 5, 'option 4', '0', 1),
(21, 6, 'option 1', '0', 1),
(22, 6, 'option 2', '0', 1),
(23, 6, 'option 3', '0', 1),
(24, 6, 'option 4', '1', 1),
(25, 7, 'option 1', '0', 1),
(26, 7, 'option 2', '0', 1),
(27, 7, 'option 3', '1', 1),
(28, 7, 'option 4', '0', 1),
(29, 8, 'option 1', '0', 1),
(30, 8, 'option 2', '0', 1),
(31, 8, 'option 3', '1', 1),
(32, 8, 'option 4', '0', 1),
(33, 9, 'option 1', '1', 1),
(34, 9, 'option 2', '0', 1),
(35, 9, 'option 3', '0', 1),
(36, 9, 'option 4', '0', 1),
(37, 10, 'option 1', '1', 1),
(38, 10, 'option 2', '0', 1),
(39, 10, 'option 3', '0', 1),
(40, 10, 'option 4', '0', 1),
(41, 11, 'option 1', '0', 1),
(42, 11, 'option 2', '0', 1),
(43, 11, 'option 3', '1', 1),
(44, 11, 'option 4', '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_subjects`
--

CREATE TABLE IF NOT EXISTS `quiz_subjects` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(500) NOT NULL,
  `category_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `status` enum('-1','0','1') NOT NULL COMMENT '0-inactive, 1-active, -1-delete',
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `quiz_subjects`
--

INSERT INTO `quiz_subjects` (`subject_id`, `subject_name`, `category_id`, `lang_id`, `status`) VALUES
(1, 'Mathemetics category sub 1', 1, 1, '1'),
(2, 'Maths sub category 1 sub 1', 5, 1, '1'),
(3, 'Maths sub category 2 sub 1', 6, 1, '1'),
(4, 'Physics sub category 1 sub 1', 7, 1, '1'),
(5, 'Chemistry sub', 3, 1, '1'),
(6, 'Misc sub', 4, 1, '1'),
(7, 'Physics sub category 1 sub 2', 7, 1, '1');
