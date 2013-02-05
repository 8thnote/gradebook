-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 06 2013 г., 01:00
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Group ID',
  `name` varchar(255) NOT NULL COMMENT 'Group  Name',
  `faculty_id` int(11) NOT NULL COMMENT 'Faculty ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Table for pages data' AUTO_INCREMENT=7 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Table for users data' AUTO_INCREMENT=3 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
