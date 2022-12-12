<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active">Регистрация</li>
        </ol>
    </nav>
</div>

<div class="container py-3">
    <div class="row">

        <div class="col-lg-12 category-content">
            <h1 class="section-title">Регистрация</h1>

            <form class="row g-3" method="post">

                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" value="<?= get_field_value('email') ?>">
                        <label class="required" for="email">E-mail</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control" id="password" placeholder="password">
                        <label class="required" for="password">Пароль</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?= get_field_value('name') ?>">
                        <label class="required" for="name">Имя</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" name="address" class="form-control" id="address" placeholder="Address" value="<?= get_field_value('address') ?>">
                        <label class="required" for="address">Адрес</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <button type="submit" class="btn btn-danger">Зарегистрироваться</button>
                </div>
            </form>

            <?php 
            if (isset($_SESSION['form_data']))
            {
                unset($_SESSION['form_data']);
            } 
            ?>

        </div>
    </div>
</div>

