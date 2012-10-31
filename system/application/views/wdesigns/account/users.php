<?php $this->load->view('wdesigns/account/block'); ?>		
<div id="yui-main">
	<div class="yui-b">
		<h1><a href="/account/users">Пользователи</a></h1>
		<p class="subtitle"> Список пользователей.</p>
		<?php if (! empty($data)): ?>
		<table class="offers">
			<tr>
				<th class="txtl">Пользователь</th>
				<th style="width:100px;">Дата регистрации</th>
				<th style="width:100px;">Последний визит</th>
				<th style="width:100px;">Баланс</th>
				<th style="width:100px;">Рейтинг</th>
				<th style="width:60px;"></th>
			</tr>
			<?php foreach ($data as $row): ?>
			<tr>
				<td class="title">
					<a href="/user/<?=$row['username']?>"><?= $row['surname']?><?= $row['name']?>(<?= $row['username']?>)</a>
				</td>
				<td class="state txtc">
					<?= $row['created']?>
				</td>
				<td class="budget txtc">
					<?= $row['last_login']?>
				</td>
				<td class="owner txtc">
					<?= $row['balance']?>
				</td>
				<td class="owner txtc">
					<?= $row['rating']?>
				</td>
				<td class="state txtc">
					<?php if ($this->users_mdl->check_banned($row['id'])): ?>
					<strong>Забанен</strong>
					<?php else : ?>
					<a href="/account/users_ban/<?=$row['id']?>">Забанить</a>
					<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?= $page_links?>
		<?php else : ?>
		<p>Платежи отсутствуют.</p>
		<?php endif; ?>
	</div>
</div>
