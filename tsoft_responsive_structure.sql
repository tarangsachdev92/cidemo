-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 10, 2015 at 12:12 PM
-- Server version: 5.5.24
-- PHP Version: 5.3.10-1ubuntu3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `team5_tsoftresponsive_staging_local`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `session_id` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24395 ;


-- --------------------------------------------------------

--
-- Table structure for table `advertisement`
--

CREATE TABLE IF NOT EXISTS `advertisement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_id` int(11) NOT NULL,
  `lang_id` tinyint(1) NOT NULL COMMENT '1-english,2-spanish',
  `section_id` tinyint(1) NOT NULL COMMENT '1=home page banner,2-ad banner',
  `page_id` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-about_us,2-contact_us,3-privacy policy',
  `position` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-top,2-bottom,3-left,4-right',
  `banner_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-image,2-embedded code',
  `link` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `embedded_code` text NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `order` tinyint(4) NOT NULL DEFAULT '1',
  `country_id` int(4) NOT NULL DEFAULT '0',
  `state_id` int(4) NOT NULL DEFAULT '0',
  `city_id` int(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '-1-deleted,1-active,0-inactive',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ad_id` (`ad_id`),
  KEY `city_id` (`city_id`),
  KEY `country_id` (`country_id`),
  KEY `state_id` (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `advertisement`
--

INSERT INTO `advertisement` (`id`, `ad_id`, `lang_id`, `section_id`, `page_id`, `position`, `banner_type`, `link`, `image_url`, `embedded_code`, `title`, `description`, `order`, `country_id`, `state_id`, `city_id`, `status`, `created_by`, `created_on`, `modified_by`, `modified_on`) VALUES
(1, 1, 1, 1, 0, 0, 1, 'http://google.com', 'banner-Test-20141013-060446.jpg', '', 'Test', 'Test', 1, 0, 0, 0, 1, 1, '2014-10-13 06:04:46', 1, '2014-10-16 00:46:25'),
(2, 2, 1, 2, 1, 1, 1, 'http://www.google.co.in', 'banner-About_Banner-20141013-092039.jpg', '', 'About Banner', '', 0, 4, 8, 5, 1, 1, '2014-10-13 09:20:39', 1, '2014-10-16 00:46:25'),
(3, 3, 1, 1, 0, 0, 1, '', 'banner-Test_Home-20141013-112149.jpg', '', 'Test Home', 'asdfghjkcvfghjkghj', 0, 0, 0, 0, 1, 1, '2014-10-13 11:21:49', 1, '2014-10-16 00:46:25'),
(4, 4, 2, 1, 0, 0, 1, '', 'banner-BNBVCNVBCN-20141017-084059.jpg', '', 'BNBVCNVBCN', 'VBNVNVB', 0, 0, 0, 0, 1, 1, '2014-10-17 08:40:59', 0, '2014-10-17 08:34:13');

-- --------------------------------------------------------

--
-- Table structure for table `ad_visitors`
--

CREATE TABLE IF NOT EXISTS `ad_visitors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '0-visitor',
  `ip` varchar(20) NOT NULL,
  `visited_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ad_id` (`ad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ashish`
--

CREATE TABLE IF NOT EXISTS `ashish` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blogpost`
--

CREATE TABLE IF NOT EXISTS `blogpost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blogpost_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `title` varchar(100) NOT NULL,
  `slug_url` varchar(50) NOT NULL,
  `blog_text` text NOT NULL,
  `blog_image` varchar(255) DEFAULT NULL,
  `view_permission` tinyint(1) NOT NULL COMMENT '''0'' = ''Registered'', ''1'' = ''All User''',
  `status` tinyint(1) NOT NULL COMMENT '"-1= Deleted, 0=Inactive,1=Active, 2=Suspended,3=Restricted"',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `slug_url` (`slug_url`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `blogpost`
--

INSERT INTO `blogpost` (`id`, `blogpost_id`, `category_id`, `lang_id`, `title`, `slug_url`, `blog_text`, `blog_image`, `view_permission`, `status`, `created`, `modified`) VALUES
(1, 1, 76, 1, 'Blog Title123', 'blog-title123', 'Blog Title123', '', 1, 1, '2014-10-10 12:49:29', '2014-10-10 12:42:43'),
(2, 2, 76, 1, 'Blog', 'blog-', 'Blog Title123', '', 1, 1, '2014-10-10 12:52:01', '2014-10-13 00:18:17'),
(3, 3, 11, 1, 'New', 'new', 'New', '', 1, -1, '2014-10-13 05:48:43', '2014-10-13 05:41:58'),
(4, 4, 11, 1, 'test', 'test', 'test', '', 1, 1, '2014-10-13 05:50:31', '2014-10-13 05:43:45'),
(5, 5, 11, 1, 'new', 'new', 'new', '', 1, 1, '2014-10-13 05:57:10', '2014-10-13 05:50:24'),
(6, 6, 11, 1, 'dgf11111', '4545', '', '', 0, -1, '2014-10-15 13:10:23', '2014-10-15 07:51:54'),
(7, 7, 11, 1, 'fdf', 'fdf', '', '', 0, -1, '2014-10-16 08:45:13', '2014-10-16 08:38:28'),
(8, 8, 11, 1, 'ghjg', 'ghjg', 'gfhgf', '', 0, 0, '2014-10-17 08:18:37', '2014-10-17 08:11:51');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comment`
--

CREATE TABLE IF NOT EXISTS `blog_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blogpost_id` int(11) NOT NULL COMMENT 'pk of blogpost table',
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0=Inactive,1=Active,-1=Deleted',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `blogpost_id` (`blogpost_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `blog_comment`
--

INSERT INTO `blog_comment` (`id`, `blogpost_id`, `lang_id`, `name`, `email`, `website`, `comment`, `status`, `created`) VALUES
(1, 2, 1, 'Amit', 'amit.mehta@sparsh.com', '', 'this is comment for test', -1, '2014-10-10 18:16:29'),
(2, 1, 1, 'GORSIYA DHARA VAJUBHAI', 'pooja.nagvadia@sparsh.com', 'www.indiabix.com', 'hiiiiiii', -1, '2014-10-13 11:37:20'),
(3, 1, 1, 'GORSIYA DHARA VAJUBHAI', 'dhara.gorsiya@sparsh.com', 'http://google.com', 'hello', -1, '2014-10-13 11:39:33'),
(4, 3, 1, 'Amit', 'amit.mehta@sparsh.com', 'www.lipsum.com', 'dasdaddasd', -1, '2014-10-13 12:03:20'),
(5, 1, 1, 'dhara', 'dhara.gorsiya@sparsh.com', 'www.lipsum.com', 'test', -1, '2014-10-13 12:18:50'),
(6, 1, 1, 'dhara', 'dhara.gorsiya@sparsh.com', 'www.indiabix.com', 'new', -1, '2014-10-13 12:19:13'),
(7, 4, 1, 'dhara', 'dhara.gorsiya@sparsh.com', 'http://google.com', 'test', -1, '2014-10-13 13:32:23'),
(8, 4, 1, 'dhara', 'admin@tatvasoft.com', 'http://google.com', 'new', -1, '2014-10-13 13:32:49'),
(9, 3, 1, 'dhara', 'admin@tatvasoft.com', 'http://google.com', 'kfdjkdkbkb', 0, '2014-10-13 14:00:02'),
(10, 3, 1, 'dfg', 'pankit.shah@sparsh.com', 'www.indiabix.com', 'dfs', 0, '2014-10-13 14:00:18'),
(11, 3, 1, 'GORSIYA DHARA VAJUBHAI', 'pankit.shah@sparsh.com', 'www.lipsum.com', 'cbhcbh', 0, '2014-10-13 14:00:30');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '0 means root category else id of parent category',
  `module_id` int(11) NOT NULL DEFAULT '1' COMMENT 'FK of modules',
  `title` varchar(100) NOT NULL,
  `slug_url` varchar(50) NOT NULL,
  `description` longtext NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '-1= Deleted, 0=Inactive,1=Active',
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=113 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_id`, `lang_id`, `parent_id`, `module_id`, `title`, `slug_url`, `description`, `status`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 1, 1, 0, 4, 'General', 'general', '<p>This is General category all general common posts are put here.</p>', -1, '2013-09-20 05:39:11', 0, '2014-07-27 20:01:38', 1),
(2, 2, 1, 0, 4, 'News', 'news', 'News related information are here all commenting o recent and breaking news', -1, '2013-09-20 05:39:11', 0, '2014-10-08 03:13:07', 1),
(3, 3, 1, 0, 4, 'Movies', 'movies', '<p>Movies for movie review, stry link n phoyos</p>', -1, '2013-09-20 05:39:54', 0, '2013-11-21 02:19:12', 1),
(4, 4, 1, 0, 4, 'Sports', 'sports', 'Sports is category which includes all sports rrelated activity', -1, '2013-09-20 05:39:54', 0, '2014-10-08 03:12:44', 1),
(5, 5, 1, 0, 4, 'Science', 'science', '<p>Science is related technology and research</p>', -1, '2013-09-20 05:40:29', 0, '2014-08-25 17:57:29', 1),
(6, 6, 1, 0, 5, 'Information & Technology', 'information-and-technology', 'IT', -1, '2013-09-20 05:40:29', 0, '2013-09-19 18:40:29', 0),
(7, 7, 1, 0, 4, 'Mobile', 'mobile', '<p>Mobile is relates to new mobile news and all</p>', -1, '2013-09-20 05:40:53', 0, '2014-10-08 00:28:09', 1),
(8, 8, 1, 0, 4, 'Politics', 'politics', 'politics is for government election result and all <b>and </b><br>', 1, '2013-09-20 05:40:53', 0, '2014-10-08 04:42:15', 1),
(9, 10, 1, 0, 5, 'Pharma', 'pharma', 'Pharma', -1, '2013-09-20 05:41:11', 0, '2013-09-19 18:41:11', 0),
(10, 1, 2, 0, 4, 'General-sp', 'general-sp', 'General-sp', 1, '2013-09-20 06:40:29', 0, '2013-09-19 19:40:29', 0),
(11, 11, 1, 0, 3, 'Sports', 'sports-blog', '<p>This is for Sports</p>', 1, '2013-09-20 07:18:24', 0, '2013-09-25 23:45:38', 24),
(12, 12, 1, 0, 3, 'Music', 'music', '<p>This is for music</p>', -1, '2013-09-20 07:20:52', 0, '2013-09-19 14:50:52', 0),
(14, 11, 2, 0, 3, 'Sports-sp', 'sports-sp', '<p>Spoerts sp category</p>', 1, '2013-09-23 08:28:38', 0, '2013-09-22 15:58:38', 0),
(15, 11, 10, 0, 3, 'Sports Ar', 'sports-ar', '<p>This is sports arabic category..</p>', 1, '2013-09-23 08:29:28', 0, '2013-09-22 15:59:28', 0),
(16, 13, 1, 0, 7, 'Sports Shopping', 'sports-shopping', '<p>Jewellery description</p>', -1, '2013-09-27 06:04:10', 26, '2013-11-21 02:18:18', 1),
(17, 14, 1, 0, 6, 'Gallery 1', 'gallery-1', '<p>gallery1</p>', 1, '2013-09-27 10:12:35', 23, '2013-09-27 04:39:16', 0),
(18, 15, 1, 0, 6, 'Gallery 2', 'gallery-2', '<p>Gallery2</p>', 1, '2013-09-27 10:13:12', 23, '2013-09-27 04:39:53', 0),
(19, 16, 1, 0, 8, 'Mathemetics category1', 'mathemetics-category1', 'Mathemetics category', -1, '2013-09-27 11:14:22', 23, '2014-10-08 04:39:54', 1),
(20, 17, 1, 0, 8, 'Physics category', '', '<p>Physics category</p>', -1, '2013-09-27 11:14:44', 23, '2013-09-27 05:41:26', 0),
(21, 18, 1, 0, 8, 'Chemistry category', '', '<p>Chemistry category</p>', -1, '2013-09-27 11:15:02', 23, '2013-09-27 05:41:44', 0),
(22, 19, 1, 0, 8, 'Misc category', '', '<p>Misc category</p>', 1, '2013-09-27 11:15:22', 23, '2013-09-27 05:42:04', 0),
(23, 20, 1, 16, 8, 'Maths sub category 1', '', '<p>Maths sub category 1</p>', 1, '2013-09-27 11:15:40', 23, '2013-09-27 05:42:21', 0),
(24, 21, 1, 16, 8, 'Maths sub category 2', '', '<p>Maths sub category 2</p>', 1, '2013-09-27 11:16:00', 23, '2013-09-27 05:42:41', 0),
(25, 22, 1, 17, 8, 'Physics sub category 1', '', '<p>Physics sub category 1</p>', 1, '2013-09-27 11:16:28', 23, '2013-09-27 05:43:10', 0),
(26, 23, 1, 0, 8, 'General Knowledge', '', '<p>General Knowledge</p>', 1, '2013-09-27 11:24:35', 23, '2013-09-27 05:51:18', 0),
(27, 24, 1, 0, 2, 'category 1', '', '<p>category 1</p>', 1, '2013-09-27 12:41:46', 23, '2013-09-27 07:08:30', 0),
(28, 25, 1, 0, 2, 'category 2', '', '<p>category 2</p>', 1, '2013-09-27 12:42:06', 23, '2013-09-27 07:08:50', 0),
(29, 26, 1, 0, 2, 'category 3', '', '<p>category 3</p>', -1, '2013-09-27 12:42:21', 23, '2013-09-27 07:09:05', 0),
(30, 27, 1, 0, 7, 'ShoppingCart cat', 'general', '<p>asas</p>', -1, '2013-10-01 05:02:28', 26, '2013-09-30 23:29:03', 0),
(33, 33, 1, 0, 7, 'Necklaces', 'necklaces', 'Necklaces description', 1, '2013-10-01 00:00:00', 26, '2013-10-01 01:32:57', 0),
(34, 34, 1, 0, 7, 'Rings', 'rings', 'Rings description', 1, '2013-10-01 00:00:00', 26, '2013-10-01 01:32:57', 0),
(37, 37, 1, 0, 9, 'Sports', 'sports', 'Sports', 1, '2013-10-01 00:00:00', 0, '2013-10-01 02:44:00', 0),
(38, 38, 1, 0, 9, 'Music', 'music', 'Music', 1, '2013-10-01 00:00:00', 0, '2013-10-01 02:44:00', 0),
(40, 39, 1, 0, 2, 'category 5', 'category-5', '<p>this is category 5</p>', -1, '2013-10-02 04:40:00', 23, '2013-10-01 23:16:45', 0),
(49, 41, 1, 17, 8, 'New Category in English', '', '', -1, '0000-00-00 00:00:00', 0, '2013-10-01 23:49:57', 0),
(50, 41, 2, 17, 8, 'New Category in Spanish', '', '', 1, '0000-00-00 00:00:00', 0, '2013-10-01 23:50:41', 0),
(51, 41, 10, 17, 8, 'New Category in Arabic', '', '', 1, '0000-00-00 00:00:00', 0, '2013-10-01 23:51:13', 0),
(52, 17, 2, 0, 5, 'Physics category spanish', '', '', 1, '0000-00-00 00:00:00', 0, '2013-10-01 23:55:10', 0),
(53, 17, 10, 0, 8, 'Physics category Arabic', '', '', 1, '0000-00-00 00:00:00', 0, '2013-10-01 23:56:17', 0),
(54, 16, 2, 0, 5, 'Mathemetics category es', '', '', 1, '0000-00-00 00:00:00', 0, '2013-10-02 00:24:01', 0),
(55, 16, 10, 0, 8, 'Mathemetics category ar', '', '', 1, '0000-00-00 00:00:00', 0, '2013-10-02 00:24:17', 0),
(56, 42, 10, 0, 5, 'arabic proudct', 'arabic-proudct', '<p>TESt</p>', 1, '2013-10-02 13:22:01', 1, '2013-10-02 07:58:45', 0),
(57, 43, 10, 0, 5, 'arabic 11', 'arabic-11', '<p>test</p>', 1, '2013-10-02 13:22:20', 1, '2013-10-02 07:59:03', 0),
(58, 18, 2, 0, 8, 'Chemistry category es', '', '', 1, '0000-00-00 00:00:00', 0, '2013-10-03 00:24:11', 0),
(59, 18, 10, 0, 8, 'Chemistry category ar', '', '', 1, '0000-00-00 00:00:00', 0, '2013-10-03 00:24:27', 0),
(60, 16, 2, 0, 8, 'Mathemetics category es', '', '', 1, '0000-00-00 00:00:00', 0, '2013-10-03 00:24:53', 0),
(62, 23, 2, 0, 8, 'General Knowledge es', '', '', 1, '0000-00-00 00:00:00', 0, '2013-10-03 00:47:11', 0),
(63, 23, 10, 0, 8, 'General Knowledge ar', '', '', 1, '0000-00-00 00:00:00', 0, '2013-10-03 00:47:21', 0),
(64, 17, 2, 0, 8, 'Physics category es', '', '', 1, '0000-00-00 00:00:00', 0, '2013-10-03 05:41:35', 0),
(65, 44, 1, 3, 1, 'New release', 'new-release', '<p>sdf</p>', -1, '2013-10-18 09:40:41', 12, '2013-10-18 04:17:03', 0),
(66, 33, 2, 0, 7, 'Necklaces-Es', 'necklaces-es', 'Necklaces-ES description', 1, '2013-10-30 00:00:00', 0, '2013-10-30 07:33:33', 0),
(69, 39, 1, 0, 9, 'News', '', 'News', -1, '0000-00-00 00:00:00', 0, '2013-10-31 00:01:33', 0),
(70, 38, 2, 0, 9, 'Music-sp', 'music-sp', 'Music', 1, '2013-10-01 00:00:00', 0, '2013-10-01 02:44:00', 0),
(71, 37, 2, 0, 9, 'Sports-sp', '', 'Sports-sp', 1, '0000-00-00 00:00:00', 0, '2013-10-30 23:58:51', 0),
(72, 39, 2, 0, 9, 'News-sp', '', 'News-sp', 1, '0000-00-00 00:00:00', 0, '2013-10-31 00:01:33', 0),
(73, 37, 10, 0, 9, 'Sports-ar', '', 'Sports-ar', 1, '0000-00-00 00:00:00', 0, '2013-10-30 23:58:51', 0),
(74, 38, 10, 0, 9, 'Music-ar', '', 'Music-ar', 1, '0000-00-00 00:00:00', 0, '2013-10-31 00:01:33', 0),
(75, 39, 10, 0, 9, 'News-ar', '', 'News-ar', 1, '0000-00-00 00:00:00', 0, '2013-10-31 00:01:33', 0),
(76, 50, 1, 37, 9, 'News', 'news', 'Sports', -1, '2013-10-01 00:00:00', 0, '2013-10-01 02:44:00', 0),
(77, 51, 1, 0, 1, 'Science', 'science', '', -1, '2014-10-08 06:02:35', 1, '2014-10-08 00:34:06', 1),
(78, 52, 1, 0, 1, 'Test Category', 'test-category', '<p>Test - Cat</p>', -1, '2014-10-08 07:00:02', 1, '2014-10-08 06:53:17', 0),
(79, 53, 1, 0, 1, 'Test Category', 'test-category', '<p>Test - Cat</p>', -1, '2014-10-08 07:02:10', 1, '2014-10-08 06:55:24', 0),
(80, 54, 1, 0, 1, 'Test Category', 'test-category', '<p>Test - Cat</p>', -1, '2014-10-08 07:03:38', 1, '2014-10-08 06:56:52', 0),
(81, 55, 1, 0, 1, 'Test Category', 'test-category', '<p>Test - Cat</p>', -1, '2014-10-08 07:04:39', 1, '2014-10-08 06:57:53', 0),
(82, 56, 1, 0, 1, 'Test Category', 'test-category', '<p>Test - Cat</p>', -1, '2014-10-08 07:04:50', 1, '2014-10-08 06:58:04', 0),
(83, 57, 1, 0, 1, 'Test Category', 'test-category', '<p>Test - Cat</p>', -1, '2014-10-08 07:04:57', 1, '2014-10-08 06:58:11', 0),
(84, 58, 1, 0, 1, 'Test Category', 'test-category', '<p>Test - Cat</p>', -1, '2014-10-08 07:07:16', 1, '2014-10-08 07:00:31', 0),
(85, 59, 1, 0, 1, 'Test Category', 'test-category12345', '<p>Test - Cat</p>', -1, '2014-10-08 07:07:34', 1, '2014-10-08 07:00:48', 0),
(86, 60, 1, 0, 1, 'Arts', 'arts', '', -1, '2014-10-08 08:42:27', 1, '2014-10-08 08:35:42', 0),
(87, 61, 1, 0, 9, 'I Phone 6', 'i-phone-6', 'tftcftcvt<br>', -1, '2014-10-08 09:28:20', 1, '2014-10-08 09:21:35', 0),
(88, 62, 1, 0, 1, 'new', 'new', '', -1, '2014-10-08 09:31:42', 1, '2014-10-08 09:24:56', 0),
(89, 63, 1, 0, 1, 'new', 'new', '', -1, '2014-10-08 09:32:56', 1, '2014-10-08 09:26:10', 0),
(90, 64, 1, 0, 1, 'new', 'new', '', -1, '2014-10-08 09:37:50', 1, '2014-10-08 09:31:04', 0),
(91, 65, 1, 0, 1, 'dell', 'dell', '', -1, '2014-10-08 10:03:28', 1, '2014-10-08 09:56:42', 0),
(92, 66, 1, 0, 1, 'new', 'dfgfd', '', -1, '2014-10-08 10:05:18', 1, '2014-10-08 09:58:32', 0),
(93, 67, 1, 0, 1, 'games', 'games', '', -1, '2014-10-08 10:10:21', 1, '2014-10-08 10:03:36', 0),
(94, 68, 1, 0, 1, 'Movies', 'movies', '', -1, '2014-10-08 10:13:59', 1, '2014-10-08 10:07:13', 0),
(95, 69, 1, 0, 1, 'Mobile', 'mobile', '', -1, '2014-10-08 10:14:56', 1, '2014-10-08 10:08:11', 0),
(96, 70, 1, 0, 1, 'Animation', 'animation', '', -1, '2014-10-08 10:16:29', 1, '2014-10-08 10:09:43', 0),
(97, 71, 1, 0, 1, 'Social', 'social', '', -1, '2014-10-08 10:33:10', 1, '2014-10-08 10:26:24', 0),
(98, 72, 10, 0, 3, 'I Phone 6', 'i-phone-6', 'gddfgdfg<br>', -1, '2014-10-08 10:47:11', 1, '2014-10-08 10:40:25', 0),
(99, 73, 1, 0, 1, 'Test Cat', 'test-cat', 'Test Cat<br><br>', -1, '2014-10-08 10:54:18', 1, '2014-10-08 10:47:32', 0),
(100, 74, 1, 0, 1, 'dhara', 'dhara', '', -1, '2014-10-08 10:57:16', 1, '2014-10-08 10:50:30', 0),
(101, 75, 1, 0, 4, 'News', 'news', 'News<br>', 1, '2014-10-10 11:15:07', 1, '2014-10-10 11:08:21', 0),
(102, 76, 1, 0, 3, 'Blog  Category', 'blog--category', 'Blog&nbsp; Category<br><br>', -1, '2014-10-10 12:48:53', 1, '2014-10-10 12:42:08', 0),
(103, 77, 1, 0, 5, 'Mobile', 'mobile123', 'Mobile<br>', -1, '2014-10-14 10:27:41', 1, '2014-10-14 10:20:55', 0),
(104, 78, 1, 0, 1, '''gg', 'gg', '', -1, '2014-10-16 09:41:19', 1, '2014-10-16 09:34:33', 0),
(105, 79, 1, 0, 1, 'cvgcb', 'cvgcb', '', -1, '2014-10-16 12:46:47', 1, '2014-10-16 12:40:02', 0),
(106, 80, 1, 0, 1, 'dg', 'dg', '', -1, '2014-10-16 12:47:06', 1, '2014-10-16 12:40:21', 0),
(107, 81, 1, 0, 1, 'Test Cat', 'test-cat', '', -1, '2014-10-16 13:08:46', 1, '2014-10-16 13:02:00', 0),
(108, 82, 1, 0, 5, 'Polo Brand', 'polo-brand', '', 1, '2014-10-16 13:23:07', 1, '2014-10-16 13:16:22', 0),
(109, 83, 1, 0, 1, 'fg,hlg', 'fghlg', '', 1, '2014-10-17 06:21:23', 1, '2014-10-17 06:14:37', 0),
(110, 84, 1, 0, 1, 'dfsfds', 'dfsfds', '', 1, '2014-10-17 06:35:39', 1, '2014-10-17 06:28:53', 0),
(111, 85, 10, 0, 4, 'Sports', 'Sports', '', 1, '2014-10-17 06:43:10', 1, '2014-10-17 06:36:25', 0),
(112, 86, 2, 0, 4, 'hfgjfgfghfgh', 'hfgjfgfghfgh', 'hfghf<br>', 1, '2014-10-17 09:28:08', 1, '2014-10-17 09:21:22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `category_modules`
--

CREATE TABLE IF NOT EXISTS `category_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `category_modules`
--

INSERT INTO `category_modules` (`id`, `name`, `title`, `status`, `created`, `modified`) VALUES
(1, 'general', 'General', 1, '2013-09-18 17:24:14', '2013-09-18 11:54:14'),
(2, 'newsletter', 'Newsletter', 1, '2013-09-18 17:24:14', '2013-09-18 11:54:14'),
(3, 'blog', 'Blog', 1, '2013-09-18 17:24:32', '2013-09-18 11:54:32'),
(4, 'forum', 'Forum', 1, '2013-09-18 17:24:32', '2013-09-18 11:54:32'),
(5, 'products', 'Products', 1, '2013-09-18 19:09:59', '2013-09-18 13:39:59'),
(6, 'gallery', 'Gallery', 1, '2013-09-26 16:08:19', '2013-09-26 10:38:19'),
(7, 'shoppingcart', 'Shopping Cart', 1, '2013-09-27 00:00:00', '2013-09-27 06:00:13'),
(8, 'quiz', 'Quiz', 1, '2013-09-27 00:00:00', '2013-09-27 11:10:03'),
(9, 'testimonial', 'Testimonial', 1, '2013-10-01 13:34:00', '2013-10-01 08:01:42');

-- --------------------------------------------------------

--
-- Table structure for table `category_newsletters`
--

CREATE TABLE IF NOT EXISTS `category_newsletters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(8) NOT NULL,
  `state_id` int(4) NOT NULL,
  `country_id` int(4) NOT NULL,
  `city_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `lang_id` tinyint(1) NOT NULL COMMENT '1-english,0-spanish',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-active,0-inactive, -1-deleted',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `state_id` (`state_id`),
  KEY `city_id` (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `city_id`, `state_id`, `country_id`, `city_name`, `lang_id`, `status`, `created_by`, `created_on`, `modified_by`, `modified_on`) VALUES
(57, 2, 2, 3, 'Palo Alto', 1, 1, 28, '2013-10-08 05:17:55', 28, '2013-11-08 06:13:16'),
(60, 2, 2, 3, 'بالو ألتو', 10, 1, 28, '2013-10-08 05:42:27', 12, '2013-11-21 01:25:39'),
(61, 2, 2, 3, 'Palo Alto', 2, 1, 28, '2013-10-08 05:46:22', 28, '2013-11-07 06:18:10'),
(64, 5, 8, 4, 'Ahmedabad', 1, 1, 12, '2013-10-08 06:01:25', 28, '2013-11-08 06:13:16'),
(65, 6, 8, 4, 'Baroda', 1, 1, 28, '2013-10-17 12:55:21', 28, '2013-11-08 06:13:16'),
(66, 7, 8, 4, 'Surat', 1, 1, 28, '2013-10-17 12:55:37', 28, '2013-11-08 06:13:16'),
(67, 8, 8, 4, 'Bhavnagar', 1, 1, 28, '2013-10-17 12:55:53', 28, '2013-11-08 06:13:16'),
(68, 9, 9, 4, 'Mumbai', 1, -1, 28, '2013-10-17 12:56:17', 12, '2013-11-11 00:42:26'),
(69, 10, 8, 4, 'fgjhghjghj', 1, -1, 28, '2013-10-21 06:57:56', 28, '2013-11-07 05:41:04'),
(70, 11, 11, 4, '""', 1, -1, 28, '2013-10-21 07:09:32', 28, '2013-11-07 05:41:04'),
(71, 12, 15, 4, 'Hyderabad', 1, 1, 28, '2013-10-21 08:22:12', 28, '2013-11-08 06:13:16'),
(72, 13, 14, 14, 'Hyderabad', 1, 1, 28, '2013-10-21 08:22:57', 28, '2013-11-08 06:13:16'),
(73, 5, 8, 4, 'Ahmedabad', 2, 1, 28, '2013-10-21 08:24:13', 1, '2013-11-21 06:58:04'),
(74, 14, 8, 4, 'bhuj', 1, 1, 12, '2013-10-22 08:42:33', 28, '2013-11-08 06:13:16'),
(75, 15, 8, 4, 'Valsad', 1, 1, 1, '2013-10-28 05:50:55', 28, '2013-11-08 06:13:16'),
(76, 16, 8, 4, 'Himmat Nagar', 1, 1, 1, '2013-11-06 12:46:52', 1, '2013-11-21 06:57:10');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` char(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'session id',
  `ip_address` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'ip address',
  `user_agent` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'user agent - Browser',
  `last_activity` int(10) unsigned NOT NULL COMMENT 'last activity',
  `user_data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s session data',
  `previous_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'previous session id',
  `last_rotate` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_write` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'last write',
  UNIQUE KEY `session_id` (`session_id`),
  KEY `last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ci_sessions`
--

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE IF NOT EXISTS `cms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cms_id` int(11) NOT NULL COMMENT 'cms id for frontend representation',
  `lang_id` int(11) NOT NULL DEFAULT '1' COMMENT 'Foreign Key of id from language table',
  `title` varchar(100) CHARACTER SET utf8 NOT NULL,
  `slug_url` varchar(50) CHARACTER SET utf8 NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `meta_fields` text COLLATE utf8_bin NOT NULL COMMENT 'Json Encoded Array',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Status Active/Inactive',
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lang_id` (`lang_id`),
  KEY `cms_id` (`cms_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=100 ;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`id`, `cms_id`, `lang_id`, `title`, `slug_url`, `description`, `meta_fields`, `status`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 1, 1, 'cms3', 'cms3', '<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br>\r\n&nbsp;</span>', '', 1, '2013-09-03 13:13:58', 0, '2014-10-16 00:48:07', 1),
