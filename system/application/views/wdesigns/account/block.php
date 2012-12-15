<div class="sideBar">
	<div class="userInfo">
		<p class="contacts">
			<a href="/user/<?=$username?>" class="name"><?= $this->username?></a>
		</p>
		<p>
			<a href="/account" class="name"><?= "{$name} {$surname}"?></a>
		</p>
		<div class="avatar <?=$tariff?>">
			<a href="/users/portfolio/<?=$this->username?>" title="Перейти к портфолио"></a>
			<a href="/account/settings" class="name"><img src="<?=$userpic?>" alt="<?=$this->username?> avi" /></a>
		</div>
		<p class="contacts">
			<a href="/contacts">Сообщения</a>
			<span><?= $contacts?></span>
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
						<a href="/account/purchased">заказанные</a>
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
