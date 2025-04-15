-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 15 2025 г., 07:04
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

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
  `created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `fio`, `address`, `phone`, `email`, `all_sum`, `created`) VALUES
(1, 'Иванов Иван Иванович', 'ул. Мичурина д.15 кв.10 ', '89956556222', 'despuvikna@gufum.com', 100, '2025-04-08 12:04:14'),
(2, 'Иванов Иван Иванович', 'ул. Мичурина д.15 кв.10 ', '89956556222', 'VAnka@email.com', 9200, '2025-04-08 12:09:07'),
(3, 'Иванов Иван Иванович', 'ул. Мичурина д.15 кв.10 ', '89956556222', 'VAnka@email.com', 3200, '2025-04-14 14:48:44'),
(4, 'Иванов Иван Иванович', 'ул. Мичурина д.15 кв.10 ', '89956556222', 'VAnka@email.com', 6400, '2025-04-14 14:57:01'),
(5, 'Иванов Иван Иванович', 'ул. Мичурина д.15 кв.10 ', '89956556222', 'VAnka@email.com', 3200, '2025-04-15 10:44:42');

-- --------------------------------------------------------

--
-- Структура таблицы `order_item`
--

CREATE TABLE `order_item` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `count_item` int(11) NOT NULL,
  `price_item` float NOT NULL,
  `sum_item` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `order_item`
--

INSERT INTO `order_item` (`id`, `order_id`, `product_id`, `count_item`, `price_item`, `sum_item`) VALUES
(1, 1, 1, 1, 3200, 3200),
(2, 2, 1, 1, 3200, 3200),
(3, 2, 2, 1, 6000, 6000),
(4, 3, 1, 1, 3200, 3200),
(5, 4, 1, 2, 3200, 6400),
(6, 5, 1, 1, 3200, 3200);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(120) DEFAULT NULL,
  `price` float NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image`, `price`, `created`, `updated`) VALUES
(1, 'Рембо', 'Абонимент на 1 месяц(30 дней)', 'https://localhost/trenazherka/assets/images/rembo.png', 3200, '2025-04-07 12:55:08', '2025-04-08 12:08:50'),
(2, 'Терминатор', 'Абонимент на 3 месяца(90 дней)', 'https://localhost/trenazherka/assets/images/term.png', 6000, '2025-04-07 12:55:08', '2025-04-08 12:08:41'),
(3, 'Отлет', 'Абонимент на 6 месяцев(180 дней)', 'https://localhost/trenazherka/assets/images/otlet.png', 10000, '2025-04-07 12:55:08', '2025-04-08 12:08:33'),
(4, ' Посейдон ', 'Абонемент в бассейн(30 дней)', 'https://localhost/trenazherka/assets/images/pos.png', 2500, '2025-04-15 11:43:12', '2025-04-15 12:01:57');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `token`, `is_verified`, `created_at`) VALUES
(1, 'Вертухай Кирилл Абрамосович ', 'despuvikna@gufum.com', '$2y$10$xAhrlLUpyUPtOxzPBNU1meYSjSANJm85rlvJbgTdx1h1lYJChOIOO', 'febdcac58f3de173e0b6b5fedce0913d', 0, '2025-04-15 11:23:46'),
(2, 'Иванов Иван', '123rew321@gmail.com', '$2y$10$leqi5pf6WtVD/Zb7vuJH5OUFFu1/Imp4lkECGGMZtQzBNuBXSLWfC', '251852e96e9be393e75e1cf7d861f5a6', 0, '2025-04-15 11:52:38');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
