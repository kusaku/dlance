<div class="sideBar">
	<div class="designsCategories">
		<h3><a href="/blogs">Все блоги</a></h3>
		<ul>
			<? foreach ($categories as $row): ?>
			<li class="lvl-1">
				<a href="/blogs/index/?category=<?=$row['id']?>"><?= $row['name']?></a>
			</li>
			<? endforeach; ?>
		</ul>
	</div>
</div>
<div class="content">
	<div>
		<? if (! empty($check)): ?>
		<a href="/blogs/edit/<?=$id?>">Редактировать</a>
		<? endif; ?>
	</div>
	<div class="avatar">
		<a title="Перейти к портфолио" href="/user/<?=$username?>"></a>
		<img alt="<?=$username?>" src="<?=$userpic?>"/>
	</div>
	<div class="blogTitle">
		<?= $title?>
	</div>
	<div class="blogDate">
		<?= $descr?>
	</div>
	<div class="blogDesc">
		<?= nl2br($row['text'])?>
	</div>
	<div class="blogComments">
		Дата: <?= $date?> Автор:		<a href="/user/<?=$username?>"><?= $username?></a>
		&nbsp; Категория: <a href="/blogs/index/?category=<?=$category_id?>"><?= $category?></a>
		&nbsp;
	</div>
	<?= $comments?>
</div>
