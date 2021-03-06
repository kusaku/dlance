<link rel="stylesheet" href="/templates/admin/steal/960.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="/templates/admin/steal/template.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="/templates/admin/steal/colour.css" type="text/css" media="screen" charset="utf-8">
<?= validation_errors()?>
<?= show_tinimce('text')?>
<form action="" method="post">
	<div id="content" class="container_16 clearfix">
		<div class="grid_16">
			<h2>Редактировать новость</h2>
			<p class="error">Форма редактирования новостей.</p>
		</div>
		<div class="grid_16">
			<p>
				<label for="title">
					Заголовок 
					<small>Максимальное количество символов 64.</small>
				</label>
				<input type="text" name="title" maxlength="64" value="<?=$title?>"></p>
		</div>
		<div class="grid_16">
			<p>
				<label>
					Краткое описание 
					<small>Максимальное количество символов 255.</small>
				</label>
				<textarea name="descr"><?= $descr?></textarea>
			</p>
		</div>
		<div class="grid_16">
			<p>
				<label>
					Текст 
					<small>Максимальное количество символов 10000.</small>
				</label>
				<textarea id="text" name="text"><?= $text?></textarea>
			</p>
			<p class="submit">
				<input value="Сбросить" type="reset"><input value="Сохранить" type="submit"></p>
		</div>
	</div>
</form>