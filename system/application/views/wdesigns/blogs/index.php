<div class="sideBar">
	<div class="designsCategories">
		<h3><a href="/blogs">Все блоги</a></h3>
		<ul>
			<?php foreach ($categories as $row): ?>
			<li class="lvl-1">
				<a href="/blogs/index/?category=<?=$row['id']?>"><?= $row['name']?></a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<div class="content">
	<div>
		<a href="/blogs/add/"><b>+ Добавить запись</b></a>
	</div>
	<br/>
	<?php if (! empty($blogs)): ?>
	<?php foreach ($blogs as $row): ?>
	<div class="blogTitle">
		<a href="/blogs/<?=$row['id']?>.html"><?= $row['title']?></a>
	</div>
	<div class="blogDate">
		<?= $row['date']?>
	</div>
	<div class="blogDesc">
		<?= nl2br($row['text'])?>
	</div>
	<div class="blogComments">
		<span>Комментарии (<?= $row['count_comments']?>)</span>
		&nbsp;|&nbsp; Категория: <a href="/blogs/index/?category=<?=$row['category_id']?>"><?= $row['category']?></a>
		&nbsp;|&nbsp; <span>Автор: <a href="/user/<?=$row['username']?>"><?= $row['username']?></a></span>
	</div>
	<?php endforeach; ?>
	<?= $page_links?>
	<?php else : ?>
	<p>Ничего не найдено.</p>
	<?php endif; ?>
</div>
