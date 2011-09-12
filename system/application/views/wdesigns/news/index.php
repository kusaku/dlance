<div id="yui-main">
<div class="yui-b clearfix"><? if( !empty($news) ): ?> <? foreach($news as $row): ?>
<div class="rnd mb10">
<div>
<div>
<div>
<div class="row-title"><a href="/news/<?=$row['id']?>.html"><?=$row['title']?></a>
</div>
<div class="row-date"><?=$row['date']?></div>
<div class="row-desc clearfix skip-rating"><?=$row['descr']?></div>
</div>
</div>
</div>
</div>
<? endforeach; ?> <?=$page_links?> <? else: ?>
<p>������ �� �������.</p>
<? endif; ?></div>
</div>


<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div class="bd clearfix">

<div class="sideblock">
<h3>������� �������</h3>
<ul class="latest-page">
<? foreach($newest_news as $row): ?>
	<li><?=$row['date']?> | <a href="/news/<?=$row['id']?>.html"><?=$row['title']?></a></li>
	<? endforeach; ?>
</ul>

</div>

</div>
<div class="ft"></div>
</div>
