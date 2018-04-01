-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 01 apr 2018 om 14:59
-- Serverversie: 5.1.73
-- PHP-versie: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `torrentempire`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `admin_pages`
--

CREATE TABLE IF NOT EXISTS `admin_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(100) NOT NULL,
  `img` varchar(100) NOT NULL,
  `class` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Gegevens worden uitgevoerd voor tabel `admin_pages`
--

INSERT INTO `admin_pages` (`id`, `name`, `url`, `img`, `class`) VALUES
(1, 'Nieuwe pagina ', 'moderator/new_page', 'glyphicon-book', 7),
(2, 'uploaders', 'moderator/uploaders', 'glyphicon-search', 4),
(3, 'Peerlijst', 'moderator/peerlist', 'glyphicon-menu-hamburger', 4),
(4, 'Check Passkey', 'moderator/checkpasskey', 'glyphicon-search', 4),
(5, 'Dode Torrents', 'moderator/deathtorrents', '', 5),
(6, 'Waarschuwingen verwijderen', 'moderator/deletewarnings', '', 6),
(7, 'Geblokeerde gebruikers', 'moderator/blocked-users', '', 5),
(8, 'Geparkeerde gebruikers', 'moderator/parked-users', '', 5),
(9, 'Inaktieve gebruikers', 'moderator/not-active-users', '', 5),
(10, 'Massa bericht verzenden', 'moderator/mass-pm-mod', '', 4),
(11, 'Massa Pm overzicht', 'moderator/mass-pm-overview', '', 5),
(12, 'Test pagina', 'moderator/testpage', '', 7),
(13, 'Site Bericht', 'moderator/site_message', '', 6),
(14, 'Forum Beheer', 'forum/forum_admin', '', 5),
(15, 'Categorie Beheer', 'categories', '', 6),
(16, 'Reset torrents ghost en delers', 'moderator/flush_ghost', '', 6);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `blocks`
--

CREATE TABLE IF NOT EXISTS `blocks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `blockid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `userfriend` (`userid`,`blockid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sort` int(10) NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL DEFAULT '',
  `parent` int(3) NOT NULL DEFAULT '0',
  `image` varchar(125) NOT NULL,
  `url` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Gegevens worden uitgevoerd voor tabel `categories`
--

INSERT INTO `categories` (`id`, `sort`, `name`, `parent`, `image`, `url`) VALUES
(1, 1, 'Films', 0, '', 'movie'),
(2, 2, 'Series', 0, '', 'tv'),
(3, 3, 'Games', 0, '', 'game'),
(4, 4, 'Porno XXX', 0, '', 'porno');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL DEFAULT '0',
  `torrent` int(10) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` text NOT NULL,
  `ori_text` text NOT NULL,
  `editedby` int(10) unsigned NOT NULL DEFAULT '0',
  `editedat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `torrent` (`torrent`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Gegevens worden uitgevoerd voor tabel `comments`
--

INSERT INTO `comments` (`id`, `user`, `torrent`, `added`, `text`, `ori_text`, `editedby`, `editedat`) VALUES
(1, 10, 3, '2015-07-24 20:32:50', '<p>Super geweldig uploader!!!</p><p>Deze pik ik ff mee van je :)</p><p><br></p><p>Groetjes <span style="font-size: 18px; color: rgb(255, 0, 255);">Sunshine</span></p>', '<p>Super geweldig uploader!!!</p><p>Deze pik ik ff mee van je :)</p><p><br></p><p>Groetjes <span style="font-size: 18px; color: rgb(255, 0, 255);">Sunshine</span></p>', 0, '0000-00-00 00:00:00'),
(7, 10, 2, '2015-08-16 22:58:21', 'Dit is best gaaf !!', 'Dit is best gaaf !!', 0, '0000-00-00 00:00:00'),
(8, 10, 5, '2015-09-02 01:12:58', '<span style="color: rgb(255, 0, 255);"><span style="font-weight: bold;">Dank je wel Decoder voor deze upload !!</span></span><br>', '<span style="color: rgb(255, 0, 255);"><span style="font-weight: bold;">Dank je wel Decoder voor deze upload !!</span></span><br>', 0, '0000-00-00 00:00:00'),
(9, 11, 5, '2015-09-09 14:14:37', 'Dank jewel uploader...deze pak ik ook ff mee van je :)', 'Dank jewel uploader...deze pak ik ook ff mee van je :)', 0, '0000-00-00 00:00:00'),
(10, 11, 9, '2015-09-09 14:53:58', '<p>Dank je wel upper deze neem ik ook ffies mee :)</p><p>Groetjes sandor</p>', '<p>Dank je wel upper deze neem ik ook ffies mee :)</p><p>Groetjes sandor</p>', 0, '0000-00-00 00:00:00'),
(12, 14, 5, '2015-12-18 12:10:11', 'Iii', 'Iii', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `image` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

--
-- Gegevens worden uitgevoerd voor tabel `countries`
--

INSERT INTO `countries` (`id`, `name`, `image`) VALUES
(1, 'Sweden', 'sweden.gif'),
(2, 'United States of America', 'usa.gif'),
(3, 'Russia', 'russia.gif'),
(4, 'Finland', 'finland.gif'),
(5, 'Canada', 'canada.gif'),
(6, 'France', 'france.gif'),
(7, 'Germany', 'germany.gif'),
(8, 'China', 'china.gif'),
(9, 'Italy', 'italy.gif'),
(10, 'Denmark', 'denmark.gif'),
(11, 'Norway', 'norway.gif'),
(12, 'United Kingdom', 'uk.gif'),
(13, 'Ireland', 'ireland.gif'),
(14, 'Poland', 'poland.gif'),
(15, 'Netherlands', 'netherlands.gif'),
(16, 'Belgium', 'belgium.gif'),
(17, 'Japan', 'japan.gif'),
(18, 'Brazil', 'brazil.gif'),
(19, 'Argentina', 'argentina.gif'),
(20, 'Australia', 'australia.gif'),
(21, 'New Zealand', 'newzealand.gif'),
(22, 'Spain', 'spain.gif'),
(23, 'Portugal', 'portugal.gif'),
(24, 'Mexico', 'mexico.gif'),
(25, 'Singapore', 'singapore.gif'),
(26, 'South Africa', 'southafrica.gif'),
(27, 'South Korea', 'southkorea.gif'),
(28, 'Jamaica', 'jamaica.gif'),
(29, 'Luxembourg', 'luxembourg.gif'),
(30, 'Hong Kong', 'hongkong.gif'),
(31, 'Belize', 'belize.gif'),
(32, 'Algeria', 'algeria.gif'),
(33, 'Angola', 'angola.gif'),
(34, 'Austria', 'austria.gif'),
(35, 'Yugoslavia', 'yugoslavia.gif'),
(36, 'Western Samoa', 'westernsamoa.gif'),
(37, 'Malaysia', 'malaysia.gif'),
(38, 'Dominican Republic', 'dominicanrep.gif'),
(39, 'Greece', 'greece.gif'),
(40, 'Guatemala', 'guatemala.gif'),
(41, 'Israel', 'israel.gif'),
(42, 'Pakistan', 'pakistan.gif'),
(43, 'Czech Republic', 'czechrep.gif'),
(44, 'Serbia', 'serbia.gif'),
(45, 'Seychelles', 'seychelles.gif'),
(46, 'Taiwan', 'taiwan.gif'),
(47, 'Puerto Rico', 'puertorico.gif'),
(48, 'Chile', 'chile.gif'),
(49, 'Cuba', 'cuba.gif'),
(50, 'Congo', 'congo.gif'),
(51, 'Afghanistan', 'afghanistan.gif'),
(52, 'Turkey', 'turkey.gif'),
(53, 'Uzbekistan', 'uzbekistan.gif'),
(54, 'Switzerland', 'switzerland.gif'),
(55, 'Kiribati', 'kiribati.gif'),
(56, 'Philippines', 'philippines.gif'),
(57, 'Burkina Faso', 'burkinafaso.gif'),
(58, 'Nigeria', 'nigeria.gif'),
(59, 'Iceland', 'iceland.gif'),
(60, 'Nauru', 'nauru.gif'),
(61, 'Slovenia', 'slovenia.gif'),
(62, 'Albania', 'albania.gif'),
(63, 'Turkmenistan', 'turkmenistan.gif'),
(64, 'Bosnia Herzegovina', 'bosniaherzegovina.gif'),
(65, 'Andorra', 'andorra.gif'),
(66, 'Lithuania', 'lithuania.gif'),
(67, 'India', 'india.gif'),
(68, 'Netherlands Antilles', 'nethantilles.gif'),
(69, 'Ukraine', 'ukraine.gif'),
(70, 'Venezuela', 'venezuela.gif'),
(71, 'Hungary', 'hungary.gif'),
(72, 'Romania', 'romania.gif'),
(73, 'Vanuatu', 'vanuatu.gif'),
(74, 'Vietnam', 'vietnam.gif'),
(75, 'Trinidad & Tobago', 'trinidadandtobago.gif'),
(76, 'Honduras', 'honduras.gif'),
(77, 'Kyrgyzstan', 'kyrgyzstan.gif'),
(78, 'Ecuador', 'ecuador.gif'),
(79, 'Bahamas', 'bahamas.gif'),
(80, 'Peru', 'peru.gif'),
(81, 'Cambodia', 'cambodia.gif'),
(82, 'Barbados', 'barbados.gif'),
(83, 'Bangladesh', 'bangladesh.gif'),
(84, 'Laos', 'laos.gif'),
(85, 'Uruguay', 'uruguay.gif'),
(86, 'Antigua Barbuda', 'antiguabarbuda.gif'),
(87, 'Paraguay', 'paraguay.gif'),
(88, 'Union of Soviet Socialist Repu', 'ussr.gif'),
(89, 'Thailand', 'thailand.gif'),
(90, 'Senegal', 'senegal.gif'),
(91, 'Togo', 'togo.gif'),
(92, 'North Korea', 'northkorea.gif'),
(93, 'Croatia', 'croatia.gif'),
(94, 'Estonia', 'estonia.gif'),
(95, 'Colombia', 'colombia.gif'),
(96, 'Lebanon', 'lebanon.gif'),
(97, 'Latvia', 'latvia.gif'),
(98, 'Costa Rica', 'costarica.gif'),
(99, 'Egypt', 'egypt.gif'),
(100, 'Bulgaria', 'bulgaria.gif');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `downloaded`
--

CREATE TABLE IF NOT EXISTS `downloaded` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `torrent` int(9) NOT NULL DEFAULT '0',
  `downloaded` bigint(25) NOT NULL DEFAULT '0',
  `uploaded` bigint(25) NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user` int(11) NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Gegevens worden uitgevoerd voor tabel `downloaded`
--

