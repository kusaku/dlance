<?php $this->load->view('wdesigns/users/block'); ?>
<div class="content">
	<div class="userResponseHeader">
		<?php if ($this->username != $username): ?>
		<div class="addResponse">
			<div class="addResponseRightBrdr">
				<span>+</span>
				<a href="/users/reviews_add/<?=$username?>">добавить отзыв</a>
			</div>
		</div>
		<?php endif; ?>
		<h3>Отзывы:</h3>
	</div>
	<div class="contentWrapperBorderLeft" style="height:580px;">
		<?php if (! empty($reviews)): ?>
		<ul class="commentsList">
			<?php foreach ($reviews as $row): ?>
			<li>
				<div class="userInfo">
					<div class="avatar lite">
						<a href="/user/<?=$row['username']?>" title="перейти к портфолио <?=$row['username']?>"></a>
						<img src="<?=$row['userpic']?>" alt="<?=$row['username']?> avi" />
					</div>
					<p>
						<a href="/user/<?=$row['username']?>" title="перейти к портфолио"><?= $row['username']?></a>
					</p>
					<p>
						<?= $row['surname']?><?= $row['name']?>
					</p>
				</div>
				<div class="userComment">
					<p class="commentDate">
						<?= $row['date']?>
					</p>
					<p>
						<?= nl2br($row['text'])?>
					</p>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
		<div class="paginationControl">
			<?= $page_links?>
		</div>
		<?php else : ?>
		<p>Отзывы отсутствуют.</p>
		<?php endif; ?>
	</div>
</div>
