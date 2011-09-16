<div id="yui-main">
<div class="yui-b clearfix">
	<div class="post">
	<h2 class="title"><?=$title?></h2>
		<div class="entry">
			<p><?=nl2br($text)?></p>
		</div>
	</div>
</div>
</div>


<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div class="bd clearfix">

<div class="sideblock">
<ul class="marketnav">
<h3><a href="/help/">Все разделы</a></h3>
<li class="lvl-1"><a href="/help/">Все разделы</a></li>
<? foreach($categories as $row): ?> 
<li class="lvl-1"><a href="/help/index/?category=<?=$row['id']?>"><?=$row['name']?></a></li>
<? endforeach; ?>
</ul>
</div>

</div>
<div class="ft"></div>
</div>