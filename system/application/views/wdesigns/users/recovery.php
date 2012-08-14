<div class="registrationForm">
	<?=validation_errors()?>
	<h1 class="title"><a href="/recovery">Восстановление пароля</a></h1>
	<br/>
	<div id="passrecover" class="rnd">
		<h2>Чтобы восстановить пароль, выполните нижеследуюшее предписание</h2>
		<form action="" method="post">
		<ol>
			<li>Введите ваш логин и email</li>
			<li>Вы получите сообщение на ваш email адрес с ссылкой в теле письма. Кликните на нее, чтобы войти</li>
			<li>Затем, войдите в ваш профиль и установите новый пароль</li>
		</ol>
		<fieldset>
			<label for="email">Ваш Логин: </label><br/>
			<input type="text" class="text" name="username" value="<?=set_value('username')?>" size="20" maxlength="15" />
		</fieldset>
		<fieldset>
			<label for="email">Ваш email: </label><br/>
			<input id="email" type="text" class="text" name="email" value="<?=set_value('email')?>" size="20" maxlength="48" />
		</fieldset>
		<input value="Отправить" type="submit" class="reg-submit"/>
		</form>
	</div>
</div>