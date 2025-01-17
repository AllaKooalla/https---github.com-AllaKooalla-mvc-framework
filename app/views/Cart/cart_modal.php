<!-- модальное окно корзины товаров, открывается из хедера -->
<div class="modal-body">
    <?php if (!empty($_SESSION['cart'])): ?>
    <div class="table-responsive cart-table">
        <table class="table text-start">
            <thead>
                <tr>
                    <th scope="col">Фото</th>
                    <th scope="col">Товар</th>
                    <th scope="col">Кол-во</th>
                    <th scope="col">Цена</th>
                    <th scope="col"><i class="far fa-trash-alt"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                <tr>
                    <td>
                        <a href="product/<?= $item['slug'] ?>"><img src="<?= PATH . $item['img'] ?>" alt=""></a>
                    </td>
                    <td><a href="product/<?= $item['slug'] ?>"><?= $item['title'] ?></a></td>
                    <td><?= $item['qty'] ?></td>
                    <td>$<?= $item['price'] ?></td>
                    <td><a href="cart/delete?id=<?= $id ?>" data-id="<?= $id ?>" class="del-item"><i class="far fa-trash-alt"></i></a></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" class="text-end">Итого:</td>
                    <td class="cart-qty"><?= $_SESSION['cart.qty'] ?></td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end">Сумма:</td>
                    <td class="cart-sum">$<?= $_SESSION['cart.sum'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <h4 class="text-start">Корзина пуста</h4>
    <?php endif; ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success ripple" data-bs-dismiss="modal">Продолжить покупки</button>
    <?php if (!empty($_SESSION['cart'])): ?>
    <a href="cart/view" class="btn btn-primary">Оформить заказ</a>
    <button type="button" id="clear-cart" class="btn btn-danger">Очистить корзину</button>
    <?php endif; ?>
</div>