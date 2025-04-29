-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 29 2025 г., 07:48
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `is221`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `fio` varchar(120) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `all_sum` float NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `fio`, `address`, `phone`, `email`, `all_sum`, `created`, `user_id`, `status`) VALUES
(1, 'Иванов Иван Иванович', 'г. Москва, ул. Ленина, д. 15, кв. 42', '79161234567', 'example@mail.ru', 6050, '2025-04-08 12:28:06', 0, 0),
(2, 'Иванов Иван Иванович', 'г. Москва, ул. Ленина, д. 15, кв. 42', '79161234567', 'hitrucetru@gufum.com', 6050, '2025-04-08 12:28:43', 0, 0),
(3, 'Иванов Иван Иванович', 'г. Москва, ул. Ленина, д. 15, кв. 42', '79161234567', 'hitrucetru@gufum.com', 0, '2025-04-08 12:30:22', 0, 0),
(4, 'Иванов Иван Иванович', 'г. Москва, ул. Ленина, д. 15, кв. 42', '79161234567', 'hitrucetru@gufum.com', 3300, '2025-04-08 12:34:09', 0, 0),
(5, 'Иванов Иван Иванович', 'г. Москва, ул. Ленина, д. 15, кв. 42', '79161234567', 'example@mail.ru', 4400, '2025-04-15 10:54:54', 0, 0),
(6, 'Иванов Иван Иванович', 'г. Москва, ул. Ленина, д. 15, кв. 42', '79161234567', 'hitrucetru@gufum.com', 4400, '2025-04-15 10:55:08', 0, 0),
(7, 'Иванов Иван Иванович', 'г. Москва, ул. Ленина, д. 15, кв. 42', '79161234567', 'restunafye@gufum.com', 8650000, '2025-04-22 11:48:26', 0, 0),
(8, 'Акимова Дмитрий Дмитриевчи', 'Тухачевского 32a', '88005553535', 'moscvicin1986@gmail.com', 4550000, '2025-04-24 14:23:28', 0, 0),
(9, 'Иванов Иван Иванович', 'г. Москва, ул. Ленина, д. 15, кв. 42', '79161234567', 'hc0y3@ptct.net', 5850000, '2025-04-24 14:24:09', 0, 0),
(10, 'Лудоманыч', 'г. Москва, ул. Ленина, д. 15, кв. 42', '79161234567', 'restunafye@gufum.com', 1300000, '2025-04-29 12:35:13', 3, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
