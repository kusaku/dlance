<div class="sideBar">
	<div class="tagsCloud slideBox">
		<ul id="slider1">
			<?= $tagcloud?>
		</ul>
	</div>
	<div class="designsCategories">
		<h3><a href="/designs">Дизайны:</a></h3>
		<?php if (! empty($category)) {
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
				<?php if ($input['order_field'] == 'title'): ?>
				<?php if ($input['order_field'] == 'title' and $input['order_type'] == 'desc'): ?>
				<a class="abs" href="/designs/index/?order_field=title&order_type=asc<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>">названию &darr;</a>
				<?php else : ?>
				<a class="abs" href="/designs/index/?order_field=title<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>">названию &uarr;</a>
				<?php endif; ?>
				<?php else : ?>
				<a href="/designs/index/?order_field=title<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>">названию</a>
				<?php endif; ?>
				<?php if ($input['order_field'] == 'rating'): ?>
				<?php if ($input['order_field'] == 'rating' and $input['order_type'] == 'desc'): ?>
				<a class="abs" href="/designs/index/?order_field=rating&order_type=asc<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>">рейтингу &darr;</a>
				<?php else : ?>
				<a class="abs" href="/designs/index/?order_field=rating<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>">рейтингу &uarr;</a>
				<?php endif; ?>
				<?php else : ?>
				<a href="/designs/index/?order_field=rating<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>">рейтингу</a>
				<?php endif; ?>
				<?php if ($input['order_field'] == 'sales'): ?>
				<?php if ($input['order_field'] == 'sales' and $input['order_type'] == 'desc'): ?>
				<a class="abs" href="/designs/index/?order_field=sales&order_type=asc<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>">кол-ву покупок &darr;</a>
				<?php else : ?>
				<a class="abs" href="/designs/index/?order_field=sales<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>">кол-ву покупок &uarr;</a>
				<?php endif; ?>
				<?php else : ?>
				<a href="/designs/index/?order_field=sales<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>">кол-ву покупок</a>
				<?php endif; ?>
				<?php if ($input['order_field'] == 'price_1'): ?>
				<?php if ($input['order_field'] == 'price_1' and $input['order_type'] == 'desc'): ?>
				<a class="abs" href="/designs/index/?order_field=price_1&order_type=asc<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>">цене &darr;</a>
				<?php else : ?>
				<a class="abs" href="/designs/index/?order_field=price_1<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>">цене &uarr;</a>
				<?php endif; ?>
				<?php else : ?>
				<a href="/designs/index/?order_field=price_1<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>">цене</a>
				<?php endif; ?>
				<?php if ($input['order_field'] == 'price_2'): ?>
				<?php if ($input['order_field'] == 'price_2' and $input['order_type'] == 'desc'): ?>
				<a class="abs" href="/designs/index/?order_field=price_2&order_type=asc<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>">цене выкупа &darr;</a>
				<?php else : ?>
				<a class="abs" href="/designs/index/?order_field=price_2<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>">цене выкупа &uarr;</a>
				<?php endif; ?>
				<?php else : ?>
				<a href="/designs/index/?order_field=price_2<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>">цене выкупа</a>
				<?php endif; ?>
			</div>
			<h3>Все дизайны сайтов:</h3>
		</div>
		<div>
			<p>
				<a href="/designs/add/"><strong>+ Добавить дизайн на продажу</strong></a>
			</p>
		</div>
		<div class="searchResultsList">
			<?php if (! empty($data)): ?>
			<ul class="designsList">
				<?php foreach ($data as $row): ?>
				<?php if ($row['sales'] == 0): ?>
				<li class="unique">
					<a href="<?=$row['full_image']?>" class="zoom" title="<?=$row['title']?>"><img src="<?=$row['small_image']?>" alt="<?=$row['title']?>"/></a>
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
						<span class="new">Скачиваний: <?= $row['sales']?></span>
						<br/>
						Цена: <span><?= $row['price_1']?> руб.</span>
					</p>
					<p class="details">
						<a href="/designs/<?=$row['id']?>.html">Купить первым!</a>
					</p>
				</li>
				<?php else : ?>
				<li>
					<a href="<?=$row['full_image']?>" class="zoom" title="<?=$row['title']?>"><img src="<?=$row['small_image']?>" alt="<?=$row['title']?>"/></a>
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
						Скачиваний: <span><?= $row['sales']?></span>
						<br/>
						Цена: <span><?= $row['price_1']?> руб.</span>
					</p>
					<p class="details">
						<a href="/designs/<?=$row['id']?>.html">Подробно</a>
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
		</div>
	</div>
</div>
