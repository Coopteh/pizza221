-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 07 2025 г., 11:19
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
  `name` varchar(120) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(120) NOT NULL,
  `price` float NOT NULL,
  `category` varchar(120) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image`, `price`, `category`, `created`, `updated`) VALUES
(2, 'Мясная с аджикой', 'Баварские колбаски , острый соус аджика, острые колбаски чоризо , цыпленок , пикантная пепперони , моцарелла, фирменный томатный соус', '/assets/image/1.png', 469, 'pizza', '2025-04-07 09:08:44', '2025-04-07 09:08:44'),
(3, 'Диабло', 'Острые колбаски чоризо , острый перец халапеньо , соус барбекю, митболы из говядины , томаты, моцарелла, фирменный томатный соус', '/assets/image/2.png', 529, 'pizza', '2025-04-07 09:10:16', '2025-04-07 09:10:16'),
(4, 'Кола-барбекю', 'Пряная говядина , пикантная пепперони , острые колбаски чоризо , соус кола-барбекю, моцарелла, фирменный томатный соус', '/assets/image/3.png', 479, 'pizza', '2025-04-07 09:12:12', '2025-04-07 09:12:12'),
(5, 'Картошка Фри', 'Хрустящяя, золотистая Картошка Фри', '/assets/image/4.png', 137, 'snack', '2025-04-07 09:13:14', '2025-04-07 09:13:14'),
(6, 'Добрый Кола', 'Сладкая газировка 1л', '/assets/image/5.png', 120, 'drink', '2025-04-07 09:13:14', '2025-04-07 09:13:14'),
(7, 'Сырный Соус', 'Мега СЫЫЫРНЫЙ!!! соус', '/assets/image/6.png', 70, 'sauce', '2025-04-07 09:13:14', '2025-04-07 09:13:14'),
(8, 'Ветчина и сыр', 'Ветчина , моцарелла, фирменный соус альфред', '/assets/image/7.png', 549, 'pizza', '2025-04-07 09:13:14', '2025-04-07 09:13:14'),
(9, 'Баварский ланчбокс', 'Цельные креветки в хрустящей панировке', '/assets/image/8.png', 199, 'snack', '2025-04-07 09:13:14', '2025-04-07 09:13:14'),
(10, 'Креветки', 'Цельные креветки в хрустящей панировке', '/assets/image/9.png', 199, 'snack', '2025-04-07 09:13:14', '2025-04-07 09:13:14'),
(11, 'Супермясной Додстер', 'Горячая закуска с цыпленком, моцареллой, митболами, острыми колбасками чоризо и соусом бургер в тонкой пшеничной лепешке', '/assets/image/10.png', 219, 'snack', '2025-04-07 09:13:14', '2025-04-07 09:13:14'),
(12, 'Морс Черная смородина', 'Фирменный ягодный морс из натуральной душистой черной смородины Дизайн товара может отличаться', '/assets/image/11.png', 219, 'drink', '2025-04-07 09:13:14', '2025-04-07 09:13:14'),
(13, 'Чесночный', 'Фирменный соус с чесночным вкусом для бортиков пиццы и горячих закусок, 25 г', '/assets/image/12.png', 70, 'sauce', '2025-04-07 09:13:14', '2025-04-07 09:13:14'),
(14, 'Малиновое варенье', 'Идеально к сырникам, но у нас их нет XD 25 г', '/assets/image/13.png', 70, 'sauce', '2025-04-07 09:13:14', '2025-04-07 09:13:14');

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
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
