<?php


namespace app\controllers\admin;


use app\models\admin\User;
use app\models\AppModel;
use RedBeanPHP\R;
use shop\App;
use shop\Controller;

class AppController extends Controller
{

    public false|string $layout = 'admin';

    public function __construct($route)
    {
        parent::__construct($route);

        if (!User::isAdmin() && $route['action'] != 'login-admin') {
            redirect(ADMIN . '/user/login-admin');
        }

        new AppModel();

        $categories = R::getAssoc("SELECT c.*, cd.* FROM category c 
                        JOIN category_description cd
                        ON c.id = cd.category_id");
        App::$app->setProrerty("categories", $categories);
    }

}

?>