<?=validation_errors()?>
<?=show_tinimce('text')?>
<form action="" method="post">��������:<br />
<input type="text" name="name" size="50" maxlength="24"
	style="width: 100%" value="<?=$name?>">
<div class="comment">������������ ���������� �������� 24.</div>
<br />
���������:<br />
<input type="text" name="title" size="50" maxlength="64"
	style="width: 100%" value="<?=$title?>">
<div class="comment">������������ ���������� �������� 64.</div>
<br />
�����:<br />
<textarea id="text" name="text" cols="46" rows="10"><?=$text?></textarea>
<div class="comment">������������ ���������� �������� 10000.</div>
<br />
<div align="right"><input type="submit" value="��������� ���������"
	class="button" /></div>
</form>
