<div id="yui-main">
<div class="yui-b clearfix"> 

<ul class="marketnav">
<li class="lvl-1"><a href="/help/">Все разделы</a></li>
<? foreach($help_categories as $row): ?> 

<li class="lvl-1"><a href="/help/index/?category=<?=$row['id']?>"><?=$row['name']?></a></li>
	<? foreach($help_pages as $row2): ?> 
		<? if( $row['id'] == $row2['category'] ): ?>
			<li class="lvl-2"><a href="/help/<?=$row2['id']?>.html"><?=$row2['title']?></a></li>
		<? endif; ?>
	<? endforeach; ?>
<? endforeach; ?>
</ul>

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