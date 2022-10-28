<?php

// модель странички товара
namespace app\models;

use RedBeanPHP\R;

class Product extends AppModel
{
    // метод получает один выбранный продук, где $slug - его имя в адресной строке, берется из БД
    public function get_product($slug): array
    {
        return R::getRow("SELECT p.*, pd.* FROM product p JOIN product_description pd on p.id = pd.product_id WHERE p.status = 1 AND p.slug = ?", [$slug]);
    }

    // метод для отображения картинок в странике товара
    public function get_gallery($product_id): array
    {
        return R::getAll("SELECT * FROM product_gallery WHERE product_id = ?", [$product_id]);
    }
}

?>