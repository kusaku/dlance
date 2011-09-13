<link rel="stylesheet" href="/templates/admin/steal/960.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="/templates/admin/steal/template.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="/templates/admin/steal/colour.css" type="text/css" media="screen" charset="utf-8">
<?=validation_errors()?>
<form action="" method="post">
			<div id="content" class="container_16 clearfix">
				<div class="grid_16">
					<h2>Настройка рейтинга</h2>
					<p class="error">Форма настройки рейтинга.</p>
				</div>

				<div class="grid_3">
					<p>
						<label for="title">Авторизация</label>
						<input type="text" name="auth" maxlength="16" value="<?=$auth?>">
					</p>
				</div>

				<div class="grid_3">
					<p>
						<label for="title">Отправка сообщения</label>
						<input type="text" name="send_message" maxlength="16" value="<?=$send_message?>">
					</p>
				</div>

				<div class="grid_3">
					<p>
						<label for="title">Получение сообщения</label>
						<input type="text" name="receipt_message" maxlength="16" value="<?=$receipt_message?>">
					</p>
				</div>

				<div class="grid_3">
					<p>
						<label for="title">Увеличение баланса</label>
						<input type="text" name="plus_balance" maxlength="16" value="<?=$plus_balance?>">
					</p>
				</div>

				<div class="grid_3">
					<p>
						<label for="title">Уменьшение баланса</label>
						<input type="text" name="minus_balance" maxlength="16" value="<?=$minus_balance?>">
					</p>
				</div>

				<div class="grid_3">
					<p>
						<label for="title">Продажа дизайна</label>
						<input type="text" name="sell_design" maxlength="16" value="<?=$sell_design?>">
					</p>
				</div>

				<div class="grid_3">
					<p>
						<label for="title">Покупка дизайна</label>
						<input type="text" name="buy_design" maxlength="16" value="<?=$buy_design?>">
					</p>
				</div>

				<div class="grid_3">
					<p>
						<label for="title">Отправка отзыва(+)</label>
						<input type="text" name="add_positive_review" maxlength="16" value="<?=$add_positive_review?>">
					</p>
				</div>


				<div class="grid_3">
					<p>
						<label for="title">Отправка отзыва(-)</label>
						<input type="text" name="add_negative_review" maxlength="16" value="<?=$add_negative_review?>">
					</p>
				</div>

				<div class="grid_3">
					<p>
						<label for="title">Получение отзыва(+)</label>
						<input type="text" name="receipt_positive_review" maxlength="16" value="<?=$receipt_positive_review?>">
					</p>
				</div>

				<div class="grid_3">
					<p>
						<label for="title">Получение отзыва(-)</label>
						<input type="text" name="receipt_negative_review" maxlength="16" value="<?=$receipt_negative_review?>">
					</p>
				</div>

				<div class="grid_3">
					<p>
						<label for="title">Добавление дизайна</label>
						<input type="text" name="add_design" maxlength="16" value="<?=$add_design?>">
					</p>
				</div>

				<div class="grid_16">
					<p class="submit">
						<input value="Сбросить" type="reset">
						<input value="Сохранить" type="submit">
					</p>
				</div>
			</div>
</form>