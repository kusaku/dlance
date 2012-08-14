<div class="yui-g">
	<h1 class="title"><?=$title?></h1>
	<div class="desc"><?=$descr?></div>
	<noindex>
	<div class="subtitle">Дата: <?=$date?></div>
	</noindex>

</div>


<div id="yui-main">
<div class="yui-b clearfix">

<div class="content">
<?=nl2br($text)?>
</div>

</div>
</div>



<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div class="bd clearfix">

<div class="sideblock">
<h3>Новости проекта</h3>
	<ul class="latest-page">
<? foreach($newest_news as $row): ?>
		<li><?=$row['date']?> | <a href="/news/<?=$row['id']?>.html"><?=$row['title']?></a></li>
<? endforeach; ?>
	</ul>

</div>

</div>
<div class="ft"></div>
</div>