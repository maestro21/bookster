-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 18 2014 г., 17:21
-- Версия сервера: 5.1.41
-- Версия PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- База данных: `bookster`
--

-- --------------------------------------------------------

--
-- Структура таблицы `alerts`
--

CREATE TABLE IF NOT EXISTS `alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=140 ;

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isactive` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT '0',
  `name` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `lastmsgid` int(11) DEFAULT '0',
  `messages` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci,
  `abbr` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `courseworks`
--

CREATE TABLE IF NOT EXISTS `courseworks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) DEFAULT '0',
  `lang` text COLLATE utf8_unicode_ci,
  `name` text COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci,
  `filename` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `faculties`
--

CREATE TABLE IF NOT EXISTS `faculties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uni_id` int(11) DEFAULT '0',
  `name` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Структура таблицы `globals`
--

CREATE TABLE IF NOT EXISTS `globals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Структура таблицы `globals_values`
--

CREATE TABLE IF NOT EXISTS `globals_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT '0',
  `name` text COLLATE utf8_unicode_ci,
  `value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `help`
--

CREATE TABLE IF NOT EXISTS `help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text COLLATE utf8_unicode_ci,
  `answer` text COLLATE utf8_unicode_ci NOT NULL,
  `public` tinyint(4) NOT NULL DEFAULT '0',
  `lang` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Структура таблицы `labels`
--

CREATE TABLE IF NOT EXISTS `labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` text COLLATE utf8_unicode_ci,
  `label` text COLLATE utf8_unicode_ci,
  `text` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `langs`
--

CREATE TABLE IF NOT EXISTS `langs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `abbr` text COLLATE utf8_unicode_ci,
  `name` text COLLATE utf8_unicode_ci,
  `enabled` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Структура таблицы `lectures`
--

CREATE TABLE IF NOT EXISTS `lectures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `factulty_id` int(11) DEFAULT '0',
  `term_id` int(11) DEFAULT '0',
  `name` text COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `mail`
--

CREATE TABLE IF NOT EXISTS `mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) DEFAULT '0',
  `to` int(11) DEFAULT '0',
  `topic` text COLLATE utf8_unicode_ci,
  `text` text COLLATE utf8_unicode_ci,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delto` int(11) NOT NULL DEFAULT '0',
  `delfrom` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=213 ;

-- --------------------------------------------------------

--
-- Структура таблицы `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text COLLATE utf8_unicode_ci,
  `access` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `mylectures`
--

