-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 25 2025 г., 04:57
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
-- База данных: `pizzais`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `fio` varchar(120) NOT NULL,
  `addres` mediumtext NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(120) NOT NULL,
  `all_sum` float NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `fio`, `addres`, `phone`, `email`, `all_sum`, `created`, `payment_method`) VALUES
(1, 'Гончаров Денис Алибабаевич', '12222222222', '79130758655', 'soborovets@gmail.com', 529, '2025-04-08 07:45:45', 'sbp'),
(2, 'Гончаров Денис Алибабаевич', '12222222222', '79130758655', 'soborovets@gmail.com', 529, '2025-04-08 07:46:38', 'sbp'),
(3, 'Гвоздиков Данил Александрович', 'Тухочевского 32', '79999999999', 'soborovets@gmail.com', 1865, '2025-04-08 07:50:14', 'sbp'),
(4, 'Буланов Семён Димка', 'Тухочевского 32', '89130758655', 'soborovets@gmail.com', 967, '2025-04-08 07:55:17', 'card'),
(5, 'Гончаров Денис Алибабаевич', 'Тухочевского 32', '89333009978', 'sdafdas@gmail.com', 529, '2025-04-17 12:26:55', 'card'),
(6, 'Гончаров Денис Алибабаевич', 'Тухочевского 32', '89333009978', 'sdafdas@gmail.com', 356, '2025-04-17 12:30:42', 'sbp'),
(7, 'Гончаров Денис Алибабаевич', 'Тухочевского 32', '89333009978', 'soborovets@gmail.com', 1436, '2025-04-19 10:46:09', 'sbp');

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
(12, 5, 2, 1, 529, 529),
(13, 6, 4, 1, 137, 137),
(14, 6, 11, 1, 219, 219),
(15, 7, 1, 1, 469, 469),
(16, 7, 7, 1, 549, 549),
(17, 7, 9, 1, 199, 199),
(18, 7, 11, 1, 219, 219);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(120) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(120) NOT NULL,
  `price` float NOT NULL,
  `category` varchar(120) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime NOT NULL DEFAULT current_timestamp(),
  `new_id` int(11) DEFAULT NULL,
  `new_id1` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image`, `price`, `category`, `created`, `updated`, `new_id`, `new_id1`) VALUES
(1, 'Мясная с аджикой', 'Баварские колбаски , острый соус аджика, острые колбаски чоризо , цыпленок , пикантная пепперони , моцарелла, фирменный томатный соус', '/assets/image/1.png', 469, 'pizza', '2025-04-07 09:08:44', '2025-04-07 09:08:44', 1, NULL),
(2, 'Диабло', 'Острые колбаски чоризо , острый перец халапеньо , соус барбекю, митболы из говядины , томаты, моцарелла, фирменный томатный соус', '/assets/image/2.png', 529, 'pizza', '2025-04-07 09:10:16', '2025-04-07 09:10:16', 2, NULL),
(3, 'Кола-барбекю', 'Пряная говядина , пикантная пепперони , острые колбаски чоризо , соус кола-барбекю, моцарелла, фирменный томатный соус', '/assets/image/3.png', 479, 'pizza', '2025-04-07 09:12:12', '2025-04-07 09:12:12', 3, NULL),
(4, 'Картошка Фри', 'Хрустящяя, золотистая Картошка Фри', '/assets/image/4.png', 137, 'snack', '2025-04-07 09:13:14', '2025-04-07 09:13:14', 4, NULL),
(5, 'Добрый Кола', 'Сладкая газировка 1л', '/assets/image/5.png', 120, 'drink', '2025-04-07 09:13:14', '2025-04-07 09:13:14', 5, NULL),
(6, 'Сырный Соус', 'Мега СЫЫЫРНЫЙ!!! соус', '/assets/image/6.png', 70, 'sauce', '2025-04-07 09:13:14', '2025-04-07 09:13:14', 6, NULL),
(7, 'Ветчина и сыр', 'Ветчина , моцарелла, фирменный соус альфред', '/assets/image/7.png', 549, 'pizza', '2025-04-07 09:13:14', '2025-04-07 09:13:14', 7, NULL),
(8, 'Баварский ланчбокс', 'Цельные креветки в хрустящей панировке', '/assets/image/8.png', 199, 'snack', '2025-04-07 09:13:14', '2025-04-07 09:13:14', 8, NULL),
(9, 'Креветки', 'Цельные креветки в хрустящей панировке', '/assets/image/9.png', 199, 'snack', '2025-04-07 09:13:14', '2025-04-07 09:13:14', 9, NULL),
(10, 'Супермясной Додстер', 'Горячая закуска с цыпленком, моцареллой, митболами, острыми колбасками чоризо и соусом бургер в тонкой пшеничной лепешке', '/assets/image/10.png', 219, 'snack', '2025-04-07 09:13:14', '2025-04-07 09:13:14', 10, NULL),
(11, 'Морс Черная смородина', 'Фирменный ягодный морс из натуральной душистой черной смородины Дизайн товара может отличаться', '/assets/image/11.png', 219, 'drink', '2025-04-07 09:13:14', '2025-04-07 09:13:14', 11, NULL),
(12, 'Чесночный', 'Фирменный соус с чесночным вкусом для бортиков пиццы и горячих закусок, 25 г', '/assets/image/12.png', 70, 'sauce', '2025-04-07 09:13:14', '2025-04-07 09:13:14', 12, NULL),
(13, 'Малиновое варенье', 'Идеально к сырникам, но у нас их нет XD 25 г', '/assets/image/13.png', 70, 'sauce', '2025-04-07 09:13:14', '2025-04-07 09:13:14', 13, NULL);

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
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `token`, `is_verified`, `created_at`, `address`, `phone`, `avatar`) VALUES
(1, 'Dinis', 'dinis@gmail.com', '$2y$10$O5DJ5D8a3SzJQ3Xxcr.rr.SFwbBRS0z.1O5Yf0lYkTFh/JOQDwVAq', '521533ad2d5e2014173e876a7fa4af87', 0, '2025-04-21 09:51:20', NULL, NULL, NULL),
(24, 'syoma', 'sustogista@gufum.com', '$2y$10$SabBqms4/EGA4TykFnF7Y.oibEIfcvyewpJlix5tACGkfyCAFrESm', '662b61e0833268d9e333ebb3f4bfa241', 0, '2025-04-22 07:57:42', NULL, NULL, NULL),
(25, 'syoma', 'kerkabidro@gufum.com', '$2y$10$E8UM5cpixIHEV1AXoseuG.7ldeHRGF7jmJblHGDo1etz7I0ZG5SWy', '', 1, '2025-04-22 07:57:59', NULL, NULL, NULL),
(26, 'gsaibers', 'soborovets@gmail.com', '$2y$10$NN.gpA5o9Og8opoDnywzZ.9ABNxl2YlPACC.OxP9vyxQBfC.ATP8y', '', 1, '2025-04-22 10:27:59', 'Тухочевского 32', '89999999999', '/assets/uploads/avatar_6809eb50843b69.38614178.png');

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
