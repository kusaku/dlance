<div class="sideBar">
	<div class="userInfo">
		<p class="contacts">			
			<?php if ($this->username != $username): ?>
			<a href="/user/<?=$username?>" class="name"><?= $username?></a>
			<span>&nbsp;</span>
			<a href="/contacts/send/<?=$username?>">Написать</a>
			<?php else: ?>
			<a href="/account" class="name"><?= $username?></a>
			это вы
			<?php endif; ?>
		</p>
		<p>
			<?= "{$name} {$surname}"?>
		</p>
		<div class="avatar pro">
			<a href="/user/<?=$username?>" title="Перейти к портфолио"></a>
			<img src="<?=$userpic?>" alt="<?=$username?> avi" />
		</div>
		<p>
			<a href="/users/designs/<?=$username?>">Дизайны:</a>
			<span><?= $designs_count; ?></span>
		</p>
		<p>
			<a href="/users/services/<?=$username?>">Услуги:</a>
			<span><?= $services_count; ?></span>
		</p>
		<p>
			<a href="/users/reviews/<?=$username?>">Отзывы:</a>
			<span><?= $reviews_count; ?></span>
		</p>
		<div>
			<p>
				Подписчики:
				<span><?= $subscribers_count; ?></span>
			</p>
			<?php if ($this->username != $username): ?>
			<?php if ($this->account_mdl->subscribe_check($this->user_id, $id)): ?>
			<div class="addResponse">
				<div class="addResponseRightBrdr">
					<span>-</span>
					<a href="/users/unsubscribe/<?=$username?>">отписаться</a>
				</div>
			</div>
			<?php else : ?>
			<div class="addResponse">
				<div class="addResponseRightBrdr">
					<span>+</span>
					<a href="/users/subscribe/<?=$username?>">подписаться</a>
				</div>
			</div>
			<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
	<div class="sideTabsBlock">
		<h3>Аккаунт:</h3>
		<ul>
			<li>
				Регистрация: <span><?= $created?></span>
			</li>
			<li>
				Последний визит: <span><?= $last_login?></span>
			</li>
			<li>
				Просмотров: <span><?= $views?></span>
			</li>
		</ul>
	</div>
	<?php if (!( empty($profile['price_1']) or empty($profile['price_2']))): ?>
	<div class="sideTabsBlock">
		<h3>Стоимость работы:</h3>
		<ul>
			<?php if (! empty($profile['price_1'])): ?>
			<li>
				Час работы: <strong><?= $profile['price_1']?> USD</strong>
			</li>
			<?php endif; ?>
			<?php if (! empty($profile['price_2'])): ?>
			<li>
				Месяц работы: <strong><?= $profile['price_2']?> USD</strong>
			</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>
	<div class="sideTabsBlock">
		<h3>Личная информация:</h3>
		<ul>
			<li>
				Возраст: <span><?= $age?></span>
			</li>
			<li>
				Пол: <span><?= $sex?></span>
			</li>
			<li>
				Страна: <span><?= $country_id?></span>
			</li>
			<li>
				Город: <span><?= $city_id?></span>
			</li>
			<li>
				О себе: <span><?= nl2br($full_descr)?></span>
			</li>
		</ul>
	</div>
	<div class="sideTabsBlock">
		<h3>Контакты:</h3>
		<?php if ($logged_in): ?>
		<ul class="info">
			<li>E-mail: Скрытый</li>
			<?php if (! empty($icq)): ?>
			<li>
				ICQ: <?= $icq?>
			</li>
			<?php endif; ?>
			<?php if (! empty($skype)): ?>
			<li>
				Skype: <?= $skype?>
			</li>
			<?php endif; ?>
			<?php if (! empty($telephone)): ?>
			<li>
				Телефон: <?= $telephone?>
			</li>
			<?php endif; ?>
		</ul>
		<?php else : ?>
		Вам необходимо залогиниться или зарегистрироваться для просмотра контактных данных
		<?php endif; ?>
	</div>
</div>
