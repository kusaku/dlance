<link rel="stylesheet" href="/templates/admin/steal/960.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="/templates/admin/steal/template.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="/templates/admin/steal/colour.css" type="text/css" media="screen" charset="utf-8">
<?=validation_errors()?>
<form action="" method="post">
			<div id="content" class="container_16 clearfix">
				<div class="grid_16">
					<h2>Профиль</h2>
					<p class="error">Профиль администратора.</p>
				</div>

				<div class="grid_8">
					<p>
						<label for="title">Логин <small>Максимальное количество символов 50.</small></label>
						<input type="text" name="username" maxlength="50">
					</p>
				</div>

				<div class="grid_8">
					<p>
						<label for="title">Пароль <small>Максимальное количество символов 50.</small></label>
						<input type="password" name="password" maxlength="50">
					</p>
                    
				</div>

				<div class="grid_8">
					<p>
						<label for="title">Введите текущий пароль </label>
						<input type="text" name="current_password" maxlength="50">
					</p>
					<p class="submit">
						<input value="Сбросить" type="reset">
						<input value="Сохранить" type="submit">
					</p>
				</div>

			</div>
</form>