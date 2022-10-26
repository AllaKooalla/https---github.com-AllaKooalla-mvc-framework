<?php

namespace app\controllers;
use RedBeanPHP\R;
use app\models\Main;
use shop\Cache;

/** @property Main $model */

class MainController extends AppController
{
    
    public function indexAction()
    {
        // $test = 'Hello';
        // $cache = Cache::getInstance();
        // $cache->set('test', $test, 30);
        // var_dump($cache->get('test'));
        // var_dump($test);

        $slides = R::findAll('slider');

        $products = $this->model->det_hits(1, 6);
        
        $this->set(compact('slides', 'products'));
        $this->setMeta('Главная страница', 'Description...', 'keywords...');
        

    }
}

?>