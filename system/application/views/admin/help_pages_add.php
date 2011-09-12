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
<form action="" method="post">
<div id="content" class="container_16 clearfix">
<div class="grid_16">
<h2>������������� ��������</h2>
<p class="error">����� �������������� �������.</p>
</div>

<div class="grid_8">
<p><label for="title">��������� <small>������������ ���������� ��������
64.</small></label> <input type="text" name="title" maxlength="64"
	value="<?=set_value('title')?>"></p>
</div>

<div class="grid_8">
<p><label for="title">��������� <small>�������� ���������.</small></label>
<select name="category" style="width: 100%">
	<option></option>
	<? foreach($categories as $row): ?>
	<option value="<?=$row['id']?>"><?=$row['name']?></option>
	<? endforeach; ?>
</select></p>
</div>

<div class="grid_16">
<p><label>����� <small>������������ ���������� �������� 10000.</small></label>
<textarea id="text" name="text"><?=set_value('text')?></textarea></p>
<p class="submit"><input value="��������" type="reset"> <input
	value="��������" type="submit"></p>
</div>
</div>
</form>
