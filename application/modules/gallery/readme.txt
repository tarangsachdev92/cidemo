@author - Vijay Gosai
@mail -vijay.gosai@sparsh.com

--------------installating the product module--------------

1)Paste the following querries in your database. It will create all the required table for this module


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;



2) Copy the folder in the following directory 
    "project_name\application\modules\gallery"
   
3)Create a folder named "uploads" in "project_name\assets\" directory. Then create a folder named "gallery_images" and sub folder "thumb"
  If "uploads" already exits then just create folder "gallery_images" and subfolder "thumb". This is for image upload.
  
4)Create a directory named "gallery" in "\projec_name\themes\front\js\modules" and put "image_gallery_nano_js" folder in that directory.
now all js files comes from this path "\projec_name\themes\front\js\modules\gallery\image_gallery_nano_js\..."
If any folder is not there , create the hierarchy accordingly.

5)Create a directory named "gallery" in "\projec_name\themes\front\css\modules" and put "image_gallery_nano" folder in that directory.
now all js files comes from this path "themes\front\css\modules\gallery\image_gallery_nano\.."
If any folder is not there , create the hierarchy accordingly.

6) add categories in gallery module from admin side from category module. This categories will display while adding images.

7) Upload images from admin side and you can see that images in front side.

gallery module is ready to use.