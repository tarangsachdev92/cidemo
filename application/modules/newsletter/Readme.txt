--------------Installating the Newsletter module--------------

1)Paste the following querries in your database. It will create all the required table for this module


CREATE TABLE IF NOT EXISTS `content_newsletters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;


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
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `updated_date` datetime NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

CREATE TABLE IF NOT EXISTS `subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `slug_url` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `updated_date` datetime NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

CREATE TABLE IF NOT EXISTS `templates_newsletters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_title` varchar(255) NOT NULL,
  `template_view_file` varchar(255) NOT NULL,
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `updated_date` datetime NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

2) Copy the folder in the following directory
    "project_name\application\modules\"
   If you cant find it, create a folder with name "module" in the application directory.

newsletter module is ready to use.

3) set cron job for automatic send newsletter 
	path : http://localhost/cidemo/tatvasoft/newsletter/send_all_newsletter
	
NOTE : Listed below files which are in the view directory is for Newsleter templates.
	1 - admin_view_template1
	2 - admin_view_template2
	3 - admin_view_template3