-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Авг 09 2021 г., 18:27
-- Версия сервера: 10.3.23-MariaDB-0+deb10u1
-- Версия PHP: 7.3.4-2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `itsmakc_insta`
--

-- --------------------------------------------------------

--
-- Структура таблицы `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `nickname` varchar(64) NOT NULL,
  `email` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `contacts`
--

INSERT INTO `contacts` (`id`, `nickname`, `email`) VALUES
(1, 'Alicia Cain', 'jeucrummottepra-8373@google.com'),
(2, 'Marie Burns', 'mopuxobeige-3973@google.com'),
(3, 'John Turner', 'yazinemmoizei-4554@google.com'),
(4, 'Tiffany Thompson', 'weromazara-2388@google.com'),
(5, 'James Smith', 'yalutraujimme-1773@google.com'),
(6, 'Hazel Williamson', 'soddaufuprabrei-1545@google.com'),
(7, 'Ryan Lawson', 'banesinnallau-4863@google.com'),
(8, 'Ellen Jackson', 'lennidaujouha-1051@google.com'),
(9, 'Janet Williams', 'heigrauyezilla-3711@google.com'),
(10, 'Rebecca Simon', 'grimitruquoitrou-9169@google.com'),
(11, 'Catherine Diaz', 'boigippeuquigre-6957@google.com'),
(12, 'Barbara Hall', 'brouquauffoutebeu-1523@google.com'),
(13, 'James Richardson', 'weuvoloziva-8524@google.com'),
(14, 'Greg Sullivan', 'zetroikoiseju-6362@google.com'),
(15, 'Martha Malone', 'pretoillaffowou-7723@google.com');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nickname` varchar(64) NOT NULL,
  `email` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user_contacts`
--

CREATE TABLE `user_contacts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_contacts`
--

INSERT INTO `user_contacts` (`id`, `user_id`, `contact_id`) VALUES
(26, 7, 14),
(27, 7, 15),
(28, 6, 12);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_contacts`
--
ALTER TABLE `user_contacts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `user_contacts`
--
ALTER TABLE `user_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
