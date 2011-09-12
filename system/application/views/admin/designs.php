
<!-- Content -->
<article class="container_12">

<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post"
	action="/administrator/designs_action">
<h1>�������</h1>
<a href="/administrator/designs">���</a> | <a
	href="/administrator/designs/?status=1">��������</a> | <a
	href="/administrator/designs/?status=3">��������</a> | <a
	href="/administrator/designs/?status=2">�����������</a>
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
			<th scope="col">���������</th>
			<th scope="col">���������</th>
			<th scope="col">������</th>
			<th scope="col">����</th>
			<th scope="col">���������</th>
			<th scope="col">������</th>
		</tr>
	</thead>

	<tbody>
	<? foreach($data as $row): ?>
		<tr>
			<th scope="row" class="table-check-cell"><input type="checkbox"
				name="designs[]" value="<?=$row['id']?>" /></th>
			<td><a href="/designs/<?=$row['id']?>.html" target="_new"><?=$row['title']?></a></td>
			<td><?=$row['category']?></td>
			<td><a href="<?=$row['full_image']?>"><small><img
				src="/templates/admin/images/icons/fugue/image.png" width="16"
				height="16" class="picto"></small></a></td>
			<td><?=$row['date']?></td>
			<td><?=$row['moder']?></td>
			<td><?=$row['status']?></td>
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
	<option value="moder">���������</option>
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