(2, 2, 1, 'About-us', 'about-us', '<p>test about us page - english</p>', '', 1, '2013-09-03 13:14:32', 0, '2014-10-15 23:36:40', 0),
(3, 1, 2, 'cms3 Sp', 'cms3-es', '<p>test cms3 page - spanish</p>', '', 1, '2013-09-03 13:16:16', 0, '2014-02-12 09:08:04', 0),
(4, 3, 2, 'privacy Policy-sp', 'privacy-policy-sp', '<p>Privacy Policy Page - Spanish</p>\n\n<p>&nbsp;</p>\n\n<p>this is the testing</p>', '', 1, '2013-09-03 13:17:06', 0, '2014-02-20 13:51:48', 0),
(5, 2, 2, 'About Us Sp', 'about-us1', '<p>test about us page - spanish</p>', '', 1, '2013-09-03 13:18:17', 0, '2014-04-25 06:13:37', 1),
(10, 8, 1, 'Home', 'Home', 'Home Page - English', '', 1, '2013-09-10 06:22:08', 0, '2014-10-06 00:02:11', 1),
(12, 1, 10, 'cms-ar', 'cms-ar', '', '', 1, '2013-09-16 09:36:58', 0, '2014-10-07 04:37:17', 0),
(17, 14, 10, 'newcms-arabic', 'newcms-arabic', '', '', 1, '2013-09-19 04:23:23', 0, '2013-09-18 22:53:23', 0),
(18, 15, 10, 'كيف ذلك، يعمل', 'how-it-works', '<p>كيف ذلك، يعمل</p>', '', 1, '2013-09-23 14:14:06', 0, '2013-09-23 08:45:27', 0),
(20, 17, 2, 'this is  the teting', '---this-is--the-teting----', '', '', 1, '2013-09-24 13:07:38', 11, '2013-09-24 13:07:40', 0),
(22, 8, 2, 'Home-sp', 'Home-sps', '', '', 1, '2013-09-27 13:09:05', 23, '2013-10-24 03:50:31', 0),
(24, 20, 2, 'new cms page in spanish', 'new-cms-page-in-spanish', '<p>This is new cms page in spanish</p>', '', 1, '2013-10-01 11:58:44', 23, '2013-10-01 06:32:21', 23),
(25, 19, 2, 'This is new cms page in spanish', 'this-is-new-cms-page-in-spanish', '', '', 1, '2013-10-01 12:02:32', 23, '2013-10-01 11:59:07', 0),
(26, 19, 10, 'This is new cms page in arabic', 'this-is-new-cms-page-in-arabic', '', '', 1, '2013-10-01 12:04:24', 23, '2013-10-01 12:00:59', 0),
(41, 22, 2, 'cms-sp', 'cms-sp', '<p>dasdfasfasfasdf</p>', '', 1, '2013-10-30 08:47:33', 23, '2014-10-07 04:37:53', 0),
(48, 37, 10, 'test-article-en', 'test-article-en', '<p>This is arabic content</p>', '', 1, '2013-12-05 10:56:30', 1, '2013-12-05 11:01:42', 0),
(49, 38, 1, 'Terms & Conditions', 'Terms & Conditions', 'Terms &amp; Conditions', '', 1, '2013-12-12 05:36:36', 1, '2014-10-07 04:29:07', 0),
(52, 41, 2, 'test-article-ar', 'test-article-ar', '', '', 1, '2013-12-12 12:50:24', 1, '2013-12-12 13:03:34', 0),
(63, 2, 11, 'About French', 'about-fnch', '<p>ryrtyrty</p>', '', 1, '2014-02-07 13:03:03', 1, '2014-02-11 13:33:29', 0),
(66, 53, 1, 'Special Page', 'special-page', '<p>Some of the detail is requied. Some of the detail is requied. Some of the detail is requied. Some of the detail is requied. Some of the detail is requied. Some of the detail is requied. Some of the detail is requied. Some of the detail is requied. Some of the detail is requied. Some of the detail is requied.</p>', '', -1, '2014-02-12 14:31:25', 1, '2014-02-12 09:02:49', 0),
(70, 57, 1, 'portfolio', 'portfolio', '<p>portfolio</p>', '', -1, '2014-02-13 10:50:25', 1, '2014-02-18 10:30:44', 0),
(71, 57, 2, 'portfolio', 'portfoliosp', 'portfolio', '', 1, '2014-02-13 10:52:23', 1, '2014-10-13 06:16:49', 1),
(86, 58, 1, 'Test Responsive', 'Test Responsive', '<b>Test <span class="wysiwyg-color-red"><i><u>Responsive22222</u></i></span></b>', '', -1, '2014-10-03 10:58:33', 1, '2014-10-08 04:41:39', 1),
(87, 59, 10, 'Admin Escalation -Ar', 'admin-escalation--ar', 'Admin Escalation -Ar<br><br>', '', 1, '2014-10-09 11:47:44', 1, '2014-10-09 11:40:58', 0),
(88, 60, 2, 'SONY VAIO - SP', 'sony-vaio---sp', 'SONY VAIO - SP<br><br>', '', -1, '2014-10-09 11:49:23', 1, '2014-10-09 11:42:38', 0),
(89, 61, 10, 'SONY VAIO - AR', 'sony-vaio---ar', 'SONY VAIO - AR<br><br>', '', 1, '2014-10-09 11:49:56', 1, '2014-10-09 11:43:10', 0),
(90, 62, 2, 'Test Span', 'test-span', 'sfdsfd dsfdsfs<br>', '', 1, '2014-10-13 11:52:20', 1, '2014-10-13 11:45:35', 0),
(91, 63, 1, 'hjhgjhj''446"', 'hjhgjhj446', '', '', -1, '2014-10-15 07:53:40', 1, '2014-10-16 03:33:35', 1),
(92, 64, 1, 'hjhk', 'hjhk', 'jg<br>', '', -1, '2014-10-15 07:54:21', 1, '2014-10-15 07:47:35', 0),
(93, 65, 1, 'vghjhgj', 'vghjhgj', '', '', -1, '2014-10-16 09:03:14', 1, '2014-10-16 08:56:28', 0),
(94, 66, 1, 'dgtfdgh', 'dgtfdgh', '', '', -1, '2014-10-16 10:48:14', 1, '2014-10-16 10:41:28', 0),
(95, 67, 1, '''fdaf', 'fdaf', '', '', -1, '2014-10-16 10:48:26', 1, '2014-10-16 10:41:41', 0),
(96, 68, 1, '''#$^&*((', 'sand', '', '', -1, '2014-10-16 10:48:42', 1, '2014-10-16 10:41:57', 0),
(97, 69, 1, 'Test CMS for Slug by Anand', 'test-cms-for-slug-by-anand', '', '', 1, '2014-10-16 13:00:24', 1, '2014-10-16 12:53:38', 0),
(98, 70, 1, 'dsf', 'dsf', 'safs<br>', '', 1, '2014-10-17 08:05:21', 1, '2014-10-17 07:58:35', 0),
(99, 71, 2, 'ghdfhfghfhf', 'ghdfhfghfhf', 'fghfgh<br>', '', 1, '2014-10-17 08:34:19', 1, '2014-10-17 08:27:33', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cms_meta`
--

CREATE TABLE IF NOT EXISTS `cms_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cms_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `cms_meta`
--

INSERT INTO `cms_meta` (`id`, `cms_id`, `lang_id`, `meta_title`, `meta_keywords`, `meta_description`) VALUES
(1, 2, 1, 'About-us', 'About-us', 'About-us'),
(2, 58, 1, 'Test Responsive', 'Test Responsive', 'Test Responsive'),
(3, 8, 1, '', '', ''),
(4, 38, 1, 'Terms & Conditions', 'Terms & Conditions', 'Terms & Conditions'),
(5, 59, 10, 'Admin Escalation -Ar', 'Admin Escalation -Ar', 'Admin Escalation -Ar'),
(6, 60, 2, 'SONY VAIO - SP', 'SONY VAIO - SP', 'SONY VAIO - SP'),
(7, 61, 10, 'SONY VAIO - AR', 'SONY VAIO - AR', 'SONY VAIO - AR'),
(8, 57, 2, '', '', ''),
(9, 62, 2, '', '', ''),
(10, 63, 1, '', '', ''),
(11, 64, 1, '', '', ''),
(12, 1, 1, '', '', ''),
(13, 65, 1, '', '', ''),
(14, 66, 1, '', '', ''),
(15, 67, 1, '', '', ''),
(16, 68, 1, '', '', ''),
(17, 69, 1, '', '', ''),
(18, 70, 1, '', '', ''),
(19, 71, 2, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE IF NOT EXISTS `contact_us` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `subject` varchar(100) CHARACTER SET utf8 NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `ip_address` varchar(500) CHARACTER SET utf8 NOT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(4) NOT NULL,
  `country_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `country_iso` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `lang_id` tinyint(1) NOT NULL COMMENT '1-english,0-spanish',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-active,0-inactive',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=85 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `country_id`, `country_name`, `country_iso`, `lang_id`, `status`, `created_by`, `created_on`, `modified_by`, `modified_on`) VALUES
(61, 2, 'Afghanistana', 'AF', 1, 1, 12, '2013-10-08 05:14:14', 12, '2013-11-11 07:08:11'),
(62, 2, 'Afghanistansp', 'AF', 2, 0, 12, '2013-10-08 05:14:36', 1, '2013-10-31 08:02:53'),
(63, 2, 'Afghanistanar', 'AF', 10, 1, 12, '2013-10-08 05:15:06', 12, '2013-11-11 07:08:03'),
(64, 3, 'United States', 'US', 1, 1, 28, '2013-10-08 05:15:23', 28, '2013-11-13 05:07:16'),
(65, 3, 'EstadosUnidos', 'US', 2, 0, 28, '2013-10-08 05:20:12', 1, '2013-10-31 08:02:53'),
(66, 3, 'UnitedStates', 'US', 10, 1, 28, '2013-10-08 05:37:17', 12, '2013-11-11 07:08:03'),
(67, 4, 'India', 'IN', 1, 1, 12, '2013-10-08 05:37:44', 1, '2013-10-31 08:03:06'),
(68, 5, 'الهند', 'IN', 10, -1, 12, '2013-10-14 04:38:37', 0, '2013-10-14 04:45:20'),
(69, 4, 'الهند', 'IN', 10, 1, 12, '2013-10-14 04:39:24', 12, '2013-11-11 07:08:03'),
(70, 6, 'USA', 'US', 1, -1, 12, '2013-10-17 10:48:27', 0, '2013-10-17 11:25:10'),
(71, 7, 'United States', 'us', 10, -1, 12, '2013-10-17 11:22:17', 0, '2013-10-17 11:31:02'),
(72, 8, 'United States', 'us', 10, -1, 12, '2013-10-17 11:24:56', 0, '2013-10-17 11:31:43'),
(73, 9, 'UnitedStates', 'PL', 1, -1, 12, '2013-10-17 11:38:46', 0, '2013-10-17 11:45:31'),
(74, 10, 'Colombia', 'CO', 1, 1, 12, '2013-10-17 12:41:58', 1, '2013-10-31 08:03:06'),
(75, 11, 'Algeria', 'DZ', 1, -1, 12, '2013-10-17 12:43:08', 0, '2013-10-29 12:58:58'),
(76, 12, 'Bahamas', 'BS', 1, 1, 12, '2013-10-17 12:43:35', 1, '2013-10-31 08:03:06'),
(77, 13, 'india', 'in', 1, -1, 28, '2013-10-17 12:43:56', 0, '2013-10-17 12:50:24'),
(78, 4, 'India-sp', 'IN', 2, 0, 28, '2013-10-18 05:49:18', 1, '2013-10-31 08:02:53'),
(79, 14, 'Pakistan', 'PK', 1, -1, 28, '2013-10-21 08:19:47', 12, '2013-10-29 07:35:27'),
(80, 15, 'Demo', 'AB', 1, -1, 12, '2013-10-23 09:44:36', 0, '2013-10-23 09:50:59'),
(81, 16, 'Algeria', 'DZ', 1, 1, 12, '2013-10-29 13:00:42', 1, '2013-10-31 08:03:06'),
(82, 17, 'كينيا', 'KN', 10, 1, 1, '2013-11-06 12:37:57', 0, '2013-11-06 12:43:50'),
(83, 18, 'South Afrika', 'RS', 1, 1, 1, '2013-11-06 12:43:31', 0, '2013-11-06 12:49:25'),
(84, 19, 'ABCD', 'AB', 1, 1, 12, '2013-11-21 09:49:25', 0, '2013-11-21 09:54:58');

-- --------------------------------------------------------

--
-- Table structure for table `dashboard`
--

CREATE TABLE IF NOT EXISTS `dashboard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `demo`
--

CREATE TABLE IF NOT EXISTS `demo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_demo` varchar(100) NOT NULL,
  `test_demow` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dmtest`
--

CREATE TABLE IF NOT EXISTS `dmtest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(10) NOT NULL,
  `uname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE IF NOT EXISTS `email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `email_template`
--

CREATE TABLE IF NOT EXISTS `email_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `template_name` varchar(100) NOT NULL,
  `template_subject` varchar(100) NOT NULL,
  `template_body` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `email_template`
--

INSERT INTO `email_template` (`id`, `template_id`, `lang_id`, `template_name`, `template_subject`, `template_body`, `status`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 1, 1, 'registration_template', 'Registration Email', '<body style="font-family: Arial, Helvetica, sans-serif;  color: #414141;  font-size: 15px;  line-height: 22px;">\r\n\r\n<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">\r\n<tbody>\r\n<tr>\r\n<td class="border_cs" valign="top" style="border: 5px solid #000000;  padding: 20px 28px;  background-color: #FFF;">\r\n  <table border="0" cellpadding="0" cellspacing="0" width="100%">\r\n	<tbody>\r\n	<tr>\r\n	<td valign="top">\r\n	 <table border="0" cellpadding="0" cellspacing="0" width="100%">\r\n	   <tbody>\r\n		<tr>\r\n	            <td >\r\n		<img alt="" src="[logopath]"  />\r\n</td>\r\n\r\n</tr>\r\n</tbody>\r\n</table>\r\n\r\n</td>\r\n</tr>\r\n<tr>\r\n<td><hr></td>\r\n</tr>\r\n<tr>\r\n\r\n<table border="0" cellpadding="0" cellspacing="2" width="100%">\r\n<tbody style="line-height: 25px;  font-size: 13px;">\r\n<tr>\r\n<td colspan="2">\r\n<b>Dear [name]<b><br>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td colspan="2" class="text_detail">\r\nYour registration has been successful. Please click on the activation link to verify your account.\r\n</td>\r\n</tr>\r\n<tr>\r\n<td colspan="2">Username: [USERNAME]</td>\r\n</tr>\r\n<tr>\r\n<td colspan="2">Activation Link: <a href="[activation_link]">[activation_link]</a></td>\r\n</tr>\r\n\r\n<tr>\r\n<td colspan="2"><a href="[activation_link]">Clik Here</a> to activate your account.</td>\r\n</tr>\r\n\r\n<tr><td align="center" colspan="2" valign="center"><span style="font-size: 10pt">&copy; Copyright [YEAR] [SITE_NAME] All rights reserved.</span></td>\r\n</tr></tbody></table>\r\n\r\n\r\n						</tr>\r\n					</tbody>\r\n				</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</body>', 1, '2013-10-08 00:00:00', 1, '2014-10-07 10:45:15', 0),
(8, 8, 10, 'template-ar', '', '<p>template-artemplate-artemplate-artemplate-artemplate-artemplate-artemplate-artemplate-artemplate-artemplate-artemplate-artemplate-artemplate-artemplate-artemplate-artemplate-artemplate-artemplate-artemplate-artemplate-artemplate-artemplate-artemplate-artemplate-ar</p>', 1, '2013-10-11 05:37:39', 1, '2014-01-08 05:40:04', 0),
(17, 17, 1, 'forgot_password_email_template', 'Forgot Password Mail', '<body style="font-family: Arial, Helvetica, sans-serif;  color: #414141;  font-size: 15px;  line-height: 22px;">\r\n\r\n<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">\r\n<tbody>\r\n<tr>\r\n<td class="border_cs" valign="top" style="border: 5px solid #000000;  padding: 20px 28px;  background-color: #FFF;">\r\n  <table border="0" cellpadding="0" cellspacing="0" width="100%">\r\n	<tbody>\r\n	<tr>\r\n	<td valign="top">\r\n	 <table border="0" cellpadding="0" cellspacing="0" width="100%">\r\n	   <tbody>\r\n		<tr>\r\n	            <td >\r\n		<img alt="" src="[logopath]"  />\r\n</td>\r\n\r\n</tr>\r\n</tbody>\r\n</table>\r\n\r\n</td>\r\n</tr>\r\n<tr>\r\n<td><hr></td>\r\n</tr>\r\n<tr>\r\n\r\n<table border="0" cellpadding="0" cellspacing="2" width="100%">\r\n<tbody style="line-height: 25px;  font-size: 13px;">\r\n<tr>\r\n<td colspan="2">\r\n<b>Dear [name]<b><br>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td colspan="2" class="text_detail">\r\nWe have reset you password. Please try to login with below details.\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="16%">Username :[USERNAME]</td>\r\n</tr>\r\n<tr>\r\n<td width="16%">New Password :[PASSWORD]</td>\r\n</tr>\r\n<tr><td align="center" colspan="2" valign="center"><span style="font-size: 10pt">&copy; Copyright 2013 [SITE_NAME] All rights reserved.</span></td>\r\n</tr></tbody></table>\r\n\r\n\r\n						</tr>\r\n					</tbody>\r\n				</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</body>', 1, '2014-01-13 13:47:42', 1, '2014-10-07 10:45:15', 0),
(20, 20, 11, 'testing_purpose_french', 'testing purpose123', '<p>testing purpose testing purpose<strong>&nbsp; </strong>testing purpose testing purpose testing purpose</p>', 1, '2014-01-20 14:20:20', 1, '2014-01-20 08:50:20', 0),
(22, 22, 1, 'Invite_user', 'Invite user', '', 1, '2014-02-05 11:32:33', 1, '2014-10-07 10:45:15', 0),
(23, 23, 1, 'contact_us', 'Conatct Us', '<body style="font-family: Arial, Helvetica, sans-serif;  color: #414141;  font-size: 15px;  line-height: 22px;"><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td class="border_cs" valign="top" style="border: 5px solid #000000;  padding: 20px 28px;  background-color: #FFF;">  <table border="0" cellpadding="0" cellspacing="0" width="100%">	<tbody>	<tr>	<td valign="top">	 <table border="0" cellpadding="0" cellspacing="0" width="100%">	   <tbody>		<tr>	            <td >		<img alt="" src="[logopath]"  /></td></tr></tbody></table></td></tr><tr><td><hr></td></tr><tr><table border="0" cellpadding="0" cellspacing="2" width="100%"><tbody style="line-height: 25px;  font-size: 13px;"><tr><td colspan="2"><b>Hi,<b><br></td></tr><tr>      <td colspan="2"  class="text_detail">New contact us request, Please check below details</td>     </tr>     <tr>      <td colspan="2"><b>Name :</b>[Name]</td>     </tr>     <tr>      <td colspan="2"><b>Email :</b>[Email]</td>     </tr>     <tr>      <td colspan="2"><b>Message :</b>[Message]</td>     </tr><tr><td align="center" colspan="2" valign="center"><span style="font-size: 10pt">&copy; Copyright [YEAR] [SITE_NAME] All rights reserved.</span></td></tr></tbody></table>						</tr>					</tbody>				</table>			</td>		</tr>	</tbody></table></body>', 1, '2014-02-11 10:47:20', 1, '2014-10-07 10:45:27', 0),
(24, 24, 2, 'NVBNVBN', 'BVNVBNVBN', 'NVBNV', 1, '2014-10-17 08:41:28', 1, '2014-10-17 08:34:42', 0);

-- --------------------------------------------------------

--
-- Table structure for table `eventcal`
--

CREATE TABLE IF NOT EXISTS `eventcal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_title` varchar(100) COLLATE utf8_bin NOT NULL,
  `event_location` varchar(100) COLLATE utf8_bin NOT NULL,
  `event_organizer` varchar(100) COLLATE utf8_bin NOT NULL,
  `event_desc` text COLLATE utf8_bin NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `event_fees` decimal(8,2) NOT NULL,
  `recurrence` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 for none 1 for weekly 2 for monthly 3 for yearly 4 for all days',
  `repeated` tinyint(1) NOT NULL COMMENT '0 fro never 1 for specific date',
  `repeat_end_date` date NOT NULL COMMENT 'date when repeat event ends',
  `privacy` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 for public and 1 for private',
  `created_by` int(11) NOT NULL,
  `created_on` date NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_on` date NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 for deleted and 0 for not deleted',
  PRIMARY KEY (`id`),
  KEY `lang_id` (`lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_post`
--

CREATE TABLE IF NOT EXISTS `forum_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL COMMENT 'PK of forum_categories',
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `forum_post_title` varchar(255) NOT NULL DEFAULT '',
  `slug_url` varchar(50) NOT NULL,
  `forum_post_text` text NOT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT '0' COMMENT '(0) no (1) yes',
  `status` tinyint(1) NOT NULL COMMENT '(-1:delete , 1:active  and  2:inactive)',
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  `deleted_on` datetime NOT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `forum_post`
--

INSERT INTO `forum_post` (`id`, `category_id`, `lang_id`, `forum_post_title`, `slug_url`, `forum_post_text`, `is_private`, `status`, `created_on`, `created_by`, `modified_on`, `modified_by`, `deleted_on`, `deleted_by`) VALUES
(1, 8, 1, 'Test by Anand', 'test-by-anand', '<p>Test by Anand</p>', 0, 1, '2014-10-10 12:47:31', 1, '2014-10-10 09:59:19', 0, '0000-00-00 00:00:00', 0),
(2, 8, 1, 'Test by Anand for actions', 'test-by-anand-for-actions', '<p>Test by Anand for actions</p>', 0, 1, '2014-10-10 13:12:58', 1, '2014-10-10 13:43:43', 0, '0000-00-00 00:00:00', 0),
(3, 8, 1, 'My Forum', 'my-forum', '<b>My Forum Description</b><br>', 0, 1, '2014-10-10 15:09:08', 1, '2014-10-10 09:59:16', 0, '0000-00-00 00:00:00', 0),
(4, 8, 1, 'My Forum test', 'my-forum-test', '<b>My Forum Description</b><br>', 0, 1, '2014-10-10 15:11:34', 1, '2014-10-10 09:59:16', 1, '0000-00-00 00:00:00', 0),
(5, 8, 1, 'My Forum test here 123', 'my-forum-test-here-123', '<b>My Forum Description</b><br>', 0, 1, '2014-10-10 15:11:55', 1, '2014-10-16 08:45:12', 1, '0000-00-00 00:00:00', 0),
(6, 75, 1, 'Test by Anand22', 'test-by-anand22', 'Lorem Ipsum is simply dummy \r\ntext of the printing and typesetting industry. Lorem Ipsum has been the \r\nindustry''s standard dummy text ever since the 1500s, when an unknown \r\nprinter took a galley of type and scrambled it to make a type specimen \r\nbook. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining essentially unchanged. It was \r\npopularised in the 1960s with the release of Letraset sheets containing \r\nLorem Ipsum passages, and more recently with desktop publishing software\r\n like Aldus PageMaker including versions of Lorem Ipsum.<div>It\r\n is a long established fact that a reader will be distracted by the \r\nreadable content of a page when looking at its layout. The point of \r\nusing Lorem Ipsum is that it has a more-or-less normal distribution of \r\nletters, as opposed to using ''Content here, content here'', making it \r\nlook like readable English. Many desktop publishing packages and web \r\npage editors now use Lorem Ipsum as their default model text, and a \r\nsearch for ''lorem ipsum'' will uncover many web sites still in their \r\ninfancy. Various versions have evolved over the years, sometimes by \r\naccident, sometimes on purpose (injected humour and the like).</div><br>', 0, 1, '2014-10-10 17:00:39', 1, '2014-10-10 11:30:39', 0, '0000-00-00 00:00:00', 0),
(7, 8, 1, 'NetworkKing Announcement', 'networkking-announcement', '<h2><b><span class="wysiwyg-color-maroon">This is testing</span></b></h2>', 0, 1, '2014-10-10 19:11:18', 1, '2014-10-10 13:42:29', 0, '0000-00-00 00:00:00', 0),
(8, 8, 1, 'New Forum by Amit -SP12', 'new-forum-by-amit--sp12', 'New Forum by Amit -SP12<br>', 0, 1, '2014-10-13 11:03:07', 1, '2014-10-13 05:36:05', 1, '0000-00-00 00:00:00', 0),
(9, 8, 1, 'New Forum by Amit - AR', 'new-forum-by-amit---ar', 'New Forum by Amit - AR<br>', 0, 1, '2014-10-13 11:03:49', 1, '2014-10-13 05:33:49', 0, '0000-00-00 00:00:00', 0),
(10, 8, 1, 'Test Es', 'test-es', 'asdasdasda', 0, 1, '2014-10-13 17:11:52', 1, '2014-10-13 11:41:52', 0, '0000-00-00 00:00:00', 0),
(11, 8, 1, 'Test Span', 'test-span', 'dsdasdas dasdad<br>', 0, 1, '2014-10-13 17:14:09', 1, '2014-10-13 11:44:09', 0, '0000-00-00 00:00:00', 0),
(12, 1, 2, 'Test Spanish by Anand', 'test-spanish-by-anand', 'adasdas', 0, 1, '2014-10-13 17:23:48', 1, '2014-10-13 11:53:48', 0, '0000-00-00 00:00:00', 0),
(13, 8, 1, 'chch', 'chch', 'bbvcb', 0, 1, '2014-10-17 13:44:46', 1, '2014-10-17 08:14:46', 0, '0000-00-00 00:00:00', 0),
(14, 8, 1, 'BVCBVCBVCBVC', 'bvcbvcbvcbvc', 'BVCBVCBVC', 0, 1, '2014-10-17 14:03:11', 1, '2014-10-17 08:33:11', 0, '0000-00-00 00:00:00', 0),
(15, 75, 1, 'GHJGHJ', 'ghjghj', 'JGHJGJ', 0, 1, '2014-10-17 14:03:42', 1, '2014-10-17 08:33:42', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `forum_topics`
--

CREATE TABLE IF NOT EXISTS `forum_topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL COMMENT 'PK of forum_post',
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `topic_title` varchar(255) NOT NULL,
  `topic_text` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '(-1:delete 1:active 2: inactive)',
  `attachment` varchar(255) DEFAULT NULL COMMENT 'attched file path',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `forum_topics`
--

INSERT INTO `forum_topics` (`id`, `post_id`, `lang_id`, `topic_title`, `topic_text`, `status`, `attachment`, `created_by`, `created_on`, `modified_by`, `modified_on`, `deleted_by`, `deleted_on`) VALUES
(1, 2, 1, 'dsfsdfsdfsd', '<p>sdfsdfsdfsdf</p>', 1, '', 1, '2014-10-10 15:24:38', NULL, NULL, NULL, NULL),
(2, 2, 1, 'fsfsfsdfsdf', '<p>sfsfsdfsdfsdfsdf</p>', 1, 'city.ods', 1, '2014-10-10 15:25:01', NULL, NULL, NULL, NULL),
(3, 1, 1, 'sfsfsf', '<p>sfsfs</p>', 1, '', 1, '2014-10-10 15:26:23', NULL, NULL, NULL, NULL),
(4, 2, 1, 'Anand Test reply', 'Anand Test reply with more text .........!<br>', 1, '', 1, '2014-10-10 18:50:50', NULL, NULL, NULL, NULL),
(5, 2, 1, 'Anand test attachment', 'Anand test attachment with more text ....!<br>', 1, 'Bootstrap.txt', 1, '2014-10-10 18:51:20', NULL, '2014-10-10 13:40:40', NULL, NULL),
(6, 7, 1, 'This is reply with new tools of ck editor', '<span>Lorem Ipsum is simply dummy text of \r\nthe printing and typesetting industry. Lorem Ipsum has been the \r\nindustry''s standard dummy text ever since the 1500s, when an unknown \r\nprinter took a galley of type and scrambled it to make a type specimen \r\nbook. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining essentially unchanged. It was \r\npopularised in the 1960s with the release of Letraset sheets containing \r\nLorem Ipsum passages, and more recently with desktop publishing software\r\n like Aldus PageMaker including versions of Lorem Ipsum.</span><div><span>It\r\n is a long established fact that a reader will be distracted by the \r\nreadable content of a page when looking at its layout. The point of \r\nusing Lorem Ipsum is that it has a more-or-less normal distribution of \r\nletters, as opposed to using ''Content here, content here'', making it \r\nlook like readable English. Many desktop publishing packages and web \r\npage editors now use Lorem Ipsum as their default model text, and a \r\nsearch for ''lorem ipsum'' will uncover many web sites still in their \r\ninfancy. Various versions have evolved over the years, sometimes by \r\naccident, sometimes on purpose (injected humour and the like).</span></div><br>', 1, 'city.ods', 1, '2014-10-10 19:12:29', NULL, NULL, NULL, NULL),
(7, 2, 1, 'This is reply with new tools of ck editor', '<span>Lorem Ipsum is simply dummy text of \r\nthe printing and typesetting industry. Lorem Ipsum has been the \r\nindustry''s standard dummy text ever since the 1500s, when an unknown \r\nprinter took a galley of type and scrambled it to make a type specimen \r\nbook. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining essentially unchanged. It was \r\npopularised in the 1960s with the release of Letraset sheets containing \r\nLorem Ipsum passages, and more recently with desktop publishing software\r\n like Aldus PageMaker including versions of Lorem Ipsum.</span><div><span>It\r\n is a long established fact that a reader will be distracted by the \r\nreadable content of a page when looking at its layout. The point of \r\nusing Lorem Ipsum is that it has a more-or-less normal distribution of \r\nletters, as opposed to using ''Content here, content here'', making it \r\nlook like readable English. Many desktop publishing packages and web \r\npage editors now use Lorem Ipsum as their default model text, and a \r\nsearch for ''lorem ipsum'' will uncover many web sites still in their \r\ninfancy. Various versions have evolved over the years, sometimes by \r\naccident, sometimes on purpose (injected humour and the like).</span></div><br>', 1, '', 1, '2014-10-10 19:13:35', NULL, NULL, NULL, NULL),
(8, 2, 1, 'This is reply  from amit', '<span>Lorem Ipsum is simply dummy text of \r\nthe printing and typesetting industry. Lorem Ipsum has been the \r\nindustry''s standard dummy text ever since the 1500s, when an unknown \r\nprinter took a galley of type and scrambled it to make a type specimen \r\nbook. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining essentially unchanged. It was \r\npopularised in the 1960s with the release of Letraset sheets containing \r\nLorem Ipsum passages, and more recently with desktop publishing software\r\n like Aldus PageMaker including versions of Lorem Ipsum.</span><div><span>It\r\n is a long established fact that a reader will be distracted by the \r\nreadable content of a page when looking at its layout. The point of \r\nusing Lorem Ipsum is that it has a more-or-less normal distribution of \r\nletters, as opposed to using ''Content here, content here'', making it \r\nlook like readable English. Many desktop publishing packages and web \r\npage editors now use Lorem Ipsum as their default model text, and a \r\nsearch for ''lorem ipsum'' will uncover many web sites still in their \r\ninfancy. Various versions have evolved over the years, sometimes by \r\naccident, sometimes on purpose (injected humour and the like).</span></div><br>', 1, '', 1, '2014-10-10 19:13:43', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `tag` varchar(100) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0=inactive, 1=active, -1=inactive',
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `gallery_id`, `title`, `tag`, `image`, `status`, `updated`, `created`) VALUES
(2, 14, 'nokia1 123', 'nokia', 'nikola-cirkovic.jpg', 1, '0000-00-00 00:00:00', '2014-10-01 18:22:01'),
(3, 14, 'SONY VAIO', 'SONY VAIO', 'booklet1.jpg', -1, '0000-00-00 00:00:00', '2014-10-02 11:19:54'),
(4, 14, 'I Phone 6', 'dfdfs', 'index.jpg', -1, '0000-00-00 00:00:00', '2014-10-02 11:26:35'),
(6, 15, 'dell', '', 'Lenobo-505s.jpg', -1, '0000-00-00 00:00:00', '2014-10-02 14:01:30'),
(7, 14, 'Sony Xperia Z2', '', 'Sony-Xperia-Z2-purple1.jpg', -1, '0000-00-00 00:00:00', '2014-10-02 14:06:31'),
(8, 14, 'Samsung Galaxy', '', 'images.jpg', -1, '0000-00-00 00:00:00', '2014-10-02 14:07:07'),
(9, 14, 'Samsung Galaxy', '', 'Lenobo-505s1.jpg', -1, '0000-00-00 00:00:00', '2014-10-02 15:23:57'),
(12, 15, 'SONY VAIO', 'SONY VAIO', 'booklet11.jpg', -1, '0000-00-00 00:00:00', '2014-10-02 15:50:25'),
(13, 14, 'nokia', 'nokia', 'Jellyfish.jpg', -1, '0000-00-00 00:00:00', '2014-10-02 16:46:16'),
(14, 14, 'nokia123', 'nokia', 'Desert.jpg', -1, '0000-00-00 00:00:00', '2014-10-02 16:47:03'),
(15, 14, 'nokia', 'nokia', '', -1, '0000-00-00 00:00:00', '2014-10-02 18:22:21'),
(16, 14, 'new', 'new', '', -1, '0000-00-00 00:00:00', '2014-10-02 18:40:14'),
(17, 14, 'nokia', 'nokia', '', -1, '0000-00-00 00:00:00', '2014-10-02 18:43:04'),
(18, 14, 'nokia', 'nokia', '', -1, '0000-00-00 00:00:00', '2014-10-03 10:03:53'),
(19, 14, 'nokia', 'nokia', '', -1, '0000-00-00 00:00:00', '2014-10-03 10:04:14'),
(20, 14, 'nokia', 'nokia', '', -1, '0000-00-00 00:00:00', '2014-10-03 10:11:53'),
(21, 14, 'nokia', 'nokia', '', -1, '0000-00-00 00:00:00', '2014-10-03 10:13:52'),
(22, 14, 'nokia', 'nokia', '', -1, '0000-00-00 00:00:00', '2014-10-03 10:14:14'),
(23, 14, 'nokia', 'nokia', '', -1, '0000-00-00 00:00:00', '2014-10-03 10:17:58'),
(24, 14, 'I Phone 6', 'dfdfs', '', -1, '0000-00-00 00:00:00', '2014-10-03 10:19:16'),
(25, 15, 'SONY VAIO', 'SONY VAIO', '', -1, '0000-00-00 00:00:00', '2014-10-07 15:33:46'),
(26, 14, 'nokia123', 'nokia', '', -1, '0000-00-00 00:00:00', '2014-10-07 15:34:59'),
(27, 14, 'nokia123', 'nokia', '', -1, '0000-00-00 00:00:00', '2014-10-07 15:35:15'),
(28, 14, 'Samsung123', 'Samsung Galaxy', '', -1, '0000-00-00 00:00:00', '2014-10-07 15:35:48'),
(29, 14, 'Moto G2', 'Moto G2', 'Tulips.jpg', -1, '0000-00-00 00:00:00', '2014-10-07 16:13:40'),
(30, 14, 'nbn', 'gjhj', 'images1.jpg', -1, '0000-00-00 00:00:00', '2014-10-16 16:59:30'),
(31, 14, 'xcvx', 'xvx', 'images2.jpg', -1, '0000-00-00 00:00:00', '2014-10-16 17:51:00'),
(33, 14, 'dfgg', 'hgfhf', 'sony_vaio_sve1511d1ew.jpg', -1, '0000-00-00 00:00:00', '2014-10-16 18:05:49'),
(34, 14, 'hjhgkj', 'kkh', 'iphone-6.jpg', -1, '0000-00-00 00:00:00', '2014-10-16 18:07:03'),
(35, 14, 'sdfs', 'dfgdf', 'iphone-61.jpg', -1, '0000-00-00 00:00:00', '2014-10-16 18:07:43');

-- --------------------------------------------------------

--
-- Table structure for table `image_gallery`
--

CREATE TABLE IF NOT EXISTS `image_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `image_path` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `language_code` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT 'Language Code',
  `language_name` varchar(100) COLLATE utf8_bin NOT NULL COMMENT 'Language Name',
  `direction` enum('ltr','rtl') COLLATE utf8_bin NOT NULL DEFAULT 'ltr' COMMENT 'Direction for view (left to right - ltr or right to left - rtl)',
  `default` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Is Default Language',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Status Active/Inactive',
  PRIMARY KEY (`id`),
  KEY `language_code` (`language_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Lanugage Table' AUTO_INCREMENT=11 ;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language_code`, `language_name`, `direction`, `default`, `status`) VALUES
(1, 'en', 'English', 'ltr', 1, 1),
(2, 'es', 'Spanish', 'ltr', 0, 1),
(10, 'ar', 'Arabic', 'rtl', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_navigation`
--

CREATE TABLE IF NOT EXISTS `menu_navigation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `title` varchar(50) COLLATE utf8_bin NOT NULL,
  `link` varchar(255) COLLATE utf8_bin NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=Inactive,1=Active, -1= Deleted',
  PRIMARY KEY (`id`),
  KEY `lang_id` (`lang_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=295 ;

--
-- Dumping data for table `menu_navigation`
--

INSERT INTO `menu_navigation` (`id`, `menu_name`, `title`, `link`, `parent_id`, `lang_id`, `status`) VALUES
(1, 'admin_menu', 'Home', 'admin/dashboard', 0, 1, 0),
(17, 'front_menu', 'Home', 'cms3', 0, 1, 1),
(28, 'admin_menu', 'Home-sp', '/', 0, 2, 1),
(29, 'admin_menu', 'Menu-sp', 'admin/menu', 0, 2, 1),
(33, 'admin_menu', 'Permissions-sp', 'admin/permissions', 0, 2, 1),
(41, 'admin_menu', 'URL Management', 'admin/urls', 0, 2, 1),
(42, 'admin_menu', 'Roles', 'admin/roles', 0, 2, 1),
(43, 'admin_menu', 'CMS Management', 'admin/cms', 0, 2, 1),
(44, 'front_menu', 'Home', 'es/cms3-es', 0, 2, 1),
(45, 'front_menu', 'About Us-sp', 'es/about-us-sp', 0, 2, 1),
(54, 'admin_menu', 'Home', 'admin/users', 0, 3, 1),
(55, 'admin_menu', 'Menu', 'admin/menu/index', 0, 3, 1),
(59, 'admin_menu', 'Permissions', 'admin/permissions', 0, 3, 1),
(67, 'admin_menu', 'URL Management', 'admin/urls', 0, 3, 1),
(70, 'front_menu', 'Home', '/', 0, 3, 1),
(93, 'admin_menu', 'Roles', 'admin/roles', 0, 3, 1),
(94, 'admin_menu', 'Settings', 'admin/settings', 0, 3, 1),
(95, 'admin_menu', 'Languages', 'admin/languages', 94, 3, 1),
(105, 'admin_menu', 'Translate', 'admin/translate', 94, 3, 1),
(106, 'admin_menu', 'Menu', 'admin/menu', 0, 1, 1),
(114, 'front_menu', 'Contact Us', 'contact_us/index', 0, 1, 1),
(123, 'admin_menu', 'Permissions', 'admin/permissions', 0, 1, 0),
(124, 'admin_menu', 'URL', 'admin/urls', 0, 1, 1),
(125, 'admin_menu', 'Roles', 'admin/roles', 0, 1, 0),
(126, 'admin_menu', 'CMS', 'admin/cms', 0, 1, 1),
(130, 'admin_menu', 'Permission Matrix', 'admin/roles/permission_matrix', 125, 1, 0),
(140, 'admin_menu', 'Permission Matrix', 'admin/roles/permission_matrix', 42, 2, 1),
(141, 'admin_menu', 'Settings', 'admin/settings', 0, 2, 1),
(142, 'admin_menu', 'Languages', 'admin/languages', 141, 2, 1),
(143, 'admin_menu', 'Translate', 'admin/translate', 141, 2, 1),
(144, 'front_menu', 'Contact Us sp', 'contact_us/index', 0, 2, 1),
(146, 'front_menu', 'Login-sp', 'users', 0, 2, 1),
(147, 'front_menu', 'About Us', 'about-us', 0, 3, 1),
(148, 'front_menu', 'Contact Us ar', 'contact_us/index', 0, 3, 1),
(150, 'front_menu', 'Login-ar', 'users', 0, 3, 1),
(151, 'admin_menu', 'Permission Matrix', 'admin/roles/permission_matrix', 93, 3, 1),
(160, 'admin_menu', 'Settings', 'admin/settings', 0, 1, 1),
(161, 'admin_menu', 'Language', 'admin/languages', 160, 1, 1),
(162, 'admin_menu', 'Translate', 'admin/translate', 160, 1, 1),
(164, 'admin_menu', ' منزل', 'admin/users', 0, 10, 1),
(168, 'admin_menu', 'Sample', 'admin/sample/index', 0, 1, 0),
(173, 'admin_menu', 'test', 'admin/sample/index', 0, 2, 1),
(183, 'front_menu', 'Demo Menu', 'cms3', 0, 1, 0),
(187, 'front_menu', 'Newsletter', 'newsletter', 0, 1, 0),
(188, 'admin_menu', 'NewsLetter', 'admin/newsletter/index', 0, 1, 1),
(189, 'admin_menu', 'Subscribers', 'admin/newsletter/all_subscribers', 188, 1, 1),
(190, 'admin_menu', 'Newsletters', 'admin/newsletter/all_newsletters', 188, 1, 1),
(191, 'admin_menu', 'Add subscribers', 'admin/newsletter/subscribers_actions/add/en', 188, 1, 0),
(192, 'admin_menu', 'Add newsletter', 'admin/newsletter/newsletters_actions/add/en', 188, 1, 0),
(194, 'admin_menu', 'Templates', 'admin/newsletter/all_templates', 188, 1, 1),
(195, 'admin_menu', 'Categories', 'admin/categories/index', 0, 1, 1),
(196, 'admin_menu', 'Blog', 'admin/blog/index', 0, 1, 1),
(197, 'front_menu', 'Blog', 'blog/index', 0, 1, 1),
(198, 'admin_menu', 'Blog Posts', 'admin/blog/index', 196, 1, 1),
(199, 'admin_menu', 'Comments', 'admin/blog/comment', 196, 1, 1),
(200, 'admin_menu', 'Forum', 'admin/forum', 0, 1, 1),
(201, 'front_menu', 'Forum', 'forum', 0, 1, 1),
(202, 'admin_menu', 'Gallery', 'admin/gallery', 0, 1, 1),
(203, 'admin_menu', 'Calendar', 'admin/calendar', 0, 1, 0),
(204, 'admin_menu', 'Banner', 'admin/banner', 0, 1, 1),
(205, 'admin_menu', 'Country Management', 'admin/country', 204, 1, 0),
(206, 'admin_menu', 'State Management', 'admin/states', 204, 1, 0),
(207, 'admin_menu', 'City Management', 'admin/city', 204, 1, 0),
(209, 'front_menu', 'Calendar', 'calendar/calendar_public', 0, 1, 1),
(210, 'front_menu', 'Gallery', 'gallery', 0, 1, 0),
(211, 'admin_menu', 'Banner Visitor', 'admin/banner/visitor_index', 204, 1, 0),
(212, 'front_menu', 'Blog-sp', 'blog/index', 0, 2, 1),
(213, 'front_menu', 'Banner', 'banner', 0, 1, 1),
(214, 'admin_menu', 'Calendar-sp', 'admin/calendar', 0, 2, 1),
(215, 'front_menu', 'Forum-sp', 'forum', 0, 2, 1),
(217, 'admin_menu', 'Quiz', 'admin/quiz/index', 0, 1, 0),
(218, 'front_menu', 'Quiz', 'quiz/index', 0, 1, 0),
(219, 'admin_menu', 'Product', 'admin/products', 0, 1, 1),
(220, 'admin_menu', 'Product Management', 'admin/products', 0, 2, 0),
(221, 'front_menu', 'Home Banner', 'banner/home_index', 213, 1, 1),
(222, 'front_menu', 'Banner-sp', 'banner/index', 0, 2, 1),
(223, 'front_menu', 'Home Banner-sp', 'banner/home_index', 0, 2, 1),
(224, 'admin_menu', 'ShoppingCart', 'admin/shoppingcart', 0, 1, 0),
(225, 'admin_menu', 'Manage Categories ', 'admin/shoppingcart/categories', 224, 1, 0),
(226, 'admin_menu', 'Manage Products', 'admin/shoppingcart/products', 224, 1, 0),
(227, 'front_menu', 'ShoppingCart', 'shoppingcart/index', 0, 1, 0),
(228, 'admin_menu', 'Banner Management', 'admin/banner', 204, 1, 0),
(230, 'admin_menu', 'Email Template', 'admin/email_template', 0, 1, 1),
(231, 'admin_menu', 'Banner-sp', 'admin/banner', 0, 2, 1),
(232, 'admin_menu', 'Banner Management-sp', 'admin/banner', 231, 2, 1),
(233, 'admin_menu', 'Banner visitor-sp', 'admin/banner/visitor_index', 231, 2, 1),
(234, 'admin_menu', 'Country Management', 'admin/country', 231, 2, 1),
(235, 'admin_menu', 'State Management', 'admin/state', 231, 2, 1),
(236, 'admin_menu', 'City Management', 'admin/city', 231, 2, 1),
(237, 'front_menu', 'Products', 'products', 0, 1, 1),
(238, 'front_menu', 'Products', 'products', 0, 2, 1),
(239, 'front_menu', 'Products', 'products', 0, 10, 1),
(242, 'admin_menu', 'Testimonial', 'admin/testimonial', 0, 1, 1),
(243, 'front_menu', 'Testimonial', 'testimonial', 0, 1, 1),
(244, 'front_menu', 'Testimonial', 'testimonial', 0, 2, 1),
(247, 'admin_menu', 'Orders', 'admin/shoppingcart/orders', 224, 1, 0),
(248, 'admin_menu', 'Coupons', 'admin/shoppingcart/coupons', 224, 1, 0),
(249, 'front_menu', 'Products List', 'shoppingcart/products', 227, 1, 0),
(250, 'front_menu', 'My Cart', 'shoppingcart/cart', 227, 1, 0),
(252, 'admin_menu', 'Payment Methods', 'admin/shoppingcart/payments', 224, 1, 0),
(253, 'front_menu', 'Order History', 'shoppingcart/orders', 227, 1, -1),
(271, 'front_menu', 'Edit Profile', 'users/profile', 0, 1, 1),
(291, 'front_menu', 'About Us', 'about-us', 0, 1, 1),
(292, 'admin_menu', 'Configuration', 'admin/settings', 160, 1, 1),
(293, 'admin_menu', 'test', 'admin/cms', 0, 1, 0),
(294, 'admin_menu', 'Test', 'admin/test', 0, 1, -1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_navigation_backup`
--

CREATE TABLE IF NOT EXISTS `menu_navigation_backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `title` varchar(50) COLLATE utf8_bin NOT NULL,
  `link` varchar(255) COLLATE utf8_bin NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=Inactive,1=Active, -1= Deleted',
  PRIMARY KEY (`id`),
  KEY `lang_id` (`lang_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=241 ;

--
-- Dumping data for table `menu_navigation_backup`
--

INSERT INTO `menu_navigation_backup` (`id`, `menu_name`, `title`, `link`, `parent_id`, `lang_id`, `status`) VALUES
(1, 'admin_menu', 'Home', 'admin/users', 0, 1, 1),
(17, 'front_menu', 'Home', 'cms3', 0, 1, 1),
(18, 'front_menu', 'Navigation 2', 'testslug3', 19, 1, 1),
(19, 'front_menu', 'Sub Link 1', '', 18, 1, 1),
(20, 'front_menu', 'Sub Link 2', 'testslug', 18, 1, 1),
(21, 'front_menu', 'Sub Link 3', '', 18, 1, 1),
(22, 'front_menu', 'Sub Sub Link 1', '', 21, 1, 1),
(23, 'front_menu', 'Sub Sub Link 2', '', 21, 1, 1),
(25, 'front_menu', 'About Us', 'about-us', 0, 1, 1),
(28, 'admin_menu', 'Home-sp', '/', 0, 2, 1),
(29, 'admin_menu', 'Menu-sp', 'admin/menu', 0, 2, 1),
(33, 'admin_menu', 'Permissions-sp', 'admin/permissions', 0, 2, 1),
(41, 'admin_menu', 'URL Management', 'admin/urls', 0, 2, 1),
(42, 'admin_menu', 'Roles', 'admin/roles', 0, 2, 1),
(43, 'admin_menu', 'CMS Management', 'admin/cms', 0, 2, 1),
(44, 'front_menu', 'Home', 'cms3', 0, 2, 1),
(45, 'front_menu', 'About Us-sp', 'about-us', 0, 2, 1),
(54, 'admin_menu', 'Home', 'admin/users', 0, 3, 1),
(55, 'admin_menu', 'Menu', 'admin/menu/index', 0, 3, 1),
(59, 'admin_menu', 'Permissions', 'admin/permissions', 0, 3, 1),
(67, 'admin_menu', 'URL Management', 'admin/urls', 0, 3, 1),
(70, 'front_menu', 'Home', '/', 0, 3, 1),
(93, 'admin_menu', 'Roles', 'admin/roles', 0, 3, 1),
(94, 'admin_menu', 'Settings', 'admin/settings', 0, 3, 1),
(95, 'admin_menu', 'Languages', 'admin/languages', 94, 3, 1),
(105, 'admin_menu', 'Translate', 'admin/translate', 94, 3, 1),
(106, 'admin_menu', 'Menu', 'admin/menu/index', 0, 1, 1),
(114, 'front_menu', 'Contact Us', 'contact_us/index', 0, 1, 1),
(123, 'admin_menu', 'Permissions', 'admin/permissions', 0, 1, 1),
(124, 'admin_menu', 'URL', 'admin/urls', 0, 1, 1),
(125, 'admin_menu', 'Roles', 'admin/roles', 0, 1, 0),
(126, 'admin_menu', 'CMS', 'admin/cms', 0, 1, 1),
(130, 'admin_menu', 'Permission Matrix', 'admin/roles/permission_matrix', 125, 1, 0),
(138, 'front_menu', 'Login', 'users', 0, 1, 1),
(140, 'admin_menu', 'Permission Matrix', 'admin/roles/permission_matrix', 42, 2, 1),
(141, 'admin_menu', 'Settings', 'admin/settings', 0, 2, 1),
(142, 'admin_menu', 'Languages', 'admin/languages', 141, 2, 1),
(143, 'admin_menu', 'Translate', 'admin/translate', 141, 2, 1),
(144, 'front_menu', 'Contact Us sp', 'contact_us/index', 0, 2, 1),
(146, 'front_menu', 'Login-sp', 'users', 0, 2, 1),
(147, 'front_menu', 'About Us', 'about-us', 0, 3, 1),
(148, 'front_menu', 'Contact Us ar', 'contact_us/index', 0, 3, 1),
(150, 'front_menu', 'Login-ar', 'users', 0, 3, 1),
(151, 'admin_menu', 'Permission Matrix', 'admin/roles/permission_matrix', 93, 3, 1),
(160, 'admin_menu', 'Settings', 'admin/settings', 0, 1, 1),
(161, 'admin_menu', 'Language', 'admin/languages', 160, 1, 1),
(162, 'admin_menu', 'Translate', 'admin/translate', 160, 1, 1),
(163, 'admin_menu', 'घर', 'admin/users', 0, 11, -1),
(164, 'admin_menu', ' منزل', 'admin/users', 0, 10, 1),
(165, 'front_menu', 'test', 'about-us', 0, 1, -1),
(166, 'admin_menu', 'Menu', '/admin/menu', 0, 1, -1),
(167, 'admin_menu', 'Menu', 'admin/menu', 0, 1, -1),
(168, 'admin_menu', 'Sample', 'admin/sample/index', 0, 1, 1),
(169, 'admin_menu', 'test title', 'about-us', 0, 1, -1),
(170, 'front_menu', 'test', 'admin/sample/index', 0, 10, 0),
(171, 'front_menu', 'test title2', 'admin/sample/index', 0, 10, 0),
(172, 'admin_menu', 'test', 'pricvay-policy', 168, 1, 1),
(173, 'admin_menu', 'test', 'admin/sample/index', 0, 2, 1),
(174, 'front_menu', 'Home1', 'cms3', 0, 1, -1),
(175, 'front_menu', 'Home1', 'cms3', 0, 1, -1),
(176, 'front_menu', '<Test Menu>', 'cms3', 0, 1, 0),
(177, 'new_menu', 'new_menu', 'about-us', 0, 1, -1),
(178, 'new_menu', 'new_menu', 'about-us', 0, 1, 1),
(179, 'admin_menu', '<testmenu>', 'about-us', 0, 1, -1),
(180, 'new_menu', '&lt;testmenu&gt;', 'about-us', 0, 1, 1),
(181, 'front_menu', '<Menu test123>', 'test-en', 0, 1, 1),
(182, 'front_menu', '&amp;lt;b&amp;gt;tetttt&amp;lt;/b&amp;gt;', 'about-us', 0, 1, 0),
(183, 'front_menu', 'Demo Menu', 'cms3', 0, 1, 0),
(184, 'admin_menu', 'test admin', 'test/index', 0, 1, -1),
(185, 'admin_menu', 'Demo Menus', 'cms3', 0, 1, -1),
(186, 'admin_menu', 'Testimonial Management', 'admin/testimonial', 0, 1, -1),
(187, 'front_menu', 'Newsletter', 'newsletter', 0, 1, 1),
(188, 'admin_menu', 'NewsLetter', 'admin/newsletter/index', 0, 1, 1),
(189, 'admin_menu', 'Subscribers', 'admin/newsletter/all_subscribers', 188, 1, 1),
(190, 'admin_menu', 'Newsletters', 'admin/newsletter/all_newsletters', 188, 1, 1),
(191, 'admin_menu', 'Add subscribers', 'admin/newsletter/subscribers_actions/add/en', 189, 1, 1),
(192, 'admin_menu', 'Add newsletter', 'admin/newsletter/newsletters_actions/add/en', 190, 1, 1),
(193, 'admin_menu', 'Newsletter category ', 'admin/newsletter/add_newsletter_category', 190, 1, -1),
(194, 'admin_menu', 'Newsletter templates', 'admin/newsletter/all_templates', 190, 1, 1),
(195, 'admin_menu', 'Categories', 'admin/categories/index', 0, 1, 1),
(196, 'admin_menu', 'Blog', 'admin/blog/index', 0, 1, 1),
(197, 'front_menu', 'Blog', 'blog/index', 0, 1, 1),
(198, 'admin_menu', 'Blog Posts', 'admin/blog/index', 196, 1, 1),
(199, 'admin_menu', 'Comments', 'admin/blog/comment', 196, 1, 1),
(200, 'admin_menu', 'Forum', 'admin/forum', 0, 1, 1),
(201, 'front_menu', 'Forum', 'forum', 0, 1, 1),
(202, 'admin_menu', 'Gallery', 'admin/gallery', 0, 1, 1),
(203, 'admin_menu', 'Calendar', 'admin/calendar', 0, 1, 1),
(204, 'admin_menu', 'Banner', 'admin/banner', 0, 1, 1),
(205, 'admin_menu', 'Country Management', 'admin/country', 204, 1, 1),
(206, 'admin_menu', 'State Management', 'admin/states', 204, 1, 1),
(207, 'admin_menu', 'City Management', 'admin/city', 204, 1, 1),
(208, 'front_menu', 'Calendar', 'calendar', 0, 1, -1),
(209, 'front_menu', 'Calendar', 'calendar/calendar_public', 0, 1, 1),
(210, 'front_menu', 'Gallery', 'gallery', 0, 1, 1),
(211, 'admin_menu', 'Banner Visitor', 'admin/banner/visitor_index', 204, 1, 1),
(212, 'front_menu', 'Blog-sp', 'blog/index', 0, 2, 1),
(213, 'front_menu', 'Banner', 'banner', 0, 1, 1),
(214, 'admin_menu', 'Calendar-sp', 'admin/calendar', 0, 2, 1),
(215, 'front_menu', 'Forum-sp', 'forum', 0, 2, 1),
(216, 'front_menu', 'Forum-ar', 'forum', 0, 10, 1),
(217, 'admin_menu', 'Quiz', 'admin/quiz/index', 0, 1, 1),
(218, 'front_menu', 'Quiz', 'quiz/index', 0, 1, 1),
(219, 'admin_menu', 'Product', 'admin/products', 0, 1, 1),
(220, 'admin_menu', 'Product Management', 'admin/products', 0, 2, 0),
(221, 'front_menu', 'Home Banner', 'banner/home_index', 213, 1, 1),
(222, 'front_menu', 'Banner-sp', 'banner/index', 0, 2, 0),
(223, 'front_menu', 'Home Banner-sp', 'banner/home_index', 0, 2, 1),
(224, 'admin_menu', 'ShoppingCart', 'admin/shoppingcart', 0, 1, 1),
(225, 'admin_menu', 'Coupons', 'admin/shoppingcart/coupons', 224, 1, 1),
(226, 'admin_menu', 'Orders', 'admin/shoppingcart/orders', 224, 1, 1),
(227, 'front_menu', 'ShoppingCart', 'shoppingcart/products', 0, 1, 1),
(228, 'admin_menu', 'Banner Management', 'admin/banner', 204, 1, 1),
(229, 'admin_menu', 'Privileges', 'admin/privileges', 0, 1, 1),
(230, 'admin_menu', 'Email Template', 'admin/email_template', 0, 1, 1),
(231, 'admin_menu', 'Banner-sp', 'admin/banner', 0, 2, 1),
(232, 'admin_menu', 'Banner Management-sp', 'admin/banner', 231, 2, 1),
(233, 'admin_menu', 'Banner visitor-sp', 'admin/banner/visitor_index', 231, 2, 1),
(234, 'admin_menu', 'Country Management', 'admin/country', 231, 2, 1),
(235, 'admin_menu', 'State Management', 'admin/state', 231, 2, 1),
(236, 'admin_menu', 'City Management', 'admin/city', 231, 2, 1),
(237, 'front_menu', 'Products', 'products', 0, 1, 1),
(238, 'front_menu', 'Products', 'products', 0, 2, 1),
(239, 'front_menu', 'Products', 'products', 0, 10, 1),
(240, 'admin_menu', 'testttt', 'its-my-page', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE IF NOT EXISTS `newsletters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `newsletter_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `subject` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `schedule_time` date NOT NULL,
  `sent` enum('yes','no') NOT NULL DEFAULT 'no',
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `updated_date` datetime NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `newsletters`
--

INSERT INTO `newsletters` (`id`, `newsletter_id`, `lang_id`, `subject`, `category_id`, `content_id`, `template_id`, `schedule_time`, `sent`, `status`, `updated_date`, `created_date`) VALUES
(1, 1, 1, 'Testing send message functionality', 24, 0, 6, '2014-08-07', 'no', 'deleted', '0000-00-00 00:00:00', '2014-10-08 11:06:55'),
(2, 2, 1, 'test', 24, 0, 6, '0000-00-00', 'no', 'deleted', '0000-00-00 00:00:00', '2014-10-08 11:56:11'),
(3, 3, 1, 'test', 24, 0, 6, '0000-00-00', 'no', 'deleted', '0000-00-00 00:00:00', '2014-10-08 12:12:00'),
(5, 5, 1, 'new', 24, 0, 6, '0000-00-00', 'no', 'deleted', '0000-00-00 00:00:00', '2014-10-08 12:49:47'),
(6, 6, 1, 'new', 24, 0, 6, '2014-10-09', 'yes', 'inactive', '2014-10-09 09:09:30', '2014-10-08 13:20:44'),
(7, 7, 1, 'test', 24, 0, 6, '0000-00-00', 'no', 'deleted', '0000-00-00 00:00:00', '2014-10-08 13:21:08'),
(9, 9, 1, 'Congratulation!!!!!!!!!!!!!!!', 26, 0, 6, '2014-10-14', 'yes', 'active', '2014-10-16 11:00:54', '2014-10-09 06:38:44'),
(10, 10, 10, 'NetworkKing Updates -ar', 25, 0, 8, '2014-10-11', 'no', 'inactive', '2014-10-09 07:37:04', '2014-10-09 07:36:09'),
(11, 11, 2, 'Happy BirthDay', 24, 0, 7, '2014-10-24', 'no', 'inactive', '0000-00-00 00:00:00', '2014-10-09 07:53:08'),
(12, 12, 1, 'Tender Invitation', 24, 0, 6, '2014-10-25', 'no', 'inactive', '0000-00-00 00:00:00', '2014-10-13 05:30:29'),
(13, 13, 1, 'NetworkKing Updates -EN', 24, 0, 6, '2014-10-30', 'no', 'inactive', '0000-00-00 00:00:00', '2014-10-13 05:31:15'),
(14, 14, 1, 'New Offer Waiting For You', 24, 0, 6, '2014-10-30', 'no', 'inactive', '0000-00-00 00:00:00', '2014-10-13 05:31:42'),
(15, 15, 2, 'NetworkKing Updates -SP', 24, 0, 7, '2014-10-30', 'no', 'inactive', '0000-00-00 00:00:00', '2014-10-13 05:32:49'),
(16, 16, 2, 'Tender Invitation - sP', 24, 0, 7, '2014-10-31', 'no', 'inactive', '0000-00-00 00:00:00', '2014-10-13 05:33:11'),
(17, 17, 2, 'New Offer Waiting For You -SP', 24, 0, 7, '2014-10-13', 'yes', 'inactive', '0000-00-00 00:00:00', '2014-10-13 05:33:43'),
(18, 18, 2, 'Tender Invitation - 2', 24, 0, 7, '2014-10-31', 'no', 'inactive', '0000-00-00 00:00:00', '2014-10-13 05:34:16'),
(19, 19, 2, 'New Offer Waiting For You 2', 24, 0, 7, '2014-10-24', 'no', 'inactive', '0000-00-00 00:00:00', '2014-10-13 05:34:44'),
(20, 20, 1, 'Happy Diwali', 24, 0, 6, '2014-10-17', 'no', 'active', '0000-00-00 00:00:00', '2014-10-15 12:15:23'),
(21, 21, 1, 'kjhkjlkj', 24, 0, 6, '2014-10-14', 'no', 'active', '0000-00-00 00:00:00', '2014-10-16 12:45:29'),
(22, 22, 1, 'hdfh', 24, 0, 6, '2014-10-09', 'no', 'active', '0000-00-00 00:00:00', '2014-10-16 12:45:49'),
(23, 23, 1, 'dffghgh', 24, 0, 6, '2014-10-29', 'no', 'active', '0000-00-00 00:00:00', '2014-10-16 12:50:22'),
(24, 24, 1, 'test', 24, 0, 6, '2014-10-22', 'no', 'active', '0000-00-00 00:00:00', '2014-10-17 06:50:40'),
(25, 25, 1, 'fghgfh', 24, 0, 6, '2014-10-18', 'no', 'active', '0000-00-00 00:00:00', '2014-10-17 06:51:29'),
(26, 26, 1, 'fghjg', 24, 0, 6, '2014-10-17', 'no', 'active', '0000-00-00 00:00:00', '2014-10-17 06:51:54'),
(27, 27, 1, 'jhgj', 24, 0, 6, '2014-10-01', 'no', 'active', '0000-00-00 00:00:00', '2014-10-17 06:52:08'),
(28, 28, 1, 'jljkkljk', 24, 0, 6, '2014-10-22', 'no', 'active', '0000-00-00 00:00:00', '2014-10-17 06:52:39'),
(29, 29, 1, 'dgfdg', 24, 0, 6, '2014-10-01', 'no', 'active', '0000-00-00 00:00:00', '2014-10-17 06:54:04'),
(30, 30, 1, 'dfsd', 24, 0, 6, '2014-10-22', 'no', 'active', '0000-00-00 00:00:00', '2014-10-17 08:16:33'),
(31, 31, 2, 'test', 24, 0, 7, '2014-10-02', 'no', 'active', '0000-00-00 00:00:00', '2014-10-17 08:35:14');

-- --------------------------------------------------------

--
-- Table structure for table `newsletters_content`
--

CREATE TABLE IF NOT EXISTS `newsletters_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `newsletter_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `title` varchar(500) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `newsletters_content`
--

INSERT INTO `newsletters_content` (`id`, `newsletter_id`, `lang_id`, `title`, `text`) VALUES
(1, 1, 1, 'SONY VAIO', '<p>wqeqwewqe</p>'),
(2, 2, 1, 'new', '<p>hiiiiiiiii</p>'),
(3, 3, 1, 'test', '<p>test</p>'),
(4, 4, 1, 'Happy Diwali', '<p>Happy Diwali</p>'),
(5, 5, 1, 'new', '<p>new</p>'),
(6, 6, 1, 'new', 'new13'),
(7, 7, 1, 'test', '<p>test</p>'),
(8, 8, 1, 'Happy New Year', 'Be careful from other duplicate wisher I m the only ISO certified well wisher.<br>Aa diwali na prakash thi tara dimag ma prakash thai ane tu manso jevo vyavhar kre<br><br>Happy Diwali in Advance<br>'),
(9, 9, 1, 'Congratulation!!!!!!!!!!!!!!!', 'U Have won I Phone 6<br><br><br><br>'),
(10, 10, 10, 'NetworkKing Updates -ar', 'NetworkKing Updates -ar<br><br>'),
(11, 11, 2, 'Happy BirthDay', 'Happy BirthDay<br><br>'),
(12, 12, 1, 'Tender Invitation', 'Tender Invitation<br><br>'),
(13, 13, 1, 'NetworkKing Updates -EN', 'NetworkKing Updates -EN<br><br>'),
(14, 14, 1, 'New Offer Waiting For You', 'New Offer Waiting For You<br><br>'),
(15, 15, 2, 'NetworkKing Updates -SP', 'NetworkKing Updates -SP<br><br>'),
(16, 16, 2, 'Tender Invitation - sP', 'Tender Invitation - sP<br><br>'),
(17, 17, 2, 'New Offer Waiting For You -SP', 'New Offer Waiting For You -SP<br><br>'),
(18, 18, 2, 'Tender Invitation - 2', 'Tender Invitation - 2<br><br>'),
(19, 19, 2, 'New Offer Waiting For You 2', 'New Offer Waiting For You 2<br><br>'),
(20, 20, 1, 'Happy Diwali', 'Happy Diwali<br><br>'),
(21, 21, 1, 'lkj', 'kl;''<br>'),
(22, 22, 1, 'jhgf', 'dhdf<br>'),
(23, 23, 1, 'hgghj', 'fgh'),
(24, 24, 1, 'test', 'test<br><br>'),
(25, 25, 1, 'fghf', 'gfjh<br>'),
(26, 26, 1, 'fhjgj', 'gjhgj<br>'),
(27, 27, 1, 'jhg', 'hjg<br>'),
(28, 28, 1, 'gfhgf', 'gjuh<br>'),
(29, 29, 1, 'dfg', 'fdgdf<br>'),
(30, 30, 1, 'sdfs', 'fds<br>'),
(31, 31, 2, 'tsfvnckvhh', '''''vcvbgcvbcbcv c<br>');

-- --------------------------------------------------------

--
-- Table structure for table `newsletters_subscribers`
--

CREATE TABLE IF NOT EXISTS `newsletters_subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `slug_url` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `updated_date` datetime NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `newsletters_subscribers`
--

INSERT INTO `newsletters_subscribers` (`id`, `firstname`, `lastname`, `slug_url`, `email`, `status`, `updated_date`, `created_date`) VALUES
(2, 'Dhara', 'Gorsiya', '', 'dhara.gorsiya@sparsh.com', 'active', '0000-00-00 00:00:00', '2014-10-09 14:21:43'),
(8, 'Harsh', 'Gandhi', '', 'harsh.gandhi@sparsh.com', 'inactive', '2014-10-15 16:05:43', '2014-10-13 09:46:59');

-- --------------------------------------------------------

--
-- Table structure for table `newsletters_templates`
--

CREATE TABLE IF NOT EXISTS `newsletters_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_id` int(11) NOT NULL,
  `template_title` varchar(255) NOT NULL,
  `template_view_file` varchar(255) NOT NULL,
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `updated_date` datetime NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `newsletters_templates`
--

INSERT INTO `newsletters_templates` (`id`, `template_id`, `template_title`, `template_view_file`, `lang_id`, `updated_date`, `created_date`) VALUES
(6, 6, 'Template 1 -English', 'admin_view_template1', 1, '2014-08-07 05:10:59', '2013-09-12 15:29:13'),
(7, 7, 'Template 2 - Spanish', 'admin_view_template2', 2, '2013-09-12 16:29:55', '2013-09-12 15:29:29'),
(8, 8, 'Template 3 - Arabic', 'admin_view_template3', 10, '0000-00-00 00:00:00', '2013-09-12 16:56:00'),
(9, 9, 'zxczxczxc', 'zxczxczxc', 2, '0000-00-00 00:00:00', '2014-10-17 08:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_label` varchar(255) COLLATE utf8_bin NOT NULL,
  `permission_title` varchar(255) COLLATE utf8_bin NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '"-1= Deleted, 0=Inactive,1=Active"',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=324 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission_label`, `permission_title`, `parent_id`, `status`) VALUES
(1, 'Admin.Users.Login', 'Login', 0, 1),
(2, 'Admin.Users.Index', 'User Listing', 0, 1),
(3, 'Admin.Users.Action.Add', 'User Add', 2, 1),
(4, 'Admin.Users.Action.Edit', 'User Edit', 2, 1),
(5, 'Admin.Permissions.Index', 'Permission Listing', 0, 1),
(6, 'Admin.Permissions.Action.Add', 'Permission Add', 5, 1),
(7, 'Admin.Users.Delete', 'User Delete', 2, 1),
(9, 'Admin.Permissions.Action.Edit', 'Permission Edit', 5, 1),
(10, 'Admin.Permissions.Delete', 'Permission Delete', 5, 1),
(11, 'Admin.Roles.Index', 'Role Listing', 0, 1),
(12, 'Admin.Roles.Action.Add', 'Role Add', 11, 1),
(13, 'Admin.Roles.Action.Edit', 'Role Edit', 11, 1),
(14, 'Admin.Roles.Action.Delete', 'Role Delete', 11, 1),
(15, 'Admin.Roles.Permission_matrix', 'Role Permission Matrix', 11, 1),
(17, 'Admin.Urls.Index', 'URL Listing', 0, 1),
(18, 'Admin.Urls.Action.Add', 'URL Add', 17, 1),
(19, 'Admin.Urls.Action.Edit', 'URL Edit', 17, 1),
(20, 'Admin.Urls.Delete', 'URL Delete', 17, 1),
(21, 'Front.Contact_us.Index', 'Contact Us', 0, 1),
(22, 'Admin.Cms.Index', 'CMS Listing', 0, 1),
(23, 'Admin.Cms.Ajax_Index', 'CMS Listing - Ajax', 22, 1),
(24, 'Admin.Cms.Action', 'Cms add/edit page', 22, 1),
(25, 'Admin.Cms.Ajax_Action', 'Cms add/edit ajax page', 22, 1),
(26, 'Admin.Menu.Index', 'Menu', 0, 1),
(27, 'Admin.Menu.Action.Add', 'Menu Add', 26, 1),
(28, 'Admin.Menu.Action.Edit', 'Menu Edit', 26, 1),
(29, 'Admin.Menu.Delete', 'Menu Delete', 26, 1),
(30, 'Admin.Languages.Index', 'Languages', 0, 1),
(31, 'Admin.Languages.Action.Add', 'Languages Add', 30, 1),
(32, 'Admin.Languages.Action.Edit', 'Languages Edit', 30, 1),
(33, 'Admin.Settings.Index', 'Settings', 0, 1),
(34, 'Admin.Settings.Action.Add', 'Settings Add', 33, 1),
(35, 'Admin.Settings.Action.Edit', 'Settings Edit', 33, 1),
(36, 'Admin.Settings.Delete', 'Settings Delete', 33, 1),
(37, 'Admin.Users.Save', 'User Save', 2, 1),
(41, 'Admin.Cms.Delete', 'CMS delete', 22, 1),
(42, 'Front.Users.Change_password', 'Users Change Password', 0, 1),
(43, 'Admin.Permissions.save', 'Permission save', 5, 1),
(44, 'Admin.Urls.Save', 'Url save', 17, 1),
(45, 'Admin.Roles.update_matrix_permission', 'Update Permission matrix', 11, 1),
(46, 'Admin.Menu.Save', 'Menu Save', 26, 1),
(47, 'Admin.Languages.Save', 'Language Save', 30, 1),
(48, 'Admin.Languages.Delete', 'Language Delete', 30, 1),
(49, 'Admin.Categories.index', 'Categories Listing', 0, 1),
(54, 'Admin.Users.View_Data', 'View user profile', 17, 1),
(55, 'Admin.Categories.ajax_index', 'Categories ajax listing', 49, 1),
(56, 'Admin.Categories.ajax_action', 'Categories ajax action', 49, 1),
(57, 'Admin.Categories.action', 'Categories Action', 49, 1),
(58, 'Admin.Categories.delete', 'Categories Delete', 49, 1),
(63, 'Admin.Newsletter.Index', 'Newsletter Index', 0, 1),
(64, 'Admin.Newsletter.All_subscribers', 'Newsletter -> All subcribers', 63, 1),
(65, 'Admin.Newsletter.Add_subscribers', 'Newsletter -> Add subcribers', 63, 1),
(66, 'Admin.Newsletter.All_newsletters', 'Newsletter -> All newsletters', 63, 1),
(67, 'Admin.Newsletter.Ajax_index', 'Newsletter -> Ajax index', 63, 1),
(68, 'Admin.Newsletter.Add_newsletters', 'Newsletter -> Add newsletters', 63, 1),
(69, 'Admin.Newsletter.Add_newsletter_category', 'Newsletter -> Add newsletter category', 63, 1),
(70, 'Admin.Newsletter.All_templates', 'Newsletter -> All templates', 63, 1),
(71, 'Admin.Newsletter.Add_templates', 'Newsletter -> Add templates', 63, 1),
(72, 'Admin.Newsletter.Delete_newsletter', 'Newsletter -> Delete newsletter', 63, 1),
(73, 'Admin.Newsletter.Edit_newsletter', 'Newsletter -> Edit newsletter', 63, 1),
(74, 'Admin.Newsletter.Delete_category', 'Newsletter -> Delete category', 63, 1),
(75, 'Admin.Newsletter.Send_all_newsletter', 'Newsletter -> Send all newsletter', 63, 1),
(76, 'Admin.Newsletter.Edit_templates', 'Newsletter -> Edit templates', 63, 1),
(77, 'Admin.Newsletter.Delete_template', 'Newsletter -> Delete template', 63, 1),
(78, 'Admin.Newsletter.Edit_subscribers', 'Newsletter ->Edit subscribers', 63, 1),
(79, 'Admin.Gallery.Index', 'Image gallery view', 0, 1),
(80, 'Admin.Gallery.add_image', 'Image gallery add', 79, 1),
(81, 'Admin.Gallery.edit_image', 'Image gallery edit', 79, 1),
(82, 'Admin.Gallery.delete', 'Image gallery delete', 79, 1),
(83, 'Admin.Gallery.save', 'Image gallery save', 79, 1),
(84, 'Admin.Newsletter.view_newsletter', 'Newsletter -> View newsletter', 63, 1),
(85, 'Admin.Newsletter.All_dashboard_subscribers', 'Newsletter -> All dashboard subscribers', 63, 1),
(86, 'Admin.Newsletter.All_dashboard_newsletter', 'Newsletter -> All dashboard newsletter', 63, 1),
(87, 'Admin.Calendar.Index', 'Calendar', 0, 1),
(88, 'Admin.Calendar.Action', 'Calendar Action', 87, 1),
(89, 'Admin.City.Index', 'City listing', 0, 1),
(90, 'Admin.Blog.Index', 'Blog', 0, 1),
(91, 'Admin.Country.Index', 'Country Listing', 0, 1),
(92, 'Admin.Blog.Action', 'Add New Blog', 90, 1),
(93, 'Admin.Blog.Save', 'Blog Save', 90, 1),
(94, 'Admin.Calendar.Ajax_Calendar', 'Calendar view', 87, 1),
(95, 'Admin.Blog.Delete', 'Delete Blog', 90, 1),
(96, 'Admin.Forum.Index', 'Forum', 0, 1),
(97, 'Admin.States.Index', 'States listing', 0, 1),
(98, 'Admin.Forum.Forum_listing', 'Forum Listing', 96, 1),
(99, 'Admin.Forum.Action', 'Add Forum', 96, 1),
(100, 'Admin.Forum.Add_category.Add', 'Add_category', 96, 1),
(101, 'Admin.City.Action.Add', 'City Add', 89, 1),
(102, 'Admin.Calendar.Event_List', 'Listing Events', 87, 1),
(103, 'Admin.Forum.Add_category.Edit', 'Edit Category', 96, 1),
(104, 'Admin.Calendar.Delete', 'Delete Events', 87, 1),
(105, 'Admin.Forum.Action.Edit', 'Edit Forum', 96, 1),
(106, 'Admin.Calendar.Do_Add_Time', 'add event time in session', 87, 1),
(107, 'Admin.Forum.Forum_post', 'Forum Posts', 96, 1),
(108, 'Admin.City.Ajax_Index', 'City listing-ajax', 89, 1),
(109, 'Admin.City.Ajax_Action', 'City Add/Edit ajax page', 89, 1),
(111, 'Admin.Banner.Country.Index', 'Country', 110, 1),
(112, 'Admin.States.Ajax_Index', 'States Listing-Ajax', 97, 1),
(113, 'Admin.States.Ajax_Action', 'states add/edit-ajax', 97, 1),
(114, 'Admin.Country.Ajax_Index', 'Country Listing-ajax', 91, 1),
(115, 'Admin.Country.Ajax_Action', 'Add/edit Country-ajax', 91, 1),
(116, 'Admin.Country.Action.Add', 'Add country', 91, 1),
(117, 'Admin.Country.Action.edit', 'Edit Country', 91, 1),
(118, 'Admin.Country.Delete', 'Delete country', 91, 1),
(119, 'Admin.City.Action.Edit', 'City Edit', 89, 1),
(120, 'Admin.States.Action.Add', 'Add States', 97, 1),
(121, 'Admin.States.Action.Edit', 'Edit States', 97, 1),
(122, 'Admin.States.Delete', 'Delete States', 97, 1),
(123, 'Admin.Calendar.Action.Edit', 'Edit Calendar', 87, 1),
(124, 'Admin.City.Delete', 'City Delete', 89, 1),
(125, 'Admin.Calendar.Open_Form', 'open form', 87, 1),
(127, 'Front.Forum.Index', 'Forum Front', 96, 1),
(128, 'Admin.Calendar.Action.Add', 'Add Event', 87, 1),
(129, 'Admin.City.Get_Related_State', 'Get country related state', 89, 1),
(130, 'Admin.Banner.Index', 'Banner', 0, 1),
(132, 'Admin.Calendar.Open_Dialog', 'Open form in dialog', 87, 1),
(133, 'Admin.Banner.Ajax_Index', 'Banner ajax listing', 130, 1),
(134, 'Admin.Roles.Update_user_permission', 'Update User Permission', 11, 1),
(135, 'Admin.Banner.Visitor_index', 'Visitor listing', 130, 1),
(136, 'Admin.Banner.Visitor_ajax_index', 'Visitor listing-ajax', 130, 1),
(137, 'Admin.Calendar.Open_List', 'Open List events', 87, 1),
(138, 'Admin.Newsletter.Subscribers_actions', 'Newsletter -> Subscribers actions', 63, 1),
(139, 'Admin.Newsletter.Newsletters_actions', 'Newsletter -> Newsletters Actions', 63, 1),
(140, 'Admin.Newsletter.Templates_actions', 'Newsletter -> Templates actions', 63, 1),
(141, 'Admin.Newsletter.Ajax_all_templates', 'Newsletter -> Ajax all templates', 63, 1),
(142, 'Front.Calendar.Index', 'Front_Calendar', 0, 1),
(143, 'Front.Calendar.Ajax_Calendar', 'Front_Calendar_view', 142, 1),
(144, 'Front.Calendar.Action.Add', 'Front Event Add', 142, 1),
(145, 'Front.Calendar.Public_Event_List', 'Front Listing Events', 142, 1),
(146, 'Front.Calendar.Event_List', 'Front Event List', 142, 1),
(147, 'Admin.Banner.Delete', 'Banner delete', 130, 1),
(148, 'Admin.Banner.Action.Add', 'Banner Add', 130, 1),
(149, 'Admin.Banner.Ajax_Action', 'Banner Ajax Add/Edit', 130, 1),
(150, 'Admin.Banner.Get_Related_State', 'States', 130, 1),
(151, 'Admin.Banner.Get_Related_City', 'Cities', 130, 1),
(155, 'Front.Calendar.Action.Edit', 'Front Edit Event', 142, 1),
(156, 'Front.Calendar.Open_Dialog', 'Open form in dialog in front', 142, 1),
(157, 'Front.Calendar.Delete', 'Delete Event From Front', 142, 1),
(158, 'Front.Calendar.Upcoming_Events', 'listing of upcoming events', 142, 1),
(159, 'Admin.Calendar.Upcoming_Events', 'Upcoming Events', 87, 1),
(160, 'Front.Calendar.Share_Event', 'front event sharing', 142, 1),
(161, 'Admin.Calendar.Share_Event', 'Sharing Event', 87, 1),
(162, 'front.banner.index', 'bannre front page', 0, 1),
(163, 'front.banner.ajax_index', 'banner listing', 162, 1),
(164, 'Front.Calendar.Open_List', 'Open List', 142, 1),
(165, 'Admin.Quiz.Index', 'Quiz Management', 0, 1),
(166, 'Admin.Quiz.Admin_ajax_index', 'Quiz Management -> Admin ajax index', 165, 1),
(167, 'Admin.Quiz.Categories', 'Quiz Management -> Categories', 165, 1),
(168, 'Admin.Quiz.Category_action', 'Quiz Management -> Category action', 165, 1),
(169, 'Admin.Quiz.Ajax_categories_list', 'Quiz Management -> Ajax categories list', 165, 1),
(170, 'Admin.Quiz.Delete_category', 'Quiz Management -> Delete category', 165, 1),
(171, 'Admin.Quiz.Subjects', 'Quiz Management -> Subjects', 165, 1),
(172, 'Admin.Quiz.Subject_action', 'Quiz Management -> Subject action', 165, 1),
(173, 'Admin.Quiz.Ajax_subjects_list', 'Quiz Management -> Ajax subjects list', 165, 1),
(174, 'Admin.Quiz.Delete_subject', 'Quiz Management -> Delete subject', 165, 1),
(175, 'Admin.Quiz.Chapters', 'Quiz Management -> Chapters', 165, 1),
(176, 'Admin.Quiz.Chapter_action', 'Quiz Management -> Chapter action', 165, 1),
(177, 'Admin.Quiz.Ajax_chapters_list', 'Quiz Management -> Ajax chapters list', 165, 1),
(178, 'Admin.Quiz.Delete_chapter', 'Quiz Management -> Delete chapter', 165, 1),
(179, 'Admin.Quiz.Select_chapters_from_subjects', 'Quiz Management -> Select chapters from subjects', 165, 1),
(180, 'Admin.Quiz.Questions', 'Quiz Management -> Questions', 165, 1),
(181, 'Admin.Quiz.Ajax_questions_list', 'Quiz Management -> Ajax questions list', 165, 1),
(182, 'Admin.Quiz.Question_action', 'Quiz Management -> Question action', 165, 1),
(183, 'Admin.Quiz.Delete_question', 'Quiz Management -> Delete question', 165, 1),
(184, 'Admin.Quiz.Quizzes', 'Quiz Management -> Quizzes', 165, 1),
(185, 'Admin.Quiz.Quizzes_action', 'Quiz Management -> Quizzes action', 165, 1),
(186, 'Admin.Quiz.Ajax_quizzes_list', 'Quiz Management -> Ajax quizzes list', 165, 1),
(187, 'Admin.Quiz.Delete_quizzes', 'Quiz Management -> Delete quizzes', 165, 1),
(188, 'Admin.Quiz.Select_questions_from_categories', 'Quiz Management -> Select questions from categories', 165, 1),
(189, 'Admin.Quiz.Select_quizzes_questions_from_categories', 'Quiz Management -> Select quizzes questions from categories', 165, 1),
(190, 'Front.Forum.Forum_Listing', 'Forum_listing Front.', 96, 1),
(191, 'Front.Forum.Forum_post', 'Forum_post Front', 96, 1),
(192, 'Front.Forum.Action', 'Add Forum Front', 96, 1),
(193, 'Front.Quiz.Quiz_actions', 'Quiz Management -> Front quiz actions', 165, 1),
(194, 'Admin.Shoppingcart.coupons', 'ShoppingCart Coupons', 196, 1),
(195, 'Admin.Shoppingcart.orders', 'ShoppingCart Orders', 196, 1),
(196, 'Admin.Shoppingcart.index', 'ShoppingCart Products', 0, 1),
(197, 'Admin.Shoppingcart.add', 'Shoppingcart Productadd', 220, 1),
(198, 'Admin.Shoppingcart.edit', 'Shoppingcart ProductEdit', 220, 1),
(199, 'Admin.Shoppingcart.delete_product', 'ShoppingCart ProductDelete', 196, 1),
(200, 'Front.Calendar.Calendar_Public', 'Public Calendar', 142, 1),
(201, 'Front.Calendar.Upcoming_Events_public', 'Public Upcoming Events', 142, 1),
(202, 'Front.Calendar.Event_Detail', 'Show event detail front', 142, 1),
(203, 'Admin.Calendar.Event_Detail', 'Show event detail', 87, 1),
(204, 'Admin.Quiz.Ajax_subject_action', 'Quiz Management -> Ajax subject action', 165, 1),
(205, 'Admin.Quiz.Ajax_chapter_action', 'Quiz Management -> Ajax chapter action', 165, 1),
(206, 'Admin.Quiz.Ajax_question_action', 'Quiz Management -> Ajax question action', 165, 1),
(207, 'Admin.Quiz.Ajax_quizzes_action', 'Quiz Management -> Ajax quizzes action', 165, 1),
(208, 'Admin.Newsletter.Ajax_newsletters_actions', 'Newsletter -> Ajax newsletters actions', 63, 1),
(209, 'Front.Banner.add_visitor', 'Add visitor', 162, 1),
(210, 'Admin.Shoppingcart.ajax_coupons', 'ShoppingCart CouponAjax', 194, 1),
(211, 'Admin.Shoppingcart.action_coupon', 'ShoppingCart Coupons Action', 194, 1),
(212, 'Admin.Shoppingcart.ajax_action_coupon', 'ShoppingCart Coupon Ajax Action', 211, 1),
(213, 'Admin.Shoppingcart.delete_coupon', 'ShoppingCart Coupon delete', 194, 1),
(214, 'Admin.Shoppingcart.action_coupon.add', 'ShoppingCart Coupon Action Add', 211, 1),
(215, 'Admin.Shoppingcart.ajax_coupon.edit', 'ShoppingCart Coupon Action Edit', 211, 1),
(216, 'Admin.Shoppingcart.ajax_orders', 'ShoppingCart Orders Ajax', 195, 1),
(217, 'Admin.Shoppingcart.action_order', 'ShoppingCart Orders Action', 195, 1),
(218, 'Admin.Shoppingcart.action_order.edit', 'ShoppingCart Order Action Edit', 216, 1),
(219, 'Admin.Shoppingcart.ajax_index', 'ShoppingCart Product Ajax', 196, 1),
(220, 'Admin.Shoppingcart.ajax_action', 'ShoppingCart Product Ajax Action', 219, 1),
(221, 'Admin.City.View_Data', 'View city details', 89, 1),
(222, 'Admin.City.Ajax_View', 'Ajax view of city', 89, 1),
(223, 'Admin.Country.View', 'View Country', 91, 1),
(224, 'Admin.Country.Ajax_view', 'View country-ajax', 91, 1),
(225, 'Admin.States.Ajax_view', 'State view-ajax', 97, 1),
(226, 'Admin.States.View', 'State view', 97, 1),
(227, 'Admin.Banner.View_Data', 'Banner view', 130, 1),
(228, 'Admin.Banner.Ajax_View', 'Banner ajax view', 130, 1),
(229, 'Admin.Testimonial.Index', 'Testimonial', 0, 1),
(230, 'Admin.Forum.Ajax_index', 'Ajax Index', 96, 1),
(231, 'Admin.Forum.Ajax_Forum_listing', 'Ajax Forum Listing', 96, 1),
(232, 'Admin.Newsletter.Ajax_templates_actions', 'Newsletter -> Ajax templates actions', 63, 1),
(233, 'Admin.Calendar.Validate', 'Validate fields', 87, 1),
(234, 'admin.products.index', 'Product Listing', 0, 1),
(235, 'admin.products.ajax_index', 'Product Listing - Ajax', 234, 1),
(236, 'admin.products.action', 'Product Add / Edit Page', 234, 1),
(237, 'admin.products.ajax_action', 'Product Add / Edit Ajax Page', 234, 1),
(238, 'admin.products.delete_product', 'Product Delete', 234, 1),
(239, 'admin.products.image_index', 'Product Image Listing', 234, 1),
(240, 'admin.products.ajax_image_index', 'Product Image Listing - Ajax', 234, 1),
(241, 'admin.products.image_action', 'Product Image  Add / Edit Page', 234, 1),
(242, 'admin.products.delete_product_image', 'Product Image Delete', 234, 1),
(243, 'admin.products.view', 'Product view', 234, 1),
(244, 'admin.products.ajax_view', 'Product view - Ajax', 234, 1),
(245, 'admin.sample.jqgrid', 'Sample grid listing', 0, 1),
(246, 'admin.sample.jqgrid_show', 'Sample grid listing ajax', 245, 1),
(247, 'Admin.Shoppingcart.images', 'ShoppingCart ProductImages', 0, 1),
(248, 'Admin.Shoppingcart.ajax_images', 'ShoppingCart ProductImages Ajax', 247, 1),
(249, 'Admin.Shoppingcart.action_image', 'ShoppingCart ProductImages Action', 247, 1),
(250, 'Admin.Shoppingcart.ajax_action_image', 'ShoppingCart ProductImages Ajax Action', 249, 1),
(251, 'Admin.Shoppingcart.delete_product_images', 'ShoppingCart ProductImages Delete', 247, 1),
(252, 'Front.Calendar.Validate', 'Validate form fields', 142, 1),
(253, 'Admin.Banner.Set_Session', 'Banner search', 130, 1),
(254, 'Admin.City.Set_Session', 'City Search', 89, 1),
(255, 'Admin.Country.set_session', 'set session', 91, 1),
(256, 'Admin.States.set_session', 'set session for states', 97, 1),
(257, 'Admin.Calendar.Session_Set', 'Session Set', 87, 1),
(258, 'Front.Calendar.Session_Set', 'Session set front', 142, 1),
(259, 'Admin.Menu.Get_menulist', 'Menu Get Menulist', 26, 1),
(260, 'Admin.menu.get_subpages', 'Admin Menu Get_subpages', 26, 1),
(262, 'Admin.Roles.User_permission_matrix', 'User Permission Matrix', 11, 1),
(263, 'Admin.Users.Action', 'Admin User Action', 4, 1),
(264, 'Admin.Testimonial.Action.Add', 'Add Testimonial', 229, 1),
(265, 'Admin.Testimonial.Action.Edit', 'Edit Testimonial', 229, 1),
(266, 'Admin.Testimonial.Save', 'Save Testimonial', 229, 1),
(267, 'Admin.Testimonial.Delete', 'Delete Testimonial', 229, 1),
(268, 'Front.Testimonial.Index', 'Front_Testimonial', 0, 1),
(269, 'Front.Testimonial.Action.Add', 'Add front Testimonial', 268, 1),
(270, 'Front.Testimonial.Save', 'Save Front Testimonial', 268, 1),
(271, 'Front.Testimonial.Delete', 'Delete Front Testimonial', 268, 1),
(272, 'Front.Testimonial.Action.Edit', 'Edit Front Testimonial', 268, 1),
(273, 'Admin.Forum.Delete_topic', 'Topic Delete', 96, 1),
(274, 'Admin.Forum.Delete_forum', 'Delete Forum', 96, 1),
(275, 'Admin.Testimonial.Ajax_Index', 'Testimonial listing', 229, 1),
(276, 'Admin.Testimonial.Ajax_Action', 'Add Testimonial in diff. lang.', 229, 1),
(277, 'Admin.Forum.Topic_edit', 'Forum Topic Edit', 96, 1),
(278, 'Admin.Shoppingcart.view', 'ShoppingCart View', 196, 1),
(279, 'Front.Testimonial.Testimonial_Detail', 'Testimonial Details', 268, 1),
(280, 'Admin.Forum.View_data', 'Forum View_data', 96, 1),
(281, 'Front.Testimonial.Recaptcha', 'Captcha', 268, 1),
(282, 'Admin.Testimonial.Testimonial_Detail', 'Admin tetimonial Detail', 229, 1),
(283, 'Admin.Testimonial.Ajax_View', 'Ajax Detail', 229, 1),
(284, 'Admin.Gallery.view_details', 'View Image Details', 79, 1),
(285, 'Product', 'Admin.Product.Listing', 0, 1),
(286, 'Admin.Blog.Ajax_Index', 'Blog Listing', 90, 1),
(287, 'Admin.Blog.Ajax_Action', 'Blog Ajax Action', 90, 1),
(288, 'Admin.Blog.Comment', 'Blog Comment Listing', 90, 1),
(289, 'Admin.Blog.Edit_Comment', 'Blog Comment Edit', 90, 1),
(290, 'Admin.Blog.Comment_Action', 'Blog Comment Action', 90, 1),
(291, 'Admin.Blog.Comment_Delete', 'Blog Comment Delete', 90, 1),
(292, 'Admin.Blog.View', 'Blog View', 90, 1),
(293, 'Front.Testimonial.Session_Set', 'Set search values in session', 268, 1),
(294, 'Admin.Testimonial.Session_Set', 'To Set search values in session', 229, 1),
(295, 'Admin.Shoppingcart.Ajax_Control_Panel', 'ShoppingCart Control Panel Ajax', 196, 1),
(296, 'Admin.Shoppingcart.categories', 'ShoppingCart Categories', 0, 1),
(297, 'Admin.Shoppingcart.Ajax_category_Index', 'ShoppingCart Categories Ajax', 296, 1),
(298, 'Admin.Shoppingcart.ajax_category_action', 'ShoppingCart Category Ajax Action', 296, 1),
(299, 'Admin.Shoppingcart.Category.add', 'ShoppingCart Categories Add', 296, 1),
(300, 'Admin.Shoppingcart.Category.edit', 'ShoppingCart Categories Edit', 296, 1),
(301, 'Admin.Shoppingcart.Category.delete', 'ShoppingCart Categories Delete', 296, 1),
(302, 'Admin.Products.Session_Set', 'Set Values of Search in Session', 234, 1),
(303, 'Admin.cms.view', 'CMS View', 22, 1),
(304, 'Admin.categories.view', 'Categories View', 49, 1),
(305, 'Admin.Categories.Ajax_view', 'Categories Ajax View', 49, 1),
(306, 'Shoppingcart.Addtocart', 'ShoppingCart Addtocart', 196, 1),
(307, 'Shoppingcart.Cart', 'ShoppingCart Cart', 196, 1),
(308, 'Shoppingcart.Updatecartitem', 'ShoppingCart Update Cart Item', 196, 1),
(309, 'Shoppingcart.Payments', 'ShoppingCart Payments', 0, 1),
(310, 'Shoppingcart.Action_Payments', 'ShoppingCart Action Payments', 309, 1),
(311, 'ddfgdfg', 'dfdfgdfg', 0, -1),
(312, 'Admin.Modulebuilder.Generate_Module', 'Module builder', 0, 1),
(313, 'Front.Uploadify.Index', 'Uploadify', 0, 1),
(314, 'Front.Uploadify.Do_Upload', 'Upload  Image', 313, 1),
(315, 'Admin.Roles.Save', 'Role Save', 11, 1),
(316, 'Admin.Settings.Save', 'Settings Save', 33, 1),
(319, 'admin.Test.action', 'Admin Test', 0, 1),
(323, 'Admin.Blog.Ajax_View', 'Blog Ajax View', 90, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` float(10,2) NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0->inactive 1->active -1->deleted',
  `meta_keywords` varchar(100) NOT NULL,
  `meta_description` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`,`lang_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_id`, `category_id`, `lang_id`, `name`, `description`, `price`, `featured`, `sort_order`, `slug`, `product_image`, `status`, `meta_keywords`, `meta_description`, `created_by`, `created_on`, `modified_by`, `modified_on`) VALUES
(1, 1, 82, 1, 'Art Test Case', '', 2350.00, 0, 0, 'art-test-case', '', 1, '', '', 1, '2014-10-21 10:31:53', 0, '2014-10-21 10:25:08');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE IF NOT EXISTS `product_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0->inactive 1->active -1->deleted',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE IF NOT EXISTS `quizzes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `quiz_title` varchar(1000) NOT NULL,
  `description` text NOT NULL,
  `publish_status` enum('0','1') NOT NULL COMMENT '0-unpublished, 1-published',
  `status` enum('-1','0','1') NOT NULL COMMENT '0-inactive, 1-active, -1-delete',
  `created_datetime` datetime NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `lang_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempted_questions`
--

CREATE TABLE IF NOT EXISTS `quiz_attempted_questions` (
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `attempted_question_id` int(11) NOT NULL,
  `attempted_option_id` int(11) NOT NULL,
  `is_correct_option` int(11) NOT NULL COMMENT '0 - incorrect, 1 - correct '
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_chapters`
--

CREATE TABLE IF NOT EXISTS `quiz_chapters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_id` int(11) NOT NULL,
  `chapter_name` varchar(500) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `status` enum('-1','0','1') NOT NULL COMMENT '0-inactive, 1-active, -1-delete',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE IF NOT EXISTS `quiz_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `status` enum('-1','0','1') NOT NULL COMMENT '0-inactive, 1-active, -1-delete',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question_options`
--

CREATE TABLE IF NOT EXISTS `quiz_question_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option` varchar(1000) NOT NULL,
  `is_correct_answer` enum('0','1') NOT NULL COMMENT '0-no, 1-yes',
  `lang_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_subjects`
--

CREATE TABLE IF NOT EXISTS `quiz_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(500) NOT NULL,
  `category_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `status` enum('-1','0','1') NOT NULL COMMENT '0-inactive, 1-active, -1-delete',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `role_description` text CHARACTER SET utf8 NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL COMMENT '"-1= Deleted, 0=Inactive,1=Active"',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=37 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `role_description`, `default`, `status`) VALUES
(1, 'Administrator', 'This is role of administrator', 0, 1),
(2, 'User', 'This is role user', 0, 1),
(30, 'Visitor', '', 0, 1),
(32, 'Manager', '', 0, 1),
(36, 'Guest', 'Guest', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE IF NOT EXISTS `role_permission` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(1, 54),
(1, 55),
(1, 56),
(1, 57),
(1, 58),
(1, 63),
(1, 64),
(1, 65),
(1, 66),
(1, 67),
(1, 68),
(1, 69),
(1, 70),
(1, 71),
(1, 72),
(1, 73),
(1, 74),
(1, 75),
(1, 76),
(1, 77),
(1, 78),
(1, 79),
(1, 80),
(1, 81),
(1, 82),
(1, 83),
(1, 84),
(1, 85),
(1, 86),
(1, 87),
(1, 88),
(1, 89),
(1, 90),
(1, 91),
(1, 92),
(1, 93),
(1, 94),
(1, 95),
(1, 96),
(1, 97),
(1, 98),
(1, 99),
(1, 100),
(1, 101),
(1, 102),
(1, 103),
(1, 104),
(1, 105),
(1, 106),
(1, 107),
(1, 108),
(1, 109),
(1, 112),
(1, 113),
(1, 114),
(1, 115),
(1, 116),
(1, 117),
(1, 118),
(1, 119),
(1, 120),
(1, 121),
(1, 122),
(1, 123),
(1, 124),
(1, 125),
(1, 127),
(1, 128),
(1, 129),
(1, 130),
(1, 132),
(1, 133),
(1, 134),
(1, 135),
(1, 136),
(1, 137),
(1, 138),
(1, 139),
(1, 140),
(1, 141),
(1, 142),
(1, 143),
(1, 144),
(1, 145),
(1, 146),
(1, 147),
(1, 148),
(1, 149),
(1, 150),
(1, 151),
(1, 155),
(1, 156),
(1, 157),
(1, 158),
(1, 159),
(1, 160),
(1, 161),
(1, 162),
(1, 163),
(1, 164),
(1, 165),
(1, 166),
(1, 167),
(1, 168),
(1, 169),
(1, 170),
(1, 171),
(1, 172),
(1, 173),
(1, 174),
(1, 175),
(1, 176),
(1, 177),
(1, 178),
(1, 179),
(1, 180),
(1, 181),
(1, 182),
(1, 183),
(1, 184),
(1, 185),
(1, 186),
(1, 187),
(1, 188),
(1, 189),
(1, 190),
(1, 191),
(1, 192),
(1, 193),
(1, 194),
(1, 195),
(1, 196),
(1, 197),
(1, 198),
(1, 199),
(1, 200),
(1, 201),
(1, 202),
(1, 203),
(1, 204),
(1, 205),
(1, 206),
(1, 207),
(1, 208),
(1, 209),
(1, 210),
(1, 211),
(1, 212),
(1, 213),
(1, 214),
(1, 215),
(1, 216),
(1, 217),
(1, 218),
(1, 219),
(1, 220),
(1, 221),
(1, 222),
(1, 223),
(1, 224),
(1, 225),
(1, 226),
(1, 227),
(1, 228),
(1, 229),
(1, 230),
(1, 231),
(1, 232),
(1, 233),
(1, 252),
(1, 253),
(1, 254),
(1, 255),
(1, 256),
(1, 257),
(1, 258),
(1, 259),
(1, 260),
(1, 262),
(1, 263),
(1, 264),
(1, 265),
(1, 266),
(1, 273),
(1, 274),
(1, 277),
(1, 278),
(1, 280),
(1, 284),
(1, 286),
(1, 287),
(1, 288),
(1, 289),
(1, 290),
(1, 291),
(1, 292),
(1, 295),
(1, 303),
(1, 304),
(1, 305),
(1, 306),
(1, 307),
(1, 308),
(1, 315),
(1, 316),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 24),
(2, 25),
(2, 26),
(2, 27),
(2, 28),
(2, 29),
(2, 30),
(2, 31),
(2, 32),
(2, 33),
(2, 34),
(2, 35),
(2, 36),
(2, 37),
(2, 41),
(2, 42),
(2, 43),
(2, 44),
(2, 45),
(2, 46),
(2, 47),
(2, 48),
(2, 49),
(2, 54),
(2, 55),
(2, 56),
(2, 57),
(2, 58),
(2, 63),
(2, 64),
(2, 65),
(2, 66),
(2, 67),
(2, 68),
(2, 69),
(2, 70),
(2, 71),
(2, 72),
(2, 73),
(2, 74),
(2, 75),
(2, 76),
(2, 77),
(2, 78),
(2, 79),
(2, 80),
(2, 81),
(2, 82),
(2, 83),
(2, 84),
(2, 85),
(2, 86),
(2, 90),
(2, 91),
(2, 92),
(2, 93),
(2, 95),
(2, 96),
(2, 97),
(2, 98),
(2, 99),
(2, 100),
(2, 103),
(2, 105),
(2, 107),
(2, 112),
(2, 113),
(2, 114),
(2, 115),
(2, 116),
(2, 117),
(2, 118),
(2, 120),
(2, 121),
(2, 122),
(2, 127),
(2, 134),
(2, 138),
(2, 139),
(2, 140),
(2, 141),
(2, 142),
(2, 143),
(2, 144),
(2, 145),
(2, 146),
(2, 155),
(2, 156),
(2, 157),
(2, 158),
(2, 160),
(2, 162),
(2, 163),
(2, 164),
(2, 165),
(2, 166),
(2, 167),
(2, 168),
(2, 169),
(2, 170),
(2, 171),
(2, 172),
(2, 173),
(2, 174),
(2, 175),
(2, 176),
(2, 177),
(2, 178),
(2, 179),
(2, 180),
(2, 181),
(2, 182),
(2, 183),
(2, 184),
(2, 185),
(2, 186),
(2, 187),
(2, 188),
(2, 189),
(2, 190),
(2, 191),
(2, 192),
(2, 194),
(2, 195),
(2, 196),
(2, 197),
(2, 198),
(2, 199),
(2, 200),
(2, 201),
(2, 202),
(2, 203),
(2, 209),
(2, 210),
(2, 211),
(2, 212),
(2, 213),
(2, 214),
(2, 215),
(2, 216),
(2, 217),
(2, 218),
(2, 219),
(2, 220),
(2, 223),
(2, 224),
(2, 225),
(2, 226),
(2, 230),
(2, 231),
(2, 252),
(2, 255),
(2, 256),
(2, 258),
(2, 262),
(2, 263),
(2, 273),
(2, 274),
(2, 277),
(2, 278),
(2, 280),
(2, 284),
(2, 286),
(2, 287),
(2, 288),
(2, 289),
(2, 290),
(2, 291),
(2, 292),
(2, 295),
(2, 306),
(2, 307),
(2, 308);

-- --------------------------------------------------------

--
-- Table structure for table `samples`
--

CREATE TABLE IF NOT EXISTS `samples` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sample_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_label` varchar(255) COLLATE utf8_bin NOT NULL,
  `setting_title` varchar(255) COLLATE utf8_bin NOT NULL,
  `setting_value` varchar(255) COLLATE utf8_bin NOT NULL,
  `comment` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=32 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_label`, `setting_title`, `setting_value`, `comment`) VALUES
(8, 'RECORD_PER_PAGE', 'Recored per page for pagination', '5', 'Recored per page for pagination'),
(9, 'CAPTCHA_SETTING', 'captcha setting', '1', 'settings for captcha'),
(10, 'CONTACT_US_EMAIL', 'contact us email', 'test@compaydomain.com', 'contact us email id'),
(11, 'SITE_FROM_EMAIL', 'site from email', 'info@compaydomain.com', 'from email address'),
(12, 'SMTP_HOST', 'smtp host', '192.168.10.2', 'smtp host setting'),
(13, 'SMTP_PORT', 'smtp port', '25', 'set smtp port'),
(14, 'SMTP_PASSWORD', 'smtp password', 'tatva123', 'set smtp password'),
(15, 'SMTP_USERNAME', 'smtp username', 'vijay.vaishnav@sparsh.com', 'set smtp username'),
(16, 'DEFAULT_CMS_PAGE', 'Default CMS Page', 'cms3', 'Default CMS Page'),
(18, 'EXCLUDE_KEYS_FILTEROUTPUT', 'Exclude Keys in Filter Output', 'captcha,content,description,search_term', 'Exclude Keys in Data Variable assignment in Theme''s View function to render as it is'),
(19, 'ACTIVITY_LOG', 'Activity log', '1', 'Enable activity log. 1 for enable and 0 for disable'),
(21, 'SITE_NAME', 'Site Name', 'Site Name', 'site name'),
(28, 'CURRENCY_CODE', 'Currency Code', 'USD', 'Default currency code for all products'),
(29, 'PAYPAL_TEST_MODE', 'Paypal Test Mode', 'true', 'Paypal mode if sandbox then it will go to testing site if you left blank then it will go to the live paypal site'),
(30, 'PAYPAL_API_USERNAME', 'Paypal Api User Name', 'PAYPAL_API_USERNAME', ''),
(31, 'PAYPAL_API_PASSWORD', 'Paypal Api Password', 'PAYPAL_API_PASSWORD', '');

-- --------------------------------------------------------

--
-- Table structure for table `settings_newsletters`
--

CREATE TABLE IF NOT EXISTS `settings_newsletters` (
  `admin_email` varchar(255) NOT NULL,
  `admin_email_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart_billing_address`
--

CREATE TABLE IF NOT EXISTS `shoppingcart_billing_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `bill_fname` varchar(100) CHARACTER SET utf8 NOT NULL,
  `bill_lname` varchar(100) CHARACTER SET utf8 NOT NULL,
  `bill_address` text CHARACTER SET utf8 NOT NULL,
  `bill_street` varchar(100) CHARACTER SET utf8 NOT NULL,
  `bill_country` varchar(100) CHARACTER SET utf8 NOT NULL,
  `bill_state` varchar(100) CHARACTER SET utf8 NOT NULL,
  `bill_city` varchar(100) CHARACTER SET utf8 NOT NULL,
  `bill_postcode` int(6) NOT NULL,
  `bill_default` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart_categories`
--

CREATE TABLE IF NOT EXISTS `shoppingcart_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug_url` varchar(255) NOT NULL,
  `category_image` varchar(255) DEFAULT NULL,
  `description` text,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=inactive, 1=active, -1=deleted',
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` text,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `modify_on` datetime DEFAULT NULL,
  `modify_by` int(11) NOT NULL DEFAULT '0',
  `delete_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `parent_id` (`parent_id`),
  KEY `lang_id` (`lang_id`),
  KEY `status` (`status`),
  KEY `slug_url` (`slug_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart_coupons`
--

CREATE TABLE IF NOT EXISTS `shoppingcart_coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `coupon_code` varchar(10) CHARACTER SET utf8 NOT NULL,
  `coupon_price` float NOT NULL,
  `coupon_percentage` tinyint(4) NOT NULL,
  `coupon_maxuse` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `coupon_sdate` date NOT NULL,
  `coupon_edate` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `coupon_code` (`coupon_code`),
  KEY `status` (`status`),
  KEY `coupon_sdate` (`coupon_sdate`),
  KEY `coupon_edate` (`coupon_edate`),
  KEY `coupon_maxuse` (`coupon_maxuse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart_orders`
--

CREATE TABLE IF NOT EXISTS `shoppingcart_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lang_id` int(2) NOT NULL DEFAULT '1',
  `currency_code` varchar(5) CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `bill_address_id` int(11) NOT NULL,
  `ship_address_id` int(11) NOT NULL,
  `coupon_code` varchar(10) CHARACTER SET utf8 NOT NULL,
  `order_amount` decimal(10,2) NOT NULL,
  `coupon_discount` decimal(10,2) NOT NULL,
  `order_tax` decimal(5,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_items` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `notes` text CHARACTER SET utf8,
  `order_status` int(11) NOT NULL COMMENT '0-Pending,1-Cancelled,2-Processing,3-Dispatched,4-Completed',
  `paypal_token` varchar(50) CHARACTER SET utf8 NOT NULL,
  `payapl_payerid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `payapl_transactionid` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `bill_address_id` (`bill_address_id`),
  KEY `ship_address_id` (`ship_address_id`),
  KEY `order_status` (`order_status`),
  KEY `lang_id` (`lang_id`),
  KEY `order_date` (`order_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart_order_items`
--

CREATE TABLE IF NOT EXISTS `shoppingcart_order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `lang_id` int(2) NOT NULL DEFAULT '1',
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `product_qty` int(11) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `order_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  KEY `lang_id` (`lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart_payment_module`
--

CREATE TABLE IF NOT EXISTS `shoppingcart_payment_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 NOT NULL,
  `method` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `key` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `mode` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modify_on` int(11) DEFAULT NULL,
  `modify_by` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `shoppingcart_payment_module`
--

INSERT INTO `shoppingcart_payment_module` (`id`, `title`, `method`, `username`, `password`, `key`, `mode`, `status`, `created_by`, `created_on`, `modify_on`, `modify_by`) VALUES
(1, 'PAYPAL EXPRESS', 'SetExpressCheckout', 'devma1_1347618395_biz_api1.yahoo.com', '1347618414', 'AFcWxV21C7fd0v3bYYYRCpSSRl31AxX13Y-Hi50kgSqi45JuEGpxRz6E', 0, 0, 1, '2013-12-12 13:33:57', 2013, '0000-00-00 00:00:00'),
(2, 'NEW PAYPAL EXPRESS', 'SetExpressCheckout', 'test1360750536_api1.gmail.com', '1387272969', 'ABSjvYIOD6k11wJyojyS-33LgVU0A4xwXg0fsM4qlME2Sax4SL7a9ZCh', 0, 1, 1, '2013-12-17 09:46:15', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart_products`
--

CREATE TABLE IF NOT EXISTS `shoppingcart_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` float(10,2) NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `slug_url` varchar(100) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0->inactive 1->active -1->deleted',
  `meta_keywords` varchar(100) NOT NULL,
  `meta_description` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `discount_price` decimal(10,2) NOT NULL,
  `currency_code` varchar(5) NOT NULL,
  `stock` int(11) NOT NULL,
  `visiters` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`,`lang_id`),
  KEY `product_id` (`product_id`),
  KEY `lang_id` (`lang_id`),
  KEY `visiters` (`visiters`),
  KEY `price` (`price`),
  KEY `name` (`name`),
  KEY `slug_url` (`slug_url`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart_products_image`
--

CREATE TABLE IF NOT EXISTS `shoppingcart_products_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0->inactive 1->active -1->deleted',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart_products_related`
--

CREATE TABLE IF NOT EXISTS `shoppingcart_products_related` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `related_product_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `related_product_id` (`related_product_id`),
  KEY `lang_id` (`lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart_shipping_address`
--

CREATE TABLE IF NOT EXISTS `shoppingcart_shipping_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ship_fname` varchar(100) CHARACTER SET utf8 NOT NULL,
  `ship_lname` varchar(100) CHARACTER SET utf8 NOT NULL,
  `ship_address` text CHARACTER SET utf8 NOT NULL,
  `ship_street` varchar(100) CHARACTER SET utf8 NOT NULL,
  `ship_country` varchar(100) CHARACTER SET utf8 NOT NULL,
  `ship_state` varchar(100) CHARACTER SET utf8 NOT NULL,
  `ship_city` varchar(100) CHARACTER SET utf8 NOT NULL,
  `ship_postcode` int(6) NOT NULL,
  `ship_default` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE IF NOT EXISTS `state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(8) NOT NULL,
  `country_id` int(4) NOT NULL,
  `state_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `lang_id` tinyint(1) NOT NULL COMMENT '1-english,0-spanish',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-active,0-inactive',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `state_id` (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `state_id`, `country_id`, `state_name`, `lang_id`, `status`, `created_by`, `created_on`, `modified_by`, `modified_on`) VALUES
(62, 2, 3, 'California', 1, 1, 28, '2013-10-08 05:15:53', 12, '2013-10-29 08:00:08'),
(63, 2, 3, 'Californiaar', 10, 1, 28, '2013-10-08 05:37:40', 12, '2013-10-29 08:00:08'),
(67, 2, 3, 'California', 2, 1, 28, '2013-10-08 05:46:12', 12, '2013-10-29 08:00:08'),
(70, 8, 4, 'gujarat', 1, 1, 12, '2013-10-08 06:01:02', 12, '2013-10-29 08:00:08'),
(71, 9, 4, 'Maharashtra', 1, -1, 12, '2013-10-17 11:46:01', 12, '2013-11-11 00:42:26'),
(72, 10, 4, 'Asam', 1, -1, 12, '2013-10-17 12:44:39', 0, '2013-10-29 12:41:32'),
(73, 11, 4, 'Karnataka', 1, 1, 12, '2013-10-17 12:45:03', 12, '2013-10-29 08:04:07'),
(74, 12, 4, 'Kerala', 1, 1, 12, '2013-10-17 12:45:15', 12, '2013-10-29 08:01:22'),
(75, 13, 4, 'Tamilnaduu', 1, -1, 12, '2013-10-17 12:45:45', 0, '2013-10-17 13:19:27'),
(76, 14, 14, 'Sindh', 1, -1, 28, '2013-10-21 08:20:39', 12, '2013-10-29 07:35:27'),
(77, 15, 4, 'AndhraPradesh', 1, 1, 28, '2013-10-21 08:21:59', 12, '2013-10-29 08:03:56'),
(78, 8, 4, 'Gujarat', 2, 1, 28, '2013-10-21 08:24:01', 12, '2013-10-29 08:00:08'),
(79, 16, 4, 'Goa', 1, -1, 12, '2013-10-22 08:40:16', 0, '2013-10-22 08:47:15'),
(80, 17, 4, 'Goa', 1, -1, 12, '2013-10-22 08:41:30', 0, '2013-10-29 12:41:24'),
(81, 18, 4, 'Madhyapradesh', 1, 1, 1, '2013-11-06 12:43:02', 0, '2013-11-06 12:48:56'),
(82, 19, 10, 'Maharashtra', 1, -1, 12, '2013-11-11 06:30:21', 12, '2013-11-11 01:00:26'),
(83, 20, 4, 'Maharashtra', 1, 1, 12, '2013-11-11 09:11:08', 0, '2013-11-11 09:16:55');

-- --------------------------------------------------------

--
-- Table structure for table `testimonial`
--

CREATE TABLE IF NOT EXISTS `testimonial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `testimonial_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL COMMENT 'Languages Table',
  `category_id` int(11) NOT NULL COMMENT 'categories Table',
  `testimonial_name` varchar(100) NOT NULL,
  `testimonial_slug` varchar(100) NOT NULL,
  `testimonial_description` text NOT NULL,
  `logo` varchar(255) DEFAULT NULL COMMENT 'person image/company logo',
  `company_name` varchar(100) NOT NULL,
  `website` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `user_id` int(11) NOT NULL COMMENT 'users Table',
  `video_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '''2''=>''youtube'', ''1''=>''file_type''',
  `video_src` varchar(500) NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0' COMMENT '''0''=>''Not published'', ''1''=>''Published''',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lang_id` (`lang_id`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `testimonial`
--

INSERT INTO `testimonial` (`id`, `testimonial_id`, `lang_id`, `category_id`, `testimonial_name`, `testimonial_slug`, `testimonial_description`, `logo`, `company_name`, `website`, `position`, `user_id`, `video_type`, `video_src`, `is_published`, `created_by`, `created_on`, `modified_by`, `modified_on`, `deleted`) VALUES
(1, 1, 1, 37, 'way''s', 'ways', '<p><span >this is the testing detail&#39;s</span></p>', '', '', '', '', 1, 0, '', 1, 1, '2014-10-09 11:06:26', 0, '2014-10-16 07:15:12', 1),
(2, 2, 1, 37, 'way''sdddd', 'waysdddd', '<p>ssfsdfsdfsdf</p>', '', 'sdfsdfsd', '', '2', 1, 1, 'assets/uploads/testimonial_video/abc141285344214352.flv', 1, 1, '2014-10-09 11:17:22', 0, '2014-10-16 11:20:01', 1),
(3, 3, 1, 37, 'test', 'test', '<p>test</p>', 'assets/uploads/testimonial_logo/Tulips.jpg', 'test', 'http://google.com', 'test', 1, 0, '', 1, 1, '2014-10-09 11:19:26', 0, '2014-10-16 07:15:12', 0),
(4, 4, 1, 37, 'test', 'test23', '<p>test</p>', '', 'test', 'http://google.com', 'test', 1, 0, '', 1, 1, '2014-10-09 11:21:38', 0, '2014-10-16 07:48:29', 0),
(5, 5, 1, 38, 'test', 'asdfgh', 'www.lipsum.com', '', 'test', 'http://google.com', 'test', 1, 0, '', 1, 1, '2014-10-10 05:33:12', 1, '2014-10-16 07:50:24', 0),
(6, 6, 1, 38, 'Concert123', 'concert123', 'Concert', 'assets/uploads/testimonial_logo/Chrysanthemum.jpg', 'Concert', 'http://google.com', 'Concert', 1, 0, '', 1, 1, '2014-10-10 05:35:13', 1, '2014-10-16 07:15:12', 1),
(7, 7, 2, 37, 'Cricket', 'cricket', '<p>Cricket</p>', '', 'Cricket', 'http://google.com', 'Cricket', 1, 0, '', 1, 1, '2014-10-10 05:48:22', 0, '2014-10-10 05:41:36', 0),
(8, 8, 1, 37, 'Cricket', 'adsfdg', 'Cricket<br>', '', 'Cricket', 'sfds', 'Cricket', 1, 1, '', 1, 1, '2014-10-10 09:58:18', 1, '2014-10-16 07:51:36', 0),
(9, 9, 1, 37, 'gugyuygui', 'gugyuyguijh', 'hgyj', 'assets/uploads/testimonial_logo/Desert.jpg', '', '', '', 1, 0, '', 1, 1, '2014-10-14 09:59:16', 0, '2014-10-16 07:21:34', 1),
(10, 10, 1, 37, 'ghjhgj', 'ghjhgj', 'hjkjhk', '', '', '', '', 1, 0, '', 1, 1, '2014-10-15 07:54:57', 0, '2014-10-16 07:21:10', 1),
(11, 11, 1, 37, 'Indian Cricket Team', 'indian-cricket-team', '<span>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</span><br>', '', '', '', '', 1, 0, '', 1, 1, '2014-10-16 07:16:05', 0, '2014-10-16 07:15:12', 1),
(12, 12, 2, 38, 'bcvbcb', 'bcvbcb', 'cvbvcbvcbvcbvc', '', '', '', '', 1, 0, '', 1, 1, '2014-10-17 09:35:37', 0, '2014-10-17 09:28:52', 0);

-- --------------------------------------------------------

--
-- Table structure for table `url_management`
--

CREATE TABLE IF NOT EXISTS `url_management` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug_url` varchar(50) COLLATE utf8_bin NOT NULL,
  `language_id` int(11) NOT NULL,
  `module_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `related_id` int(11) NOT NULL DEFAULT '0',
  `core_url` varchar(255) COLLATE utf8_bin NOT NULL,
  `order` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=Inactive, 1=Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=125 ;

--
-- Dumping data for table `url_management`
--

INSERT INTO `url_management` (`id`, `slug_url`, `language_id`, `module_name`, `related_id`, `core_url`, `order`, `status`) VALUES
(2, 'about-us', 1, 'cms', 2, 'index/about-us', 0, 1),
(3, 'cms3', 1, 'cms', 1, 'index/cms3', 0, 1),
(15, 'cms', 1, 'cms', 8, 'index/cms', 0, 1),
(57, 'contact us', 0, 'contact_us', 0, 'contact_us/index', 0, 1),
(59, 'banner', 0, 'banner', 0, 'banner', 0, 1),
(61, 'Home', 1, 'cms', 8, 'index/Home', 0, 1),
(62, 'Terms & Conditions', 1, 'cms', 49, 'index/Terms & Conditions', 0, 1),
(64, 'test-category', 1, 'categories', 58, 'index/test-category', 0, 1),
(76, 'mobile', 1, 'categories', 69, 'index/mobile', 0, 1),
(85, 'sony-vaio---ar', 10, 'cms', 61, 'index/sony-vaio---ar', 0, 1),
(86, 'asdfgh', 1, 'testimonial', 0, 'index/asdfgh', 0, 1),
(87, 'concert123', 1, 'testimonial', 1, 'index/concert123', 0, 1),
(88, 'cricket', 2, 'testimonial', 0, 'index/cricket', 0, 1),
(89, 'adsfdg', 1, 'testimonial', 1, 'index/adsfdg', 0, 1),
(90, 'news', 1, 'categories', 75, 'index/news', 0, 1),
(92, 'test', 1, 'blog', 2, 'index/test', 0, 1),
(93, 'blog-', 1, 'blog', 2, 'index/blog-', 0, 1),
(96, 'new', 1, 'blog', 5, 'index/new', 0, 1),
(97, 'portfoliosp', 2, 'cms', 57, 'index/portfoliosp', 0, 1),
(98, 'test-span', 2, 'cms', 62, 'index/test-span', 0, 1),
(99, 'gugyuyguijh', 1, 'testimonial', 0, 'index/gugyuyguijh', 0, 1),
(100, 'mobile123', 1, 'categories', 77, 'index/mobile123', 0, 1),
(101, 'hjhgjhj446', 1, 'cms', 63, 'index/hjhgjhj446', 0, 1),
(102, 'hjhk', 1, 'cms', 64, 'index/hjhk', 0, 1),
(103, 'ghjhgj', 1, 'testimonial', 0, 'index/ghjhgj', 0, 1),
(105, 'indian-cricket-team', 1, 'testimonial', 0, 'index/indian-cricket-team', 0, 1),
(107, 'vghjhgj', 1, 'cms', 65, 'index/vghjhgj', 0, 1),
(109, 'dgtfdgh', 1, 'cms', 66, 'index/dgtfdgh', 0, 1),
(110, 'fdaf', 1, 'cms', 67, 'index/fdaf', 0, 1),
(112, 'cvgcb', 1, 'categories', 79, 'index/cvgcb', 0, 1),
(116, 'polo-brand', 1, 'categories', 82, 'index/polo-brand', 0, 1),
(117, 'fghlg', 1, 'categories', 83, 'index/fghlg', 0, 1),
(118, 'dfsfds', 1, 'categories', 84, 'index/dfsfds', 0, 1),
(119, 'Sports', 10, 'categories', 85, 'index/Sports', 0, 1),
(120, 'dsf', 1, 'cms', 70, 'index/dsf', 0, 1),
(121, 'ghjg', 1, 'blog', 8, 'index/ghjg', 0, 0),
(122, 'ghdfhfghfhf', 2, 'cms', 71, 'index/ghdfhfghfhf', 0, 1),
(123, 'hfgjfgfghfgh', 2, 'categories', 86, 'index/hfgjfgfghfgh', 0, 1),
(124, 'bcvbcb', 2, 'testimonial', 0, 'index/bcvbcb', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(3) NOT NULL DEFAULT '0',
  `firstname` varchar(100) CHARACTER SET utf8 NOT NULL,
  `lastname` varchar(100) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Unique',
  `password` varchar(50) COLLATE utf8_bin NOT NULL COMMENT 'Sha1 with Custom encryption key',
  `activation_code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `activation_expiry` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '"-1= Deleted, 0=Inactive,1=Active, 2=Suspended,3=Restricted"',
  `created` datetime NOT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_locked` tinyint(1) NOT NULL,
  `lock_datetime` datetime NOT NULL,
  `lock_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=222 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `firstname`, `lastname`, `email`, `password`, `activation_code`, `activation_expiry`, `last_login`, `status`, `created`, `modified`, `is_locked`, `lock_datetime`, `lock_user_id`) VALUES
(1, 1, 'Tatvasoft', 'Super Admin', 'admin@tatvasoft.com', 'f865b53623b121fd34ee5426c792e5c33af8c227', '', '2013-08-23 18:56:51', '2015-03-10 12:11:42', 1, '2013-08-22 18:56:52', '2013-08-22 13:26:52', 1, '2015-01-01 11:31:46', 1),
(205, 1, 'Test1', 'Test1', 'test1@test.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, 1, '2014-10-01 14:02:48', '2014-10-16 04:56:38', 0, '2014-10-16 04:56:55', 0),
(206, 2, 'Test10', 'User', 'test10.user@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, 1, '2014-10-01 14:03:13', '2014-10-16 04:56:38', 0, '2014-10-15 12:29:44', 0),
(207, 1, 'Test2', 'Test2', 'test2@test.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, 1, '2014-10-01 14:04:41', '2014-10-16 04:56:38', 0, '2014-10-03 12:49:03', 0),
(208, 2, 'Test11', 'User11', 'test11@test.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, -1, '2014-10-01 14:04:52', '2014-10-16 04:49:59', 0, '2014-10-15 09:08:57', 0),
(209, 1, 'Test3', 'Test3', 'test3@test.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, 1, '2014-10-01 14:05:38', '2014-10-16 04:56:38', 0, '0000-00-00 00:00:00', 0),
(210, 2, 'Test12', 'User', 'test12.user@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, -1, '2014-10-01 14:06:16', '2014-10-16 05:10:33', 0, '0000-00-00 00:00:00', 0),
(211, 1, 'Test4', 'Test4', 'test4@test.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, 1, '2014-10-01 14:06:31', '2014-10-16 04:56:38', 0, '2014-10-02 11:50:30', 0),
(212, 1, 'Amit', 'Mehta', 'amit.mehta@sparsh.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, 1, '2014-10-02 16:29:10', '2014-10-16 04:56:38', 0, '2014-10-02 11:03:56', 0),
(213, 1, 'Anand', 'Solanki', 'anand.solanki@sparsh.com', 'b973f774bfeab53233b4f347be114e9ca7b2d00f', NULL, NULL, NULL, 1, '2014-10-02 17:38:13', '2014-10-16 04:56:38', 0, '0000-00-00 00:00:00', 0),
(214, 2, 'Vijay', 'Mehta', 'vijay@mehta.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, 1, '2014-10-03 18:15:57', '2014-10-16 04:56:38', 0, '2014-10-03 12:49:18', 0),
(215, 1, 'Amit', 'Mehta', 'amit.mehta123@sparsh.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, 1, '2014-10-06 09:33:04', '2014-10-16 04:56:38', 0, '0000-00-00 00:00:00', 0),
(216, 1, 'teblet', 'tablet', 'ten@let.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, -1, '2014-10-08 15:11:17', '2014-10-13 09:21:55', 0, '2014-10-08 09:57:13', 0),
(217, 2, 'Atul', 'Mehra', 'atul@gmail.cim', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, -1, '2014-10-15 14:28:42', '2014-10-15 08:58:42', 0, '0000-00-00 00:00:00', 0),
(218, 2, 'Test1', 'Panchal1', 'vikky.richard@test.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, -1, '2014-10-15 14:29:19', '2014-10-16 05:12:59', 0, '0000-00-00 00:00:00', 0),
(219, 1, 'Amit', 'Tanna', 'admiddn@fixadoc.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, -1, '2014-10-15 14:29:56', '2014-10-15 08:59:56', 0, '0000-00-00 00:00:00', 0),
(220, 1, 'jbhjhj', 'hjhjhjhj', 'jaydeep@testmail.com', 'bcb58c91e18656345fafda2f2914264135091014', NULL, NULL, NULL, -1, '2014-10-15 17:30:32', '2014-10-16 05:10:51', 0, '2014-10-15 12:16:39', 0),
(221, 1, 'Dhara', 'Gorasiya', 'dhara.gorasiya@sparsh.com', 'd7b7a227b8a4921e7731592a9e4d07603d91c682', NULL, NULL, NULL, 1, '2014-10-16 10:21:32', '2014-10-16 04:56:38', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE IF NOT EXISTS `user_permission` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_permission`
--

INSERT INTO `user_permission` (`user_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(1, 54),
(1, 55),
(1, 56),
(1, 57),
(1, 58),
(1, 63),
(1, 64),
(1, 65),
(1, 66),
(1, 67),
(1, 68),
(1, 69),
(1, 70),
(1, 71),
(1, 72),
(1, 73),
(1, 74),
(1, 75),
(1, 76),
(1, 77),
(1, 78),
(1, 79),
(1, 80),
(1, 81),
(1, 82),
(1, 83),
(1, 84),
(1, 85),
(1, 86),
(1, 87),
(1, 88),
(1, 89),
(1, 90),
(1, 91),
(1, 92),
(1, 93),
(1, 94),
(1, 95),
(1, 96),
(1, 97),
(1, 98),
(1, 99),
(1, 100),
(1, 101),
(1, 102),
(1, 103),
(1, 104),
(1, 105),
(1, 106),
(1, 107),
(1, 108),
(1, 109),
(1, 112),
(1, 113),
(1, 114),
(1, 115),
(1, 116),
(1, 117),
(1, 118),
(1, 119),
(1, 120),
(1, 121),
(1, 122),
(1, 123),
(1, 124),
(1, 125),
(1, 127),
(1, 128),
(1, 129),
(1, 130),
(1, 132),
(1, 133),
(1, 134),
(1, 135),
(1, 136),
(1, 137),
(1, 138),
(1, 139),
(1, 140),
(1, 141),
(1, 142),
(1, 143),
(1, 144),
(1, 145),
(1, 146),
(1, 147),
(1, 148),
(1, 149),
(1, 150),
(1, 151),
(1, 155),
(1, 156),
(1, 157),
(1, 158),
(1, 159),
(1, 160),
(1, 161),
(1, 162),
(1, 163),
(1, 164),
(1, 165),
(1, 166),
(1, 167),
(1, 168),
(1, 169),
(1, 170),
(1, 171),
(1, 172),
(1, 173),
(1, 174),
(1, 175),
(1, 176),
(1, 177),
(1, 178),
(1, 179),
(1, 180),
(1, 181),
(1, 182),
(1, 183),
(1, 184),
(1, 185),
(1, 186),
(1, 187),
(1, 188),
(1, 189),
(1, 190),
(1, 191),
(1, 192),
(1, 193),
(1, 194),
(1, 195),
(1, 196),
(1, 197),
(1, 198),
(1, 199),
(1, 200),
(1, 201),
(1, 202),
(1, 203),
(1, 204),
(1, 205),
(1, 206),
(1, 207),
(1, 208),
(1, 209),
(1, 210),
(1, 211),
(1, 212),
(1, 213),
(1, 214),
(1, 215),
(1, 216),
(1, 217),
(1, 218),
(1, 219),
(1, 220),
(1, 221),
(1, 222),
(1, 223),
(1, 224),
(1, 225),
(1, 226),
(1, 227),
(1, 228),
(1, 229),
(1, 230),
(1, 231),
(1, 232),
(1, 233),
(1, 234),
(1, 235),
(1, 236),
(1, 237),
(1, 238),
(1, 239),
(1, 240),
(1, 241),
(1, 242),
(1, 243),
(1, 244),
(1, 245),
(1, 246),
(1, 247),
(1, 248),
(1, 249),
(1, 250),
(1, 251),
(1, 252),
(1, 253),
(1, 254),
(1, 255),
(1, 256),
(1, 257),
(1, 258),
(1, 259),
(1, 260),
(1, 262),
(1, 263),
(1, 264),
(1, 265),
(1, 266),
(1, 267),
(1, 268),
(1, 269),
(1, 270),
(1, 271),
(1, 272),
(1, 273),
(1, 274),
(1, 275),
(1, 276),
(1, 277),
(1, 278),
(1, 279),
(1, 280),
(1, 281),
(1, 282),
(1, 283),
(1, 284),
(1, 285),
(1, 286),
(1, 287),
(1, 288),
(1, 289),
(1, 290),
(1, 291),
(1, 292),
(1, 293),
(1, 294),
(1, 295),
(1, 296),
(1, 297),
(1, 298),
(1, 299),
(1, 300),
(1, 301),
(1, 302),
(1, 303),
(1, 304),
(1, 305),
(1, 306),
(1, 307),
(1, 308),
(1, 309),
(1, 310),
(1, 311),
(1, 312),
(1, 323);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `gender` enum('M','F') COLLATE utf8_bin NOT NULL DEFAULT 'M',
  `address` text COLLATE utf8_bin NOT NULL,
  `hobbies` varchar(255) COLLATE utf8_bin NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=207 ;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `user_id`, `gender`, `address`, `hobbies`, `modified`) VALUES
(2, 1, 'M', 'Tatvasoft', 'Sport', '2013-08-22 13:26:52'),
(190, 205, 'M', 'Address', '', '2014-10-01 08:32:48'),
(191, 206, 'M', '', '', '2014-10-01 08:33:13'),
(192, 207, 'M', 'Steel Authority of India Ltd.\r\n   Ispat Bhavan\r\n   Lodhi Road\r\n   NEW DELHI \r\n   110003\r\n   INDIA', 'Movies', '2014-10-01 08:34:41'),
(193, 208, 'F', '', 'Movies,Travelling', '2014-10-01 08:34:52'),
(194, 209, 'M', 'Steel Authority of India Ltd.\r\n   Ispat Bhavan\r\n   Lodhi Road\r\n   NEW DELHI \r\n   110003\r\n   INDIA', 'Sport', '2014-10-01 08:35:38'),
(195, 210, 'M', '', '', '2014-10-01 08:36:16'),
(196, 211, 'M', 'Steel Authority of India Ltd.\r\n   Ispat Bhavan\r\n   Lodhi Road\r\n   NEW DELHI \r\n   110003\r\n   INDIA', 'Movies', '2014-10-01 08:36:31'),
(197, 212, 'M', 'Ranip', 'Sport,Movies,Travelling', '2014-10-02 10:59:10'),
(198, 213, 'M', '', '', '2014-10-02 12:08:13'),
(199, 214, 'M', 'Address', 'Sport,Travelling', '2014-10-03 12:45:57'),
(200, 215, 'M', 'Iscon Elegance . Prahlad Nagar, Ahmedabad.', 'Sport,Movies', '2014-10-06 04:03:04'),
(201, 216, 'M', 'Address', 'Movies', '2014-10-08 09:41:17'),
(202, 217, 'M', 'ldadkjasd', 'Movies,Travelling', '2014-10-15 08:58:42'),
(203, 218, 'M', 'sdadsadd', 'Travelling', '2014-10-15 08:59:19'),
(204, 219, 'M', 'sddsad', 'Sport,Movies', '2014-10-15 08:59:56'),
(205, 220, 'M', '', '', '2014-10-15 12:00:32'),
(206, 221, 'F', 'Ahemdabad', 'Movies,Travelling', '2014-10-16 04:51:32');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ad_visitors`
--
ALTER TABLE `ad_visitors`
  ADD CONSTRAINT `ad_visitors_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `advertisement` (`ad_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `eventcal`
--
ALTER TABLE `eventcal`
  ADD CONSTRAINT `eventcal_ibfk_1` FOREIGN KEY (`lang_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shoppingcart_billing_address`
--
ALTER TABLE `shoppingcart_billing_address`
  ADD CONSTRAINT `shoppingcart_billing_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `shoppingcart_categories`
--
ALTER TABLE `shoppingcart_categories`
  ADD CONSTRAINT `shoppingcart_categories_ibfk_1` FOREIGN KEY (`lang_id`) REFERENCES `languages` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `shoppingcart_orders`
--
ALTER TABLE `shoppingcart_orders`
  ADD CONSTRAINT `shoppingcart_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `shoppingcart_orders_ibfk_2` FOREIGN KEY (`lang_id`) REFERENCES `languages` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `shoppingcart_shipping_address`
--
ALTER TABLE `shoppingcart_shipping_address`
  ADD CONSTRAINT `shoppingcart_shipping_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `state`
--
ALTER TABLE `state`
  ADD CONSTRAINT `state_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
