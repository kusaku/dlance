<div class="yui-g">

<div align="right"><? if( !empty($check) ): ?> <a
	href="/blogs/edit/<?=$id?>">�������������</a> <? endif; ?></div>

<h1 class="title"><?=$title?></h1>
<div class="desc"><?=$descr?></div>

<div class="subtitle">�����: <a href="/user/<?=$username?>"><?=$username?></a>
&nbsp; ���������: <a href="/blogs/index/?category=<?=$category_id?>"><?=$category?></a>
&nbsp; ����: <?=$date?></div>

</div>


<div id="yui-main">
<div class="yui-b clearfix">

<div class="content"><?=nl2br($text)?></div>

<div class="subcontent"><span>�����: <?=$username?></span></div>


<?=$comments?></div>
</div>


<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div class="bd clearfix">

<ul class="marketnav">
	<h3><a href="/blogs">��� �����</a></h3>
	<? foreach($categories as $row): ?>
	<li class="lvl-1"><a href="/blogs/index/?category=<?=$row['id']?>"><?=$row['name']?></a></li>
	<? endforeach; ?>
</ul>
</div>
<div class="ft"></div>
</div>
