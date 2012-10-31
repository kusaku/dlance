<?php if (! empty($data)): ?>
<form action="/contacts/move" method="post">
	<table class="contractors">
		<tr>
			<td class="topline lft txtl" style="width:15px;"></td>
			<td class="topline title">Пользователь</td>
			<td class="topline rht" style="width:100px;">Число сообщений</td>
		</tr>
		<?php foreach ($data as $row): ?>
		<tr>
			<td class="num">
				<input name="users[]" value="<?=$row['id']?>" type="checkbox" />
			</td>
			<td class="text">
				<img src="<?=$row['userpic']?>" alt="" class="avatar" />
				<ul class="ucard">
					<li class="utitle">
						<a class="black" href="/user/<?=$row['username']?>">
							<?= $row['surname']?>
							<?= $row['name']?>
							(
							<?= $row['username']?>
							)</a>
					</li>
					<li>
						Последний визит: 
						<?= $row['created']?>
					</li>
					<li>
						Дата регистрации: 
						<?= $row['last_login']?>
					</li>
					<strong>
						<li>
							Последнее сообщение: 
							<?= $row['last_msg']?>
						</li>
					</strong>
				</ul>
			</td>
			<td class="portfolio">
				<a href="/contacts/send/<?=$row['username']?>">
				Новых: 
				<?= $row['count_new_messages']?>
				(всего: 
				<?= $row['count_messages']?>
				)
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</form>
<?= $page_links?>
<?php else : ?>
<p>Контакты не найдены.</p>
<?php endif; ?>