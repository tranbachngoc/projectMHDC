-- Date: 15/11/2018 Thuan - START
ALTER TABLE `tbtt_images` ADD `tags` TEXT NULL DEFAULT NULL AFTER `animation`;
-- END

-- Date: 26/11/2018 Thuan - START
ALTER TABLE `tbtt_product` ADD `pro_brand` VARCHAR(255) NULL AFTER `pro_of_shop`;
ALTER TABLE `tbtt_product` ADD `pro_protection` TINYINT(1) NOT NULL DEFAULT '0' AFTER `pro_brand`;
ALTER TABLE `tbtt_product` ADD `pro_specification` TEXT NULL AFTER `pro_protection`;
ALTER TABLE `tbtt_product` ADD `pro_attach` VARCHAR(500) NULL AFTER `pro_specification`;
ALTER TABLE `tbtt_detail_product` ADD `dp_weight` FLOAT NOT NULL DEFAULT '0' AFTER `dp_note`;
ALTER TABLE `tbtt_product` ADD `pro_made_in` VARCHAR(255) NULL AFTER `pro_attach`;
ALTER TABLE `tbtt_product` ADD `pro_manufacturer` VARCHAR(255) NULL AFTER `pro_made_in`;
-- END

-- Date: 04/12/2018 BaoTran - START
ALTER TABLE `tbtt_collection` ADD `isPublic` BOOLEAN NOT NULL DEFAULT FALSE AFTER `status`;
ALTER TABLE `tbtt_collection` ADD `type` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '1: content, 2: product' AFTER `isPublic`;


CREATE TABLE `azibai_home`.`tbtt_collection_product` ( 
	`cp_id` INT(11) NOT NULL AUTO_INCREMENT , 
	`cp_coll_id` INT(11) NOT NULL DEFAULT '0' , 
	`cp_user_id` INT(11) NOT NULL DEFAULT '0' , 
	`cp_pro_id` INT(11) NOT NULL DEFAULT '0' , 
	PRIMARY KEY (`cp_id`)
) ENGINE = InnoDB;
-- END

-- Date: 02/12/2018 Thành - START
ALTER TABLE `tbtt_user` ADD COLUMN `use_about` TEXT NULL AFTER `use_lng`;
-- END

-- Date: 09/12/2018 Thành - START
ALTER TABLE `tbtt_content`
ADD COLUMN `sho_id` INT NULL COMMENT 'xác định bài viết của doanh nghiệp' AFTER `not_posted_by`;
-- END

-- Date: 09/12/2018 Đức - START
DROP TABLE IF EXISTS `tbtt_custom_link`;
CREATE TABLE IF NOT EXISTS `tbtt_custom_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` tinytext COLLATE utf8_unicode_ci,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `save_link` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;
-- END
-- Date: 02/01/2019 Đức - START
ALTER TABLE `tbtt_custom_link` ADD `user_id` INT NOT NULL AFTER `type`;
-- END

-- Date: 02/01/2019 Tài - START
CREATE TABLE `azibai_home`.`tbtt_collection_link`(
  `cl_id` INT NOT NULL AUTO_INCREMENT,
  `cl_coll_id` INT NOT NULL DEFAULT 0,
  `cl_user_id` INT NOT NULL DEFAULT 0,
  `cl_customLink_id` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`cl_id`)
) ENGINE=INNODB CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `azibai_home`.`tbtt_collection`
  CHANGE `type` `type` TINYINT(1) DEFAULT 0  NOT NULL   COMMENT '1: content, 2: product, 3: link';

-- END

ALTER TABLE `azibai_home`.`tbtt_custom_link`
ADD COLUMN `sho_id` INT(11) NOT NULL AFTER `id`;

-- Date: 04/01/2019 Đức - START
DROP TABLE IF EXISTS `tbtt_videos`;
CREATE TABLE IF NOT EXISTS `tbtt_videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `width` int(100) NOT NULL DEFAULT '0',
  `height` int(100) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `thumbnail` VARCHAR(255) NOT NULL,
  `path` VARCHAR(100) NOT NULL,
  `create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;
-- END

-- Date: 06/01/2019 Đức - START
ALTER TABLE `azibai_home`.`tbtt_custom_link`   
  ADD COLUMN `detail` TINYTEXT NULL   COMMENT 'Tao n/dug link' AFTER `description`;
-- END

-- Date: 10/01/2019 Thuận - START
ALTER TABLE `tbtt_images` 
  ADD `img_w` INT(11) NOT NULL DEFAULT '0' AFTER `created_at`, 
  ADD `img_h` INT(11) NOT NULL DEFAULT '0' AFTER `img_w`, 
  ADD `img_type` VARCHAR(255) NULL AFTER `img_h`;

 -- Date 21/1/2019 Thuan
