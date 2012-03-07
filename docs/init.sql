SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `categories_demo` (
  `categoryid` int(32) NOT NULL AUTO_INCREMENT,
  `categoryname` varchar(100) DEFAULT NULL,
  `categorydescrip` varchar(255) DEFAULT NULL,
  `leftval` int(5) NOT NULL,
  `rightval` int(5) NOT NULL,
  PRIMARY KEY (`categoryid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

INSERT INTO `categories_demo` (`categoryid`, `categoryname`, `categorydescrip`, `leftval`, `rightval`) VALUES
(1, 'top', 'top of the tree', 1, 28),
(2, 'movies', NULL, 2, 9),
(22, 'romantic comedy', NULL, 5, 6),
(23, 'books', NULL, 10, 15),
(24, 'horror', NULL, 11, 12),
(25, 'electricals', NULL, 16, 27),
(26, 'sound & vision', NULL, 17, 22),
(27, 'white goods', NULL, 23, 26),
(28, 'mp3 players', NULL, 18, 19),
(33, 'dvd players', NULL, 20, 21),
(34, 'science fiction', NULL, 13, 14),
(35, 'westerns', NULL, 7, 8),
(36, 'washing machines', NULL, 24, 25),
(37, 'bob', NULL, 3, 4);

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(26) NOT NULL,
  `user_email` varchar(40) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_status` varchar(1) NOT NULL,
  `user_lastlogin` datetime NOT NULL,
  `user_joindate` datetime NOT NULL,
  `user_key` varchar(32) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

CREATE TABLE IF NOT EXISTS `user_perms` (
  `user_id` int(10) NOT NULL,
  `user_perms` int(5) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;