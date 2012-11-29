<div class="sideBar">
	<div class="designsCategories">
		<h3><a href="/users/all/">Все дизайнеры</a></h3>
		<?php if( !empty($category) )
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
		<?php foreach($categories as $row): ?> 

			<?php if( $row['parent_id'] == 0 ) :?>
				<li class="<?php if( !empty($active) and $row['id'] == $active ): ?>active<?php endif ?>"><a href="/users/search/?category=<?=$row['id']?>"><?=$row['name']?></a>
			<?php endif; ?>

			<?php if( !empty($active) and $active == $row['id'] ):?>
				<ul>
				<?php foreach($categories as $row2): ?>
					<?php if( $row['id'] == $row2['parent_id'] ): ?>
						<li class="lvl-2"><a href="/users/search/?category=<?=$row2['id']?>"><?=$row2['name']?></a> <span>(<?=$row2['number']?>)</span></li>
					<?php endif; ?>
				<?php endforeach; ?>
				</ul>
			</li>
			<?php else: ?>
				<?php if ($row['parent_id']==0){ echo "</li>"; }?>
			<?php endif; ?>
		<?php endforeach; ?>
		</ul>
		<?php if( !empty($users_descr) ): ?>
			<div class="sideblock nomargin">
				<p class="freetext"><?=$users_descr?></p>
			</div>	
		<?php endif; ?>
	</div>
