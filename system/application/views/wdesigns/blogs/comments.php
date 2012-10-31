<?= js_insert_smiley('comment', 'text')?>
<?= validation_errors()?>
<div class="comments">
	<div class="commentsHeader">
		<h3>Комментарии:</h3>
		<a href="#">Оставить комментарий</a>
	</div>
	<?php if (! empty($data)): ?>
	<ul class="commentsList">
		<?php foreach ($data as $row): ?>
		<li>
			<div class="userInfo">
				<div class="avatar">
					<a rel="nofollow" href="/user/<?=$row['username']?>" title="перейти к портфолио"></a>
					<img src="<?=$row['userpic']?>" alt="<?=$row['username']?>" />
				</div>
				<p>
					<a rel="nofollow" href="/user/<?=$row['username']?>" title="перейти к портфолио"><?= $row['username']?></a>
				</p>
				<p>
					<?= $row['name']?><?= $row['sirname']?>
				</p>
			</div>
			<div class="userComment">
				<p class="commentDate">
					<?= $row['date']?>
				</p>
				<?= parse_smileys(nl2br($row['text']), '/img/smileys/')?>
			</div>
			<!--
			<?php if( $this->team == 2 ) :?>
			<ul class="ocard">
			<li><a href="/designs/comments_edit/<?=$row['id']?>">Редактировать</a></li>
			<li><a href="/designs/comments_del/<?=$row['id']?>">Удалить</a></li>
			</ul>
			<?php endif; ?>
			-->
		</li>
		<?php endforeach; ?>
	</ul>
	<?php else : ?>
	<p>Коментарии отсутствуют.</p>
	<?php endif; ?>
</div>
<?php if ($this->users_mdl->logged_in()): ?>
<div class="makeComment">
	<div class="makeCommentHeader">
		<h3>Оставить комментарий</h3>
		<a href="#">Показать смайлы</a>
	</div>
	<form class="commentForm" action="" method="post" name="comment">
		<div class="avatar">
			<a href="/user/<?=$username?>" title="Перейти к портфолио"></a>
			<img src="<?=$userpic?>" alt="<?=$username?>" />
		</div><textarea id="text" name="text" placeholder="Оставьте комментарий..."></textarea>
		<div class="smiles">
			<?= $smiley?>
		</div>
		<input type="submit" name="newcomment" value="Отправить" class="commentBtn" />
	</form>
</div>
<?php else : ?>
<p>Для добавление комментариев, вам необходимо <a href="/account">залогиниться или зарегистрироваться</a>.</p>
<?php endif; ?>