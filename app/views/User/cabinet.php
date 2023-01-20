<?php
/** @var $this \shop\View */
?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active">Кабинет</li>
        </ol>
    </nav>
</div>

<div class="container py-3">
    <div class="row">

        <div class="col-12">
            <h1 class="section-title">Кабинет</h1>
        </div>

        <?php $this->getPart('parts/cabinet_sidebar'); ?>

        <div class="col-md-9 order-md-1">
            <ul class="list-unstyled">
                <li><a href="user/orders">Заказы</a></li>
                <li><a href="user/files">Файлы</a></li>
                <li><a href="user/credentials">Учетные данные</a></li>
                <li><a href="user/logout">Выход</a></li>
            </ul>
        </div>
    </div>
</div>
