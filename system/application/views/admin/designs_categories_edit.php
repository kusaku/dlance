<link rel="stylesheet" href="/templates/admin/steal/960.css"
	type="text/css" media="screen" charset="utf-8">
<link
	rel="stylesheet" href="/templates/admin/steal/template.css"
	type="text/css" media="screen" charset="utf-8">
<link
	rel="stylesheet" href="/templates/admin/steal/colour.css"
	type="text/css" media="screen" charset="utf-8">
<?=validation_errors()?>
<form action="" method="post">
<div id="content" class="container_16 clearfix">
<div class="grid_16">
<h2>������������� ���������</h2>
<p class="error">����� �������������� ���������.</p>
</div>

<div class="grid_8">
<p><label for="title">�������� <small>������������ ���������� ��������
24.</small></label> <input type="text" name="name" maxlength="24"
	value="<?=$name?>"></p>
</div>

<div class="grid_8">
<p><label for="title">������ <small>�������� �������� ������.</small></label>

<select name="category">
	<option></option>
	<? foreach($categories as $row): ?>

	<? if( $row['parent_id'] == 0): ?>
	<option value="<?=$row['id']?>" <? if( $row['id'] == $parent_id ): ?>
		selected="selected" <? endif; ?>><?=$row['name']?></option>
		<? endif; ?>

		<? endforeach; ?>
</select></p>
</div>

<div class="grid_16">
<p><label for="title">��������� <small>������������ ���������� ��������
255.</small></label> <input type="text" name="title" maxlength="255"
	value="<?=$title?>"></p>
</div>

<div class="grid_16">
<p class="submit"><input value="��������" type="reset"> <input
	value="���������" type="submit"></p>
</div>
</div>
</form>
