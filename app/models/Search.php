<?php

// модель для поиска
namespace app\models;

use RedBeanPHP\R;

class Search extends AppModel
{
    // метод считает найденные товары для пагинации
    public function get_count_find_products($s): int
    {
        return R::getCell("SELECT COUNT(*) FROM product p JOIN product_description pd on p.id = pd.product_id WHERE p.status = 1 AND pd.title LIKE ?", ["%{$s}%"]);
    }

    public function get_find_products($s, $start, $perpage): array
    {
        return R::getAll("SELECT p.*, pd.* FROM product p JOIN product_description pd ON p.id = pd.product_id WHERE p.status = 1 AND pd.title LIKE ? LIMIT $start, $perpage", ["%{$s}%"]);
    }
}

?>