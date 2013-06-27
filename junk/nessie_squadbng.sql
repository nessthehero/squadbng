-- phpMyAdmin SQL Dump
-- version 2.11.2.1
-- http://www.phpmyadmin.net
--
-- Host: mysql.legendaryawesome.com
-- Generation Time: Jan 16, 2008 at 09:48 PM
-- Server version: 5.0.18
-- PHP Version: 4.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `nessie_squadbng`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `inbng` varchar(10) NOT NULL default '',
  `timeinbng` text NOT NULL,
  `bng_username` varchar(50) NOT NULL default '',
  `learn_about` varchar(15) NOT NULL default '',
  `referred_by` text NOT NULL,
  `ness` varchar(10) NOT NULL default '',
  `gb` varchar(10) NOT NULL default '',
  `know_staff` text NOT NULL,
  `gender` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `applications`
--


-- --------------------------------------------------------

--
-- Table structure for table `avatars`
--

CREATE TABLE IF NOT EXISTS `avatars` (
  `id` int(11) NOT NULL auto_increment,
  `user` text,
  `name` text,
  `file` text,
  `def` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `avatars`
--

INSERT INTO `avatars` (`id`, `user`, `name`, `file`, `def`) VALUES
(7, '18', 'Ness (Talk)', 'admin/avatars/nesstalk.gif', 1),
(10, '56', 'Reality', 'admin/avatars/MSN.jpg', 1),
(5, '19', 'TJ Art Avatar', 'admin/avatars/TJArtAvSmall.gif', 1),
(17, '96', 'FEAR...', 'admin/avatars/fearsig.jpg', 1),
(14, '21', 'Zuh', 'admin/avatars/Strikerwhatsm.jpg', 1),
(16, '21', 'Thumbs Up Alt', 'admin/avatars/strikeyocomplete.gif', 1),
(49, '122', 'wtfstache', 'admin/avatars/1151498788684.gif', 1),
(34, '64', 'Tails Doll', 'admin/avatars/TailsDoll.png', 1),
(22, '37', 'Tripical Paradise', 'admin/avatars/Avy1.PNG', 1),
(23, '22', 'Narutlo, Manga', 'admin/avatars/naruavatarnew.jpg', 1),
(26, '40', 'helmet', 'admin/avatars/helmet1.PNG', 1),
(28, '76', 'The Darkest loom', 'admin/avatars/darchon.gif', 1),
(29, '24', 'Conan!', 'admin/avatars/conanhead.PNG', 1),
(30, '23', 'Grath''s Avatar', 'admin/avatars/AvatarNew.png', 1),
(31, '75', 'Klonoa!', 'admin/avatars/Klonoa2.gif', 1),
(32, '28', 'Fiiiiiight', 'admin/avatars/15aaf598.gif', 0),
(33, '68', 'Magnus', 'admin/avatars/magava.gif', 1),
(42, '115', 'Raar?', 'admin/avatars/gywallMSN.png', 1),
(36, '29', 'NewSquadAv', 'admin/avatars/newsquadav.PNG', 1),
(37, '104', 'AENIMA', 'admin/avatars/tool-aenima.jpg', 1),
(38, '108', 'yadaman', 'admin/avatars/yadaboo1yq.png', 1),
(39, '111', 'Megaman!!!', 'admin/avatars/Megaman.PNG', 1),
(40, '113', 'The Bringer of pain', 'admin/avatars/avatar_byakuya05.png', 1),
(43, '116', 'Pixel', 'admin/avatars/Comic014.gif', 1),
(44, '28', 'Soren and Cierra', 'admin/avatars/so+ci.jpg', 1),
(45, '55', 'Psycho Gemhead', 'admin/avatars/MonMSNPic.GIF', 1),
(46, '118', 'Scarved One', 'admin/avatars/TalonA-PointAv.png', 1),
(47, '121', 'Avatar', 'admin/avatars/IRLretsnip80G.gif', 1),
(48, '44', 'Avatar2', 'admin/avatars/=3.PNG', 1),
(50, '123', 'North', 'admin/avatars/chrisavatar7xx.png', 1),
(51, '125', 'flail', 'admin/avatars/zomgflail.png', 1),
(52, '77', 'Fireface', 'admin/avatars/OzyComplete_avy.gif', 1);

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

CREATE TABLE IF NOT EXISTS `awards` (
  `id` int(11) NOT NULL auto_increment,
  `img_id` int(11) NOT NULL default '0',
  `username` text NOT NULL,
  `level` int(11) NOT NULL default '0',
  `notes` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=199 ;

--
-- Dumping data for table `awards`
--

INSERT INTO `awards` (`id`, `img_id`, `username`, `level`, `notes`) VALUES
(2, 7, '18', 3, NULL),
(3, 7, '64', 3, NULL),
(4, 7, '24', 3, NULL),
(5, 7, '22', 3, NULL),
(6, 7, '29', 3, NULL),
(8, 7, '44', 3, NULL),
(73, 15, '22', 3, 'For anyone that hasnt annoyed GB in the past few weeks (1/24/07)'),
(10, 16, '21', 3, 'For his dedication to the Squad, even when he''s not supposed to be on the computer. :P'),
(11, 20, '18', 2, 'These were the players left when the tournament ended'),
(12, 20, '24', 2, 'These were the players left when the tournament ended'),
(74, 15, '56', 3, 'For anyone that hasnt annoyed GB in the past few weeks (1/24/07)'),
(15, 7, '68', 3, ''),
(17, 6, '75', 3, 'Raid on 8-11-05 at 11 PM'),
(18, 16, '18', 3, 'For granting us so much of your time, talents, and hard earned cash, this Purple Heart is awarded to NessTheHero by the members of Squad BnG.'),
(19, 16, '18', 3, 'For granting us so much of your time, talents, and hard earned cash, this Purple Heart is awarded to NessTheHero by the members of Squad BnG.'),
(20, 7, '21', 3, ''),
(21, 6, '56', 3, 'Raid 11/25/05'),
(22, 6, '24', 3, 'Raid 11/25/05'),
(23, 10, '56', 5, 'Yay!'),
(24, 10, '86', 5, 'Yay!'),
(25, 10, '29', 5, 'Yay!'),
(27, 10, '18', 5, 'Yay!'),
(28, 10, '64', 5, 'Yay!'),
(29, 10, '24', 5, 'Yay!'),
(30, 9, '65', 5, 'For being in chat when I said it.'),
(31, 9, '56', 5, 'For being in chat when I said it.'),
(32, 9, '86', 5, 'For being in chat when I said it.'),
(33, 9, '75', 5, 'For being in chat when I said it.'),
(34, 9, '29', 5, 'For being in chat when I said it.'),
(36, 9, '18', 5, 'For being in chat when I said it.'),
(37, 9, '73', 5, 'For being in chat when I said it.'),
(38, 9, '64', 5, 'For being in chat when I said it.'),
(39, 9, '24', 5, 'For being in chat when I said it.'),
(41, 6, '56', 3, 'Whoo!'),
(42, 8, '56', 5, ''),
(43, 8, '37', 5, ''),
(44, 6, '18', 3, 'Raid 11/30/2005'),
(45, 10, '91', 5, ''),
(46, 6, '56', 3, 'For doing three people''s worth of fighting in a three man raid, Cuddy was most definately the MVP.'),
(47, 8, '86', 5, 'For having a front page YTMND. Forai, king of repetitive sound files accompanied by images.'),
(48, 16, '29', 3, 'I''m just that awesome'),
(49, 9, '56', 5, 'ASStralia! lolol.'),
(61, 23, '24', 1, 'Won by Uru on March 22nd, 2006.'),
(59, 25, '68', 3, 'For creating the kickass drawing and sprite of TexBot'),
(60, 25, '37', 3, 'For coming up with the idea of a last word function for TexBot'),
(56, 15, '44', 3, 'Gardius wanted another award, now he has one. GB also just wanted to give out a Good Conduct award.'),
(62, 25, '29', 3, 'It''s my award!'),
(63, 25, '18', 3, 'For getting TexBot''s EXP system figured out, mostly.'),
(64, 25, '77', 3, 'For his excellent work thus-far on the Tribes server'),
(65, 10, '24', 5, 'He saved the chat from GB''s wrath'),
(66, 26, '29', 1, 'Won by 29 on November 12th, 2006.'),
(67, 15, '44', 3, 'For your work in getting the BOTS tournament together'),
(68, 15, '19', 3, 'For your work in getting the BOTS tournament together'),
(69, 10, '121', 5, 'For being the only one with any semblance of motivation to get his matches done for the Cyberworld Warriors tournament. You are truly exemplary.'),
(70, 9, '77', 5, 'For being the only one to show some love for Tails. Hooray for Ozy!'),
(71, 10, '118', 5, 'For listening to the Tetris A-Theme for 99:99'),
(72, 28, '44', 1, 'Won by 44 on December 29th, 2006.'),
(75, 15, '75', 3, 'For anyone that hasnt annoyed GB in the past few weeks (1/24/07)'),
(76, 15, '44', 3, 'For anyone that hasnt annoyed GB in the past few weeks (1/24/07)'),
(77, 15, '28', 3, 'For anyone that hasnt annoyed GB in the past few weeks (1/24/07)'),
(78, 15, '37', 3, 'For anyone that hasnt annoyed GB in the past few weeks (1/24/07)'),
(79, 15, '30', 3, 'For anyone that hasnt annoyed GB in the past few weeks (1/24/07)'),
(80, 15, '68', 3, 'For anyone that hasnt annoyed GB in the past few weeks (1/24/07)'),
(81, 15, '77', 3, 'For anyone that hasnt annoyed GB in the past few weeks (1/24/07)'),
(82, 15, '73', 3, 'For anyone that hasnt annoyed GB in the past few weeks (1/24/07)'),
(83, 15, '64', 3, 'For anyone that hasnt annoyed GB in the past few weeks (1/24/07)'),
(84, 15, '21', 3, 'For anyone that hasnt annoyed GB in the past few weeks (1/24/07)'),
(85, 15, '19', 3, 'For anyone that hasnt annoyed GB in the past few weeks (1/24/07)'),
(86, 15, '118', 3, 'For anyone that hasnt annoyed GB in the past few weeks (1/24/07)'),
(87, 15, '124', 3, 'For anyone that hasnt annoyed GB in the past few weeks (1/24/07)'),
(88, 15, '24', 3, 'For anyone that hasnt annoyed GB in the past few weeks (1/24/07)'),
(89, 16, '19', 3, 'A ninja did it'),
(90, 9, '65', 5, 'Stars for everyone!'),
(91, 9, '93', 5, 'Stars for everyone!'),
(92, 9, '22', 5, 'Stars for everyone!'),
(93, 9, '50', 5, 'Stars for everyone!'),
(94, 9, '123', 5, 'Stars for everyone!'),
(95, 9, '56', 5, 'Stars for everyone!'),
(96, 9, '120', 5, 'Stars for everyone!'),
(97, 9, '86', 5, 'Stars for everyone!'),
(98, 9, '91', 5, 'Stars for everyone!'),
(99, 9, '102', 5, 'Stars for everyone!'),
(100, 9, '75', 5, 'Stars for everyone!'),
(101, 9, '44', 5, 'Stars for everyone!'),
(102, 9, '29', 5, 'Stars for everyone!'),
(103, 9, '23', 5, 'Stars for everyone!'),
(104, 9, '28', 5, 'Stars for everyone!'),
(105, 9, '117', 5, 'Stars for everyone!'),
(106, 9, '37', 5, 'Stars for everyone!'),
(107, 9, '30', 5, 'Stars for everyone!'),
(108, 9, '68', 5, 'Stars for everyone!'),
(109, 9, '101', 5, 'Stars for everyone!'),
(110, 9, '55', 5, 'Stars for everyone!'),
(111, 9, '125', 5, 'Stars for everyone!'),
(112, 9, '18', 5, 'Stars for everyone!'),
(113, 9, '77', 5, 'Stars for everyone!'),
(114, 9, '73', 5, 'Stars for everyone!'),
(115, 9, '64', 5, 'Stars for everyone!'),
(116, 9, '122', 5, 'Stars for everyone!'),
(117, 9, '121', 5, 'Stars for everyone!'),
(118, 9, '40', 5, 'Stars for everyone!'),
(119, 9, '21', 5, 'Stars for everyone!'),
(120, 9, '19', 5, 'Stars for everyone!'),
(121, 9, '118', 5, 'Stars for everyone!'),
(122, 9, '124', 5, 'Stars for everyone!'),
(123, 9, '24', 5, 'Stars for everyone!'),
(124, 9, '74', 5, 'Stars for everyone!'),
(125, 9, '108', 5, 'Stars for everyone!'),
(126, 30, '118', 3, 'Winner of the Continuum raid on the first night of Winter-een-mas 2007'),
(127, 6, '118', 3, '1/25/2007'),
(128, 10, '18', 5, 'For being fuckin incredible at absolutely everything without having to have proof of it.'),
(129, 8, '118', 5, 'For having too many goddamn stars.'),
(130, 9, '24', 5, 'For disagreeing too much.'),
(131, 9, '55', 5, 'Because he said the words "Bronze" and "Star" in that order.'),
(132, 10, '68', 5, 'For completely sucking'),
(133, 8, '64', 5, 'We did not have three stars, so he just got this one.'),
(134, 10, '29', 5, 'For having the most powerful weapon ever created permanently attached to his wrist.'),
(135, 8, '64', 5, 'For being a big whore.'),
(136, 9, '55', 5, 'For finally accepting that Ness is better than him.'),
(137, 9, '118', 5, 'For the ability to see into the future.'),
(138, 9, '55', 5, 'For breaking the rules of Squad BnG.'),
(139, 10, '18', 5, 'For giving out STARS LIKE WOAH.'),
(140, 9, '64', 5, 'For having a completely lame super power.'),
(141, 9, '18', 5, 'For being fat.'),
(142, 10, '65', 5, 'For not being Mew.'),
(143, 10, '93', 5, 'For not being Mew.'),
(144, 10, '22', 5, 'For not being Mew.'),
(145, 10, '50', 5, 'For not being Mew.'),
(146, 10, '123', 5, 'For not being Mew.'),
(147, 10, '56', 5, 'For not being Mew.'),
(148, 10, '120', 5, 'For not being Mew.'),
(149, 10, '86', 5, 'For not being Mew.'),
(150, 10, '91', 5, 'For not being Mew.'),
(151, 10, '102', 5, 'For not being Mew.'),
(152, 10, '75', 5, 'For not being Mew.'),
(153, 10, '44', 5, 'For not being Mew.'),
(154, 10, '29', 5, 'For not being Mew.'),
(155, 10, '23', 5, 'For not being Mew.'),
(156, 10, '28', 5, 'For not being Mew.'),
(157, 10, '117', 5, 'For not being Mew.'),
(158, 10, '37', 5, 'For not being Mew.'),
(159, 10, '30', 5, 'For not being Mew.'),
(160, 10, '68', 5, 'For not being Mew.'),
(161, 10, '55', 5, 'For not being Mew.'),
(162, 10, '125', 5, 'For not being Mew.'),
(163, 10, '18', 5, 'For not being Mew.'),
(164, 10, '77', 5, 'For not being Mew.'),
(165, 10, '73', 5, 'For not being Mew.'),
(166, 10, '64', 5, 'For not being Mew.'),
(167, 10, '122', 5, 'For not being Mew.'),
(168, 10, '121', 5, 'For not being Mew.'),
(169, 10, '40', 5, 'For not being Mew.'),
(170, 10, '21', 5, 'For not being Mew.'),
(171, 10, '19', 5, 'For not being Mew.'),
(172, 10, '118', 5, 'For not being Mew.'),
(173, 10, '124', 5, 'For not being Mew.'),
(174, 10, '24', 5, 'For not being Mew.'),
(175, 10, '74', 5, 'For not being Mew.'),
(176, 10, '108', 5, 'For not being Mew.'),
(177, 30, '29', 3, 'Winner of a LandGrab game on the second night of Winter-een-mas 2007'),
(178, 30, '19', 3, 'Winner of the second LandGrab game on the second night of Winter-een-mas'),
(179, 30, '64', 3, 'Winner (Traitor who successfully accomplished his mission) of the SS13 game on the third night of Winter-een-mas 2007  \r\n'),
(180, 30, '44', 3, 'Winner of the TetriNET event on the fourth night of Winter-een-mas 2007 '),
(181, 30, '24', 3, 'For being the MVP of the Continuum Raid on the fifth day of Wintereenmas 2007'),
(182, 30, '64', 3, 'For being the MVP of the Continuum raid on the fifth day of Wintereenmas 2007'),
(183, 6, '24', 3, 'Raid 1/29/07'),
(184, 30, '124', 3, 'Won for the StarCraft game on the sixth day of Wintereenmas 2007'),
(185, 30, '28', 3, 'Won for the StarCraft game on the sixth day of Wintereenmas 2007'),
(186, 6, '64', 3, '1/31/07'),
(187, 6, '124', 3, '1/31/07'),
(188, 30, '64', 3, 'For being the MVP of the Continuum raid on the 7th night of Winter-een-mas'),
(189, 30, '124', 3, 'For being the MVP of the Continuum raid on the 7th night of Winter-een-mas'),
(190, 30, '22', 3, 'Best WC3 player Winter-een-mas 2007'),
(191, 30, '29', 3, 'Best LandGrab player Winter-een-mas 2007'),
(192, 30, '23', 3, 'Best Wolfenstein: Enemy Territory player Winter-een-mas 2007'),
(193, 30, '121', 3, 'Best SS13 player Winter-een-mas 2007'),
(194, 30, '118', 3, 'Best Kawaks player Winter-een-mas 2007'),
(195, 30, '124', 3, 'Best TetriNET player Winter-een-mas 2007'),
(196, 30, '24', 3, 'Best Continuum player Winter-een-mas 2007'),
(197, 30, '19', 3, 'Best StarCraft player Winter-een-mas 2007'),
(198, 29, '124', 1, 'Won by 124 on February 4th, 2007.');

-- --------------------------------------------------------

--
-- Table structure for table `buttons`
--

CREATE TABLE IF NOT EXISTS `buttons` (
  `id` int(11) NOT NULL auto_increment,
  `path` text,
  `dest` text,
  `type` varchar(5) default NULL,
  `type_id` int(11) default NULL,
  `active` char(3) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `buttons`
--

INSERT INTO `buttons` (`id`, `path`, `dest`, `type`, `type_id`, `active`) VALUES
(1, 'menuMAIN.PNG', 'main.php', 'admin', 1, 'yes'),
(2, 'menuMEMBERS.PNG', 'listaccounts.php', 'admin', 2, 'yes'),
(22, 'menuBAN.PNG', 'ban.php', 'judge', 6, 'yes'),
(4, 'menuGAMES.PNG', 'games.php', 'admin', 8, 'yes'),
(26, 'menuBNGWARS.PNG', 'tournament.php', 'judge', 2, 'yes'),
(25, 'menuMATCH.PNG', 'match.php', 'judge', 3, 'yes'),
(24, 'menuMAIL.PNG', 'mail.php', 'judge', 5, 'yes'),
(23, 'menuRULES.PNG', 'rules.php', 'judge', 8, 'yes'),
(10, 'menuBUTTONS.PNG', 'buttons.php', 'admin', 6, 'yes'),
(11, 'menuHOME.PNG', 'home.php', 'squad', 1, 'yes'),
(12, 'menuJOIN.PNG', 'apply.php', 'squad', 2, 'yes'),
(14, 'menuBNGWARS.PNG', 'bngwars.php', 'squad', 8, 'yes'),
(15, 'menuMEMBERS.PNG', 'members.php', 'squad', 9, 'yes'),
(17, 'menuLINKS.PNG', 'links.php', 'squad', 11, 'yes'),
(18, 'menuFAQ.PNG', 'faq.php', 'squad', 11, 'yes'),
(19, 'menuAPPLICATIONS.PNG', 'applications.php', 'admin', 5, 'yes'),
(27, 'menuNEWS.PNG', 'news.php', 'judge', 1, 'yes'),
(28, 'menuAWARDS.PNG', 'award.php', 'admin', 3, 'yes'),
(31, 'menuDOWNLOADS.png', 'downloads.php', 'squad', 6, 'yes'),
(32, 'menuGAMES.PNG', 'game.php', 'squad', 7, 'yes'),
(33, 'menuFORUMS.PNG', 'forum/', 'squad', 4, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL auto_increment,
  `who` text NOT NULL,
  `comment` text NOT NULL,
  `title` text,
  `timestamp` datetime default '0000-00-00 00:00:00',
  `type` varchar(4) NOT NULL default '',
  `type_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=115 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `who`, `comment`, `title`, `timestamp`, `type`, `type_id`) VALUES
(5, '18', 'This is the first comment ever on the first post ever!', 'Test post', '2005-07-07 16:42:27', 'news', 1),
(6, '22', 'Wait. We can comment now? Go Ness.', 'Whoa. Comments now?', '2005-07-08 15:08:08', 'news', 10),
(7, '30', 'Me and TJ have gotten a large portion of the squad to begin playing Starcraft(SC) again, after many long months. So if anyone''s interested in joining the fun, you can contact me on the forums, but all games to date have been organized on the spot in the IRC chat room. So you''ll likely have to talk to me or TJ, or anyone else that want''s to play there. I''m the SC master here so any questions you have I should be able to anwser, just post it the forums.', 'We do too play games......', '2005-07-08 22:10:41', 'news', 10),
(8, '22', 'You may be better at SC, but I''m a mod of that forum bit too. Before you were, I''ll have you know. XP', 'Hey.', '2005-07-08 23:07:04', 'news', 10),
(9, '19', 'E-mail''s been all changed up.', '', '2005-07-28 14:44:15', 'news', 11),
(10, '29', 'Changed, but don''t send me anything important, because I don''t check my Gmail.', '', '2005-07-29 02:23:13', 'news', 11),
(11, '22', 'Um, then what''s the point of having the E-mail on there?', '', '2005-07-31 16:46:09', 'news', 11),
(12, '18', 'You get stuff in the mail, doofus. Like tournament notices and when me and GB feel like telling the whole squad stuff.', '', '2005-07-31 20:26:01', 'news', 11),
(13, '56', 'woah, I didn''t even realise until I checked my mail and had 4 copies of the same 2 pieces of mail O.o', '', '2005-08-02 19:26:08', 'news', 11),
(14, '19', 'I can''t replace you Ness, but I''ll certianly do my best to keep things running smoothly around here.', '', '2005-08-26 16:58:07', 'news', 12),
(15, '44', 'It was great having you here on the squad and you definately will be missed during the time you''re gone. May the future treat you well.', '', '2005-08-26 21:11:16', 'news', 12),
(16, '22', 'Gonna miss you a ton, man. :/ Won''t be the same withouit you and C-bot around.', '', '2005-08-27 11:29:17', 'news', 12),
(17, '28', 'Good riddance. >:P\r\nI kid, I kid. We''ll miss you much.', '', '2005-08-30 21:25:01', 'news', 12),
(18, '21', 'I second what TJ said in that I''ll do my best to follow up. Good luck out at school.', '', '2005-09-06 13:30:00', 'news', 12),
(19, '56', 'site is the win, ness. very spiffy, you sure do know that stuff that I have no idea about.\r\n', '', '2006-02-21 23:33:42', 'news', 13),
(28, '68', 'Everything looks great, Ness. Great additions to the site.', 'Awesomeness', '2006-02-23 17:03:13', 'news', 13),
(26, '18', 'test', 'test', '2006-02-23 08:11:37', 'news', 13),
(29, '40', 'I signed in! Surprise!!!', 'Um....', '2006-02-26 20:55:46', 'news', 13),
(39, '18', 'Gimme back mah news!\r\n\r\n>:O', 'OI!', '2006-03-14 13:49:45', 'news', 16),
(34, '68', 'rofl lmao lolz\r\n\r\nHappy brithday T.J ^_^', 'lawlz', '2006-03-08 17:34:30', 'news', 15),
(30, '18', 'Sei lives! Huzzah! Girls are actually in teh squad!', 'Holy crap', '2006-02-27 10:43:19', 'news', 13),
(31, '37', 'Oh, so now I am not GOOD enough for you, Ness? ;_; \r\n\r\nOh, and the site DOES look a lot spiffier. \r\nExcellent Work!', 'Offense!', '2006-03-05 13:47:45', 'news', 13),
(40, '19', ' Magnus news! :O\r\n\r\nI shall joinlee.\r\n\r\n\r\nNews ticker News ticker News ticker', 'omg', '2006-03-14 14:46:38', 'news', 16),
(35, '40', 'There is no freaking way he is 18. I don''t believe it. LIES!', 'holy crap', '2006-03-08 21:30:56', 'news', 15),
(36, '19', 'Thanks everyone! I feel loved.', '=D', '2006-03-09 14:04:59', 'news', 15),
(37, '22', 'Damn. Now I''m gonna be like the 3rd or 4th person to be 18. Curses.', ':O', '2006-03-09 17:43:53', 'news', 15),
(38, '44', 'Sorry i''m late by 3 days, but congrats. You managed to survive another year without dying. :D', 'Late response', '2006-03-12 19:06:01', 'news', 15),
(41, '56', 'happy late b''day TJ. now, where''s my news post? ;_; my birthday was on pi day, for crying out loud. XD', 'Oh snap', '2006-03-15 14:16:19', 'news', 15),
(42, '21', 'So totally in on this.\r\n', 'HAY YEW', '2006-03-18 16:40:31', 'news', 16),
(43, '29', 'I would, but I don''t want to. Ever since we last left TWD, I haven''t been that fond of it. However, I''ll gladly support those of you who decide to play', 'Erm...', '2006-03-18 18:50:33', 'news', 16),
(44, '68', 'n00b\r\n\r\n... I love this comment feature.', 'lawlz', '2006-03-18 21:14:02', 'news', 16),
(45, '18', 'Gimme back mah comments!\r\n\r\n>:O', 'OI!', '2006-03-19 18:22:34', 'news', 16),
(46, '18', 'We just hate you.', 'ASStralia', '2006-03-29 14:39:30', 'news', 15),
(47, '18', 'Autograph requests must be submitted in writing, with 5 dollars enclosed.', '', '2006-04-18 09:33:42', 'news', 18),
(48, '19', 'Though I too am coming up on the close of my senior year, you can expect to see me around. I should be handy most of the time. Except I can''t work any of TexBot''s functions, so don''t ask. =P\r\n\r\n*hands Ness an envelope with $5 Monoploy money*', 'Pish-posh', '2006-04-19 10:05:56', 'news', 18),
(49, '22', 'I might send you some cash after I grab a job. But I''ll probably be using that money to like, eat, and stuff. We''ll see. Also, not like we''ve used the Radio script in the last ever.', 'I''d send it if I had it', '2006-04-29 23:14:44', 'news', 19),
(50, '22', 'I''m not here much either, but that''s mostly due to trying to get a job. :/', '', '2006-04-29 23:15:47', 'news', 18),
(51, '24', 'I blame Cuddy', 'Cuddy', '2006-06-05 21:06:27', 'news', 21),
(52, '18', 'Me too', '', '2006-06-12 11:52:32', 'news', 21),
(53, '68', 'Curse you, Cuddy.', '', '2006-06-14 23:47:06', 'news', 21),
(54, '44', 'Dammit, Cuds.', '', '2006-06-19 21:26:06', 'news', 21),
(55, '68', 'I think it''d be a great idea. Granted, I like the site as it is now, but it isn''t used. At all. Plus I might get to do more graphic stuff. =D', '', '2006-08-15 17:37:21', 'news', 22),
(56, '44', 'I say maybe have a subdirectory to the Eden site, but not completely dump the Squad BnG. If you must dump the site at least keep the page script in case the server doesn''t do as well as we originally thought.', '', '2006-08-15 17:37:29', 'news', 22),
(57, '91', 'I would agree with Gardius - not that it really affects me, since I don''t actually play RO or anything. :P\r\n\r\nBesides - what if you get bored of RO?', '', '2006-08-15 17:40:15', 'news', 22),
(58, '19', 'Seconded. Despite the fact that we never use this site, I would hate to see it go completely. So, change to an EdenRO site, but save the Squad site script. Maybe when I get a job I can toss a few dollars your way and we may be able to keep up both at once.', '', '2006-08-15 17:40:59', 'news', 22),
(59, '29', 'Is there any way that the RO stuff could be integrated into the current site? Sorta like what Gardius is saying, I guess.', '', '2006-08-15 17:47:30', 'news', 22),
(60, '77', 'Yeah, keep this site at least.', 'Lolhaxx', '2006-08-15 17:47:31', 'news', 22),
(61, '24', 'I blame Cuddy', '', '2006-08-15 18:17:49', 'news', 22),
(62, '77', 'I blame Grath', '', '2006-08-17 15:16:09', 'news', 22),
(63, '22', 'Ditch the squad site? Is you on crack!?!? RO might be what we''re playing now, but a year down the road it will be as dead and forgotten as Continuum, Tetrinet, and Gunbound. The squad prevails despite the popularity of any particular games. Certainly have a RO part of the site, but we must all remember that the squad is gonna be around a lot longer than us playing RO.', 'o.O', '2006-08-17 15:24:00', 'news', 22),
(64, '86', 'Dare I say it, I''m actually with blade on this one. But if you want something to do with the server, why not actually host the RO server. it doesn''t take that much of your computer''s power surprisingly, I finally got my server back up so I''m typing this as I host it.', 'wow.', '2006-08-18 07:52:08', 'news', 22),
(65, '21', 'I don''t know whether it will die out completely. There''ll probably retain a small number of people on the server at any point after this, I think, because RO is that addictive, and assuming we get new members, lots of them will filter through there.\r\n\r\nBut no, I think the site ought to stay. I like it the way it is.', 'Going with the majority.', '2006-08-18 08:55:49', 'news', 22),
(66, '112', 'Im still kinda new to this site but I do have to go with the majority on this one. Like GB330033 asked I must ask the same question.', 'majority rules', '2006-08-29 16:11:28', 'news', 22),
(67, '18', 'You forget that I get infinity billion votes.', 'Infinity', '2006-08-31 12:42:11', 'news', 22),
(68, '77', 'Forum restoration = very yes', 'Is that so, my good man?', '2006-09-18 11:40:25', 'news', 24),
(69, '77', 'Perhaps we are just that awesome', '', '2006-09-27 14:09:38', 'news', 26),
(70, '77', 'Also, for some reason every time I try to use an apostrophe in a comment I get a MySQL error', '', '2006-09-27 14:10:17', 'news', 26),
(71, '18', 'I will kill you for every apostrophe I find.\r\n\r\nAlso, thank you for mentioning it.', 'die', '2006-09-27 17:31:22', 'news', 26),
(72, '55', 'I&#039;m going gainst TJ? I might win! :O', ':O!', '2006-10-10 15:03:02', 'news', 27),
(73, '19', 'I would take offense at that, except it&#039;s true. XD', 'Arar', '2006-10-11 14:11:22', 'news', 27),
(74, '77', 'Srsly tho, CHOP CHOP (as both a phrase meaning &quot;hurry up&quot;, and as a phrase describing what my bot&#039;s gonna do to the competition. &#039;Cuz the other bots are gonna die.)', 'yay viorance!', '2006-10-18 18:06:53', 'news', 29),
(75, '28', 'Srsly tho, you know how busy uni can be. :P', 'o rly?', '2006-10-21 10:14:15', 'news', 29),
(76, '18', 'I just don&#039;t get how everyone else in college right now doesn&#039;t have the same amount of the assloads of free time as I have.', '', '2006-10-21 16:33:15', 'news', 29),
(77, '120', 'olo no wai tournamuntz. I wun inz.', 'LOL YAI', '2006-11-21 10:37:39', 'news', 30),
(78, '118', 'Ah, it didn&#039;t take long for this idea to spring up. I&#039;ll be wanting in, then.', 'Whoo', '2006-11-21 12:19:19', 'news', 30),
(79, '24', 'Tournaments where play time and not skills make a difference are laem', '', '2006-11-21 12:57:24', 'news', 30),
(80, '19', 'I didn&#039;t want to put these up yet, but in order to draw more people in, I shall.\r\n\r\nhttp://www.geocities.com/turboquestertj/BOTSTourneyRules.txt\r\n\r\nThe rules for the tourney.', '', '2006-11-21 19:17:34', 'news', 30),
(81, '44', 'Let me just note for that i&#039;ll be supplying some of the prizes for the tournament which consists of MVP items. They&#039;re mostly Ram parts, but chances are you can sell them for a good amount.', '', '2006-11-23 23:34:23', 'news', 30),
(82, '93', 'Sweet. I&#039;m in. \r\n\r\nAbout the &quot;-They will start with, and are limited to, bbase equipment, plus a \r\n base gun, and one Part upgrade&quot;, we&#039;ll have to level up to get a gun or something, unless you&#039;ll give them to us.', '', '2006-11-27 11:43:20', 'news', 30),
(83, '19', 'We will be giving you the basic gun and enough gigas for the part upgrade, if you cannot afford it with the money you start with.', '', '2006-11-28 07:34:25', 'news', 30),
(84, '121', 'I&#039;m in there like swimwear!\r\n\r\n(HUGE bonus points to anyone who knows that reference)', 'lol wut', '2006-12-02 11:34:43', 'news', 31),
(85, '18', 'Bonus Stage?\r\n\r\nIf it isn&#039;t, it sucks.', '', '2006-12-02 12:11:48', 'news', 31),
(86, '18', '28. If it exists, Blade probably hates it.', '', '2006-12-16 21:48:54', 'news', 33),
(88, '18', '29. If Blade doesn&#039;t hate it, it&#039;s probably made from liquid awesome and win.', '', '2006-12-16 21:54:29', 'news', 33),
(89, '77', 'Best rules ever.', 'Yyyyyeah...', '2006-12-18 07:10:48', 'news', 33),
(90, '77', 'Bots is dumb. :(', '', '2006-12-18 07:11:16', 'news', 32),
(91, '121', 'Possible 21.5: If you are reading this, you must go through TJ.\r\n\r\n(rulez r teh pwnge btw)', '', '2006-12-20 19:00:26', 'news', 33),
(92, '44', 'O&#039;Reiley?', '', '2006-12-22 15:18:06', 'news', 34),
(93, '55', 'Possible 30. If Blade does not hate it and rule 29 does not apply, it is some from of kittens.\r\n', '', '2006-12-23 06:58:48', 'news', 33),
(94, '118', '31: Ness is no longer allowed to say &quot;cherry&quot;.', '', '2006-12-25 14:42:19', 'news', 33),
(95, '55', 'The world is doomed, Wii Internetz.\r\n\r\nAlso, Ya Ridley.\r\n', 'OSHI-', '2006-12-25 20:07:58', 'news', 34),
(96, '101', 'Dammit, Ness, stop showing off.', '', '2006-12-27 14:12:24', 'news', 34),
(97, '18', 'No', '', '2006-12-27 18:24:56', 'news', 34),
(98, '86', 'Me too. :3', 'hey', '2007-01-12 23:50:59', 'news', 34),
(99, '118', 'I don&#039;t like the art of fighting, but I&#039;m gonna be the king of fighters!\r\n\r\nNo, I lie. FIGHTING! WHOO!', '', '2007-01-25 04:58:39', 'news', 36),
(100, '24', 'I disagree', '', '2007-01-25 11:53:25', 'news', 36),
(101, '19', 'At the moment angry helicopter dad, anime conventions, and high price summer coursework are putting a big press on my cash flow and paternal leniency.\r\n\r\nIf I can manage to find some money and persuade my dad that not everyone on the internet is a nazizombirapist, then I might be able to go. My mother believes that I&#039;m entirely capable of a trip like this, but ex-spouses don&#039;t always value each other&#039;s opinions. Ah, the joys of divorce.', 'On the fence', '2007-05-25 07:16:38', 'news', 37),
(102, '28', 'What?\r\n\r\nMeet-up for squadmembers to play games, have fun, and generally get to know each other beyond soulless text from an IRC client.\r\n\r\nWho?\r\n\r\nAnyone (mostly) who is capable of making their way to Stratford, Ontario for the week of August 11th to 18th.\r\n\r\nWhere?\r\n\r\nStratford, doi. We&#039;ll be varying between Tear, Nami and my own houses most likely.\r\n\r\nWhen?\r\n\r\nAugust 11-18th.\r\n\r\nHow?\r\n\r\nTransportation will be arranged for people if they are arriving from airport, though the sooner you can let us know when your flight gets in the better. Sleeping arrangements are iffy right now, but we will have a place for everyone.\r\n\r\nWhy?\r\n\r\nBecause we can.\r\n\r\n---\r\n\r\nThe sooner you can let me know your status on the trip, the better.', 'Known details.', '2007-05-25 10:46:10', 'news', 37),
(104, '118', 'I have none of these issues. Yay for me. I almost forgot about this trip too. Heh.', 'Yay for me', '2007-05-25 23:30:37', 'news', 37),
(105, '77', 'That&#039;s what SHE said.', 'Original content follows:', '2007-05-27 13:49:27', 'news', 37),
(106, '28', 'No U.', 'Unoriginal content follows:', '2007-05-27 16:10:37', 'news', 37),
(107, '28', 'Nami has brought up the idea that people may want to find a flight to London Int&#039;l Airport. Will post more details later.', 'Before I forget...', '2007-05-27 16:12:31', 'news', 37),
(108, '28', 'Nami has brought up the idea that people may want to find a flight to London Int&#039;l Airport. Will post more details later.', 'Before I forget...', '2007-05-27 17:44:48', 'news', 37),
(109, '121', 'I&#039;d love to go/come, but I&#039;m going to be gone until August 28th or 29th, around there. I expect many pictures to be pic&#039;d, and inside jokes to be retold.', 'Hm.', '2007-06-01 23:18:30', 'news', 37),
(110, '118', 'omg no retro u hav 2 come', ':O', '2007-06-02 12:40:47', 'news', 37),
(111, '77', 'That&#039;s what SHE s--okay, you know what? Even *I* am starting to hate that joke. I&#039;ll just shut up now.', '', '2007-06-05 10:57:49', 'news', 37),
(112, '28', 'You all suck.\r\n\r\nNew date I&#039;m looking at is around the 11-18th of December.\r\n\r\nPut some fucking effort in, folks.', 'If this could be limed for truth, it would.', '2007-07-29 00:16:02', 'news', 38),
(113, '77', 'My only complaint is when you act like games you don&#039;t like are stupid and need to be mocked mercilessly.\r\n\r\nAnd yeah, we need to play more FPS games.', '', '2007-09-19 18:51:53', 'news', 39),
(114, '55', 'I concur.', '', '2007-09-23 18:28:41', 'news', 39);

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE IF NOT EXISTS `downloads` (
  `id` int(11) NOT NULL auto_increment,
  `src` text NOT NULL,
  `name` text NOT NULL,
  `cat` varchar(4) NOT NULL default '',
  `description` text NOT NULL,
  `misc` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0 AUTO_INCREMENT=73 ;

--
-- Dumping data for table `downloads`
--

INSERT INTO `downloads` (`id`, `src`, `name`, `cat`, `description`, `misc`) VALUES
(13, 'http://www.squadbng.com/downloads/ness-wall.jpg', 'ness-wall.jpg', 'wall', '', 'Continuum'),
(12, 'http://www.squadbng.com/downloads/geebs-wall.jpg', 'geebs-wall.jpg', 'wall', '', 'Continuum'),
(11, 'http://www.squadbng.com/downloads/generic3-wall.jpg', 'generic3-wall.jpg', 'wall', '', 'Continuum'),
(9, 'http://www.squadbng.com/downloads/generic1-wall.jpg', 'generic1-wall.jpg', 'wall', '', 'Continuum'),
(10, 'http://www.squadbng.com/downloads/generic2-wall.jpg', 'generic2-wall.jpg', 'wall', '', 'Continuum'),
(14, 'http://www.squadbng.com/downloads/tj-wall.jpg', 'tj-wall.jpg', 'wall', '', 'Continuum'),
(15, 'http://www.squadbng.com/downloads/uru-wall.jpg', 'uru-wall.jpg', 'wall', '', 'Continuum'),
(16, 'http://www.squadbng.com/downloads/proto-wall.jpg', 'proto-wall.jpg', 'wall', '', 'Continuum'),
(17, 'http://www.squadbng.com/downloads/magnus-wall.jpg', 'magnus-wall.jpg', 'wall', '', 'Continuum'),
(18, 'http://www.squadbng.com/downloads/bot-wall.jpg', 'bot-wall.jpg', 'wall', '', 'Continuum'),
(19, 'http://www.squadbng.com/downloads/monk-wall.jpg', 'monk-wall.jpg', 'wall', '', 'Continuum'),
(20, 'http://www.squadbng.com/downloads/smilie-wall.jpg', 'smilie-wall.jpg', 'wall', '', 'Continuum'),
(21, 'http://www.squadbng.com/downloads/bng.bmp', 'bng.bmp', 'game', 'Banner', 'Continuum'),
(22, 'http://www.squadbng.com/downloads/bng2.bmp', 'bng2.bmp', 'game', 'Banner', 'Continuum'),
(23, 'http://www.squadbng.com/downloads/bng3.bmp', 'bng3.bmp', 'game', 'Banner', 'Continuum'),
(24, 'http://www.squadbng.com/downloads/bng4.bmp', 'bng4.bmp', 'game', 'Banner', 'Continuum'),
(25, 'http://www.squadbng.com/downloads/bng5.bmp', 'bng5.bmp', 'game', 'Banner', 'Continuum'),
(26, 'http://www.squadbng.com/downloads/bng7.bmp', 'bng7.bmp', 'game', 'Banner', 'Continuum'),
(27, 'http://www.squadbng.com/downloads/bngships.bm2', 'bngships.bm2', 'game', 'Shipset', 'Continuum'),
(28, 'http://www.squadbng.com/downloads/icecream.bm2', 'icecream.bm2', 'game', 'Flag', 'Continuum'),
(29, 'http://www.squadbng.com/downloads/bngbullets.bm2', 'bngbullets.bm2', 'game', 'Bullets', 'Continuum'),
(30, 'http://www.squadbng.com/downloads/poink.bm2', 'poink.bm2', 'game', 'Repel', 'Continuum'),
(31, 'http://www.squadbng.com/downloads/pfoof.bm2', 'pfoof.bm2', 'game', 'Warp', 'Continuum'),
(32, 'http://www.squadbng.com/downloads/portal.bm2', 'portal.bm2', 'game', 'Warp Point', 'Continuum'),
(33, 'http://www.squadbng.com/downloads/7-3-05.rep', '7-3-05.rep', 'game', 'Replay', 'Starcraft'),
(34, 'http://www.squadbng.com/downloads/7-5-05.rep', '7-5-05.rep', 'game', 'Replay', 'Starcraft'),
(35, 'http://www.squadbng.com/downloads/mrsaturn.bmp', 'mrsaturn.bmp', 'game', 'Banner/Mr. Saturn', 'Continuum'),
(36, 'http://www.squadbng.com/downloads/burnalmighty.mp3', 'burnalmighty.mp3', 'misc', 'Chatroom sound', 'Continuum'),
(37, 'http://www.squadbng.com/downloads/EpicBattle.rep', 'EpicBattle.rep', 'game', 'Replay', 'Starcraft'),
(38, 'http://www.squadbng.com/downloads/sound pack.zip', 'sound pack.zip', 'misc', 'Chatroom sound pack', ''),
(39, 'http://www.squadbng.com/downloads/sound pack.zip', 'sound pack.zip', '', '', ''),
(40, 'http://www.squadbng.com/downloads/1YearAnniversary.txt', '1YearAnniversary.txt', 'misc', '1st Anniversary Celebration Log', 'Continuum'),
(41, 'http://www.squadbng.com/downloads/update080405.zip', 'update080405.zip', 'misc', 'Update to sound pack', 'Continuum'),
(42, 'http://www.squadbng.com/downloads/WORSTGAMEEVER.rep', 'WORSTGAMEEVER.rep', 'game', 'THIS DOES NOT EXIST', 'Starcraft'),
(43, 'http://www.squadbng.com/downloads/jhangs_soundpack.zip', 'jhangs_soundpack.zip', 'misc', 'Jhang''s addition to the soundpack', 'Continuum'),
(44, 'http://www.squadbng.com/downloads/baconman.wav', 'baconman.wav', 'misc', 'The baconman song!', NULL),
(45, 'http://www.squadbng.com/downloads/squadbeamwallpsd6hl.jpg', 'squadbeamwallpsd6hl.jpg', 'wall', 'Magnus is awesome', 'Continuum'),
(46, 'http://www.squadbng.com/downloads/BnG Squad List.txt', 'BnG Squad List.txt', 'misc', 'List of the first 60 or so squadmembers, way back before the site or the forums existed.', 'Continuum'),
(47, 'http://squadbng.com/downloads/tourofawe1024x768.jpg', 'tourofawe1024x768.jpg', 'wall', 'Wallpaper celebrating the completion of the Tournament of Awesome, and it''s winner, UrutoraD.', 'Continuum'),
(48, 'http://www.squadbng.com/downloads/ventrilo_2[1].1.1.exe', 'ventrilo_2[1].1.1.exe', 'misc', 'Ventrilo client version 2.1. You need this if you want to access Madarrow''s vent server.', 'Continuum'),
(49, 'http://www.squadbng.com/downloads/texbot.bot', 'texbot.bot', 'game', '', 'RoboForge'),
(50, 'http://www.squadbng.com/downloads/NegiBot.bot', 'NegiBot.bot', 'game', '', 'RoboForge'),
(51, 'http://www.squadbng.com/downloads/texbotvskingass.zip', 'texbotvskingass.zip', 'game', 'Tournament Final', 'RoboForge'),
(52, 'http://www.squadbng.com/downloads/grodusvstexbot.zip', 'grodusvstexbot.zip', 'game', 'Tournament semi-final', 'RoboForge'),
(53, 'http://www.squadbng.com/downloads/kingassvsnegibot.zip', 'kingassvsnegibot.zip', 'game', 'Tournament semi-final', 'RoboForge'),
(54, 'http://www.squadbng.com/downloads/texbotvsgrinbot.zip', 'texbotvsgrinbot.zip', 'game', 'Tournament round 1', 'RoboForge'),
(55, 'http://www.squadbng.com/downloads/cbotvsnegibot.zip', 'cbotvsnegibot.zip', 'game', 'Tournament round 1', 'RoboForge'),
(56, 'http://www.squadbng.com/downloads/clodstrifvskingass.zip', 'clodstrifvskingass.zip', 'game', 'Tournament round 1', 'RoboForge'),
(57, 'http://www.squadbng.com/downloads/BOTSTourneyRules.txt', 'BOTSTourneyRules.txt', 'game', 'Offical rules for the "BOTS: Cyberworld Warriors" tournament.', 'BOTS'),
(60, 'http://www.squadbng.com/downloads/killword.mrc', 'killword.mrc', 'misc', 'Final version. Does a /hop instead of a /quit.\r\n\r\nPut into your mIRC directory and load with /load -rs killword.mrc', 'BOTS'),
(65, 'http://www.squadbng.com/downloads/icecream-wall.JPG', 'icecream-wall.JPG', 'wall', '', 'BOTS'),
(66, 'http://www.squadbng.com/downloads/crossfire.wav', 'crossfire.wav', 'misc', 'Chatroom sound', 'BOTS'),
(67, 'http://www.squadbng.com/downloads/WintereenmasRaid1.log', 'WintereenmasRaid1.log', 'game', 'A log of the first Winter-Een-Mas 2007 raid', 'Continuum'),
(68, 'http://www.legendaryawesome.com/squadbng/downloads/az2.zip', 'az2.zip', 'misc', '', 'BOTS'),
(69, 'http://legendaryawesome.com/squadbng/downloads/az2.zip', 'az2.zip', 'misc', 'Upload of the first test version of A2.', 'BOTS'),
(70, 'http://legendaryawesome.com/squadbng/downloads/az2.zip', 'az2.zip', 'misc', 'Updated with sdl.dll. I hope the deletion feature on here decides to work soon. >_>', 'BOTS'),
(71, 'http://legendaryawesome.com/squadbng/downloads/SDL_mixer.dll', 'SDL_mixer.dll', 'misc', 'Hopefully the last needed file for AZ2.', 'BOTS'),
(72, 'http://legendaryawesome.com/squadbng/downloads/Az2 WIP 9-14.zip', 'Az2 WIP 9-14.zip', 'misc', 'Az2 project update as of 9/14 (8:00 PM). To fight, head to the two squares at the bottom of the left area; you should have a party with you however.', 'BOTS');

-- --------------------------------------------------------

--
-- Table structure for table `facts`
--

CREATE TABLE IF NOT EXISTS `facts` (
  `id` int(11) NOT NULL default '0',
  `what` varchar(50) NOT NULL default '',
  `fact_num` int(11) NOT NULL default '0',
  `fact` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `facts`
--

INSERT INTO `facts` (`id`, `what`, `fact_num`, `fact`) VALUES
(1, 'uru', 1, 'Uru doesn''t exist in real life. He is actually an advanced AI robot, and his only flaw is that he responds to most statements with "lawl"'),
(2, 'gb', 1, 'GB&#039;s hand and bicep have the sheer power of 300 tanks, 200 mack trucks, and 20 B-52 bombers combined '),
(3, 'hylian', 1, 'Hylian is, in fact, one of the 5 people in Canada that have access to a computer  The rest of those 5 also come into this channel, making 80% of Canada part of Squad BnG '),
(4, 'gb', 2, 'GB is aware of every sports related quote EVER  If he says he has never heard it, you either made it up, or he wants to keep your self esteem intact '),
(5, 'gb', 3, 'GB once injected liquid orange crayon into his arm  The wax solidified and added to the indestructibility of his arm '),
(6, 'gb', 4, 'GB is so AFK, that he is AFK from life  All interactions with GB are simply elaborate away messages '),
(7, 'gb', 5, 'Clergy refer to Ragnarok as a vast meteor that will annihilate the earth and all life on it  They were actually just talking about GB&#039;s fist '),
(8, 'gb', 6, 'Everything run on GB&#039;s laptop, from Server&#039;s to robots, must mandatorily break 15 times, then work for 5 minutes, break again, then work'),
(9, 'tj', 1, 'To this date, TJ has taken enough advanced classes in his high school alone to equal three PhDs, four masters, one bachelors, and 14 associate degrees in every subject possible '),
(10, 'c-bot', 1, 'C-Bot retrieved so many sodas for Ness that Vanilla coke production was canceled because they couldn&#039;t keep up  Cherry coke isn&#039;t looking too good now '),
(11, 'jhang', 1, 'Jhang is forbidden by International law to reveal any pictures of himself on the internet, as a mere glance at him will completely reverse one&#039;s sexual preference, forever '),
(12, 'jhang', 2, 'Jhang once hugged GB at the exact same time GB punched him in the face  The resulting explosion created TexBot '),
(13, 'fortemaster', 1, 'ForteMaster was in this channel, idling, before Ness and GB even came up with the name &quot;Squad BnG&quot;'),
(14, 'texbot', 1, 'For every 400 lines of code TexBot is written with, C-Bot does the exact same thing in 5 lines '),
(15, 'uru', 2, 'Ness and GB did not found Squad BnG  It was all Uru&#039;s idea, and they stole it '),
(16, 'uru', 3, 'TJ&#039;s legendary &quot;girlfriend&quot; is actually Uru&#039;s right sock '),
(17, 'uru', 4, 'lawls actually means &quot;Listen, a war looms soon&quot;  It is a prophecy to the internet apocolypse that Uru himself will cause'),
(18, 'uru', 5, 'Uru actually has the power to deop every operator, voice, halfop, oper, and service bot on every network at the same time, but he&#039;d rather just say &quot;lawls&quot;'),
(19, 'uru', 6, 'Uru does not actually leave the chatroom  He only tells IRC to say this to calm the chatroom down from its impeding doom '),
(20, 'uru', 7, 'ChanServ is too afraid to give Uru ops, for fear that he will be banned from IRC alltogether '),
(21, 'genryu', 1, 'Genryu has been fired by Ness so many times that he will be unable to land a job in the real world for 25 years, 30 weeks, 3 days, 23 hours, 4 minutes, and 25 seconds '),
(22, 'genryu', 2, 'Genryu is the Bacon Man, bringing all the pork he can, to all the little kids down the row  Clogging their arteries with all the MSG&#039;s, then they&#039;ll all die at the age of eight '),
(23, 'foxywolf', 1, 'FoxyWolf&#039;s hair is the longest in the world  In fact, it is so long, that scientists claim the hair has begun growing hair itself  Foxy stores his most prized possessions in his flowing locks '),
(24, 'foxywolf', 2, 'Because of his hair, all people meeting Foxy for the first time must make a DC 30 INT check to determine his gender '),
(25, 'madarrow', 1, 'Mad is so good at StarCraft, that the Protoss once came all the way to Earth to offer him control of all their armed forces  Mad declined only because the Protoss had no mouths, and therefore no potato chips'),
(26, 'cuddy', 1, 'Cuddy is one of the only squadmembers who went from giddy newb to cynical asshole in record time '),
(27, 'blade', 1, 'Blade once hated hating things  This caused an immense paradox, but it went away when he hated it too '),
(28, 'blade', 2, 'Blade has mastered every game on the planet, and so much to the extent that he completely hates the game entirely, but he can kick your ass at it '),
(29, 'blade', 3, 'Blade has the ability to download anything from anywhere at 500gb/s  Even your SOUL!!!'),
(30, 'foxywolf', 3, 'FoxyWolf has a Power Glove  Therefore, if he wants you to get out da way, all he has to do is point at you and hit left, and you GET OUT DA WAY!! Also, he can make you jump by hitting B, and shoot fireballs by hitting A ');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL auto_increment,
  `game` text,
  `g_key` text,
  `description` text,
  `rec_method` text,
  `method_name` text,
  `site` text,
  `banner` text,
  `tourneys` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `game`, `g_key`, `description`, `rec_method`, `method_name`, `site`, `banner`, `tourneys`) VALUES
(1, 'Continuum', 'continuum', 'This game is a classic on Squad BnG. It''s a top down ship game, where you fly around and shoot people. It''s often compared to asteroids by it''s looks, though it has decent graphics. It supports the creation of Squads, and is the origin of Squad BnG. \r\n\r\nWe play on Trench Wars.', 'log', 'log', 'http://www.subspacedownloads.com/', 'images/banners/bannerSS.png', 1),
(2, 'Gunbound', 'gunbound', 'This is a game similar to Worms. You get a tank-like vehicle and attempt to kill the members of the opposite team. There are several modes of play. You can also buy items called Avatars, which can increase your skill and points in some servers.', NULL, NULL, 'http://www.gunbound.net/', 'images/banners/bannerGB.png', 0),
(3, 'GunZ', 'gunz', 'GunZ is an FPS of sorts. There are a few RPG elements here and there, an interesting movement/jumping system, and of course, lots of bullets and explosions. Did I mention it''s free?', NULL, NULL, 'www.gunzonline.com', 'images/banners/Gunz.gif', 0),
(4, 'Starsiege: TRIBES', 'starsiege_tribes', 'Starsiege TRIBES is a unique first-person shooter set in the Starsiege universe. TRIBES revolutionized the world of multiplayer squad-level games. It''s a bit outdated, but still a great game.', NULL, NULL, 'www.planettribes.com', 'images/banners/TRIBESbanner.gif', 0),
(5, 'Starcraft', 'starcraft', 'StarCraft is Blizzard''s real-time strategy game of galactic conflict between three different species on the edge of known space. As the military leader for your people, you must gather the resources you need to raise a military force capable of dominating your enemies.', NULL, NULL, 'http://www.blizzard.com/starcraft/', 'images/banners/SCbanner.gif', 0),
(6, 'Rakion', 'rakion', 'Rakion is a lot like GunZ, in the fact that it''s a Third-Person "Shooter". It''s played with more of a Melee style in mind, with only a 2 ranged characters. Unlike GunZ, the Melee fighting is more indepth, making combos, special attacks, and "invincible" attacks. Best part? FREE!', NULL, NULL, 'http://www.rakion.net/', 'images/banners/Rakion.PNG', 0),
(7, 'RoboForge', 'roboforge', 'Create a robot with a number of different parts, paint it as you wish, program its moves and unleash it for ULTIMATE DESTRUCTION.', 'game_file', 'Roboforge Recording', 'http://www.roboforge.com/iglobe/roboforge.exe ', 'images/banners/roboforge.bmp', 1),
(8, 'BOTS', 'bots', 'Bots of Unlimited Transformation!\r\n\r\nGuide your BOT soldier into battle against evil viruses and tranform for greater power! Then customize your BOT with various equipment.', NULL, NULL, 'http://bots.acclaim.com/', 'images/banners/BOTSBanner.gif', 1),
(9, 'Winter-een-mas', 'winter-een-mas', 'Winter-een-mas is a holiday of sorts. More specifically, it is a celebration of video games and the people that play them. Winter-een-mas lasts for a whole week, which is always the very last week in January, the 25th through the 31st. The entire month of January constitutes the Winter-een-mas season, very similar to the "christmas season", where people begin to gear up for the holiday, and get into the spirit of things.', 'none', '', 'www.wintereenmas.com', 'images/banners/Wintereenmas.GIF', 1),
(10, 'Chatroom Battle', 'chatroom_battle', 'Chatroom opponents illustrate their victory over their competitor with whichever media they wish. The chatroom then votes on a winner.', 'game_file', 'various media', '', '', 0),
(11, 'Chatroom Battle', 'chatroom_battle', 'Chatroom opponents illustrate their victory over their competitor with whichever media they wish. The chatroom then votes on a winner.', 'game_file', 'various media', '', 'images/banners/ChatBattle.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL auto_increment,
  `class` text NOT NULL,
  `filename` text NOT NULL,
  `name` text NOT NULL,
  `misc` text,
  `misc_2` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `class`, `filename`, `name`, `misc`, `misc_2`) VALUES
(6, 'award', 'RaidMVP.gif', 'Continuum Raid MVP', 'This is the Continuum Raid MVP medal, awarded to the most valuable player in a raid. The MVP will be chosen by the players.', '3'),
(7, 'award', 'FoundingMember.gif', 'Founding Member', 'This is the Founding Member medal, given to those who were with Squad BnG in the early days. (Early days are defined as before the first tournament)', '3'),
(8, 'award', '2.gif', 'Silver Star', 'This is the Silver Star, given for anything worth more than a bronze star, but less than a gold star.', '5'),
(9, 'award', '3.gif', 'Bronze Star', 'This is a Bronze Star, given for anything worth less than a silver star.', '5'),
(10, 'award', '1.gif', 'Gold Star', 'This is the Gold Star, given for anything worth more than a silver star, but less than a specific award.', '5'),
(15, 'award', 'GoodConduct.gif', 'Good Conduct', 'This is given to any member who shows exceptionally good conduct. No real guidelines for this one.', '3'),
(16, 'award', 'PurpleHeart.gif', 'The Purple Heart', 'The purple heart is given in the American military to soldiers who are wounded in battle. In the squad, it is awarded to those that have made some sort of sacrifice for the squad.', '3'),
(20, 'award', 'NYA_3rd.gif', 'New Year''s Apocolypse: Semi-Finalist', 'Awarded to the semi-finalists of the first Continuum tournament of 2005. The tournament was ended before a winner could be determined.', '2'),
(23, 'award', 'Continuumtrophy.gif', 'The Trophy of Awesome', 'The holder of this trophy is the victor of the first ever PHP driven tournament. They are completely awesome.', '1'),
(25, 'award', 'texmedal.GIF', 'The Tex Medal', 'The Tex Medal is GB''s personal award. It is given to anyone who has done something of merit for GB or TexBot.', '3'),
(26, 'award', 'rftrophypw7.gif', 'RoboForge: Robots NOT in Disguise Trophy', 'This is the trophy for the first RoboForge tournament, which is the second tournament to be completed', '1'),
(28, 'award', 'BOTSTourneyTrophy.gif', 'BOTSman Memorial Trophy', 'Trophy for the BOTS: Cyberworld Warriors tournament. The holder is feared throughout cyberspace!', '1'),
(29, 'award', 'WintereenmasKing.gif', 'King of Winter-een-mas', 'He who holds this staff has been declared King of Winter-een-mas', '1'),
(30, 'award', 'Wintereenmasmedal.gif', 'Winter-een-mas Medal', 'This medal is awarded to anyone who wins or is voted "best player" in a Winter-een-mas event or game', '3');

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL auto_increment,
  `img_path` text NOT NULL,
  `link_size` text NOT NULL,
  `cat` text NOT NULL,
  `link_dest` text,
  `width` int(11) NOT NULL default '0',
  `height` int(11) NOT NULL default '0',
  `filesize` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `links`
--


-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL auto_increment,
  `t_key` varchar(50) NOT NULL default '',
  `match_id` int(11) NOT NULL default '0',
  `location` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `t_key`, `match_id`, `location`) VALUES
(5, 'continuum1', 7, 'tournaments/continuum/tournament_of_awesome/logs/gardius_vs_gb330033[continuum1].txt'),
(6, 'continuum1', 1, 'tournaments/continuum/tournament_of_awesome/logs/striker_vs_protoman_116[continuum1].txt'),
(7, 'continuum1', 8, 'tournaments/continuum/tournament_of_awesome/logs/nessthehero_vs_fusion_ax[continuum1].txt'),
(8, 'continuum1', 6, 'tournaments/continuum/tournament_of_awesome/logs/24_vs_32[continuum1].txt'),
(9, 'continuum1', 3, 'tournaments/continuum/tournament_of_awesome/logs/Blade Serpent_vs_Jhang[continuum1].txt'),
(10, 'continuum1', 5, 'tournaments/continuum/tournament_of_awesome/logs/Mewtroid_vs_Madarrow[continuum1].txt'),
(11, 'continuum1', 2, 'tournaments/continuum/tournament_of_awesome/logs/Cuddy_vs_Magnus[continuum1].txt'),
(12, 'continuum1', 4, 'tournaments/continuum/tournament_of_awesome/logs/FoxyWolf_vs_T.J.[continuum1].txt'),
(13, 'continuum1', 10, 'tournaments/continuum/tournament_of_awesome/logs/Blade Serpent_vs_T.J.[continuum1].txt'),
(14, 'continuum1', 11, 'tournaments/continuum/tournament_of_awesome/logs/Madarrow_vs_UrutoraD[continuum1].txt'),
(15, 'continuum1', 12, 'tournaments/continuum/tournament_of_awesome/logs/Gardius_vs_Fusion[continuum1].txt'),
(16, 'continuum1', 9, 'tournaments/continuum/tournament_of_awesome/logs/Protoman116_vs_Magnus[continuum1].txt'),
(17, 'continuum1', 13, 'tournaments/continuum/tournament_of_awesome/logs/Protoman116_vs_Blade Serpent[continuum1].txt'),
(18, 'continuum1', 14, 'tournaments/continuum/tournament_of_awesome/logs/UrutoraD_vs_Fusion[continuum1].txt'),
(19, 'continuum1', 15, 'tournaments/continuum/tournament_of_awesome/logs/Genryu_vs_Uru[continuum1].txt'),
(20, 'roboforge1', 3, 'tournaments/roboforge/robots_not_in_disguise/logs/NessTheHero_vs_T.J.[roboforge1].zip'),
(21, 'roboforge1', 2, 'tournaments/roboforge/robots_not_in_disguise/logs/Gardius_vs_Teh leet[roboforge1].zip'),
(22, 'roboforge1', 4, 'tournaments/roboforge/robots_not_in_disguise/logs/Mon_vs_GB330033[roboforge1].zip'),
(23, 'roboforge1', 1, 'tournaments/roboforge/robots_not_in_disguise/logs/lol brakit_vs_Ozymandias[roboforge1].zip'),
(24, 'roboforge1', 5, 'tournaments/roboforge/robots_not_in_disguise/logs/lol brakit_vs_Gardius[roboforge1].zip'),
(25, 'roboforge1', 6, 'tournaments/roboforge/robots_not_in_disguise/logs/T.J._vs_GB330033[roboforge1].txt'),
(26, 'roboforge1', 7, 'tournaments/roboforge/robots_not_in_disguise/logs/lol brakit_vs_GB330033[roboforge1].txt');

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE IF NOT EXISTS `matches` (
  `id` int(11) NOT NULL auto_increment,
  `t_key` varchar(25) default NULL,
  `match_id` int(11) NOT NULL default '0',
  `contender` varchar(50) NOT NULL default '',
  `score` int(11) NOT NULL default '0',
  `box_id` int(11) NOT NULL default '0',
  `round` int(11) NOT NULL default '0',
  `done` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0 AUTO_INCREMENT=397 ;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`id`, `t_key`, `match_id`, `contender`, `score`, `box_id`, `round`, `done`) VALUES
(16, 'continuum1', 8, '75', 0, 2, 1, 'YES'),
(15, 'continuum1', 8, '18', 1337, 1, 1, 'YES'),
(14, 'continuum1', 7, '29', 1, 2, 1, 'YES'),
(13, 'continuum1', 7, '44', 0, 1, 1, 'YES'),
(12, 'continuum1', 6, '32', 0, 2, 1, 'YES'),
(11, 'continuum1', 6, '24', 1, 1, 1, 'YES'),
(10, 'continuum1', 5, '30', 0, 2, 1, 'YES'),
(9, 'continuum1', 5, '101', 1337, 1, 1, 'YES'),
(8, 'continuum1', 4, '19', 1, 2, 1, 'YES'),
(7, 'continuum1', 4, '102', 0, 1, 1, 'YES'),
(6, 'continuum1', 3, '37', 1, 2, 1, 'YES'),
(5, 'continuum1', 3, '22', 0, 1, 1, 'YES'),
(4, 'continuum1', 2, '68', 0, 2, 1, 'YES'),
(3, 'continuum1', 2, '56', 1234, 1, 1, 'YES'),
(2, 'continuum1', 1, '64', 1, 2, 1, 'YES'),
(1, 'continuum1', 1, '21', 0, 1, 1, 'YES'),
(33, 'continuum1', 9, '64', 34, 1, 2, 'YES'),
(34, 'continuum1', 9, '68', 2, 2, 2, 'YES'),
(35, 'continuum1', 10, '22', 3, 1, 2, 'YES'),
(36, 'continuum1', 10, '19', 2, 2, 2, 'YES'),
(37, 'continuum1', 11, '30', 1, 1, 2, 'YES'),
(38, 'continuum1', 11, '24', 0, 2, 2, 'YES'),
(39, 'continuum1', 12, '44', 1, 1, 2, 'YES'),
(40, 'continuum1', 12, '75', 0, 2, 2, 'YES'),
(41, 'continuum1', 13, '64', 4, 1, 3, 'YES'),
(42, 'continuum1', 13, '22', 5, 2, 3, 'YES'),
(43, 'continuum1', 14, '24', 1337, 1, 3, 'YES'),
(44, 'continuum1', 14, '75', 0, 2, 3, 'YES'),
(45, 'continuum1', 15, '64', 0, 1, 4, 'YES'),
(46, 'continuum1', 15, '24', 1337, 2, 4, 'YES'),
(214, 'roboforge1', 4, '29', 1, 2, 1, 'YES'),
(213, 'roboforge1', 4, '55', 0, 1, 1, 'YES'),
(212, 'roboforge1', 3, '19', 1, 2, 1, 'YES'),
(211, 'roboforge1', 3, '18', 0, 1, 1, 'YES'),
(210, 'roboforge1', 2, '86', 0, 2, 1, 'YES'),
(209, 'roboforge1', 2, '44', 1234, 1, 1, 'YES'),
(208, 'roboforge1', 1, '77', 1, 2, 1, 'YES'),
(207, 'roboforge1', 1, '23', 0, 1, 1, 'YES'),
(259, 'bots1', 5, '123', 1337, 1, 2, 'YES'),
(342, 'winter-een-mas1', 5, '55', 0, 2, 1, 'YES'),
(341, 'winter-een-mas1', 5, '44', 1337, 1, 1, 'YES'),
(215, 'roboforge1', 5, '23', 1337, 1, 2, 'YES'),
(216, 'roboforge1', 5, '44', 0, 2, 2, 'YES'),
(217, 'roboforge1', 6, '19', 1, 1, 2, 'YES'),
(218, 'roboforge1', 6, '29', 0, 2, 2, 'YES'),
(359, 'winter-een-mas1', 14, '24', 1337, 1, 2, 'YES'),
(263, 'bots1', 7, '44', 0, 1, 3, 'YES'),
(219, 'roboforge1', 7, '23', 0, 1, 3, 'YES'),
(220, 'roboforge1', 7, '29', 1, 2, 3, 'YES'),
(264, 'bots1', 7, '121', 1, 2, 3, 'YES'),
(262, 'bots1', 6, '19', 0, 2, 2, 'YES'),
(260, 'bots1', 5, '44', 0, 2, 2, 'YES'),
(336, 'winter-een-mas1', 2, '23', 0, 2, 1, 'YES'),
(261, 'bots1', 6, '121', 1, 1, 2, 'YES'),
(339, 'winter-een-mas1', 4, '29', 0, 1, 1, 'YES'),
(256, 'bots1', 3, '123', 1, 2, 1, 'YES'),
(257, 'bots1', 4, '18', 0, 1, 1, 'YES'),
(258, 'bots1', 4, '121', 1, 2, 1, 'YES'),
(255, 'bots1', 3, '120', 0, 1, 1, 'YES'),
(254, 'bots1', 2, '122', 0, 2, 1, 'YES'),
(253, 'bots1', 2, '44', 1234, 1, 1, 'YES'),
(252, 'bots1', 1, '19', 1, 2, 1, 'YES'),
(251, 'bots1', 1, '118', 0, 1, 1, 'YES'),
(358, 'winter-een-mas1', 13, 'UNEVEN', 0, 2, 1, 'NO'),
(357, 'winter-een-mas1', 13, '124', 0, 1, 1, 'NO'),
(356, 'winter-een-mas1', 12, '122', 0, 2, 1, 'YES'),
(355, 'winter-een-mas1', 12, '121', 1, 1, 1, 'YES'),
(354, 'winter-een-mas1', 11, '120', 0, 2, 1, 'YES'),
(353, 'winter-een-mas1', 11, '125', 1, 1, 1, 'YES'),
(352, 'winter-een-mas1', 10, '118', 2, 2, 1, 'YES'),
(348, 'winter-een-mas1', 8, '101', 0, 2, 1, 'YES'),
(346, 'winter-een-mas1', 7, '75', 1, 2, 1, 'YES'),
(345, 'winter-een-mas1', 7, '74', 0, 1, 1, 'YES'),
(344, 'winter-een-mas1', 6, '68', 0, 2, 1, 'YES'),
(343, 'winter-een-mas1', 6, '56', 1, 1, 1, 'YES'),
(340, 'winter-een-mas1', 4, '19', 1, 2, 1, 'YES'),
(338, 'winter-een-mas1', 3, '21', 1, 2, 1, 'YES'),
(337, 'winter-een-mas1', 3, '22', 0, 1, 1, 'YES'),
(335, 'winter-een-mas1', 2, '24', 1234, 1, 1, 'YES'),
(334, 'winter-een-mas1', 1, '64', 1, 2, 1, 'YES'),
(349, 'winter-een-mas1', 9, '86', 34, 1, 1, 'YES'),
(347, 'winter-een-mas1', 8, '77', 1337, 1, 1, 'YES'),
(350, 'winter-een-mas1', 9, '93', 2, 2, 1, 'YES'),
(351, 'winter-een-mas1', 10, '117', 3, 1, 1, 'YES'),
(333, 'winter-een-mas1', 1, '28', 0, 1, 1, 'YES'),
(360, 'winter-een-mas1', 14, '21', 0, 2, 2, 'YES'),
(361, 'winter-een-mas1', 15, '19', 0, 1, 2, 'YES'),
(362, 'winter-een-mas1', 15, '44', 1337, 2, 2, 'YES'),
(363, 'winter-een-mas1', 16, '56', 1337, 1, 2, 'YES'),
(364, 'winter-een-mas1', 16, '75', 0, 2, 2, 'YES'),
(365, 'winter-een-mas1', 17, '77', 1337, 1, 2, 'YES'),
(366, 'winter-een-mas1', 17, '86', 0, 2, 2, 'YES'),
(367, 'winter-een-mas1', 18, '117', 0, 1, 2, 'YES'),
(368, 'winter-een-mas1', 18, '125', 1, 2, 2, 'YES'),
(369, 'winter-een-mas1', 19, '121', 0, 1, 2, 'YES'),
(370, 'winter-een-mas1', 19, '124', 1, 2, 2, 'YES'),
(371, 'winter-een-mas1', 20, '64', 0, 1, 2, 'NO'),
(372, 'winter-een-mas1', 20, 'UNEVEN', 0, 2, 2, 'NO'),
(373, 'winter-een-mas1', 21, '44', 1337, 1, 3, 'YES'),
(374, 'winter-een-mas1', 21, '56', 0, 2, 3, 'YES'),
(375, 'winter-een-mas1', 22, '77', 1337, 1, 3, 'YES'),
(376, 'winter-een-mas1', 22, '125', 0, 2, 3, 'YES'),
(377, 'winter-een-mas1', 23, '124', 1, 1, 3, 'YES'),
(378, 'winter-een-mas1', 23, '64', 0, 2, 3, 'YES'),
(379, 'winter-een-mas1', 24, '24', 0, 1, 3, 'NO'),
(380, 'winter-een-mas1', 24, 'UNEVEN', 0, 2, 3, 'NO'),
(381, 'winter-een-mas1', 25, '77', 0, 1, 4, 'YES'),
(382, 'winter-een-mas1', 25, '124', 1, 2, 4, 'YES'),
(383, 'winter-een-mas1', 26, '24', 0, 1, 4, 'YES'),
(384, 'winter-een-mas1', 26, '44', 1, 2, 4, 'YES'),
(385, 'winter-een-mas1', 27, '124', 1, 1, 5, 'YES'),
(386, 'winter-een-mas1', 27, '44', 0, 2, 5, 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL auto_increment,
  `poster` text,
  `post` text,
  `title` text,
  `timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `poster`, `post`, `title`, `timestamp`) VALUES
(1, '18', 'Well, here it is! The new site, all pumped up and ready. Even a new domain name to go with it!\r\n\r\nEverything is accessible by the menu on the left. \r\n\r\nThe forums have been erased of data. This means you must re-create your name, and none of the topics you have before exist anymore. There are also some sections missing.\r\n\r\nBe sure to visit the suggestions area of the forum and tell me stuff that you want! I want to make this site as great as possible, and to do so, I need your input!\r\n\r\nDon''t forget to create a username using the Join button on the left!\r\n\r\nThe tournament will begin when everyone gets situated with the forums, the site, and everything else.', 'Welcome to Squad BnG!', '2004-11-14 17:14:49'),
(2, '29', 'Ok... so this is a whole lot easier than the old site. Give Ness tons of props for this thing. Like he said, look for info on the next tourney soon.', 'Wow', '2004-11-15 00:57:11'),
(3, '18', 'If you haven''t noticed, I''ve been duking it out with many weird errors on the site. If you couldn''t log in, you can now. Still can''t? Empty your cookies, your temp files, and refresh the site. Still can''t? Please let me know, and tell me your address, so I can kill you.  :D\r\n\r\nTournament might start soon, but I''m going to be implementing an application process in order to get into the squad, and I''m going to have to delete ALL the squadmembers in order to be fair. Sorry guys, but I can''t have random webservers joining the squad. We don''t want strangers ruining our tournaments.\r\n\r\nI also want to make something clear. By signing up to this site, and joining this squad, you agree to be somewhat active. I understand that we are all still kids, and have lives, but if you just create an account and dissappear forever, you''re wasting our time. Just remember that if you actually want to stay with us and play for an extended period of time, then sign up. Else, go away.\r\n\r\n(You can still join the forums though!)', 'PHP goes down fighting', '2004-11-16 21:17:40'),
(4, '18', 'The site has been purged of members. Please resignup. You have to go to me to ask for the squad password.\r\n\r\nHanding out the squad password to random people may result in dismissal from the squad.\r\n\r\nThe tournament may soon be underway. I will not be participating, because I might be adding new features to the site.', 'Site emptied', '2004-11-22 18:59:02'),
(5, '18', 'The tournament is officially underway! Sign-ups are open, and . . . gasp! Lo and behold, the new application form has arrived! If you want to join us, simply drop an application in and wait. I check the site everyday (Sometimes every hour or so. I have no life :( )\r\n\r\nThe tournament will take place on Gunbound.\r\n\r\nI suggest that you pay attention to the email address you put into your profile. It will recieve notices about the tournament, as well as your first adversary.\r\n\r\nI''d like to also point out to newcomers that the concept of an organized bracket has been eliminated. Why? Because sometimes, the line-up makes it so one person does not get to fight for 2 or more rounds, allowing them to have more time to practice and have less matches to complete before winning. The matches in this tournament are COMPLETELY RANDOMIZED! You never know who you will fight, and if the numbers are uneven, you might even sit out for a round! But don''t worry! Nobody will ever sit out twice in a row.\r\n\r\nHave fun, and play some Gunbound!', 'The tournament has started!', '2004-11-27 20:30:25'),
(6, '18', 'If you are currently on AOL and use the e-mail address they give you with *@aol.com, your address blocks every e-mail this site sends. So, basically, if you''re in the tournament, you are going to be blissfully unaware of anything going on, as well as the tournament actually starting.\r\n\r\nPlease whitelist ''nessie@squadbng.com'' and ''nessthehero@squadbng.com'' from your spam blockers.\r\n\r\nIf after you do this you are still unable to recieve our e-mails, I suggest you create an account on hotmail. Otherwise, you are going to have to be pretty damn active and constantly know what is going on at the site.', 'AOL blocks site messages', '2004-12-03 18:46:56'),
(7, '18', 'Well, it''s 2005. It''s an important year for me, because I will be in college by the end of it. I hope it''s not the last year I spend with you guys, but I want to solidify my future plans, so education comes first.\r\n\r\nIf you''d take a look at my sig on the forum, you''ll notice it is really nifty. I suggest any of you that don''t have it, download Xfire. It''s this handy program that shows you what games your friends are playing, and you can join in on them if you like. I believe it is at www.xfire.com. It works for Starcraft, as well as Halo and Gunbound. Many other games as well, but those three are the major ones we actually play (sometimes). If you download it, add me to your buddylist and stuff.\r\n\r\nThe tournament, Holiday Havoc, was burned to the ground in dissapointment. Nobody seemed to care, so I killed it. There is a new tournament poll on the forum. Go vote for the next tournament. Voting ends on the 6th, and so far, Continuum is winning!\r\n\r\nHave a happy, safe new year filled with gaming!', 'Happy new year!', '2005-01-02 20:29:10'),
(8, '29', 'Yeah, I''ve been gone a while, due to stuff. Mostly robotics, but also school, and other crap. In any case, I''m back, and should be much more active in the coming weeks. \r\n\r\nMy first project will be to finish the forum theme that I started a long time ago. Second project, put together some more events, look up more games, and really just try to get things going again. I really want to update the links page, and all the old pages, like I said I would a while back. Might happen, might not. I believe Ness will be in and out in the coming weeks/months due to work and whatnot, plus, it''s his senior year. \r\n\r\nBottom line: I''m here again, hopefully doing some work', 'I''m back', '2005-04-06 01:02:56'),
(9, '29', 'Hoo boy, summer is here, and I''m loving it. Got a few things lined up for you guys, not sure how many are going to come to be. \r\n\r\nFirst, I haven''t worked on the forum theme, but intend on doing so next week. Should be done sometime soon. If you have any suggestions, let me know.\r\n\r\nSecond, Ness is still away, but when he gets back, I''d like to try and upgrade some parts of the site, especially the awards system, because I plan on using it more. If you have a suggestion for the site, post on the forums.\r\n\r\nThird, if you visit the IRC channel, then you know that TexBot is undergoing upgrades. I''m upgrading many of his features, adding some, and completing the rest. Currently, I''m about 20% done. One of the big things will be TexBot Arcade, which will contain 4 or so classic arcade games for you guys to play. TexBot will record high-scores, and track the person with the best overall score. At the end of a month (maybe less) I will give an award to the person who is at the top of the leaderboard. Games I''m currently looking at: Pac-Man, Asteroids, Space Invaders, Tailgunner (3D click+shoot game) I''m not sure if I should customize the games, or leave them as-is. More discussion on this either in the forums on IRC.\r\n\r\nNext, we''re looking for games again. A "Great Game Hunt" if you will. Alliegance has been proposed again, as has Tribes, and several others. If you have a suggestion, post it on the forums or in chat, and people will check it out, and make the verdict. I was thinking about having a game-review panel, but I''m not sure. If you''d be interested in something like that, contact me.\r\n\r\nAlso, Squad BnG Radio is about ready to be re-launched for the summer. I''m working on writing a page for the site, but I need Ness''s help. TexBot can now launch the server remotely. I''m accepting applications for DJs as well. All former DJs need to re-apply. Email me with your IRC name, a playlist (Generated by Winamp), and how often you''ll be able/want  to host. I''ll then compile a list of new DJs, and send out instructions on how to connect and whatnot.\r\n\r\nLastly, our anniversary is coming up at the end of July. Last year, Magnus, who is no longer with us, made some kickass wallpapers (Which will hopefully be put up on a Downloads page sometime soon) for everyone. If you have something you''d like to contribute for this year, email me. I''m thinking TexBot Arcade will be my gift, and I''m going to talk to Gardius about his bobbleheads maybe being a part of it.\r\n\r\nThat''s about it. Hopefully we can get people back/get new members this summer. If you know someone who likes games, introduce them. If you have questions/suggestions/comments, email me, as always.', 'Summer, How I Love Thee', '2005-05-28 22:51:21'),
(10, '18', 'Yeah, I''m not dead. I was just doing other things.\r\n\r\nI just recently graduated high school. I have this summer and then I head to college in late August. I''m not saying that this will reduce my time with you guys. In fact, it might not change much other than I will put College first and you guys . . . later. I want to focus on my studies, but I will have a lot of free time on my hands. I might be away for a week or so when I move in because I want to wipe my C drive clean when I move to college to get rid of everything I don''t need or want. My F drive has all the garbage I''ve collected over forever, and I don''t want the C drive to be cluttered with anything that will slow down my PC.\r\n\r\nI want you guys to get back into gaming mode. We hardly do ANYTHING around here. Spark up a game every once in a while. Find a new game to play. Ask people if they play your game and if they don''t, send them the download link.\r\n\r\nGB has been working hard on the squad, and I''ve been slacking a bit but I plan to get back into gear now that school is out. I still have a job, but I am finished working by at most 7:30, depending on the shift. I need to fix any kinks in the website (if there are still any) and add some new things that I want. If any of you want something special on the website, let me know.\r\n\r\nWell, thats all.', 'I''m alive', '2005-06-14 00:11:28'),
(11, '18', 'The following members have e-mails that bounce everything I send. The active ones I can get to change, but the inactive members better get their ass on the site and change their e-mail or I''m deleting their account.\r\n\r\nActive:\r\nTJ\r\nGB330033\r\nSeiryo\r\n\r\nInactive:\r\nRagora\r\nSprite-Dude\r\nQuadace\r\n\r\nChange your e-mail or you WILL BE DELETED.', 'Bouncing e-mails', '2005-07-27 19:26:05'),
(12, '18', 'Well guys, here I go.\r\n\r\nI''m off to college come tomorrow morning. Once I log off this evening, who knows when you''ll see me again. Might be Christmas, might be sooner. I can''t say. \r\n\r\nI want you guys to know how much I really loved this squad. I seriously dedicated a lot of my time and energy into making it what it has become. Thats probably why I get so disgruntled when everything slows down and nearly stops.\r\n\r\nMy contact info will be on the forums. Feel free to e-mail me, write me a letter, and maybe even call me if you feel up to the task.\r\n\r\n\r\nI will return. Until then, listen to the new Admins, TJ and Striker. Hopefully they''ll run things pretty smoothly. (but they''re so fired when I get back! :P      j/k)', 'The end draws near', '2005-08-26 17:21:22'),
(13, '18', 'Holy crap.\r\n\r\nThis is the new site stuff. A few new things are added here and there. The comments functionality has been improved, as well as made nicer looking. \r\n\r\nYou can now have AVATARS! OH SNAP. If you are not an administrator, you can only have one at a time. I couldn''t test it from a non-admin perspective, so if you get an error, tell me IMMEDIATELY.\r\n\r\nAlso, the tournament aspect of the site has been tremendously improved, and it supports teams and custom awards, as well as bracket and random match modes.\r\n\r\nI have implemented a member purge function, that removes all members that do not rescue their account in a certain period of time. That period of time is determined by me, and you can always sign up again if you miss the deadline. This system is only to remove dead accounts, which there are a lot of.\r\n\r\nAlso, all our games are documented on the site, and you can page through them. Some are not up to date, and me and GB will probably update them soon.\r\n\r\nAnyway, enjoy the new functions. Let me know if you want any new stuff added.\r\n\r\nOh, and you can also FINALLY view information on your awards, such as notes and what the award means.\r\n\r\nA notice to all squad females. The system is set up to show a default avatar that corresponds to your gender. I am not aware of everyone''s gender, so simply notify me if you are a girl so I can fix it in the database. Thanks!\r\n\r\nI can''t believe how awesome this site is.', 'Oh snap!', '2006-02-21 23:46:30'),
(14, '18', 'Alright, we''re two days into the tournament and already 4 matches have been completed. We had to write a whole new rule or two, but things are going awesome.\r\n\r\nJust a clarification to the judges, you CAN upload logs and matches. The log does not have to be a text file. The script automatically converts it to one. Also, double kills in matches COUNT. Double kills offer no advantage to either player, so the score increase is negligible. You must record the score AS IS. If you have any questions about judging, timekeeping, uploading matches, or anything else, please let me know.\r\n\r\nKeep playing, and lets hope we can get this round done by the end of the week!', 'Tournament going great!', '2006-03-08 08:25:44'),
(15, '18', 'A big happy birthday to TJ, the biggest nerd in the squad. Have a kickass 18th, man.', 'Happy birthday', '2006-03-08 11:30:55'),
(16, '68', 'This news page is now Magnus''! Haha!\r\n\r\nAnyway, I''ve decided to try to round up a group to be in TWD once again. For those who don''t know, it''s a squad dueling league-type-thing on Continuum that we used to suck at really bad. So we quit.\r\n\r\nBut nevertheless, I need a minimum of 5 people, and only myself and Cuddy are a part so far. If you wish to participate, then contact me via e-mail, PM, the chatroom, whatever, and I''ll give you details.\r\n\r\n... lawlz', 'ohemgee hijack''d', '2006-03-14 13:49:00'),
(17, '19', 'The forums are, quite obviously, unusable for the time being. If you have any expertise on fixing such problems, please let the admins or chat ops know. Otherwise, please be patient and we shall attempt to restore the forums to functionality as soon as possible. Thank you.', 'Public service announcement', '2006-04-15 13:01:23'),
(18, '29', 'First, I wanted to let everyone know that the forums are fixed again. If you missed the fun, some guy hacked the forum, deleted Ness'' account, and put up a redirect page. However, his awesomeness, Ness, was able to quickly repair everything upon returning to his computer. In short, things were broken, but now they''re fixed.\r\n\r\nSecond, I want to say I''m sorry for not being around recently. I''m nearing the end of my senior year and I have a ton of stuff going on, and not a lot of time for the squad. If you recall, Ness experienced something similar last year. Anyway, hopefully I''ll be around more after May 27th (Graduation) and will have the time to do those re-writes to TexBot that I''ve been talking about.', 'Forums are Fixed', '2006-04-16 20:48:27'),
(19, '18', 'Okay, I just realized that GoDaddy.com is a piece of shit, and they block certain functions that make certain areas of the site (C-Bot and the entire Radio Script) completely useless.\r\n\r\nI cannot change hosts since it costs 50 bucks in setup fees for the host I want. I do not have this money, nor can I come up with it since I need to save as much money as humanly possible for my Germany trip, which is definitely more important in my life than a website. The webhost I want will be the final stop, as it has everything I could want on it. Though, it will cost me 70 dollars to start (10 bucks for the domain name, and 60 for the hosting package setup (50 bucks + 10 per month)).\r\n\r\nSo, yeah, until I manage to scrap together a spare 70 bucks, I''m gonna be pissed, and the radio script and C-Bot will be non-existant.\r\n\r\nStupid webhosting.', 'I am PISSED', '2006-04-20 15:27:10'),
(20, '18', 'It is official, croonies.\r\n\r\n\r\nI am a DJ at AKA Radio.\r\n\r\nHuzzah!', 'DJ Ness in the hizzle', '2006-05-01 06:00:12'),
(21, '18', 'We were hacked again, so instead of wasting my time and fixing it, I completely deleted the forum and the MySQL database. I don''t have any plans on remaking the forums, since nobody uses them ever.\r\n\r\nNone of this hacking crap ever happened when we were on Fuitad, and the forums were the same version then they are now, so it isn''t a security hole or anything.\r\n\r\nAs soon as I get enough money, we''re moving to DreamHost. ', 'Forums are gone', '2006-06-02 10:46:17'),
(22, '18', 'Okay, apparently the entire squad as it seems is addicted to Ragnarok Online, and Hylianbunny and friends are setting up a server that will be called Eden RO.\r\n\r\nNow, I''ve noticed how much this site is neglected, and I would wonder if you guys would want to, or not mind going to an all out RO server with a dedicated site to it.\r\n\r\nIf it were so, this blue and black site would vanish, along with squadbng.com, and edenro.com or something similar would emerge.\r\n\r\nLet me know what you think. I''m for either way, because I like the site how it is now, but a new site with equal functionality would be cool and fun to write.\r\n\r\nWrite what you think in the comment section.', 'Squad to change?', '2006-08-15 17:32:31'),
(23, '18', 'As of next week I will be in Munich for the Blind Guardian concert on Friday.\r\n\r\nI won''t be here or on the chatroom.\r\n\r\nYou can read my chronicles of it on my xanga, at http://xanga.com/NessTheHero\r\n\r\nI won''t start posting on it till Monday, though, when I arrive in Munich.', 'Away in Munich', '2006-09-01 14:29:32'),
(24, '18', 'We have changed over to Dreamhost, which is the reason the site has been down the past few days.\r\n\r\nIt should all be working now. Also, the forums (and maybe C-Bot) will come back up soon, so look out for them.\r\n\r\nAlso, sign up for the Roboforge tournament, but hurry up and finish your robots!', 'Host change', '2006-09-18 09:30:43'),
(25, '18', 'Okay, the forums are back up, and C-Bot will pop in and out of the chatroom every so often but I dunno if it will ever be a permanent thing unless I can figure out how to start him remotely on the site without opening a browser window.\r\n\r\nI also might start doing some more work on the site. I need to clean up a few pages, add some stuff in, and I&#039;m thinking about adding some new permissions to the site to give the Staff page something to show. What I am planning will also allow someone to coordinate a tournament without being a full fledged admin, since that is a bit too much power for someone to have with the way the site is set up right now.\r\n\r\nI might fix the radio script up and maybe get some things going again but I dunno. That is up to you guys, since you are the people who would actually use it.\r\n\r\nI&#039;d like to get more generalized awards going around. Maybe some joke ones like a &quot;You fail&quot; or &quot;You win&quot; award for chatroom incidents or other things. I have little photoshop skills so don&#039;t hand in ideas with expectation of someone whipping up the images. We want your ideas.\r\n\r\nOh, and join the tournament or something.', 'Stuff that is going on now', '2006-09-25 10:21:12'),
(26, '18', 'I just noticed the insane amount of new names on the members list and I have not noticed any new people in the chatroom. So who are these new people and where are they coming from?!', 'Who the hell are these people!?', '2006-09-25 10:34:28'),
(27, '28', 'Tourney is now in progress, check the BnG Wars section for more.', 'Roboforge on!', '2006-10-02 12:50:52'),
(28, '29', 'http://www.i-mockery.com/minimocks/crouton/applesauce.jpg', 'APPLESAUCE', '2006-10-13 08:30:13'),
(29, '18', 'Start it now or I&#039;ll kill everyone and end it.\r\n\r\nAlso, I own a Wii now. :D', 'START THE TOURNAMENT', '2006-10-14 21:02:58'),
(30, '19', 'BOTS is spreading like and infectious virus! Only a good one. And with PvP AND Base modes available, it can mean only one thing...\r\n\r\n..zomg no wai!\r\n\r\nya wai\r\n\r\nThe BOTS Tournament is on the way.  Unlike past tournaments, there is a prize of money and items in game for the victor. Toss up a comment if you&#039;d be interested in participating and/or if you&#039;d be willing to sprite the trophy for the winner. ', 'Log in and power up!', '2006-11-21 10:28:33'),
(31, '19', 'Sign ups for the new tournament are officially open! Everyone go sign up so we can get rockin!', 'Here we go!', '2006-12-01 20:34:08'),
(32, '44', 'Okay. Today is your last chance to get your match in if you&#039;re signed up for the Bots tournament. If you haven&#039;t done your match yet, get it in asap.', 'Last day for first round', '2006-12-10 10:12:51'),
(33, '18', '1. It&#039;s probably a script written by Ness.\r\n\r\n2. If it&#039;s a game, nobody will play it.\r\n\r\n3. If there is a tournament, nobody will show up.\r\n\r\n4. If it is planned, it will not happen\r\n\r\n5. Matches are required to be postponed for two weeks then finished over the course of three days.\r\n\r\n6. TexBot is real.\r\n\r\n7. TexBot will never say anything you want him to say until you don&#039;t want him to say the correct thing.\r\n\r\n8. Uru disagrees.\r\n\r\n9. GB&#039;s fist says otherwise.\r\n\r\n10. Grath is a big meanie face.\r\n\r\n11. If there is a slight possibility that anything that is taking place will involve some sort of Laser, Ozy is in the chatroom.\r\n\r\n12. Magnus is not real.\r\n\r\n13. Only Ness can say Grodus.\r\n\r\n14. Only Grodus can say NOSTEHRO.\r\n\r\n15. Nobody has Continuum anymore.\r\n\r\n16. GB is not allowed on the website.\r\n\r\n17. Ness is definitely the justice. You are not.\r\n\r\n18. If something is ruined, Mon or Mew probably did it.\r\n\r\n19. If 18 wasn&#039;t caused by Mon or Mew, it was Lucon.\r\n\r\n20. To talk to Sei, you must go through TJ.\r\n\r\n21. To think of Sei, you must go through TJ. \r\n\r\n22. If you feel uncomfortable, Jhang is probably there.\r\n\r\n23. There will always be three or more people in the chatroom who never say anything and you have never seen them before in all of ever.\r\n\r\n24. Hylian is one of the 15 people who occupy Canada.\r\n\r\n25. 6 other people from Canada also come to Squad BnG.\r\n\r\n26. GB is always AFK. Even when he is speaking to you.\r\n\r\n27. C-Bot lives!\r\n\r\nMore to be added if they are deemed awesome enough.', 'Rules of Squad BnG', '2006-12-16 21:41:04'),
(34, '18', 'I&#039;m posting from my Wii!!! ', 'OH SNAPS', '2006-12-22 12:14:28'),
(35, '19', 'The BOTS: Cyberworld Warriors tournment is now over! Congrats to Gardius for beating down all the competition and thanks to everyone who participated. Stick around for more tournament fun!\r\n\r\nOh, and I&#039;m posting from the middle of the Gulf of Mexico. =P', 'It&#039;s over!', '2006-12-31 17:36:02'),
(36, '19', 'That&#039;s right, Wintereenmas is upon us! For the next seven days, the world belongs to the gaming community. Squad BnG is having it&#039;s own Wintereenmas Wonderland mega tournament, with the winner declared the King of Wintereenmas. At least, for this year. Within the Squad.\r\n\r\nWe only get one Wintereenmas a year, so get out there and hit the games!', 'Wintereenmas!', '2007-01-24 22:48:03'),
(37, '18', 'Okay, so here&#039;s the deal.\r\n\r\nHylian and Tear have been planning a Canada meet-up for squadmembers. Before you go &quot;Holy crap internet people will kill me,&quot; hear us out. Naturally we wouldn&#039;t expect anyone below the age of 18 to go. Your parents will probably object to spending a week in Canada with people you&#039;ve never met. But listen up 18+ crowd.\r\n\r\nHylian lives in Stratford, Ontario, which is located probably an hour or so from Toronto. I&#039;m thinking we could all fly there and be picked up by Hylian or something. \r\n\r\nI know that I offered to drive, but gas prices are on the rise and it might just be cheaper for me and everyone else to just fly there directly. You WILL need a passport to get into Canada if you are flying. If you don&#039;t have one and expect to go, GET ONE NOW. Right now. Go to the post office tomorrow and fill out the forms.\r\n\r\nRight now it&#039;s about 367 dollars for me to fly to Canada. It should probably be around that for everyone else.\r\n\r\nIf you cannot get a passport, and are willing to fly (cheaper?) to Pittsburgh and pay me a reasonable amount for gas money (probably around 30 dollars), I will change my mind and drive from Pittsburgh to Canada. It does not require a passport to get into Canada on the road. I&#039;d bring one anyone.\r\n\r\nPost what you think in the comments.\r\n\r\nThe date has been confirmed. It&#039;s August 11th through August 17th. That starts on a Saturday and goes to a Friday.\r\n\r\nAnd to all the 18 year old people with helicopter parents, you have to shake them off. You are an adult, and unless you&#039;re chained to the floor, you are perfectly capable of getting a job and raising the money to go.\r\n\r\nMore planning will come later, but for now let&#039;s get everyone&#039;s input on it.', 'Canada Trip', '2007-05-25 01:21:47'),
(38, '18', 'If I&#039;m the only American planning to go to Canada by the end of July, I&#039;m not going.\r\n\r\nYou guys are horrible. We planned this for over a year. You all had ample time to get jobs and set aside money. And you didn&#039;t. Personally, I don&#039;t care what your excuses are. None of them make sense to me anyway. Helicopter parents? Sorry, thought you were 18. Lack of money? Guess you somehow can&#039;t get a job in a year. Other plans? Well, figured with enough time in advance that you&#039;d form plans around this, not make plans that replace it.\r\n\r\nEveryone wants to plan for Texas next year. Well, hate to burst your bubble but you won&#039;t find me at that next year. In order to prepare for real life, I&#039;m probably going to take an internship next summer. I highly doubt that I&#039;ll have time for a vacation to Texas, but who knows.\r\n\r\nI&#039;m still up for winter break though. I never do anything on breaks.\r\n\r\nThis was the first try. The next time, your excuses are meaningless.', 'You guys suck.', '2007-07-04 15:45:54'),
(39, '18', 'There is always aggression in the chatroom towards people who don&#039;t do anything. &quot;Why are you here&quot; &quot;Why don&#039;t you stop whining and play something&quot; &quot;You never do anything&quot; and so forth. A point came up that most of the ops don&#039;t do anything. GB seemingly vanished, myself and Striker are sporadically in the chatroom, and TJ is shuffling a life together. \r\n\r\nI thought I&#039;d come forth and explain why I don&#039;t &quot;SEEM&quot; to do anything in the chatroom.\r\n\r\nI hate every game you guys play at the moment, and as such refuse to play them.\r\n\r\nI do not like DnD. I tried playing it at some point and realized that I don&#039;t have the imagination nor patience for such a stupid, inconsistent, unrealistic game. SS13 came along and it was basically DnD with a complicated interface and graphics. I hate playing pretend. I don&#039;t care if I can build bombs, if that isn&#039;t the point of the game I&#039;m not going to play it. You can call me unimaginative or shallow if you want, but fine. I don&#039;t want to pretend my character is killing a bunch of guys, or act like I&#039;m some officer on some poorly pixelated ship. I want to actually see it happen with an intuitive interface and I want some fucking action. I&#039;m one of those people that watch FMVs once in my life, then skip past them every time I play that game over. Who cares about story. Bring on the blood.\r\n\r\nNow you guys are playing card games, a game I find boring and too complicated to even want to follow. Yeah, I don&#039;t give a shit that the enchantment you just played cancels out my attacks, I&#039;m going to go over here and shoot Germans in Call of Duty 3. With guns, not cards of guns that need 3 fire cards to actually use.\r\n\r\nI play Gmod. I played CS:S. I play over Xbox Live with GB sometimes. I even played RO for a bit. I&#039;m a gamer that needs to SEE the action in order to enjoy it. So while most of you enjoy staring at character sheets and imagining battles, I like experiencing them with a controller or my WASD keys.\r\n\r\nSo, I&#039;m sorry that I don&#039;t share your gaming interests, but until they match mine I&#039;m gonna go play something else.', 'Why I don&#039;t seem to play games.', '2007-09-11 13:28:40');

-- --------------------------------------------------------

--
-- Table structure for table `old_members`
--

CREATE TABLE IF NOT EXISTS `old_members` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `username` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=172 ;

--
-- Dumping data for table `old_members`
--

INSERT INTO `old_members` (`id`, `user_id`, `username`) VALUES
(1, 32, 'Lex24'),
(2, 32, 'Lex24'),
(3, 39, 'Lucon'),
(4, 32, 'Lex24'),
(5, 39, 'Lucon'),
(6, 49, 'Devin'),
(7, 32, 'Lex24'),
(8, 39, 'Lucon'),
(9, 49, 'Devin'),
(10, 58, 'Imitarate'),
(11, 32, 'Lex24'),
(12, 39, 'Lucon'),
(13, 49, 'Devin'),
(14, 58, 'Imitarate'),
(15, 76, 'Power Star'),
(16, 32, 'Lex24'),
(17, 39, 'Lucon'),
(18, 49, 'Devin'),
(19, 58, 'Imitarate'),
(20, 76, 'Power Star'),
(21, 82, 'Crunchy'),
(22, 32, 'Lex24'),
(23, 39, 'Lucon'),
(24, 49, 'Devin'),
(25, 58, 'Imitarate'),
(26, 76, 'Power Star'),
(27, 82, 'Crunchy'),
(28, 103, 'Trisk'),
(29, 32, 'Lex24'),
(30, 39, 'Lucon'),
(31, 49, 'Devin'),
(32, 58, 'Imitarate'),
(33, 76, 'Power Star'),
(34, 82, 'Crunchy'),
(35, 103, 'Trisk'),
(36, 104, 'Gundamman'),
(37, 32, 'Lex24'),
(38, 39, 'Lucon'),
(39, 49, 'Devin'),
(40, 58, 'Imitarate'),
(41, 76, 'Power Star'),
(42, 82, 'Crunchy'),
(43, 103, 'Trisk'),
(44, 104, 'Gundamman'),
(45, 105, 'Typamc95'),
(46, 32, 'Lex24'),
(47, 39, 'Lucon'),
(48, 49, 'Devin'),
(49, 58, 'Imitarate'),
(50, 76, 'Power Star'),
(51, 82, 'Crunchy'),
(52, 103, 'Trisk'),
(53, 104, 'Gundamman'),
(54, 105, 'Typamc95'),
(55, 106, 'Zackery'),
(56, 32, 'Lex24'),
(57, 39, 'Lucon'),
(58, 49, 'Devin'),
(59, 58, 'Imitarate'),
(60, 76, 'Power Star'),
(61, 82, 'Crunchy'),
(62, 103, 'Trisk'),
(63, 104, 'Gundamman'),
(64, 105, 'Typamc95'),
(65, 106, 'Zackery'),
(66, 109, 'Radei'),
(67, 32, 'Lex24'),
(68, 39, 'Lucon'),
(69, 49, 'Devin'),
(70, 58, 'Imitarate'),
(71, 76, 'Power Star'),
(72, 82, 'Crunchy'),
(73, 103, 'Trisk'),
(74, 104, 'Gundamman'),
(75, 105, 'Typamc95'),
(76, 106, 'Zackery'),
(77, 109, 'Radei'),
(78, 110, 'KazeMaru'),
(79, 32, 'Lex24'),
(80, 39, 'Lucon'),
(81, 49, 'Devin'),
(82, 58, 'Imitarate'),
(83, 76, 'Power Star'),
(84, 82, 'Crunchy'),
(85, 103, 'Trisk'),
(86, 104, 'Gundamman'),
(87, 105, 'Typamc95'),
(88, 106, 'Zackery'),
(89, 109, 'Radei'),
(90, 110, 'KazeMaru'),
(91, 111, 'Shadow El'),
(92, 32, 'Lex24'),
(93, 39, 'Lucon'),
(94, 49, 'Devin'),
(95, 58, 'Imitarate'),
(96, 76, 'Power Star'),
(97, 82, 'Crunchy'),
(98, 103, 'Trisk'),
(99, 104, 'Gundamman'),
(100, 105, 'Typamc95'),
(101, 106, 'Zackery'),
(102, 109, 'Radei'),
(103, 110, 'KazeMaru'),
(104, 111, 'Shadow El'),
(105, 112, 'Kyte'),
(106, 32, 'Lex24'),
(107, 39, 'Lucon'),
(108, 49, 'Devin'),
(109, 58, 'Imitarate'),
(110, 76, 'Power Star'),
(111, 82, 'Crunchy'),
(112, 103, 'Trisk'),
(113, 104, 'Gundamman'),
(114, 105, 'Typamc95'),
(115, 106, 'Zackery'),
(116, 109, 'Radei'),
(117, 110, 'KazeMaru'),
(118, 111, 'Shadow El'),
(119, 112, 'Kyte'),
(120, 113, 'DragonAndLance'),
(121, 32, 'Lex24'),
(122, 39, 'Lucon'),
(123, 49, 'Devin'),
(124, 58, 'Imitarate'),
(125, 76, 'Power Star'),
(126, 82, 'Crunchy'),
(127, 103, 'Trisk'),
(128, 104, 'Gundamman'),
(129, 105, 'Typamc95'),
(130, 106, 'Zackery'),
(131, 109, 'Radei'),
(132, 110, 'KazeMaru'),
(133, 111, 'Shadow El'),
(134, 112, 'Kyte'),
(135, 113, 'DragonAndLance'),
(136, 114, 'silentninja'),
(137, 32, 'Lex24'),
(138, 39, 'Lucon'),
(139, 49, 'Devin'),
(140, 58, 'Imitarate'),
(141, 76, 'Power Star'),
(142, 82, 'Crunchy'),
(143, 103, 'Trisk'),
(144, 104, 'Gundamman'),
(145, 105, 'Typamc95'),
(146, 106, 'Zackery'),
(147, 109, 'Radei'),
(148, 110, 'KazeMaru'),
(149, 111, 'Shadow El'),
(150, 112, 'Kyte'),
(151, 113, 'DragonAndLance'),
(152, 114, 'silentninja'),
(153, 116, 'Blades'),
(154, 32, 'Lex24'),
(155, 39, 'Lucon'),
(156, 49, 'Devin'),
(157, 58, 'Imitarate'),
(158, 76, 'Power Star'),
(159, 82, 'Crunchy'),
(160, 103, 'Trisk'),
(161, 104, 'Gundamman'),
(162, 105, 'Typamc95'),
(163, 106, 'Zackery'),
(164, 109, 'Radei'),
(165, 110, 'KazeMaru'),
(166, 111, 'Shadow El'),
(167, 112, 'Kyte'),
(168, 113, 'DragonAndLance'),
(169, 114, 'silentninja'),
(170, 116, 'Blades'),
(171, 119, 'Onichi_Vacoe');

-- --------------------------------------------------------

--
-- Table structure for table `purge`
--

CREATE TABLE IF NOT EXISTS `purge` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `to_delete` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `purge`
--


-- --------------------------------------------------------

--
-- Table structure for table `ranks`
--

CREATE TABLE IF NOT EXISTS `ranks` (
  `rank_id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `manage_users` enum('0','1') NOT NULL,
  `game_auth` enum('0','1') NOT NULL,
  `tournaments` enum('0','1') NOT NULL,
  `purge` enum('0','1') NOT NULL,
  `awards` enum('0','1') NOT NULL,
  `applications` enum('0','1') NOT NULL,
  `delete_auth` enum('0','1') NOT NULL,
  `ultimate` enum('0','1') NOT NULL,
  PRIMARY KEY  (`rank_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ranks`
--

INSERT INTO `ranks` (`rank_id`, `name`, `manage_users`, `game_auth`, `tournaments`, `purge`, `awards`, `applications`, `delete_auth`, `ultimate`) VALUES
(1, 'founder', '0', '0', '0', '0', '0', '0', '0', '1'),
(2, 'squaddie', '0', '0', '0', '0', '0', '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE IF NOT EXISTS `rules` (
  `id` int(11) NOT NULL auto_increment,
  `rule` text,
  `game` text,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`id`, `rule`, `game`, `description`) VALUES
(1, 'Any and all judges are protected from attacks during matches. Any deliberate attacks upon a judge will result in penalization of the shooter. Likewise, the judge cannot fire upon any of the players. Judges cannot be used as shielding. As such, the judge must try to remain out of the way at all times, and players may not take advantage of the judge''s position. Once one player has terminated the other, the judge may be fired upon, if neccesary, to end the match (The judge still cannot fire back).', 'Gunbound', 'Non-Interferance'),
(15, 'No combatant may use an item or have a ship that has certain abilities in the game that offers any significant advantage over the outcome, such as warping, stealth, or supremely powerful weapons. This is on a "don''t ask don''t tell" basis. If your ship has warping or stealth, simply do not use it. If you violate this rule, you will be immediately instructed to either change your ship or forfeit the match.', 'Continuum', 'No unfair advantage'),
(21, 'Rush rules do not prohibit expansion in any way.', 'Starcraft', 'Expansion Permitted'),
(24, 'No units/buildings with the ability to cause harm or gather intel are knowingly allowed within the base of another player. Until the timer expires. ', 'Starcraft', 'Units in other bases'),
(23, 'Any before mentioned "Expansions" can be attacked at any time.', 'Starcraft', 'Expansions Vulnerable'),
(14, 'No one combatant may kill another when the other has recently died and has appeared upon the map within the time limit of around 3 to 4 seconds. The combatant may attack if the recently "spawned" individual engages him in combat, or uses a diversionary tactic, such as using ship accessories, such as repels or bursts. Violations to this rule will result in first offense being a verbal warning, and upon second offense, disqualification to the offender and advancement to the opposing combatant.', 'Continuum', 'No spawn kills'),
(25, 'A base area inculdes all ground up to and including the easily defensible choke point(s).', 'Starcraft', 'Defined Base'),
(12, 'When each tournament match starts, a specific zone will be described as the combat area. This may or may not vary per match. All combatants are required to remain in the combat area at all times during the match, and may use no excuse except forced exit, in which they were chased out by the other combatant. They must immediately return to the combat area within 10 seconds. If they have been chased out, the other combatant must return to the starting safe zone, touch the green once, then they may head back into battle. The chased-out combatant may pursuit the "chaser" to his safe zone, and the "chaser" may not engage until he has touched green. If the "chaser" is killed on the way to the green, it counts as a legal kill, and the "chaser" may engage the "chased" after respawning. If the exiting combatant was not chased, s/he has 10 seconds to return to the combat area or risk losing the match. Being shot while outside of the combat area is considered a legal kill.', 'Continuum', 'Stay in boundaries'),
(13, 'No combatant may use any excessive rude or slanderous language directed toward any squad member either participating or spectating in the match, as well as using such language to comment on deaths or any other maneuver or action of the opposing combatant. Violations will result in first offence being a verbal warning, and second offense resulting in full squad punishment, that which includes a two-day ban from the squad forums and a disqualification from the tournament match they are scheduled to complete. No exceptions will be made for this offense. All squad members, participating or otherwise, are included in this rule during the set time for the match, from the opening of the log to the closing.', 'Continuum', 'No bad language'),
(8, 'No form of teleporting will be permitted during play by either contestant. Only Judges will be permitted to teleport. Teleporting will result in a free death for the teleporting team.', 'Gunbound', 'No teleporting'),
(19, 'No attacks on other player''s base''s with mobile or previously mobile units until the timer expires.', 'Starcraft', 'No rushing'),
(27, 'No Siege moded Siege tanks are allowed inside a base are until after the the timer expires', 'Starcraft', 'No Siege Tanks'),
(28, 'While it may be an extremely effective tactic to kill someone once, then flee for the rest of the match, this is an incredible waste of a match. While defensive fleeing is permitted, fleeing for a minute or more straight will audit a warning. Should the fleeing continue without concession, the match will go to the opposing player. Exceptions to this will be dictated by the judge.', 'Continuum', 'No running'),
(29, 'The following items shall be permitted for use in a tournament match without hinderment: Radar, Mines, Repel, Burst, Decoy, Multishot, Rockets, Anti-Warp. All other items not named above cannot be used, as they either break other rules or are deemed unacceptable or unfair to use.', 'Continuum', 'Items'),
(34, 'BOT\r\nIn order to participate, each player must create a separate account on the BOTS website in order to procure a new, level 1 BOT to be used in the tournament.\r\n\r\nThe new BOT:\r\n  1) may be of any class\r\n  2) will be given the money neccesary for one lvl1 Part upgrade\r\n  3) will be given a Bit Cannon gun\r\n  4) may keep the Mercenaries they start with\r\n  5) cannot equip anything other than the upgrades mentioned here\r\n\r\n\r\nMATCHES\r\nTournament pairings will be randomized. Each match consists of three sections, the winner of each section receiving one point. The player with the most points at the end of the match advances and the loser is dropped from the competition.\r\n\r\nEach match includes one round of each of the following:\r\n  1)SECTOR game, players will proceed through level 1. The bout winner is whoever is ranked #1 by the game at the end of the level. Transforming is allowed and other players are not required to revive you if you bite the dust.\r\n  2)PVP game, players will battle in a randomly selected map. The bout winner is whoever kicks the other guy''s ass. Transforming is not allowed.\r\n  3)BASE game, players will compete on a randomly selected map. The bout winner is whoever destroys the other player''s base first. In the event that niether base can be destroyed, the person who lost their 5 lives first loses. Transforming and Mercenaries are allowed. Any gold acquired from a victory must be given to the judges as part of the tournament prize pool.\r\n\r\n\r\nPRIZES\r\nAfter the tournament, prizes will be handed out.\r\n\r\nFirst place recieves:\r\n  1) choice of 5 MVP items from the prize pool\r\n  2) gold collected from Base bouts, comparatively large portion\r\n  3) the BOTSman Memorial Trophy\r\n\r\nSecond place receives:\r\n  1) choice of 3 MVP items remaining in the prize pool\r\n  2) gold collected from Base bouts, comparatively small portion\r\n\r\nAll players recieve:\r\n  1) any gigas acquired during gameplay\r\n  2) any MVP drops they pick up during Sector bouts\r\n\r\nA randomly selected player recieves:\r\n  1) the last MVP item from the prize pool\r\n\r\n\r\nMISCELLANEOUS\r\nAny BOT that gains a new level during the tournament must be deleted and recreated. Any equipment, gigas, and drops the player owns will be transfered to another player, and then to the new BOT.\r\n\r\n\r\nJUDGES\r\nJudges will be present in matches to ensure that rules are followed and that matches are valid. Any gold acquired during Base bouts must be given to a judge. If there is a problem, ask your judge.\r\n\r\nJudges have the following powers/responsibilities:\r\n  1) Create tournament rooms and act as Room Master\r\n  2) Disqualify players who break the rules, no warnings\r\n  3) Invalidate bouts if the game bugs up, then repeat the bout. This is especially important in Base bouts, which bug up more often other game play modes\r\n  4) Collect gold from Base bout victors\r\n  5) Do not interfere in gameplay. This includes no unneccesary chatter with players. Immedeately jump off a nearby ledge during Sector and PvP bouts to ensure you do not get in the way. In Base bouts, kill yourself continuously and de-equip all Mercenaries beforehand\r\n  6) Sector and PvP bouts require only one judge, Base requires two', 'BOTS', 'Cyberworld Warriors Rules'),
(40, 'Events begin at 6:00PM CST\r\n\r\nNOTE: THERE HAS BEEN A SLIGHT CHANGE IN THE SCHEDULE\r\n\r\nThursday: Continuum Raid\r\nFriday: Massive LandGrab game \r\nSaturday: Super SS13 \r\nSunday: TetriNET 2\r\nMonday: Wolfenstein: Enemy Territory Marathon\r\nTuesday: Blizzard Games (Starcraft and Warcraft 3)\r\nWednesday: Continuum Raid\r\n\r\nWeek-long "Break in the Road" song contest\r\n\r\nGames for Wintereenmas:\r\n\r\nDS Wifi \r\nLandgrab \r\nSoldat \r\nWolfenstein: Enemy Territory\r\nOpen Arena \r\nInklink \r\nKawaks/Kaillera \r\nBOTS \r\nDnD/d20 Modern\r\nSS13 \r\nContinuum \r\nStarCraft (Brood War)\r\nWarcraft 3 (The Frozen Throne)\r\nLieroX\r\nTetriNET2\r\n\r\nAll of these games and events give you a chance to win the Winter-een-mas Medal. Some give you two chances! Ex: One person can win the Blizzard Games night, and two other people could be voted "best player" of Starcraft and Warcraft 3, resulting in three people obtaining the medal.\r\n\r\nMost of the links to the games can be found with !games in the chatroom. Let someone know if you need a link. \r\n', 'Winter-een-mas', 'Schedule and Games'),
(42, 'You depict how a battle would unfold between yourself and your opponent using whatever medium you please, traditionally (but not necessarily) with them dying. Both your and his or her entries go up underneath a 24-hour poll and then the masses pick which battle they liked more.', 'Chatroom Battle', 'Basic Rules');

-- --------------------------------------------------------

--
-- Table structure for table `squadmembers`
--

CREATE TABLE IF NOT EXISTS `squadmembers` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `password` varchar(50) NOT NULL default '',
  `gender` enum('male','female') NOT NULL default 'male',
  `twon` int(11) default NULL,
  `tpart` int(11) default NULL,
  `ban` varchar(5) default NULL,
  `intourn` enum('yes','no') NOT NULL default 'no',
  `rank` enum('admin','judge','squad') NOT NULL default 'squad',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=127 ;

--
-- Dumping data for table `squadmembers`
--

INSERT INTO `squadmembers` (`id`, `username`, `email`, `password`, `gender`, `twon`, `tpart`, `ban`, `intourn`, `rank`) VALUES
(18, 'NessTheHero', 'nessthehero@gmail.com', '353bfbdb209deaf685318dcb818d5e32', 'male', 0, 3, '0', 'no', 'admin'),
(28, 'Hylianbunny', 'hylianbunny@hotmail.com', '696fbf17aefa357b0a62a92a87e8652e', 'male', 0, 1, '0', 'no', 'admin'),
(30, 'Madarrow', 'Madarrow0@yahoo.com', '2e771fe4f4354532dbc49c9c9a45e81f', 'male', 0, 1, '0', 'no', 'squad'),
(64, 'Protoman116', 'genryugenezen@yahoo.com', '42d388f8b1db997faaf7dab487f11290', 'male', 0, 2, '0', 'no', 'squad'),
(24, 'UrutoraD', 'UrutoraD@hotmail.com', '2b6236f8d1273ea6b1dbc07b2dc2de57', 'male', 1, 2, '0', 'no', 'squad'),
(23, 'Grath', 'grathxvi@gmail.com', '947f772fd01bf2cf4cb097caa0e21f2d', 'male', 0, 2, '0', 'no', 'squad'),
(22, 'Blade Serpent', 'Blade_Serpent@yahoo.com', '3115cd7836f2944d274a895eab896a0d', 'male', 0, 2, '0', 'no', 'squad'),
(21, 'Striker', 'strikeromega@gmail.com', '9e963409fb69601d2d791b423f43e803', 'male', 0, 2, '0', 'no', 'admin'),
(29, 'GB330033', 'GB330033@mail.utexas.edu', '124354a64a3ea47d6c8deb0d9d25d7b9', 'male', 1, 3, '0', 'no', 'admin'),
(19, 'T.J.', 'turboquestertj@tampabay.rr.com', '2e1056defdb4eac51954b37a93608628', 'male', 0, 4, '0', 'no', 'admin'),
(65, 'Asharaxx Metallium', 'DarkMewMetallium@aol.com', '5481c004f7121c74c0dac96dd0576708', 'male', 0, 0, '0', 'no', 'squad'),
(37, 'Jhang', 'hawkerharrier@aol.com', '73c05432845b6fc79e1fdadc188446d4', 'male', 0, 1, '0', 'no', 'squad'),
(40, 'Seiryo', 'pythagoras@tampabay.rr.com', 'ef9c585a688107190d5108eb15706c61', 'female', 0, 0, '0', 'no', 'squad'),
(44, 'Gardius', 'DGardius@gmail.com', '0cafad2636d3a13d1435ff869b4e6086', 'male', 1, 4, '0', 'no', 'squad'),
(50, 'Blastamasta', 'kayos66@sbcglobal.net', '3bf1114a986ba87ed28fc1b5884fc2f8', 'male', 0, 0, '0', 'no', 'squad'),
(55, 'Mon', 'biofreak72@yahoo.com', '00bfc8c729f5d4d529a412b12c58ddd2', 'male', 0, 2, '0', 'no', 'squad'),
(56, 'Cuddy', 'ewjrocks@hotmail.com', 'b0a0969e815bb0b7b2bbce859c05c449', 'male', 0, 2, '0', 'no', 'squad'),
(68, 'Magnus', 'jonjonwayne@yahoo.com', '99c8ef576f385bc322564d5694df6fc2', 'male', 0, 2, '0', 'no', 'squad'),
(73, 'Pichu0102', 'pichu0102@gmail.com', 'f24d99c9e3fc628679a834b82620cdfe', 'male', 0, 0, '0', 'no', 'squad'),
(74, 'XeroLogik', 'voice_of_oblivion@hotmail.com', '035c88a67814485689ec861c3685c316', 'male', 0, 1, '0', 'no', 'squad'),
(75, 'Fusion', 'fusion_armor_x@yahoo.com', 'd02c4c4cde7ae76252540d116a40f23a', 'male', 0, 2, '0', 'no', 'squad'),
(77, 'Ozymandias', 'shadow_ds@yahoo.com', '46e0969fb897b6b9ae87b539b1897d90', 'male', 0, 2, '0', 'no', 'squad'),
(101, 'Mewtroid', 'catlover20410@gmail.com', '97c2bd1615963162bd4e0caca037ba9e', 'male', 0, 2, '0', 'no', 'squad'),
(86, 'Forai', 'Forai@comcast.net', '7510d498f23f5815d3376ea7bad64e29', 'male', 0, 2, '0', 'no', 'squad'),
(91, 'ForteMaster', 'fortemaster@gmail.com', '912af0dff974604f1321254ca8ff38b6', 'male', 0, 0, '0', 'no', 'squad'),
(93, 'berserkuh', 'ace_of_space_shaman@yahoo.com', '5ebe2294ecd0e0f08eab7690d2a6ee69', 'male', 0, 1, '0', 'no', 'squad'),
(102, 'FoxyWolf', 'wolfex.sylcom@gmail.com', 'b1378ffd46295dd991724de6c5ebc6d1', 'male', 0, 1, '0', 'no', 'squad'),
(108, 'yadaman', 'yadaman@gmail.com', '6f7f9432d35dea629c8384dab312259a', 'male', 0, 0, '0', 'no', 'squad'),
(126, 'Nami', 'savannah@writersavvy.com', 'debf8567f34fb656ba535f1b971a8e18', 'female', 0, 0, '0', 'no', 'squad'),
(117, 'Jeilan', 'bijouthehamster@hotmail.com', '583f4be146b6127f9e4f3f036ce7df43', 'female', 0, 1, '0', 'no', 'squad'),
(118, 'Talon IceHawk', 'Talon.IceHawk@Gmail.com', '8f090d12f471e5a30eda084f77aef072', 'male', 0, 2, '0', 'no', 'squad'),
(125, 'Neito', 'neito@nerdramblingz.com', '6d3c7fcbc81c540db7f0556f1f22fb63', 'male', 0, 1, '0', 'no', 'squad'),
(120, 'Drehiel', 'Drehiel@gmail.com', '65c58e742815c43b559ae14432ffaf00', 'male', 0, 2, '0', 'no', 'squad'),
(121, 'Retro', 'retrodriftwood@hotmail.com', 'e7e94d9ef1edaf2c6c55e9966b551295', 'male', 0, 2, '0', 'no', 'squad'),
(122, 'Ren', 'ren_garde@hotmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'male', 0, 2, '0', 'no', 'squad'),
(123, 'Christoph', 'christoph2772@gmail.com', '2e065020dd811fb53e6259eba76a2763', 'male', 0, 1, '0', 'no', 'squad'),
(124, 'Tear', 'thartwick@dtechstudios.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'male', 1, 1, '0', 'no', 'squad');

-- --------------------------------------------------------

--
-- Table structure for table `teammates`
--

CREATE TABLE IF NOT EXISTS `teammates` (
  `id` int(11) NOT NULL auto_increment,
  `t_key` varchar(50) NOT NULL default '',
  `user_id` int(11) NOT NULL default '0',
  `team_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `teammates`
--


-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) NOT NULL auto_increment,
  `team_id` int(11) NOT NULL default '0',
  `name` text NOT NULL,
  `t_key` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `teams`
--


-- --------------------------------------------------------

--
-- Table structure for table `tournaments`
--

CREATE TABLE IF NOT EXISTS `tournaments` (
  `id` int(11) NOT NULL auto_increment,
  `t_key` varchar(25) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `description` text NOT NULL,
  `game` text,
  `status` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `tournaments`
--

INSERT INTO `tournaments` (`id`, `t_key`, `name`, `description`, `game`, `status`) VALUES
(3, 'continuum1', 'Tournament of Awesome', 'Classic Continuum tournament rules. All matches are 15 minutes, and the person with the most kills wins.\r\n\r\nAll the rules are printed below.\r\n\r\nAfter 8 people sign up, the tournament will begin 1 week later regardless of how many people are signed up.\r\n\r\nHave fun, and let''s hope this tournament actually ends!', 'continuum', 'finished'),
(9, 'roboforge1', 'Robots NOT in Disguise', 'Only enter this if you sent GB your bot last Friday', 'roboforge', 'finished'),
(12, 'bots1', 'BOTS: Cyberworld Warriors', 'Second try', 'bots', 'finished'),
(14, 'winter-een-mas1', 'Wintereenmas 2007!', '', 'winter-een-mas', 'finished');

-- --------------------------------------------------------

--
-- Table structure for table `t_options`
--

CREATE TABLE IF NOT EXISTS `t_options` (
  `id` int(11) NOT NULL auto_increment,
  `t_key` varchar(25) NOT NULL default '',
  `teams` varchar(5) NOT NULL default '',
  `random` varchar(5) NOT NULL default '',
  `ppt` int(11) NOT NULL default '0',
  `bracket` varchar(5) NOT NULL default '',
  `match_type` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `t_options`
--

INSERT INTO `t_options` (`id`, `t_key`, `teams`, `random`, `ppt`, `bracket`, `match_type`) VALUES
(3, 'continuum1', 'no', 'no', 0, 'yes', 'time'),
(9, 'roboforge1', 'no', 'no', 0, 'yes', 'elim'),
(12, 'bots1', 'no', 'no', 0, 'no', 'elim'),
(14, 'winter-een-mas1', 'no', 'no', 0, 'yes', 'elim');

-- --------------------------------------------------------

--
-- Table structure for table `t_stats`
--

CREATE TABLE IF NOT EXISTS `t_stats` (
  `id` int(11) NOT NULL auto_increment,
  `t_key` varchar(25) default NULL,
  `award` text,
  `time` int(11) default NULL,
  `signups` char(3) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `t_stats`
--

INSERT INTO `t_stats` (`id`, `t_key`, `award`, `time`, `signups`) VALUES
(3, 'continuum1', '23', 15, 'OFF'),
(9, 'roboforge1', '26', 0, 'OFF'),
(12, 'bots1', '28', 0, 'OFF'),
(14, 'winter-een-mas1', '29', 0, 'OFF');
