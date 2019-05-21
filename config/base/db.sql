SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE IF NOT EXISTS `User` (
			`id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`name` VARCHAR(60) NOT NULL,
			`username` VARCHAR(30) NOT NULL,
			`password` VARCHAR(255) NOT NULL,
			`email` VARCHAR(255) NOT NULL,
			`confirmation_token` varchar(60) NULL,
			`confirmation_at` DateTime NULL,
			`reset_token` VARCHAR(60) NULL,
			`reset_at` DateTime NULL,
			`mail_comments` INT NOT NULL
			);


CREATE TABLE IF NOT EXISTS `photos` (
				`user_id` INT NOT NULL,
				`photo_id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				`date_photo` DateTime DEFAULT CURRENT_TIMESTAMP,
				`photo_type` VARCHAR(4) NOT NULL,
				`filter` INT NOT NULL,
				`photo_path` VARCHAR(255) NOT NULL
			);

CREATE TABLE IF NOT EXISTS `comments` (
				`comment_id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				`usercomment_id` INT NOT NULL,
				`usercomment_username` VARCHAR(255) NOT NULL,
				`photo_id` INT NOT NULL,
				`date_comment` DateTime DEFAULT CURRENT_TIMESTAMP,
				`comment` LONGTEXT NOT NULL
			);

CREATE TABLE IF NOT EXISTS `likephoto` (
				`userlike_id` INT NOT NULL,
				`date_like` DateTime DEFAULT CURRENT_TIMESTAMP,
				`photo_id` INT NOT NULL
			);

 -----------------------
 -----------------------
-- CREATE TABLE `user`(
-- 	`id` VARCHAR(255) PRIMARY KEY,
-- 	`username` VARCHAR(255) UNIQUE NOT NULL,
-- 	`email` VARCHAR(255) UNIQUE NOT NULL,
-- 	`password` VARCHAR(255) NOT NULL,
-- 	`confirmed` BOOLEAN DEFAULT 0,
--   `notified` BOOLEAN DEFAULT 0
-- );

-- CREATE TABLE `token` (
--   `id` varchar(255) NOT NULL,
--   `token` varchar(255) PRIMARY KEY,
--   `type` int(11) NOT NULL
-- );


-- CREATE TABLE `picture` (
--   `id` VARCHAR(255) PRIMARY KEY,
--   `id_user` VARCHAR(255) NOT NULL,
--   `data` MEDIUMTEXT NOT NULL,
--   `date` DATETIME DEFAULT CURRENT_TIMESTAMP
-- );

-- CREATE TABLE `like` (
--   `id_picture` VARCHAR(255),
--   `id_user` VARCHAR(255),
--   `date` DATETIME DEFAULT CURRENT_TIMESTAMP
-- );

-- CREATE TABLE `comment` (
--   `id` VARCHAR(255) PRIMARY KEY,
--   `id_picture` VARCHAR(255) NOT NULL,
--   `id_user` VARCHAR(255) NOT NULL,
--   `body` TEXT NOT NULL,
--   `date` DATETIME DEFAULT CURRENT_TIMESTAMP
-- );

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
