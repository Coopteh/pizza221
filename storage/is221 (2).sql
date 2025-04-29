-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 29 2025 г., 07:55
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
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `fio`, `address`, `phone`, `email`, `all_sum`, `created`, `user_id`, `status`) VALUES
(1, 'Fex', 'ул. разбитых фонарей', '+78901235678', 'TerAer@mail.ru', 0, '2025-04-08 11:47:11', 0, 0),
(2, 'Fex', 'ул. разбитых фонарей', '+78901235678', 'TerAer@mail.ru', 900, '2025-04-08 12:20:11', 0, 0),
(3, 'asfafsasf', 'ул. разбитых фонарей', '+78901235678', 'TerAer@mail.ru', 950, '2025-04-11 12:48:55', 0, 0),
(4, 'asfafsasf', 'ул. разбитых фонарей', '+78901235678', 'TerAer@mail.ru', 600, '2025-04-21 13:59:07', 0, 0),
(5, 'asfafsasf', 'ул. разбитых фонарей', '+78901235678', 'jorduhisto@gufum.com', 300, '2025-04-21 14:04:38', 0, 0),
(6, 'asfafsasf', 'ул. разбитых фонарей', '+78901235678', 'sarzogedre@gufum.com', 2100, '2025-04-22 14:23:11', 0, 0),
(7, 'asfafsasf', 'ул. разбитых фонарей', '+78901235678', 'sarzogedre@gufum.com', 0, '2025-04-22 14:23:13', 0, 0),
(8, 'fe', 'ул. разбитых фонарей', '+78901235678', 'ropsidafyi@gufum.com', 300, '2025-04-28 15:53:28', 0, 0),
(9, 'fe', 'ул. разбитых фонарей', '+78901235678', 'ropsidafyi@gufum.com', 1850, '2025-04-28 15:55:34', 0, 0),
(10, 'fe', 'ул. разбитых фонарей', '+78901235678', 'ropsidafyi@gufum.com', 1350, '2025-04-29 12:14:15', 5, 0),
(11, 'fe', 'ул. разбитых фонарей', '+78901235678', 'ropsidafyi@gufum.com', 300, '2025-04-29 12:31:06', 5, 1),
(12, 'fe', 'ул. разбитых фонарей', '+78901235678', 'ropsidafyi@gufum.com', 1250, '2025-04-29 12:31:13', 5, 3),
(13, 'fe', 'ул. разбитых фонарей', '+78901235678', 'ropsidafyi@gufum.com', 650, '2025-04-29 12:31:48', 5, 3),
(14, 'fe', 'ул. разбитых фонарей', '+78901235678', 'ropsidafyi@gufum.com', 1250, '2025-04-29 12:31:13', 5, 2);

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
(1, 2, 1, 3, 300, 900),
(2, 3, 1, 2, 300, 600),
(3, 3, 2, 1, 350, 350),
(4, 4, 1, 2, 300, 600),
(5, 5, 1, 1, 300, 300),
(6, 6, 1, 7, 300, 2100),
(7, 8, 1, 1, 300, 300),
(8, 9, 1, 5, 300, 1500),
(9, 9, 2, 1, 350, 350),
(10, 10, 1, 1, 300, 300),
(11, 10, 2, 3, 350, 1050),
(12, 11, 1, 1, 300, 300),
(13, 12, 1, 3, 300, 900),
(14, 12, 2, 1, 350, 350),
(15, 13, 1, 1, 300, 300),
(16, 13, 2, 1, 350, 350);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image`, `price`, `created`, `updated`) VALUES
(1, 'Шаурма классическая', 'Классическая шаурма, курица и огурец', 'https://localhost/pizza221/assets/images/image1.png', 300, '2025-04-07 14:59:57', '2025-04-07 14:59:57'),
(2, 'Шаурма бургер', 'Шаурма бургер. Просто бургер', 'https://localhost/pizza221/assets/images/image2.png', 350, '2025-04-07 14:59:57', '2025-04-07 14:59:57');

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
  `is_verified` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `address` varchar(200) NOT NULL,
  `phone` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `token`, `is_verified`, `created_at`, `address`, `phone`) VALUES
(3, 'rert', 'sarzogedre@gufum.com', '$2y$10$Ud2SvEiBZgRLdQtEUTgtTeAf3n95Lr3m6eV9GrZJieVThxUumeWC6', '', 1, '2025-04-22 14:19:16', '', ''),
(4, 'fayuo', 'bordefalte@gufum.com', '$2y$10$lzKnUwjkXkRxHVhN8sgyj.Ol2iojTcTcASj85CUja2Sqec2eWYkVa', '', 1, '2025-04-25 11:44:14', '', ''),
(5, 'fe', 'ropsidafyi@gufum.com', '$2y$10$KNda9IUotkhYAnLpS1y/U.9p73bxmo4VBrzeMI0CVHoqoeBPH.SRG', '', 1, '2025-04-28 14:46:25', 'ул. разбитых фонарей', '+78901235678');

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
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
