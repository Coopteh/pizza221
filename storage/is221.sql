-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 22 2025 г., 10:16
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
  `created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `fio`, `address`, `phone`, `email`, `all_sum`, `created`) VALUES
(1, 'Иванов Иван Иванович', 'г. Москва, ул. Ленина, д. 15, кв. 42', '79161234567', 'example@mail.ru', 6050, '2025-04-08 12:28:06'),
(2, 'Иванов Иван Иванович', 'г. Москва, ул. Ленина, д. 15, кв. 42', '79161234567', 'hitrucetru@gufum.com', 6050, '2025-04-08 12:28:43'),
(3, 'Иванов Иван Иванович', 'г. Москва, ул. Ленина, д. 15, кв. 42', '79161234567', 'hitrucetru@gufum.com', 0, '2025-04-08 12:30:22'),
(4, 'Иванов Иван Иванович', 'г. Москва, ул. Ленина, д. 15, кв. 42', '79161234567', 'hitrucetru@gufum.com', 3300, '2025-04-08 12:34:09'),
(5, 'Иванов Иван Иванович', 'г. Москва, ул. Ленина, д. 15, кв. 42', '79161234567', 'example@mail.ru', 4400, '2025-04-15 10:54:54'),
(6, 'Иванов Иван Иванович', 'г. Москва, ул. Ленина, д. 15, кв. 42', '79161234567', 'hitrucetru@gufum.com', 4400, '2025-04-15 10:55:08'),
(7, 'Иванов Иван Иванович', 'г. Москва, ул. Ленина, д. 15, кв. 42', '79161234567', 'restunafye@gufum.com', 8650000, '2025-04-22 11:48:26');

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
(1, 1, 1, 11, 550, 6050),
(2, 2, 1, 11, 550, 6050),
(3, 4, 1, 6, 550, 3300),
(4, 5, 1, 8, 550, 4400),
(5, 6, 1, 8, 550, 4400),
(6, 7, 1, 12, 650000, 7800000),
(7, 7, 2, 5, 170000, 850000);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image`, `price`, `created`, `updated`) VALUES
(1, 'Дубай У 3.0 Monolit сталь, Monolit серый', 'Просторный и очень удобный угловой диван Дубай станет стильным акцентом в Вашей гостиной и любимым местом для отдыха в кругу семьи и друзей. Его широкое сиденье и мягкие подушки с комфортом разместят даже большую компанию.\r\n\r\n\r\nНадежный механизм трансформации еврокнижка сделает Дубай достойной альтернативой традиционной кровати. В основании дивана размещены большие и удобные бельевые ящики.\r\n\r\n\r\nПродуманная конструкция дивана Дубай приятно порадует Вас. Широкие подлокотники имеют вставки из МДФ, благодаря чему их очень удобно использовать в качестве столика, а в одном из подлокотников размещены удобные полки для необходимых мелочей. Теперь Ваш телефон или любимая книга будут всегда под рукой.\r\n\r\nУниверсальный угол - положение угла клиент определяет при сборке.', 'https://localhost/pizza221/assets/images/diwan.jpg', 650000, '2025-04-08 09:20:30', '2025-04-22 11:23:46'),
(2, 'Кровать Scarlett 200х200 см Ткань: Рогожка (Тетра Молочный)', 'Внешний вид\r\nКровать Scarlett — утонченная и одновременно функциональная мягкая кровать в стиле «американская классика» идеально впишется в ваш интерьер. А все потому, что американский стиль взял все самое лучшее от разных направлений и способен удовлетворить запросы каждого. Роскошное изголовье с объемной пиковкой в форме симметричных квадратов однозначно станет центром внимания любой спальни.\r\n\r\nМягкие царги и углы у изножья обеспечивают безопасность от травм при использовании. А высокие опоры и просвет над полом облегчают уборку для создания чистоты и комфорта в вашей спальне.\r\n\r\nМатериалы\r\nБольшой выбор различных вариантов обивки из мебельных тканей высочайшего качества и экокожи класса «люкс» позволит подобрать кровать на любой вкус. Дополнительно изголовье может быть декорировано стразами. Обратная сторона кровати обита тем же материалом, что и сама кровать.\r\n\r\nГарантия\r\nот 1,5 до 10 лет (подробнее)\r\nДанная гарантия действует на мебель, выпущенную после 04.05.2021 г.', 'https://localhost/pizza221/assets/images/bed.webp', 170000, '2025-04-08 09:20:30', '2025-04-22 11:29:07');

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
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `token`, `is_verified`, `created_at`, `address`, `phone`) VALUES
(1, 'Дамболдор', 'example@mail.ru', '$2y$10$EtMb4O3E5evxt.2H01Ou0uCu93M//W81CuSU6HExAYjnU/O.jMEOe', '459abdbd9cecdfc1cf2a4f93d27ea529', 0, '2025-04-15 11:22:12', NULL, NULL),
(2, 'НикиткаzxcSSSSkaneki', 'sorkecirza@gufum.com', '$2y$10$.INMkWvuTVtmVHD0pO//0eGcKtml/E6o7Q5tr3NrOGRgtEUa2ofKW', '', 1, '2025-04-21 14:52:06', NULL, NULL),
(3, 'Лудоманыч', 'restunafye@gufum.com', '$2y$10$GzYeEUH.JIM7guoVjqHYzue9ZM5N2hSocb.HXYUT5SeRjAJSZOtQ6', '', 1, '2025-04-22 11:45:18', NULL, NULL),
(4, 'Лудоманыч', 'gumlujorzo@gufum.com', '$2y$10$Flu43s9LoKKSMWmb./NQXeWKeomvhtD3.7bt4c/LCIn4zsx/5/8Ka', 'aed5f3f8b390c3743daca077a7eea914', 0, '2025-04-22 14:29:04', NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
