<div id="yui-main">
<div class="yui-b">


<h1><a href="/account/transaction/">������� ��������</a></h1>


<? if( !empty($data) ): ?>
<table class="offers">
	<tr>
		<th style="width: 150px;">����</th>
		<th style="width: 150px;">�����</th>
		<th>��������</th>
	</tr>
	<? foreach($data as $row): ?>
	<tr>
		<td class="owner txtc"><?=$row['date']?></td>
		<td class="budget txtc"><strong><?=$row['amount']?></strong> ������</td>
		<td class="owner txtc"><?=$row['descr']?></td>
	</tr>
	<? endforeach; ?>
</table>
<? //$page_links?> <? else: ?>
<p>������� �����������.</p>
<? endif; ?></div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>