<?php

// контролле для странички одного выбранного товара
namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Product;

/** @property Product $model */
class ProductController extends AppController
{
    public function viewAction()
    {
        $product = $this->model->get_product($this->route['slug']);

        if (!$product)
        {
            // throw new \Exception("Товар по запросу {$this->route['slug']} не найден", 404);
            $this->error_404();
            return;
        }
        // debug($product);

        $breadcrumbs = Breadcrumbs::getBreadcrumbs($product['category_id'], $product['title']);

        $gallery = $this->model->get_gallery($product['id']);
        $this->setMeta($product['title'], $product['description'], $product['keywords']);
        $this->set(compact('product', 'gallery', 'breadcrumbs'));
    }
}

?>