-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 18 2013 г., 23:04
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
  `info` varchar(1024) NOT NULL COMMENT 'Subjects And Teachers Information',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `locale`
--

CREATE TABLE IF NOT EXISTS `locale` (
  `default` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Default String',
  `ua` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Ukrainian Translation',
  UNIQUE KEY `default` (`default`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `locale`
--

INSERT INTO `locale` (`default`, `ua`) VALUES
('Absence Num', 'Кількість пропусків'),
('Actions', 'Дії'),
('Add', 'Додати'),
('Add faculty', 'Додати факультет'),
('Add group', 'Додати групу'),
('Add student', 'Додати студента'),
('Add subject', 'Додати предмет'),
('Add teacher', 'Додати викладача'),
('All groups', 'Всі групи'),
('All students', 'Всі студенти'),
('All subjects', 'Всі предмети'),
('Are you confirm delete?', 'Ви підтверджуєте видалення?'),
('Authorization', 'Авторизація'),
('Cancel', 'Скасувати'),
('Content adding', 'Додавання контенту'),
('Content deleting', 'Видалення контенту'),
('Content editing', 'Редагування контенту'),
('Current Sum', 'ПК (сума)'),
('Delete', 'Видалити'),
('Deleted.', 'Видалено.'),
('Edit', 'Редагувати'),
('Empty', 'Записів немає'),
('Enter success.', 'Вхід здійснено.'),
('Exit', 'Вийти'),
('Exit success.', 'Вихід здійснено.'),
('Faculties', 'Факультети'),
('Faculty', 'Факультет'),
('Faculty name', 'Назва факультету'),
('Front', 'Головна'),
('Gradebook', 'Журнал'),
('Gradebook saved.', 'Журнал збережено.'),
('Group', 'Група'),
('Group name', 'Назва групи'),
('Hello', 'Привіт'),
('lab', 'ЛАБ'),
('lecture', 'Л'),
('Modular Sum', 'МК (сума)'),
('module', 'МК'),
('Name', 'Ім''я'),
('Options', 'Опції'),
('Password', 'Пароль'),
('practice', 'П'),
('Save', 'Зберегти'),
('Saved.', 'Збережено.'),
('Student name', 'П.І.Б.'),
('Students', 'Список студентів'),
('Subject', 'Предмет'),
('Subject name', 'Назва предмета'),
('Subjects', 'Список предметів'),
('Teachers', 'Викладачі'),
('Total Sum', 'Загальна сума');

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
  `author_id` int(11) NOT NULL COMMENT 'Teacher ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `records`
--

CREATE TABLE IF NOT EXISTS `records` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Record ID',
  `type_id` int(11) NOT NULL COMMENT 'Record Type ID',
  `date` date NOT NULL COMMENT 'Date',
  `group_id` int(11) NOT NULL COMMENT 'Group ID',
  `subject_id` int(11) NOT NULL COMMENT 'Subject ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `record_types`
--

CREATE TABLE IF NOT EXISTS `record_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Record Type ID',
  `name` varchar(64) NOT NULL COMMENT 'Record Type Name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

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
(1, 'admin', '1', 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
