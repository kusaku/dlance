<div class="sideBar">
	<div class="tagsCloud slideBox">
		<ul id="slider1">
			<!-- Облако тегов, вывод надо рассчитать -->
			<?=$tagcloud?>
		</ul>
	</div>
	<div class="designsCategories">
		<h3><a href="/designs">Дизайны:</a></h3>
		<?
		if( !empty($category) )
		{
			$active = $category;
			foreach($categories as $row):
				if( $active == $row['id'] ):
					//Если у активной категории имеется раздел, присваиваем раздел
					if( $row['parent_id'] != 0 ):
						$active = $row['parent_id'];
					endif;
				endif;
			endforeach;
		}
		?>
		<ul>
		<? foreach($categories as $row): ?> 

			<? if( $row['parent_id'] == 0 ) :?>
				<li class="<? if( !empty($active) and $row['id'] == $active ): ?>active<? endif ?>"><a href="/designs/search/?category=<?=$row['id']?>"><?=$row['name']?></a>
			<? endif; ?>

			<? if( !empty($active) and $active == $row['id'] ):?>
				<ul>
				<? foreach($categories as $row2): ?>
					<? if( $row['id'] == $row2['parent_id'] ): ?>
						<li class="lvl-2"><a href="/designs/search/?category=<?=$row2['id']?>"><?=$row2['name']?></a> <span>(<?=$row2['number']?>)</span></li>
					<? endif; ?>
				<? endforeach; ?>
				</ul>
			</li>
			<? else: ?>
				<? if ($row['parent_id']==0){ echo "</li>"; }?>
			<? endif; ?>
		<? endforeach; ?>
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
								<input type="text" name="tags" placeholder="что ищем?" <?=$input['tags']?>" id="tags"/>
							</fieldset>
							<div class="esfPrice">
								<fieldset>
									<label>Цена за покупку:</label>
									<span>от</span>
									<input type="text" name="price_1_start" value="<?=$input['price_1_start']?>"/>
									<span>до</span>
									<input type="text" name="price_1_end" value="<?=$input['price_1_end']?>" />
									<span>рублей</span>
								</fieldset>
								<fieldset>
									<label>Цена за выкуп:</label>
									<span>от</span>
									<input type="text" name="price_2_start" value="<?=$input['price_2_start']?>" />
									<span>до</span>
									<input type="text" name="price_2_end" value="<?=$input['price_2_end']?>" />
									<span>рублей</span>
								</fieldset>
							</div>
							<div class="esfTopColors">
								<label>Цвет:</label>
								<ul>
								<? foreach($colors as $row): ?>
									<?if ($row['color']!="ffffff") {
										echo "<li><a href=\"/designs/search/?color=".$row['color']."&result=".$input['result']."\" style=\"background:#".$row['color']."\"></a></li>";
										}
									else {
										echo "<li><a href=\"/designs/search/?color=".$row['color']."&result=".$input['result']."\" style=\"background:#".$row['color']."\" class=\"white\"></a></li>";
										}
									?>
								<? endforeach; ?>
								</ul>
							</div>
						</div>
						<div class="esfRightPart">
							<fieldset>
								<label>Категория:</label>
								<select name="category" id="categorySelect" >
									<option value="">Не важно</option>
									<? foreach($categories as $row): ?> 
										<? if( $row['parent_id'] == 0): ?>
											<option value="<?=$row['id']?>" <? if( $input['category'] == $row['id']): ?> selected="selected" <? endif; ?>><?=$row['name']?></option>
										<? endif; ?>
									<? foreach($categories as $row2): ?>
										<? if( $row['id'] == $row2['parent_id'] ): ?>
											<option value="<?=$row2['id']?>" <? if( $input['category'] == $row2['id']): ?> selected="selected" <? endif; ?>>- <?=$row2['name']?></option>
										<? endif; ?>
									<? endforeach; ?>
									<? endforeach; ?>
								</select>
							</fieldset>
							<fieldset>
								<label>Свой цвет:</label>
								<div id="SimpleColor">
									<input type="text" name="color" class="colorSample" placeholder="EBE6B9" value="<? if(!empty($input['color'])) { echo $input['color'];} else {echo "";} ?>"/>
								</div>
							</fieldset>
							<fieldset>
								<input name="result" type="hidden" size="1" maxlength="2" value="<?=$input['result']?>" />
								<input name="extbtn" type="submit" value="Искать" class="submitExtSearch"/>
							</fieldset>
						</div>
					</form>
				</div>
				<div class="searchResults">
					<div class="searchResultsHeader">
						<div class="sortBy">
							<p>сортировать по:</p>
							<? if( $input['order_field'] == 'title'):?>
								<? if( $input['order_field'] == 'title' and	$input['order_type'] == 'desc' ): ?>
									<a class="abs" href="/designs/search/?order_field=title&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">названию &darr;</a>
								<? else: ?>
									<a class="abs" href="/designs/search/?order_field=title<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">названию &uarr;</a>
								<? endif; ?>
							<? else: ?>
								<a	href="/designs/search/?order_field=title<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">названию</a>
							<? endif; ?>
							
							<? if( $input['order_field'] == 'rating'):?>
								<? if( $input['order_field'] == 'rating' and	$input['order_type'] == 'desc' ): ?>
									<a class="abs" href="/designs/search/?order_field=rating&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">рейтингу &darr;</a>
								<? else: ?>
									<a class="abs" href="/designs/search/?order_field=rating<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">рейтингу &uarr;</a>
								<? endif; ?>
							<? else: ?>
								<a	href="/designs/search/?order_field=rating<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">рейтингу</a>
							<? endif; ?>

							<? if( $input['order_field'] == 'sales'):?>
								<? if( $input['order_field'] == 'sales' and	$input['order_type'] == 'desc' ): ?>
									<a class="abs" href="/designs/search/?order_field=sales&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">кол-ву покупок &darr;</a>
								<? else: ?>
									<a class="abs" href="/designs/search/?order_field=sales<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">кол-ву покупок &uarr;</a>
								<? endif; ?>
							<? else: ?>
								<a	href="/designs/search/?order_field=sales<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">кол-ву покупок</a>
							<? endif; ?>

							<? if( $input['order_field'] == 'price_1'):?>
								<? if( $input['order_field'] == 'price_1' and	$input['order_type'] == 'desc' ): ?>
									<a class="abs" href="/designs/search/?order_field=price_1&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">цене &darr;</a>
								<? else: ?>
									<a class="abs" href="/designs/search/?order_field=price_1<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">цене &uarr;</a>
								<? endif; ?>
							<? else: ?>
								<a	href="/designs/search/?order_field=price_1<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">цене</a>
							<? endif; ?>
							
							<? if( $input['order_field'] == 'price_2'):?>
								<? if( $input['order_field'] == 'price_2' and	$input['order_type'] == 'desc' ): ?>
									<a class="abs" href="/designs/search/?order_field=price_2&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">цене выкупа &darr;</a>
								<? else: ?>
									<a class="abs" href="/designs/search/?order_field=price_2<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">цене выкупа &uarr;</a>
								<? endif; ?>
							<? else: ?>
								<a	href="/designs/search/?order_field=price_2<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">цене выкупа</a>
							<? endif; ?>
						</div>
						<h3>Результаты поиска:</h3>
					</div>
					<div class="searchResultsList">
						<? if( !empty($data) ): ?>
							<!-- ?=show_highslide()? -->
							<ul class="designsList">
							<? foreach($data as $row): ?>
								<? if ($row['sales']==0) {?> 
										<li class="unique"> 
											<a href="<?=$row['full_image']?>" class="zoom" title="<?=$row['title']?>"><img src="<?=$row['small_image']?>" alt="<?=$row['title']?>"/></a>
											<p><a href="/designs/<?=$row['id']?>.html"><?=$row['title']?></a></p>
											<!-- Это откуда берется? -->
											<p><?=$row['category']?><br/>
											Исходник: <?=$row['source']?></p>
											<p>Рейтинг: <span><?=$row['rating']?></span><br/>
											<span class="new">Скачиваний: <?=$row['sales']?></span><br/>
											Цена: <span><?=$row['price_1']?> руб.</span></p>
											<p class="details"><a href="/designs/<?=$row['id']?>.html">Купить первым!</a></p>
										</li>
									<?} else {?> 
										<li> 
											<a href="<?=$row['full_image']?>" class="zoom" title="<?=$row['title']?>"><img src="<?=$row['small_image']?>" alt="<?=$row['title']?>"/></a>
											<p><a href="/designs/<?=$row['id']?>.html"><?=$row['title']?></a></p>
											<!-- Это откуда берется? -->
											<p><?=$row['category']?><br/>
											Исходник: <?=$row['source']?></p>
											<p>Рейтинг: <span><?=$row['rating']?></span><br/>
											Скачиваний: <span><?=$row['sales']?></span><br/>
											Цена: <span><?=$row['price_1']?> руб.</span></p>
											<p class="details"><a href="/designs/<?=$row['id']?>.html">Подробно</a></p>
										</li>
									<? } ?>
							<? endforeach; ?>
							</ul>
						<? else: ?>
							<p>Ничего не найдено.</p>
						<? endif; ?>
						<div class="paginationControl">
							<?=$page_links?>
						</div>
						<div class="itemsOnPage">
							<p>кол-во дизайнов на страницу:</p>
							<ul class="pageList">
							<? $results = array(10,20,50,100);
								foreach ($results as $items){
									if($items==$input['result']){
										echo "<li class=\"active\">".$items."</li>";
									}
									else {
										if (mb_strpos($_SERVER['QUERY_STRING'],"&result=")) {
											echo "<li><a href=\"".mb_substr($_SERVER['QUERY_STRING'],0,(mb_strpos($_SERVER['QUERY_STRING'],"&result=")))."&result=".$items."\">".$items."</a></li>";
										}
										else {
											echo "<li><a href=\"".$_SERVER['QUERY_STRING']."&result=".$items."\">".$items."</a></li>";
										}
									}
								}
							?>
							</ul>
						</div>
					</div>
				</div>
			</div>