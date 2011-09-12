<?=validation_errors()?>
<h1 class="title">����� ���������� �������</h1>
<p class="subtitle">�������� �����</p>
<form action="" method="post" />
<div class="rnd">
<div>
<div>
<div style="overflow: hidden;">
<table class="order-form">

	<tr>
		<td class="caption">���:</td>
		<td><input type="radio" name="rating" value="-1"
		<?=set_checkbox('rating', '-1'); ?> /> �������������&nbsp &nbsp <input
			type="radio" name="rating" value="1"
			<?=set_checkbox('rating', '1'); ?> /> �������������</td>
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
