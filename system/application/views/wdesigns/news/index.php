<h2>Новости проекта</h2>

<? if( !empty($news) ): ?>
<? foreach($news as $row): ?>
	<div class="newsTitle"><a href="/news/<?=$row['id']?>.html"><?=$row['title']?></a> </div>
	<div class="newsDate"><?=$row['date']?></div>
	<div class="newsDesc"><?=$row['descr']?></div>
<? endforeach; ?>
<?=$page_links?>
<? else: ?>
<p>Ничего не найдено.</p>
<? endif; ?>


