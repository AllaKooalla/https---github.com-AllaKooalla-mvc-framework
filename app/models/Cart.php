<?php

// модель карточки товаров
namespace app\models;

use RedBeanPHP\R;

class Cart extends AppModel
{
    // метод получает продукт и возвращает массив строк
    public function get_product($id): array
    {
        return R::getRow("SELECT p.*, pd.* FROM product p JOIN product_description pd on p.id = pd.product_id WHERE p.status = 1 AND p.id = ?", [$id]);
    }

    // метод добавления в корзину
    public function add_to_cart($product, $qty = 1)
    {
        $qty = abs($qty);

        // если цифровой товар есть в корзине, то false
        if ($product['is_download'] && isset($_SESSION['cart'][$product['id']]))
        {
            return false;
        }

        // товар не цифровой и он уже есть в корзине, то прибовляем его количество к qty
        if (isset($_SESSION['cart'][$product['id']]))
        {
            $_SESSION['cart'][$product['id']]['qty'] += $qty;
        } else
        {
            // если товар цифровой, то можно добавить в корзину только 1 штуку
            if ($product['is_download'])
            {
                $qty = 1;
            }
            $_SESSION['cart'][$product['id']] = [
                'title' => $product['title'],
                'slug' => $product['slug'],
                'price' => $product['price'],
                'qty' => $qty,
                'img' => $product['img'],
                'is_download' => $product['is_download'],
            ];
        }
        // если корзина не пуста, то прибавим к количеству qty, а если пуста, то просто запишем qty
        // qty - количество товаров
        $_SESSION['cart.qty'] = !empty($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;
        // sum - сумма всех товаров
        $_SESSION['cart.sum'] = !empty($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qty * $product['price'] : $qty * $product['price'];
        return true;
    }

    // метод удаляет одну позицию в модельном окне корзины товаров
    public function delete_item($id)
    {
        $qty_minus = $_SESSION['cart'][$id]['qty'];
        $sum_minus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];
        $_SESSION['cart.qty'] -= $qty_minus;
        $_SESSION['cart.sum'] -= $sum_minus;
        unset($_SESSION['cart'][$id]);
    }


    /*Array
(
    [product_id] => Array
        (
            [qty] => QTY
            [title] => TITLE
            [price] => PRICE
            [img] => IMG
        )
    [product_id] => Array
        (
            [qty] => QTY
            [title] => TITLE
            [price] => PRICE
            [img] => IMG
        )
    )
    [cart.qty] => QTY,
    [cart.sum] => SUM
*/
}

?>