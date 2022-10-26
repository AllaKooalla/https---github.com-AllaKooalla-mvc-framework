<?php
use shop\App;
use shop\Router;

// фронт контроллер, отсюда идет запрос на конкретный контроллер приложения
// запросы пользователя проходят тут для безопасности

if (PHP_MAJOR_VERSION < 8) 
{
    die('Необходима версия PHP >= 8');
}

require_once dirname(__DIR__) . '/config/init.php';
require_once HELPERS . '/functions.php';
require_once CONFIG . '/routes.php';


new App();

// debug(Router::getRoutes());

// throw new Exception('Возникла ошибка', 404);

?>
