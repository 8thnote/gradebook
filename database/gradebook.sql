-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 12 2013 г., 00:51
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
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Mark ID',
  `value` varchar(64) NOT NULL COMMENT 'Mark Value',
  `record_id` int(11) NOT NULL COMMENT 'Record ID',
  `student_id` int(11) NOT NULL COMMENT 'Student ID',
  `subject_id` int(11) NOT NULL COMMENT 'Subject ID',
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `marks`
--

INSERT INTO `marks` (`id`, `value`, `record_id`, `student_id`, `subject_id`, `author_id`) VALUES
(1, 'Н', 2, 1, 1, 2),
(2, '5', 3, 2, 1, 2),
(3, '3', 4, 1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `records`
--

CREATE TABLE IF NOT EXISTS `records` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Record ID',
  `type_id` int(11) NOT NULL COMMENT 'Record Type ID',
  `date` date NOT NULL,
  `group_id` int(11) NOT NULL COMMENT 'Group ID',
  `subject_id` int(11) NOT NULL COMMENT 'Subject ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `records`
--

INSERT INTO `records` (`id`, `type_id`, `date`, `group_id`, `subject_id`) VALUES
(1, 1, '2013-02-05', 1, 1),
(2, 2, '2013-02-06', 1, 1),
(3, 3, '2013-02-15', 1, 1),
(4, 4, '2013-02-04', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `record_types`
--

CREATE TABLE IF NOT EXISTS `record_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Record Type ID',
  `name` varchar(64) NOT NULL COMMENT 'Record Type Name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `record_types`
--

INSERT INTO `record_types` (`id`, `name`) VALUES
(1, 'lecture'),
(2, 'practice'),
(3, 'lab'),
(4, 'module');

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Student ID',
  `name` varchar(255) NOT NULL COMMENT 'Student Name',
  `group_id` int(11) NOT NULL COMMENT 'Group ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`id`, `name`, `group_id`) VALUES
(1, 'Саша', 1),
(2, 'Пєтя', 1),
(3, 'Андрій', 2),
(4, 'Вася', 2);

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
