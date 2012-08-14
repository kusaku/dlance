<div class="sideBar">
	<div class="designsCategories">
		<h3><a href="/help/">Все разделы</a></h3>
		<ul>
		<? foreach($categories as $row): ?> 
			<li class="lvl-1"><a href="/help/index/?category=<?=$row['id']?>"><?=$row['name']?></a></li>
		<? endforeach; ?>
		</ul>
	</div>
</div>
<div class="content">
	<h2 class="title"><?=$title?></h2>
	<div class="entry">
		<p><?=nl2br($text)?></p>
	</div>
</div>