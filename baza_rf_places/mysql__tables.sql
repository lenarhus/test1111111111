-- --------------------------------------------------------

--
-- Структура таблицы `bazac_rf_place`
--

CREATE TABLE IF NOT EXISTS `bazac_rf_place` (
  `place_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID населенного пункта.',
  `fias_aoguid` varchar(36) NOT NULL COMMENT 'ФИАС GUID',
  `custom` smallint(6) DEFAULT '0' COMMENT 'Пометка о том, что запись создана вручную. 0 - запись из базы ФИАС, 1 - запись созданная нашим модулем.',
  `name` varchar(128) NOT NULL COMMENT 'Название населенного пункта.',
  `level` smallint(6) NOT NULL COMMENT 'Уровень адресного объекта',
  `type` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Тип населенного пункта: 1 - регион/край, 2 - район, 3 - город, 4 - населенный пункт, 5 - улица, 6 - дом',
  `place_type_name_id` int(11) NOT NULL COMMENT 'Id названия типа объекта: город, село, пгт и т.п.',
  `parent_place_id` bigint(20) DEFAULT NULL COMMENT 'Родительский элемент',
  `region_place_id` bigint(20) DEFAULT NULL COMMENT 'Родительский регион элемента',
  `postal_code` int(11) DEFAULT NULL COMMENT 'Почтовый индекс',
  `is_region_center` smallint(6) DEFAULT '0' COMMENT 'Населенный пункт является центром региона',
  `is_center` smallint(6) DEFAULT '0' COMMENT 'Населенный пункт является центром региона или района',
  PRIMARY KEY (`place_id`),
  UNIQUE KEY `bazac_rf_place_fias_aoguid_key` (`fias_aoguid`),
  KEY `bazac_rf_place_custom_idx` (`custom`),
  KEY `bazac_rf_place_fias_aoguid_idx` (`fias_aoguid`),
  KEY `bazac_rf_place_id_idx` (`place_id`),
  KEY `bazac_rf_place_level_idx` (`level`),
  KEY `bazac_rf_place_parent_center_idx` (`parent_place_id`,`is_center`),
  KEY `bazac_rf_place_parent_idx` (`parent_place_id`),
  KEY `bazac_rf_place_parent_name_idx` (`parent_place_id`,`name`),
  KEY `bazac_rf_place_parent_postal_idx` (`parent_place_id`,`postal_code`),
  KEY `bazac_rf_place_parent_type_idx` (`parent_place_id`,`type`),
  KEY `bazac_rf_place_postal_idx` (`postal_code`),
  KEY `bazac_rf_place_region_center_idx` (`region_place_id`,`is_region_center`),
  KEY `bazac_rf_place_type_idx` (`type`),
  KEY `bazac_rf_place_type_name_idx` (`place_type_name_id`),
  KEY `bazac_rf_place_type_name_postal_idx` (`place_type_name_id`,`postal_code`),
  KEY `bazac_rf_place_type_postal_idx` (`type`,`postal_code`),
  KEY `place_type_name_id` (`place_type_name_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Справочник данных о населенных пунктах России';

-- --------------------------------------------------------

--
-- Структура таблицы `bazac_rf_place_postal_code`
--

CREATE TABLE IF NOT EXISTS `bazac_rf_place_postal_code` (
  `place_postal_code_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID записи.',
  `postal_code` int(11) NOT NULL COMMENT 'Почтовый индекс н.п.',
  `place_id` bigint(20) NOT NULL COMMENT 'ID населенного пункта к которому относится почтовый индекс',
  PRIMARY KEY (`place_postal_code_id`),
  UNIQUE KEY `bazac_rf_place_postal_code_postal_key` (`postal_code`),
  KEY `bazac_rf_place_postal_code_place_id_idx` (`place_id`),
  KEY `bazac_rf_place_postal_code_postal_idx` (`postal_code`),
  KEY `place_id` (`place_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `bazac_rf_place_coordinates`
--

CREATE TABLE IF NOT EXISTS `bazac_rf_place_coordinates` (
  `place_coordinates_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID записи.',
  `place_id` bigint(20) NOT NULL COMMENT 'ID населенного пункта',
  `latitude` numeric(10,6) NOT NULL COMMENT 'Широта',
  `longitude` numeric(10,6) NOT NULL COMMENT 'Долгота',
  `ym_geocode` varchar(1024) NOT NULL COMMENT 'Атрибут GeocoderMetaData->text объекта, который вернул API Яндекс.Карт',
  PRIMARY KEY (`place_coordinates_id`),
  UNIQUE KEY `bazac_rf_place_coordinates_key` (`place_id`),
  KEY `bazac_rf_place_coordinates_place_id_idx` (`place_id`),
  KEY `place_id` (`place_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `bazac_rf_place_type_name`
--

CREATE TABLE IF NOT EXISTS `bazac_rf_place_type_name` (
  `place_type_name_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID записи.',
  `level` smallint(6) NOT NULL COMMENT 'Уровень типа н.п. согласно ФИАС',
  `code` smallint(6) NOT NULL COMMENT 'Код типа н.п. согласно ФИАС',
  `name` varchar(32) NOT NULL COMMENT 'Сокращенное название типа н.п.',
  `full_name` varchar(128) DEFAULT NULL COMMENT 'Полное название типа н.п.',
  `alt_name` varchar(32) DEFAULT NULL COMMENT 'Альтернативный вариант сокращенного названия типа н.п.',
  `after_place_name` smallint(6) NOT NULL DEFAULT '0' COMMENT 'В названии н.п. указывать тип после имени н.п.',
  PRIMARY KEY (`place_type_name_id`),
  UNIQUE KEY `bazac_rf_place_place_type_name_code_key` (`code`),
  KEY `bazac_rf_place_place_type_name_id_idx` (`place_type_name_id`),
  KEY `bazac_rf_place_place_type_name_name_idx` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Справочник данных о почтовых индексах городов и населенных п';

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bazac_rf_place`
--
ALTER TABLE `bazac_rf_place`
  ADD CONSTRAINT `fk_bazac_rf_place-bazac_rf_place_type_name` FOREIGN KEY (`place_type_name_id`) REFERENCES `bazac_rf_place_type_name` (`place_type_name_id`);

--
-- Ограничения внешнего ключа таблицы `bazac_rf_place_postal_code`
--
ALTER TABLE `bazac_rf_place_postal_code`
  ADD CONSTRAINT `fk_bazac_rf_place_postal_code-bazac_rf_place` FOREIGN KEY (`place_id`) REFERENCES `bazac_rf_place` (`place_id`);

--
-- Ограничения внешнего ключа таблицы `bazac_rf_place_coordinates`
--
ALTER TABLE `bazac_rf_place_coordinates`
  ADD CONSTRAINT `fk_bazac_rf_place_coordinates-bazac_rf_place` FOREIGN KEY (`place_id`) REFERENCES `bazac_rf_place` (`place_id`);
