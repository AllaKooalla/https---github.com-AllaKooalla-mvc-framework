<?php


namespace app\models\admin;


use app\models\AppModel;
use RedBeanPHP\R;

class Product extends AppModel
{

    public function get_products($start, $perpage): array
    {
        return R::getAll("SELECT p.*, pd.title FROM product p JOIN product_description pd on p.id = pd.product_id LIMIT $start, $perpage");
    }

    public function get_downloads($q): array
    {
        $data = [];
        $downloads = R::getAssoc("SELECT download_id, name FROM download_description WHERE name LIKE ? LIMIT 10", ["%{$q}%"]);
        if ($downloads) {
            $i = 0;
            foreach ($downloads as $id => $title) {
                $data['items'][$i]['id'] = $id;
                $data['items'][$i]['text'] = $title;
                $i++;
            }
        }
        return $data;
    }
}