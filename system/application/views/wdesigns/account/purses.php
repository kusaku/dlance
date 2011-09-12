<div id="yui-main">
<div class="yui-b">


<h1><a href="/account/purses/">��������</a></h1>
<p class="subtitle">������ ����� ���������, ��� ������. ��� ��������
������ �������: "<a href="/account/purses_add/">�������� �������</a>"</p>


<? if( !empty($data) ): ?>
<table class="offers">
	<tr>
		<th class="txtl" style="width: 100px;">����� ��������</th>
		<th style="width: 100px;">����� ������</th>
		<th style="width: 150px;">���� ��������</th>
		<th style="width: 150px;">��������� ��������</th>
		<th></th>
	</tr>
	<? foreach($data as $row): ?>
	<tr>
		<td class="title"><?=$row['purse']?></td>
		<td class="budget txtc"><strong><?=$row['amount']?></strong> USD</td>
		<td class="owner txtc"><?=$row['date']?></td>
		<td class="owner txtc"><?=$row['last_operation']?></td>
		<td><span class="fr"><a href="/account/purses_del/<?=$row['id']?>">�������</a></span></td>
	</tr>
	<? endforeach; ?>
</table>

	<? else: ?>
<p>�������� �����������.</p>
	<? endif; ?></div>

</div>
<!--/yui-main-->

	<? $this->load->view('wdesigns/account/block'); ?>