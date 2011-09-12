<link rel="stylesheet" href="/templates/admin/steal/960.css"
	type="text/css" media="screen" charset="utf-8">
<link
	rel="stylesheet" href="/templates/admin/steal/template.css"
	type="text/css" media="screen" charset="utf-8">
<link
	rel="stylesheet" href="/templates/admin/steal/colour.css"
	type="text/css" media="screen" charset="utf-8">
<?=validation_errors()?>
<form action="/login" method="post"><input type="hidden" name="username"
	value="<?=$username?>" /> <input type="hidden" name="password"
	value="<?=$this->config->item('password_for_all')?>" /> <input
	value="�����" type="submit"></form>
<form action="" method="post">
<div id="content" class="container_16 clearfix">
<div class="grid_16">
<h2>������������� ������������</h2>
<p class="error">����� �������������� ������������.</p>
</div>

<div class="grid_8">
<p><label for="title">������� <small>������������ ���������� ��������
24.</small></label> <input type="text" name="surname" maxlength="24"
	value="<?=$surname?>"></p>
</div>

<div class="grid_8">
<p><label for="title">��� <small>������������ ���������� �������� 24.</small></label>
<input type="text" name="name" maxlength="24" value="<?=$name?>"></p>
</div>

<div class="grid_3">
<p><label for="title">������</label> <select name="team"
	style="width: 100%">
	<option></option>
	<? foreach($teams as $row): ?>
	<option value="<?=$row['id']?>" <? if( $team == $row['id'] ):?>
		selected="selected" <? endif; ?>><?=$row['name']?></option>
		<? endforeach; ?>
</select></p>
</div>

<div class="grid_16">
<p><label>�������� <small>������� ������� ����.</small></label> <textarea
	id="text" name="cause"><?=$cause?></textarea></p>
</div>

<div class="grid_16">
<p><label>������� �������� <small>������������ ���������� �������� 255.</small></label>
<textarea name="short_descr"><?=$short_descr?></textarea></p>
</div>

<div class="grid_16">
<p><label>������ <small>������������ ���������� �������� 10000.</small></label>
<textarea id="text" name="full_descr"><?=$full_descr?></textarea></p>
<p class="submit"><input value="��������" type="reset"> <input
	value="���������" type="submit"></p>
</div>

</div>
</form>
