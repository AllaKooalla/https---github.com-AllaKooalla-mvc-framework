<?php

// контроллер для товаров, добавленных в корзину
namespace app\controllers;
use app\models\Cart;

/** @property Cart $model */
class CartController extends AppController
{
    public function addAction(): bool
    {
        $id = get('id');
        $qty = get('qty');

        if (!$id)
        {
            return false;
        }

        // получаем данные о продукте
        $product = $this->model->get_product($id);
        if (!$product)
        {
            return false;
        }

        $this->model->add_to_cart($product, $qty);
        if ($this->isAjax())
        {
            $this->loadView('cart_modal');
        }
        redirect();
        return true;
        
    }

    public function showAction()
    {
        $this->loadView('cart_modal');
    }

    public function deleteAction()
    {
        $id = get('id');
        if (isset($_SESSION['cart'][$id]))
        {
            $this->model->delete_item($id);
        }
        if ($this->isAjax())
        {
            $this->loadView('cart_modal');
        }
        redirect();
    }

    public function clearAction()
    {
        if (empty($_SESSION['cart']))
        {
            return false;
        }
        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.sum']);
        $this->loadView('cart_modal');
        return true;
    }
}

?>