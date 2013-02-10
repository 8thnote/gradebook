-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 10 2013 г., 22:49
-- Версия сервера: 5.1.67-community-log
-- Версия PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `gradebook`
--

-- --------------------------------------------------------

--
-- Структура таблицы `faculties`
--

CREATE TABLE IF NOT EXISTS `faculties` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Faculty ID',
  `name` varchar(255) NOT NULL COMMENT 'Faculty Name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `faculties`
--

INSERT INTO `faculties` (`id`, `name`) VALUES
(1, 'Машинобудівний факультет (МБФ)'),
(2, 'Факультет бізнесу (ФБ)'),
(3, 'Факультет будівництва та дизайну (ФБД)'),
(4, 'Факультет екології та приладо-енергетичних систем (ФЕПЕС)'),
(5, 'Факультет комп''ютерних наук та інформаційних технологій (ФКНІТ)');

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Group ID',
  `name` varchar(255) NOT NULL COMMENT 'Group  Name',
  `faculty_id` int(11) NOT NULL COMMENT 'Faculty ID',
  `info` varchar(1024) NOT NULL COMMENT 'Information about subjects and teachers',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`, `faculty_id`, `info`) VALUES
(1, 'КСМ-21', 5, 'a:2:{i:1;a:1:{i:0;i:2;}i:3;a:1:{i:0;i:3;}}'),
(2, 'АТ-31', 1, 'a:2:{i:1;a:1:{i:0;i:2;}i:3;a:1:{i:0;i:3;}}');

-- --------------------------------------------------------

--
-- Структура таблицы `marks`
--

CREATE TABLE IF NOT EXISTS `marks` (
  `type` varchar(64) NOT NULL COMMENT 'Mark Type',
  `value` varchar(64) NOT NULL COMMENT 'Mark Value',
  `student_id` int(11) NOT NULL COMMENT 'Student ID',
  `subject_id` int(11) NOT NULL COMMENT 'Subject ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Page ID',
  `title` varchar(255) NOT NULL COMMENT 'Page Title',
  `path` varchar(255) NOT NULL COMMENT 'Page Path',
  `alias` varchar(255) NOT NULL COMMENT 'Page Alias',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table for pages data' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Student ID',
  `name` varchar(255) NOT NULL COMMENT 'Student Name',
  `group_id` int(11) NOT NULL COMMENT 'Group ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Subject ID',
  `name` varchar(255) NOT NULL COMMENT 'Subject Name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `subjects`
--

INSERT INTO `subjects` (`id`, `name`) VALUES
(1, 'Вища математика'),
(2, 'Українська мова'),
(3, 'Фізика'),
(4, 'Програмування');

-- --------------------------------------------------------

--
-- Структура таблицы `teachers`
--

CREATE TABLE IF NOT EXISTS `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Teacher ID',
  `name` varchar(255) NOT NULL COMMENT 'Teacher Name',
  `status` varchar(255) NOT NULL COMMENT 'Teacher Status',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `name` varchar(64) NOT NULL COMMENT 'User Name',
  `pass` varchar(64) NOT NULL COMMENT 'User Password',
  `role` varchar(64) NOT NULL COMMENT 'User Role',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Table for users data' AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `pass`, `role`) VALUES
(1, 'admin', '1', 'admin'),
(2, 'Вчитель математики', '1', 'teacher'),
(3, 'Вчитель фізики', '1', 'teacher');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
