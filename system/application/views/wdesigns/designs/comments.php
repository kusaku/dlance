<?=js_insert_smiley('comment', 'text')?>

<?=validation_errors()?>



<div class="comments">
						<div class="commentsHeader">
							<h3>Комментарии:</h3>
							<a href="#">Оставить комментарий</a>
						</div>
						
<? if( !empty($data) ): ?>
<ul class="commentsList">
<? foreach($data as $row): ?>
<li>
<div class="userInfo">
									<div class="avatar">
										<a rel="nofollow" href="/user/<?=$row['username']?>" title="перейти к портфолио"></a>
										<img src="<?=$row['userpic']?>" alt="<?=$row['username']?> avi" />
									</div>
									<p><a rel="nofollow" href="/user/<?=$row['username']?>" title="перейти к портфолио"><?=$row['username']?></a></p>
									<p><?=$row['name']?> <?=$row['sirname']?></p>
								</div>
<div class="userComment">
									<p class="commentDate"><?=$row['date']?></p>
									<?=parse_smileys(nl2br($row['text']), '/img/smileys/')?>
								</div>

<!--
<? if( $this->team == 2 ) :?>
<ul class="ocard">
<li><a href="/designs/comments_edit/<?=$row['id']?>">Редактировать</a></li>
<li><a href="/designs/comments_del/<?=$row['id']?>">Удалить</a></li>
</ul>
<? endif; ?>
-->
</li>
<? endforeach; ?>
</ul>
<? else: ?>
<p>Коментарии отсутствуют.</p>
<? endif; ?>
</div>
<? if( $this->users_mdl->logged_in() ): ?>


<div class="makeComment">
						<div class="makeCommentHeader">
							<h3>Оставить комментарий</h3>
							<a href="#">Показать смайлы</a>
						</div>
						<form class="commentForm" action="" method="post" name="comment">
							<div class="avatar">
								<a href="/user/<?=$row['username']?>" title="Перейти к портфолио"></a>
								<img src="<?=$row['userpic']?>" alt="<?=$row['username']?> avi" />
							</div>
							<textarea id="text" placeholder="Оставьте комментарий..."></textarea>
							<div class="smiles">
								<?=$smiley?>
							</div>
							<input type="submit" name="newcomment" value="Отправить" class="commentBtn" />
						</form>
					</div>
<? else: ?>
<p>Для добавление комментариев, вам необходимо залогиниться или зарегистрироваться.</p>
<? endif; ?>