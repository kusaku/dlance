<?php $this->load->view('wdesigns/users/block'); ?>
<div class="content">
	<div class="userResponseHeader">
		<?php if ($this->username != $username): ?>
		<div class="addResponse">
			<div class="addResponseRightBrdr">
				<span>+</span>
				<a href="/users/subscribe/<?=$username?>">подписаться</a>
			</div>
		</div>
		<?php endif; ?>
		<h3>Подписчики:</h3>
	</div>
	<div class="contentWrapperBorderLeft" style="height:580px;">
		<?php if (! empty($followers)): ?>
		<div class="following">
			<?php foreach ($followers as $row): ?>
			<div>
				<img src="<?=$row['userpic']?>" alt="" class="avatar" width="60px"/><a href="/user/<?=$row['username']?>" rel="follows"><?= $row['username']?></a>
			</div>
			<?php endforeach; ?>
		</div>
		<?= $page_links?>
		<?php else : ?>
		<p>Подписчики отсутствуют.</p>
		<?php endif; ?>
	</div>
</div>
