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
<h2>�������</h2>
<p class="error">������� ��������������.</p>
</div>

<div class="grid_8">
<p><label for="title">����� <small>������������ ���������� �������� 50.</small></label>
<input type="text" name="username" maxlength="50"></p>
</div>

<div class="grid_8">
<p><label for="title">������ <small>������������ ���������� �������� 50.</small></label>
<input type="password" name="password" maxlength="50"></p>

</div>

<div class="grid_8">
<p><label for="title">������� ������� ������ </label> <input type="text"
	name="current_password" maxlength="50"></p>
<p class="submit"><input value="��������" type="reset"> <input
	value="���������" type="submit"></p>
</div>

</div>
</form>
