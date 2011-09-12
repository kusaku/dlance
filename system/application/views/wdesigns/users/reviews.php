<div class="yui-g">
<ul class="usernav">
	<li><a href="/user/<?=$username?>">����������</a></li>
	<li><a href="/users/designs/<?=$username?>">�������</a></li>
	<li><a href="/users/portfolio/<?=$username?>">���������</a></li>
	<li><a href="/users/services/<?=$username?>">������</a></li>
	<li class="active"><a href="/users/reviews/<?=$username?>">������</a></li>
	<li><a href="/users/followers/<?=$username?>">����������</a></li>
</ul>
</div>

<div class="yui-g usertitle">
<h1><?=$surname?> <?=$name?> (<?=$username?>)</h1>

<? if( $this->username != $username ) :?>
<p><a href="/users/reviews_add/<?=$username?>">�������� �����</a></p>
<? endif; ?>
<p class="desc"><?=$short_descr?></p>
</div>


<div id="yui-main">
<div id="usermain" class="yui-b"><? if( !empty($reviews) ): ?>
<div id="reviews" class="clearfix">
<table class="reviews">
	<tr>
		<th class="txtl">������������ / �������</th>
		<th style="width: 70px;">������</th>
	</tr>

	<? foreach($reviews as $row): ?>
	<tr>
		<td class="review-card"><img src="<?=$row['userpic']?>" alt=""
			class="avatar" />
		<ul class="rcard">
			<li class="black"><a href="/user/<?=$row['username']?>"><?=$row['surname']?>
			<?=$row['name']?> (<?=$row['username']?>)</a></li>
			<li>���� �����������: <?=$row['created']?></li>
			<li>��������� �����: <?=$row['last_login']?></li>
			<li><a href="/contacts/send/<?=$row['username']?>">������ ���������</a></li>
		</ul>
		<? if( $this->team == 2 ) :?> <a
			href="/users/reviews_edit/<?=$row['id']?>">�������������</a> | <a
			href="/users/reviews_del/<?=$row['id']?>">�������</a> <? endif; ?></td>
		<td class="txtc review-mark"><?=$row['rating']?></td>
	</tr>


	<tr>
		<td colspan="3" class="review-target"><? if( $row['rating'] == 1 ): ?>
		<img class="revtype" src="/templates/wdesigns/css/img/rev1.png"> <? else: ?>
		<img class="revtype" src="/templates/wdesigns/css/img/rev0.png"> <? endif; ?>



		</td>
	</tr>



	<tr>
		<td colspan="3" class="review-text">
		<p><?=nl2br($row['text'])?></p>

		<span class="review-date">���������: <?=$row['date']?></span> <? if( !empty($row['moder_date']) ): ?>
		<br />
		<span class="review-date">���������: <a
			href="/user/<?=$row['moder_user_id']?>"><?=$row['moder_user_id']?></a>:
			<?=$row['moder_date']?></span> <? endif; ?></td>
	</tr>
	<? endforeach; ?>
	<tr>
		<td colspan="3" class="sep txtr">&nbsp;</td>
	</tr>
</table>
</div>
<?=$page_links?> <? else: ?>
<p>������ �����������.</p>
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
