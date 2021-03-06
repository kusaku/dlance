<link rel="stylesheet" href="/templates/admin/steal/960.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="/templates/admin/steal/template.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="/templates/admin/steal/colour.css" type="text/css" media="screen" charset="utf-8">
<?=validation_errors()?>
<?=show_tinimce('text')?>
<?php if( !empty($error) ): ?><?=$error?><?php endif; ?>
<?php if( !empty($count) ): ?>
<strong>Всего отправлено <?=$count?> писем.</strong>
<?php endif; ?>
<form action="" method="post" enctype="multipart/form-data">
	<div id="content" class="container_16 clearfix">
		<div class="grid_16">
			<h2>Рассылка</h2>
			<p class="error">Форма для рассылки по пользователям.</p>
		</div>
		<div class="grid_16">
			<p>
				<label for="title">
					Заголовок 
					<small>Максимальное количество символов 64.</small>
				</label>
				<input type="text" name="title" maxlength="64" value="<?=set_value('title')?>"></p>
		</div>
		<div class="grid_16">
			<p>
				<label for="title">
					Файл 
					<small>Размер — до 100 Мб, Формат — ZIP, RAR.</small>
				</label>
				<input name="userfile" type="file" />
			</p>
		</div>
		<div class="grid_16">
			<p>
				<label>
					Текст 
					<small>Максимальное количество символов 10000.</small>
				</label>
				<textarea id="text" name="text"><?= set_value('text')?></textarea>
			</p>
			<p class="submit">
				<input value="Сбросить" type="reset"><input value="Отправить" type="submit"></p>
		</div>
	</div>
</form>

<?php if (! empty($mailer)): ?>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
	<tr>
		<td width="250px">Пользователь</td>
		<td>Email</td>
	</tr>
	<?php foreach ($mailer as $row): ?>
	<tr>
		<td>
			<a class="black" href="/user/<?=$row['username']?>">
				<?= $row['surname']?>
				<?= $row['name']?>
				(
				<?= $row['username']?>
				)</a>
		</td>
		<td>
			<?= $row['email']?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
<?php else: ?>
<p>Подписчиков не найдено.</p>
<?php endif; ?>