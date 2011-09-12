<div id="yui-main">
<div class="yui-b clearfix">
<div class="index-about">
<h1>����� �� ������� � ������� �������� ��� ������ Dlance.ru</h1>
<p>��� ����������� ����������� ����� �� ������ ������� ����� �� ����� �
��������� �������� � ��������, �� �� � ������������ ���������� ��������
� ������������ ����� ��������, �������, �� ����, �������� ��������
��������� � �������������� ������ ������� � ������ ��������. � ��� �����
��� ����� ������: �� ������� ��������� ������ ��� ���� ��������: ��,
������� �������� � ��������� � ��, ������� ����� �� �������. ������
Dlance.ru ������������ ����� ����� ���������� �������� ������, �������
������ ��������� ��� ����� � ���������� ����� � �� ��������� �����.
������� ������ ��������� ��������� ��������� ������������ �� ������
��������. ��-������, ��� ���������� ������������� ������� �����������
��������� ��� ���� ��� �����������. ��-������, ��������� �������������
�������� ����������� � ����. ����� ������ �������� ���������� �����
������ �� ������������� ������ �������. �������� ��� ������ �����
�������� ������ � �����������, � ����� �� ��������� �� ���
�������������� ������. � ��� �������, ���� �� ��������� ����������� �
�������� ������������ ������ ������������� ������� �������� ������, �� �
��� ���� ����������� ����� ���� �������, ������� ����� ��������� ������
���. �� ������� ��������� �� ������������� ����� � ���������������
�������� ������, �� �������� �� ������ ������ �����. ������������
��������� ����� ������ ����� � �������� ������� ������ ��� ����������� �
������ ��� ������ ������ Dlance.ru ���������� ������� ��� ���
�����������, ��� � ��� �������������.</p>
</div>

<h2>��� ����������������� �������� �����������</h2>

<div id="ptf">
<div class="top-payed">
<ul>
<? foreach($top_designs as $row): ?>
	<li><a href="#"><img src="<?=$row['small_image']?>"
		title="<?=$row['title']?>" width="50px"></a>
	<div><strong><a href="/designs/<?=$row['id']?>.html"><?=$row['title']?></a></strong>
	�������: <?=$row['rating']?></div>
	</li>
	<? endforeach; ?>
</ul>
</div>
</div>

<br />
<br />
<br />



<div id="bubble-2" class="mb20"></div>
<div align="right"><a href="/designs/add/"><b>�������� ������</b></a></div>
<div class="latest-orders">
<h3>��������� ������� ������</h3>

<div class="offers-stateline"><script type="text/javascript"
	src="/templates/js/currency.js"></script> <span> <a id="setRur"
	rel="nofollow" href="#" class="bold">�����</a> | <a id="setEur"
	rel="nofollow" href="#">����</a> | <a id="setUsd" rel="nofollow"
	href="#">�������</a> <a id="setUah" rel="nofollow" href="#">������</a>
</span></div>

<table class="listorder">
	<tr>
		<td class="topline lft txtl"><a
			href="/designs/index/?order_field=title">��������� / ������</a></td>
		<td class="topline" style="width: 70px;"><a
			href="/designs/index/?order_field=sales">�������</a></td>
		<td class="topline" style="width: 70px;"><a
			href="/designs/index/?order_field=rating">�������</a></td>
		<td class="topline" style="width: 70px;"><a
			href="/designs/index/?order_field=price_1">����</a></td>
		<td class="topline rht" style="width: 70px;"><a
			href="/designs/index/?order_field=price_2">���� ������</a></td>
	</tr>

	<? if( !empty($data) ): ?>

	<?=show_highslide()?>

	<? foreach($data as $row): ?>
	<tr>
		<td class="ordertitle"><strong><a href="/designs/<?=$row['id']?>.html"><?=$row['title']?></a></strong><br>

		<a href="<?=$row['full_image']?>" class="highslide"
			onclick="return hs.expand(this)"> <img src="<?=$row['small_image']?>"
			title="<?=$row['title']?>" /> </a>


		<div class="inf"><?=$row['section']?> / <?=$row['category']?> | <?=$row['date']?>

		</div>
		</td>
		<td class="offcount"><?=$row['sales']?></td>
		<td class="offcount"><?=$row['rating']?></td>
		<td class="budget"><?=$row['price_1']?> ������</td>
		<td class="budget" <? if( $row['sales'] > 0 ): ?>
			style="text-decoration: line-through" <? endif; ?>><?=$row['price_2']?>
		������</td>


	</tr>
	<? endforeach; ?>

	<? else: ?>
	<p>������ �� �������.</p>
	<? endif; ?>
	<tr>
		<td colspan="1" class="topline lft txtl">&nbsp;</td>
		<td colspan="4" class="topline rht txtr"><a href="/designs">��������
		���</a></td>
	</tr>
</table>

</div>
</div>
</div>


<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div class="bd clearfix">

<div class="sideblock">
<h3>������� �������</h3>
<ul class="latest-page">
<? foreach($news as $row): ?>
	<li><?=$row['date']?> | <a href="/news/<?=$row['id']?>.html"><?=$row['title']?></a></li>
	<? endforeach; ?>
</ul>
</div>

<div class="sideblock clearfix">
<h3>����������</h3>
<ul class="index-stats">
	<li><span><?=$count_designs?></span><a href="/designs">�������</a></li>
	<li class="last"><span><?=$count_users?></span>������������</li>
</ul>
</div>

<div class="sideblock clearfix">
<h3>������ �����</h3>
<div id="tagcloud">
<ul>
<?=$tagcloud?>
</ul>
</div>
</div>

<div class="sideblock">
<h3>TOP 10 �������������</h3>
<ol class="best-contractors">
<? foreach($top_users as $row): ?>
	<li><span>(<?=$row['views']?>)</span><a
		href="/user/<?=$row['username']?>"><?=$row['username']?></a></li>
		<? endforeach; ?>
</ol>
</div>

<div class="sideblock">
<h3>��������� ������������������ ������������</h3>
<ol class="best-contractors">
<? foreach($newest_users as $row): ?>
	<li><a href="/user/<?=$row['username']?>"><?=$row['username']?></a></li>
	<? endforeach; ?>
</ol>
</div>


<div class="sideblock nomargin">
<p class="freetext">�� ����� XXI ��� � � ������ ������ ������ ���������
������������ �� ������ ��� �������, ����� ���� ����������, ���������, ��
� ��� ������� �������� ��������! ��� ������ ����������� �� ����, ���
����� ��� ������ ������ �� ������ ��������� ��� �������. ������� ������
����� ������ �������. ���� �� ������ ������������ ���� ���� ��� ��� �
��� ��� ����, �� ��� ��� ����������� ����� �������� ����������� ������
����, � �������� ����� ����� ������ ������! Dlance.ru ������� ��� �
����! �������� �������� � ������ ���� ���������� ��� ������ � ������, ��
������ �� ����� �������� ���������� �� ������� ���������� ���-��
��������������, ��� ����� �������� ����. �� ����� Dlance.ru ������������
������ ����, ������� ��������. �� ����� Dlance.ru �� ������ �������� ���
���� ������ ��� �� ������ ��� ��������� �� �����! ���� �� �� ����
������� ������� web ������ Dlance.ru ��� ����� � ������ ���� �� ����
�����, ��������, �� ������ �������� �������, �� � ��������� ����
�������! ��� ��� �������� ��� ���! ������ � ���, ��� ���� ��������
������ ����� ��������� � ������ � �������������. ���������� ���� �������
� ��������� �������!</p>
</div>

</div>
<div class="ft"></div>
</div>
