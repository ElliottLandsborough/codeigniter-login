# Login system for codeigniter. ToAdd: Tracking, sql, various

todo:
 - Ajax form validation
 - capcha
 - password confirmation
 - email confirmation
 - user groups

#SQL DATABASE STUFF:

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
