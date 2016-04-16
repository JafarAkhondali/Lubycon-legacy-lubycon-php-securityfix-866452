
DROP DATABASE IF EXISTS LubyconBoard;
CREATE DATABASE IF NOT EXISTS LubyconBoard;

USE LubyconBoard;

-- Tutorial
DROP TABLE IF EXISTS `Tutorial`;
CREATE TABLE IF NOT EXISTS `Tutorial`
(
	`boardCode` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`userCode` INT UNSIGNED NOT NULL,
	`title` VARCHAR(255) NOT NULL,
	`desc` TEXT,
	`contents` TEXT,
	`imgDirectory` TEXT,
	`downDirectory` TEXT,
	`downloadCount` INT UNSIGNED NOT NULL,
	`viewCount` INT UNSIGNED NOT NULL,
	`likeCount` INT UNSIGNED NOT NULL,
	`preview` TEXT NOT NULL,
	
	PRIMARY KEY(`boardCode`)
	
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

-- tutorial comment
DROP TABLE IF EXISTS `TutoComment`;
CREATE TABLE IF NOT EXISTS `TutoComment`
(
	`boardCode` INT UNSIGNED NOT NULL,
	`contents` TEXT NOT NULL,
	`like` INT UNSIGNED NOT NULL,
	`userCode` INT UNSIGNED NOT NULL,
	`date` DATETIME NOT NULL,
	
	PRIMARY KEY(`boardCode`)
)ENGINE = InnoDB DEFAULT CHARSET=utf8;


-- Forum
DROP TABLE IF EXISTS `Forum`;

CREATE TABLE IF NOT EXISTS `Forum`
(
	`boardCode` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`userCode` INT UNSIGNED NOT NULL,
	`title` VARCHAR(255) NOT NULL,
	`desc` TEXT,
	`contents` TEXT,
	`imgDirectory` TEXT,
	`downDirectory` TEXT,
	`downloadCount` INT UNSIGNED NOT NULL,
	`viewCount` INT UNSIGNED NOT NULL,
	`likeCount` INT UNSIGNED NOT NULL,
	`preview` TEXT NOT NULL,
	
	PRIMARY KEY(`boardCode`)
	
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

-- ForumComment
DROP TABLE IF EXISTS `ForumComment`;
CREATE TABLE IF NOT EXISTS `ForumComment`
(
	`boardCode` INT UNSIGNED NOT NULL,
	`contents` TEXT NOT NULL,
	`like` INT UNSIGNED NOT NULL,
	`userCode` INT UNSIGNED NOT NULL,
	`date` DATETIME NOT NULL,
	
	PRIMARY KEY(`boardCode`)
)ENGINE = InnoDB DEFAULT CHARSET=utf8;

-- Vector
DROP TABLE IF EXISTS `Vector`;
CREATE TABLE IF NOT EXISTS `Vector`
(
	`boardCode` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`userCode` INT UNSIGNED NOT NULL,
	`title` VARCHAR(255) NOT NULL,
	`desc` TEXT,
	`contents` TEXT,
	`imgDirectory` TEXT,
	`downDirectory` TEXT,
	`downloadPermission` ENUM('Free','Qualified','View') NOT NULL,
	`downloadCount` INT UNSIGNED NOT NULL,
	`viewCount` INT UNSIGNED NOT NULL,
	`likeCount` INT UNSIGNED NOT NULL,
	`preview` TEXT NOT NULL,
	
	PRIMARY KEY(`boardCode`)
	
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

-- VectorComment
DROP TABLE IF EXISTS `VectorComment`;
CREATE TABLE IF NOT EXISTS `VectorComment`
(
	`boardCode` INT UNSIGNED NOT NULL,
	`contents` TEXT NOT NULL,
	`like` INT UNSIGNED NOT NULL,
	`userCode` INT UNSIGNED NOT NULL,
	`date` DATETIME NOT NULL,
	
	PRIMARY KEY(`boardCode`)
)ENGINE = InnoDB DEFAULT CHARSET=utf8;

-- ArtWork
DROP TABLE IF EXISTS `ArtWork`;
CREATE TABLE IF NOT EXISTS `ArtWork`
(
	`boardCode` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`userCode` INT UNSIGNED NOT NULL,
	`title` VARCHAR(255) NOT NULL,
	`desc` TEXT,
	`contents` TEXT,
	`imgDirectory` TEXT,
	`downDirectory` TEXT,
	`downloadPermission` ENUM('Free','Qualified','View') NOT NULL,
	`downloadCount` INT UNSIGNED NOT NULL,
	`viewCount` INT UNSIGNED NOT NULL,
	`likeCount` INT UNSIGNED NOT NULL,
	`preview` TEXT NOT NULL,
	
	PRIMARY KEY(`boardCode`)
	
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

-- ArtWorkComment
DROP TABLE IF EXISTS `ArtWorkComment`;
CREATE TABLE IF NOT EXISTS `ArtWorkComment`
(
	`boardCode` INT UNSIGNED NOT NULL,
	`contents` TEXT NOT NULL,
	`like` INT UNSIGNED NOT NULL,
	`userCode` INT UNSIGNED NOT NULL,
	`date` DATETIME NOT NULL,
	
	PRIMARY KEY(`boardCode`)
)ENGINE = InnoDB DEFAULT CHARSET=utf8;

-- ThreeD
DROP TABLE IF EXISTS `ThreeD`;
CREATE TABLE IF NOT EXISTS `ThreeD`
(
	`boardCode` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`userCode` INT UNSIGNED NOT NULL,
	`title` VARCHAR(255) NOT NULL,
	`desc` TEXT,
	`contents` TEXT,
	`imgDirectory` TEXT,
	`downDirectory` TEXT,
	`downloadPermission` ENUM('Free','Qualified','View') NOT NULL,
	`downloadCount` INT UNSIGNED NOT NULL,
	`viewCount` INT UNSIGNED NOT NULL,
	`likeCount` INT UNSIGNED NOT NULL,
	`preview` TEXT NOT NULL,
	
	PRIMARY KEY(`boardCode`)
	
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

-- ThreeDComment
DROP TABLE IF EXISTS `ThreeDComment`;
CREATE TABLE IF NOT EXISTS `ThreeDComment`
(
	`boardCode` INT UNSIGNED NOT NULL,
	`contents` TEXT NOT NULL,
	`like` INT UNSIGNED NOT NULL,
	`userCode` INT UNSIGNED NOT NULL,
	`date` DATETIME NOT NULL,
	
	PRIMARY KEY(`boardCode`)
)ENGINE = InnoDB DEFAULT CHARSET=utf8;

SHOW WARNINGS;