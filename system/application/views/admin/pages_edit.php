<?= validation_errors()?>
<?= show_tinimce('text')?>
<form action="" method="post">
	Название:
	<br/>
	<input type="text" name="name" size="50" maxlength="24" style="width:100%" value="<?=$name?>">
	<div class="comment">Максимальное количество символов 24.</div>
	<br/>
	Заголовок:
	<br/>
	<input type="text" name="title" size="50" maxlength="64" style="width:100%" value="<?=$title?>">
	<div class="comment">Максимальное количество символов 64.</div>
	<br/>
	Текст:
	<br/>
	<textarea id="text" name="text" cols="46" rows="10"><?= $text?></textarea>
	<div class="comment">Максимальное количество символов 10000.</div>
	<br/>
	<div align="right">
		<input type="submit" value="Сохранить изменения" class="button" />
	</div>
</form>