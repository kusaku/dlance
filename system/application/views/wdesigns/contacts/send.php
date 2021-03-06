<?php $this->load->view('wdesigns/account/block'); ?>
<div id="yui-main" class="content">
	<div class="yui-b services">
		<h1><a href="">Контакты / Сообщения</a></h1>
		<div class="userInfo">
			<img src="<?=$userpic?>" alt="" class="avatar" />
			<ul class="ucard">
				<li class="utitle">
					<a class="black" href="/user/<?=$username?>"><?= $username?></a>
				</li>
				<li>
					Последний визит: <?= $last_login?>
				</li>
				<li>
					Дата регистрации: <?= $created?>
				</li>
				<li>
					<a href="#send">Написать сообщение</a>
				</li>
			</ul>
		</div>
		<div class="message">
			<?php if (! empty($messages)): ?>
			<?php foreach ($messages as $row): ?>
			<?php if ($row['reading']): ?>
			<div align="right">
				Прочитано: <?= $row['reading']?>
			</div>
			<?php endif; ?>
			<strong><?= $row['sender_id']?></strong>
			<?= date_smart($row['date'])?>:
			<br/>
			<?= nl2br($row['text'])?>
			<hr/><?php endforeach; ?>
			<?= $page_links?>
			<?php else : ?>
			Сообщения не найдено.
			<?php endif; ?>
		</div>
		<?php if ($black_list): ?>
		Переписка отключена
		<?php else : ?>
		<?= validation_errors()?>
		<div id="send">
			<form action="" method="post">
				<div>
					<textarea cols="10" rows="10" name="text" style="width:100%"><?= set_value('text')?></textarea>
				</div>
				<div>
					<br/>
					<button name="submit" type="submit" value="Отправить" class="orangeBtn80">Отправить</button></form>
				</div>
			</form>
		</div>
		<?php endif; ?>
	</div>
</div>