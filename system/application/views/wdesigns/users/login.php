<div class="loginForm">
	<h3>Вход в систему</h3>
	<div class="error">
		<?=validation_errors()?>
	</div>
	<form name="login" action="/login" method="post">
		<fieldset>
			<label for="rusername">Имя пользователя</label><br/>
			<input type="text" class="text" name="username" value="<?=set_value('username')?>" size="16" maxlength="15" />
		</fieldset>
		<fieldset>
			<label for="ruserpassword">Пароль</label><br/>
			<input type="password" class="password" name="password" size="16" maxlength="32" />
		</fieldset>
		<fieldset>
			<span class="niceCheck"><input type="checkbox" class="authcheckbox" name="rcookiettl"	value="86400" /></span>
			<label for="rcookiettl">Запомнить</label>
		</fieldset>
		<fieldset>
			<input class="auth-submit" name="submit" type="submit" value="Вход">
		</fieldset>
	</form>
</div>