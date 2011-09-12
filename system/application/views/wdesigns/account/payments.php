<div id="yui-main">
<div class="yui-b">

<h1><a href="/balance/payments/">�������</a></h1>
<p class="subtitle">������ ��������. ��� �������� ������ ��������
�������: "<a href="/account/transfer/">������� �������</a>"<br />
��� �������� ������������� ��� �������, �������� �� ������.</p>

<? if( !empty($data) ): ?>
<table class="offers">
	<tr>
		<th style="width: 15px;">�</th>
		<th class="txtl">���� ��������</th>
		<th style="width: 100px;">���</th>
		<th style="width: 100px;">�����</th>
		<th style="width: 100px;">����������</th>
		<th style="width: 100px;">����������</th>
		<th style="width: 60px;">������</th>
	</tr>
	<? foreach($data as $row): ?>
	<tr>
		<td><a href="/account/payments/<?=$row['id']?>.html"><?=$row['id']?></a></td>
		<td class="title"><?=$row['date']?></td>
		<td class="state txtc"><?=$row['type']?> <? if( $row['type_id'] == 2 and $row['status'] == 1 ): //���� ������ � ����� ���������?>
		(<?=$row['time']?>) <? endif; ?></td>
		<td class="budget txtc"><strong><?=$row['amount']?> ������</strong></td>
		<td class="owner txtc"><a href="/user/<?=$row['user']?>/"><?=$row['user']?></a></td>
		<td class="owner txtc"><a href="/user/<?=$row['recipient']?>/"><?=$row['recipient']?></a></td>
		<td class="state txtc"><?=$row['status']?></td>
	</tr>
	<? endforeach; ?>
</table>
<?=$page_links?> <? else: ?>
<p>������� �����������.</p>
<? endif; ?></div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>