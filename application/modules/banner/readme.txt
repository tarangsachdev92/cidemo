@author - Vivek Doshi
@mail -vivek.doshi@sparsh-technologies.co.in
@skype- tatva60
--------------installating the product module--------------

1)Paste the following querries in your database. It will create all the required table for this module


   CREATE TABLE IF NOT EXISTS `advertisement` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `ad_id` int(11) NOT NULL,
	  `lang_id` tinyint(1) NOT NULL COMMENT '1-english,2-spanish',
	  `section_id` tinyint(1) NOT NULL COMMENT '1=home page banner,2-ad banner',
	  `page_id` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-about_us,2-contact us,3-privacy policy',
	  `position` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-top,2-bottom,3-left,4-right',
	  `banner_type` tinyint(1) NOT NULL COMMENT '1-image,2-embedded code',
	  `link` varchar(255) NOT NULL,
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
	  `modified_on` datetime NOT NULL,
	  PRIMARY KEY (`id`),
	  KEY `ad_id` (`ad_id`),
	  KEY `city_id` (`city_id`),
	  KEY `country_id` (`country_id`),
	  KEY `state_id` (`state_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;


	CREATE TABLE IF NOT EXISTS `ad_visitors` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `ad_id` int(11) NOT NULL,
	  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '0-visitor',
	  `ip` varchar(20) NOT NULL,
	  `visited_date` datetime NOT NULL,
	  PRIMARY KEY (`id`),
	  KEY `ad_id` (`ad_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;
	

2) Copy the folder in the following directory 
    "project_name\application\modules\"
   If you cant find it, create a folder with name "module" in the application directory.
   
3)Create a folder named "uploads" in "project_name\assets\" directory. Then create a folder named "banner_ad_images" and sub folder "main" and "thumbs"
  If "uploads" already exits then just create folder "banner_ad_images" and subfolder "main" and "thumbs". This is for image upload.
  
4)Create a directory named "banner" in "\project_name\themes\default\js\modules" and put "jquery.slugify.js" in that directory.
If any folder is not there , create the hierarchy accordingly.

5)Create a directory named "banner" in "\project_name\themes\front\js\modules" and put "jquery.cycle.all.js" in that directory.
If any folder is not there , create the hierarchy accordingly.

6)Create a directory named "banner" in "\project_name\themes\front\css\modules" and put "banner.css" in that directory.
If any folder is not there , create the hierarchy accordingly.

Banner module is ready to use.