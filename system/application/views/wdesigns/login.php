<? if( $logged_in ): ?>
<div id="userbar" class="clearfix">
<ul class="ltop">
<img src="<?=$userpic?>" alt="" class="userpic">

<li class="usr">
<a href="/user/<?=$username?>"><?=$name?> <?=$surname?> (<?=$username?>)</a>
<br />
<a href="/account/profile">Настройки</a>
</li>

<li class="pm"><a href="/contacts/">Контакты</a>
<? if( $messages ): ?>
(<?=$messages?>)
<? endif; ?>

<li class="pm"><a href="/account/events">События</a>
<? if( $events ): ?>
(<?=$events?>)
<? endif; ?>
</li>

<li>
Баланс: 
<a href="/account/balance/"><?=$balance?> рублей</a> 
</li>

<li>
Виртуальный статус: 
<a href="/account/tariff/"><?=$tariff?></a> 
</li>

<li>
Рейтинг: 
<a href="#"><?=$rating?></a> 
</li>

</ul>
<ul class="rtop">
<li>&nbsp;</li>
<li><a href="/account">Мой кабинет</a></li>
<li><a href="/logout">Выход</a></li>
</ul>
</div>
<? else: ?>
<div id="userbar" class="clearfix" style="height:32px">
<form name="login" action="/login" method="post">
<ul id="authline">
<li class="reg"><a href="/register">Регистрация</a></li>
<li class="log">Авторизация &nbsp; <input class="authtext" type="text" name="username" size="12" maxlength="32" /> &nbsp; <input class="authtext" type="password" name="password" size="12" maxlength="32" /></li>
<li class="rem"><input type="checkbox" class="authcheckbox" name="rcookiettl"  value="86400" /> Запомнить &nbsp;

<input name="submit" value='Вход' type="submit" >
</li>
<li class="rec"><a rel="nofollow" href="/recovery">Напомнить пароль</a></li>


<ul class="rtop">
<li><a href="/account/">Мой кабинет</a></li>
</ul>

</ul>



</form>
</div>
<? endif; ?>