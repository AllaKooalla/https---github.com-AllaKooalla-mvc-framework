<!-- Default box -->
<div class="card">


    <div class="card-body">

        <?php if (!empty($downloads)): ?>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Наименование</th>
                    <th>Оригинальное имя</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($downloads as $download): ?>
                    <tr>
                        <td>
                            <?= $download['name'] ?>
                        </td>
                        <td>
                            <?= $download['original_name'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-12">
                    <p><?= count($downloads) ?> файл(ов) из: <?= $total; ?></p>
                    <?php if ($pagination->countPages > 1): ?>
                        <?= $pagination; ?>
                    <?php endif; ?>
                </div>
            </div>

        <?php else: ?>
            <p>Файлов для загрузки не найдено...</p>
        <?php endif; ?>

    </div>
</div>
<!-- /.card -->



