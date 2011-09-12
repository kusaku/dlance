<div id="yui-main">
<div class="yui-b">
<h1><a href="/account/tariffs">����������� ������</a></h1>
<p class="subtitle">��������</p>
<?=validation_errors()?>
<div class="ttl">
<div class="ttr"></div>
</div>
<div class="bbd">
<p class="subtitle"><b>����������� ������</b></p>
<table class="profile">
	<tr>
		<td class="caption">��������:</td>
		<td><strong><?=$name?></strong></td>
	</tr>

	<? if( $id != 1 ): ?>
	<tr>
		<td class="caption">�� ���������:</td>
		<td><?=$tariff_period?></td>
	</tr>

	<tr>
		<td class="caption">���� �� �����:</td>
		<td><?=$price_of_month?> ������</td>
	</tr>

	<tr>
		<td class="caption">���� �� ���</td>
		<td><?=$price_of_year?> ������</td>
	</tr>
	<? endif; ?>
</table>
</div>
<div class="bbl">
<div class="bbr"></div>
</div>

	<? if( $id != 1 ): ?> <br />
<form action="" method="post" />
<input name="tariff" type="hidden" value="<?=$this->user_tariff?>" /> <select
	name="period">
	<option value="1">�����</option>
	<option value="2">���</option>
</select> <input type="submit" value="��������">
</form>
	<? endif; ?></div>
</div>
<!--/yui-main-->

	<? $this->load->view('wdesigns/account/block'); ?>