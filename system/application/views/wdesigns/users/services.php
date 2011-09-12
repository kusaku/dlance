<div class="yui-g">
<ul class="usernav">
	<li><a href="/user/<?=$username?>">����������</a></li>
	<li><a href="/users/designs/<?=$username?>">�������</a></li>
	<li><a href="/users/portfolio/<?=$username?>">���������</a></li>
	<li class="active"><a href="/users/services/<?=$username?>">������</a></li>
	<li><a href="/users/reviews/<?=$username?>">������</a></li>
	<li><a href="/users/followers/<?=$username?>">����������</a></li>
</ul>
</div>

<div class="yui-g usertitle">
<h1><?=$surname?> <?=$name?> (<?=$username?>)</h1>

<? if( $this->username == $username ) :?>
<p><a href="/account/services">�������������</a></p>
<? endif; ?>
<p class="desc"><?=$short_descr?></p>
</div>


<div id="yui-main">
<div id="usermain" class="yui-b"><? if( !empty($services) ): ?>

<table class="services">
	<tbody>

	<? foreach($categories as $row): ?>

	<? if( $row['parent_id'] == 0): ?>

	<? if( in_array($row['id'], $select_parent) ): //��������� �������?>
		<tr>
			<th class="txtl">
			<h5><?=$row['name']?></h5>
			</th>
		</tr>
		<? endif; ?>

		<? endif; ?>

		<? foreach($categories as $row2): ?>

		<? if( $row['id'] == $row2['parent_id'] ): //��������� ���������?>

		<? if( in_array($row2['id'], $select) ): ?>
		<tr>
			<td><?=$row2['name']?></td>
		</tr>
		<? endif; ?>
		<? endif; ?>

		<? endforeach; ?>

		<? endforeach; ?>

	</tbody>
</table>


		<? else: ?>
<p>������ �� ���������������.</p>
		<? endif; ?></div>
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
