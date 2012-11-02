<?php if ($logged_in): ?>
<div class="userInfo">
	<div class="avatar <?=$tariff?>">
		<a href="/account" title="Перейти к портфолио <?=$username?>"></a>
		<img src="<?=$userpic?>" alt="<?=$username?> avi" />
	</div>
	<p>
		<a href="/account" class="name"><?= $username?></a>
		<br/>
		<?= $name?> <?= $surname?>
	</p>
	<p>
		<span>Рейтинг:</span>
		<span class="orange"><?= $rating?></span>
		<br/>
		<span>Баланс:</span>
		<a href="/account/balance/" class="orange"><?= $balance?> руб.</a>
	</p>
</div>
<div class="userPanel">
	<a href="/account/settings" class="settings">Настройки</a>
	<a href="/account">Мой кабинет</a>
	<a href="/contacts/" class="inbox"><span><?php if ($messages): ?><?= $messages?><?php else : ?>0 <?php endif; ?></span></a>
	<a href="/logout">Выход</a>
</div>
<?php else: ?>
<h3>Авторизация</h3>
<a href="/register" class="topReg">Регистрация</a>
<form class="topAuth" name="login" action="/login" method="post">
	<fieldset>
		<input name="username" size="12" maxlength="32" type="text" value="" placeholder="login" class="inputTopAuth"/><input name="password" size="12" maxlength="32" type="password" value="" placeholder="password" class="inputTopPass"/><input name="submit" type="submit" value="вход" class="submitLogin"/>
	</fieldset>
	<fieldset>
		<label for="remember">запомнить меня</label>
		<span class="niceCheck"><input name="rcookiettl" value="86400" type="checkbox"/></span><a href="/recovery" class="forgetPassword">забыли пароль?</a>
	</fieldset>
</form>
<?php endif; ?>