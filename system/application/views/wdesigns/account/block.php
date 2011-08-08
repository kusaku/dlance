<!--Блок-->
<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div class="bd">
<div id="accsidebar">

<? if( $this->team == 2 ): ?>
<div class="sideblock">
<h3>Модератор</h3> 
<ul>
<li><a href="/account/users">Пользователи</a></li>
</ul>
</div>
<? endif; ?>

<div class="sideblock">
<h3>Дизайны</h3> 
<ul>
<li><a href="/account/designs">Дизайны</a></li>
<li><a href="/account/cart">Корзина</a></li>
<li><a href="/account/purchased">Купленные</a></li>
<li><a href="/account/downloads">Созданные загрузки</a></li>
</ul>
</div>


<div class="sideblock mb0 noborder">
<h3>Аккаунт</h3> 
<ul>
<li><a href="/account/profile">Профиль</a></li>
<li><a href="/account/password">Пароль</a></li>
<li><a href="/account/userpic">Юзерпик</a></li>
<li><a href="/account/contact_data">Контактные данные</a></li>

<li><a href="/account/additional_data">Дополнительные данные</a></li>
<li><a href="/account/services">Услуги</a></li>
<li><a href="/users/portfolio/<?=$this->username?>">Портфолио</a></li>

<li><a href="/account/settings">Настройки</a></li>

<li><a href="/account/tariff">Виртуальный статус</a></li>

<li><a href="/account/tariff_set">Установить виртуальный статус</a></li>
</ul>
</div>

<div class="sideblock mb0 noborder">
<h3>Финансовые операции</h3> 
<ul>
<li><a href="/account/purses">Кошельки</a></li>
<li><a href="/account/balance">Баланс</a></li>
<li><a href="/account/withdraw">Вывод средств</a></li>
<li><a href="/account/transaction">История</a></li>

<li><a href="/account/transfer">Перевод средств</a></li>
<li><a href="/account/payments">Платежи</a></li>
</ul>
</div>

<div class="sideblock mb0 noborder">
<h3>Рассылки</h3> 
<ul>
<li><a href="/account/users_followers">Подписки на пользовательские работы</a></li>
<li><a href="/account/categories_followers">Подписки на рубрики</a></li>
</ul>
</div>

<div class="sideblock mb0 noborder">
<h3>Общий раздел</h3> 
<ul>
<li><a href="/blogs/add">Добавить запись в блог</a></li>
<li><a href="/account/blogs">Мой блог</a></li>
<li><a href="/contacts">Контакты / Сообщения</a></li>
<li><a href="/account/ad">Указатели</a></li>
</ul>
</div>
</div>


</div>
</div>
<div class="ft"></div>
</div>
<!--/Блок-->