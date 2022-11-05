<?php

// модель для главной страницы сайта
namespace app\models;
use RedBeanPHP\R;

class Main extends AppModel
{
    // метод выбора хит товаров на главной странице
    public function det_hits($lang, $limit): array
    {
        return R::getAll("SELECT p.*, pd.* FROM product p JOIN product_description pd on p.id = pd.product_id WHERE p.status = 1 AND p.hit = 1 LIMIT $limit");
    }

}

?>