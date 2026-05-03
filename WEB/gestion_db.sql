-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 08 2026 г., 00:04
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
-- База данных: `gestion_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `added_date`) VALUES
(19, 1, 1, 5, '2026-04-08 00:01:56'),
(18, 1, 3, 1, '2026-04-08 00:01:56');

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `manufacturer_id` smallint(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `description` text NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `available` smallint(1) NOT NULL DEFAULT 1,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `manufacturer_id`, `name`, `alias`, `short_description`, `description`, `price`, `image`, `available`, `meta_keywords`, `meta_description`, `meta_title`) VALUES
(1, 1, 'Регистрация бизнеса', 'registraciya-biznesa', 'Регистрация ООО и ИП под ключ от 3 дней', 'Полное сопровождение регистрации бизнеса', 999999.00, 'biznes.jpg', 1, 'регистрация, бизнес, ООО, ИП', 'Регистрация бизнеса под ключ', 'Регистрация бизнеса - Гестион'),
(2, 1, 'Представительство в суде', 'predstavitelstvo-v-sude', 'Защита интересов в судах всех инстанций', 'Профессиональная защита в суде', 15000.00, 'sood1.jpg', 1, 'суд, адвокат, представительство', 'Представительство в суде', 'Представительство в суде - Гестион'),
(3, 1, 'Юридическая консультация', 'uridicheskaya-konsultaciya', 'Бесплатная первичная консультация', 'Квалифицированная юридическая помощь', 1500.00, 'uslugi.jpg', 1, 'консультация, юрист, право', 'Юридическая консультация', 'Юридическая консультация - Гестион');

-- --------------------------------------------------------

--
-- Структура таблицы `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `product_properties`
--

CREATE TABLE `product_properties` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `property_name` varchar(255) NOT NULL,
  `property_value` varchar(255) NOT NULL,
  `property_price` decimal(20,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `reg_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `reg_date`) VALUES
(1, 'Синев Данила', 'groxa8701@gmail.com', '+79029332830', '$2y$10$.PTi6ht0k.kFHFNQJnr76OHSlpH1HIjcwrjxThyWQGIi.750Azptu', '2026-04-06 18:26:40');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product_properties`
--
ALTER TABLE `product_properties`
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
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `product_properties`
--
ALTER TABLE `product_properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
