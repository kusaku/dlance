<? $this->load->view('wdesigns/users/block'); ?>
<div class="yui-g">
	<ul class="usernav">
		<li>
			<a href="/user/<?=$username?>">Информация</a>
		</li>
		<li>
			<a href="/users/designs/<?=$username?>">Дизайны</a>
		</li>
		<li>
			<a href="/users/portfolio/<?=$username?>">Портфолио</a>
		</li>
		<li>
			<a href="/users/services/<?=$username?>">Услуги</a>
		</li>
		<li>
			<a href="/users/reviews/<?=$username?>">Отзывы</a>
		</li>
		<li class="active">
			<a href="/users/followers/<?=$username?>">Подписчики</a>
		</li>
	</ul>
</div>
<div class="content">
	<? if (! empty($followers)): ?>
	<div class="following">
		<? foreach ($followers as $row): ?>
		<div>
			<img src="<?=$row['userpic']?>" alt="" class="avatar" width="60px"/><a href="/user/<?=$row['username']?>" rel="follows"><?= $row['username']?></a>
		</div>
		<? endforeach; ?>
	</div>
	<?= $page_links?>
	<? else : ?>
	<p>Подписчики отсутствуют.</p>
	<? endif; ?>
</div>
<div id="sidebar" class="yui-b">
	<div class="hd"></div>
	<div id="usercard" class="bd clearfix">
		<div class="clearfix">
			<img src="<?=$userpic?>" alt="" class="avatar" />
			<ul class="ucard">
				<li class="age">
					Возраст: <?= $age?>
				</li>
				<li>
					Пол: <?= $sex?>
				</li>
			</ul>
		</div>
		<div class="sendpm">
			<a href="/contacts/send/<?=$username?>">Личное сообщение</a>
		</div>
		<table class="userstats">
			<tr>
				<td>Дата регистрации:</td>
				<td>
					<?= $created?>
				</td>
			</tr>
			<tr>
				<td>Последний визит:</td>
				<td>
					<?= $last_login?>
				</td>
			</tr>
			<? if ($positive or $negative): ?>
			<tr>
				<td>Отзывы:</td>
				<td>
					<a class="rev-positive" href="/users/reviews/<?=$username?>/?type=positive"><?= $positive?></a>
					<? if ($negative): ?>|             <a class="rev-negative" href="/users/reviews/<?=$username?>/?type=negative"><?= $negative?></a>
					<? endif; ?>
				</td>
			</tr>
			<? endif; ?>
			<tr>
				<td>Просмотров:</td>
				<td>
					<?= $views?>
				</td>
			</tr>
			<tr>
			<tr>
				<td>Местоположение:</td>
				<td>
					<?= $country_id?>/ <?= $city_id?>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="noborder green"></td>
			</tr>
		</table>
		<? if (! empty($website)): ?><b>
			<noindex>
				<a href="<?=$website?>" target="_blank" rel="nofollow"><?= $website?></a>
			</noindex>
		</b>
		<? endif; ?>
	</div>
	<div class="ft"></div>
</div>
