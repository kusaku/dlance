<?=validation_errors()?>

<div id="comments">

	<div class="rnd comments-body">
		<div>
			<div>
				<div>

<h4>Комментарии</h4>
<? if( !empty($data) ): ?>
<? foreach($data as $row => $value): $row++; ?>

<div id="com<?=$row?>" class="commets-row">
<div class="com-title">Разместил <a rel="nofollow" href="/user/<?=$value['username']?>"><?=$value['username']?></a> &nbsp; <?=$value['date']?> &nbsp; <span class="fr"> &nbsp; </span> </div>
<div class="com-text">
<?=nl2br($value['text'])?>
</div>

<? if( $this->team == 2 ) :?>
<a href="/blogs/comments_edit/<?=$value['id']?>">Редактировать</a> |
<a href="/blogs/comments_del/<?=$value['id']?>">Удалить</a>
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
