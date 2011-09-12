<link rel="stylesheet" href="/templates/admin/steal/960.css"
	type="text/css" media="screen" charset="utf-8">
<link
	rel="stylesheet" href="/templates/admin/steal/template.css"
	type="text/css" media="screen" charset="utf-8">
<link
	rel="stylesheet" href="/templates/admin/steal/colour.css"
	type="text/css" media="screen" charset="utf-8">
<?=validation_errors()?>
<?=show_tinimce('text')?>
<? if( !empty($error) ): ?><?=$error?><? endif; ?>
<? if( !empty($count) ): ?>
<strong>����� ���������� <?=$count?> �����.</strong>
<? endif; ?>
<form action="" method="post" enctype="multipart/form-data">
<div id="content" class="container_16 clearfix">
<div class="grid_16">
<h2>��������</h2>
<p class="error">����� ��� �������� �� �������������.</p>
</div>

<div class="grid_16">
<p><label for="title">��������� <small>������������ ���������� ��������
64.</small></label> <input type="text" name="title" maxlength="64"
	value="<?=set_value('title')?>"></p>
</div>

<div class="grid_16">
<p><label for="title">���� <small>������ � �� 100 ��, ������ � ZIP, RAR.</small></label>
<input name="userfile" type="file" /></p>
</div>

<div class="grid_16">
<p><label>����� <small>������������ ���������� �������� 10000.</small></label>
<textarea id="text" name="text"><?=set_value('text')?></textarea></p>
<p class="submit"><input value="��������" type="reset"> <input
	value="���������" type="submit"></p>
</div>
</div>
</form>

<? if( !empty($mailer) ): ?>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
	<tr>
		<td width="250px">������������</td>
		<td>Email</td>
	</tr>
	<? foreach($mailer as $row): ?>
	<tr>
		<td><a class="black" href="/user/<?=$row['username']?>"><?=$row['surname']?>
		<?=$row['name']?> (<?=$row['username']?>)</a></td>
		<td><?=$row['email']?></td>
	</tr>
	<? endforeach; ?>
</table>

	<? else: ?>
<p>����������� �� �������.</p>
	<? endif; ?>