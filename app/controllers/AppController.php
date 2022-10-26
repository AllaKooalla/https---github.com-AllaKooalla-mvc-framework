<?php

// общий класс, наследуется от основного контроллера ядра,
//  от него будут наследоватьвся все контроллеры, чтобы избежать повторения кода

namespace app\controllers;
use app\models\AppModel;
use shop\App;
use shop\Controller;

class AppController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();
        
    }
}

?>