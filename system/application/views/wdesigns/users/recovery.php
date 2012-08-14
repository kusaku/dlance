<?=validation_errors()?>
<div class="yui-g">
<h1 class="title"><a href="/recovery">Восстановление пароля</a></h1>
<div class="subtitle"></div>
<div class="content">
<div id="passrecover" class="rnd">
<div>
<div>
<div>
<h3>Чтобы восстановить пароль, выполните нижеследуюшее предписание</h3>
<form action="" method="post">
<ul>
<li>1. Введите ваш логин и email</li>
<li>2. Вы получите сообщение на ваш email адрес с ссылкой в теле письма. Кликните на нее, чтобы войти</li>
<li>3. Затем, войдите в ваш профиль и установите новый пароль</li>
<li class="clearfix">
<label for="email">Ваш Логин: </label>
<input type="text" class="text" name="username" value="<?=set_value('username')?>" size="20" maxlength="15" />

<label for="email">Ваш email: </label>
<input id="email" type="text" class="text" name="email" value="<?=set_value('email')?>" size="20" maxlength="48" />
</li>
<input value="Отправить" type="submit" />
</ul>
</form>
</div>
</div>
</div>
</div>
</div>
</div>