INSERT INTO `downloaded` (`id`, `torrent`, `downloaded`, `uploaded`, `added`, `user`, `username`) VALUES
(1, 5, 1981030666, 0, '2015-09-09 19:13:08', 11, 'leeg'),
(2, 5, 668213514, 0, '2015-09-10 07:06:40', 10, 'leeg'),
(4, 9, 124496841, 0, '2015-09-29 11:47:38', 11, 'leeg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `downup`
--

CREATE TABLE IF NOT EXISTS `downup` (
  `torrent` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `uploaded` bigint(20) NOT NULL,
  `downloaded` bigint(20) NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastseen` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `username` varchar(40) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `downup`
--

INSERT INTO `downup` (`torrent`, `user`, `uploaded`, `downloaded`, `added`, `lastseen`, `username`) VALUES
(1, 8, 2080768, 0, '2015-08-20 17:19:37', '0000-00-00 00:00:00', ''),
(9, 8, 3670923154, 0, '2015-09-07 21:32:04', '2015-09-29 12:36:53', ''),
(9, 9, 59255753, 583008256, '2015-09-07 22:18:12', '2015-09-19 13:25:16', ''),
(5, 11, 238534656, 1981030666, '2015-09-09 14:15:13', '2015-09-10 05:32:02', ''),
(5, 8, 3599909396, 0, '2015-09-09 14:33:22', '2015-09-10 05:29:06', ''),
(9, 11, 1638400, 281018368, '2015-09-09 14:57:20', '2015-09-09 16:27:23', ''),
(5, 10, 2054328801, 1981030666, '2015-09-09 23:11:52', '2015-09-10 05:03:53', ''),
(10, 9, 80723968, 0, '2015-09-12 14:06:48', '2015-09-12 15:06:50', ''),
(10, 10, 0, 118617798, '2015-09-12 14:21:23', '2015-09-12 14:42:12', ''),
(11, 14, 0, 580833, '2015-12-15 20:08:47', '0000-00-00 00:00:00', ''),
(11, 8, 606208, 0, '2015-12-15 20:19:17', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `torrent` int(10) unsigned NOT NULL DEFAULT '0',
  `filename` varchar(255) NOT NULL DEFAULT '',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `torrent` (`torrent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Gegevens worden uitgevoerd voor tabel `files`
--

INSERT INTO `files` (`id`, `torrent`, `filename`, `size`) VALUES
(1, 1, 'Insurgent.2015.1080p.BluRay.x264.YIFY.mp4', 1978804695),
(2, 1, 'WWW.YTS.TO.jpg', 105983),
(3, 2, 'Avengers.Age.of.Ultron.2015.TCRip.XVID.AC3.HQ.Hive-CM8.avi', 1965563904),
(4, 3, 'the.flash.2014.123.hdtv-lol.mp4', 233057937),
(5, 3, 'Sample/the.flash.2014.123.hdtv-lol.sample.mp4', 3128878),
(6, 3, 'the.flash.2014.123.hdtv-lol.nfo', 4359),
(7, 3, 'Torrent-Downloaded-From-extratorrent.cc.txt', 172),
(8, 4, 'Kingsman.The.Secret.Service.2014.1080p.BluRay.x264.YIFY.mp4', 2096409117),
(9, 4, 'WWW.YTS.TO.jpg', 105983),
(10, 5, 'Mad.Max.Fury.Road.2015.1080p.BluRay.x264.YIFY.mp4', 1980924683),
(11, 5, 'WWW.YTS.TO.jpg', 105983),
(12, 6, 'Big Penetration/04.wmv', 911168444),
(13, 6, 'Big Penetration/07.wmv', 677039526),
(14, 6, 'Big Penetration/06.wmv', 625991334),
(15, 6, 'She Can Do What/06.wmv', 605743244),
(16, 6, 'Big Penetration/01.wmv', 591175190),
(17, 6, 'Big Penetration/05.wmv', 586839172),
(18, 6, 'Big Penetration/03.wmv', 563055076),
(19, 6, 'She Can Do What/03.wmv', 537647208),
(20, 6, 'She Can Do What/01.wmv', 500134836),
(21, 6, 'Big Penetration/02.wmv', 495990818),
(22, 6, 'She Can Do What/02.wmv', 401990452),
(23, 6, 'She Can Do What/05.wmv', 376822350),
(24, 6, 'She Can Do What/04.wmv', 236133828),
(25, 6, 'episode.jpg', 138203),
(26, 7, 'Pitch.Perfect.2.2015.1080p.BluRay.x264.YIFY.mp4', 1984197164),
(27, 7, 'WWW.YTS.TO.jpg', 105983),
(28, 8, 'Big Penetration/04.wmv', 911168444),
(29, 8, 'Big Penetration/07.wmv', 677039526),
(30, 8, 'Big Penetration/06.wmv', 625991334),
(31, 8, 'She Can Do What/06.wmv', 605743244),
(32, 8, 'Big Penetration/01.wmv', 591175190),
(33, 8, 'Big Penetration/05.wmv', 586839172),
(34, 8, 'Big Penetration/03.wmv', 563055076),
(35, 8, 'She Can Do What/03.wmv', 537647208),
(36, 8, 'She Can Do What/01.wmv', 500134836),
(37, 8, 'Big Penetration/02.wmv', 495990818),
(38, 8, 'She Can Do What/02.wmv', 401990452),
(39, 8, 'She Can Do What/05.wmv', 376822350),
(40, 8, 'She Can Do What/04.wmv', 236133828),
(41, 8, 'episode.jpg', 138203),
(42, 9, 'Big.Hero.6.2014.1080p.WEB-DL.DD5.1.H264-RARBG.mkv', 2147483647),
(43, 9, 'RARBG.com.mp4', 1016764),
(44, 9, 'English.srt', 88013),
(45, 9, 'Big.Hero.6.2014.1080p.WEB-DL.DD5.1.H264-RARBG.nfo', 5657),
(46, 9, 'RARBG.com.txt', 34),
(47, 10, 'Minecraft.rar', 143259334),
(48, 11, 'Pan.2015.720p.BluRay.H264.AAC-RARBG.mp4', 1446779457),
(49, 11, 'Subs/Pan.2015.720p.BluRay.H264.AAC-RARBG.sub', 7653376),
(50, 11, 'RARBG.COM.mp4', 1016764),
(51, 11, 'Subs/Pan.2015.720p.BluRay.H264.AAC-RARBG.idx', 67532),
(52, 11, 'Pan.2015.720p.BluRay.H264.AAC-RARBG.nfo', 3940),
(53, 11, 'RARBG.COM.txt', 34);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `forums`
--

CREATE TABLE IF NOT EXISTS `forums` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '',
  `description` varchar(200) DEFAULT NULL,
  `minclassread` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `minclasswrite` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `postcount` int(10) unsigned NOT NULL DEFAULT '0',
  `topiccount` int(10) unsigned NOT NULL DEFAULT '0',
  `lastpost` int(10) DEFAULT NULL,
  `minclasscreate` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `forid` tinyint(4) DEFAULT '0',
  `sort` int(10) NOT NULL DEFAULT '999',
  PRIMARY KEY (`id`),
  UNIQUE KEY `lastpost` (`lastpost`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Gegevens worden uitgevoerd voor tabel `forums`
--

INSERT INTO `forums` (`id`, `name`, `description`, `minclassread`, `minclasswrite`, `postcount`, `topiccount`, `lastpost`, `minclasscreate`, `forid`, `sort`) VALUES
(2, 'Algemeen', 'Alle shit ', 0, 0, 7, 3, NULL, 0, 0, 1),
(3, 'Moderator Forum', 'Mods alleen', 0, 4, 2, 2, NULL, 4, 0, 2),
(4, 'Hoe werkt dit allemaal ?', 'Uitleg jip en janneke taal', 0, 0, 1, 1, NULL, 4, 0, 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `friendid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `userfriend` (`userid`,`friendid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Gegevens worden uitgevoerd voor tabel `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User'),
(3, 'uploader', 'mag uploaden'),
(4, 'moderators', 'Hebben verschillende mogelijkheden'),
(5, 'beheerder', 'Beheerder kan alles op de site'),
(6, 'owner', 'De eigenaar van de site');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hits`
--

CREATE TABLE IF NOT EXISTS `hits` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `page` varchar(40) NOT NULL DEFAULT '',
  `kliks` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=207 ;

--
-- Gegevens worden uitgevoerd voor tabel `hits`
--

INSERT INTO `hits` (`id`, `user_id`, `page`, `kliks`) VALUES
(1, 8, '/', 376),
(2, 8, '/torrents', 457),
(3, 8, '/torrents/details/3', 87),
(4, 8, '/moderator', 207),
(5, 8, '/forum/forum_admin', 11),
(6, 8, '/torrents/upload', 53),
(7, 8, '/messages', 71),
(8, 8, '/messages/details/51', 5),
(9, 8, '/forum', 90),
(10, 8, '/forum/viewforum/2', 30),
(11, 8, '/forum/viewtopic/11', 19),
(12, 8, '/members/details/8', 139),
(13, 8, '/members/details/11', 31),
(14, 8, '/members/details/10', 119),
(15, 8, '/messages/details/50', 6),
(16, 8, '/messages/details/49', 9),
(17, 8, '/shoutbox', 134),
(18, 8, '/moderator/site_message', 24),
(19, 8, '/moderator/peerlist', 30),
(20, 8, '/moderator/testpage', 23),
(21, 9, '/', 39),
(22, 9, '/torrents/details/3', 5),
(23, 9, '/shoutbox', 14),
(24, 9, '/torrents/upload', 5),
(25, 9, '/moderator', 15),
(26, 8, '/torrents/details/2', 62),
(27, 8, '/torrents/torrent_edit/3', 6),
(28, 8, '/torrents/details/1', 28),
(29, 8, '/members/details/9', 88),
(30, 8, '/moderator/users_modtask/9', 85),
(31, 8, '/moderator/users_modtask/11', 3),
(32, 8, '/members/details', 40),
(33, 8, '/torrents/details/2/hit', 2),
(34, 8, '/forum/viewforum/3', 8),
(35, 8, '/forum/viewtopic/15', 3),
(36, 8, '/torrents/details/3/hit', 1),
(37, 8, '/moderator/users_modtask/credits.php', 1),
(38, 8, '/moderator/users_modtask/inbox.php', 1),
(39, 8, '/staff', 96),
(40, 8, '/messages/sendmessage/Decoder', 10),
(41, 9, '/forum', 12),
(42, 9, '/members/details/9', 14),
(43, 9, '/staff', 18),
(44, 8, '/moderator/new_page', 5),
(45, 8, '/messages/details/60', 5),
(46, 9, '/messages/details/45', 1),
(47, 9, '/messages/details/46', 1),
(48, 9, '/messages/details/43', 1),
(49, 9, '/messages/details/61', 2),
(50, 9, '/messages/details/41', 1),
(51, 9, '/messages/details/40', 1),
(52, 9, '/messages/details/42', 1),
(53, 9, '/messages/details/39', 1),
(54, 9, '/messages/details/38', 1),
(55, 9, '/messages/details/37', 1),
(56, 9, '/messages/details/33', 1),
(57, 9, '/messages/', 2),
(58, 9, '/members/details/8', 6),
(59, 9, '/messages', 10),
(60, 9, '/messages/details/62', 1),
(61, 9, '/messages/details/63', 3),
(62, 9, '/messages/details/64', 3),
(63, 9, '/torrents', 14),
(64, 9, '/messages/details/65', 2),
(65, 8, '/forum/viewtopic/13', 1),
(66, 8, '/torrents/torrent_edit/2', 1),
(67, 8, '/messages/sendmessage/RCR1984', 5),
(68, 8, '/forum/viewtopic/14', 2),
(69, 8, '/forum/replay/14', 8),
(70, 8, '/forum/viewtopic/12', 4),
(71, 8, '/moderator/users_modtask/10', 17),
(72, 9, '/messages/details/66', 3),
(73, 9, '/torrents/details/2', 4),
(74, 9, '/torrents/torrent_edit/2', 1),
(75, 8, '/members', 5),
(76, 8, '/auth', 5),
(77, 8, '/auth/create_user', 2),
(78, 8, '/auth/create_group', 1),
(79, 8, '/torrents/details/4', 103),
(80, 8, '/torrents/details/4/hit', 4),
(81, 8, '/torrents/torrent_edit/4', 15),
(82, 9, '/torrents/details/4', 1),
(83, 9, '/messages/sendmessage/Decoder', 2),
(84, 9, '/forum/viewforum/4', 3),
(85, 9, '/forum/viewforum/3', 2),
(86, 9, '/forum/viewtopic/15', 4),
(87, 8, '/messages/details/69', 3),
(88, 8, '/forum/viewforum/4', 3),
(89, 8, '/forum/newtopic/4', 1),
(90, 8, '/messages/details/70', 8),
(91, 8, '/messages/details/71', 1),
(92, 8, '/forum/newtopic/2', 1),
(93, 8, '/forum/viewtopic/16', 5),
(94, 8, '/forum/viewforum/200', 1),
(95, 8, '/moderator/checkpasskey', 61),
(96, 8, '/moderator/uploaders', 45),
(97, 9, '/moderator/checkpasskey', 2),
(98, 9, '/moderator/peerlist', 1),
(99, 9, '/forum/replay/15', 1),
(100, 9, '/forum/viewtopic/15?action=viewforum&for', 1),
(101, 9, '/forum/forum_admin', 2),
(102, 8, '/forum/viewtopic/14?action=viewforum&for', 1),
(103, 8, '/forum?action=search', 1),
(104, 8, '/forum?action=viewunread', 1),
(105, 8, '/forum?catchup', 1),
(106, 8, '/torrents/details/5', 67),
(107, 8, '/torrents/do_upload/5', 2),
(108, 8, '/torrents/details/6', 60),
(109, 8, '/torrents/torrent_edit/6', 7),
(110, 8, '/torrents/details/6/hit', 1),
(111, 8, '/forum/newtopic/3', 1),
(112, 8, '/forum/forum_edit/4', 2),
(113, 8, '/torrents/details/7', 16),
(114, 8, '/torrents/details/8', 5),
(115, 8, '/torrents/details/8/hit', 14),
(116, 8, '/torrents/details/9', 132),
(117, 8, '/torrents/details/9/hit', 3),
(118, 9, '/torrents/details/9', 2),
(119, 9, '/moderator/site_message', 6),
(120, 8, '/categories', 10),
(121, 8, '/categories/edit/2', 1),
(122, 8, '/categories/edit/1', 1),
(123, 8, '/categories/edit/3', 1),
(124, 8, '/categories/edit/4', 1),
(125, 8, '/torrents/search?searchquery=1080', 18),
(126, 8, '/torrents/search?searchquery=pitch', 1),
(127, 8, '/torrents/search?searchquery=avengers', 6),
(128, 8, '/torrents/search?searchquery=hero', 3),
(129, 8, '/torrents/search?searchquery=big', 5),
(130, 8, '/torrents/search?searchquery=perfect', 1),
(131, 8, '/torrents/search?searchquery=fury', 1),
(132, 8, '/torrents/search?searchquery=2015', 2),
(133, 8, '/torrents/search?searchquery=ftv', 2),
(134, 8, '/torrents/details/8/delete.php', 1),
(135, 8, '/messages/details/72', 4),
(136, 9, '/torrents/search?searchquery=big+hero+6', 1),
(137, 9, '/messages/details/73', 1),
(138, 8, '/torrents/torrent_mass_message/7', 34),
(139, 8, '/torrents/torrent_mass_message/pics/syst', 1),
(140, 8, '/torrents/torrent_mass_message/9', 17),
(141, 8, '/messages/details/82', 3),
(142, 8, '/messages/details/84', 6),
(143, 8, '/messages/sendmessage/Sandor', 1),
(144, 8, '/torrents/details/5/hit', 2),
(145, 8, '/members/details/12', 10),
(146, 10, '/', 8),
(147, 10, '/torrents', 9),
(148, 10, '/torrents/details/9', 3),
(149, 10, '/members/details/8', 12),
(150, 10, '/members/details', 6),
(151, 10, '/moderator', 5),
(152, 10, '/moderator/peerlist', 3),
(153, 10, '/shoutbox', 9),
(154, 10, '/members/details/10', 5),
(155, 10, '/members/details/12', 1),
(156, 10, '/members/details/9', 3),
(157, 9, '/messages/details/85', 2),
(158, 10, '/torrents/details/5', 5),
(159, 10, '/torrents/details/5/hit', 1),
(160, 10, '/torrents/torrent_mass_message/5', 1),
(161, 9, '/torrents/details/10', 8),
(162, 9, '/torrents/do_upload/10', 1),
(163, 10, '/torrents/details/10', 5),
(164, 8, '/torrents/details/10', 8),
(165, 10, '/messages/details/81', 1),
(166, 10, '/torrents/details/4', 1),
(167, 10, '/staff', 4),
(168, 10, '/members/details/11', 1),
(169, 10, '/moderator/users_modtask/11', 2),
(170, 10, '/forum', 4),
(171, 10, '/torrents/torrent_mass_message/10', 1),
(172, 10, '/forum/viewforum/2', 2),
(173, 10, '/forum/viewtopic/11', 1),
(174, 10, '/messages', 1),
(175, 8, '/messages/sendmessage/Sunshine', 1),
(176, 9, '/messages/details/89', 1),
(177, 8, '/messages/details/90', 4),
(178, 8, '/torrents/torrent_mass_message/1', 2),
(179, 8, '/messages/details/91', 13),
(180, 8, '/torrents/details/7/hit', 1),
(181, 8, '/torrents/torrent_mass_message/4', 2),
(182, 8, '/torrents/search?searchquery=test', 6),
(183, 8, '/torrents/search?searchquery=spiderman', 1),
(184, 8, '/torrents/search?searchquery=kings', 1),
(185, 8, '/torrents/search?searchquery=king', 3),
(186, 8, '/torrents/search?searchquery=mad', 2),
(187, 8, '/torrents/search?searchquery=ma', 1),
(188, 8, '/torrents/search?searchquery=k', 2),
(189, 8, '/torrents/search?searchquery=m', 3),
(190, 8, '/torrents/search?searchquery=b', 1),
(191, 8, '/torrents/search?searchquery=10', 1),
(192, 8, '/torrents/search?searchquery=a', 1),
(193, 8, '/moderator/users_modtask/user_helpdesk.p', 1),
(194, 10, '/messages/details/87', 1),
(195, 8, '/torrents/details/11', 7),
(196, 9, '/messages/details/92', 1),
(197, 8, '/members/details/14', 6),
(198, 8, '/moderator/users_modtask/14', 1),
(199, 8, '/torrents/search?searchquery=te', 1),
(200, 8, '/torrents/search?searchquery=sa', 1),
(201, 8, '/torrents/search?searchquery=bi', 1),
(202, 10, '/forum/viewforum/3', 1),
(203, 8, '/torrents/torrent_edit/9', 2),
(204, 8, '/forum/replay/15', 1),
(205, 8, '/torrents/search?searchquery=t', 1),
(206, 8, '/torrents/search?searchquery=e', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `massa_bericht_torrents`
--

CREATE TABLE IF NOT EXISTS `massa_bericht_torrents` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL DEFAULT '0',
  `aantal` mediumint(11) NOT NULL DEFAULT '0',
  `msg` varchar(255) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `send_to` int(11) NOT NULL DEFAULT '0',
  `done` enum('yes','no') NOT NULL DEFAULT 'no',
  `torrent_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `massa_bericht_torrents`
--

INSERT INTO `massa_bericht_torrents` (`id`, `sender`, `aantal`, `msg`, `added`, `send_to`, `done`, `torrent_id`) VALUES
(1, 8, 0, 'Hallo,\n\ndit is een testbericht\n\nMet vriendelijke groet,\n\nDecoder\n\nDit bericht wordt aan iedereen verzonden die de torrent ''Pitch Perfect 2 (2015) [1080p]''\naan het ontvangen is of ontvangen heeft.', '2015-09-08 03:32:26', 0, 'no', 7),
(2, 8, 2, 'Hallo,\r\n\r\ndit is een testbericht.......\r\n\r\nMet vriendelijke groet,\r\n\r\nDecoder\r\n\r\nDit bericht wordt aan iedereen verzonden die de torrent ''Big Hero 6 (2014) [1080p]''\r\naan het ontvangen is of ontvangen heeft.', '2015-09-08 03:45:36', 0, 'no', 9),
(3, 8, 2, 'Hallo,\r\n\r\nNog een test....\r\n\r\nMet vriendelijke groet,\r\n\r\nDecoder\r\n\r\nDit bericht wordt aan iedereen verzonden die de torrent ''Big Hero 6 (2014) [1080p]''\r\naan het ontvangen is of ontvangen heeft.', '2015-09-08 03:50:02', 0, 'no', 9);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `menu`
--

INSERT INTO `menu` (`id`, `url`, `name`, `icon`, `order`) VALUES
(1, 'torrents', 'Torrents', 'glyphicon-film', 1),
(2, 'shoutbox', 'Shoutbox', 'glyphicon-comment', 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender` int(10) unsigned NOT NULL DEFAULT '0',
  `receiver` int(10) unsigned NOT NULL DEFAULT '0',
  `added` datetime DEFAULT NULL,
  `msg` text,
  `unread` enum('yes','no') NOT NULL DEFAULT 'yes',
  `poster` bigint(20) unsigned NOT NULL DEFAULT '0',
  `location` enum('in','out','both') NOT NULL DEFAULT 'in',
  `subject` varchar(255) NOT NULL,
  `saved` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `receiver` (`receiver`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

--
-- Gegevens worden uitgevoerd voor tabel `messages`
--

INSERT INTO `messages` (`id`, `sender`, `receiver`, `added`, `msg`, `unread`, `poster`, `location`, `subject`, `saved`) VALUES
(33, 8, 9, '2015-06-26 14:35:52', 'Hallo RCR1984,\n\nU heeft een waarschuwing gehad voor ''Lage Ratio'' (Hit & Run).\nHetgeen inhoud dat u een meer Gb ontvangt als wenst te delen aan andere gebruikers.\nRatio is de deling van hetgeen u heeft verzonden door hetgeen u heeft ontvangen.\nU kunt dit verbeteren doormiddel van te blijven delen (seeden) na het downloaden totdat uw ratio weer goed is.\nEen lage ratio betekend ook dat u minder torrents tergelijkertijd mag gebruiken.\nBij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\nTevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\nMet vriendelijke groet,\nStaff van Veranderen\n ', 'no', 0, 'in', 'U heeft een waarschuwing gekregen', 'no'),
(37, 0, 9, '2015-06-27 16:29:01', 'Uw waarschuwing is verwijderd door Decoder.', 'no', 0, 'in', 'Waarschuwing verwijderd', 'no'),
(38, 8, 9, '2015-06-28 07:46:42', 'Dit bericht is leeg', 'no', 0, 'out', 'Leeeg', 'no'),
(39, 10, 9, '2015-06-28 07:48:20', 'Dit bericht was ook leeg.....', 'no', 0, 'in', 'Deze ook', 'no'),
(40, 8, 9, '2015-06-28 07:54:43', 'Nog maar een test bericht<br>', 'no', 0, 'in', 'Test', 'no'),
(41, 8, 9, '2015-06-28 08:47:16', '<p><span style="font-weight: bold;">Hallo RCR1984</span>,\r\n\r\n</p><p>U heeft een waarschuwing gehad voor ''Lage Ratio'' (Hit &amp; Run).\r\nHetgeen inhoud dat u een meer Gb ontvangt als wenst te delen aan andere gebruikers.\r\n</p><p>Ratio is de deling van hetgeen u heeft verzonden door hetgeen u heeft ontvangen.\r\nU kunt dit verbeteren doormiddel van te blijven delen (seeden) na het downloaden totdat uw ratio weer goed is.\r\nEen lage ratio betekend ook dat u minder torrents tegelijkertijd mag gebruiken.\r\n</p><p>Bij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\r\nTevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\r\n\r\nMet vriendelijke groet,\r\nStaff van Veranderen\r\n </p>', 'no', 0, 'in', 'Geen idee wat dit is ', 'no'),
(42, 8, 9, '2015-06-29 20:10:33', '&lt;h1&gt;HTML Ipsum Presents&lt;/h1&gt;<br>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<br>&lt;p&gt;&lt;strong&gt;Pellentesque habitant morbi tristique&lt;/strong&gt; senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. &lt;em&gt;Aenean ultricies mi vitae est.&lt;/em&gt; Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, &lt;code&gt;commodo vitae&lt;/code&gt;, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. &lt;a href="#"&gt;Donec non enim&lt;/a&gt; in turpis pulvinar facilisis. Ut felis.&lt;/p&gt;<br><br>&lt;h2&gt;Header Level 2&lt;/h2&gt;<br>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<br>&lt;ol&gt;<br>&nbsp;&nbsp; &lt;li&gt;Lorem ipsum dolor sit amet, consectetuer adipiscing elit.&lt;/li&gt;<br>&nbsp;&nbsp; &lt;li&gt;Aliquam tincidunt mauris eu risus.&lt;/li&gt;<br>&lt;/ol&gt;<br><br>&lt;blockquote&gt;&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue. Ut a est eget ligula molestie gravida. Curabitur massa. Donec eleifend, libero at sagittis mollis, tellus est malesuada tellus, at luctus turpis elit sit amet quam. Vivamus pretium ornare est.&lt;/p&gt;&lt;/blockquote&gt;<br><br>&lt;h3&gt;Header Level 3&lt;/h3&gt;<br><br>&lt;ul&gt;<br>&nbsp;&nbsp; &lt;li&gt;Lorem ipsum dolor sit amet, consectetuer adipiscing elit.&lt;/li&gt;<br>&nbsp;&nbsp; &lt;li&gt;Aliquam tincidunt mauris eu risus.&lt;/li&gt;<br>&lt;/ul&gt;<br><br>&lt;pre&gt;&lt;code&gt;<br>#header h1 a { <br>&nbsp;&nbsp; &nbsp;display: block; <br>&nbsp;&nbsp; &nbsp;width: 300px; <br>&nbsp;&nbsp; &nbsp;height: 80px; <br>}<br>&lt;/code&gt;&lt;/pre&gt;', 'no', 0, 'in', 'Dit is HET testbericht.....kiek Rich :)', 'no'),
(43, 8, 9, '2015-06-29 20:11:10', '<h1>HTML Ipsum Presents</h1>           <p><strong>Pellentesque habitant morbi tristique</strong> senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, <code>commodo vitae</code>, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. <a href="#">Donec non enim</a> in turpis pulvinar facilisis. Ut felis.</p><h2>Header Level 2</h2>           <ol>   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>   <li>Aliquam tincidunt mauris eu risus.</li></ol><blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue. Ut a est eget ligula molestie gravida. Curabitur massa. Donec eleifend, libero at sagittis mollis, tellus est malesuada tellus, at luctus turpis elit sit amet quam. Vivamus pretium ornare est.</p></blockquote><h3>Header Level 3</h3><ul>   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>   <li>Aliquam tincidunt mauris eu risus.</li></ul><pre><code>#header h1 a {    display: block;    width: 300px;    height: 80px;}</code></pre>', 'no', 0, 'in', 'Dit is HET testbericht.....kiek Rich :)', 'no'),
(45, 8, 9, '2015-06-29 20:12:03', '    <div>         <label for="name">Text Input:</label>         <input name="name" id="name" value="" tabindex="1" type="text">    </div>    <div>         <h4>Radio Button Choice</h4>         <label for="radio-choice-1">Choice 1</label>         <input name="radio-choice-1" id="radio-choice-1" tabindex="2" value="choice-1" type="radio">		 <label for="radio-choice-2">Choice 2</label>         <input name="radio-choice-2" id="radio-choice-2" tabindex="3" value="choice-2" type="radio">    </div>	<div>		<label for="select-choice">Select Dropdown Choice:</label>		<select name="select-choice" id="select-choice">			<option value="Choice 1">Choice 1</option>			<option value="Choice 2">Choice 2</option>			<option value="Choice 3">Choice 3</option>		</select>	</div>		<div>		<label for="textarea">Textarea:</label>		<textarea cols="40" rows="8" name="textarea" id="textarea"></textarea>	</div>		<div>	    <label for="checkbox">Checkbox:</label>		<input name="checkbox" id="checkbox" type="checkbox">    </div>	<div>	    <input value="Submit" type="submit">    </div>', 'no', 0, 'in', 'Formulier?', 'no'),
(46, 8, 9, '2015-06-30 05:49:11', '', 'no', 0, 'in', 'test', 'no'),
(49, 0, 8, '2015-07-11 14:02:01', 'Uw waarschuwing is verwijderd door Decoder.', 'no', 0, 'in', 'test', 'no'),
(50, 8, 8, '2015-07-11 14:09:00', 'Hallo Decoder,\n\nU heeft een waarschuwing gehad voor ''Lage Ratio'' (Hit & Run).\nHetgeen inhoud dat u een meer Gb ontvangt als wenst te delen aan andere gebruikers.\nRatio is de deling van hetgeen u heeft verzonden door hetgeen u heeft ontvangen.\nU kunt dit verbeteren doormiddel van te blijven delen (seeden) na het downloaden totdat uw ratio weer goed is.\nEen lage ratio betekend ook dat u minder torrents tergelijkertijd mag gebruiken.\nBij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\nTevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\nMet vriendelijke groet,\nStaff van Veranderen\n ', 'no', 0, 'in', 'U heeft een waarschuwing gekregen!', 'no'),
(51, 0, 8, '2015-07-11 23:29:52', 'Uw waarschuwing is verwijderd.', 'no', 0, 'in', 'Uw waarschuwing is verwijderd door Decoder.', 'no'),
(52, 0, 10, '2015-07-24 22:15:33', 'Uw waarschuwing is verwijderd door Decoder.', 'no', 0, 'in', 'Uw waarschuwing is verwijderd.', 'no'),
(53, 8, 10, '2015-07-24 22:17:02', 'Hallo <a href=http://torrent-empire.org/members/details/10>Sunshine </a>,\n\nU heeft een waarschuwing gehad voor ''Lage Ratio'' (Hit & Run).\nHetgeen inhoud dat u een meer Gb ontvangt als wenst te delen aan andere gebruikers.\nRatio is de deling van hetgeen u heeft verzonden door hetgeen u heeft ontvangen.\nU kunt dit verbeteren doormiddel van te blijven delen (seeden) na het downloaden totdat uw ratio weer goed is.\nEen lage ratio betekend ook dat u minder torrents tergelijkertijd mag gebruiken.\nBij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\nTevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\nMet vriendelijke groet,\nStaff van Veranderen\n ', 'no', 0, 'in', 'U heeft een waarschuwing gekregen!', 'no'),
(54, 0, 10, '2015-07-24 22:18:04', 'Uw waarschuwing is verwijderd door Decoder.', 'no', 0, 'in', 'Uw waarschuwing is verwijderd.', 'no'),
(55, 8, 10, '2015-07-24 22:18:14', 'Hallo <a href=http://torrent-empire.org/members/details/10>Sunshine </a>,\n\nU heeft een waarschuwing gehad voor ''Lage Ratio'' (Hit & Run).\nHetgeen inhoud dat u een meer Gb ontvangt als wenst te delen aan andere gebruikers.\nRatio is de deling van hetgeen u heeft verzonden door hetgeen u heeft ontvangen.\nU kunt dit verbeteren doormiddel van te blijven delen (seeden) na het downloaden totdat uw ratio weer goed is.\nEen lage ratio betekend ook dat u minder torrents tergelijkertijd mag gebruiken.\nBij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\nTevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\nMet vriendelijke groet,\nStaff van Veranderen\n ', 'no', 0, 'in', 'U heeft een waarschuwing gekregen!', 'no'),
(56, 0, 10, '2015-07-24 22:18:27', 'Uw waarschuwing is verwijderd door Decoder.', 'no', 0, 'in', 'Uw waarschuwing is verwijderd.', 'no'),
(57, 8, 10, '2015-07-24 22:18:34', 'Hallo <a href=http://torrent-empire.org/members/details/10>Sunshine </a>,\n\nU heeft een waarschuwing gehad voor ''Lage Ratio'' (Hit & Run).\nHetgeen inhoud dat u een meer Gb ontvangt als wenst te delen aan andere gebruikers.\nRatio is de deling van hetgeen u heeft verzonden door hetgeen u heeft ontvangen.\nU kunt dit verbeteren doormiddel van te blijven delen (seeden) na het downloaden totdat uw ratio weer goed is.\nEen lage ratio betekend ook dat u minder torrents tergelijkertijd mag gebruiken.\nBij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\nTevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\nMet vriendelijke groet,\nStaff van Veranderen\n ', 'no', 0, 'in', 'U heeft een waarschuwing gekregen!', 'no'),
(58, 0, 10, '2015-07-24 22:18:48', 'Uw waarschuwing is verwijderd door Decoder.', 'no', 0, 'in', 'Uw waarschuwing is verwijderd.', 'no'),
(59, 8, 10, '2015-07-24 22:19:00', 'Hallo <a href=http://torrent-empire.org/members/details/10>Sunshine </a>,\n\nU heeft een waarschuwing gehad voor ''Pakken en wegwezen'' (Hit & Run).\nHetgeen inhoud dat u een torrent heeft gedownload en niet de moeite heeft genomen om te blijven delen voor andere gebruikers.\nBij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\nTevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\nMet vriendelijke groet,\nStaff van Veranderen\n ', 'no', 0, 'in', 'U heeft een waarschuwing gekregen!', 'no'),
(60, 8, 8, '2015-07-26 13:49:24', '<p><span style="font-weight: bold;">Hoi Decoder,</span></p><p>Ik wilde je even laten weten dat ik deze site bijzonder mooi vind......hoe heb je dat allemaal gedaan??</p><p>Zou ik een kopie mogen hebben hiervan?&nbsp;</p><p>Groetjes&nbsp;<span style="font-weight: bold;">John DOE</span></p>', 'no', 0, 'in', 'Dit is een testbericht', 'no'),
(61, 8, 9, '2015-07-27 23:35:36', '<p>Hallo <a href=http://torrent-empire.org/members/details/9>RCR1984 </a></p><p>Uw avatar is verwijderd omdat deze niet voldoet aan de gestelde regels van de site.<br>Ben u van meening dat dit onterecht is, dan kunt u contact opnemen met uw Moderator.</p><p>Met vriendelijke groet,</p><a href=http://torrent-empire.org/members/details/8>Decoder </a>', 'no', 0, 'in', 'Uw avatar is verwijderd.', 'no'),
(62, 8, 9, '2015-07-28 00:17:56', '<p>Hello "<a href=http://torrent-empire.org/members/details/9>RCR1984 </a>"</p><p>Youre avatar has been removed becouse it does not fit our site policy.<br>If you belive a mistake has been made, you could get in contact with your Moderator.</p><p>Kind regards,</p>"<a href=http://torrent-empire.org/members/details/8>Decoder </a>"', 'no', 0, 'in', 'youre avatar has been removed.', 'no'),
(63, 8, 9, '2015-07-28 00:21:55', '<p>Hello "<a href=http://torrent-empire.org/members/details/9>RCR1984 </a>"</p><p>Youre avatar has been removed becouse it does not fit our site policy.<br>If you belive a mistake has been made, you could get in contact with your Moderator.</p><p>Kind regards,</p>"<a href=http://torrent-empire.org/members/details/8>Decoder </a>"', 'no', 0, 'in', 'youre avatar has been removed.', 'no'),
(64, 8, 9, '2015-07-28 08:53:29', '<p>Hello <a href=http://torrent-empire.org/members/details/9>RCR1984 </a></p><p>Youre avatar has been removed becouse it does not fit our site policy.<br>If you belive a mistake has been made, you could get in contact with your Moderator.</p><p>Kind regards,</p><a href=http://torrent-empire.org/members/details/8>Decoder </a>', 'no', 0, 'in', 'your avatar has been removed.', 'no'),
(65, 8, 9, '2015-07-29 01:01:42', '', 'no', 0, 'in', '0', 'no'),
(66, 8, 9, '2015-07-29 01:59:42', '', 'no', 0, 'in', '0', 'no'),
(67, 8, 10, '2015-07-30 01:11:33', '<p>Hello <a href=http://torrent-empire.org/members/details/10>Sunshine </a></p><p>Youre avatar has been removed becouse it does not fit our site policy.<br>If you belive a mistake has been made, you could get in contact with your Moderator.</p><p>Kind regards,</p><a href=http://torrent-empire.org/members/details/8>Decoder </a>', 'no', 0, 'in', 'your avatar has been removed.', 'no'),
(68, 8, 10, '2015-07-30 01:21:18', '<p>Hello <a href=http://torrent-empire.org/members/details/10>Sunshine </a></p><p>Youre avatar has been removed becouse it does not fit our site policy.<br>If you belive a mistake has been made, you could get in contact with your Moderator.</p><p>Kind regards,</p><a href=http://torrent-empire.org/members/details/8>Decoder </a>', 'no', 0, 'in', 'your avatar has been removed.', 'no'),
(69, 9, 8, '2015-08-01 18:46:18', 'hoi ', 'no', 0, 'in', 'hi', 'no'),
(70, 8, 8, '2015-08-05 21:47:22', '<div class="styles-section-title styles-selector" style="min-width: 0px; min-height: 0px; word-wrap: break-word; cursor: text; color: rgb(34, 34, 34); font-family: Consolas, ''Lucida Console'', monospace; font-size: 12px; line-height: normal;"><div style="min-width: 0px; min-height: 0px;"><span class="selector" style="min-width: 0px; min-height: 0px; color: rgb(136, 136, 136);"><span class="simple-selector selector-matches" style="min-width: 0px; min-height: 0px; color: rgb(34, 34, 34);">.news</span></span><span style="min-width: 0px; min-height: 0px;">&nbsp;{</span></div></div><ol class="style-properties monospace" tabindex="0" style="min-width: 0px; min-height: 0px; font-family: Consolas, ''Lucida Console'', monospace; font-size: 12px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 2px 4px 0px 0px; list-style: none; clear: both; color: rgb(34, 34, 34); line-height: normal; white-space: nowrap;"><li style="min-width: 0px; min-height: 0px; padding-left: 38px; white-space: normal; text-overflow: ellipsis; overflow: hidden; cursor: auto; margin-left: 0px !important;"><input class="enabled-button" type="checkbox" style="min-width: 0px; min-height: 0px; font-size: 10px; visibility: visible; float: left; margin-top: 0px; vertical-align: top; position: relative; z-index: 1; width: 18px; left: -40px; top: 1px;"><span class="styles-clipboard-only" style="min-width: 0px; min-height: 0px; display: inline-block; width: 0px; opacity: 0; pointer-events: none; white-space: pre;">    </span><span class="webkit-css-property" title="position:absolute;" style="min-width: 0px; min-height: 0px; color: rgb(200, 0, 0); margin-left: -38px;">position</span>:&nbsp;<span class="expand-element" style="min-width: 0px; min-height: 0px;"></span><span class="value" style="min-width: 0px; min-height: 0px;">absolute</span>;</li><li class="overloaded" style="min-width: 0px; min-height: 0px; padding-left: 38px; white-space: normal; text-overflow: ellipsis; overflow: hidden; cursor: auto; text-decoration: line-through; margin-left: 0px !important;"><input class="enabled-button" type="checkbox" style="min-width: 0px; min-height: 0px; font-size: 10px; visibility: visible; float: left; margin-top: 0px; vertical-align: top; position: relative; z-index: 1; width: 18px; left: -40px; top: 1px;"><span class="styles-clipboard-only" style="min-width: 0px; min-height: 0px; display: inline-block; width: 0px; opacity: 0; pointer-events: none; white-space: pre;">    </span><span class="webkit-css-property" title="top:0.6em;" style="min-width: 0px; min-height: 0px; color: rgb(200, 0, 0); margin-left: -38px;">top</span>:&nbsp;<span class="expand-element" style="min-width: 0px; min-height: 0px;"></span><span class="value" style="min-width: 0px; min-height: 0px;">0.6em</span>;</li><li style="min-width: 0px; min-height: 0px; padding-left: 38px; white-space: normal; text-overflow: ellipsis; overflow: hidden; cursor: auto; margin-left: 0px !important;"><input class="enabled-button" type="checkbox" style="min-width: 0px; min-height: 0px; font-size: 10px; visibility: visible; float: left; margin-top: 0px; vertical-align: top; position: relative; z-index: 1; width: 18px; left: -40px; top: 1px;"><span class="styles-clipboard-only" style="min-width: 0px; min-height: 0px; display: inline-block; width: 0px; opacity: 0; pointer-events: none; white-space: pre;">    </span><span class="webkit-css-property" title="left:10em;" style="min-width: 0px; min-height: 0px; color: rgb(200, 0, 0); margin-left: -38px;">left</span>:&nbsp;<span class="expand-element" style="min-width: 0px; min-height: 0px;"></span><span class="value" style="min-width: 0px; min-height: 0px;">10em</span>;</li><li class="styles-panel-hovered" style="min-width: 0px; min-height: 0px; padding-left: 38px; white-space: normal; text-overflow: ellipsis; overflow: hidden; cursor: auto; margin-left: 0px !important;"><input class="enabled-button" type="checkbox" style="min-width: 0px; min-height: 0px; font-size: 10px; visibility: visible; float: left; margin-top: 0px; vertical-align: top; position: relative; z-index: 1; width: 18px; left: -40px; top: 1px;"><span class="styles-clipboard-only" style="min-width: 0px; min-height: 0px; display: inline-block; width: 0px; opacity: 0; pointer-events: none; white-space: pre;">    </span><span class="webkit-css-property" title="right:16.5em;" style="min-width: 0px; min-height: 0px; color: rgb(200, 0, 0); margin-left: -38px;">right</span>:&nbsp;<span class="expand-element" style="min-width: 0px; min-height: 0px;"></span><span class="value" style="min-width: 0px; min-height: 0px;">16.5em</span>;</li><li style="min-width: 0px; min-height: 0px; padding-left: 38px; white-space: normal; text-overflow: ellipsis; overflow: hidden; cursor: auto; margin-left: 0px !important;"><input class="enabled-button" type="checkbox" style="min-width: 0px; min-height: 0px; font-size: 10px; visibility: visible; float: left; margin-top: 0px; vertical-align: top; position: relative; z-index: 1; width: 18px; left: -40px; top: 1px;"><span class="styles-clipboard-only" style="min-width: 0px; min-height: 0px; display: inline-block; width: 0px; opacity: 0; pointer-events: none; white-space: pre;">    </span><span class="webkit-css-property" title="height:1.3em;" style="min-width: 0px; min-height: 0px; color: rgb(200, 0, 0); margin-left: -38px;">height</span>:&nbsp;<span class="expand-element" style="min-width: 0px; min-height: 0px;"></span><span class="value" style="min-width: 0px; min-height: 0px;">1.3em</span>;</li><li style="min-width: 0px; min-height: 0px; padding-left: 38px; white-space: normal; text-overflow: ellipsis; overflow: hidden; cursor: auto; margin-left: 0px !important;"><input class="enabled-button" type="checkbox" style="min-width: 0px; min-height: 0px; font-size: 10px; visibility: visible; float: left; margin-top: 0px; vertical-align: top; position: relative; z-index: 1; width: 18px; left: -40px; top: 1px;"><span class="styles-clipboard-only" style="min-width: 0px; min-height: 0px; display: inline-block; width: 0px; opacity: 0; pointer-events: none; white-space: pre;">    </span><span class="webkit-css-property" title="color:#fff;" style="min-width: 0px; min-height: 0px; color: rgb(200, 0, 0); margin-left: -38px;">color</span>:&nbsp;<span class="expand-element" style="min-width: 0px; min-height: 0px;"></span><span class="value" style="min-width: 0px; min-height: 0px;"><span is="color-swatch" style="white-space: nowrap; min-width: 0px; min-height: 0px;">#fff</span></span>;</li><li style="min-width: 0px; min-height: 0px; padding-left: 38px; white-space: normal; text-overflow: ellipsis; overflow: hidden; cursor: auto; margin-left: 0px !important;"><input class="enabled-button" type="checkbox" style="min-width: 0px; min-height: 0px; font-size: 10px; visibility: visible; float: left; margin-top: 0px; vertical-align: top; position: relative; z-index: 1; width: 18px; left: -40px; top: 1px;"><span class="styles-clipboard-only" style="min-width: 0px; min-height: 0px; display: inline-block; width: 0px; opacity: 0; pointer-events: none; white-space: pre;">    </span><span class="webkit-css-property" title="font-size:1.125em;" style="min-width: 0px; min-height: 0px; color: rgb(200, 0, 0); margin-left: -38px;">font-size</span>:&nbsp;<span class="expand-element" style="min-width: 0px; min-height: 0px;"></span><span class="value" style="min-width: 0px; min-height: 0px;">1.125em</span>;</li><li class="parent" style="min-width: 0px; min-height: 0px; padding-left: 38px; white-space: normal; text-overflow: ellipsis; overflow: hidden; cursor: auto; margin-left: 0px !important;"><input class="enabled-button" type="checkbox" style="min-width: 0px; min-height: 0px; font-size: 10px; visibility: visible; float: left; margin-top: 0px; vertical-align: top; position: relative; z-index: 1; width: 18px; left: -40px; top: 1px;"><span class="styles-clipboard-only" style="min-width: 0px; min-height: 0px; display: inline-block; width: 0px; opacity: 0; pointer-events: none; white-space: pre;">    </span><span class="webkit-css-property" title="overflow:hidden;" style="min-width: 0px; min-height: 0px; color: rgb(200, 0, 0); margin-left: -38px;">overflow</span>:&nbsp;<span class="expand-element" style="min-width: 0px; min-height: 0px; -webkit-user-select: none; margin-right: 2px; margin-left: -6px; opacity: 0.55; width: 8px; height: 10px; display: inline-block; background-image: url(chrome-devtools://devtools/bundled/Images/toolbarButtonGlyphs.png); background-size: 320px 144px; background-position: -4px -96px;"></span><span class="value" style="min-width: 0px; min-height: 0px;">hidden</span>;</li><li style="min-width: 0px; min-height: 0px; padding-left: 38px; white-space: normal; text-overflow: ellipsis; overflow: hidden; cursor: auto; margin-left: 0px !important;"><input class="enabled-button" type="checkbox" style="min-width: 0px; min-height: 0px; font-size: 10px; visibility: visible; float: left; margin-top: 0px; vertical-align: top; position: relative; z-index: 1; width: 18px; left: -40px; top: 1px;"><span class="styles-clipboard-only" style="min-width: 0px; min-height: 0px; display: inline-block; width: 0px; opacity: 0; pointer-events: none; white-space: pre;">    </span><span class="webkit-css-property" title="white-space:nowrap;" style="min-width: 0px; min-height: 0px; color: rgb(200, 0, 0); margin-left: -38px;">white-space</span>:&nbsp;<span class="expand-element" style="min-width: 0px; min-height: 0px;"></span><span class="value" style="min-width: 0px; min-height: 0px;">nowrap</span>;</li><li style="min-width: 0px; min-height: 0px; padding-left: 38px; white-space: normal; text-overflow: ellipsis; overflow: hidden; cursor: auto; margin-left: 0px !important;"><input class="enabled-button" type="checkbox" style="min-width: 0px; min-height: 0px; font-size: 10px; visibility: visible; float: left; margin-top: 0px; vertical-align: top; position: relative; z-index: 1; width: 18px; left: -40px; top: 1px;"><span class="styles-clipboard-only" style="min-width: 0px; min-height: 0px; display: inline-block; width: 0px; opacity: 0; pointer-events: none; white-space: pre;">    </span><span class="webkit-css-property" title="text-overflow:ellipsis;" style="min-width: 0px; min-height: 0px; color: rgb(200, 0, 0); margin-left: -38px;">text-overflow</span>:&nbsp;<span class="expand-element" style="min-width: 0px; min-height: 0px;"></span><span class="value" style="min-width: 0px; min-height: 0px;">ellipsis</span>;</li><li class="has-ignorable-error overloaded not-parsed-ok inactive" style="min-width: 0px; min-height: 0px; padding-left: 38px; white-space: normal; text-overflow: ellipsis; overflow: hidden; cursor: auto; text-decoration: line-through; color: gray; margin-left: 0px !important;"><label is="dt-icon-label" class="exclamation-mark" title="Unknown property name." style="min-width: 0px; min-height: 0px; position: relative; width: 11px; height: 10px; margin: 0px 7px 0px 0px; top: 1px; left: -36px; -webkit-user-select: none; z-index: 1;"></label><span class="styles-clipboard-only" style="min-width: 0px; min-height: 0px; display: inline-block; width: 0px; opacity: 0; pointer-events: none; white-space: pre;">    </span><span class="webkit-css-property" title="-o-text-overflow:ellipsis" style="min-width: 0px; min-height: 0px; color: inherit; margin-left: -38px;">-o-text-overflow</span>:&nbsp;<span class="expand-element" style="min-width: 0px; min-height: 0px;"></span><span class="value" style="min-width: 0px; min-height: 0px;">ellipsis</span>;</li></ol><div style="min-width: 0px; min-height: 0px; color: rgb(34, 34, 34); font-family: Consolas, ''Lucida Console'', monospace; font-size: 12px; line-height: normal; white-space: nowrap;">}</div>', 'no', 0, 'in', 'css item', 'no'),
(71, 8, 8, '2015-08-05 22:05:27', '<p><br></p><table class="table table-bordered"><tbody><tr><td>test</td><td>nr 1</td><td>2500</td></tr><tr><td>test2</td><td>nr 2</td><td>1500</td></tr><tr><td>test 3</td><td>nr3&nbsp;</td><td>500</td></tr></tbody></table><p><br></p>', 'no', 0, 'in', '', 'no'),
(72, 10, 8, '2015-09-07 02:27:20', 'Hoi Decoder dit is een testbericht van mij :)', 'no', 0, 'in', 'testbericht', 'no'),
(73, 8, 9, '2015-09-07 02:50:18', '<p>Hoi Richard.....dit is een testbericht....ik ga weer eens wat doen op de site...word gek van het niks doen terwijl er nog zoveel gedaan moet worden.</p><p><span style="color: rgb(231, 99, 99);"><span style="font-weight: bold;">Wist je dat er al een versie op github stond maar dat ik die er weer af heb gehaald?</span> </span>whahahah tja er moet nog teveel gedaan worden voordat ik hem serieus op github kan plaatsen hoor...ken er niks aan doen :S</p><p>Groet van mij !</p>', 'no', 0, 'in', 'Welkom Richard !!', 'no'),
(74, 0, 10, '2015-09-07 16:56:55', 'Uw waarschuwing is verwijderd door Decoder.', 'no', 0, 'in', 'Uw waarschuwing is verwijderd.', 'no'),
(75, 0, 10, '2015-09-07 16:58:46', 'Uw waarschuwing is verwijderd door Decoder.', 'no', 0, 'in', 'Uw waarschuwing is verwijderd.', 'no'),
(76, 0, 10, '2015-09-07 17:00:41', 'Uw waarschuwing is verwijderd door Decoder.', 'no', 0, 'in', 'Uw waarschuwing is verwijderd.', 'no'),
(77, 0, 10, '2015-09-07 17:01:54', 'Uw waarschuwing is verwijderd door Decoder.', 'no', 0, 'in', 'Uw waarschuwing is verwijderd.', 'no'),
(78, 8, 10, '2015-09-07 17:07:00', 'Hallo <a href=http://torrent-empire.org/members/details/10>Sunshine </a>,\n\nU heeft een waarschuwing gehad voor ''Pakken en wegwezen'' (Hit & Run).\nHetgeen inhoud dat u een torrent heeft gedownload en niet de moeite heeft genomen om te blijven delen voor andere gebruikers.\nBij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\nTevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\nMet vriendelijke groet,\nStaff van Veranderen\n ', 'no', 0, 'in', 'U heeft een waarschuwing gekregen!', 'no'),
(79, 0, 10, '2015-09-07 17:08:35', 'Uw waarschuwing is verwijderd door Decoder.', 'no', 0, 'in', 'Uw waarschuwing is verwijderd.', 'no'),
(80, 8, 10, '2015-09-07 17:09:48', 'Hallo <a href=http://torrent-empire.org/members/details/10>Sunshine </a>,\n\nU heeft een waarschuwing gehad voor ''Lage Ratio'' (Hit & Run).\nHetgeen inhoud dat u een meer Gb ontvangt als wenst te delen aan andere gebruikers.\nRatio is de deling van hetgeen u heeft verzonden door hetgeen u heeft ontvangen.\nU kunt dit verbeteren doormiddel van te blijven delen (seeden) na het downloaden totdat uw ratio weer goed is.\nEen lage ratio betekend ook dat u minder torrents tergelijkertijd mag gebruiken.\nBij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\nTevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\nMet vriendelijke groet,\nStaff van Veranderen\n ', 'no', 0, 'in', 'U heeft een waarschuwing gekregen!', 'no'),
(81, 0, 10, '2015-09-07 17:09:54', 'Uw waarschuwing is verwijderd door Decoder.', 'no', 0, 'in', 'Uw waarschuwing is verwijderd.', 'no'),
(82, 8, 8, '2015-09-08 03:45:36', 'Hallo,\r\n\r\ndit is een testbericht.......\r\n\r\nMet vriendelijke groet,\r\n\r\nDecoder\r\n\r\nDit bericht wordt aan iedereen verzonden die de torrent ''Big Hero 6 (2014) [1080p]''\r\naan het ontvangen is of ontvangen heeft.', 'no', 0, 'in', 'Torrent bericht: Big Hero 6 (2014) [1080p] ', 'no'),
(83, 8, 9, '2015-09-08 03:45:36', 'Hallo,\r\n\r\ndit is een testbericht.......\r\n\r\nMet vriendelijke groet,\r\n\r\nDecoder\r\n\r\nDit bericht wordt aan iedereen verzonden die de torrent ''Big Hero 6 (2014) [1080p]''\r\naan het ontvangen is of ontvangen heeft.', 'no', 0, 'in', 'Torrent bericht: Big Hero 6 (2014) [1080p] ', 'no'),
(84, 8, 8, '2015-09-08 03:50:02', 'Hallo,\r\n\r\nNog een test....\r\n\r\nMet vriendelijke groet,\r\n\r\nDecoder\r\n\r\nDit bericht wordt aan iedereen verzonden die de torrent ''Big Hero 6 (2014) [1080p]''\r\naan het ontvangen is of ontvangen heeft.', 'no', 0, 'in', 'Torrent bericht: Big Hero 6 (2014) [1080p] ', 'no'),
(85, 8, 9, '2015-09-08 03:50:02', 'Hallo,\r\n\r\nNog een test....\r\n\r\nMet vriendelijke groet,\r\n\r\nDecoder\r\n\r\nDit bericht wordt aan iedereen verzonden die de torrent ''Big Hero 6 (2014) [1080p]''\r\naan het ontvangen is of ontvangen heeft.', 'no', 0, 'in', 'Torrent bericht: Big Hero 6 (2014) [1080p] ', 'no'),
(86, 10, 11, '2015-09-14 11:34:59', '<p>Hello <a href=http://torrent-empire.org/members/details/11>Sandor </a></p><p>Youre avatar has been removed becouse it does not fit our site policy.<br>If you belive a mistake has been made, you could get in contact with your Moderator.</p><p>Kind regards,</p><a href=http://torrent-empire.org/members/details/10>Sunshine </a>', 'yes', 0, 'in', 'your avatar has been removed.', 'no'),
(87, 8, 10, '2015-09-21 15:50:53', 'Hallo <a href=http://torrent-empire.org/members/details/10>Sunshine </a>,\n\nU heeft een waarschuwing gehad voor ''Pakken en wegwezen'' (Hit & Run).\nHetgeen inhoud dat u een torrent heeft gedownload en niet de moeite heeft genomen om te blijven delen voor andere gebruikers.\nBij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\nTevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\nMet vriendelijke groet,\nStaff van Veranderen\n ', 'no', 0, 'in', 'U heeft een waarschuwing gekregen!', 'no'),
(88, 0, 10, '2015-09-21 15:51:17', 'Uw waarschuwing is verwijderd door Decoder.', 'yes', 0, 'in', 'Uw waarschuwing is verwijderd.', 'no'),
(89, 8, 9, '2015-09-29 13:04:43', 'Hallo <a href=http://torrent-empire.org/members/details/9>RCR1984 </a>,\n\nU heeft een waarschuwing gehad voor ''Pakken en wegwezen'' (Hit & Run).\nHetgeen inhoud dat u een torrent heeft gedownload en niet de moeite heeft genomen om te blijven delen voor andere gebruikers.\nBij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\nTevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\nMet vriendelijke groet,\nStaff van Veranderen\n ', 'no', 0, 'in', 'U heeft een waarschuwing gekregen!', 'no'),
(90, 9, 8, '2015-10-13 17:29:00', 'De site ziet er echt wel vet uit!', 'no', 0, 'in', 'Hey', 'no'),
(91, 0, 8, '2015-10-15 22:30:30', 'Hallo,\n\nDe torrent Insurgent (2015) [1080p] is verwijderd van , omdat deze niet goed bleek te zijn.\n\nSorry dat dit is gebeurd, we hopen dat uw volgende download wel goed zal gaan.\n\nOm uw ratio te compenseren is er 1.8 GB bij uw totale upload toegevoegd.\n\nMet vriendelijk groet,\n\nonzesite', 'no', 0, 'in', 'De torrent Insurgent (2015) [1080p] is verwijderd.', 'no'),
(92, 0, 9, '2015-10-23 10:20:37', 'Uw waarschuwing is verwijderd door Decoder.', 'no', 0, 'in', 'Uw waarschuwing is verwijderd.', 'no'),
(93, 14, 14, '2015-12-17 23:07:08', 'kiiiiiiiiiiiiiiiii', 'no', 0, 'in', 'kiii', 'no');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `peers`
--

CREATE TABLE IF NOT EXISTS `peers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `torrent` int(10) unsigned NOT NULL DEFAULT '0',
  `peer_id` varchar(40) NOT NULL,
  `info_hash` varchar(40) NOT NULL,
  `compact` binary(6) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL,
  `port` smallint(5) unsigned NOT NULL DEFAULT '0',
  `updated` int(10) NOT NULL,
  `uploaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `downloaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `to_go` bigint(20) unsigned NOT NULL DEFAULT '0',
  `seeder` enum('yes','no') NOT NULL DEFAULT 'no',
  `started` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_action` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `connectable` enum('yes','no') NOT NULL DEFAULT 'yes',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(40) NOT NULL DEFAULT '',
  `agent` varchar(60) NOT NULL DEFAULT '',
  `finishedat` int(10) unsigned NOT NULL DEFAULT '0',
  `downloadoffset` bigint(20) unsigned NOT NULL DEFAULT '0',
  `uploadoffset` bigint(20) unsigned NOT NULL DEFAULT '0',
  `passkey` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `torrent_peer_id` (`torrent`,`peer_id`),
  KEY `torrent` (`torrent`),
  KEY `torrent_seeder` (`torrent`,`seeder`),
  KEY `last_action` (`last_action`),
  KEY `connectable` (`connectable`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topicid` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(40) NOT NULL,
  `added` int(11) DEFAULT NULL,
  `body` text,
  `editedby` int(10) unsigned NOT NULL DEFAULT '0',
  `editedat` int(11) NOT NULL,
  `editedbyusername` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `topicid` (`topicid`),
  KEY `userid` (`userid`),
  FULLTEXT KEY `body` (`body`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Gegevens worden uitgevoerd voor tabel `posts`
--

INSERT INTO `posts` (`id`, `topicid`, `userid`, `username`, `added`, `body`, `editedby`, `editedat`, `editedbyusername`) VALUES
(9, 11, 10, 'Sunshine', 1436997193, 'Dit is een testforum voor normale gebruiikers en dus alleen zichtbaar voor normale gebruikers....doet alles het?', 0, 0, ''),
(10, 12, 10, 'Sunshine', 1436999146, 'Dit is er nog een nu voor de datum te teste', 0, 0, ''),
(11, 11, 10, 'Sunshine', 1437005228, 'en dit is een reactie op deze topic :) kieke of ut werk wa hahaha', 0, 0, ''),
(12, 11, 8, 'Decoder', 1437079051, 'Okde dan reageer ik ook ff op dit form.....puur voor testdoeleinden toch ?<br />\r\nWe moeten hier nog een editor inzetten voor mooiere texten enzo...<br /><br />\r\n\r\nDecoder...fix jij dat ffies ??', 8, 1437144356, 'Decoder'),
(16, 11, 10, 'Sunshine', 1437166516, 'Okde dan reageer ik ook ff op dit form.....puur voor testdoeleinden toch ?<br>We moeten hier nog een editor inzetten voor mooiere texten enzo...<br>Decoder...fix jij dat ffies ??\r\n\r\n<p>test hij quote nog steeds he "?</p>\r\n', 10, 1437167154, 'Sunshine'),
(14, 13, 8, 'Decoder', 1437134494, 'Hier komen alle regels te staan voor onze Moderators! <br /><br />Nog maar eens aangepast......', 8, 1437144321, 'Decoder'),
(15, 14, 8, 'Decoder', 1437151646, '<p><span style="font-weight: bold; font-size: 18px; font-family: Tahoma;">Oke dit is een bericht gemaakt met de summernote editor</span></p><p>Is dit beter ja of nee ?</p><ul><li><span style="color: rgb(255, 0, 255);">test 1</span></li><li><span style="color: rgb(255, 0, 255);">niet vloeken</span></li><li><span style="color: rgb(255, 0, 255);">user dwinger te doneren</span></li><li><span style="color: rgb(255, 0, 255);">je naakte lichaam laten zien</span></li></ul>', 8, 1437152143, 'Decoder'),
(17, 15, 9, 'RCR1984', 1437300300, '<p>Het antwoord op die vraag is JA</p><p><br></p><p>Het forum werkt perfect en ziet er ook nog eens tip top uit!</p>', 0, 0, ''),
(18, 16, 8, 'Decoder', 1438805470, '<p>Wat moet er nog allemaal gebeuren.....ik ga het hier proberen bij te houden.</p><ul><li><span style="font-weight: bold;">Forum verder afmaken</span></li><li><span style="font-weight: bold;">gebruiker functies bouwen</span></li><li><span style="font-weight: bold;">foutafhandeling toevoegen</span></li><li><span style="font-weight: bold;">bugs zoeken en verhelpen</span></li><li><span style="font-weight: bold;">Moderator functies afmaken</span></li><li><span style="font-weight: bold;">er zal nog genoeg zijn wat gedaan moet worden maar kom er zo snel niet op</span></li><li><span style="font-weight: bold;">misschien een paar widgets maken die bijvoorbeeld laten zien dat er nieuwe forum berichten zijn?</span></li><li><span style="font-weight: bold; color: rgb(255, 0, 255);">grafieken maken die laten zien hoeveel verkeer er is op een torrent? top 5 maken middels grafieken ?</span></li></ul><p>Richard mocht jij nog ideeen of suggesties hebben wil je die dan aub hier neerzetten ?</p><p>Thanks Decoder</p>', 0, 0, ''),
(19, 11, 10, 'Sunshine', 1440083541, 'ziet er allemaal goed uit', 0, 0, '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `readposts`
--

CREATE TABLE IF NOT EXISTS `readposts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `topicid` int(10) unsigned NOT NULL DEFAULT '0',
  `lastpostread` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `topicid` (`topicid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Gegevens worden uitgevoerd voor tabel `readposts`
--

INSERT INTO `readposts` (`id`, `userid`, `topicid`, `lastpostread`) VALUES
(1, 8, 1, 13),
(2, 10, 10, 8),
(3, 10, 11, 19),
(4, 10, 12, 10),
(5, 8, 11, 19),
(6, 8, 12, 10),
(7, 8, 13, 14),
(8, 10, 13, 14),
(9, 8, 14, 15),
(10, 9, 13, 14),
(11, 9, 14, 15),
(12, 9, 11, 16),
(13, 9, 15, 17),
(14, 10, 15, 17),
(15, 8, 15, 17),
(16, 11, 13, 14),
(17, 11, 11, 16),
(18, 8, 16, 18),
(19, 11, 15, 17),
(20, 14, 16, 18),
(21, 14, 11, 19),
(22, 14, 15, 17),
(23, 14, 13, 14),
(24, 14, 12, 10);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `slug` varchar(30) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `type` enum('text','textarea','password','select','select-multiple','radio','checkbox') NOT NULL,
  `default` text NOT NULL,
  `value` text NOT NULL,
  `options` text NOT NULL,
  `is_required` int(1) NOT NULL,
  `is_gui` int(1) NOT NULL,
  `module` varchar(50) NOT NULL,
  `order` int(10) NOT NULL DEFAULT '0',
  UNIQUE KEY `index_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `shoutbox`
--

CREATE TABLE IF NOT EXISTS `shoutbox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(55) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;

--
-- Gegevens worden uitgevoerd voor tabel `shoutbox`
--

INSERT INTO `shoutbox` (`id`, `user_id`, `username`, `content`, `created_at`) VALUES
(70, 8, 'Decoder', 'nee die moet je dan echt ff zoeken maar hij is er toch alweer af omdat er iets nog niet klopte....en de server gegevens waren zichtbaar', '2015-10-18 17:58:35'),
(72, 9, 'RCR1984', 'kijk das beter. heb idd je evonden maar was idd weg ;)', '2015-10-19 22:18:30'),
(73, 9, 'RCR1984', 'grrr mis smilys haha', '2015-10-19 22:18:38'),
(74, 8, 'Decoder', 'jow die komen er ook nog in :)', '2015-10-23 10:17:00'),
(75, 14, 'Demo', 'hallo', '2015-12-15 21:16:17'),
(76, 14, 'Demo', ':)', '2015-12-15 21:17:54'),
(77, 14, 'Demo', 'schon ziehmlich billig', '2015-12-16 17:35:46'),
(78, 14, 'Demo', 'ja du sagst es..', '2015-12-16 17:38:58'),
(79, 14, 'Demo', ':))', '2015-12-17 21:20:43'),
(80, 14, 'Demo', '', '2015-12-17 23:00:47'),
(81, 14, 'Demo', ':D', '2015-12-17 23:00:56'),
(82, 14, 'Demo', ':P', '2015-12-19 10:51:42'),
(83, 14, 'Demo', '', '2015-12-20 18:09:52'),
(84, 14, 'Demo', 'dfšk', '2015-12-22 11:29:53'),
(85, 14, 'Demo', 'oh', '2016-02-03 20:56:23'),
(86, 14, 'Demo', 'hi', '2016-12-30 16:53:35'),
(87, 14, 'Demo', 'test', '2017-05-19 14:51:59');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `site_message`
--

CREATE TABLE IF NOT EXISTS `site_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `added` int(11) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Gegevens worden uitgevoerd voor tabel `site_message`
--

INSERT INTO `site_message` (`id`, `text`, `added`, `active`) VALUES
(1, '<div style="box-shadow: inset 2px 1px 10px 1px #000; background: #c3c3c3; border: 1px solid bbb; padding: 20px ; margin-bottom: 30px; font-size: 20px;">\r\n<center>\r\nKerel download eens wat dan kan ik verder testen!! <br />zou je ook de zoekfunctie kunnen testen boven in ? als het goed is werkt die nu :)\r\n</center>\r\n</div>', 1441626411, 'no');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `name` varchar(5) NOT NULL,
  `value` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `tasks`
--

INSERT INTO `tasks` (`name`, `value`) VALUES
('prune', 1435967286);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `added` int(11) NOT NULL,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(40) NOT NULL,
  `subject` varchar(225) DEFAULT NULL,
  `locked` enum('yes','no') NOT NULL DEFAULT 'no',
  `forumid` int(10) unsigned NOT NULL DEFAULT '0',
  `lastpost` int(10) unsigned DEFAULT NULL,
  `lastpostuserid` int(10) NOT NULL,
  `lastpostusername` varchar(40) NOT NULL,
  `lastpostadded` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sticky` enum('yes','no') NOT NULL DEFAULT 'no',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `numposts` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `lastpost` (`lastpost`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Gegevens worden uitgevoerd voor tabel `topics`
--

INSERT INTO `topics` (`id`, `added`, `userid`, `username`, `subject`, `locked`, `forumid`, `lastpost`, `lastpostuserid`, `lastpostusername`, `lastpostadded`, `sticky`, `views`, `numposts`) VALUES
(11, 0, 10, 'Sunshine', 'Test Forum', 'no', 2, 19, 0, '', '0000-00-00 00:00:00', 'yes', 181, 1),
(12, 1436999146, 10, 'Sunshine', 'Nog eeeeen', 'no', 2, 10, 0, '', '0000-00-00 00:00:00', 'no', 30, 1),
(13, 1437134494, 8, 'Decoder', 'Regels voor Moderators', 'yes', 3, 14, 0, '', '0000-00-00 00:00:00', 'yes', 89, 1),
(14, 1437151646, 8, 'Decoder', 'Dit is een testbericht', 'no', 3, 15, 0, '', '0000-00-00 00:00:00', 'no', 15, 1),
(15, 1437300300, 9, 'RCR1984', 'Alles werkt?', 'no', 4, 17, 0, '', '0000-00-00 00:00:00', 'no', 16, 1),
(16, 1438805470, 8, 'Decoder', 'Roadtrip', 'no', 2, 18, 0, '', '0000-00-00 00:00:00', 'no', 10, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `torrents`
--

CREATE TABLE IF NOT EXISTS `torrents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `info_hash` varchar(40) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `filename` varchar(255) NOT NULL DEFAULT '',
  `save_as` varchar(255) NOT NULL DEFAULT '',
  `search_text` text NOT NULL,
  `descr` text NOT NULL,
  `ori_descr` text NOT NULL,
  `category` int(10) unsigned NOT NULL DEFAULT '0',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` enum('single','multi') NOT NULL DEFAULT 'single',
  `numfiles` int(10) unsigned NOT NULL DEFAULT '0',
  `comments` int(10) unsigned NOT NULL DEFAULT '0',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `times_completed` int(10) unsigned NOT NULL DEFAULT '0',
  `leechers` int(10) unsigned NOT NULL DEFAULT '0',
  `seeders` int(10) unsigned NOT NULL DEFAULT '0',
  `last_action` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `visible` enum('yes','no') NOT NULL DEFAULT 'yes',
  `banned` enum('yes','no') NOT NULL DEFAULT 'no',
  `owner` int(10) unsigned NOT NULL DEFAULT '0',
  `numratings` int(10) unsigned NOT NULL DEFAULT '0',
  `ratingsum` int(10) unsigned NOT NULL DEFAULT '0',
  `nfo` text NOT NULL,
  `cover` varchar(255) NOT NULL,
  `cover_thumb` varchar(255) NOT NULL,
  `cover_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Gegevens worden uitgevoerd voor tabel `torrents`
--

INSERT INTO `torrents` (`id`, `info_hash`, `name`, `filename`, `save_as`, `search_text`, `descr`, `ori_descr`, `category`, `size`, `added`, `type`, `numfiles`, `comments`, `views`, `hits`, `times_completed`, `leechers`, `seeders`, `last_action`, `visible`, `banned`, `owner`, `numratings`, `ratingsum`, `nfo`, `cover`, `cover_thumb`, `cover_by`) VALUES
(4, '31bbba0fbeeeed0b5e5dc304ad72855c6d65a789', 'Kingsman the secret service (2015) ', 'Kingsman The Secret Service (2014) [1080p].torrent', 'Kingsman The Secret Service (2014) [1080p]', 'My title', '<p style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; line-height: normal;"><span style="font-weight: bold;">Verenigd Koninkrijk<br><span itemprop="genre">Actie</span>&nbsp;/&nbsp;<span itemprop="genre">Komedie</span><br>129 minuten</span><br></p><p style="margin-top: 10px; margin-right: 10px; overflow: hidden;"><span style="color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; line-height: normal;">geregisseerd door&nbsp;</span><span style="color: rgb(0, 0, 0); font-family: OpenSansSemiBold, Arial; line-height: normal; font-weight: bold;">Matthew Vaughn</span><br><span style="color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; line-height: normal;">met&nbsp;</span><span itemprop="actor" style="color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; line-height: normal;">Colin Firth</span><span style="color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; line-height: normal;">,&nbsp;</span><span itemprop="actor" style="color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; line-height: normal;">Taron Egerton</span><span style="color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; line-height: normal;">&nbsp;en&nbsp;</span><span itemprop="actor" style="color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; line-height: normal;">Samuel L. Jackson</span></p><p itemprop="description" style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; line-height: normal;">Gary, een jongeman wiens leven dreigt te ontsporen, vult zijn dagen door in de kroeg te hangen met vrienden. Harry Hart, een doorgewinterde agent van een geheime organisatie, neemt hem onder zijn vleugels om een oude schuld te vereffenen. Hij draagt Gary voor om deel te nemen aan een trainingsprogramma voor geheim agent, precies op het moment dat de wereld wordt bedreigd door een IT-genie met kwaadaardige bedoelingen.</p>', '<p style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; line-height: normal;"><span style="font-weight: bold;">Verenigd Koninkrijk<br><span itemprop="genre">Actie</span>&nbsp;/&nbsp;<span itemprop="genre">Komedie</span><br>129 minuten</span><br></p><p style="margin-top: 10px; margin-right: 10px; overflow: hidden;"><span style="color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; line-height: normal;">geregisseerd door&nbsp;</span><span style="color: rgb(0, 0, 0); font-family: OpenSansSemiBold, Arial; line-height: normal; font-weight: bold;">Matthew Vaughn</span><br><span style="color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; line-height: normal;">met&nbsp;</span><span itemprop="actor" style="color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; line-height: normal;">Colin Firth</span><span style="color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; line-height: normal;">,&nbsp;</span><span itemprop="actor" style="color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; line-height: normal;">Taron Egerton</span><span style="color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; line-height: normal;">&nbsp;en&nbsp;</span><span itemprop="actor" style="color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; line-height: normal;">Samuel L. Jackson</span></p><p itemprop="description" style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; line-height: normal;">Gary, een jongeman wiens leven dreigt te ontsporen, vult zijn dagen door in de kroeg te hangen met vrienden. Harry Hart, een doorgewinterde agent van een geheime organisatie, neemt hem onder zijn vleugels om een oude schuld te vereffenen. Hij draagt Gary voor om deel te nemen aan een trainingsprogramma voor geheim agent, precies op het moment dat de wereld wordt bedreigd door een IT-genie met kwaadaardige bedoelingen.</p>', 1, 2096515100, '2015-07-30 00:26:31', 'multi', 2, 0, 0, 0, 0, 0, 0, '2015-11-18 19:20:33', 'yes', 'no', 8, 0, 0, '', '4.jpg', '4_thumb.jpg', 0),
(5, '8567f05d45dcafa02907465e8534f5d994c605f0', 'Mad Max: Fury Road (2015)', 'Mad Max Fury Road (2015) [1080p].torrent', 'Mad Max Fury Road (2015) [1080p]', 'My title', '<p style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;"><span style="font-weight: bold;">Australië / Verenigde Staten<br><span itemprop="genre">Actie</span>&nbsp;/&nbsp;<span itemprop="genre">Avontuur</span><br>120 minuten</span><br></p><p style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;">geregisseerd door&nbsp;<span style="font-family: OpenSansSemiBold, Arial; font-weight: bold;">George Miller (II)</span><br>met&nbsp;<span style="font-weight: bold;"><span itemprop="actor">Tom Hardy</span>,&nbsp;<span itemprop="actor">Nicholas Hoult</span>&nbsp;en&nbsp;<span itemprop="actor">Charlize Theron</span></span></p><p itemprop="description" style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;">De film speelt zich af in een grimmig woestijnlandschap waar de mensheid is gebroken en waar bijna iedereen gek is en vecht voor de noodzakelijkheden van het leven. In deze wereld van vuur en bloed zijn twee rebellen op de vlucht die misschien wel de orde zouden kunnen herstellen. Max (Tom Hardy), een man van actie en weinig woorden, tracht gemoedsrust te vinden na het verlies van zijn vrouw en kind in de nasleep van de chaos. Furiosa (Charlize Theron), een vrouw van actie die haar pad naar overleving kan bereiken als ze door de woestijn geraakt terug naar het vaderland uit haar kindertijd.</p>', '<p style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;"><span style="font-weight: bold;">Australië / Verenigde Staten<br><span itemprop="genre">Actie</span>&nbsp;/&nbsp;<span itemprop="genre">Avontuur</span><br>120 minuten</span><br></p><p style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;">geregisseerd door&nbsp;<span style="font-family: OpenSansSemiBold, Arial; font-weight: bold;">George Miller (II)</span><br>met&nbsp;<span style="font-weight: bold;"><span itemprop="actor">Tom Hardy</span>,&nbsp;<span itemprop="actor">Nicholas Hoult</span>&nbsp;en&nbsp;<span itemprop="actor">Charlize Theron</span></span></p><p itemprop="description" style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;">De film speelt zich af in een grimmig woestijnlandschap waar de mensheid is gebroken en waar bijna iedereen gek is en vecht voor de noodzakelijkheden van het leven. In deze wereld van vuur en bloed zijn twee rebellen op de vlucht die misschien wel de orde zouden kunnen herstellen. Max (Tom Hardy), een man van actie en weinig woorden, tracht gemoedsrust te vinden na het verlies van zijn vrouw en kind in de nasleep van de chaos. Furiosa (Charlize Theron), een vrouw van actie die haar pad naar overleving kan bereiken als ze door de woestijn geraakt terug naar het vaderland uit haar kindertijd.</p>', 1, 1981030666, '2015-09-01 13:37:26', 'multi', 2, 3, 0, 0, 2, 0, 0, '2015-10-25 19:39:09', 'yes', 'no', 8, 0, 0, '', '5.jpg', '5_thumb.jpg', 0),
(9, 'cd28b931b71449b666a38e7ea6b0ed894bc925b1', 'Big Hero 6 (2014) [1080p]', 'Big.Hero.6.2014.1080p.WEB-DL.DD5.1.H264-Torrent-empire.torrent', 'Big.Hero.6.2014.1080p.WEB-DL.DD5.1.H264-RARBG', 'My title', '<h1 style="font-family: DinEngschrift, Arial; font-size: 44px; margin-top: 0px; margin-bottom: 0px; color: rgb(0, 0, 0); line-height: normal;"><span style="font-weight: bold;"><span itemprop="name" style="font-size: 24px;">Big Hero 6</span><span style="font-size: 24px;">&nbsp;</span><span style="font-size: 24px;">(2014)</span></span></h1><p style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;">Verenigde Staten<br><span itemprop="genre">Animatie</span>&nbsp;/&nbsp;<span itemprop="genre">Avontuur</span><br>102 minuten<br></p><p style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;">geregisseerd door&nbsp;<a class="tooltip" href="http://www.moviemeter.nl/director/27540" itemprop="director" style="color: rgb(0, 0, 0); font-family: OpenSansSemiBold, Arial;">Don Hall</a>&nbsp;en&nbsp;<span style="font-family: OpenSansSemiBold, Arial;">Chris Williams</span><br>met de stemmen van&nbsp;<span itemprop="actor">T.J. Miller</span>,&nbsp;<span itemprop="actor">Maya Rudolph</span>&nbsp;en&nbsp;<span itemprop="actor">Jamie Chung</span></p><p itemprop="description" style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;">Big Hero 6 draait om Hiro Hamada, een wonderkind en robotica-expert. Hij raakt betrokken bij een crimineel plan dat de hectische, hightech stad San Fransokyo dreigt te vernietigen. Met de hulp van zijn beste vriend – de robot Baymax – sluit Hiro zich aan bij een team van onervaren misdaadbestrijders om de stad te redden. Gebaseerd op de gelijknamige Marvel comics.</p>', '<h1 style="font-family: DinEngschrift, Arial; font-size: 44px; margin-top: 0px; margin-bottom: 0px; color: rgb(0, 0, 0); line-height: normal;"><span style="font-weight: bold;"><span itemprop="name" style="font-size: 24px;">Big Hero 6</span><span style="font-size: 24px;">&nbsp;</span><span style="font-size: 24px;">(2014)</span></span></h1><p style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;">Verenigde Staten<br><span itemprop="genre">Animatie</span>&nbsp;/&nbsp;<span itemprop="genre">Avontuur</span><br>102 minuten<br></p><p style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;">geregisseerd door&nbsp;<a class="tooltip" href="http://www.moviemeter.nl/director/27540" itemprop="director" style="color: rgb(0, 0, 0); font-family: OpenSansSemiBold, Arial;">Don Hall</a>&nbsp;en&nbsp;<span style="font-family: OpenSansSemiBold, Arial;">Chris Williams</span><br>met de stemmen van&nbsp;<span itemprop="actor">T.J. Miller</span>,&nbsp;<span itemprop="actor">Maya Rudolph</span>&nbsp;en&nbsp;<span itemprop="actor">Jamie Chung</span></p><p itemprop="description" style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;">Big Hero 6 draait om Hiro Hamada, een wonderkind en robotica-expert. Hij raakt betrokken bij een crimineel plan dat de hectische, hightech stad San Fransokyo dreigt te vernietigen. Met de hulp van zijn beste vriend – de robot Baymax – sluit Hiro zich aan bij een team van onervaren misdaadbestrijders om de stad te redden. Gebaseerd op de gelijknamige Marvel comics.</p>', 1, 2148594115, '2015-09-02 01:39:08', 'multi', 5, 1, 0, 0, 1, 4, 0, '2015-11-02 21:45:09', 'yes', 'no', 8, 0, 0, '', '9.jpg', '9_thumb.jpg', 0),
(11, '82b85444a11f189136aea5c96c907ca2ba156f2d', 'Pan 2015 720p BlueRay', 'Pan.2015.720p.BluRay.H264.AAC-RARBG.torrent', 'Pan.2015.720p.BluRay.H264.AAC-RARBG', 'My title', '<p style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;">Verenigde Staten<br><span itemprop="genre">Avontuur</span>&nbsp;/&nbsp;<span itemprop="genre">Komedie</span><br>111 minuten<br></p><p style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;">geregisseerd door&nbsp;<a class="tooltip" href="http://www.moviemeter.nl/director/6311" itemprop="director" style="color: rgb(0, 0, 0); font-family: OpenSansSemiBold, Arial;">Joe Wright</a><br>met&nbsp;<span itemprop="actor">Levi Miller</span>,&nbsp;<span itemprop="actor">Hugh Jackman</span>&nbsp;en&nbsp;<span itemprop="actor">Garrett Hedlund</span></p><p style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;"><img src="http://www.moviemeter.nl/images/cover/102000/102042.jpg" style="width: 800px;"><span itemprop="actor"><br></span></p><p itemprop="description" style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;">Een wees wordt naar de magische wereld van Neverland gebracht. Daar aangekomen wordt hij de redder van de inboorlingen en leidt hij een opstand tegen de gemene piraten van Neverland. Uiteindelijk ontdekt hij hier zijn lot, veranderen in de legendarische held Peter Pan.</p>', '<p style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;">Verenigde Staten<br><span itemprop="genre">Avontuur</span>&nbsp;/&nbsp;<span itemprop="genre">Komedie</span><br>111 minuten<br></p><p style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;">geregisseerd door&nbsp;<a class="tooltip" href="http://www.moviemeter.nl/director/6311" itemprop="director" style="color: rgb(0, 0, 0); font-family: OpenSansSemiBold, Arial;">Joe Wright</a><br>met&nbsp;<span itemprop="actor">Levi Miller</span>,&nbsp;<span itemprop="actor">Hugh Jackman</span>&nbsp;en&nbsp;<span itemprop="actor">Garrett Hedlund</span></p><p style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;"><img src="http://www.moviemeter.nl/images/cover/102000/102042.jpg" style="width: 800px;"><span itemprop="actor"><br></span></p><p itemprop="description" style="margin-top: 10px; margin-right: 10px; overflow: hidden; color: rgb(0, 0, 0); font-family: OpenSansRegular, Arial; font-size: 14px; line-height: normal;">Een wees wordt naar de magische wereld van Neverland gebracht. Daar aangekomen wordt hij de redder van de inboorlingen en leidt hij een opstand tegen de gemene piraten van Neverland. Uiteindelijk ontdekt hij hier zijn lot, veranderen in de legendarische held Peter Pan.</p>', 1, 1455521103, '2015-12-15 19:18:01', 'multi', 6, 0, 0, 0, 0, 0, 0, '2016-01-06 13:47:02', 'yes', 'no', 8, 0, 0, '', '11.jpg', '11_thumb.jpg', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `passkey` varchar(32) NOT NULL,
  `class` int(11) NOT NULL DEFAULT '0',
  `avatar` varchar(255) NOT NULL,
  `country` varchar(10) NOT NULL,
  `language` varchar(100) NOT NULL DEFAULT 'english',
  `uploaded` bigint(20) NOT NULL,
  `downloaded` bigint(20) NOT NULL,
  `maxtorrents` int(100) NOT NULL DEFAULT '10',
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `last_access` int(11) NOT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `donor` enum('yes','no') NOT NULL DEFAULT 'no',
  `warned` enum('yes','no') NOT NULL DEFAULT 'no',
  `warneduntil` datetime NOT NULL,
  `warnedby` int(11) NOT NULL,
  `modcomment` text NOT NULL,
  `deleted` enum('yes','no') NOT NULL DEFAULT 'no',
  `blocked` enum('yes','no') NOT NULL DEFAULT 'no',
  `last_browse` int(11) NOT NULL,
  `last_page` varchar(122) NOT NULL,
  `kliks` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Gegevens worden uitgevoerd voor tabel `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `passkey`, `class`, `avatar`, `country`, `language`, `uploaded`, `downloaded`, `maxtorrents`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `last_access`, `active`, `first_name`, `last_name`, `company`, `phone`, `donor`, `warned`, `warneduntil`, `warnedby`, `modcomment`, `deleted`, `blocked`, `last_browse`, `last_page`, `kliks`) VALUES
(8, '0.0.0.0', 'Decoder', '$2y$08$NueoRUAztcNU3CRFAIk.veVKTyzyn2LQQ67.2eYblrU6yKCGPHxy2', NULL, 'decoder1978@gmail.com', '084f31b021f9879e944c1c75e8406153', 7, '8.jpg', '15', 'english', 14859568159, 6030805715, 30, NULL, NULL, NULL, 'bMCgi.gOy.19YwLNIhjAte', 1434544387, 1522592458, 1522592466, 1, 'Decoder', 'Empire', 'Torrent Empire', '061234567', 'no', 'no', '0000-00-00 00:00:00', 0, 'Dit is een beetje test text kijken of het blijft staan: 26-07-2015', 'no', 'no', 2018, 'torrentsdetails5', 748),
(9, '77.167.206.83', 'RCR1984', '$2y$08$8emqmCnCwPekSlXXl7NuIu1MPYDc2RWbEGrMyPW2SHp6h2fIeeNXa', NULL, 'rcr1984@hotmail.com', '8c77c996bacaf5a3ad49e66684d95772', 6, '', '15', 'english', 6170912283, 3154095045, 10, NULL, NULL, NULL, 'bMCgi.gOy.19YwLNIhjAte', 1434997583, 1450209542, 1450209551, 1, NULL, NULL, NULL, NULL, 'no', 'no', '0000-00-00 00:00:00', 0, '23 oktober 2015  om 10:20:37 - Waarschuwing verwijderd door Decoder.\nMomentopname: Ontvangen: 2.9 GB - Verzonden: 5.7 GB - Ratio: 1.96\n\n29 september 2015  om 13:04:43 - Gewaarschuwd voor 336 uur door Decoder.\r\nReden waarschuwing: Pakken en wegwezen.  \r\nMomentopname: Ontvangen: 2.9 GB - Verzonden: 5.7 GB - Ratio: 1.96\r\n\r\n11 juli 2015  om 12:01:28 - Waarschuwing verwijderd door Decoder.\r\nMomentopname: Ontvangen: 564.7 MB - Verzonden: 5.6 GB - Ratio: 10.18\r\n\r\n26 juni 2015  om 14:35:52 - Gewaarschuwd voor 48 uur door Decoder.\r\nReden waarschuwing: Lage ratio.  \r\nMomentopname: Ontvangen: 564.7 MB - Verzonden: 4.0 GB - Ratio: 7.30\r\n\r\n', 'no', 'no', 2015, 'torrents', 62),
(10, '85.151.28.198', 'Sunshine', '$2y$08$CQUxJ0MD./3OByELfObZkewLk4K.T7LzKdZoI24tui.eVjHsNMAJ2', NULL, 'sunshine@live.nl', '0aebc45d158626b32e26167b515ded5a', 4, '10.jpg', '1', 'english', 0, 2316457407, 10, NULL, NULL, NULL, 'bMCgi.gOy.19YwLNIhjAte', 1435252047, 1453332936, 1453333032, 1, NULL, NULL, NULL, NULL, 'no', 'no', '0000-00-00 00:00:00', 0, '21 september 2015  om 15:51:17 - Waarschuwing verwijderd door Decoder.\nMomentopname: Ontvangen: 2.2 GB - Verzonden: 0 Bytes - Ratio: 0.00\n\n21 september 2015  om 15:50:53 - Gewaarschuwd voor 96 uur door Decoder.\r\nReden waarschuwing: Pakken en wegwezen.  \r\nMomentopname: Ontvangen: 2.2 GB - Verzonden: 0 Bytes - Ratio: 0.00\r\n\r\n7 september 2015  om 17:09:54 - Waarschuwing verwijderd door Decoder.\r\nMomentopname: Ontvangen: 206.8 MB - Verzonden: 0 Bytes - Ratio: 0.00\r\n\r\n7 september 2015  om 17:09:48 - Gewaarschuwd voor 336 uur door Decoder.\r\nReden waarschuwing: Lage ratio.  \r\nMomentopname: Ontvangen: 206.8 MB - Verzonden: 0 Bytes - Ratio: 0.00\r\n\r\n7 september 2015  om 15:08:35 - Waarschuwing verwijderd door Decoder.\r\nMomentopname: Ontvangen: 206.8 MB - Verzonden: 0 Bytes - Ratio: 0.00\r\n\r\n7 september 2015  om 17:07:00 - Gewaarschuwd voor 96 uur door Decoder.\r\nReden waarschuwing: Pakken en wegwezen.  \r\nMomentopname: Ontvangen: 206.8 MB - Verzonden: 0 Bytes - Ratio: 0.00\r\n\r\n7 september 2015  om 15:01:54 - Waarschuwing verwijderd door Decoder.\r\nMomentopname: Ontvangen: 206.8 MB - Verzonden: 0 Bytes - Ratio: 0.00\r\n\r\n', 'no', 'no', 2016, '', 96),
(11, '84.25.252.68', 'Sandor', '$2y$08$ZZh5bDfa9zpt86uNiCHpSOsxok9decgYb/b3UL3wujZwENIhPtqZe', NULL, 'sandor_schippers@hotmail.com', 'bd32655a289e7d52d23115711c8fd87f', 0, '', '15', 'english', 240173056, 2262049034, 10, NULL, 'bMCgi.gOy.19YwLNIhjAte5177fec9b29e3ea358', 1436942075, NULL, 1436941550, 1443192270, 1443192487, 1, NULL, NULL, NULL, NULL, 'no', 'no', '0000-00-00 00:00:00', 0, '', 'no', 'no', 2015, 'forumviewtopic13', 15),
(12, '85.151.28.198', 'Sjaakie', '$2y$08$2Ny/hD2jrHcNgX9TyGcYvuAfq8hoCHi8DpKrpyJzSly7SNkBk9evu', NULL, 'sjaak@live.nl', '203166322ef281d7b6f40662bb0b9cb1', 0, '', '15', 'english', 0, 0, 10, NULL, NULL, NULL, NULL, 1440118064, 1440118076, 1440118350, 1, NULL, NULL, NULL, NULL, 'no', 'no', '0000-00-00 00:00:00', 0, '', 'no', 'no', 2015, '', 0),
(13, '178.165.129.68', 'roli01', '$2y$08$UwPYH46n8KPyB9rgbscizOPkRtkYOWuFPv7wgp.Sn842F.a6szQle', NULL, 'per_vivere@hotmail.com', 'd4b0bd15e6ddaf9ece44e847de2ad77b', 0, '', '1', 'english', 0, 0, 10, NULL, NULL, NULL, NULL, 1448540057, 1448540068, 1448540112, 1, NULL, NULL, NULL, NULL, 'no', 'no', '0000-00-00 00:00:00', 0, '', 'no', 'no', 2015, 'torrents', 9),
(14, '178.252.19.106', 'Demo', '$2y$08$pGC/CwEANMLTbyVizjNv2uKx0vSJckZjuDnW36jlHE589AZu..ns6', NULL, 'demo@live.nl', '95a3ab573423ede21ea58579ef7e99f5', 0, '', '1', 'english', 0, 580833, 10, NULL, NULL, NULL, 'bMCgi.gOy.19YwLNIhjAte', 1450205057, 1520403450, 1520403502, 1, NULL, NULL, NULL, NULL, 'no', 'no', '0000-00-00 00:00:00', 0, '', 'no', 'no', 2018, 'forum', 707);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Gegevens worden uitgevoerd voor tabel `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(4, 2, 2),
(5, 2, 4),
(6, 4, 2),
(7, 5, 2),
(8, 6, 2),
(9, 7, 2),
(11, 8, 1),
(12, 8, 2),
(13, 9, 2),
(14, 10, 2),
(15, 11, 2),
(16, 12, 2),
(17, 13, 2),
(18, 14, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_ip`
--

CREATE TABLE IF NOT EXISTS `user_ip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `userid` int(11) NOT NULL,
  `last_seen` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=113 ;

--
-- Gegevens worden uitgevoerd voor tabel `user_ip`
--

INSERT INTO `user_ip` (`id`, `ip`, `userid`, `last_seen`, `added`) VALUES
(1, '84.25.229.192', 8, '2015-08-04 20:36:30', '2015-07-08 10:02:22'),
(2, '84.25.229.192', 10, '2015-07-19 13:57:28', '2015-07-08 11:24:11'),
(3, '77.167.206.83', 9, '2015-12-15 20:59:11', '2015-07-08 21:32:08'),
(4, '85.151.28.198', 8, '2016-02-22 22:44:34', '2015-07-11 21:36:27'),
(5, '85.151.28.198', 10, '2016-01-21 00:37:19', '2015-07-12 20:11:14'),
(6, '84.25.229.192', 11, '2015-07-15 08:37:25', '2015-07-15 08:26:20'),
(7, '84.25.252.68', 11, '2015-09-25 16:48:07', '2015-07-20 16:10:52'),
(8, '178.21.218.92', 10, '2015-07-21 10:42:46', '2015-07-21 10:27:35'),
(9, '178.21.218.92', 8, '2015-09-22 11:36:38', '2015-07-21 10:43:09'),
(10, '77.167.206.83', 8, '2015-07-22 01:24:42', '2015-07-22 00:28:29'),
(11, '213.124.117.35', 10, '2015-07-22 10:35:13', '2015-07-22 10:31:21'),
(12, '85.151.28.198', 9, '2015-08-10 03:23:37', '2015-07-27 23:36:58'),
(13, '62.140.132.13', 8, '2015-08-05 22:21:18', '2015-08-05 21:46:47'),
(14, '84.28.176.58', 8, '2017-05-16 12:29:03', '2015-08-11 19:34:55'),
(15, '86.95.134.236', 10, '2015-08-20 17:15:13', '2015-08-19 19:31:03'),
(16, '85.151.28.198', 12, '2015-08-21 02:52:30', '2015-08-21 02:47:56'),
(17, '62.140.132.76', 10, '2015-09-09 12:27:47', '2015-09-09 12:26:23'),
(18, '84.28.176.58', 10, '2015-09-20 20:00:00', '2015-09-09 22:40:19'),
(19, '84.25.92.53', 8, '2015-09-15 16:05:20', '2015-09-15 16:02:35'),
(20, '84.25.252.68', 8, '2015-10-24 16:55:28', '2015-10-24 16:53:47'),
(21, '85.150.127.165', 10, '2015-11-02 11:12:39', '2015-11-02 11:09:43'),
(22, '178.165.129.68', 13, '2015-11-26 13:15:12', '2015-11-26 13:14:29'),
(23, '85.151.28.198', 14, '2015-12-15 20:06:49', '2015-12-15 19:44:45'),
(24, '188.24.217.117', 14, '2015-12-16 17:15:13', '2015-12-15 20:05:55'),
(25, '83.233.190.117', 14, '2015-12-15 20:10:37', '2015-12-15 20:07:45'),
(26, '188.173.174.244', 14, '2015-12-15 21:02:16', '2015-12-15 21:01:26'),
(27, '77.64.255.104', 14, '2015-12-15 21:26:35', '2015-12-15 21:15:29'),
(28, '92.238.214.47', 14, '2015-12-15 21:44:02', '2015-12-15 21:43:42'),
(29, '82.20.1.238', 14, '2015-12-27 22:03:02', '2015-12-15 22:01:02'),
(30, '109.228.154.214', 14, '2015-12-15 22:41:17', '2015-12-15 22:39:02'),
(31, '123.2.106.154', 14, '2015-12-16 06:17:37', '2015-12-16 06:16:44'),
(32, '195.154.163.196', 14, '2015-12-16 06:49:53', '2015-12-16 06:48:51'),
(33, '70.80.117.5', 14, '2015-12-16 12:42:44', '2015-12-16 12:42:28'),
(34, '79.130.223.165', 14, '2015-12-16 13:32:07', '2015-12-16 13:31:20'),
(35, '178.252.19.106', 14, '2018-03-07 07:18:22', '2015-12-16 13:39:22'),
(36, '185.69.104.122', 14, '2015-12-16 14:10:37', '2015-12-16 14:09:58'),
(37, '79.237.51.181', 14, '2015-12-16 17:37:01', '2015-12-16 17:34:34'),
(38, '77.64.255.116', 14, '2015-12-20 18:10:02', '2015-12-16 17:38:20'),
(39, '41.250.54.190', 14, '2015-12-16 22:08:51', '2015-12-16 22:08:51'),
(40, '51.255.34.218', 14, '2015-12-17 01:55:42', '2015-12-17 01:54:55'),
(41, '123.28.215.168', 14, '2015-12-17 16:32:46', '2015-12-17 16:23:56'),
(42, '125.27.215.45', 14, '2015-12-17 16:29:40', '2015-12-17 16:27:44'),
(43, '95.211.139.6', 14, '2016-01-01 17:49:45', '2015-12-17 20:26:21'),
(44, '85.170.112.110', 14, '2015-12-17 23:09:47', '2015-12-17 23:00:30'),
(45, '92.84.156.70', 14, '2015-12-18 09:40:10', '2015-12-18 09:38:59'),
(46, '86.59.255.121', 14, '2015-12-18 10:32:44', '2015-12-18 10:32:27'),
(47, '117.250.38.218', 14, '2015-12-18 12:10:11', '2015-12-18 12:08:33'),
(48, '94.23.196.171', 14, '2015-12-19 18:26:33', '2015-12-18 13:50:18'),
(49, '31.15.137.154', 14, '2015-12-18 14:13:45', '2015-12-18 14:12:38'),
(50, '46.9.25.70', 14, '2015-12-18 16:04:51', '2015-12-18 16:02:10'),
(51, '217.173.47.7', 14, '2015-12-18 18:21:45', '2015-12-18 18:21:13'),
(52, '84.123.19.138', 14, '2015-12-18 22:37:21', '2015-12-18 22:37:21'),
(53, '213.107.150.157', 14, '2015-12-18 23:12:49', '2015-12-18 23:12:37'),
(54, '24.203.127.229', 14, '2015-12-19 03:00:50', '2015-12-19 03:00:50'),
(55, '78.177.251.246', 14, '2015-12-19 10:52:36', '2015-12-19 10:50:53'),
(56, '79.67.152.140', 14, '2015-12-19 13:46:48', '2015-12-19 13:46:33'),
(57, '89.120.160.131', 14, '2015-12-19 16:18:03', '2015-12-19 16:17:55'),
(58, '46.35.193.244', 14, '2015-12-19 16:50:41', '2015-12-19 16:50:18'),
(59, '80.12.35.64', 14, '2015-12-19 21:16:56', '2015-12-19 21:15:39'),
(60, '101.181.82.87', 14, '2015-12-20 00:38:45', '2015-12-20 00:37:15'),
(61, '43.245.119.218', 14, '2016-03-23 18:09:59', '2015-12-20 15:34:19'),
(62, '171.4.117.23', 14, '2015-12-20 18:16:58', '2015-12-20 18:16:50'),
(63, '78.134.109.0', 14, '2015-12-20 23:59:04', '2015-12-20 23:58:48'),
(64, '188.173.166.16', 14, '2015-12-21 08:24:08', '2015-12-21 08:23:35'),
(65, '62.64.154.1', 14, '2015-12-21 14:54:34', '2015-12-21 13:59:18'),
(66, '50.7.211.210', 14, '2015-12-21 14:34:42', '2015-12-21 14:33:01'),
(67, '188.24.207.44', 14, '2015-12-21 17:55:50', '2015-12-21 17:55:13'),
(68, '79.237.63.144', 14, '2015-12-22 00:18:44', '2015-12-22 00:17:33'),
(69, '89.212.224.55', 14, '2015-12-22 11:30:44', '2015-12-22 11:27:45'),
(70, '178.166.43.151', 14, '2015-12-22 23:43:34', '2015-12-22 23:23:04'),
(71, '84.62.225.75', 14, '2015-12-22 23:46:20', '2015-12-22 23:26:22'),
(72, '78.109.178.181', 14, '2015-12-23 10:18:09', '2015-12-23 10:17:42'),
(73, '78.217.68.23', 14, '2015-12-24 14:48:17', '2015-12-24 12:57:16'),
(74, '59.89.80.186', 14, '2015-12-24 19:41:38', '2015-12-24 19:41:12'),
(75, '85.74.214.134', 14, '2015-12-27 11:44:05', '2015-12-27 11:43:34'),
(76, '104.197.98.242', 14, '2015-12-27 17:42:48', '2015-12-27 17:42:42'),
(77, '46.165.220.195', 14, '2016-01-02 21:30:14', '2016-01-02 21:29:40'),
(78, '78.235.120.123', 14, '2016-01-08 15:10:25', '2016-01-08 14:54:27'),
(79, '92.22.87.24', 14, '2016-01-08 21:27:18', '2016-01-08 21:27:18'),
(80, '79.21.143.110', 14, '2016-01-09 07:59:55', '2016-01-09 07:59:55'),
(81, '81.232.163.122', 14, '2016-01-10 12:14:41', '2016-01-10 12:14:20'),
(82, '78.156.104.156', 14, '2016-01-10 18:08:05', '2016-01-10 18:07:10'),
(83, '89.42.155.2', 14, '2016-01-20 23:57:53', '2016-01-20 23:57:05'),
(84, '93.118.248.250', 14, '2016-01-27 12:07:56', '2016-01-27 12:07:21'),
(85, '95.220.93.146', 14, '2016-02-03 20:56:27', '2016-02-03 20:55:25'),
(86, '173.190.69.223', 14, '2016-02-06 19:13:48', '2016-02-06 19:13:06'),
(87, '212.10.178.202', 14, '2016-02-14 20:40:40', '2016-02-14 20:40:04'),
(88, '81.107.87.148', 14, '2016-02-16 22:29:54', '2016-02-16 22:28:59'),
(89, '94.211.246.45', 14, '2016-02-18 23:59:07', '2016-02-18 23:57:52'),
(90, '185.37.87.186', 14, '2016-02-19 17:23:24', '2016-02-19 17:22:45'),
(91, '175.212.206.176', 14, '2016-02-21 04:54:04', '2016-02-21 04:48:03'),
(92, '95.94.194.83', 14, '2016-02-27 20:41:47', '2016-02-27 20:41:25'),
(93, '78.217.69.73', 14, '2016-03-02 22:57:52', '2016-03-02 22:57:52'),
(94, '95.232.26.113', 14, '2016-03-16 03:23:34', '2016-03-16 03:23:34'),
(95, '177.43.13.242', 14, '2016-03-30 23:05:34', '2016-03-30 23:03:50'),
(96, '78.175.46.57', 14, '2016-04-23 23:40:22', '2016-04-23 23:40:05'),
(97, '213.146.225.171', 14, '2016-05-16 09:25:30', '2016-05-16 09:24:46'),
(98, '160.165.81.194', 14, '2016-07-24 12:02:45', '2016-07-24 12:02:30'),
(99, '77.221.63.30', 14, '2016-08-26 19:30:17', '2016-08-26 19:29:42'),
(100, '5.15.134.96', 14, '2016-11-07 18:45:18', '2016-11-07 18:44:04'),
(101, '79.107.178.152', 14, '2016-12-30 16:54:10', '2016-12-30 16:51:04'),
(102, '86.124.57.238', 14, '2017-02-02 18:12:22', '2017-02-02 18:11:40'),
(103, '188.98.143.8', 14, '2017-05-01 20:51:05', '2017-05-01 20:50:55'),
(104, '200.237.159.184', 14, '2017-05-19 14:54:46', '2017-05-19 14:50:41'),
(105, '188.25.73.213', 14, '2017-05-20 15:58:52', '2017-05-20 15:58:34'),
(106, '200.237.158.23', 14, '2017-05-23 19:47:41', '2017-05-23 19:43:23'),
(107, '37.59.60.209', 14, '2017-07-26 18:23:05', '2017-07-26 18:22:46'),
(108, '90.64.8.67', 14, '2017-10-12 19:00:22', '2017-10-12 18:59:10'),
(109, '46.190.0.33', 14, '2017-10-23 19:41:46', '2017-10-23 19:34:54'),
(110, '10.13.103.110', 8, '2017-11-16 09:53:08', '2017-11-16 09:48:06'),
(111, '103.30.141.105', 14, '2018-01-24 17:39:05', '2018-01-24 17:38:47'),
(112, '217.101.23.172', 8, '2018-04-01 16:21:06', '2018-04-01 09:17:39');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `warnings`
--

CREATE TABLE IF NOT EXISTS `warnings` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `userid` int(11) NOT NULL,
  `warned_by` int(11) NOT NULL,
  `uploaded` int(20) NOT NULL,
  `downloaded` int(20) NOT NULL,
  `warned_for` varchar(255) NOT NULL,
  `warned_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Gegevens worden uitgevoerd voor tabel `warnings`
--

INSERT INTO `warnings` (`id`, `date`, `userid`, `warned_by`, `uploaded`, `downloaded`, `warned_for`, `warned_time`) VALUES
(1, '2015-07-24 21:51:49', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(2, '2015-07-24 22:12:12', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(3, '2015-07-24 22:15:33', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(4, '2015-07-24 22:16:21', 10, 0, 0, 216808943, 'Lage ratio.', 0),
(5, '2015-07-24 22:16:41', 10, 0, 0, 216808943, 'Lage ratio.', 0),
(6, '2015-07-24 22:17:02', 10, 8, 0, 216808943, 'Lage ratio.', 48),
(7, '2015-07-24 22:18:04', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(8, '2015-07-24 22:18:14', 10, 8, 0, 216808943, 'Lage ratio.', 96),
(9, '2015-07-24 22:18:27', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(10, '2015-07-24 22:18:34', 10, 8, 0, 216808943, 'Lage ratio.', 672),
(11, '2015-07-24 22:18:48', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(12, '2015-07-24 22:19:00', 10, 8, 0, 216808943, 'Pakken en wegwezen.', 1680),
(13, '2015-07-26 09:37:39', 8, 0, 2147483647, 2147483647, 'Lage ratio.', 0),
(14, '2015-07-26 09:38:16', 8, 0, 2147483647, 2147483647, 'Lage ratio.', 0),
(15, '2015-07-29 01:31:09', 9, 0, 2147483647, 2147483647, 'Lage ratio.', 0),
(16, '2015-07-29 01:31:23', 9, 0, 2147483647, 2147483647, 'Lage ratio.', 0),
(17, '2015-08-04 20:31:34', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(18, '2015-08-04 20:31:46', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(19, '2015-08-04 20:31:55', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(20, '2015-08-04 20:33:32', 11, 0, 0, 0, 'Lage ratio.', 0),
(21, '2015-09-07 16:45:38', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(22, '2015-09-07 16:46:00', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(23, '2015-09-07 16:49:59', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(24, '2015-09-07 16:56:29', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(25, '2015-09-07 16:56:33', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(26, '2015-09-07 16:56:55', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(27, '2015-09-07 16:58:46', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(28, '2015-09-07 17:00:09', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(29, '2015-09-07 17:00:15', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(30, '2015-09-07 17:00:41', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(31, '2015-09-07 17:01:54', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(32, '2015-09-07 17:07:00', 10, 8, 0, 216808943, 'Pakken en wegwezen.', 96),
(33, '2015-09-07 17:08:35', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(34, '2015-09-07 17:09:48', 10, 8, 0, 216808943, 'Lage ratio.', 336),
(35, '2015-09-07 17:09:54', 10, 0, 0, 216808943, 'Pakken en wegwezen.', 0),
(36, '2015-09-21 15:50:07', 10, 0, 0, 2147483647, 'Lage ratio.', 0),
(37, '2015-09-21 15:50:53', 10, 8, 0, 2147483647, 'Pakken en wegwezen.', 96),
(38, '2015-09-21 15:51:17', 10, 0, 0, 2147483647, 'Pakken en wegwezen.', 0),
(39, '2015-09-29 13:04:43', 9, 8, 2147483647, 2147483647, 'Pakken en wegwezen.', 336),
(40, '2015-10-23 10:20:37', 9, 0, 2147483647, 2147483647, 'Pakken en wegwezen.', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `warn_pm_seeding`
--

CREATE TABLE IF NOT EXISTS `warn_pm_seeding` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `added` datetime DEFAULT NULL,
  `sender` int(8) NOT NULL DEFAULT '0',
  `receiver` int(8) NOT NULL DEFAULT '0',
  `torrent` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `added` (`added`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
