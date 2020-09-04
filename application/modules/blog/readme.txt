@author - Sagar Shah
@mail -sagarn.shah@sparsh.com
--------------installating the blog module--------------

1)Paste the following querries in your database. It will create all the required table for this module


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



   CREATE TABLE IF NOT EXISTS `blog_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blogpost_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0=Inactive,1=Active,-1=Deleted',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `blogpost_id` (`blogpost_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
	

2) Copy the folder in the following directory 
    "project_name\application\modules\"
   If you cant find it, create a folder with name "module" in the application directory.
   
3)Create a folder named "uploads" in "project_name\assets\" directory. Then create a folder named "blog_images"
  If "uploads" already exits then just create folder "blog_images" .
  
4)Create a directory named "products" in "\project_name\themes\default\js\modules" and put "jquery.slugify.js" in that directory.
If any folder is not there , create the hierarchy accordingly.

Product module is ready to use.