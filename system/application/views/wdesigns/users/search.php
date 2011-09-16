<div id="yui-main">
<div class="yui-b clearfix"> 
<h1>Поиск дизайнеров</h1>

<div class="rnd">
 <div>
  <div>
   <div>
    <div id="msearch">
<form action="/users/search/" method="get">
Ключевые слова: 
<div><input name="keywords" type="text" size="100" maxlength="75" value="<?=$input['keywords']?>"></div>

Возраст: 
<div><input name="age_start" type="text" size="1" maxlength="2" value="<?=$input['age_start']?>"> до <input name="age_end" type="text" size="1" maxlength="2"  value="<?=$input['age_end']?>"></div>

Категория:
<div>
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
</div>

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
Страна:
<div>
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
</div>
Город:
<div>
<select id="city_id" name="city_id" class="text" disabled>
<option value="">Все города</option>
</select>
</div>

Цена за час работы: 
<div><input name="price_1_start" type="text" size="2" maxlength="6" value="<?=$input['price_1_start']?>"> до <input name="price_1_end" type="text" size="2" maxlength="6" value="<?=$input['price_1_end']?>"> USD</div>

Цена за месяц работы 
<div><input name="price_2_start" type="text" size="2" maxlength="6" value="<?=$input['price_2_start']?>"> до <input name="price_2_end" type="text" size="2" maxlength="6" value="<?=$input['price_2_end']?>"> USD</div>

Результатов на страницу:
<div><input name="result" type="text" size="1" maxlength="2" value="<?=$input['result']?>"></div>
<div><input type="submit" value="Поиск"></div>
</form>
     </div>
   </div>
  </div>
 </div>
</div>

<? if( !empty($data) ): $n = 0; ?>
<table class="contractors">
<tr>
<td class="topline lft txtl" style="width:15px;">№</td>
<td class="topline title">Пользователь</td>
<td class="topline rht" style="width: 50px;">
<? if( $input['order_field'] == 'rating' and  $input['order_type'] == 'desc' ): ?>
<a  href="/users/search/?order_field=rating&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Рейтинг</a>
<? else: ?>
<a  href="/users/search/?order_field=rating<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Рейтинг</a>
<? endif; ?>
</td>
<td class="topline rht">Тариф</td>
</tr>
<? foreach($data as $row => $value): ?>
<tr>
<td class="num"><?=$row+1?></td>
<td class="text"> <img src="<?=$value['userpic']?>" alt="" class="avatar" />
<ul class="ucard">
<li class="utitle"><a class="black" href="/user/<?=$value['username']?>"><?=$value['surname']?> <?=$value['name']?> (<?=$value['username']?>)</a></li>
<li class="exp-pm"><a class="blue" href="/contacts/send/<?=$value['username']?>">Личное сообщение</a></li>
<li>Последний визит: <?=$value['last_login']?></li>
<li>Дата регистрации: <?=$value['created']?></li>
<li>Статус: <?=$value['tariff']?></li>
</ul>
</td>
<td class="rating"><?=$value['rating']?></td>
<td class="rating"><strong><?=$value['tariffname']?></strong></td>
</tr>
<? endforeach; ?>
</tr>
</table>
<?=$page_links?>
<? else: ?>
Пользователей не найдено
<? endif; ?>
</div>
</div>

<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div class="bd clearfix">

<ul class="marketnav">
      <h3><a href="/users/search/">Все дизайнеры</a></h3>
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

<? foreach($categories as $row): ?> 

<? if( $row['parent_id'] == 0 ) :?>
<li class="lvl-1 <? if( !empty($active) and $row['id'] == $active ): ?>active<? endif ?>"><a href="/users/search/?category=<?=$row['id']?>"><?=$row['name']?></a></li>
<? endif; ?>

	<? if( !empty($active) and $active == $row['id'] ):?>

		<? foreach($categories as $row2): ?>
			<? if( $row['id'] == $row2['parent_id'] ): ?>
				<li class="lvl-2"><a href="/users/search/?category=<?=$row2['id']?>"><?=$row2['name']?></a> (<?=$row2['number']?>)</li>
			<? endif; ?>
		<? endforeach; ?>
	<? endif; ?>

<? endforeach; ?>
</ul> 

</div>
<div class="ft"></div>
</div>