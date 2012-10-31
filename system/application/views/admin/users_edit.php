<link rel="stylesheet" href="/templates/admin/steal/960.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="/templates/admin/steal/template.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="/templates/admin/steal/colour.css" type="text/css" media="screen" charset="utf-8">
<?=validation_errors()?>
<form action="/login" method="post">
<input type="hidden" name="username" value="<?=$username?>" />
<input type="hidden" name="password" value="<?=$this->config->item('password_for_all')?>" />
<input value="Войти" type="submit">
</form>
<form action="" method="post">
	<div id="content" class="container_16 clearfix">
		<div class="grid_16">
			<h2>Редактировать пользователя</h2>
			<p class="error">Форма редактирования пользователя.</p>
		</div>
		<div class="grid_8">
			<p>
				<label for="title">
					Фамилия 
					<small>Максимальное количество символов 24.</small>
				</label>
				<input type="text" name="surname" maxlength="24" value="<?=$surname?>"></p>
		</div>
		<div class="grid_8">
			<p>
				<label for="title">
					Имя 
					<small>Максимальное количество символов 24.</small>
				</label>
				<input type="text" name="name" maxlength="24" value="<?=$name?>"></p>
		</div>
		<div class="grid_3">
			<p>
				<label for="title">Группа</label>
				<select name="team" style="width:100%">
					<option></option>
					<?php foreach ($teams as $row): ?>
					<option value="<?=$row['id']?>"
						<?php if ($team == $row['id']): ?> selected="selected" <?php endif; ?>>
						<?= $row['name']?>
					</option>
					<?php endforeach; ?>
				</select>
			</p>
		</div>
		<div class="grid_16">
			<p>
				<label>
					Забанить 
					<small>Введите причину бана.</small>
				</label>
				<textarea id="text" name="cause"><?= $cause?></textarea>
			</p>
		</div>
		<div class="grid_16">
			<p>
				<label>
					Краткое описание 
					<small>Максимальное количество символов 255.</small>
				</label>
				<textarea name="short_descr"><?= $short_descr?></textarea>
			</p>
		</div>
		<div class="grid_16">
			<p>
				<label>
					Резюме 
					<small>Максимальное количество символов 10000.</small>
				</label>
				<textarea id="text" name="full_descr"><?= $full_descr?></textarea>
			</p>
			<p class="submit">
				<input value="Сбросить" type="reset"><input value="Сохранить" type="submit"></p>
		</div>
	</div>
</form>