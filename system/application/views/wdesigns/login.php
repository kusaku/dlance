<? if( $logged_in ): ?>
<div id="userbar" class="clearfix">
<ul class="ltop">
	<img src="<?=$userpic?>" alt="" class="userpic">

	<li class="usr"><a href="/user/<?=$username?>"><?=$name?> <?=$surname?>
	(<?=$username?>)</a> <br />
	<a href="/account/profile">���������</a></li>

	<li class="pm"><a href="/contacts/">��������</a> <? if( $messages ): ?>
	(<?=$messages?>) <? endif; ?>

	<li class="pm"><a href="/account/events">�������</a> <? if( $events ): ?>
	(<?=$events?>) <? endif; ?></li>

	<li>������: <a href="/account/balance/"><?=$balance?> ������</a></li>

	<li>����������� ������: <a href="/account/tariff/"><?=$tariff?></a></li>

	<li>�������: <a href="#"><?=$rating?></a></li>

</ul>
<ul class="rtop">
	<li>&nbsp;</li>
	<li><a href="/account">��� �������</a></li>
	<li><a href="/logout">�����</a></li>
</ul>
</div>
<? else: ?>
<div id="userbar" class="clearfix" style="height: 32px">
<form name="login" action="/login" method="post">
<ul id="authline">
	<li class="reg"><a href="/register">�����������</a></li>
	<li class="log">����������� &nbsp; <input class="authtext" type="text"
		name="username" size="12" maxlength="32" /> &nbsp; <input
		class="authtext" type="password" name="password" size="12"
		maxlength="32" /></li>
	<li class="rem"><input type="checkbox" class="authcheckbox"
		name="rcookiettl" value="86400" /> ��������� &nbsp; <input
		name="submit" value='����' type="submit"></li>
	<li class="rec"><a rel="nofollow" href="/recovery">��������� ������</a></li>


	<ul class="rtop">
		<li><a href="/account/">��� �������</a></li>
	</ul>

</ul>



</form>
</div>
<? endif; ?>