@author - Vivek Doshi
@mail -vivek.doshi@sparsh-technologies.co.in
@skype- tatva60
--------------installating the product module--------------

1)Paste the following querries in your database. It will create all the required table for this module


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
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


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
	

2) Copy the folder in the following directory 
    "project_name\application\modules\"
   If you cant find it, create a folder with name "module" in the application directory.
   
3)Create a folder named "uploads" in "project_name\assets\" directory. Then create a folder named "products" and sub folder "main" and "thumbs"
  If "uploads" already exits then just create folder "products" and subfolder "main" and "thumbs". This is for image upload.
  
4)Create a directory named "products" in "\project_name\themes\default\js\modules" and put "jquery.slugify.js" in that directory.
If any folder is not there , create the hierarchy accordingly.

Product module is ready to use.