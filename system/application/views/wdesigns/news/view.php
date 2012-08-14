<h2>Новости проекта</h2><br/>
<h3><b><?=$title?></b></h3>
<div class="newsQuote"><?=$descr?></div>
<noindex>
<div class="newsDate"><?=$date?></div>
</noindex>


<div class="newsContent">
<?=nl2br($text)?>
</div>


<h3>Другие новости проекта:</h3>
<? foreach($newest_news as $row): ?>
	<p><?=$row['date']?> | <a class="orange" href="/news/<?=$row['id']?>.html"><?=$row['title']?></a></p>
<? endforeach; ?>