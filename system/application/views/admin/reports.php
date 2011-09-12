
<!-- Content -->
<article class="container_12">

<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post"
	action="/administrator/reports_action">
<h1>������</h1>
<a href="/administrator/reports">���</a> | <a
	href="/administrator/reports/?status=1">��������</a> | <a
	href="/administrator/reports/?status=2">��������</a>
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
			<th class="black-cell"><span class="loading"></span></th>
			<th scope="col">������</th>
			<th scope="col">�����������</th>
			<th scope="col">����</th>
			<th scope="col">������</th>
			<th scope="col" class="table-actions">Actions</th>
		</tr>
	</thead>

	<tbody>
	<? foreach($data as $row): ?>
		<tr>
			<th scope="row" class="table-check-cell"><input type="checkbox"
				name="reports[]" value="<?=$row['id']?>" /></th>
			<td><?=$row['title']?></td>
			<td><a href="/user/<?=$row['username']?>"><?=$row['username']?></a></td>
			<td><?=$row['date']?></td>
			<td><?=$row['status']?></td>
			<td class="table-actions"><a href="#"
				onClick="openModal(<?=$row['id']?>); return false;" title="�������"
				class="with-tip">�������</a></td>
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
	width="16" height="16" class="picto"> <select name="action" id="action"
	class="small">
	<option value="">� ����������...</option>
	<option value="close">�������</option>
	<option value="delete">�������</option>
</select>
<button type="submit" class="small">Ok</button>
</div>

</form>
</div>
</section>

<div class="clear"></div>

</article>

<!-- End content -->
