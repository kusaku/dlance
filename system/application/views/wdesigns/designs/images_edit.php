<?=validation_errors()?>
<? if( !empty($error) ) {?><?=$error?><? } ?>
<h1 class="title">����� �������������� ������</h1>
<p class="subtitle">������������� ������</p>
<form
	action="" method="post" enctype="multipart/form-data" />
<div class="rnd">
<div>
<div>
<div style="overflow: hidden;">
<table class="order-form">
	<tr>
		<td class="caption">���������(�������� 64 ��������):</td>
		<td class="frnt"><input type="text" class="text" name="title"
			value="<?=$title?>" size="64" maxlength="64" /></td>
	</tr>

	<tr>
		<td class="caption">��������(�������� 255 ��������):</td>
		<td class="frnt"><textarea name="text" rows="10" cols="49"><?=$descr?></textarea></td>
	</tr>

	<tr>
		<td class="caption">�������� �����������:</td>
		<td><img src="<?=$small_image?>" /><br />
		<input class="file" name="userfile" type="file"> &nbsp; &nbsp; &nbsp;
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ������ � �� 1
		��, ������ � JPG, ���������� - �� 1024x768 px</td>
	</tr>

</table>
</div>
</div>
</div>
</div>
<input type="submit"
	value="���������">
</form>
