<?php

// класс подключения к БД
namespace shop;

use RedBeanPHP\R;

class Db
{
    // использует паттерн TSingleton, то есть от его можно создать только один объект
    use TSingleton;

    // конструктор приватный, чтобы нельзя было использовать создание через new
    private function __construct()
    {
        $db = require_once CONFIG . '/config_db.php';
        R::setup($db['dsn'], $db['user'], $db['password']);
        if(!R::testConnection())
        {
            throw new \Exception('No connection DB', 500);
        }
        // заморозить модификацию БД
        R::freeze(true);
        if (DEBUG)
        {
            // выведет sql запрос, если включена отладка
            R::debug(true, 3);
        }
        
        R::ext('xdispense', function( $type ){
            return R::getRedBean()->dispense( $type );
        });
    }
}

?>