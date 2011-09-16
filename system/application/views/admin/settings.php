<link rel="stylesheet" href="/templates/admin/steal/960.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="/templates/admin/steal/template.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="/templates/admin/steal/colour.css" type="text/css" media="screen" charset="utf-8">
<?=validation_errors()?>
<form action="" method="post">
			<div id="content" class="container_16 clearfix">
				<div class="grid_16">
					<h2>Настройки</h2>
					<p class="error">Настройки сервиса.</p>
				</div>

				<div class="grid_8">
					<p>
						<label for="title">Заголовок <small>Максимальное количество символов 255.</small></label>
						<input type="text" name="title" maxlength="255" value="<?=$title?>">
					</p>
				</div>

				<div class="grid_8">
					<p>
						<label for="title">Название сайта <small>Максимальное количество символов 64.</small></label>
						<input type="text" name="site" value="<?=$site?>">
					</p>
				</div>

				<div class="grid_4">
					<p>
						<label for="title">Период добавления отзыва</label>
<select name="reviews_add">
<option value="1"<? if( $reviews_add == 1 ): ?> selected="selected"<? endif; ?>>1 час</option>
<option value="2"<? if( $reviews_add == 2 ): ?> selected="selected"<? endif; ?>>2 часа</option>
<option value="24"<? if( $reviews_add == 24 ): ?> selected="selected"<? endif; ?>>1 день</option>
<option value="48"<? if( $reviews_add == 48 ): ?> selected="selected"<? endif; ?>>2 дня</option>
<option value="168"<? if( $reviews_add == 168 ): ?> selected="selected"<? endif; ?>>1 неделя</option>
<option value="336"<? if( $reviews_add == 336 ): ?> selected="selected"<? endif; ?>>2 недели</option>
</select>
					</p>
				</div>

				<div class="grid_4">
					<p>
						<label for="title">Период загрузки</label>
<select name="download_period">
<option value="1"<? if( $download_period == 1 ): ?> selected="selected"<? endif; ?>>1 час</option>
<option value="2"<? if( $download_period == 2 ): ?> selected="selected"<? endif; ?>>2 часа</option>
<option value="24"<? if( $download_period == 24 ): ?> selected="selected"<? endif; ?>>1 день</option>
<option value="48"<? if( $download_period == 48 ): ?> selected="selected"<? endif; ?>>2 дня</option>
<option value="168"<? if( $download_period == 168 ): ?> selected="selected"<? endif; ?>>1 неделя</option>
<option value="336"<? if( $download_period == 336 ): ?> selected="selected"<? endif; ?>>2 недели</option>
</select>
					</p>
				</div>

				<div class="grid_4">
					<p>
						<label>Модерация</label>
<select name="moder">
<option value="0"<? if( $moder == 0 ): ?> selected="selected"<? endif; ?>>Выключена</option>
<option value="1"<? if( $moder == 1 ): ?> selected="selected"<? endif; ?>>Включена</option>
</select>

					</p>
				</div>

				<div class="grid_16">
					<p>
						<label>Краткое описание <small>Максимальное количество символов 255.</small></label>
						<textarea name="description"><?=$description?></textarea>
					</p>
				</div>

				<div class="grid_16">
					<p>
						<label>Ключевые слова <small>Максимальное количество символов 10000.</small></label>
						<textarea name="keywords"><?=$keywords?></textarea>
					</p>
					<p class="submit">
						<input value="Сбросить" type="reset">
						<input value="Сохранить" type="submit">
					</p>
				</div>
			</div>
</form>