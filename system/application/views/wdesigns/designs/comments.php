<?=validation_errors()?>

<div id="comments">

	<div class="rnd comments-body">
		<div>
			<div>
				<div>

<h4>Комментарии</h4>
<? if( !empty($data) ): ?>
<? foreach($data as $row): ?>

<div id="com" class="commets-row">
<div class="com-title">Разместил <a rel="nofollow" href="/user/<?=$row['username']?>"><?=$row['username']?></a> &nbsp; <?=$row['date']?> &nbsp; <span class="fr"> &nbsp; </span> </div>
<div class="com-text">
<?=nl2br($row['text'])?>
</div>

<? if( $this->team == 2 ) :?>
<a href="/designs/comments_edit/<?=$row['id']?>">Редактировать</a> |
<a href="/designs/comments_del/<?=$row['id']?>">Удалить</a>
<? endif; ?>

</div>
<? endforeach; ?>
<? else: ?>
<p>Коментарии отсутствуют.</p>
<? endif; ?>

				</div>
			</div>
		</div>
	</div>

<? if( $this->users_mdl->logged_in() ): ?>
<form action="" method="post">
<div class="comments-form">
<h4>Добавить комментарий</h4>
<div><textarea id="text" name="text" rows="7" cols="60"></textarea></div>
<div class="comments-send"><input name="newcomment" type="submit" value="Добавить"/></div>
</div>
</form>
<? else: ?>
<p>Для добавление комментариев, вам необходимо залогиниться или зарегистрироваться.</p>
<? endif; ?>

</div>
