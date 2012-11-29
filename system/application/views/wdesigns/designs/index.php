<script type="text/javascript">
	(function($){
		$(function(){
			$("#slider1").bxSlider({
				infiniteLoop: false,
				hideControlOnEnd: true
			});
			$("a.zoom").fancybox({
				titlePosition: 'over'
			});
			$("input[placeholder]").placeholder();
		});
	}(jQuery));
</script>
<div class="sideBar">
	<div class="tagsCloud slideBox">
		<h3>Популярные теги:</h3>
		<ul id="slider1">
			<!-- Облако тегов, вывод надо рассчитать -->
			<?= $tagcloud?>
		</ul>
	</div>
	<div class="designsCategories">
		<h3><a href="/designs">Дизайны:</a></h3>
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
				<a href="/designs/index/?category=<?=$row['id']?>"><?= $row['name']?></a>
				<?php endif; ?>
				<?php if (! empty($active) and $active == $row['id']): ?>
				<ul>
					<?php foreach ($categories as $row2): ?>
					<?php if ($row['id'] == $row2['parent_id']): ?>
					<li class="lvl-2">
						<a href="/designs/index/?category=<?=$row2['id']?>"><?= $row2['name']?></a>
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
	</div>
</div>
<div class="content">
	<div class="searchResults">
		<div class="searchResultsHeader">
			<div class="sortBy">
				<p>сортировать по:</p>
				названию<a<?= ($search['order_by'] == 'title' and $search['order_dir'] == 'asc') ? 'class="abs"' : ''?> href="/designs/search/?<?=http_build_query(array_merge($search, array('order_by'=>'title','order_dir'=>'asc')));?>&">&darr;</a>
				<a<?= ($search['order_by'] == 'title' and $search['order_dir'] == 'desc') ? 'class="abs"' : ''?> href="/designs/search/?<?=http_build_query(array_merge($search, array('order_by'=>'title','order_dir'=>'desc')));?>&">&uarr;</a>
				рейтингу<a<?= ($search['order_by'] == 'rating' and $search['order_dir'] == 'asc') ? 'class="abs"' : ''?> href="/designs/search/?<?=http_build_query(array_merge($search, array('order_by'=>'rating','order_dir'=>'asc')));?>&">&darr;</a>
				<a<?= ($search['order_by'] == 'rating' and $search['order_dir'] == 'desc') ? 'class="abs"' : ''?> href="/designs/search/?<?=http_build_query(array_merge($search, array('order_by'=>'rating','order_dir'=>'desc')));?>&">&uarr;</a>
			</div>
			<h3>Все дизайны сайтов:</h3>
		</div>
		<div class="searchResultsList">
			<?php if (! empty($data)): ?>
			<ul class="designsList">
				<?php foreach ($data as $row): ?>
				<?php if ($row['sales'] == 0): ?>
				<li class="unique">
					<a href="<?=$row['full_image1']?>" class="zoom" title="<?=$row['title']?>"><img src="<?=$row['small_image1']?>" alt="<?=$row['title']?>"/></a>
					<p>
						<a href="/designs/<?=$row['id']?>.html"><?= $row['title']?></a>
					</p>
					<p>
						<?= $row['category']?>
						<br/>
						Исходник: <?= $row['source']?>
					</p>
					<p>
						Рейтинг: <span><?= $row['rating']?></span>
						<br/>
						Цена: <span><?= $row['price_1']?> руб.</span>
					</p>
					<p class="details">
						<a href="/designs/<?=$row['id']?>.html">Подробнее</a>
					</p>
				</li>
				<?php else : ?>
				<li>
					<a href="<?=$row['full_image1']?>" class="zoom" title="<?=$row['title']?>"><img src="<?=$row['small_image1']?>" alt="<?=$row['title']?>"/></a>
					<p>
						<a href="/designs/<?=$row['id']?>.html"><?= $row['title']?></a>
					</p>
					<p>
						<?= $row['category']?>
						<br/>
						Исходник: <?= $row['source']?>
					</p>
					<p>
						Рейтинг: <span><?= $row['rating']?></span>
						<br/>
						Цена: <span><?= $row['price_1']?> руб.</span>
					</p>
					<p class="details">
						<a href="/designs/<?=$row['id']?>.html">Подробнее</a>
					</p>
				</li>
				<?php endif; ?>
				<?php endforeach; ?>
			</ul>
			<?php else : ?>
			<p>Ничего не найдено.</p>
			<?php endif; ?>
			<div class="paginationControl">
				<?= $page_links?>
			</div>
			<div class="itemsOnPage">
				<p>Элементов на страницу:</p>
				<ul class="pageList">
					<?php foreach (array( 10,20,50,100 ) as $limit): ?>
					<?php if ($limit == $search['limit']): ?>
					<li class="active">
						<?= $limit?>
					</li>
					<?php else : ?>
					<li>
						<a href="/designs/index/?<?=http_build_query(array_merge($search, array('limit'=>$limit)));?>">
							<?= $limit?>
						</a>
					</li>
					<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