CREATE TABLE IF NOT EXISTS `mylectures` (
  `userid` int(11) NOT NULL,
  `lectureid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `myseminars`
--

CREATE TABLE IF NOT EXISTS `myseminars` (
  `userid` int(11) NOT NULL,
  `seminarid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `mysummaries`
--

CREATE TABLE IF NOT EXISTS `mysummaries` (
  `userid` int(11) NOT NULL,
  `reportid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` text COLLATE utf8_unicode_ci,
  `url` text COLLATE utf8_unicode_ci,
  `title` text COLLATE utf8_unicode_ci,
  `text` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Структура таблицы `refcategories`
--

CREATE TABLE IF NOT EXISTS `refcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_ua` text COLLATE utf8_unicode_ci,
  `name_ru` text COLLATE utf8_unicode_ci NOT NULL,
  `name_en` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Структура таблицы `referats`
--

CREATE TABLE IF NOT EXISTS `referats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) DEFAULT '0',
  `lang` text COLLATE utf8_unicode_ci,
  `name` text COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci,
  `filename` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `rightlist`
--

CREATE TABLE IF NOT EXISTS `rightlist` (
  `module` text COLLATE utf8_unicode_ci NOT NULL,
  `function` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `seminarlessons`
--

CREATE TABLE IF NOT EXISTS `seminarlessons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seminar_id` int(11) DEFAULT '0',
  `name` text COLLATE utf8_unicode_ci,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `literature` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=301 ;

-- --------------------------------------------------------

--
-- Структура таблицы `seminarquestions`
--

CREATE TABLE IF NOT EXISTS `seminarquestions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seminarlesson_id` int(11) DEFAULT '0',
  `question` text COLLATE utf8_unicode_ci,
  `answer` longblob,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1195 ;

-- --------------------------------------------------------

--
-- Структура таблицы `seminars`
--

CREATE TABLE IF NOT EXISTS `seminars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visible` int(11) NOT NULL,
  `specialization_id` int(11) DEFAULT '0',
  `faculty_id` int(11) DEFAULT '0',
  `term_id` int(11) DEFAULT '0',
  `name` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=223 ;

-- --------------------------------------------------------

--
-- Структура таблицы `seminar_tags`
--

CREATE TABLE IF NOT EXISTS `seminar_tags` (
  `seminar_id` int(11) NOT NULL,
  `tag` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`seminar_id`,`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `specialization`
--

CREATE TABLE IF NOT EXISTS `specialization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faculty_id` int(11) DEFAULT '0',
  `name` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Структура таблицы `summaries`
--

CREATE TABLE IF NOT EXISTS `summaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) DEFAULT '0',
  `lang` text COLLATE utf8_unicode_ci,
  `name` text COLLATE utf8_unicode_ci,
  `content` longblob,
  `filename` text COLLATE utf8_unicode_ci,
  `type` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=621 ;

-- --------------------------------------------------------

--
-- Структура таблицы `summaries_to_categories`
--

CREATE TABLE IF NOT EXISTS `summaries_to_categories` (
  `cat_id` int(11) NOT NULL,
  `sum_id` int(11) NOT NULL,
  PRIMARY KEY (`cat_id`,`sum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `summary_tags`
--

CREATE TABLE IF NOT EXISTS `summary_tags` (
  `summary_id` int(11) NOT NULL,
  `tag` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`summary_id`,`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `u2`
--

CREATE TABLE IF NOT EXISTS `u2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `pass` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `isadmin` int(11) NOT NULL DEFAULT '0',
  `confirmed` int(11) NOT NULL DEFAULT '0',
  `confirmcode` text COLLATE utf8_unicode_ci NOT NULL,
  `country` text COLLATE utf8_unicode_ci NOT NULL,
  `city_id` text COLLATE utf8_unicode_ci NOT NULL,
  `uni_id` int(11) NOT NULL,
  `faculty_id` text COLLATE utf8_unicode_ci NOT NULL,
  `yfrom` int(11) NOT NULL,
  `yto` int(11) NOT NULL,
  `following` text COLLATE utf8_unicode_ci NOT NULL,
  `term` int(11) NOT NULL,
  `specialization_id` int(11) NOT NULL,
  `lastmsgcheck` datetime NOT NULL,
  `lastalertcheck` datetime NOT NULL,
  `phone` text COLLATE utf8_unicode_ci NOT NULL,
  `skype` text COLLATE utf8_unicode_ci NOT NULL,
  `vkontakte` text COLLATE utf8_unicode_ci NOT NULL,
  `rights` text COLLATE utf8_unicode_ci NOT NULL,
  `soc_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `soc_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `followers` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=113 ;

-- --------------------------------------------------------

--
-- Структура таблицы `universities`
--

CREATE TABLE IF NOT EXISTS `universities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT '0',
  `name` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `pass` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `isadmin` int(11) NOT NULL DEFAULT '0',
  `confirmed` int(11) NOT NULL DEFAULT '0',
  `confirmcode` text COLLATE utf8_unicode_ci NOT NULL,
  `country` text COLLATE utf8_unicode_ci NOT NULL,
  `city_id` text COLLATE utf8_unicode_ci NOT NULL,
  `uni_id` int(11) NOT NULL,
  `faculty_id` text COLLATE utf8_unicode_ci NOT NULL,
  `yfrom` int(11) NOT NULL,
  `yto` int(11) NOT NULL,
  `following` text COLLATE utf8_unicode_ci NOT NULL,
  `term` int(11) NOT NULL,
  `specialization_id` int(11) NOT NULL,
  `lastmsgcheck` datetime NOT NULL,
  `lastalertcheck` datetime NOT NULL,
  `phone` text COLLATE utf8_unicode_ci NOT NULL,
  `skype` text COLLATE utf8_unicode_ci NOT NULL,
  `vkontakte` text COLLATE utf8_unicode_ci NOT NULL,
  `rights` text COLLATE utf8_unicode_ci NOT NULL,
  `soc_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `soc_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `followers` text COLLATE utf8_unicode_ci NOT NULL,
  `followers2` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=113 ;

-- --------------------------------------------------------

--
-- Структура таблицы `visits`
--

CREATE TABLE IF NOT EXISTS `visits` (
  `uid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  `lastvisit` datetime NOT NULL,
  PRIMARY KEY (`uid`,`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `users` SET `mail` = 'admin', `pass` = MD5('admin'), `isadmin` = 2, `confirmed` = 2;

INSERT INTO `globals` (`name`, `value`) VALUES
('defclass', 'users'),
('access', 'select'),
('defmodule', 'pages'),
('deflang', 'en'),
('mailFrom', 'Bookster &lt;register@bookster.com.ua&gt;');