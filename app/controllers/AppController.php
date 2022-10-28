<?php

// общий класс, наследуется от основного контроллера ядра,
//  от него будут наследоватьвся все контроллеры, чтобы избежать повторения кода

namespace app\controllers;
use app\models\AppModel;
use RedBeanPHP\R;
use shop\App;
use shop\Controller;

class AppController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();
        
        $categories = R::getAssoc("SELECT c.*, cd.* FROM category c JOIN category_description cd ON c.id = cd.category_id");
        App::$app->setProrerty('categories', $categories);
    }
}
?>