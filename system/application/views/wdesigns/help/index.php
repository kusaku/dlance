<div class="sideBar">
	<div class="designsCategories">
		<h3><a href="/help/">Все разделы</a></h3>
		<ul>
		<?php foreach($categories as $row): ?> 
			<li class="lvl-1"><a href="/help/index/?category=<?=$row['id']?>"><?=$row['name']?></a></li>
		<?php endforeach; ?>
		</ul>
	</div>
</div>
<div class="content">
	<h3>Помощь</h3>
	<a href="/help/">Все разделы</a>
	<ul>
	<?php foreach($help_categories as $row): ?> 
	<li class="lvl-1"><a href="/help/index/?category=<?=$row['id']?>"><?=$row['name']?></a><ul>
		<?php foreach($help_pages as $row2): ?> 
			<?php if( $row['id'] == $row2['category'] ): ?>
				<li class="lvl-2"><a href="/help/<?=$row2['id']?>.html"><?=$row2['title']?></a></li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul></li>
	<?php endforeach; ?>
	</ul>
</div>