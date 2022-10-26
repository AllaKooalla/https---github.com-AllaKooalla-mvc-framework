<?php

// правила для маршрутизатора, хранит таблицу маршрутов

use shop\Router;

// в регулярных выражениях более конкретные правила пишутся выше более общих
// для админки отдельный маршрут
Router::add('^admin/?$', ['controller' => 'Main', 'action' => 'index', 'admin_prefix' => 'admin']);
Router::add('^admin/(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)/?$', ['admin_prefix' => 'admin']);
// маршрут для карточек продуктов
Router::add('^product/(?P<slug>[a-z0-9-]+)/?$', ['controller' => 'Product', 'action' => 'view']);
// главная страница
// ^ - начало строки, $ - конец строки (регулярные выражения)
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
// в массиве появятся ключи controller и action
// то есть из адресной строки http://mvc-framework/контроллер/действие
Router::add('^(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)/?$');

?>