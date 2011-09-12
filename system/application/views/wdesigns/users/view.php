<div class="yui-g">
<ul class="usernav">
	<li class="active"><a href="/user/<?=$username?>">����������</a></li>
	<li><a href="/users/designs/<?=$username?>">�������</a></li>
	<li><a href="/users/portfolio/<?=$username?>">���������</a></li>
	<li><a href="/users/services/<?=$username?>">������</a></li>
	<li><a href="/users/reviews/<?=$username?>">������</a></li>
	<li><a href="/users/followers/<?=$username?>">����������</a></li>
</ul>
</div>

<div class="yui-g usertitle">
<h1><?=$surname?> <?=$name?> (<?=$username?>)</h1>

<? if( $this->username == $username ) :?>
<p><a href="/account/profile">�������������</a></p>
<? endif; ?>

<p class="desc"><?=nl2br($short_descr)?></p>
</div>


<div id="yui-main">
<div id="usermain" class="yui-b">
<p class="infotitle">��������</p>

<? if( $logged_in ): ?>
<ul class="info">
	<li>E-mail: �������</li>
	<? if( !empty($icq) ):?>
	<li>ICQ: <?=$icq?></li>
	<? endif; ?>
	<? if( !empty($skype) ):?>
	<li>Skype: <?=$skype?></li>
	<? endif; ?>
	<? if( !empty($telephone) ):?>
	<li>�������: <?=$telephone?></li>
	<? endif; ?>
</ul>
	<? else: ?> ��� ���������� ������������ ��� ������������������ ���
��������� ���������� ������ <? endif; ?>

<p class="infotitle">����������</p>
<p class="userdesc"><?=nl2br($full_descr)?></p>



<p class="infotitle">�������������� ������</p>
<p class="userdesc">

<ul class="info">
<? if( !empty($profile['price_1']) ):?>
	<li>���� �� ��� ������: <strong><?=$profile['price_1']?> USD</strong></li>
	<? endif; ?>
	<? if( !empty($profile['price_2']) ):?>
	<li>���� �� ����� ������: <strong><?=$profile['price_2']?> USD</strong></li>
	<? endif; ?>
</ul>

</p>

</div>
</div>


<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div id="usercard" class="bd clearfix"><img src="images/user.gif"
	class="grp-icon" />
<div class="clearfix"><img src="<?=$userpic?>" alt="" class="avatar" />
<ul class="ucard">

	<li class="age">�������: <?=$age?></li>

	<li>���: <?=$sex?></li>

</ul>
</div>
<div class="sendpm"><a href="/contacts/send/<?=$username?>">������
���������</a></div>

<table class="userstats">
	<tr>
		<td>���� �����������:</td>
		<td><?=$created?></td>
	</tr>

	<tr>
		<td>��������� �����:</td>
		<td><?=$last_login?></td>
	</tr>
	<tr>

		<tr>
			<td>����������:</td>
			<td><?=$views?></td>
		</tr>
		<tr>
			<tr>
				<td>��������������:</td>
				<td><?=$country_id?> / <?=$city_id?></td>
			</tr>
			<tr>
				<td colspan="2" class="noborder green"></td>
			</tr>

</table>

	<? if( !empty($website) ):?><b><noindex><a href="<?=$website?>"
	target="_blank" rel="nofollow"><?=$website?></a></noindex></b><? endif; ?>

</div>
<div class="ft"></div>
</div>
