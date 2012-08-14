<div class="sideBar">
	<div class="userInfo">
		<p><a href="/user/<?=$username?>" class="name"><?=$username?></a><br/><?=$name?> <?=$surname?></p>
		<div class="avatar pro">
			<a href="/user/<?=$username?>" title="Перейти к портфолио"></a>
			<img src="<?=$userpic?>" alt="<?=$username?> avi" />
		</div>
		<p><a href="/users/designs/<?=$username?>" class="active">Дизайны:</a> <span>99</span></p>
		<p><a href="/users/reviews/<?=$username?>">Отзывы</a> <span>14</span></p>
		<p><a href="/users/followers/<?=$username?>">Подписчиков:</a> <span>5</span></p>
		<br/>
		<p class="contacts"><a href="/users/followers/<?=$username?>">Написать</a> <span>&nbsp;</span></p>
	</div>
	<div class="sideTabsBlock">
		<h3>Аккаунт:</h3>
		<ul>
			<li>Регистрация: <span><?=$created?></span></li>
			<li>Последний визит: <span><?=$last_login?></span></li>
			<li>Просмотров: <span><?=$views?></span></li>
		</ul>
	</div>
	<div class="sideTabsBlock">
		<h3>Стоимость работы:</h3>
		<ul>
			<? if( !empty($profile['price_1']) ):?><li>Час работы: <strong><?=$profile['price_1']?> USD</strong></li><? endif; ?>
			<? if( !empty($profile['price_2']) ):?><li>Месяц работы: <strong><?=$profile['price_2']?> USD</strong></li><? endif; ?>
		</ul>
	</div>
	<div class="sideTabsBlock">
		<h3>Личная информация:</h3>
		<ul>
			<li>Возраст: <span><?=$age?></span></li>
			<li>Пол: <span><?=$sex?></span></li>
			<li>Страна: <span><?=$country_id?></span></li>
			<li>Город: <span><?=$city_id?></span></li>
			<li>О себе: <span><?=nl2br($full_descr)?></span></li>
			<li><a href="/user/<?=$username?>">Посмотреть резюме</a></li>
		</ul>
	</div>
	<div class="sideTabsBlock">
		<h3>Контакты:</h3>
		<? if( $logged_in ): ?>
		<ul class="info">
			<li>E-mail: Скрытый</li>
			<? if( !empty($icq) ):?><li>ICQ: <?=$icq?></li><? endif; ?>
			<? if( !empty($skype) ):?><li>Skype: <?=$skype?></li><? endif; ?>
			<? if( !empty($telephone) ):?><li>Телефон: <?=$telephone?></li><? endif; ?>
		</ul>
		<? else: ?>
		Вам необходимо залогиниться или зарегистрироваться для просмотра контактных данных
		<? endif; ?>
	</div>
</div>