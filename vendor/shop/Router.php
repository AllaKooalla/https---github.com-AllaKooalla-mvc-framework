<?php

// маршрутизатор
// отвечает за вызов контроллера, соответствующего запрошенному url-адресу
namespace shop;

use Exception;

class Router
{

    // таблица маршрутов
    protected static array $routes =[];
    // один конкретный маршрут, с которым было найдено соответствие
    protected static array $route =[];

    // через метод будем добавлять данные в таблицу
    // принимает регулярное выражение и маршрут
    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    // возвращает таблицу маршрутов
    public static function getRoutes() : array
    {
        return self::$routes;
    }

    // возвращает конкрутный маршрут, который был найден
    public static function getRoute() : array
    {
        return self::$route;
    }

    // отделяте от url адреса параметры
    protected static function removeQueryString($url)
    {
        if ($url)
        {
            $params = explode('&', $url, 2);
            // debug($params);
            if (false === str_contains($params[0], '='))
            {
                return rtrim($params[0], '/');
            }
        }
        return '';
    }

    // вызывается из класса App
    public static function dispatch($url)
    {
        $url = self::removeQueryString($url);
        if(self::matchRoute($url))
        {
            $controller = 'app\controllers\\' . self::$route['admin_prefix'] . self::$route['controller'] . 'Controller';
            if (class_exists($controller))
            {
                // указали, что $controllerObject является объектом класса Controller
                /** @var Controller $controllerObject */
                // создаем экземпляр контроллера
                $controllerObject = new $controller(self::$route);

                $controllerObject->getModel();

                $action = self::lowerCamelCase(self::$route['action'] . 'Action');
                if (method_exists($controllerObject, $action))
                {
                    $controllerObject->$action();
                    // получение вью после действия, чтобы вью можно было переопределить
                    // вид (вью) находится в папке с названием контроллера и файл назван как action
                    $controllerObject->getView();
                } else
                {
                    throw new Exception("Метод {$controller}::{$action} не найден", 404);
                }
            } else
            {
                throw new Exception("Контроллер {$controller} не найден", 404);
            }
        } else
        {
            throw new Exception("Страница не найдена", 404);
        }
    }

    // ищет соотвестсиве в адресной стоке с регулярным выражением 
    public static function matchRoute($url): bool
    {
        foreach (self::$routes as $pattern => $route)
        {
            if (preg_match("#{$pattern}#", $url, $matches))
            {
                foreach ($matches as $k => $v)
                {
                    if (is_string($k))
                    {
                        $route[$k] = $v;
                    }
                }
                if (empty($route['action']))
                {
                    $route['action'] = 'index';
                }
                if(!isset($route['admin_prefix']))
                {
                    $route['admin_prefix'] = '';
                } else
                {
                    $route['admin_prefix'] .= '\\';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    // переводит из вида контроллера в адресной строке  [controller] => product-key к виду ProductKey
    // к стандартному обозначению классов
    protected static function upperCamelCase($name): string
    {
        // product-key => product key
        $name = str_replace('-', ' ', $name);
        // product key => Product Key
        $name = ucwords($name);
        // Product Key => ProductKey
        return str_replace(' ', '', $name);
    }

    // переводит из вида экшена в адресной строке  [action] => sony-view к виду sonyView
    // к стандартному обозначению методов
    protected static function lowerCamelCase($name): string
    {
        return lcfirst(self::upperCamelCase($name));
    }


}

?>