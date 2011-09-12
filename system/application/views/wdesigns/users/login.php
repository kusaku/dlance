<?=validation_errors()?>
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
