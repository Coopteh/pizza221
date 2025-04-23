-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 15 2025 г., 06:15
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
  `address` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(120) NOT NULL,
  `all_sum` float NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `fio`, `address`, `phone`, `email`, `all_sum`, `created`) VALUES
(1, 'Петрова М.И.', 'г. Кемерово, ул. Тухачевского, 32', '89059000088', 'petrova@yahoo.com', 0, '2025-04-08 10:52:01'),
(2, 'Петрова М.И.', 'г. Кемерово, ул. Тухачевского, 32', '89059000088', 'jorkazomli@gufum.com', 550, '2025-04-08 10:53:11'),
(3, 'Иванов И.И.', 'г. Кемерово, ул. Ленинский 132', '89059000080', 'ivanov@yahoo.com', 1200, '2025-04-08 11:12:11'),
(4, 'Петрова М.И.', 'г. Кемерово, ул. Тухачевского, 32', '89059000088', 'petrova@yahoo.com', 3050, '2025-04-08 11:13:44'),
(5, 'Bafysdfsdf', 'г. Кемерово, ул. Тухачевского, 32', '89059000088', 'jorkazomli@gufum.com', 1200, '2025-04-11 12:13:05');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `order_item`
--

INSERT INTO `order_item` (`id`, `order_id`, `product_id`, `count_item`, `price_item`, `sum_item`) VALUES
(1, 3, 1, 1, 550, 550),
(2, 3, 2, 1, 650, 650),
(3, 4, 1, 2, 550, 1100),
(4, 4, 2, 3, 650, 1950),
(5, 5, 1, 1, 550, 550),
(6, 5, 2, 1, 650, 650);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(120) NOT NULL,
  `price` float NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image`, `price`, `created`, `updated`) VALUES
(1, 'Пицца Маргарита', 'Это наша фирменная пицца, она состоит из куриного мяса, сосисок, грибов и 2 сортов сыра (пармезана и моцареллы), декорирована веточкой петрушки!', 'https://localhost/pizza221/assets/images/image1.png', 550, '2025-04-07 13:00:54', '2025-04-07 13:00:54'),
(2, 'Пицца Пипперони', 'Это знаменитая пицца с колбасой и сыром', 'https://localhost/pizza221/assets/images/image2.png', 650, '2025-04-07 13:00:54', '2025-04-07 13:00:54');

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
  `is_verified` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `token`, `is_verified`, `created_at`) VALUES
(1, 'Петров', 'petrov@mail.ru', '$2y$10$XXTBpBCTj8oPoaA4nPUsne9qI1FGsgDtUdxK.KPiKR89KV13zUAbm', '448d3a0327b90b1bf583370a491ec5dde9cab0e2c9bb54623d01428531336b4b', 0, '2025-04-15 10:01:31'),
(2, 'Сидорова', 'sidorova@mail.ru', '$2y$10$A17hjhtd7S1/bZ1dNS2ZseDnhMkAFcQM25iQY3hH4j29IYFBEAs6.', '359b71ac6c3137a13d55791222aba24a', 0, '2025-04-15 10:04:53');

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
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_email` (`email`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
