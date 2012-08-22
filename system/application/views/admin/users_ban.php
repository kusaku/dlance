<?= validation_errors()?>
<form action="" method="post">
	Причина:
	<br/>
	<input type="text" name="cause" size="50" maxlength="64" style="width:100%">
	<div class="comment">Максимальное количество символов 64.</div>
	<div align="right">
		<input type="submit" value="Бан" class="button" />
	</div>
</form>