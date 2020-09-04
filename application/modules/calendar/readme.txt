@author - Khyati Govani/Preksha Shah

--------------installating Events with Calendar module--------------

1)Paste the following query in your database. It will create all the required table for this module


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=69 ;




2) Copy the folder in the following directory 
    "project_name\application\modules\"
   If you cant find it, create a folder with name "module" in the application directory.  

3)Create a directory named "calendar" in "\project_name\themes\default\js\modules" and put all the files from js folder in that directory.
If any folder is not there , create the hierarchy accordingly.

4)Create a directory named "calendar" in "\project_name\themes\front\js\modules" and put all the files from js folder in that directory.
If any folder is not there , create the hierarchy accordingly.

5)Create a directory named "calendar" in "\project_name\themes\default\css\modules" and put all the files from css folder in that directory.
If any folder is not there , create the hierarchy accordingly.

6)Create a directory named "calendar" in "\project_name\themes\front\css\modules" and put all the files from js folder in that directory.
If any folder is not there , create the hierarchy accordingly.

7)Create a directory named "calendar" in "\project_name\themes\default\images\modules" and put all the files from images folder in that directory.
If any folder is not there , create the hierarchy accordingly.

8)Create a directory named "calendar" in "\project_name\themes\front\images\modules" and put all the files from images folder in that directory.
If any folder is not there , create the hierarchy accordingly.

Calendar module is ready to use.