CREATE TABLE IF NOT EXISTS `categories_demo` (
  `categoryid` int(32) NOT NULL auto_increment,
  `categoryname` varchar(100) default NULL,
  `categorydescrip` varchar(255) default NULL,
  `leftval` int(5) NOT NULL,
  `rightval` int(5) NOT NULL,
  PRIMARY KEY  (`categoryid`)
);


INSERT INTO `categories_demo` (`categoryid`, `categoryname`, `categorydescrip`, `leftval`, `rightval`) VALUES (1, 'top', 'top of the tree', 1, 26);
INSERT INTO `categories_demo` (`categoryid`, `categoryname`, `categorydescrip`, `leftval`, `rightval`) VALUES (2, 'movies', NULL, 2, 7);
INSERT INTO `categories_demo` (`categoryid`, `categoryname`, `categorydescrip`, `leftval`, `rightval`) VALUES (22, 'romantic comedy', NULL, 3, 4);
INSERT INTO `categories_demo` (`categoryid`, `categoryname`, `categorydescrip`, `leftval`, `rightval`) VALUES (23, 'books', NULL, 8, 13);
INSERT INTO `categories_demo` (`categoryid`, `categoryname`, `categorydescrip`, `leftval`, `rightval`) VALUES (24, 'horror', NULL, 9, 10);
INSERT INTO `categories_demo` (`categoryid`, `categoryname`, `categorydescrip`, `leftval`, `rightval`) VALUES (25, 'electricals', NULL, 14, 25);
INSERT INTO `categories_demo` (`categoryid`, `categoryname`, `categorydescrip`, `leftval`, `rightval`) VALUES (26, 'sound & vision', NULL, 15, 20);
INSERT INTO `categories_demo` (`categoryid`, `categoryname`, `categorydescrip`, `leftval`, `rightval`) VALUES (27, 'white goods', NULL, 21, 24);
INSERT INTO `categories_demo` (`categoryid`, `categoryname`, `categorydescrip`, `leftval`, `rightval`) VALUES (28, 'mp3 players', NULL, 16, 17);
INSERT INTO `categories_demo` (`categoryid`, `categoryname`, `categorydescrip`, `leftval`, `rightval`) VALUES (33, 'dvd players', NULL, 18, 19);
INSERT INTO `categories_demo` (`categoryid`, `categoryname`, `categorydescrip`, `leftval`, `rightval`) VALUES (34, 'science fiction', NULL, 11, 12);
INSERT INTO `categories_demo` (`categoryid`, `categoryname`, `categorydescrip`, `leftval`, `rightval`) VALUES (35, 'westerns', NULL, 5, 6);
INSERT INTO `categories_demo` (`categoryid`, `categoryname`, `categorydescrip`, `leftval`, `rightval`) VALUES (36, 'washing machines', NULL, 22, 23);
        
