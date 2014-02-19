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
    `role`      ENUM('guest', 'visitor', 'user', 'admin'),
    PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `site_user`(`username`, `password`, `firstname`, `lastname`, `email`, `created_at`, `role`) VALUES
('PrecisionConage', '7790ffbb26cf6409e707105e92cde91e', 'Shane', 'Spoor', 'sspoor@my.bcit.ca', '2014-02-10 08:46:37', 'admin'),
('konstabro', '9115b9aab6fd005f51e429a39e9e9618', 'Konstantin', 'Boyarinov','kboyarinov@my.bcit.ca', '2014-02-10 08:47:48', 'admin');

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
    `postid`     INT(11) NOT NULL,
    `username`   VARCHAR(40) NOT NULL,
    `catid`      INT(11) NOT NULL,
    `title`      VARCHAR(80),
    `post_content` LONGTEXT,
    `updated_at` DATETIME,
    `created_at` DATETIME,
    `thumb`      VARCHAR(80),
     PRIMARY KEY (`postid`),
     CONSTRAINT fk_site_user FOREIGN KEY (`username`) REFERENCES site_user(`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `post`(`postid`, `username`, `catid`, `title`, `post_content`, `updated_at`, `created_at`, `thumb`) VALUES
(1, 'konstabro', 1, 'Post 1', 'This is the first post ever made on this blog! UPDATE: It is now also the most recent one.', '2014-02-10 10:55:22', '2014-02-10 08:48:30', 'thumb_01.png'),
(2, 'konstabro', 2, 'Post 2', 'The second post made on this blog. Not quite as exciting this time.', '2014-02-10 08:49:22', '2014-02-10 08:49:22', 'thumb_02.png'),
(3, 'PrecisionConage', 3, 'Post 3', 'Unfortunately, the third post content could not be found. Here are some words instead.', '2014-02-10 08:55:42', '2014-02-10 08:55:42', 'thumb_03.png'),
(4, 'PrecisionConage', 1, 'Post 4', 'The second-most recent post. You know it must be important since it has the highest number.', '2014-02-10 09:22:42', '2014-02-10 09:22:42', 'thumb_04.png');

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
