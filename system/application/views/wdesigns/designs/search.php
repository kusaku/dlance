<script type="text/javascript" src="/design/js/colorpicker/jquery.colorpicker.js"></script>
<link rel="stylesheet" type="text/css" href="/design/js/colorpicker/jquery.colorpicker.css" />
<script type="text/javascript">
	$(function(){
		$('#tags').autocomplete({
			source: function(request, response){
				$.getJSON("/designs/tags/", {
					'term': request.term.split(/,\s*/).pop()
				}, response);
			},
			search: function(){
				var term = this.value.split(/,\s*/).pop();
				if (term.length < 1) {
					return false;
				}
			},
			focus: function(){
				return false;
			},
			select: function(event, ui){
				var terms = this.value.split(/,\s*/);
				terms.pop();
				terms.push(ui.item.value);
				terms.push('');
				this.value = terms.join(', ');
				return false;
			}
		});
			
		$('.colorBar').click(function(event){
			event.stopPropagation();
			var color = $(this).attr('rel');
			$('.colorSample').css({
				'border-color': '#' + color
			}).val(color);
			
			return false;
		});
		
		$('.colorSample').colorpicker({
			colorFormat: 'HEX',
			buttonColorize: true,
			showNoneButton: true,
			select: function(event, color){
				$('.colorSample').css({
					'border-color': '#' + color.formatted,
				});
			}
		});
	});
</script>
<div class="sideBar">
	<div class="tagsCloud slideBox">
		<ul id="slider1">
			<!-- Облако тегов, вывод надо рассчитать -->
			<?= $tagcloud?>
		</ul>
	</div>
	<div class="designsCategories">
		<h3><a href="/designs">Дизайны:</a></h3>
		<?php 
		if (! empty($search['category'])) {
			$active = $search['category'];
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
				<a href="/designs/search/?category=<?=$row['id']?>"><?= $row['name']?></a>
				<?php endif; ?>
				<?php if (! empty($active) and $active == $row['id']): ?>
				<ul>
					<?php foreach ($categories as $row2): ?>
					<?php if ($row['id'] == $row2['parent_id']): ?>
					<li class="lvl-2">
						<a href="/designs/search/?category=<?=$row2['id']?>"><?= $row2['name']?></a>
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
	<div class="extendedSearch">
		<h3>Расширенный поиск:</h3>
		<form class="extendedSearchForm" action="/designs/search/" method="get">
			<div class="esfLeftPart">
				<fieldset>
					<label for="keyword">Ключевые слова:</label>
					<input type="text" name="tags" value="<?= $search['tags']; ?>" id="tags"/>
				</fieldset>
				<div class="esfPrice">
					<fieldset>
						<label>Цена за покупку:</label>
						<span>от</span>
						<input type="text" name="buy_from" value="<?= $search['buy_from']; ?>"/><span>до</span>
						<input type="text" name="buy_to" value="<?= $search['buy_to']; ?>" /><span>рублей</span>
					</fieldset>
					<!--fieldset>
						<label>Цена за выкуп:</label>
						<span>от</span>
						<input type="text" name="buyout_from" value="<?= $search['buyout_from'] ;?>" /><span>до</span>
						<input type="text" name="buyout_to" value="<?= $search['buyout_to'] ;?>" /><span>рублей</span>
					</fieldset-->
				</div>
				<div class="esfTopColors">
					<label>Цвет:</label>
					<ul>
						<?php foreach ($colorbars as $row): ?>
						<li>
							<a class="colorBar" style="background: #<?= $row['color']; ?>" rel="<?= $row['color']; ?>" href="#"></a>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<div class="esfRightPart">
				<fieldset>
					<label>Категория:</label>
					<select name="category" id="categorySelect">
						<option value="">Не важно</option>
						<?php foreach ($categories as $row): ?>
						<?php if ($row['parent_id'] == 0): ?>
						<option value="<?=$row['id']?>" <?= $search['category'] == $row['id'] ? 'selected="selected"': ''; ?>>
							<?= $row['name']?>
						</option>
						<?php endif; ?>
						<?php foreach ($categories as $row2): ?>
						<?php if ($row['id'] == $row2['parent_id']): ?>
						<option value="<?=$row2['id']?>" <?= $search['category'] == $row2['id'] ? 'selected="selected"' : ''; ?>> 
							--<?= $row2['name']?>
						</option>
						<?php endif; ?>
						<?php endforeach; ?>
						<?php endforeach; ?>
					</select>
				</fieldset>
				<fieldset>
					<label>Свой цвет:</label>
					<div id="SimpleColor">
						<input type="text" name="color" style="<?= empty($search['color']) ? '' : "border-color:#{$search['color']}"; ?>;border-right-width:24px;width:100px;" class="colorSample" value="<?= $search['color']; ?>"/>
					</div>
				</fieldset>
				<fieldset>
					<button type="submit" class="submitExtSearch">Искать</button>
				</fieldset>
			</div>
		</form>
	</div>
	<div class="searchResults">
		<div class="searchResultsHeader">
			<div class="sortBy">
				<p>сортировать по:</p>
				названию
				<a <?=($search['order_by']=='title' and $search['order_dir']=='asc') ? 'class="abs"':''?> href="/designs/search/?<?=http_build_query(array_merge($search, array('order_by'=>'title','order_dir'=>'asc')));?>&">&darr;</a>
				<a <?=($search['order_by']=='title' and $search['order_dir']=='desc') ? 'class="abs"':''?> href="/designs/search/?<?=http_build_query(array_merge($search, array('order_by'=>'title','order_dir'=>'desc')));?>&">&uarr;</a>
				рейтингу
				<a <?=($search['order_by']=='rating' and $search['order_dir']=='asc') ? 'class="abs"':''?> href="/designs/search/?<?=http_build_query(array_merge($search, array('order_by'=>'rating','order_dir'=>'asc')));?>&">&darr;</a>
				<a <?=($search['order_by']=='rating' and $search['order_dir']=='desc') ? 'class="abs"':''?> href="/designs/search/?<?=http_build_query(array_merge($search, array('order_by'=>'rating','order_dir'=>'desc')));?>&">&uarr;</a>
				кол-ву покупок
				<a <?=($search['order_by']=='sales' and $search['order_dir']=='asc') ? 'class="abs"':''?> href="/designs/search/?<?=http_build_query(array_merge($search, array('order_by'=>'sales','order_dir'=>'asc')));?>&">&darr;</a>
				<a <?=($search['order_by']=='sales' and $search['order_dir']=='desc') ? 'class="abs"':''?> href="/designs/search/?<?=http_build_query(array_merge($search, array('order_by'=>'sales','order_dir'=>'desc')));?>&">&uarr;</a>
			</div>
			<h3>Результаты поиска:</h3>
		</div>
		<div class="searchResultsList">
			<?php if (! empty($data)): ?>
			<? /*=show_highslide() */ ?>
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
						<a href="/designs/search/?<?=http_build_query(array_merge($search, array('limit'=>$limit)));?>">
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