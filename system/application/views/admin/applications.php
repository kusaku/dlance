
<!-- Content -->
<article class="container_12">

<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post"
	action="/administrator/applications">
<h1>������</h1>
<a href="/administrator/applications">���</a> | <a
	href="/administrator/applications/?status=1">���������</a> | <a
	href="/administrator/applications/?status=2">�����������</a>
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
			<th scope="col">�����</th>
			<th scope="col">�������</th>
			<th scope="col">����</th>
			<th scope="col">������</th>
			<th scope="col" class="table-actions">Actions</th>
		</tr>
	</thead>

	<tbody>
	<? foreach($data as $row): ?>
		<tr>
			<td><a href="/administrator/users_edit/<?=$row['id']?>"><?=$row['username']?></a></td>
			<td><?=$row['amount']?></td>
			<td><?=$row['purse']?></td>
			<td><?=$row['date']?></td>
			<td><?=$row['status']?></td>
			<td class="table-actions"><? if( $row['status_id'] == 1 ):?><a
				href="/administrator/applications_done/<?=$row['id']?>">��������</a><? endif; ?>
			</td>
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

<div class="block-footer"></div>

</form>
</div>
</section>

<div class="clear"></div>

</article>

<!-- End content -->
