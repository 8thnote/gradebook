-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 20 2013 г., 13:24
-- Версия сервера: 5.5.29
-- Версия PHP: 5.3.10-1ubuntu3.5

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
('Added.', 'Додано.'),
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
('Enter', 'Увійти'),
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
('Record added.', 'Запис додано.'),
('Save', 'Зберегти'),
('Saved.', 'Збережено.'),
('Select record date', 'Виберіть дату запису'),
('Select record type', 'Виберіть тип запису'),
('Student name', 'П.І.Б.'),
('Students', 'Список студентів'),
('Subject', 'Предмет'),
('Subject name', 'Назва предмета'),
('Subjects', 'Список предметів'),
('Teachers', 'Викладачі'),
('Total Sum', 'Загальна сума');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
