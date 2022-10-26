<?php

// общий бозовый класс, от которого наследуются все остальные контроллеры
namespace shop;

// от абстрактного класса нельзя создать объект
abstract class Controller
{
    public array $data = [];
    // чтобы из контроллера в шаблон передать метаданные страницы
    public array $meta = ['title' => '', 'description' => '', 'keywords' => ''];
    // хранит шаблон, который может не подключать верстку, если нужны только данные
    public false|string $layout = '';
    public string $view = '';
    public object $model;

    public function __construct(public $route = [])
    {
        
    }

    public function getModel()
    {
        // модель называется по имени контроллера
        $model = 'app\models\\' . $this->route['admin_prefix'] . $this->route['controller'];
        if (class_exists($model))
        {
            $this->model = new $model;
        }
    }

    // метод проверяет, не определялся ли вид
    // если он определялся, то название вида берется из названия action
    public function getView()
    {
        $this->view = $this->view ?: $this->route['action'];
        (new View($this->route, $this->layout, $this->view, $this->meta))->render($this->data);
    }

    // метод для заполнения массива $data
    public function set($data)
    {
        $this->data = $data;
    }

    public function setMeta($title ='', $description = '', $keywords = '')
    {
        $this->meta = [
            'title' => $title, 
            'description' => $description, 
            'keywords' => $keywords,
        ];
    }

    // метод проверяет, является ли запрос AJAX
    public function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function loadView($view, $vars =[])
    {
        extract($vars);
        $prefix = str_replace('\\' , '/', $this->route['admin_prefix']);
        require APP . "/views/{$prefix}{$this->route['controller']}/{$view}.php";
        die;
    }
}

?>