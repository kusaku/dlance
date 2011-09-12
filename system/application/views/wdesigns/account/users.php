<div id="yui-main">
<div class="yui-b">


<h1><a href="/account/users">������������</a></h1>
<p class="subtitle">������ �������������.</p>


<? if( !empty($data) ): ?>
<table class="offers">
	<tr>
		<th class="txtl">������������</th>
		<th style="width: 100px;">���� �����������</th>
		<th style="width: 100px;">��������� �����</th>
		<th style="width: 100px;">������</th>
		<th style="width: 100px;">�������</th>
		<th style="width: 60px;"></th>
	</tr>
	<? foreach($data as $row): ?>
	<tr>
		<td class="title"><a href="/user/<?=$row['username']?>"><?=$row['surname']?>
		<?=$row['name']?> (<?=$row['username']?>)</a></td>
		<td class="state txtc"><?=$row['created']?></td>
		<td class="budget txtc"><?=$row['last_login']?></td>
		<td class="owner txtc"><?=$row['balance']?></td>
		<td class="owner txtc"><?=$row['rating']?></td>
		<td class="state txtc"><? if( $this->users_mdl->check_banned($row['id']) ): ?>
		<strong>�������</strong> <? else: ?> <a
			href="/account/users_ban/<?=$row['id']?>">��������</a> <? endif; ?></td>
	</tr>
	<? endforeach; ?>
</table>
<?=$page_links?> <? else: ?>
<p>������� �����������.</p>
<? endif; ?></div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>