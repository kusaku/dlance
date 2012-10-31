<h2>Новости проекта</h2>

<?php if( !empty($news) ): ?>
<?php foreach($news as $row): ?>
	<div class="newsTitle"><a href="/news/<?=$row['id']?>.html"><?=$row['title']?></a> </div>
	<div class="newsDate"><?=$row['date']?></div>
	<div class="newsDesc"><?=$row['descr']?></div>
<?php endforeach; ?>
<?=$page_links?>
<?php else: ?>
<p>Ничего не найдено.</p>
<?php endif; ?>

