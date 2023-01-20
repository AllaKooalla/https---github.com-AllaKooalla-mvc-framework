<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="user/cabinet">Кабинет</a></li>
            <li class="breadcrumb-item active">Просмотр заказа</li>
        </ol>
    </nav>
</div>

<div class="container py-3">
    <div class="row">

        <div class="col-12">
            <h1 class="section-title">Просмотр заказа</h1>
        </div>

        <?php $this->getPart('parts/cabinet_sidebar'); ?>

        <div class="col-md-9 order-md-1">

            <?php if (!empty($orders)): ?>

                <div class="table-responsive">
                    <table class="table text-start table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Номер заказа</th>
                            <th scope="col">Статус</th>
                            <th scope="col">Итоговая сумма</th>
                            <th scope="col">Создан</th>
                            <th scope="col">Обновлен</th>
                            <th scope="col"><i class="far fa-eye"></i></a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr <?php if ($order['status']) echo 'class="table-info"' ?>>
                                <td><?= $order['id'] ?></td>
                                <td>Статус <?php $order['status']; ?></td>
                                <td>$<?= $order['total'] ?></td>
                                <td><?= $order['created_at'] ?></td>
                                <td><?= $order['updated_at'] ?></td>
                                <td><a href="user/order?id=<?= $order['id'] ?>"><i class="far fa-eye"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <p><?=count($orders)?> заказ(а/ов) из <?=$total;?></p>
                        <?php if($pagination->countPages > 1): ?>
                            <?=$pagination;?>
                        <?php endif; ?>
                    </div>
                </div>

            <?php else: ?>
                <p>Вы пока не делали заказов</p>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php
