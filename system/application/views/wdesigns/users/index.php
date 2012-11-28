<div class="sideBar">
	<div class="designsCategories">
		<h3><a href="/users/all/">Все дизайнеры</a></h3>
		<?php 
		if (! empty($category)) {
			$active = $category;
			foreach ($categories as $row):
				if ($active == $row['id']):
					//Если у активной категории имеется раздел, присваиваем раздел
					if ($row['parent_id'] != 0):
						$active = $row['parent_id'];
					endif;
				endif;
			endforeach;
		}
		?>
		<ul>
			<?php foreach ($categories as $row): ?>
			<?php if ($row['parent_id'] == 0): ?>
			<li class="<?php if( !empty($active) and $row['id'] == $active ): ?>active<?php endif ?>">
				<a href="/users/all/?category=<?=$row['id']?>"><?= $row['name']?></a>
				<?php endif; ?>
				<?php if (! empty($active) and $active == $row['id']): ?>
				<ul>
					<?php foreach ($categories as $row2): ?>
					<?php if ($row['id'] == $row2['parent_id']): ?>
					<li class="lvl-2">
						<a href="/users/all/?category=<?=$row2['id']?>"><?= $row2['name']?></a>
						<span>(<?= $row2['number']?>)</span>
					</li>
					<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</li>
			<?php else : ?>
			<?php if ($row['parent_id'] == 0) { echo "</li>"; } ?>
			<?php endif; ?>
			<?php endforeach; ?>
		</ul>
		<?php if (! empty($users_descr)): ?>
		<div class="sideblock nomargin">
			<p class="freetext">
				<?= $users_descr?>
			</p>
		</div>
		<?php endif; ?>
	</div>
</div>
<div class="content">
	<div class="searchResults">
		<div class="searchResultsHeader">
			<div class="sortBy">
				<a href="/users/search/">Расширенный поиск</a>
			</div>
			<h3>Дизайнеры<?php if (! empty($title)): ?> / <?= $title?><?php endif; ?></h3>
		</div>
		<div class="searchResultsList">
			<?php if (! empty($data)): $n = 0; ?>
			<ul class="designersList">
				<?php foreach ($data as $row=>$value): ?>
				<li>
					<p class="number">
						<?= $row + 1?>
					</p>
					<a href="/user/<?=$value['username']?>" title="перейти к портфолио" class="avatar <?=$value['tariffname']?>"><!-- Нужна маленькая аватарка --><img src="<?=$value['userpic']?>" alt="<?=$value['username']?> avi"/></a>
					<div class="infoblock">
						<p>
							<a class="username" href="/user/<?=$value['username']?>" title="перейти к портфолио"><?= $value['username']?></a>
						</p>
						<p>
							<?= "{$value['name']} {$value['surname']}"?>
						</p>
						<p>
							<a class="message" href="/contacts/send/<?=$value['username']?>">Личное сообщение</a>
						</p>
					</div>
					<div class="infoblock">
						<p>&nbsp;</p>
						<p>
							Последний визит: <?= $value['last_login']?>
						</p>
						<p>
							Дата регистрации: <?= $value['created']?>
						</p>
					</div>
					<!-- Не уверен, что это рейтинг -->
					<div class="rating">
						<?= $value['rating']?>
					</div>
				</li>
				<?php endforeach; ?>
			</ul>
			<div class="paginationControl">
				<?= $page_links?>
			</div>
			<?php else : ?>
			Дизайнеров не найдено
			<?php endif; ?>
		</div>
	</div>
</div>
