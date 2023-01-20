<?php

// контроллер для товаров, добавленных в корзину
namespace app\controllers;
use app\models\Cart;
use app\models\Order;
use app\models\User;
use shop\App;

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

    public function viewAction()
    {
        $this->setMeta('Корзина товаров');
    }

    public function checkoutAction()
    {
        if (!empty($_POST)) {
            // регистрация пользователя, если не авторизован
            if (!User::checkAuth()) {
                $user = new User();
                $user->load();
                if (!$user->validate($user->attributes) || !$user->checkUnique()) {
                    $user->getErrors();
                    $_SESSION['form_data'] = $user->attributes;
                    redirect();
                } else {
                    $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                    if (!$user_id = $user->save('user')) {
                        $_SESSION['errors'] = 'Ошибка регистрации';
                        redirect();
                    }
                }
            }

            // сохраняем заказ
            $data['user_id'] = $user_id ?? $_SESSION['user']['id'];
            $data['note'] = post('note');
            $user_email = $_SESSION['user']['email'] ?? post('email');
            
            if (!$order_id = Order::saveOrder($data)) {
                $_SESSION['errors'] = 'Ошибка оформления заказа';
            } else {
                Order::mailOrder($order_id, $user_email, 'mail_order_user');
                Order::mailOrder($order_id, App::$app->getProrerty('admin_email'), 'mail_order_admin');
                unset($_SESSION['cart']);
                unset($_SESSION['cart.sum']);
                unset($_SESSION['cart.qty']);
                $_SESSION['success'] = 'Спасибо за ваш заказ. В ближайшее время с вами свяжется менеджер для согласования заказа';
            }
        }
        redirect();
    }

}

?>