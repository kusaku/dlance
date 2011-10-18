<div class="sideBar">
	<div class="designsCategories">
		<h3><a href="/users/all/">Все дизайнеры</a></h3>
		<?
		if( !empty($category) )
		{
			$active = $category;
			foreach($categories as $row):
				if( $active == $row['id'] ):
					if( $row['parent_id'] != 0 )://Если у активной категории имеется раздел, присваиваем раздел
						$active = $row['parent_id'];
					endif;
				endif;
			endforeach;
		}
		?>
		<ul>
		<? foreach($categories as $row): ?> 

			<? if( $row['parent_id'] == 0 ) :?>
				<li class="<? if( !empty($active) and $row['id'] == $active ): ?>active<? endif ?>"><a href="/users/search/?category=<?=$row['id']?>"><?=$row['name']?></a>
			<? endif; ?>

			<? if( !empty($active) and $active == $row['id'] ):?>
				<ul>
				<? foreach($categories as $row2): ?>
					<? if( $row['id'] == $row2['parent_id'] ): ?>
						<li class="lvl-2"><a href="/users/search/?category=<?=$row2['id']?>"><?=$row2['name']?></a> <span>(<?=$row2['number']?>)</span></li>
					<? endif; ?>
				<? endforeach; ?>
				</ul>
			</li>
			<? else: ?>
				<? if ($row['parent_id']==0){ echo "</li>"; }?>
			<? endif; ?>
		<? endforeach; ?>
		</ul>
		<? if( !empty($users_descr) ): ?>
			<div class="sideblock nomargin">
				<p class="freetext"><?=$users_descr?></p>
			</div>  
		<? endif; ?>
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
									<input name="age_end" type="text" size="1" maxlength="2"  value="<?=$input['age_end']?>">
									<span>лет</span> 
								</fieldset>
							</div>
							<fieldset>
								<label>Категория:</label>
								<select name="category">
									<option value="">Не важно</option>
									<? foreach($categories as $row): ?> 
										<? if( $row['parent_id'] == 0): ?>
											<optgroup label="<?=$row['name']?>">
										<? endif; ?>
										<? foreach($categories as $row2): ?>
											<? if( $row['id'] == $row2['parent_id'] ): ?>
												<option value="<?=$row2['id']?>"<? if( $input['category'] == $row2['id']): ?>selected="selected<? endif; ?>"><?=$row2['name']?></option>
											<? endif; ?>
										<? endforeach; ?>
									<? endforeach; ?>
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
								<select id="country_id" name="country_id" class="text" OnChange="list_cities(this.value)">
									<option value="">не важно</option>
									<option value="2">Россия</option>
									<option value="1">Украина</option>
									<option value="0" disabled>--------------------------------------------------</option>
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
									<option value="9">Великобритания</option>
									<option value="10">Венгрия</option>
									<option value="72">Вьетнам</option>
									<option value="11">Германия</option>
									<option value="12">Греция</option>
									<option value="45">Грузия</option>
									<option value="13">Дания</option>
									<option value="70">Доминика</option>
									<option value="100">Доминиканская Республика</option>
									<option value="46">Египет</option>
									<option value="47">Израиль</option>
									<option value="83">Индия</option>
									<option value="94">Индонезия</option>
									<option value="91">Иран</option>
									<option value="14">Ирландия</option>
									<option value="15">Исландия</option>
									<option value="16">Испания</option>
									<option value="17">Италия</option>
									<option value="93">Йемен</option>
									<option value="18">Казахстан</option>
									<option value="48">Канада</option>
									<option value="49">Кипр</option>
									<option value="50">Киргизстан</option>
									<option value="58">Китай</option>
									<option value="59">Корея</option>
									<option value="19">Латвия</option>
									<option value="20">Литва</option>
									<option value="21">Лихтенштейн</option>
									<option value="22">Люксембург</option>
									<option value="23">Македония</option>
									<option value="24">Мальта</option>
									<option value="57">Мексика</option>
									<option value="25">Молдова</option>
									<option value="73">Монголия</option>
									<option value="95">Непал</option>
									<option value="26">Нидерланды</option>
									<option value="63">Новая Зеландия</option>
									<option value="27">Норвегия</option>
									<option value="89">ОАЭ</option>
									<option value="28">Польша</option>
									<option value="29">Португалия</option>
									<option value="30">Румыния</option>
									<option value="97">Саудовская Аравия</option>
									<option value="51">Сербия</option>
									<option value="90">Сингапур</option>
									<option value="99">Сирия</option>
									<option value="31">Словакия</option>
									<option value="32">Словения</option>
									<option value="41">США</option>
									<option value="52">Таджикистан</option>
									<option value="98">Тайвань</option>
									<option value="71">Тайланд</option>
									<option value="53">Туркменистан</option>
									<option value="33">Турция</option>
									<option value="54">Узбекистан</option>
									<option value="34">Финляндия</option>
									<option value="35">Франция</option>
									<option value="36">Хорватия</option>
									<option value="92">Черногория</option>
									<option value="37">Чехия</option>
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
							<? if( $input['order_field'] == 'rating' and  $input['order_type'] == 'desc' ): ?>
								<a class="abs" href="/users/search/?order_field=rating&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Рейтинг &darr;</a>
							<? else: ?>
								<a href="/users/search/?order_field=rating<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Рейтинг &uarr;</a>
							<? endif; ?>
						</div>
						<h3>Результаты поиска:</h3>
					</div>
					<div class="searchResultsList">
						<? if( !empty($data) ): $n = 0; ?>
							<!-- ?=show_highslide()? -->
							<ul class="designersList">
							<? foreach($data as $row => $value): ?>
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
							<? endforeach; ?>
							</ul>
						<? else: ?>
							<p>Пользователей не найдено.</p>
						<? endif; ?>
						<div class="paginationControl">
							<?=$page_links?>
						</div>
						<div class="itemsOnPage">
							<p>кол-во результатов на страницу:</p>
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