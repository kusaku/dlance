<div id="yui-main">
<div class="yui-b">


<h1><a href="/account/designs">�������</a></h1>
<p class="subtitle">������ ����� ��������. ��� ���������� ������ �������
�������: "<a href="/designs/add/">�������� ������</a>"</p>

<div class="offers-stateline">������: <span> <a href="/account/designs">���</a>
| <a href="/account/designs/?status=1">�������� </a> | <a
	href="/account/designs/?status=2">����������� </a> | <a
	href="/account/designs/?status=3">�������� </a> </span></div>

<? if( !empty($data) ): ?> <?=show_highslide()?>
<table class="portfolio">
	<tr>
		<th style="width: 150px;">������</th>
		<th>�������� / ������� ��������</th>
	</tr>
	<? foreach($data as $row): ?>


	<tr>
		<td class="thumb" rowspan="3" style="width: 150px;"><a
			href="<?=$row['full_image']?>" class="highslide"
			onclick="return hs.expand(this)"> <img src="<?=$row['small_image']?>"
			title="<?=$row['title']?>" /> </a></td>
		<td class="info">���������: <?=$row['category']?></td>
	</tr>

	<tr>
		<td>
		<h4><a href="/designs/<?=$row['id']?>.html"><?=$row['title']?></a></h4>
		<p><?=$row['text']?></p>
		</td>
	</tr>

	<tr>
		<td>������: <?=$row['status']?> | ����: <?=$row['date']?></td>
	</tr>
	<tr>


		<td class="options" colspan="2"><span class="fr"> <a
			href="/designs/edit/<?=$row['id']?>">�������������</a> </span></td>
	</tr>
	<? endforeach; ?>
</table>
<?=$page_links?> <? else: ?>
<p>������� �����������.</p>
<? endif; ?></div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>