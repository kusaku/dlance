
<!-- Content -->
<article class="container_12">

<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="get"
	action="/administrator/users/">
<h1>������������</h1>

<div class="block-controls">
<ul class="controls-buttons">
<?=$page_links?>
</ul>
</div>
<? if( !empty($data) ): ?>
<div class="no-margin">
<table class="table" cellspacing="0" width="100%">

	<thead>
		<tr>
			<th scope="col">������������</th>
			<th scope="col">���� �����������</th>
			<th scope="col">��������� �����</th>
			<th scope="col"><span class="column-sort"> <a
				href="/administrator/users/?order_field=balance<? if( !empty($url) ): ?>&<?=$url?><? endif;?>"
				title="Sort up"
				class="sort-up<? if( $input['order_field'] == 'balance' and  $input['order_type'] == 'desc' ): ?> active<? endif;?>"></a>

			<a
				href="/administrator/users/?order_field=balance&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>"
				title="Sort down"
				class="sort-down<? if( $input['order_field'] == 'balance' and  $input['order_type'] == 'asc' ): ?> active<? endif;?>"></a>
			</span> ������</th>
			<th scope="col"><span class="column-sort"> <a
				href="/administrator/users/?order_field=rating<? if( !empty($url) ): ?>&<?=$url?><? endif;?>"
				title="Sort up"
				class="sort-up<? if( $input['order_field'] == 'rating' and  $input['order_type'] == 'desc' ): ?> active<? endif;?>"></a>

			<a
				href="/administrator/users/?order_field=rating&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>"
				title="Sort down"
				class="sort-down<? if( $input['order_field'] == 'rating' and  $input['order_type'] == 'asc' ): ?> active<? endif;?>"></a>
			</span> �������</th>
			<th scope="col" class="table-actions">��������</th>
		</tr>
	</thead>

	<tbody>
	<? foreach($data as $row): ?>
		<tr>
			<td><a href="/user/<?=$row['username']?>" target="_new"><?=$row['surname']?>
			<?=$row['name']?> (<?=$row['username']?>)</a></td>
			<td><?=$row['created']?></td>
			<td><?=$row['last_login']?></td>
			<td><?=$row['balance']?></td>
			<td><?=$row['rating']?></td>
			<td class="table-actions"><a
				href="/administrator/users_edit/<?=$row['id']?>"
				title="�������������" class="with-tip"><img
				src="/templates/admin/images/icons/fugue/pencil.png" width="16"
				height="16"></a></td>
		</tr>
		<? endforeach; ?>
	</tbody>

</table>
</div>
		<? else: ?>
<p>������ �� �������.</p>
		<? endif; ?>
<ul class="message no-margin">
	<li>�����������: <?=$count?></li>
</ul>

<div class="block-footer"><img
	src="/templates/admin/images/icons/fugue/arrow-curve-000-left.png"
	width="16" height="16" class="picto"> ����������� �� ��������: <input
	type="text" name="result" size="2" maxlength="2"> �������� �����: <input
	type="text" name="keywords" size="64" maxlength="64"
	style="width: 250px;">

<button type="submit" class="small">�����</button>
</div>

</form>
</div>
</section>

<div class="clear"></div>

</article>

<!-- End content -->
