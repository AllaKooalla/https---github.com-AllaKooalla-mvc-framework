<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="user/cabinet">Кабинет</a></li>
            <li class="breadcrumb-item"><a href="user/orders">Список заказов</a></li>
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

            <?php if (!empty($order)): ?>
                <div class="table-responsive">
                    <table class="table text-start table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Наименование</th>
                            <th scope="col">Цена</th>
                            <th scope="col">Количество</th>
                            <th scope="col">Сумма</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($order as $item): ?>
                            <tr>
                                <td><a href="product/<?= $item['slug'] ?>"><?= $item['title'] ?></a></td>
                                <td>$<?= $item['price'] ?></td>
                                <td><?= $item['qty'] ?></td>
                                <td>$<?= $item['sum'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="box">
                    <h3 class="box-title">Детали заказа</h3>
                    <div class="box-content">
                        <div class="table-responsive">
                            <table class="table text-start table-striped">
                                <tr>
                                    <td>Номер заказа</td>
                                    <td><?= $order[0]['order_id'] ?></td>
                                </tr>
                                <tr>
                                    <td>Статус</td>
                                    <td>Статус <?php $order[0]['status']; ?></td>
                                </tr>
                                <tr>
                                    <td>Создан</td>
                                    <td><?= $order[0]['created_at'] ?></td>
                                </tr>
                                <tr>
                                    <td>Обновлен</td>
                                    <td><?= $order[0]['updated_at'] ?></td>
                                </tr>
                                <tr>
                                    <td>Итоговая сумма</td>
                                    <td>$<?= $order[0]['total'] ?></td>
                                </tr>
                                <tr>
                                    <td>Примечание</td>
                                    <td><?= $order[0]['note'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>


            <?php endif; ?>

        </div>
    </div>
</div>

