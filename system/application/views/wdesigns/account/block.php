<div class="sideBar">
<div class="userInfo">
	<p class="contacts">
		<a href="/user/<?=$username?>" class="name"><?=$this->username?></a>
	</p>
	<p>
		<?=$this->user->name?> <?=$this->user->surname?>
	</p>
	<div class="avatar <?=$tariff?>">
		<a href="/users/portfolio/<?=$this->username?>" title="Перейти к портфолио"></a>
		<img src="<?=$this->userpic?>" alt="<?=$this->username?> avi" />
	</div>
	<p>
		<a href="/account/events/">События:</a>
		<span><?= $events?></span>
	</p>
	<p class="contacts">
		<a href="/contacts">Сообщения</a>
		<span><?= $contacts?></span>
	</p>
	<p>
		<a href="/account/tariff_set">Мой статус:</a>
		<span><?= $tariff?></span>
	</p>
	<p>
		<a href="/account/settings">Настройки</a>
	</p>
</div>
<div class="sideTabsBlock">
	<h3>Управление:</h3>
	<ul>
		<li>
			<a href="/account/designs">Мои дизайны</a>
			<ul>
				<li>
					<a href="/account/cart">корзина</a>
				</li>
				<li>
					<a href="/account/purchased">купленные</a>
				</li>
				<li>
					<a href="/account/downloads">загрузки</a>
				</li>
			</ul>
		</li>
		<li>
			<a href="/account/services">Мои услуги</a>
			<span></span>
		</li>
		<li>
			<a href="/account/portfolio">Моё портфолио</a>
			<span></span>
		</li>
	</ul>
</div>
<?php 
/*
 <div class="sideTabsBlock">
 <h3>Управление финансами:</h3>
 <ul>
 <li>
 <a href="/account/purses">Мои кошельки</a>
 <span></span>
 </li>
 <li>
 <a href="/account/balance">Пополнить баланс:</a>
 <span><?= $balance?>	руб.</span>
 </li>
 <li>
 <a href="/account/transfer">Перевод средств</a>
 </li>
 <li>
 <a href="/account/withdraw">Вывод средств</a>
 </li>
 <li>
 <a href="/account/transaction">История платежей</a>
 </li>
 </ul>
 </div>
 <div class="sideTabsBlock">
 <h3><a href="#">Следить за пользователями:</a></h3>
 <ul>
 <li>
 <a href="/account/users_followers">Рассылка по пользователям:</a>
 <span></span>
 </li>
 <li>
 <a href="/account/categories_followers">Рассылка по рубрикам:</a>
 <span></span>
 </li>
 </ul>
 </div>
 */
?>
<?php if ($this->team == 2): ?>
<div class="sideTabsBlock">
	<h3>Модератор</h3>
	<ul>
		<li>
			<a href="/account/users">Пользователи</a>
		</li>
	</ul>
</div>
<?php endif; ?>
</div>
