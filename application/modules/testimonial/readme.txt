@author - Khyati Govani/Preksha Shah

--------------installating Testimonial module--------------

1)Paste the following query in your database. It will create all the required table for this module

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=178 ;

2) Copy the folder in the following directory 
    "project_name\application\modules\"
   If you cant find it, create a folder with name "module" in the application directory.  

3) Create a directory named "testimonial" in "\project_name\themes\default\js\modules" and put all the files from js folder in that directory.
If any folder is not there , create the hierarchy accordingly.

4) Create a directory named "testimonial" in "\project_name\themes\front\js\modules" and put all the files from js folder in that directory.
If any folder is not there , create the hierarchy accordingly.

5) Create a directory named "testimonial" in "\project_name\themes\default\css\modules" and put all the files from css folder in that directory.
If any folder is not there , create the hierarchy accordingly.

6) Create a directory named "testimonial" in "\project_name\themes\front\css\modules" and put all the files from css folder in that directory.
If any folder is not there , create the hierarchy accordingly.

7)Create a directory named "testimonial" in "\project_name\themes\default\images\modules" and put all the files from images folder in that directory.
If any folder is not there , create the hierarchy accordingly.

8)Create a directory named "calendar" in "\project_name\themes\front\images\modules" and put all the files from images folder in that directory.
If any folder is not there , create the hierarchy accordingly.

9) Create a folder named "uploads" in "project_name\assets\" directory.If "uploads" already exits then just create folder "testimonial_video" for uploading video file and "testimonial_logo" for uploading logo images. 

testimonial module is ready to use.