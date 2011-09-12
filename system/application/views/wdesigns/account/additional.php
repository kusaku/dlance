<div id="yui-main">
<div class="yui-b">

<h1><a href="/account/additional_data">�������������� ������</a></h1>

<p class="subtitle">���� �������������� ������</p>

<?=validation_errors()?> <?=show_validation()?>
<form action="" method="post" />
<div class="ttl">
<div class="ttr"></div>
</div>
<div class="bbd">
<p class="subtitle"><b>�������������� ������</b></p>
<table class="profile">

	<tr>
		<td class="caption">���� �� ��� ������:</td>
		<td><input type="text" class="validate[custom[Number]] text-input"
			name="price_1" value="<?=$price_1?>" size="56" maxlength="12" /></td>
	</tr>

	<tr>
		<td class="caption">���� �� ����� ����� ������:</td>
		<td><input type="text" class="validate[custom[Number]] text-input"
			name="price_2" value="<?=$price_2?>" size="56" maxlength="12" /></td>
	</tr>

</table>
</div>
<div class="bbl">
<div class="bbr"></div>
</div>
<br />
<input type="submit" value="�������������">
</form>


</div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>