</div>
			<div class="content">
				<div class="extendedSearchUsers">
					<h3>Расширенный поиск дизайнеров:</h3>
					<form action="/users/search/" method="get">
						<div class="esfLeftPart">
							<fieldset>
								<label>Ключевые слова:</label>
								<input name="keywords" type="text" size="100" maxlength="75" value="<?=$input['keywords']?>">
							</fieldset>
							<div class="esfPrice">
								<fieldset>
									<label>Возраст:</label>
									<span>от</span>
									<input name="age_start" type="text" size="1" maxlength="2" value="<?=$input['age_start']?>"> 
									<span>до</span> 
									<input name="age_end" type="text" size="1" maxlength="2"	value="<?=$input['age_end']?>">
									<span>лет</span> 
								</fieldset>
							</div>
							<fieldset>
								<label>Категория:</label>
								<select name="category">
									<option value="">Не важно</option>
									<?php foreach($categories as $row): ?> 
										<?php if( $row['parent_id'] == 0): ?>
											<optgroup label="<?=$row['name']?>">
										<?php endif; ?>
										<?php foreach($categories as $row2): ?>
											<?php if( $row['id'] == $row2['parent_id'] ): ?>
												<option value="<?=$row2['id']?>"<?php if( $input['category'] == $row2['id']): ?>selected="selected<?php endif; ?>"><?=$row2['name']?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									<?php endforeach; ?>
								</select>
							</fieldset>
							<fieldset>
								<script type="text/javascript" src="/templates/js/location.min.js"></script>
								<script type="text/javascript" src="/templates/js/location_data.js"></script>
								<script type="text/javascript" language="javascript">
									$(document).ready(
										function()
											{
											$('#country_id').val(<?=$input['country_id']?>).change();
											$('#city_id').val(<?=$input['city_id']?>).change();
											}
										);
								</script>
								<label>Страна:</label>
								<select id="country_id" name="country_id" class="text">
									<option value=""></option>
									<option value="2">Россия</option>
									<option value="1">Украина</option>
									<option value="0" disabled="disabled">-----------------------------------------</option>
									<option value="42">Австралия</option>
									<option value="3">Австрия</option>
									<option value="43">Азербайджан</option>
									<option value="4">Албания</option>
									<option value="5">Андорра</option>
									<option value="75">Аргентина</option>
									<option value="44">Армения</option>
									<option value="6">Беларусь</option>
									<option value="7">Бельгия</option>
									<option value="8">Болгария</option>
									<option value="96">Бразилия</option>
									<option value="97">Великобритания</option>
									<option value="98">Венгрия</option>
									<option value="99">Вьетнам</option>
									<option value="100">Германия</option>
									<option value="101">Греция</option>
									<option value="102">Грузия</option>
									<option value="103">Дания</option>
									<option value="104">Доминика</option>
									<option value="105">Доминиканская Республика</option>
									<option value="106">Египет</option>
									<option value="107">Израиль</option>
									<option value="108">Индия</option>
									<option value="109">Индонезия</option>
									<option value="110">Иран</option>
									<option value="111">Ирландия</option>
									<option value="112">Исландия</option>
									<option value="113">Испания</option>
									<option value="114">Италия</option>
									<option value="115">Йемен</option>
									<option value="116">Казахстан</option>
									<option value="117">Канада</option>
									<option value="118">Кипр</option>
									<option value="119">Киргизстан</option>
									<option value="120">Китай</option>
									<option value="121">Корея</option>
									<option value="122">Латвия</option>
									<option value="123">Литва</option>
									<option value="124">Лихтенштейн</option>
									<option value="125">Люксембург</option>
									<option value="126">Македония</option>
									<option value="127">Мальта</option>
									<option value="128">Мексика</option>
									<option value="129">Молдова</option>
									<option value="130">Монголия</option>
									<option value="131">Непал</option>
									<option value="132">Нидерланды</option>
									<option value="133">Новая Зеландия</option>
									<option value="134">Норвегия</option>
									<option value="135">ОАЭ</option>
									<option value="136">Польша</option>
									<option value="137">Португалия</option>
									<option value="138">Румыния</option>
									<option value="139">Саудовская Аравия</option>
									<option value="140">Сербия</option>
									<option value="141">Сингапур</option>
									<option value="142">Сирия</option>
									<option value="143">Словакия</option>
									<option value="144">Словения</option>
									<option value="145">США</option>
									<option value="146">Таджикистан</option>
									<option value="147">Тайвань</option>
									<option value="148">Тайланд</option>
									<option value="149">Туркменистан</option>
									<option value="150">Турция</option>
									<option value="151">Узбекистан</option>
									<option value="152">Финляндия</option>
									<option value="153">Франция</option>
									<option value="154">Хорватия</option>
									<option value="155">Черногория</option>
									<option value="156">Чехия;</option>
									<option value="38">Швейцария</option>
									<option value="39">Швеция</option>
									<option value="40">Эстония</option>
									<option value="55">Япония</option>
								</select>
							</fieldset>
							<fieldset>
								<label>Город:</label>
								<select id="city_id" name="city_id" class="text" disabled>
									<option value="">Все города</option>
								</select>
							</fieldset>
							<div class="esfPrice">
								<fieldset>
									<label>Цена за час работы:</label>
									<span>от</span>
									<input name="price_1_start" type="text" size="2" maxlength="6" value="<?=$input['price_1_start']?>"> 
									<span>до</span>
									<input name="price_1_end" type="text" size="2" maxlength="6" value="<?=$input['price_1_end']?>"> 
									<span>USD</span>
								</fieldset>
							</div>
							<div class="esfPrice">
								<fieldset>
									<label>Цена за месяц работы:</label>
									<span>от</span><input name="price_2_start" type="text" size="2" maxlength="6" value="<?=$input['price_2_start']?>">
									<span>до</span>
									<input name="price_2_end" type="text" size="2" maxlength="6" value="<?=$input['price_2_end']?>"> 
									<span>USD</span>
								</fieldset>
							</div>
							<input id="submitExtSearch" type="submit" value="Поиск" />
						</div>
					</form>
				</div>
				<div class="searchResults">
					<div class="searchResultsHeader">
						<div class="sortBy">
							<p>сортировать по:</p>
							<?php if( $input['order_field'] == 'rating' and	$input['order_type'] == 'desc' ): ?>
								<a class="abs" href="/users/search/?order_field=rating&order_type=asc<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>">Рейтинг &darr;</a>
							<?php else: ?>
								<a href="/users/search/?order_field=rating<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>">Рейтинг &uarr;</a>
							<?php endif; ?>
						</div>
						<h3>Результаты поиска:</h3>
					</div>
					<div class="searchResultsList">
						<?php if( !empty($data) ): $n = 0; ?>
							<!-- ?=show_highslide()? -->
							<ul class="designersList">
							<?php foreach($data as $row => $value): ?>
								<li>
									<p class="number"><?=$row+1?></p>
									<a href="/user/<?=$value['username']?>" title="перейти к портфолио" class="avatar <?=$value['tariffname']?>">
									<!-- Нужна маленькая аватарка -->
									<img src="<?=$value['userpic']?>" alt="<?=$value['username']?> avi"/>
									</a>
									<div class="infoblock">
										<p><a class="username" href="/user/<?=$value['username']?>" title="перейти к портфолио"><?=$value['username']?></a></p>
										<p><?=$value['name']?> <?=$value['surname']?></p>
										<p><a class="message" href="/contacts/send/<?=$value['username']?>">Личное сообщение</a></p>
									</div>
									<div class="infoblock">
										<p>&nbsp;</p>
										<p>Последний визит: <?=$value['last_login']?></p>
										<p>Дата регистрации: <?=$value['created']?></p>
									</div>
									<!-- Не уверен, что это рейтинг -->
									<div class="rating"><?=$value['rating']?></div>
								</li>
							<?php endforeach; ?>
							</ul>
						<?php else: ?>
							<p>Пользователей не найдено.</p>
						<?php endif; ?>
						<div class="paginationControl">
							<?=$page_links?>
						</div>
						<div class="itemsOnPage">
							<p>кол-во результатов на страницу:</p>
							<ul class="pageList">
							<?php $results = array(10,20,50,100);
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