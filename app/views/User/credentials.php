
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="user/cabinet">Кабинет</a></li>
            <li class="breadcrumb-item active">Учетные данные</li>
        </ol>
    </nav>
</div>

<div class="container py-3">
    <div class="row">

        <div class="col-12">
            <h1 class="section-title">Учетные данные</h1>
        </div>

        <?php $this->getPart('parts/cabinet_sidebar'); ?>

        <div class="col-md-9 order-md-1">

            <form class="row g-3" method="post">

                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" value="<?= h($_SESSION['user']['email']) ?>" disabled>
                        <label for="email">E-mail</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control" id="password" placeholder="password">
                        <label for="password">Пароль</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?= h($_SESSION['user']['name']) ?>" required>
                        <label for="name">Имя</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" name="address" class="form-control" id="addres" placeholder="Address" value="<?= h($_SESSION['user']['address']) ?>" required>
                        <label for="address">Адрес</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <button type="submit" class="btn btn-danger">Сохранить</button>
                </div>
            </form>

        </div>
    </div>
</div>


