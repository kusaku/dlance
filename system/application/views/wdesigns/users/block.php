<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div id="usercard" class="bd clearfix"><img src="images/user.gif"
	alt="<?=$type?>" class="grp-icon" />
<div class="clearfix"><img src="<?=$userpic?>" alt="" class="avatar" />
<ul class="ucard">

	<li class="age">�������: <?=$dob?></li>

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
			<tr>
				<td colspan="2" class="noborder green"></td>
			</tr>

</table>
</div>
<div class="ft"></div>
</div>
