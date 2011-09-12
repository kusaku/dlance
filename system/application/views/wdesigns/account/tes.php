<script type='text/javascript' src='/templates/js/thickbox/thickbox.js'></script>
<link
	rel="stylesheet" type="text/css"
	href="/templates/js/thickbox/thickbox.css" />

<script type="text/javascript">

$(document).ready(function(){
$('.thickbox').trigger('click');
});

</script>

<?=validation_errors()?>
<a href="#TB_inline?height=250&width=500&inlineId=modalWindow"
	class="thickbox" style="display: none"><strong>�������� ������ </strong></a>
<div id="authform" class="yui-g">
<h1>���� � �������</h1>
<form name="login" action="/login" method="post">
<div class="rnd">
<div>
<div>
<div>

<ul>
	<li><label for="rusername">��� ������������</label> <input type="text"
		class="text" name="username" value="<?=set_value('username')?>"
		size="16" maxlength="15" /></li>
	<li><label for="ruserpassword">������</label> <input type="password"
		class="password" name="password" size="16" maxlength="32" /></li>
	<li><input type="checkbox" class="authcheckbox" name="rcookiettl"
		value="86400" /> ���������</li>

</ul>
</div>
</div>
</div>
</div>
<input name="submit" type="submit" value="����"></form>
</div>

<div id="modalWindow" style="display: none;">
<div>

<div align="center" style="margin: 10px;">��������� ������ �������� �
������� ��� �� ����������� �����, ����� ��������� ���� ������ �� ������
������� � ������� ����� ����� � ��� �������!</div>

������ ��� ����� � �������:<br />
<br />

�����: <?=$username?><br />
������: <?=$password?></div>

</div>
