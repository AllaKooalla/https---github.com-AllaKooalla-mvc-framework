<?php
use shop\View;

/** @var $this View */
?>

<!-- страница категорий товаров -->

<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb bg-light p-2">
			<?= $breadcrumbs ?>
		</ol>
	</nav>
</div>


<div class="container py-3">
	<div class="row">

		<div class="col-lg-12 category-content">
			<h3 class="section-title">
				<?= $category['title'] ?>
			</h3>

			<?php if (!empty($category['content'])): ?>
                <div class="category-desc">
                    <?= $category['content'] ?>
                </div>
                <hr>
            <?php endif; ?>

			<?php if (!empty($products)): ?>
			<div class="row">
				<div class="col-sm-6">
					<div class="input-group mb-3">
						<label class="input-group-text" for="input-sort">Сортировка:</label>
						<select class="form-select" id="input-sort">
							<option selected="" disabled>По умолчанию</option>
							<option value="sort=title_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'title_asc')

		            echo 'selected' ?>>Название (А - Я)</option>
							<option value="sort=title_desc" <?php if (isset($_GET['sort']) &&
	            	$_GET['sort'] == 'title_desc') echo 'selected' ?>>Название (Я - А)</option>
							<option value="sort=price_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'price_asc')

		            echo 'selected' ?>>Цена (низкая > высокая)</option>
							<option value="sort=price_desc" <?php if (isset($_GET['sort']) &&
	            	$_GET['sort'] == 'price_desc') echo 'selected' ?>>Цена (высокая > низкая)</option>
						</select>
					</div>
				</div>
			</div>
			<?php endif; ?>

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
				<p>В этой категории товаров пока нет...</p>
				<?php endif; ?>
			</div>


		</div>

	</div>
</div>