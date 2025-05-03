-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 28 2025 г., 09:51
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `fio`, `address`, `phone`, `email`, `all_sum`, `created`) VALUES
(1, 'Jefry Boger Blog', 'Кифирчик ул', '83838843444', 'v.milevskiy@coopteh.ru', 0, '2025-04-08 12:05:13');

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
(1, 'Страхование автотранспорта', 'Страхование автотранспорта', 'assets/images/avto.png', 5000, '2025-04-07 13:22:44', '2025-04-07 13:22:44'),
(2, 'Страхование домов', 'Страхование домов', 'assets/images/image5.png', 20000, '2025-04-07 13:22:44', '2025-04-07 13:22:44'),
(3, 'Страхование жизни', 'Страхование жизни', 'assets/images/image6.png', 2000, '2025-04-07 13:22:44', '2025-04-07 13:22:44');

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
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `token`, `is_verified`, `created_at`, `address`) VALUES
(1, 'kkt22-121', 'v.milevskiy@coopteh.ru', '$2y$10$vjQCMWdwffJsVrjRsmz6ZeY/T54Y.2XQmzsPtJji3DXNZQ1ZPCZpq', '', 1, '2025-04-21 14:23:54', NULL),
(2, 'kkt22-121', 'lakkibalmo@gufum.com', '$2y$10$/luOhqgP7LHMe8UOxDMlTuzYs.dA9REahmbWUcfgCdhuBslQ/9FIy', '', 1, '2025-04-21 14:26:45', NULL),
(3, '123', 'lakkibalmo@gufum.com', '$2y$10$DH4oQzqW/j2g.NHWAiLQhOekmyrBSp3iJYYn4AC9WiKP3M8ApZEfW', '', 1, '2025-04-21 14:29:20', NULL),
(4, '123', 'artemlerman412@gmail.com', '$2y$10$auO86mv0PWjM7YZQj.KWLe6nAq73SZP6cDgKtp7qtoKTEOOydsTj.', '', 1, '2025-04-21 14:36:46', NULL),
(5, '1234', 'retricispe@gufum.com', '$2y$10$uANlYxxf6fbrc/mFsTmBg.kV7VOPYCRheHPJZ5rBE2JDqaetiSiMG', '', 1, '2025-04-21 14:45:51', NULL),
(6, '1234', 'huknetalmo@gufum.com', '$2y$10$4kc8iwnl0U0mwQALg9y8kuLKaLJUcWA2k.LzMCS0mwV0nouLl8ccy', '', 1, '2025-04-21 14:46:59', NULL),
(7, '1234', 'yordaraste@gufum.com', '$2y$10$SNTqJFOd/5WdS8vXFWudweyVena2uW/VVzDiYz5zzIvRJDE36LZ/G', '', 1, '2025-04-21 14:49:49', NULL),
(8, '12345', 'fudrijutru@gufum.com', '$2y$10$vgeWsg2t8fzxKtrH146CfuAYdvdyS4.G3lMvC.vmsDJUpPJ9DrjQ6', '', 1, '2025-04-21 14:53:23', NULL),
(9, '12345', 'rerkinepsu@gufum.com', '$2y$10$Ex2BHSj2Y7spvYlYwqMsNuW/48REWcSUNg8A/KjrpbYOOYKE/CCsq', '', 1, '2025-04-21 15:17:32', NULL),
(10, 'arteke', 'keltetekno@gufum.com', '$2y$10$9.Fq19mWsM5vd4p3NMUdAuPuizNHmc6zA0ACwOYZ6jU5rNRq47wtS', '', 1, '2025-04-22 14:27:48', NULL),
(11, 'arteke', 'vorderukki@gufum.com', '$2y$10$LPRDdv86bhhFntlCjpzjc.YTPp1VNLuWo3CNL.4dYdinXW2g2IatS', '', 1, '2025-04-23 12:01:00', NULL),
(12, 'aerte', 'polmopaydu@gufum.com', '$2y$10$I4GlxVHB08yvC0fNFYwDrejU6kO0hsS72B2pxygsqx6sBxMEnEy2W', '', 1, '2025-04-23 12:11:02', NULL),
(13, 'aerte', 'juspuyigna@gufum.com', '$2y$10$VYJOh35xztINfk6/QhuqTOsuJLul4UrkEhxkR9ci7wO2ia8LVs0vC', '', 1, '2025-04-23 12:15:35', NULL),
(14, 'aerte', 'filmuburtu@gufum.com', '$2y$10$G1T0TzQ0jHxGW8P7dGNbVuwz4SQA0C2gMxRO77ZBu6zJSzi6D2zSi', '', 1, '2025-04-23 12:21:09', NULL),
(15, '123456', 'tufyevakki@gufum.com', '$2y$10$nlR5NwcIPbyiMSjmPBBQ3ub71zNm1nKB0KsCtzKUTyIUUWVzl7HCi', '', 1, '2025-04-23 12:35:55', NULL);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
