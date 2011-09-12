<?=js_insert_smiley('comment', 'text')?>

<?=validation_errors()?>

<div id="comments">

<div class="rnd comments-body">
<div>
<div>
<div>

<h4>�����������</h4>

<? if( !empty($data) ): ?> <? foreach($data as $row): ?>
<div class="answer">
<div class="com-title">������� <a rel="nofollow"
	href="/user/<?=$row['username']?>"><?=$row['username']?></a> <?=$row['date']?>
</div>
<img src="<?=$row['userpic']?>" alt="<?=$row['username']?>"
	class="userpic" />
<div class="com-text"><?=parse_smileys(nl2br($row['text']), '/img/smileys/')?></div>


<? if( $this->team == 2 ) :?>
<ul class="ocard">
	<li><a href="/designs/comments_edit/<?=$row['id']?>">�������������</a></li>
	<li><a href="/designs/comments_del/<?=$row['id']?>">�������</a></li>
</ul>
<? endif; ?></div>
<? endforeach; ?> <? else: ?>
<p>���������� �����������.</p>
<? endif; ?></div>
</div>
</div>
</div>

<? if( $this->users_mdl->logged_in() ): ?> <?=$smiley?>
<form action="" method="post" name="comment">
<div class="comments-form">
<h4>�������� �����������</h4>
<div><textarea id="text" name="text" rows="7" cols="60"></textarea></div>
<div class="comments-send"><input name="newcomment" type="submit"
	value="��������" /></div>
</div>
</form>
<? else: ?>
<p>��� ���������� ������������, ��� ���������� ������������ ���
������������������.</p>
<? endif; ?></div>