DROP TABLE IF EXISTS `tbtt_pro_gallery_detail`;
CREATE TABLE IF NOT EXISTS `tbtt_pro_gallery_detail` (
  `id` INT NOT NULL AUTO_INCREMENT , 
  `user_id` INT NOT NULL , 
  `pro_id` INT NOT NULL DEFAULT '0' , 
  `gallery_id` INT NOT NULL DEFAULT '0' , 
  `link` VARCHAR(255) NOT NULL , 
  `img_dir` VARCHAR(255) NOT NULL , 
  `detail_w` INT NOT NULL DEFAULT '0' , 
  `detail_h` INT NOT NULL DEFAULT '0' , 
  `detail_type` VARCHAR(255) NULL DEFAULT NULL , 
  `thumbnail` VARCHAR(255) NULL DEFAULT NULL , 
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;


DROP TABLE IF EXISTS `tbtt_pro_gallery`;
CREATE TABLE IF NOT EXISTS `tbtt_pro_gallery` (
  `id` INT(11) NOT NULL AUTO_INCREMENT , 
  `user_id` INT(11) NOT NULL , 
  `pro_id` INT(11) NOT NULL DEFAULT '0' , 
  `name` VARCHAR(255) NOT NULL , 
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;

-- END

-- Date: 21/01/2019 Tài - START
ALTER TABLE `azibai_home`.`tbtt_collection`   
  CHANGE `avatar` `avatar` VARCHAR(250) CHARSET utf8 COLLATE utf8_unicode_ci NULL;
-- END

-- Date: 31/01/2019 chị Phượng - START
ALTER TABLE  `tbtt_collection` ADD  `sho_id` INT NOT NULL DEFAULT  '0';
-- END

-- Date 13/02/2018 Thuận
ALTER TABLE `tbtt_pro_gallery_detail` ADD `caption` VARCHAR(500) NULL AFTER `thumbnail`;
-- END


-- Date 19/02/2018 Thuận

ALTER TABLE `tbtt_order` CHANGE `shipping_fee` `shipping_fee` FLOAT NOT NULL DEFAULT '0';

DROP TABLE IF EXISTS `tbtt_like_content`;
CREATE TABLE IF NOT EXISTS `tbtt_like_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `not_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;

-- END

-- Date 21/02/2018 Tài

ALTER TABLE `tbtt_user`   
  CHANGE `use_address` `use_address` VARCHAR(100) CHARSET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';

-- END
-- Date 25/02/2018 Thuận

DROP TABLE IF EXISTS `tbtt_like_product`;
CREATE TABLE IF NOT EXISTS `tbtt_like_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;

-- END
-- Date 25/02/2018 Tài
ALTER TABLE `tbtt_user`   
  CHANGE `use_fullname` `use_fullname` VARCHAR(100) CHARSET utf8 COLLATE utf8_general_ci DEFAULT ''  NOT NULL;
-- END
-- Date 27/02/2018 Thuận

DROP TABLE IF EXISTS `tbtt_like_gallery`;
CREATE TABLE IF NOT EXISTS `tbtt_like_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;

-- END
CREATE TABLE IF NOT EXISTS `tbtt_like_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;
-- Date 06/03/2018 Thuận
CREATE TABLE IF NOT EXISTS `tbtt_like_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;
-- END

-- Thành 06/03/2019----------
ALTER TABLE `tbtt_user` ADD COLUMN `use_link` VARCHAR(100) NULL AFTER `use_about`;
ALTER TABLE `tbtt_user` ADD COLUMN `use_slug` VARCHAR(100) NULL COMMENT 'đoạn slug link của user \\nurl: azibai.com/profile/use_slug/' AFTER `use_link`;

UPDATE `tbtt_user` SET`use_slug` = `use_id` WHERE `use_id` > 0;

-- END
-- Date 08/03/2018 Thuận
CREATE TABLE IF NOT EXISTS `tbtt_user_friend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `add_friend_by` int(11) NOT NULL,
  `accept` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;
-- END
-- Date 11/03/2018 Thuận
CREATE TABLE IF NOT EXISTS `tbtt_user_follow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `follower` int(10) unsigned NOT NULL,
  `hasFollow` tinyint(1) NOT NULL DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;COMMIT;
-- END

-- Date 12/03/2018 Thuận
ALTER TABLE `tbtt_user` CHANGE `use_auth_token` `use_auth_token` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
-- END

-- Date 15/03/2018 Thuận
ALTER TABLE `tbtt_product_affiliate_user`
CHANGE COLUMN `kind_of_aff` `kind_of_aff` TINYINT(2) NOT NULL DEFAULT 0 ;
-- END

-- Date 19/03/2019 Tài
CREATE TABLE `tbtt_album_media`(
  `album_id` INT NOT NULL AUTO_INCREMENT,
  `album_name` VARCHAR(250) NOT NULL,
  `album_image` VARCHAR(250) NOT NULL,
  `album_path_image` VARCHAR(250) NOT NULL,
  `album_type` TINYINT NOT NULL DEFAULT 0 COMMENT '1/image-2/product-3/video-4/coupon',
  `album_status` TINYINT NOT NULL DEFAULT 0 COMMENT '0/deactive - 1/active',
  `ref_id` INT NOT NULL DEFAULT 0,
  `ref_type` INT NOT NULL DEFAULT 0 COMMENT '1/image-2/product-3/video-4/coupon',
  PRIMARY KEY (`album_id`)
) ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `tbtt_album_media`
  ADD COLUMN `ref_shop_id` INT DEFAULT 0  NULL   COMMENT '0/cá nhân - !=0 Doanh nghiệp' AFTER `ref_type`;-- END
ALTER TABLE `tbtt_album_media`
  CHANGE `ref_id` `ref_id` TINYTEXT NULL   COMMENT 'String - json';
-- END

-- Thành 19/03/2019
ALTER TABLE `tbtt_custom_link`
ADD COLUMN `tbtt_category_link_id` INT(11) NULL COMMENT 'danh mục liên kết' AFTER `id`;

ALTER TABLE `tbtt_videos`
ADD COLUMN `sho_id` INT(11) NULL DEFAULT 0 AFTER `height`;

ALTER TABLE  `tbtt_user` CHANGE  `use_birthday`  `use_birthday` DATE NULL;
-- END

-- Thành 21/03/2019
ALTER TABLE `tbtt_category_links`
ADD COLUMN `status` TINYINT(1) NULL DEFAULT 0 AFTER `slug`;
-- END

-- Phượng 21/03/2019
ALTER TABLE  `tbtt_user` CHANGE  `website`  `website` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE  `tbtt_user` CHANGE  `use_address`  `use_address` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT  '';
ALTER TABLE  `tbtt_user` CHANGE  `use_fullname`  `use_fullname` VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE  `tbtt_user` ADD  `use_religion` VARCHAR( 50 ) NULL;
ALTER TABLE  `tbtt_user` ADD  `use_hometown` VARCHAR( 200 ) NULL;
-- END

-- Thành 21/03/2019
ALTER TABLE`tbtt_custom_link`
CHANGE COLUMN `tbtt_category_link_id` `tbtt_category_link_id` INT(11) NULL DEFAULT 0 COMMENT 'danh mục liên kết' ;
-- END

-- Thành 26/03/2019
ALTER TABLE  `tbtt_user` CHANGE  `use_religion`  `use_religion` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;

ALTER TABLE `tbtt_user` CHANGE COLUMN `use_hometown` `use_home_town` VARCHAR(200) NULL DEFAULT NULL ;

ALTER TABLE `tbtt_user` add column `saved_token` text;

ALTER TABLE `tbtt_custom_link` DROP COLUMN `tbtt_category_link_id`;

CREATE TABLE IF NOT EXISTS `tbtt_user_categories` (
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `tbtt_shop` CHANGE COLUMN `sho_province` `sho_province` INT(11) NULL DEFAULT '0' , CHANGE COLUMN `sho_district` `sho_district` VARCHAR(11) NULL DEFAULT NULL ;

CREATE TABLE IF NOT EXISTS `tbtt_music` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `music_name` varchar(255) DEFAULT NULL,
  `music_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=27 ;

--
-- Dumping data for table `tbtt_music`
--

INSERT INTO `tbtt_music` (`id`, `music_name`, `music_path`) VALUES
(1, 'Children Fun Party ', 'Children Fun Party .mp3'),
(2, 'Chucky the Construction Worker Stings', 'Chucky_the_Construction_Worker_Stings.mp3'),
(3, 'cinemactic', 'cinemactic.mp3'),
(4, 'Contra Twin Guitar Meta', 'Contra_Twin_Guitar_Meta.mp3'),
(5, 'Do Do Do', 'Do_Do_Do.mp3'),
(6, 'Epic Adventure', 'epic adventure.mp3'),
(7, 'Epic Technology', 'epic technology.mp3'),
(8, 'Lahabana', 'file B.mp3'),
(9, 'Flutey Sting', 'Flutey_Sting.mp3'),
(10, 'Golly Gee', 'Golly_Gee.mp3'),
(11, 'Guantanamera Rumba', 'GUANTANAMERA RUMBA.mp3'),
(12, 'Hall Of Frame', 'hall of frame.mp3'),
(13, 'High Tension', 'High_Tension.mp3'),
(14, 'Home Base Groove', 'Home_Base_Groove.mp3'),
(15, 'Inspiration Kit', 'inspiration-kit.mp3'),
(16, 'Inspirational Piano ', 'Inspirational Piano .mp3'),
(17, 'Inspirational Piano short V', 'Inspirational Piano short V.mp3'),
(18, 'New Horizons', 'New Horizons.mp3'),
(19, 'Rise of Saturn', 'Rise of Saturn.mp3'),
(20, 'Rock Intro 2', 'Rock_Intro_2.mp3'),
(21, 'Scissor Snips', 'Scissor_Snips.mp3'),
(22, 'Slow Typing', 'Slow_Typing.mp3'),
(23, 'Splashing Around', 'Splashing_Around.mp3'),
(24, 'tatreal tech', 'tatreal tech.mp3'),
(25, 'The Master', 'The_Master.mp3'),
(26, 'Young And Old Know Love', 'Young_And_Old_Know_Love.mp3');

CREATE TABLE IF NOT EXISTS `tbtt_user_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(150) NOT NULL,
  `province_id` int(11) NOT NULL,
  `position` varchar(150) NOT NULL,
  `from` date NOT NULL,
  `to` date DEFAULT NULL,
  `to_present` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 => da nghi viec, 1 => dang lam viec',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

CREATE TABLE IF NOT EXISTS `tbtt_user_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sayings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `hobby` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `skills` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

CREATE TABLE IF NOT EXISTS `tbtt_user_maritals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `marital_status` int(11) NOT NULL COMMENT '1 => độc thân, 2 => đã kết hôn, 3 => đang tìm hiểu',
  `with` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hobby` int(11) NOT NULL COMMENT '1 => Nam, 2 => Nữ, 3 => Cả nam và nữ',
  `want_to_marry` tinyint(1) NOT NULL COMMENT '0 => không, 1 => có',
  `has_children` tinyint(1) NOT NULL COMMENT '0 => không, 1 => có',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
-- END

-- Tài 28/03/2019
ALTER TABLE `tbtt_album_media`
  ADD COLUMN `album_path_full` VARCHAR(250) NULL AFTER `album_path_image`,
  ADD COLUMN `ref_user` INT(11) DEFAULT 0  NOT NULL AFTER `ref_shop_id`;
  CHANGE `album_status` `album_status` TINYINT(4) DEFAULT 1  NOT NULL   COMMENT '0/deactive - 1/active',
  ADD COLUMN `album_permission` TINYINT(4) DEFAULT 1  NOT NULL   COMMENT '1/public - 2/friend - 3/only me' AFTER `album_status`;
  CHANGE `ref_id` `ref_id` TEXT CHARSET utf8 COLLATE utf8_unicode_ci NULL   COMMENT 'String - json';
ALTER TABLE `tbtt_images`
  ADD COLUMN `ref_album_id` TEXT NULL   COMMENT 'String - json' AFTER `updated_at`,
  ADD COLUMN `img_up_detect` TINYINT DEFAULT 0  NOT NULL   COMMENT '1/hình up từ library' AFTER `ref_album_id`,
  ADD COLUMN `img_library_dir` VARCHAR(50) NULL   COMMENT 'dir hình úp từ library' AFTER `img_up_detect`,
  ADD COLUMN `img_library_title` VARCHAR(250) NULL AFTER `img_library_dir`;
-- END

-- Tài 01/04/2019
ALTER TABLE `tbtt_images`
  ADD COLUMN `ref_shop_id_upload` INT DEFAULT 0  NOT NULL   COMMENT '0/cá nhân - !=0/doanh nghiệp' AFTER `ref_album_id`;-- END

--  Thành 29/03/2019
delimiter #
create trigger duplicateLibraryLink after insert on tbtt_custom_link
	for each row
	begin
		insert into tbtt_library_links
        (custom_link_id, user_id, sho_id, title, description, detail, image, save_link, host, created_at, updated_at) values
        (new.id, new.user_id, new.sho_id, new.title, new.description, new.detail, new.image, new.save_link, new.host, new.create, new.update);
	end#
delimiter ;
-- END

-- Date: 02/04/2019 Tai - START
DROP TABLE IF EXISTS `tbtt_album_media`;
CREATE TABLE IF NOT EXISTS `tbtt_album_media`(
  `album_id` INT(11) NOT NULL AUTO_INCREMENT,
  `album_name` VARCHAR(250) NOT NULL,
  `album_image` VARCHAR(250) NOT NULL,
  `album_path_image` VARCHAR(250) NOT NULL,
  `album_path_full` VARCHAR(250),
  `album_type` TINYINT(4) NOT NULL COMMENT '1/image-2/product-3/video-4/coupon',
  `album_status` TINYINT(4) NOT NULL COMMENT '0/deactive - 1/active',
  `album_permission` TINYINT(4) NOT NULL COMMENT '1/public - 2/friend - 3/only me',
  `ref_user` INT(11),
  `ref_shop_id` INT(11) COMMENT '0/cá nhân - !=0 Doanh nghiệp',
  PRIMARY KEY (`album_id`)
) ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `tbtt_album_media_detail`;
CREATE TABLE IF NOT EXISTS `tbtt_album_media_detail`(
  `ref_album_id` INT NOT NULL,
  `ref_item_id` INT NOT NULL,
  `ref_user` INT NOT NULL,
  `ref_shop_id` INT NOT NULL
) ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `tbtt_images` DROP COLUMN IF EXISTS `ref_album_id`;
ALTER TABLE `tbtt_images` DROP COLUMN IF EXISTS `ref_shop_id_upload`;
ALTER TABLE `tbtt_images`   
  ADD COLUMN `img_up_by_shop` INT(11) DEFAULT 0  NULL   COMMENT '0/Cá nhân - !=0 doanh nghiệp' AFTER `img_up_detect`;
-- END

--  Thành 02/04/2019
DROP TABLE IF EXISTS `tbtt_bookmark_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tbtt_bookmark_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `sho_id` int(11) DEFAULT '0',
  `link` varchar(1000) NOT NULL,
  `name` varchar(455) CHARACTER SET latin1 DEFAULT NULL,
  `icon` varchar(455) CHARACTER SET latin1 DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
--  END

--  Tài 04/04/2019
ALTER TABLE `tbtt_album_media`
  ADD COLUMN `album_offset_top` TINYINT DEFAULT 0  NULL AFTER `album_permission`;
ALTER TABLE `tbtt_album_media`
  ADD COLUMN `album_created` DATETIME DEFAULT CURRENT_TIMESTAMP  NOT NULL AFTER `album_offset_top`,
  ADD COLUMN `album_updated` DATETIME DEFAULT CURRENT_TIMESTAMP  NOT NULL AFTER `album_created`;
ALTER TABLE `tbtt_album_media`
  ADD COLUMN `album_description` VARCHAR(250) NULL AFTER `album_name`;

ALTER TABLE `tbtt_bookmark_links`
CHANGE COLUMN `user_id` `user_id` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `sho_id` `sho_id` INT(11) NULL DEFAULT 0 ;

ALTER TABLE `tbtt_category_links`
ADD COLUMN `ordering` INT NULL DEFAULT 0 AFTER `parent_id`;

--  END
--  Thành 08/04/2019
ALTER TABLE `tbtt_library_links`
ADD COLUMN `created_by` INT(11) NULL DEFAULT 0 AFTER `updated_at`,
ADD COLUMN `updated_by` INT(11) NULL DEFAULT 0 AFTER `created_by`;

ALTER TABLE `tbtt_collection_link`
CHANGE COLUMN `cl_customLink_id` `cl_customLink_id` INT(11) NULL DEFAULT '0' ;

--  END

--  Thuận 10/04/2019
ALTER TABLE `tbtt_detail_product` CHANGE `dp_weight` `dp_weight` FLOAT NULL DEFAULT '0';
--  END

--  Thành 11/04/2019
ALTER TABLE `tbtt_bookmark_links`
CHANGE COLUMN `link` `link` TEXT NOT NULL ;

DROP TABLE IF EXISTS `tbtt_library_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tbtt_library_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `sho_id` int(11) DEFAULT '0',
  `custom_link_id` int(11) DEFAULT NULL COMMENT 'map id voi bang custom link',
  `category_link_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `title` varchar(255) DEFAULT NULL,
  `description` tinytext,
  `detail` text,
  `image` text,
  `image_upload` text,
  `image_width` int(11) DEFAULT '0',
  `image_height` int(11) DEFAULT '0',
  `save_link` tinytext,
  `host` varchar(455) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `updated_by` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=utf8mb4;

ALTER TABLE `tbtt_library_links`
CHANGE COLUMN `user_id` `user_id` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `sho_id` `sho_id` INT(11) NULL DEFAULT 0 ;
--  END

--  Thành 12/04/2019
DROP TABLE IF EXISTS `tbtt_category_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tbtt_category_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT '0',
  `ordering` int(11) DEFAULT '0',
  `name` varchar(455) NOT NULL,
  `slug` varchar(455) CHARACTER SET latin1 DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbtt_category_links`
--

LOCK TABLES `tbtt_category_links` WRITE;
/*!40000 ALTER TABLE `tbtt_category_links` DISABLE KEYS */;
INSERT INTO `tbtt_category_links` VALUES (1,0,0,'thể thao','the-thao',1,NULL,NULL,NULL,NULL),(2,1,0,'bóng đá','bong-da',1,NULL,NULL,NULL,NULL),(3,1,0,'bóng rổ','bong-ro',1,NULL,NULL,NULL,NULL),(4,1,0,'tennis','tennis',1,NULL,NULL,NULL,NULL),(5,1,0,'võ thuật','vo-thuat',1,NULL,NULL,NULL,NULL),(6,1,0,'tốc độ','toc-do',1,NULL,NULL,NULL,NULL),(7,1,0,'môn thể thao khác','mon-the-thao-khac',1,NULL,NULL,NULL,NULL),(8,0,0,'kinh doanh','kinh-doanh',1,NULL,NULL,NULL,NULL),(9,8,0,'bất động sản','bat-dong-san',1,NULL,NULL,NULL,NULL),(10,8,0,'chứng khoán','chung-khoan',1,NULL,NULL,NULL,NULL),(11,8,0,'tài chính - ngân hàng','tai-chinh-ngan-hang',1,NULL,NULL,NULL,NULL),(12,8,0,'thương mại điện tử','thuong-mai-dien-tu',1,NULL,NULL,NULL,NULL),(13,8,0,'hàng hóa thị trường','hang-hoa-thi-truong',1,NULL,NULL,NULL,NULL),(14,8,0,'doanh nghiệp - start up','doanh-nghiep-start-up',1,NULL,NULL,NULL,NULL),(15,0,0,'giải trí','giai-tri',1,NULL,NULL,NULL,NULL),(16,15,0,'sao việt','sao-viet',1,NULL,NULL,NULL,NULL),(17,15,0,'sao châu á','sao-chau-a',1,NULL,NULL,NULL,NULL),(18,15,0,'sao thế giới','sao-the-gioi',1,NULL,NULL,NULL,NULL),(19,15,0,'phim','phim',1,NULL,NULL,NULL,NULL),(20,15,0,'nhạc','nhac',1,NULL,NULL,NULL,NULL),(21,15,0,'sân khấu - truyền hình','san-khau-truyen-hinh',1,NULL,NULL,NULL,NULL),(22,15,0,'mỹ thuật - điêu khắc','my-thuat-dieu-khac',1,NULL,NULL,NULL,NULL),(23,15,0,'sách thơ ca','sach-tho-ca',1,NULL,NULL,NULL,NULL),(24,15,0,'nhiếp ảnh','nhiep-anh',1,NULL,NULL,NULL,NULL),(25,0,0,'thời trang làm đẹp','thoi-trang-lam-dep',1,NULL,NULL,NULL,NULL),(26,25,0,'thời trang nam','thoi-trang-nam',1,NULL,NULL,NULL,NULL),(27,25,0,'thời trang nữ','thoi-trang-nu',1,NULL,NULL,NULL,NULL),(28,25,0,'nghệ thuật cắm hoa','nghe-thuat-cam-hoa',1,NULL,NULL,NULL,NULL),(29,25,0,'làm đẹp phái nữ','lam-dep-phai-nu',1,NULL,NULL,NULL,NULL),(30,0,0,'ẩm thực','am-thuc',1,NULL,NULL,NULL,NULL),(31,30,0,'việt nam','viet-nam',1,NULL,NULL,NULL,NULL),(32,30,0,'châu á','chau-a',1,NULL,NULL,NULL,NULL),(33,30,0,'thế giới','the-gioi',1,NULL,NULL,NULL,NULL),(34,0,0,'du lịch','du-lich',1,NULL,NULL,NULL,NULL),(35,34,0,'việt nam','viet-nam',1,NULL,NULL,NULL,NULL),(36,34,0,'châu á','chau-a',1,NULL,NULL,NULL,NULL),(37,34,0,'thế giới','the-gioi',1,NULL,NULL,NULL,NULL),(38,34,0,'cẩm nang – tư vấn','cam-nang-tu-van',1,NULL,NULL,NULL,NULL),(39,0,0,'thế giới','the-gioi',1,NULL,NULL,NULL,NULL),(40,0,0,'xã hội việt nam và pháp luật','xa-hoi-viet-nam-va-phap-luat',1,NULL,NULL,NULL,NULL),(41,0,0,'giáo dục','giao-duc',1,NULL,NULL,NULL,NULL),(42,41,0,'người việt trẻ','nguoi-viet-tre',1,NULL,NULL,NULL,NULL),(43,41,0,' du học','du-hoc',1,NULL,NULL,NULL,NULL),(44,41,0,' tuyển sinh trong nước ','tuyen-sinh-trong-nuoc',1,NULL,NULL,NULL,NULL),(45,41,0,' tri thức thường nhật','tri-thuc-thuong-nhat',1,NULL,NULL,NULL,NULL),(46,41,0,' lời hay ý đẹp','loi-hay-y-dep',1,NULL,NULL,NULL,NULL),(47,41,0,' nuôi dạy trẻ nhỏ','nuoi-day-tre-nho',1,NULL,NULL,NULL,NULL),(48,0,0,'kiến trúc và xây dựng','kien-truc-va-xay-dung',1,NULL,NULL,NULL,NULL),(49,48,0,'nhà hiện đại','nha-hien-dai',1,NULL,NULL,NULL,NULL),(50,48,0,' trang trí nhà cửa','trang-tri-nha-cua',1,NULL,NULL,NULL,NULL),(51,48,0,' văn hóa kiến trúc','van-hoa-kien-truc',1,NULL,NULL,NULL,NULL),(52,48,0,' kiến trúc văn phòng','kien-truc-van-phong',1,NULL,NULL,NULL,NULL),(53,48,0,' phong thủy nhà cửa','phong-thuy-nha-cua',1,NULL,NULL,NULL,NULL),(54,48,0,' tư vấn và cẩm nang','tu-van-va-cam-nang',1,NULL,NULL,NULL,NULL),(55,0,0,'sức khỏe','suc-khoe',1,NULL,NULL,NULL,NULL),(56,55,0,'y học','y-hoc',1,NULL,NULL,NULL,NULL),(57,55,0,' mẹo điều trị bệnh','meo-dieu-tri-benh',1,NULL,NULL,NULL,NULL),(58,55,0,' dinh dưỡng bổ sung','dinh-duong-bo-sung',1,NULL,NULL,NULL,NULL),(59,55,0,' tập luyện','tap-luyen',1,NULL,NULL,NULL,NULL),(96,0,0,'xe','xe',1,NULL,NULL,NULL,NULL),(97,96,0,'xe moto','xe-moto',1,NULL,NULL,NULL,NULL),(98,96,0,' xe hơi','xe-hoi',1,NULL,NULL,NULL,NULL),(99,96,0,' bảng giá thị trường','bang-gia-thi-truong',1,NULL,NULL,NULL,NULL),(100,96,0,' kinh nghiệm hỏi đáp','kinh-nghiem-hoi-dap',1,NULL,NULL,NULL,NULL),(101,0,0,'số hóa công nghệ','so-hoa-cong-nghe',1,NULL,NULL,NULL,NULL),(102,101,0,'thiết bị công nghệ','thiet-bi-cong-nghe',1,NULL,NULL,NULL,NULL),(103,101,0,' điện tử gia dụng','dien-tu-gia-dung',1,NULL,NULL,NULL,NULL),(104,101,0,' thủ thuật','thu-thuat',1,NULL,NULL,NULL,NULL),(105,101,0,' kinh nghiệm hỏi đáp','kinh-nghiem-hoi-dap',1,NULL,NULL,NULL,NULL),(106,101,0,' game','game',1,NULL,NULL,NULL,NULL),(107,101,0,' chuyện công nghệ','chuyen-cong-nghe',1,NULL,NULL,NULL,NULL),(108,0,0,'khoa học tự nhiên','khoa-hoc-tu-nhien',1,NULL,NULL,NULL,NULL),(109,108,0,'thường thức','thuong-thuc',1,NULL,NULL,NULL,NULL),(110,108,0,' chuyện lạ','chuyen-la',1,NULL,NULL,NULL,NULL),(111,108,0,' giải mã hiện tượng','giai-ma-hien-tuong',1,NULL,NULL,NULL,NULL),(112,108,0,' khám phá thiên nhiên','kham-pha-thien-nhien',1,NULL,NULL,NULL,NULL),(113,0,0,'đời sống','doi-song',1,NULL,NULL,NULL,NULL),(114,113,0,'lối sống trẻ ','loi-song-tre',1,NULL,NULL,NULL,NULL),(115,113,0,' xây dựng tổ tấm','xay-dung-to-tam',1,NULL,NULL,NULL,NULL),(116,113,0,' tâm sự bốn phương','tam-su-bon-phuong',1,NULL,NULL,NULL,NULL),(117,113,0,' vật nuôi','vat-nuoi',1,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbtt_category_links` ENABLE KEYS */;
UNLOCK TABLES;
--  END


ALTER TABLE `tbtt_custom_link` ADD COLUMN `status` TINYINT(1) NULL DEFAULT 1 AFTER `update`;

UPDATE `tbtt_custom_link` SET `status` = 1 WHERE `id` > 0;

ALTER TABLE `tbtt_library_links` ADD COLUMN `not_id` INT(11) NULL DEFAULT 0 AFTER `updated_by`;


-- Thuận 4-13-2019
CREATE TABLE `azibai_home`.`tbtt_user_order_receive` ( 
  `id` INT NOT NULL AUTO_INCREMENT , 
  `use_id` INT NOT NULL , 
  `name` VARCHAR(255) NOT NULL , 
  `address` VARCHAR(500) NOT NULL , 
  `district` INT NOT NULL DEFAULT '0' , 
  `province` INT NOT NULL DEFAULT '0' , 
  `semail` VARCHAR(255) NOT NULL , 
  `phone` VARCHAR(20) NOT NULL , 
  `active` TINYINT(1) NOT NULL DEFAULT '0' , 
  `created_at` DATETIME NULL , 
  `updated_at` DATETIME NULL , 
  PRIMARY KEY (`id`)
) ENGINE = MyISAM;
-- END

-- Thuận 4-17-2019
ALTER TABLE `tbtt_user_order_receive` ADD `full_address` VARCHAR(600) NULL AFTER `address`;
-- END

-- Duc 4-18-2019
ALTER TABLE `tbtt_custom_link` ADD `image_path` TEXT NULL AFTER `image`;
ALTER TABLE `tbtt_custom_link` ADD `image_type` VARCHAR(50) NULL AFTER `image_path`;
ALTER TABLE `tbtt_custom_link` ADD `video_path` TEXT NULL AFTER `image_path`;
ALTER TABLE `tbtt_custom_link` ADD `image_width` INT NOT NULL DEFAULT '0' AFTER `image`, ADD `image_height` INT NOT NULL DEFAULT '0' AFTER `image_width`;
ALTER TABLE `tbtt_custom_link` CHANGE `image_type` `media_type` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
-- END

-- Chị Phượng 17-04-2019
ALTER TABLE  `tbtt_content` CHANGE  `not_description`  `not_description` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
-- END

--  Thành 18/04/2019
ALTER TABLE `tbtt_library_links`
ADD COLUMN `image_upload_dir` VARCHAR(455) NULL AFTER `image_upload`;
-- END

-- Chị Phượng 17-04-2019
ALTER TABLE  `tbtt_custom_link` CHANGE  `description`  `description` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
ALTER TABLE  `tbtt_custom_link` CHANGE  `detail`  `detail` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT  'Tao n/dug link';
-- END

--  Thành 19/04/2019
ALTER TABLE `tbtt_category_links`
ADD COLUMN `image` TINYTEXT NULL AFTER `status`;

ALTER TABLE `tbtt_category_links`
CHANGE COLUMN `slug` `slug` VARCHAR(455) CHARACTER SET 'latin1' NOT NULL ;

-- END

--  Chị Phượng  20/04/2019
ALTER TABLE  `tbtt_content` CHANGE  `not_title`  `not_title` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
-- END

-- Date 23/4/2018 Ngọc
CREATE TABLE IF NOT EXISTS `tbtt_shop_follow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned NOT NULL,
  `follower` int(10) unsigned NOT NULL,
  `hasFollow` tinyint(1) NOT NULL DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;COMMIT;
-- END

-- Date 26/4/2018 Tài
ALTER TABLE `tbtt_collection`
  ADD COLUMN `avatar_path` VARCHAR(250) NULL AFTER `avatar`;
-- END
-- Date 25/4/2018 Chị Phượng
CREATE TABLE IF NOT EXISTS `tbtt_user_social_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `blocked_by` int(11) NOT NULL,
  `blocked_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

ALTER TABLE `tbtt_user_follow`
ADD COLUMN `priority` TINYINT(1) NULL DEFAULT 0 AFTER `hasFollow`;

-- END

-- Date 02/05/2018 Chị Phượng
ALTER TABLE  `tbtt_custom_link` ADD  `orientation` INT NOT NULL DEFAULT 0 AFTER  `image_height`
ALTER TABLE  `tbtt_images` ADD  `orientation` INT NOT NULL DEFAULT 0 AFTER  `img_type`
-- END
-- Date 03/05/2018 Chị Phượng
ALTER TABLE `tbtt_custom_link` CHANGE `description` `description` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
-- END

-- Date 06/05/2018 Tài
ALTER TABLE `tbtt_collection`   
  ADD COLUMN `orientation` INT DEFAULT 0  NULL AFTER `sho_id`,
  ADD COLUMN `img_w` INT DEFAULT 0  NULL AFTER `orientation`,
  ADD COLUMN `img_h` INT DEFAULT 0  NULL AFTER `img_w`;
ALTER TABLE `tbtt_collection`
  ADD COLUMN `ref_category_id` INT DEFAULT 0  NULL AFTER `img_h`;
-- END

-- Date 07/05/2018 Chị Phượng
ALTER TABLE `tbtt_custom_link`
CHANGE COLUMN `title` `title` TEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL ,
CHANGE COLUMN `description` `description` TEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL ,
CHANGE COLUMN `detail` `detail` TEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL COMMENT 'Tao n/dug link' ,
CHANGE COLUMN `image` `image` TEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL ,
CHANGE COLUMN `save_link` `save_link` TINYTEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NOT NULL ;
-- END
-- Date 06/05/2018 Đức
DROP TABLE IF EXISTS `tbtt_affiliate_level`;
CREATE TABLE IF NOT EXISTS `tbtt_affiliate_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;
ALTER TABLE `tbtt_user` ADD `affiliate_level` INT NOT NULL DEFAULT '0' AFTER `use_about`;
INSERT INTO `tbtt_affiliate_level` (`id`, `name`, `created_at`, `updated_at`) VALUES (NULL, 'Level 1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), (NULL, 'Level 2', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `tbtt_affiliate_level` (`id`, `name`, `created_at`, `updated_at`) VALUES (NULL, 'Level 3', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
DROP TABLE IF EXISTS `tbtt_affiliate_price`;
CREATE TABLE IF NOT EXISTS `tbtt_affiliate_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `cost` bigint(20) NOT NULL,

-- Date 09/05/2018 Chị Phượng
ALTER TABLE  `tbtt_lib_links` ADD  `is_public` TINYINT( 1 ) NOT NULL DEFAULT  '1' AFTER  `orientation`;
ALTER TABLE  `tbtt_content_links` ADD  `is_public` TINYINT( 1 ) NOT NULL DEFAULT  '1' AFTER  `orientation`;
ALTER TABLE  `tbtt_content_image_links` ADD  `is_public` TINYINT( 1 ) NOT NULL DEFAULT  '1' AFTER  `orientation`;
ALTER TABLE  `tbtt_collection` ADD  `cate_id` INT NOT NULL DEFAULT  '0' COMMENT  'Danh mục nằm ở nhiều table khác nhau';
ALTER TABLE  `tbtt_lib_links` ADD COLUMN `orientation` INT NULL DEFAULT 0 AFTER `mime`;
ALTER TABLE  `tbtt_content_links` ADD COLUMN `orientation` INT NULL DEFAULT 0 AFTER `mime`;
ALTER TABLE  `tbtt_content_image_links` ADD COLUMN `orientation` INT NULL DEFAULT 0 AFTER `mime`;

-- END
--10/05/2019 Ngọc
DROP TABLE IF EXISTS `tbtt_metatag_share`;
CREATE TABLE IF NOT EXISTS `tbtt_metatag_share` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `use_id` int(10) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(1) NULL,
  `item_id` int(10) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

COMMIT;DROP TABLE IF EXISTS `tbtt_affiliate_level`;
CREATE TABLE IF NOT EXISTS `tbtt_affiliate_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;
ALTER TABLE `tbtt_user` ADD `affiliate_level` INT NOT NULL DEFAULT '0' AFTER `use_about`;
INSERT INTO `tbtt_affiliate_level` (`id`, `name`, `created_at`, `updated_at`) VALUES (NULL, 'Level 1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), (NULL, 'Level 2', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `tbtt_affiliate_level` (`id`, `name`, `created_at`, `updated_at`) VALUES (NULL, 'Level 3', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
DROP TABLE IF EXISTS `tbtt_affiliate_price`;
CREATE TABLE IF NOT EXISTS `tbtt_affiliate_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `cost` bigint(20) NOT NULL,
  `discount_price` bigint(20) NOT NULL,
  `user_set` bigint(20) NOT NULL,
  `user_app` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;

-- END

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;COMMIT;

--
ALTER TABLE `tbtt_content_image_links`
ADD COLUMN `content_id` INT(11) NULL DEFAULT 0 AFTER `id`;

--15/05/2019 Chị Phượng
ALTER TABLE  `tbtt_links` ADD  `min_id` INT NULL AFTER  `img_height` ,
ADD  `tbl_min` VARCHAR( 100 ) NULL AFTER  `min_id` ,
ADD  `max_id` INT NULL AFTER  `tbl_min` ,
ADD  `tbl_max` VARCHAR( 100 ) NULL AFTER  `max_id`;
-- END

DELETE FROM `tbtt_master_shop_rule` WHERE `tbtt_master_shop_rule`.`id` = 48;
INSERT INTO `tbtt_master_shop_rule` (`id`, `type`, `content`) VALUES (NULL, '7', 'Không cần kiểm duyệt bài viết và sản phẩm , phiếu mua hàng đối với chi nhánh này');
ALTER TABLE `tbtt_master_shop_rule` ADD `order_by` INT NULL DEFAULT '0' AFTER `content`;

ALTER TABLE `tbtt_links`
ADD COLUMN `link` TEXT NOT NULL AFTER `id`;

UPDATE `tbtt_master_shop_rule` SET `order_by` = '1' WHERE `tbtt_master_shop_rule`.`id` = 50;
UPDATE `tbtt_master_shop_rule` SET `order_by` = '2' WHERE `tbtt_master_shop_rule`.`id` = 51;
UPDATE `tbtt_master_shop_rule` SET `order_by` = '3' WHERE `tbtt_master_shop_rule`.`id` = 47;
UPDATE `tbtt_master_shop_rule` SET `order_by` = '4' WHERE `tbtt_master_shop_rule`.`id` = 49;
UPDATE `tbtt_master_shop_rule` SET `order_by` = '5' WHERE `tbtt_master_shop_rule`.`id` = 52;

ALTER TABLE `tbtt_shop_follow`
ADD COLUMN `priority` TINYINT(1) NULL DEFAULT 0 AFTER `hasFollow`;


-- thuan 25/5/2019
CREATE TABLE `azibai_home`.`tbtt_send_new_branch` ( `id` INT NOT NULL AUTO_INCREMENT , `not_id` INT NOT NULL , `user_bran_id` INT NOT NULL , `created_at` DATETIME NOT NULL , `updated_at` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;
RENAME TABLE `azibai_home`.`tbtt_send_new_branch` TO `azibai_home`.`tbtt_send_news`;
ALTER TABLE `tbtt_send_news` CHANGE `user_bran_id` `user_shop_id` INT(11) NOT NULL;
ALTER TABLE `tbtt_send_news` ADD `status` TINYINT NOT NULL DEFAULT '1' AFTER `user_shop_id`;

--
ALTER TABLE `tbtt_links`
CHANGE COLUMN `image` `image` TEXT NULL DEFAULT NULL ;

ALTER TABLE `tbtt_lib_links`
CHANGE COLUMN `image` `image` TEXT NULL DEFAULT NULL ,
CHANGE COLUMN `video` `video` TEXT NULL DEFAULT NULL ;

ALTER TABLE `tbtt_content_links`
CHANGE COLUMN `image` `image` TEXT NULL DEFAULT NULL ,
CHANGE COLUMN `video` `video` TEXT NULL DEFAULT NULL ;

ALTER TABLE `tbtt_content_image_links`
CHANGE COLUMN `video` `video` TEXT NULL DEFAULT NULL ,
CHANGE COLUMN `image` `image` TEXT NULL DEFAULT NULL ;

ALTER TABLE `tbtt_content_links`
ADD COLUMN `show_in_library` INT(1) NULL DEFAULT 1 AFTER `cate_link_id`;

ALTER TABLE `tbtt_content_image_links`
ADD COLUMN `show_in_library` INT(1) NULL DEFAULT 1 AFTER `cate_link_id`;


ALTER TABLE `tbtt_links`
ADD COLUMN `tbl_min_time` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `added_at`,
ADD COLUMN `tbl_max_time` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `tbl_min_time`,
CHANGE COLUMN `title` `title` TEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL ,
CHANGE COLUMN `description` `description` TEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL ,
CHANGE COLUMN `img_width` `img_width` INT(11) NULL DEFAULT '0' ,
CHANGE COLUMN `img_height` `img_height` INT(11) NULL DEFAULT '0' ,
CHANGE COLUMN `min_id` `min_id` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `max_id` `max_id` INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN `added_at` `added_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE  `tbtt_shop_follow` ADD  `priority` TINYINT( 1 ) NOT NULL DEFAULT  '0' AFTER  `hasFollow`
ALTER TABLE `tbtt_send_news` ADD `status` TINYINT NOT NULL DEFAULT '1' AFTER `user_shop_id`;

-- duc 03/06/2019
ALTER TABLE `tbtt_affiliate_user` ADD `discount_percen` INT NOT NULL DEFAULT '0' AFTER `discount_rate`;
ALTER TABLE `tbtt_package_user` ADD `affiliate_percen` INT NOT NULL DEFAULT '0' AFTER `affiliate_price_rate`;

ALTER TABLE  `tbtt_like_link` ADD  `tbl` VARCHAR( 50 ) NULL

---Ngoc 04/06/2019
ALTER TABLE `tbtt_shop` ADD `sho_taxcode` VARCHAR(13) NOT NULL AFTER `sho_limit_ctv`;

DROP TABLE IF EXISTS `tbtt_timeworks`;
CREATE TABLE IF NOT EXISTS `tbtt_timeworks` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `monday` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tuesday` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wednesday` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thursday` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `friday` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `saturday` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sunday` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `full_time` int(1) NOT NULL DEFAULT '0',
  `close` int(1) NOT NULL DEFAULT '0',
  `shop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `tbtt_shop` ADD `sho_establish` VARCHAR(255) NULL AFTER `sho_taxcode`;

--Ngoc 06/06/2019
DROP TABLE IF EXISTS `tbtt_company_team`;
CREATE TABLE IF NOT EXISTS `tbtt_company_team` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `team_name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `team_avatar` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `team_role` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `team_desc` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `team_facebook` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `team_twitter` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `team_linkedin` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `team_instagram` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `team_azibai` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `team_shop` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `tbtt_shop` CHANGE `sho_taxcode` `sho_taxcode` VARCHAR(13) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;

ALTER TABLE `tbtt_shop` CHANGE COLUMN `sho_taxcode` `sho_taxcode` VARCHAR(13) NULL ;

-- Chị Phượng 8-6-2019
ALTER TABLE `azibai_home`.`tbtt_notifications`
CHARACTER SET = utf8mb4 , COLLATE = utf8mb4_unicode_ci ,
DROP COLUMN `createdAt`,
ADD COLUMN `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`,
CHANGE COLUMN `updatedAt` `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `type`,
CHANGE COLUMN `action_type` `action_type` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `title` `title` TEXT NULL DEFAULT NULL ,
CHANGE COLUMN `body` `body` TEXT NULL DEFAULT NULL ,
CHANGE COLUMN `model_id` `model_id` VARCHAR(20) NOT NULL DEFAULT '0' ,
CHANGE COLUMN `pushed_by` `pushed_by` INT(11) NOT NULL ,
CHANGE COLUMN `is_personal` `is_personal` TINYINT(1) NOT NULL ,
CHANGE COLUMN `type` `type` VARCHAR(50) NOT NULL ;


--Ngoc 10/06/2019
DROP TABLE IF EXISTS `tbtt_shop_certify`;
CREATE TABLE IF NOT EXISTS `tbtt_shop_certify` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `certify_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `certify_avatar` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `certify_released` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `certify_year` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `certify_shop` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `tbtt_shop_customer`;
CREATE TABLE IF NOT EXISTS `tbtt_shop_customer` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `customer_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `customer_avatar` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `customer_video` varchar(250) COLLATE utf8_unicode_ci NULL,
  `customer_quote` varchar(250) COLLATE utf8_unicode_ci NULL,
  `customer_shop` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `tbtt_shop_active`;
CREATE TABLE IF NOT EXISTS `tbtt_shop_active` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `active_title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `active_avatar` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `active_desc` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `active_urlvideo` varchar(250) COLLATE utf8_unicode_ci NULL,
  `active_video` varchar(250) COLLATE utf8_unicode_ci NULL,
  `active_url` varchar(250) COLLATE utf8_unicode_ci NULL,
  `active_date` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `active_year` int(11) NOT NULL DEFAULT '0',
  `active_at` int(1) NOT NULL DEFAULT '0',
  `active_shop` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- anh Long
ALTER TABLE  `tbtt_shop` ADD  `time_work` TEXT NULL;

UPDATE `tbtt_shop` set time_work='{"0": {"am": {"end": "12:00", "start": "8:00"}, "on": 1, "pm": {"end": "17:00", "start": "13:00"}}, "1": {"am": {"end": "12:00", "start": "8:00"}, "on": 1, "pm": {"end": "17:00", "start": "13:00"}}, "2": {"am": {"end": "12:00", "start": "8:00"}, "on": 1, "pm": {"end": "17:00", "start": "13:00"}}, "3": {"am": {"end": "12:00", "start": "8:00"}, "on": 1, "pm": {"end": "17:00", "start": "13:00"}}, "4": {"am": {"end": "12:00", "start": "8:00"}, "on": 1, "pm": {"end": "17:00", "start": "13:00"}}, "5": {"am": {"end": "12:00", "start": "8:00"}, "on": 1, "pm": {"end": "17:00", "start": "13:00"}}, "6": {"am": {"end": "12:00", "start": "8:00"}, "on": 1, "pm": {"end": "17:00", "start": "13:00"}}, "type": 1}';

-- Thuan 12-06-2019
ALTER TABLE `tbtt_user` CHANGE `use_auth_token` `use_auth_token` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

-- Thuan 29-06-2019
ALTER TABLE `tbtt_package_user` ADD `token` TEXT NULL AFTER `affiliate_percen`;
ALTER TABLE `tbtt_package_user` ADD `type_payment` INT NOT NULL DEFAULT '0' AFTER `token`;
-- Ngoc 26/06/2019
ALTER TABLE `tbtt_shop` ADD `lng` FLOAT NULL , ADD `lat` FLOAT NULL;


-- Thuan 01-07-2019
ALTER TABLE `tbtt_user` CHANGE `use_email` `use_email` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
-- Duc 02-07-2019
ALTER TABLE `tbtt_domains` ADD `domain_type` INT(11) NOT NULL DEFAULT '0' AFTER `domain`;
ALTER TABLE `tbtt_domains` ADD INDEX(`domain`);
DROP TABLE IF EXISTS `tbtt_package_show`;
CREATE TABLE IF NOT EXISTS `tbtt_package_show` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `tbtt_package_show` (`id`, `service_id`, `group_id`, `created`, `updated`) VALUES
(1, 35, 3, '2019-07-05 14:30:54', '2019-07-05 14:30:54'),
(2, 37, 3, '2019-07-05 14:30:54', '2019-07-05 14:30:54'),
(3, 38, 3, '2019-07-05 14:31:25', '2019-07-05 14:31:25'),
(4, 39, 3, '2019-07-05 14:31:25', '2019-07-05 14:31:25'),
(5, 38, 14, '2019-07-05 14:34:35', '2019-07-05 14:34:35'),
(6, 39, 14, '2019-07-05 14:34:35', '2019-07-05 14:34:35');
COMMIT;
-- Thuan 29-07-2019
ALTER TABLE `tbtt_money` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `pay_weekly`;
ALTER TABLE `tbtt_money` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `pay_weekly`;

ALTER TABLE `tbtt_money_logs` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `note`;
ALTER TABLE `tbtt_money_logs` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `note`;
ALTER TABLE `tbtt_money` ADD `list_id` LONGTEXT NOT NULL AFTER `pay_weekly`;

-- Thuan 29-07-2019
ALTER TABLE `tbtt_shop` CHANGE `sho_facebook` `sho_facebook` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `tbtt_shop` CHANGE `sho_twitter` `sho_twitter` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `tbtt_shop` CHANGE `sho_youtube` `sho_youtube` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `tbtt_shop` CHANGE `sho_google_plus` `sho_google_plus` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `tbtt_shop` CHANGE `sho_vimeo` `sho_vimeo` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `tbtt_shop` CHANGE `sho_website` `sho_website` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

-- Duc 29-07-2019
ALTER TABLE `tbtt_bank` ADD `user_id` BIGINT NOT NULL AFTER `id`;
ALTER TABLE `tbtt_bank` ADD `type_bank` INT NOT NULL DEFAULT '0' AFTER `aff`, ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `type_bank`, ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;

ALTER TABLE `tbtt_collection`
CHANGE COLUMN `avatar_path` `avatar_path_full` VARCHAR(250) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL ;

-- Ngoc 10/08/2019
DROP TABLE IF EXISTS `tbtt_like_service`;
CREATE TABLE IF NOT EXISTS `tbtt_like_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;
-- Duc 13/08/2019
ALTER TABLE `tbtt_package_info` ADD `limit` BOOLEAN NOT NULL DEFAULT FALSE AFTER `pType`;

-- Thành 15/08/2019 Procedure links
DROP PROCEDURE IF EXISTS `link_update_min_max_zero`;
DELIMITER //
CREATE PROCEDURE link_update_min_max_zero(IN link_id INT)
   BEGIN
        UPDATE tbtt_links
        SET tbtt_links.min_id       = 0,
            tbtt_links.tbl_min      = '',
            tbtt_links.tbl_min_time = '0000-00-00 00:00:00',
            tbtt_links.max_id       = 0,
            tbtt_links.tbl_max      = '',
            tbtt_links.tbl_max_time = '0000-00-00 00:00:00'
        WHERE tbtt_links.id         = link_id;
   END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `link_update_min_max_current`;
DELIMITER //
CREATE PROCEDURE link_update_min_max_current(IN link_id INT, IN min_id INT, IN tbl_min VARCHAR(100), IN tbl_min_time DATETIME, IN max_id INT, IN tbl_max VARCHAR(100), IN tbl_max_time DATETIME)
   BEGIN
        UPDATE tbtt_links
        SET tbtt_links.min_id       = min_id,
            tbtt_links.tbl_min      = tbl_min,
            tbtt_links.tbl_min_time = tbl_min_time,
            tbtt_links.max_id       = max_id,
            tbtt_links.tbl_max      = tbl_max,
            tbtt_links.tbl_max_time = tbl_max_time
        WHERE tbtt_links.id         = link_id;
   END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `link_update_min`;
DELIMITER //
CREATE PROCEDURE link_update_min(IN link_id INT, IN min_id INT, IN tbl_min VARCHAR(100), IN tbl_min_time DATETIME)
   BEGIN
        UPDATE tbtt_links
        SET tbtt_links.min_id  = min_id,
            tbtt_links.tbl_min = tbl_min,
            tbtt_links.tbl_min_time = tbl_min_time
        WHERE tbtt_links.id = link_id;
   END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `link_update_max`;
DELIMITER //
CREATE PROCEDURE link_update_max(IN link_id INT, IN max_id INT, IN tbl_max VARCHAR(100), IN tbl_max_time DATETIME)
   BEGIN
        UPDATE tbtt_links
        SET tbtt_links.max_id       = max_id,
            tbtt_links.tbl_max      = tbl_max,
            tbtt_links.tbl_max_time = tbl_max_time
        WHERE tbtt_links.id = link_id;
   END //
DELIMITER ;

-- Thành 19/08/2019
ALTER TABLE `azibai_home`.`tbtt_links`
ADD COLUMN `img_ext` TEXT NULL AFTER `image`,
ADD COLUMN `img_path` TEXT NULL AFTER `img_ext`,
ADD COLUMN `img_name` TEXT NULL AFTER `img_path`;

-- Duc 21/08/2019
DROP TABLE IF EXISTS `tbtt_affiliate_relationship`;
CREATE TABLE IF NOT EXISTS `tbtt_affiliate_relationship` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `affiliate_level` int(11) NOT NULL DEFAULT '0',
  `list_user` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;
ALTER TABLE `tbtt_affiliate_relationship` ADD `accept` TINYINT NOT NULL DEFAULT '0' AFTER `affiliate_level`;
ALTER TABLE `tbtt_package` ADD `group` INT NOT NULL DEFAULT '0' AFTER `info_id`;
ALTER TABLE `tbtt_affiliate_relationship` ADD `public` TINYINT NOT NULL DEFAULT '1' AFTER `list_user`;
ALTER TABLE `tbtt_affiliate_relationship` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;

-- 05/09/2019 Ngoc --
ALTER TABLE `tbtt_report_detail` CHANGE `rpd_status` `rpd_status` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: Mới, 1: Đang xử lý, 2: Đã xử lý';
ALTER TABLE `tbtt_report_detail` CHANGE `rpd_content` `rpd_content` INT(11) NOT NULL DEFAULT '0', CHANGE `rpd_product` `rpd_product` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `tbtt_report_detail` CHANGE `rpd_type` `rpd_type` TINYINT(1) NOT NULL COMMENT '1: tin tức, 2: sản phẩm';

DROP TABLE IF EXISTS `tbtt_voucher`;
CREATE TABLE IF NOT EXISTS `tbtt_voucher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` int(11) NOT NULL,
  `voucher_type` int(11) NOT NULL DEFAULT '1',
  `product_type` int(11) NOT NULL DEFAULT '1',
  `time_start` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_end` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `quantily` int(11) NOT NULL DEFAULT '0',
  `apply` int(11) NOT NULL DEFAULT '1',
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `affiliate_type` int(11) NOT NULL DEFAULT '1',
  `price` int(11) NOT NULL DEFAULT '0',
  `price_discount` int(11) NOT NULL DEFAULT '0',
  `price_percent` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

DROP TABLE IF EXISTS `tbtt_voucher_product`;
CREATE TABLE IF NOT EXISTS `tbtt_voucher_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;
ALTER TABLE `tbtt_voucher` ADD `user_id` INT NOT NULL AFTER `price_percent`;
ALTER TABLE `tbtt_affiliate_price` ADD `type` INT NOT NULL DEFAULT '0' AFTER `id_level`;
ALTER TABLE `tbtt_voucher` ADD `discount_type` INT NOT NULL DEFAULT '0' AFTER `affiliate_type`;
ALTER TABLE `tbtt_affiliate_price` CHANGE `discount_percen` `discount_value` BIGINT(11) NOT NULL DEFAULT '1';
ALTER TABLE `tbtt_voucher` ADD `price_rank` BIGINT NOT NULL DEFAULT '0' AFTER `price_percent`;
ALTER TABLE `tbtt_package_user` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `type_payment`, ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;
ALTER TABLE `tbtt_wallet` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `status_apply`, ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;
ALTER TABLE `tbtt_package_user` ADD `response_message` VARCHAR(255) NULL DEFAULT NULL AFTER `type_payment`, ADD `transaction_id` BIGINT NULL DEFAULT '0' AFTER `response_message`, ADD `momo_phone` VARCHAR(12) NULL DEFAULT NULL AFTER `transaction_id`;

-- Thuan 4-9-2019
ALTER TABLE `tbtt_order` ADD `shipping_info` TEXT NULL AFTER `user_process`;
ALTER TABLE `tbtt_order` CHANGE `shipping_method` `shipping_method` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '';
-- END Thuan
INSERT INTO `tbtt_affiliate_relationship` (`id`, `user_id`, `parent_id`, `affiliate_level`, `accept`, `list_user`, `public`, `created_at`, `updated_at`) VALUES (NULL, '16373', '4689', '3', '1', '', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), (NULL, '16373', '15827', '2', '1', '', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
INSERT INTO `tbtt_affiliate_relationship` (`id`, `user_id`, `parent_id`, `affiliate_level`, `accept`, `list_user`, `public`, `created_at`, `updated_at`) VALUES (NULL, '16311', '15827', '2', '1', '', '1', '2019-09-13 11:01:30', '2019-09-13 11:01:30')

--ngoc
ALTER TABLE `tbtt_product` CHANGE `pro_saleoff_value` `pro_saleoff_value` FLOAT(11) NULL;

ALTER TABLE `tbtt_content`
ADD COLUMN `user_up` INT(11) NULL DEFAULT 0 AFTER `not_comment_off`;
--ngoc
ALTER TABLE `tbtt_product` CHANGE `pro_saleoff_value` `pro_saleoff_value` FLOAT(11) NULL DEFAULT '0';
-- 23/09/2019 Duc --
ALTER TABLE `tbtt_user` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `permission_home_town`, ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;

-- 25/09/2019 Thành
ALTER TABLE `tbtt_content` ADD INDEX `not_content_not_id` (`not_id` ASC);
ALTER TABLE `tbtt_content` ADD INDEX `not_content_not_user` (`not_user` ASC);
ALTER TABLE `tbtt_content` ADD INDEX `not_content_sho_id` (`sho_id` ASC);

-- 26/09/2019 Duc --
ALTER TABLE `tbtt_package_user` ADD `type` INT NOT NULL DEFAULT '0' AFTER `momo_phone`;
ALTER TABLE `tbtt_domains` CHANGE `update_at` `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `tbtt_domains` CHANGE `create_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

-- 01/10/2019 Thuan --
CREATE TABLE `azibai_home`.`tbtt_shop_nhanh` ( `id` INT NOT NULL AUTO_INCREMENT , `sho_id` INT NOT NULL , `user_name` VARCHAR(100) NOT NULL , `secret_key` VARCHAR(100) NOT NULL , `created_at` TIMESTAMP NOT NULL , `updated_at` TIMESTAMP NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `azibai_home`.`tbtt_shop_nganluong` ( `id` INT NOT NULL AUTO_INCREMENT , `sho_id` INT NOT NULL , `merchant_id` INT NOT NULL , `merchant_pass` VARCHAR(255) NOT NULL , `receiver` VARCHAR(255) NOT NULL , `created_at` TIMESTAMP NOT NULL , `updated_at` TIMESTAMP NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `tbtt_shop_momo` (
  `id` int(11) NOT NULL,
  `sho_id` int(11) NOT NULL,
  `partner_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `access_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `serect_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pub_key` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `tbtt_order_nhanhvn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `tbtt_affiliate_relationship` ADD `user_parent_id` BIGINT NOT NULL DEFAULT '0' AFTER `parent_id`;
ALTER TABLE `tbtt_money` ADD `authorized_code` VARCHAR(30) NOT NULL AFTER `list_id`;
ALTER TABLE `tbtt_money` ADD `public` TINYINT NOT NULL DEFAULT '0' AFTER `created_at`;

-- Thanh 18/11/2019
ALTER TABLE `tbtt_content`
ADD COLUMN `not_hashtag` TEXT NULL AFTER `audio_azibai`;


-- Thuan 22/11/2019
CREATE TABLE `azibai_home`.`tbtt_order_voucher` ( `id` INT NOT NULL AUTO_INCREMENT , `order_id` INT NOT NULL , `pro_id` INT NOT NULL , `voucher` VARCHAR(50) NOT NULL , `content` TEXT NOT NULL , `created_at` TIMESTAMP NOT NULL , `updated_at` TIMESTAMP NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `tbtt_order_voucher` ADD `price_voucher` INT NOT NULL DEFAULT '0' AFTER `voucher`;
-- End Thuan

-- A Quyen tạo, Ngoc su dung 13/12/2019 --
DROP TABLE IF EXISTS `tbtt_report_category`;
CREATE TABLE `tbtt_report_category` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `report_category_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_type` varchar(50) DEFAULT NULL,
  `report_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`report_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

insert into `tbtt_report_category`(`report_id`,`report_category_name`,`report_type`,`report_status`)
  values (1,'Quyền sở hữu trí tuệ','1',1),
  (2,'Gian lận hoặc lừa đảo','1',1),
  (3,'Hình ảnh gợi dục','1',1),
  (4,'Hoạt động tình dục','1',1),
  (5,'Bạo lực','1',1),
  (6,'Ngược đãi động vật','1',1),
  (7,'Lạm dụng trẻ em','1',1),
  (8,'Tự tử / Tự gây thương tích','1',1),
  (9,'Ngôn từ gây thù ghét','1',1),
  (10,'Quảng cáo hành vi sử dụng ma tuý','1',1),
  (11,'Bán hàng cấm','1',1),
  (12,'Chế giễu nạn nhân','1',1),
  (13,'Bắt nạt','1',1),
  (14,'Quấy rối','1',1),
  (15,'Chia sẻ hình ảnh riêng tư','1',1),
  (16,'Sản phẩm là hàng cấm tàng trữ và buôn bán','2',1),
  (17,'Sản phẩm vi phạm thương hiệu, hàng giả hoặc hàng nhái','2',1),
  (18,'Tên sản phẩm, hình ảnh, mô tả sản phẩm không rõ ràng','2',1),
  (19,'Sản phẩm không rõ nguồn gốc, xuất xứ','2',1),
  (20,'Sản phẩm liên quan đến hoạt động tình dục','2',1);
-- End --

-- Thuan 19/12/2019
ALTER TABLE `tbtt_shop` ADD `permission_mobile` TINYINT NULL DEFAULT '1' AFTER `time_work`, ADD `permission_email` TINYINT NULL DEFAULT '1' AFTER `permission_mobile`, ADD `permission_phone` TINYINT NULL DEFAULT '1' AFTER `permission_email`;
-- End Thuan

-- Thuan 25/12/2019
ALTER TABLE `tbtt_product` ADD `apply` INT NOT NULL DEFAULT '0' AFTER `pro_id_old`, ADD `condition_use` TEXT NULL AFTER `apply`;
-- End Thuan

-- Thuan 7/1/2020
ALTER TABLE `tbtt_user` ADD `accuracy` TEXT NULL AFTER `is_show_on_homepage`;
-- End Thuan
-- Duc 7/1/2020
ALTER TABLE `tbtt_user` ADD `domain` VARCHAR(255) NULL DEFAULT NULL AFTER `website`;
ALTER TABLE `tbtt_package_user_detail` ADD `parent_id` BIGINT NOT NULL DEFAULT '0' AFTER `user_id`;
ALTER TABLE `tbtt_package_user_detail` CHANGE `parent_id` `is_sale` INT NOT NULL DEFAULT '0';
ALTER TABLE `tbtt_package_user` ADD `package_name` VARCHAR(255) NULL AFTER `package_id`;
ALTER TABLE `tbtt_package_user_detail` ADD `user_sale` BIGINT NOT NULL DEFAULT '0' AFTER `user_id`;
ALTER TABLE `tbtt_package_user_detail` ADD `user_parent_id` BIGINT NOT NULL DEFAULT '0' AFTER `user_sale`;
ALTER TABLE `tbtt_user` CHANGE `domain` `domain_person` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
-- End Duc

-- Thanh 08/02/2020
ALTER TABLE `tbtt_videos`
ADD COLUMN `processing` TINYINT(1) NULL DEFAULT 0 AFTER `content_id`;
-- End

-- Thuan 16/1/2020
ALTER TABLE `tbtt_cart` ADD `af_id` VARCHAR(32) NULL AFTER `quantity`;
CREATE TABLE `azibai_home`.`tbtt_order_detail_aff` ( `id` INT NOT NULL AUTO_INCREMENT , `shc_id` INT NOT NULL , `user_id` INT NOT NULL , `user_sale` INT NOT NULL , `is_sale` TINYINT(1) NOT NULL DEFAULT '0' , `limited` INT NOT NULL , `status` TINYINT(4) NOT NULL DEFAULT '0' , `real_amount` INT NOT NULL , `amount` FLOAT NOT NULL , `em_discount` INT NOT NULL , `discount_type` INT NOT NULL , `affiliate_value` FLOAT NOT NULL , `total_affiliate_price` FLOAT NOT NULL , `type` INT NOT NULL , `created_at` DATETIME NOT NULL , `updated_at` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
-- End Thuan