-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 14 Kas 2023, 01:22:16
-- Sunucu sürümü: 10.4.24-MariaDB
-- PHP Sürümü: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `mertkayn_hotelcase`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `oda_ozellik_tanim`
--

CREATE TABLE `oda_ozellik_tanim` (
  `ozellik_id` int(11) NOT NULL,
  `ozellik_adi` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `oda_ozellik_tanim`
--

INSERT INTO `oda_ozellik_tanim` (`ozellik_id`, `ozellik_adi`) VALUES
(7, 'Jakuzi'),
(6, 'Mini Mutfak'),
(5, 'Klima'),
(8, 'Minibar'),
(9, 'Balkon'),
(10, 'Deniz Manzarası'),
(11, 'Havuz Manzarası'),
(12, 'Bağlantılı Odalar'),
(13, 'Oturma Grubu'),
(14, 'Termal Su');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `oteller`
--

CREATE TABLE `oteller` (
  `otel_id` int(11) NOT NULL,
  `otel_adi` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `otel_aktif` enum('0','1') COLLATE utf8_unicode_ci DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `oteller`
--

INSERT INTO `oteller` (`otel_id`, `otel_adi`, `otel_aktif`) VALUES
(1, 'Can\'s Hotel', '1'),
(4, 'Mert\'s Hotel', '1'),
(5, 'Rabia\'s Hotel', '1'),
(22, 'Anıl Deneme', '1'),
(17, 'Bervin\'s Hotel', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `otel_oda_ozellik`
--

CREATE TABLE `otel_oda_ozellik` (
  `id` int(11) NOT NULL,
  `ozellik_id` int(11) DEFAULT NULL,
  `otel_id` int(11) DEFAULT NULL,
  `oda_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `otel_oda_ozellik`
--

INSERT INTO `otel_oda_ozellik` (`id`, `ozellik_id`, `otel_id`, `oda_id`) VALUES
(11, 8, 1, 13),
(10, 7, 1, 13),
(9, 6, 1, 12),
(8, 5, 1, 12),
(12, 9, 1, 13),
(96, 14, 22, 57),
(95, 11, 22, 57),
(94, 5, 22, 57),
(86, 12, 22, 56),
(85, 10, 22, 56),
(84, 8, 22, 56),
(83, 7, 22, 56);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `otel_oda_tanim`
--

CREATE TABLE `otel_oda_tanim` (
  `oda_id` int(11) NOT NULL,
  `otel_id` int(11) DEFAULT NULL,
  `oda_adi` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `satis_durum` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sil_durum` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `oda_aktif` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `otel_oda_tanim`
--

INSERT INTO `otel_oda_tanim` (`oda_id`, `otel_id`, `oda_adi`, `satis_durum`, `sil_durum`, `oda_aktif`) VALUES
(13, 1, 'Standart Karışık Oda', '1', '0', '1'),
(12, 1, 'Ultra Lüks Karışık Oda', '1', '0', '1'),
(7, 4, 'V.I.P. Oda', '0', '0', '1'),
(8, 4, 'Ultra Lüks Oda', '0', '0', '1'),
(9, 5, 'Standart Oda', '0', '0', '1'),
(10, 17, 'Özel oda', '0', '0', '1'),
(11, 17, 'Suit Oda', '0', '0', '1'),
(56, 22, 'Ultra Lüks Oda', '1', '0', '1'),
(57, 22, 'Standart Oda', '1', '0', '1');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `oda_ozellik_tanim`
--
ALTER TABLE `oda_ozellik_tanim`
  ADD PRIMARY KEY (`ozellik_id`);

--
-- Tablo için indeksler `oteller`
--
ALTER TABLE `oteller`
  ADD PRIMARY KEY (`otel_id`);

--
-- Tablo için indeksler `otel_oda_ozellik`
--
ALTER TABLE `otel_oda_ozellik`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `otel_oda_tanim`
--
ALTER TABLE `otel_oda_tanim`
  ADD PRIMARY KEY (`oda_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `oda_ozellik_tanim`
--
ALTER TABLE `oda_ozellik_tanim`
  MODIFY `ozellik_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Tablo için AUTO_INCREMENT değeri `oteller`
--
ALTER TABLE `oteller`
  MODIFY `otel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Tablo için AUTO_INCREMENT değeri `otel_oda_ozellik`
--
ALTER TABLE `otel_oda_ozellik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- Tablo için AUTO_INCREMENT değeri `otel_oda_tanim`
--
ALTER TABLE `otel_oda_tanim`
  MODIFY `oda_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
