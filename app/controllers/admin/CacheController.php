<?php


namespace app\controllers\admin;


use shop\Cache;

class CacheController extends AppController
{

    public function indexAction()
    {
        $title = 'Управление кэшем';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title'));
    }

    public function deleteAction()
    {
        $cache_key = get('cache', 's');
        $cache = Cache::getInstance();
        if ($cache_key == 'category') {
            $cache->delete("ishop_menu");
        }
        if ($cache_key == 'page') {
            $cache->delete("ishop_page_menu");

        }
        $_SESSION['success'] = 'Выбранный кэш удален';
        redirect();
    }

}