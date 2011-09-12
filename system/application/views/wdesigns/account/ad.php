<div id="yui-main">
<div class="yui-b">

<h1><a href="/account/ad">���������</a></h1>

<p class="subtitle">�� ������ ��������� ��������� �� ����� ���� ���
����. ��������� ����� ��������� �� ��� ������� �� ����� <?=$this->config->item('site')?>.
</p>
<? if( !empty($code) ): ?> <textarea name="text" rows="5" cols="49"
	style="width: 100%"><?=$code?></textarea> <? endif; ?> <?=validation_errors()?>


<form action="/account/ad/" method="get" />
<? if( !empty($ads) ): ?>
<table class="services">
	<tbody>
		<tr>
			<td width="25px"></td>
			<td></td>
		</tr>

		<? foreach($ads as $row): ?>
		<tr>
			<td><input name="ad" type="radio" value="<?=$row['id']?>"
			<? if( !empty($ad) and $ad == $row['id'] ): ?> checked="checked"
			<? endif; ?> /></td>
			<td><img src="<?=$row['img']?>" alt=""></td>
		</tr>

		<? endforeach; ?>


	</tbody>
</table>
		<? else: ?>
<p>��������� �� �������.</p>
		<? endif; ?> <input type="submit" value="�������� ���">
</form>


</div>

</div>
<!--/yui-main-->

		<? $this->load->view('wdesigns/account/block'); ?>