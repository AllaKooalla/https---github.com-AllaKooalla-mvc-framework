<?php

// контроллер для поиска
namespace app\controllers;
use app\models\Search;
use shop\App;
use shop\Pagination;

/** @property Search $model */
class SearchController extends AppController
{
    public function indexAction()
    {
        $s = get('s', 's');
        $page = get('page');
        $perpage = App::$app->getProrerty('pagination');
        $total = $this->model->get_count_find_products($s);
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $products = $this->model->get_find_products($s, $start, $perpage);
        $this->setMeta('Поиск');
        $this->set(compact('s', 'products', 'pagination', 'total'));
    }
}

?>