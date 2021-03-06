-- Media table -------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `media`
(
  `uid`         INT(11) NOT NULL,
  `filename`    VARCHAR(64) NOT NULL,
  `author`      VARCHAR(64) NOT NULL,
  `modified`    TIMESTAMP NOT NULL,
  `thumbnail`   VARCHAR(64) NOT NULL,
  PRIMARY KEY (`uid`,`filename`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `media`(`uid`, `filename`, `author`, `modified`, `thumbnail`) VALUES
(1, 'wireframe.jpg', 'SanchezClaire', '2014-01-10 07:47:48', 'thumb_01.png'),
(2, 'SNES_controller.svg', '', '2013-12-10 18:27:39', 'thumb_02.png'),
(3, 'Mile_Stone.png', '', '2013-05-01 05:17:59', 'thumb_03.png'),
(4, 'management.jpg', '', '2014-01-10 12:22:40', 'thumb_04.png');

-- Users table -------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `site_user`
(
    `username`  VARCHAR(40) NOT NULL,
    `password`  VARCHAR(32) NOT NULL,
    `firstname` VARCHAR(80),
    `lastname`  VARCHAR(80),
    `email`     VARCHAR(100),
    `created_at`DATETIME NOT NULL,
    `role`      VARCHAR(20) NOT NULL,
    CONSTRAINT fk_role FOREIGN KEY (`role`) REFERENCES user_role(`role`),
    PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `site_user`(`username`, `password`, `firstname`, `lastname`, `email`, `created_at`, `role`) VALUES
('PrecisionConage', '7790ffbb26cf6409e707105e92cde91e', 'Shane', 'Spoor', 'sspoor@my.bcit.ca', '2014-02-10 08:46:37', 'admin'),
('konstabro', '9115b9aab6fd005f51e429a39e9e9618', 'Konstantin', 'Boyarinov','kboyarinov@my.bcit.ca', '2014-02-10 08:47:48', 'admin'),
('JParry', '5df7bff58c7211580f99aee9738e0eea', 'Jim', 'Parry','jparry1@bcit.ca', '2014-02-10 08:47:48', 'admin'),
('JimP', 'abd2a9d59bcffefef56dbbd853a0da01', 'Jim', 'Parry', 'jparry1@bcit.ca', '2014-02-10 08:47:48', 'user');



-- Tag table ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `tag`
(
    `tagid` INT(11) NOT NULL,
    `name`  VARCHAR(40),
    `postid` INT(11),
    PRIMARY KEY (`tagid`),
    CONSTRAINT fk_postid FOREIGN KEY (`postid`) REFERENCES post(`postid`)
);
INSERT INTO `tag`(`tagid`, `name`, `postid`) VALUES
(1, 'Horse' , 1),
(2, 'Thingy', 2),
(3, 'Progressive', 2);
-- Role table --------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_role`
(
    `role` VARCHAR(20) NOT NULL,
    PRIMARY KEY(`role`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `user_role` (`role`) VALUES
('guest').
('visitor'),
('user'),
('admin');

-- Category table ----------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `category`
(
    `catid` INT(11) NOT NULL,
    `name`  VARCHAR(10),
    PRIMARY KEY (`catid`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `category`(`catid`, `name`) VALUES
(1, 'Insights'),
(2, 'Technical'),
(3, 'Progress');

-- Post table --------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `post`
(
    `postid`        INT(11)         AUTO_INCREMENT NOT NULL,
    `username`      VARCHAR(40)     NOT NULL,
    `modified_by`   VARCHAR(40)     NOT NULL,
    `catid`         INT(11),
    `title`         VARCHAR(80)     NOT NULL,
    `post_content`  TEXT            NOT NULL,
    `slug`          VARCHAR(150)    NOT NULL,
    `updated_at`    DATETIME,
    `created_at`    DATETIME,
    `thumb`         VARCHAR(80),
     PRIMARY KEY (`postid`),
     CONSTRAINT fk_site_user FOREIGN KEY (`username`) REFERENCES site_user(`username`),
     CONSTRAINT fk_site_user_mod FOREIGN KEY(`modified_by`) REFERENCES site_user(`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `post`(`postid`, `username`, `modified_by`, `catid`, `title`, `post_content`, `slug`, `updated_at`, `created_at`, `thumb`) VALUES
(1, 'konstabro', 'konstabro', 1, 'Post 1', 'This is the first post ever made on this blog! UPDATE: It is now also the most recent one.', 'Post 1: The adventure begins','2014-02-10 10:55:22', '2014-02-10 08:48:30', 'thumb_01.png'),
(2, 'konstabro', 'konstabro', 2, 'Post 2', 'The second post made on this blog. Not quite as exciting this time.', 'We explore the merits of socialising your web media stream integration.', '2014-02-10 08:49:22', '2014-02-10 08:49:22', 'thumb_02.png'),
(3, 'PrecisionConage', 'PrecisionConage', 3, 'Post 3', 'Unfortunately, the third post content could not be found. Here are some words instead.', 'We discuss the abundance of ridiculous terms used by business people in regard to computers.', '2014-02-10 08:55:42', '2014-02-10 08:55:42', 'thumb_03.png'),
(4, 'PrecisionConage', 'PrecisionConage', 1, 'Post 4', 'The second-most recent post. You know it must be important since it has the highest number.', 'Today is a lazy day. Here\'s why you should respect that.', '2014-02-10 09:22:42', '2014-02-10 09:22:42', 'thumb_04.png');
-- ci_sessions table --------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS  `ci_sessions` (
	session_id varchar(40) DEFAULT '0' NOT NULL,
	ip_address varchar(45) DEFAULT '0' NOT NULL,
	user_agent varchar(120) NOT NULL,
	last_activity int(10) unsigned DEFAULT 0 NOT NULL,
	user_data text NOT NULL,
	PRIMARY KEY (session_id),
	KEY `last_activity_idx` (`last_activity`)
);

-- metdata table ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `metadata`
(
  `property`    VARCHAR(32) NOT NULL,
  `value`    	VARCHAR(512) NOT NULL,
  `description` VARCHAR(256),
  PRIMARY KEY (`property`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `metadata`(`property`, `value`, `description`) VALUES
('syndication_code', 'o03', 'Identifies this blog uniquely for post syndication.'),
('site_plug', '[Forthcoming - like our game]', 'Brief description to interest readers.'),
('site_name', 'Agitated Multiprocessing', '');


CREATE TABLE IF NOT EXISTS `tag`
(
    `tag_id`        INT(11)     AUTO_INCREMENT NOT NULL,
    `tag_name`      VARCHAR(64)                NOT NULL,
    `postid`        INT(11)                    NOT NULL,
    CONSTRAINT PRIMARY KEY pk_tag(`tag_id`),
    CONSTRAINT fk_post FOREIGN KEY(`postid`) REFERENCES post(`postid`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `comment`
(
    `comment_id`      INT(11)     AUTO_INCREMENT NOT NULL,
    `comment_content` TEXT                       NOT NULL,
    `postid`          INT(11)                    NOT NULL,
    `username`        VARCHAR(40)                NOT NULL,
    CONSTRAINT PRIMARY KEY pk_comment(`comment_id`),
    CONSTRAINT fk_post FOREIGN KEY(`postid`) REFERENCES post(`postid`),
    CONSTRAINT fk_user FOREIGN KEY(`username`) REFERENCES site_user(`username`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

