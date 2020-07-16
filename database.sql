-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Июл 16 2020 г., 09:03
-- Версия сервера: 8.0.18
-- Версия PHP: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `nb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `Comment_id` int(11) NOT NULL,
  `Comment_text` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`Comment_id`, `Comment_text`) VALUES
(1, 'Do not be rude'),
(2, 'Do not cheat'),
(3, 'Do not feed '),
(4, 'We will ban your account'),
(5, 'You will lose all your achievements'),
(6, 'Make some achievements'),
(7, 'Make environment more complex and add some maps'),
(8, 'Olzhas is the best'),
(9, 'Totally agree'),
(10, 'Can not shot to the top of map.'),
(11, 'Olzhas,  we fixed this bag.'),
(12, 'I heard she is more beautiful than Kim Kardashian\n'),
(13, 'She is even better than Gal Gadot. : )'),
(14, 'Wow'),
(15, 'Hello');

-- --------------------------------------------------------

--
-- Структура таблицы `ctu`
--

CREATE TABLE `ctu` (
  `Comment_id` int(11) NOT NULL,
  `Topic_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `ctu`
--

INSERT INTO `ctu` (`Comment_id`, `Topic_id`, `User_id`) VALUES
(1, 3, 1),
(2, 3, 1),
(3, 3, 1),
(4, 4, 1),
(5, 4, 1),
(6, 2, 3),
(7, 2, 2),
(8, 7, 8),
(9, 7, 9),
(10, 6, 9),
(11, 6, 1),
(12, 8, 1),
(13, 8, 10),
(14, 5, 1),
(15, 7, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `discussions`
--

CREATE TABLE `discussions` (
  `Discussion_id` int(11) NOT NULL,
  `Discussion_title` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `discussions`
--

INSERT INTO `discussions` (`Discussion_id`, `Discussion_title`) VALUES
(2, 'Tech'),
(3, 'Flud'),
(6, 'Important!');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `text` text COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `title`, `text`, `url`, `date`) VALUES
(20, 'Great grandmaster.', 'Good morning , champions. Today is day to introduce you our great grandmaster. She is fan if \"Chelsea \r\n FC\", which is one of the  English Premiere Legue leaders, good luck on upcoming game(21.05 vs Aston Villa) and very beautiful woman in the KZ.', '//ru-wotp.wgcdn.co/dcont/fb/image/souvenir-main-new-2-min_KRTDbEP.jpg', '2020-06-20'),
(21, 'Our leaders.', 'Hello guys today we are going to introduce you our leaders and developers. Dimash and Olzhas. blablablablablablablablablablablablablablablablablabla\r\nblablablablablablablablablablablablablablablablablablablabla. Thank you for your attention. Enjoy your game.', 'https://images3.alphacoders.com/551/thumb-350-551461.jpg', '2020-06-09'),
(22, 'Update!', 'Our team of developers added point counter. When you kill your rival you earn points. Who first earn 300 point will win.', 'https://images3.alphacoders.com/686/thumb-350-686684.jpg', '2020-06-08'),
(23, 'Multiplayer!', 'From now on you can play the game with your friend, and in the future we are going to make it online and global.', 'https://images4.alphacoders.com/773/thumb-350-773075.jpg', '2020-06-07'),
(24, 'Rules! read carefully', 'We added some rules for the game. Please read carefully and do not break the rules. Have a nice game.', 'https://images7.alphacoders.com/657/thumb-350-657332.jpg', '2020-06-06'),
(25, 'Music in OD tanks', 'At the new update, we have uploaded music to the game. Then you can fell the atmosphere more clear , it will be improve your feeling. ', 'https://images4.alphacoders.com/748/thumb-350-748928.jpg', '2020-06-05'),
(26, 'Update!', 'Today we launched new update. From today we added some stones to the map.  Be in touch, because in the future there will be more maps in the game. ', 'https://images5.alphacoders.com/774/thumb-350-774525.jpg', '2020-06-04'),
(27, 'Improved web site', 'Hello every fan of our game! From now on you can leave feedback , communicate with other players and share your impressions. Also you can read the rules and punishment, please do not cheat.', 'https://images7.alphacoders.com/107/thumb-350-1071326.jpg', '2020-06-03'),
(28, 'First update!', 'our development team, by popular demand, made adjustments to the management of tanks and added obstacles', 'https://images4.alphacoders.com/836/thumb-350-836820.jpg', '2020-06-02'),
(29, 'Happy birthday \"OD Tanki\"', 'First launch of the game. Please play and leave feedback to improve this project.', 'https://images7.alphacoders.com/683/thumb-350-683225.jpg', '2020-06-01');

-- --------------------------------------------------------

--
-- Структура таблицы `td`
--

CREATE TABLE `td` (
  `Discussion_id` int(11) NOT NULL,
  `Topic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `td`
--

INSERT INTO `td` (`Discussion_id`, `Topic_id`) VALUES
(2, 2),
(6, 3),
(6, 4),
(3, 5),
(2, 6),
(3, 7),
(3, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `topics`
--

CREATE TABLE `topics` (
  `Topic_id` int(11) NOT NULL,
  `Topic_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `topics`
--

INSERT INTO `topics` (`Topic_id`, `Topic_name`) VALUES
(2, 'Offers'),
(3, 'Rules'),
(4, 'Punishment'),
(5, 'Impressions'),
(6, 'Complaints'),
(7, 'Who is the best'),
(8, 'how does grandmaster look like');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `isAdmin` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `password`, `isAdmin`) VALUES
(1, 'Admin', 'admin@mail.ru', '123', 1),
(2, 'Duka', 'pechkin@pochtalyon.com', 'pechka123', 0),
(3, 'Zhenis', 'zhenis@pobeda.kz', 'KZTop1', 0),
(8, 'Olzhas', 'a.olzhas.a@gmail.com', '123', 2),
(9, 'Olzhas', 'ratbel@ggg.kz', '123', 2),
(10, 'Dimash', 'dimash@dev.kz', '123', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Comment_id`);

--
-- Индексы таблицы `discussions`
--
ALTER TABLE `discussions`
  ADD PRIMARY KEY (`Discussion_id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`Topic_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `Comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `discussions`
--
ALTER TABLE `discussions`
  MODIFY `Discussion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `topics`
--
ALTER TABLE `topics`
  MODIFY `Topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
