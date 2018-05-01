<?php
/*
#####################################
#  ShopOS: Shopping Cart Software.
#  Copyright (c) 2008-2010
#  http://www.shopos.ru
#  http://www.shoposs.com
#  Ver. 1.0.0
#####################################
*/

define('HEADING_TITLE', 'Импорт');
define('IMPORT_STEP', 'Шаг');
define('IMPORT_UPDATE', 'Товар обновлён');
define('IMPORT_DELETE', 'Товар удален');
define('IMPORT_INSERT', 'Добавлен товар');
define('IMPORT_TAB', 'Табуляция');
define('IMPORT_ENCODING', 'Кодировка файла:');

define('IMPORT_TEXT1', 'Выберите CSV файл, из которого вы хотели бы загрузить данные:');
define('IMPORT_PAGE2_TEXT1', 'В закачанном файле обнаружены следующие колонки.
Соотнесите каждую из этих колонок с полем в базе данных.
В левой колонке указаны названия столбцов.
<br>
Если продукт есть и в базе, и в файле (ищется совпадение по колонке идентификации), то обновить информацию о нем.
Если же продукт найден только в файле, то добавить его в базу данных.
Иначе (если продукт есть только в базе данных) оставить его без изменений.
<br>');

define('IMPORT_PAGE2_FILENAME', 'Название файла:');
define('IMPORT_PAGE2_FILESIZE', 'Размер файла:');
define('IMPORT_STATUS', 'Статус');
define('IMPORT_ACTION', 'action');
define('IMPORT_EAN', 'Штрих-код товара');
define('IMPORT_ID', 'ID страницы');
define('IMPORT_MODEL', 'Артикул');
define('IMPORT_NAME', 'Наименование');
define('IMPORT_PRICE', 'Цена');
define('IMPORT_PAGE_URL', 'ЧПУ URL товара');
define('IMPORT_IMAGE', 'Фотография');
define('IMPORT_QUANTITY', 'Количество товара');
define('IMPORT_DESCRIPTION', 'Полное описание');
define('IMPORT_SHORT_DESCRIPTION', 'Краткое описание');
define('IMPORT_WEIGHT', 'Вес товара');
define('IMPORT_DATE_ADDED', 'Дата добавления');
define('IMPORT_SORT', 'Сортировка');
define('IMPORT_MANUFACTURERS_NAME', 'Название производителя');


?>