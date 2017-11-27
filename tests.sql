-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 27 2017 г., 15:52
-- Версия сервера: 5.6.37
-- Версия PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tests`
--

-- --------------------------------------------------------

--
-- Структура таблицы `xyz_users`
--

CREATE TABLE `xyz_users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(43) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` text NOT NULL,
  `session_email` varchar(190) NOT NULL,
  `image` varchar(190) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `xyz_users`
--

INSERT INTO `xyz_users` (`id`, `fullname`, `email`, `password`, `session_email`, `image`) VALUES
(4, 'Abylay Kura', 'qwsdoam@gmail.com', '$2a$07$usesomadaULQXTPpOSDAQOju.0oviDLwxOZrxc7hJv6nodPwkvQh.', '2017-11-27T15:20:09+03:00-(?)-(?@@@Q)-$2a$07$usesomadaULQXTPpOSDAQOFvtAEHYN2pDWPKkNehAj9aiJqQzh/8a', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `xyz_users`
--
ALTER TABLE `xyz_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `xyz_users`
--
ALTER TABLE `xyz_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
