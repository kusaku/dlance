<link rel="stylesheet" href="/templates/admin/steal/960.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="/templates/admin/steal/template.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="/templates/admin/steal/colour.css" type="text/css" media="screen" charset="utf-8">
<?= validation_errors()?>
<?= show_tinimce('text')?>
<form action="" method="post">
	<div id="content" class="container_16 clearfix">
		<div class="grid_16">
			<h2>Добавить категорию</h2>
			<p class="error">Форма добавления категорий.</p>
		</div>
		<div class="grid_16">
			<p>
				<label for="title">
					Название 
					<small>Максимальное количество символов 25.</small>
				</label>
				<input type="text" name="name" maxlength="24" value="<?=set_value('name')?>"></p>
			<p class="submit">
				<input value="Сбросить" type="reset"><input value="Добавить" type="submit"></p>
		</div>
	</div>
</form>