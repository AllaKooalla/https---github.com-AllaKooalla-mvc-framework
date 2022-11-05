<?php

// модель для страницы категорий товаров
namespace app\models;

use RedBeanPHP\R;
use shop\App;

class Category extends AppModel
{
    public function get_category($slug): array
    {
        return R::getRow("SELECT c.*, cd.* FROM category c JOIN category_description cd on c.id = cd.category_id WHERE c.slug = ?", [$slug]);
    }

    public function getIds($id): string
    {
        $categories = App::$app->getProrerty('categories');
        // рукурсией ищем id вложенной категории
        $ids = '';
        foreach ($categories as $k => $v) {
            if ($v['parent_id'] == $id) {
                $ids .= $k . ',';
                $ids .= $this->getIds($k);
            }
        }
        return $ids;
    }

    public function get_products($ids, $start, $perpage): array
    {
        // белый список, в нем перечислены всезначения, которые сравниваются со значениями, пришедшими от клиента
        $sort_values = [
            'title_asc' => 'ORDER BY title ASC',
            'title_desc' => 'ORDER BY title DESC',
            'price_asc' => 'ORDER BY price ASC',
            'price_desc' => 'ORDER BY price DESC',
        ];
        $order_by = '';
        if (isset($_GET['sort']) && array_key_exists($_GET['sort'], $sort_values))
        {
            $order_by = $sort_values[$_GET['sort']];
        }
        return R::getAll("SELECT p.*, pd.* FROM product p JOIN product_description pd on p.id = pd.product_id WHERE p.status = 1 AND p.category_id IN ($ids) $order_by LIMIT $start, $perpage");
    }

    // метод считает количество товаров в категории
    public function get_count_products($ids): int
    {
        return R::count('product', "category_id IN ($ids) AND status = 1");
    }
}

?>