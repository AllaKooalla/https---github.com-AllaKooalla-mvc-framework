<?php
use shop\View;

/** @var $this View */
?>

<!-- страница найденный товаров через поиск -->

<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb bg-light p-2">
            <li class="breadcrumb-item"><a href=""><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item">Поиск</li>
		</ol>
	</nav>
</div>


<div class="container py-3">
	<div class="row">

		<div class="col-lg-12 category-content">
			<h1 class="section-title">Поиск</h1>

            <h4>Поиск по: <?= h($s); ?></h4>

			<div class="row">
				<?php if (!empty($products)): ?>
				<?php $this->getPart('parts/products_loop', compact('products')); ?>

				<div class="row">
					<div class="col-md-12">
						<p>
							<?= count($products) ?> товара(ов) из <?= $total ?>
						</p>
						<?php if ($pagination->countPages > 1): ?>
						<?= $pagination ?>
							<?php endif; ?>
					</div>
				</div>

				<?php else: ?>
				<p>По запросу ничего не найдено...</p>
				<?php endif; ?>
			</div>


		</div>

	</div>
</div>