<div class="yui-g">
<ul class="usernav">
	<li><a href="/user/<?=$username?>">����������</a></li>
	<li><a href="/users/designs/<?=$username?>">�������</a></li>
	<li><a href="/users/portfolio/<?=$username?>">���������</a></li>
	<li><a href="/users/services/<?=$username?>">������</a></li>
	<li><a href="/users/reviews/<?=$username?>">������</a></li>
	<li class="active"><a href="/users/followers/<?=$username?>">����������</a></li>
</ul>
</div>

<div class="yui-g usertitle">
<h1><?=$surname?> <?=$name?> (<?=$username?>)</h1>

<p class="desc"><?=$short_descr?></p>
</div>


<div id="yui-main">
<div id="usermain" class="yui-b"><? if( !empty($followers) ): ?>
<div class="following"><? foreach($followers as $row): ?>
<div><img src="<?=$row['userpic']?>" alt="" class="avatar" width="60px" /><a
	href="/user/<?=$row['username']?>" rel="follows"><?=$row['username']?></a>
</div>
<? endforeach; ?></div>
<?=$page_links?> <? else: ?>
<p>���������� �����������.</p>
<? endif; ?></div>
</div>




<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div id="usercard" class="bd clearfix">
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


	<? if( $positive or $negative ): ?>
		<tr>
			<td>������:</td>
			<td><a class="rev-positive"
				href="/users/reviews/<?=$username?>/?type=positive"><?=$positive?></a>
				<? if( $negative ): ?>| <a class="rev-negative"
				href="/users/reviews/<?=$username?>/?type=negative"><?=$negative?></a><? endif; ?>
			</td>
		</tr>
		<? endif; ?>



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
