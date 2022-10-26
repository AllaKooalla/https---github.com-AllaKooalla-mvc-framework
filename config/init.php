<?php
// это файл конфигураций


// 1 - режим разработки, 0 - когда переносим на хостинг, там ошибки не показываются
define("DEBUG", 1);
// указывает на корневую папку
define("ROOT", dirname(__DIR__));
// константа хранит путь к публичной папке
define("WWW", ROOT . '/public');
// путь к папке приложения
define("APP", ROOT . '/app');
// путь к ядру
define("CORE", ROOT . '/vendor/shop');
define("HELPERS", ROOT . '/vendor/shop/helpers');
// путь к папке кэша
define("CACHE", ROOT . '/tmp/cache');
define("LOGS", ROOT . '/tmp/logs');
define("CONFIG", ROOT . '/config');
// шаблон сайта по умолчанию
define("LAYOUT", 'ishop');
// адрес сайта
define("PATH", 'http://mvc-framework');
// путь к админке
define("ADMIN", 'http://mvc-framework/admin');
// картинка по умолчанию, если ее нет у товара
define("NO_IMAGE", 'uploads/no_image.jpg');

// подключить автозагрузчик
require_once ROOT . '/vendor/autoload.php';

?>