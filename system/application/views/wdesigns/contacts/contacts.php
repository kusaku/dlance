<? if( !empty($data) ): ?>
<form action="/contacts/move" method="post">
<table class="contractors">
	<tr>
		<td class="topline lft txtl" style="width: 15px;"></td>
		<td class="topline title">������������</td>
		<td class="topline rht" style="width: 100px;">����� ���������</td>
	</tr>
	<? foreach($data as $row): ?>
	<tr>
		<td class="num"><input name="users[]" value="<?=$row['id']?>"
			type="checkbox" /></td>
		<td class="text"><img src="<?=$row['userpic']?>" alt="" class="avatar" />
		<ul class="ucard">
			<li class="utitle"><a class="black"
				href="/user/<?=$row['username']?>"><?=$row['surname']?> <?=$row['name']?>
			(<?=$row['username']?>)</a></li>
			<li>��������� �����: <?=$row['created']?></li>
			<li>���� �����������: <?=$row['last_login']?></li>

			<strong>
			<li>��������� ���������: <?=$row['last_msg']?></li>
			</strong>

		</ul>
		</td>
		<td class="portfolio"><a href="/contacts/send/<?=$row['username']?>">�����:
		<?=$row['count_new_messages']?> (�����: <?=$row['count_messages']?>)</td>
	</tr>
	<? endforeach; ?>
</table>
<?=$page_links?> <? else: ?>
<p>�������� �� �������.</p>
<? endif; ?>