<?=validation_errors()?>
<div class="yui-g">
<h1 class="title"><a href="/recovery">�������������� ������</a></h1>
<div class="subtitle"></div>
<div class="content">
<div id="passrecover" class="rnd">
<div>
<div>
<div>
<h3>����� ������������ ������, ��������� ������������� �����������</h3>
<form action="" method="post">
<ul>
	<li>1. ������� ��� ����� � email</li>
	<li>2. �� �������� ��������� �� ��� email ����� � ������� � ����
	������. �������� �� ���, ����� �����</li>
	<li>3. �����, ������� � ��� ������� � ���������� ����� ������</li>
	<li class="clearfix"><label for="email">��� �����: </label> <input
		type="text" class="text" name="username"
		value="<?=set_value('username')?>" size="20" maxlength="15" /> <label
		for="email">��� email: </label> <input id="email" type="text"
		class="text" name="email" value="<?=set_value('email')?>" size="20"
		maxlength="48" /></li>
	<input value="���������" type="submit" />
</ul>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
