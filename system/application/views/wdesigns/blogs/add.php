<?=validation_errors()?>
<h1 class="title">����� ���������� �������</h1>
<p class="subtitle">�������� ������</p>
<form action="" method="post" />
<div class="rnd">
<div>
<div>
<div style="overflow: hidden;">
<table class="order-form">
	<tr>
		<td class="caption">���������:</td>
		<td class="frnt"><input type="text" class="text" name="title"
			value="<?=set_value('title')?>" size="64" maxlength="128" /></td>
	</tr>

	<tr>
		<td class="caption">���������:</td>
		<td class="frnt cat"><select name="category_id">
			<option></option>
			<? foreach($categories as $row): ?>
			<option value="<?=$row['id']?>"
			<?=set_select('category_id', ''.$row['id'].''); ?>><?=$row['name']?></option>
			<? endforeach; ?>
		</select></td>
	</tr>

	<tr>
		<td class="caption">�����:</td>
		<td class="frnt"><textarea name="text" rows="10" cols="49"><?=set_value('text')?></textarea></td>
	</tr>

</table>
</div>
</div>
</div>
</div>
<input type="submit"
	value="��������">
</form>
