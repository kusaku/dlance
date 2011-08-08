<link rel="stylesheet" href="/templates/admin/steal/960.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="/templates/admin/steal/template.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="/templates/admin/steal/colour.css" type="text/css" media="screen" charset="utf-8">
<?=validation_errors()?>
<form action="" method="post">
			<div id="content" class="container_16 clearfix">
				<div class="grid_16">
					<h2>Добавить тариф</h2>
					<p class="error">Форма добавления тарифов.</p>
				</div>

				<div class="grid_16">
					<p>
						<label for="title">Название <small>Максимальное количество символов 16.</small></label>
						<input type="text" name="name" maxlength="16" value="<?=set_value('name')?>">
					</p>
				</div>

				<div class="grid_4">
					<p>
						<label for="title">Стоимость в месяц</label>
						<input type="text" name="price_of_month" maxlength="16" value="<?=set_value('price_of_month')?>">
					</p>
				</div>

				<div class="grid_4">
					<p>
						<label for="title">Стоимость в год</label>
						<input type="text" name="price_of_year" maxlength="16" value="<?=set_value('price_of_year')?>">
					</p>
				</div>

				<div class="grid_4">
					<p>
						<label for="title">Комиссия</label>
						<input type="text" name="commission" maxlength="16" value="<?=set_value('commission')?>">
					</p>
				</div>

				<div class="grid_4">
					<p>
						<label for="title">Минимальная сумма</label>
						<input type="text" name="minimum_w_a" maxlength="16" value="<?=set_value('minimum_w_a')?>">
					</p>
				</div>

				<div class="grid_16">
					<p class="submit">
						<input value="Сбросить" type="reset">
						<input value="Добавить" type="submit">
					</p>
				</div>
			</div>
</form>