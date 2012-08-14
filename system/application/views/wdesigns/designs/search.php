<style type="text/css">
	#SimpleColor {
		font-size:11px;
	}
	input#alert_button {
		display: block;
		margin-top: 20px;
	}
	
	.simpleColorDisplay {
		float: left;
	}
	
	.button {
		clear: right;
	}
</style>

<script type="text/javascript" src="/templates/js/SimpleColor/jquery.simpleColor.js"></script>

<script  type="text/javascript">
$(document).ready(function(){
	$('.simple_color').simpleColor({
			defaultColor: '#<?=$input['color']?>',
			cellWidth: 25,
			cellHeight: 10,
			border: '1px solid #333333',
			buttonClass: 'button'
	});
});
</script>

<script type='text/javascript' src='/templates/js/jquery-autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="/templates/js/jquery-autocomplete/jquery.autocomplete.css" />
<script type="text/javascript">
$().ready(function() {
	$("#tags").focus().autocomplete("<?=base_url()?>designs/tags/", {selectFirst:false});

});
</script>


<div id="yui-main">
<div class="yui-b clearfix"> 
<form action="/designs/search/" method="get">

<div id="SimpleColor">
Цвет:
<input name="color" class='simple_color' value='<?=$input['color']?>'/>
<br />
</div>

<div>
 <div>
  <div>
   <div>
    <div id="msearch">

Ключевые слова:
<div><input name="tags" type="text" size="100" maxlength="75" value="<?=$input['tags']?>" id="tags" /></div>

Цена за покупку 
<div><input name="price_1_start" type="text" size="2" maxlength="6" value="<?=$input['price_1_start']?>"> до <input name="price_1_end" type="text" size="2" maxlength="6" value="<?=$input['price_1_end']?>"> рублей</div>

Цена за выкуп 
<div><input name="price_2_start" type="text" size="2" maxlength="6" value="<?=$input['price_2_start']?>"> до <input name="price_2_end" type="text" size="2" maxlength="6" value="<?=$input['price_2_end']?>"> рублей</div>

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
				<option value="<?=$row2['id']?>"<? if( $input['category'] == $row2['id']): ?> selected="selected<? endif; ?>"><?=$row2['name']?></option>
			<? endif; ?>
	<? endforeach; ?>
<? endforeach; ?>
</select>
</div>





Результатов на страницу:
<div><input name="result" type="text" size="1" maxlength="2" value="<?=$input['result']?>"></div>
<div><input type="submit" value="Поиск"></div>
</form>
     </div>
   </div>
  </div>
 </div>
</div>


<? if( $colors ): ?>
Популярные цвета:
<div class="jColorSelect">
<? foreach($colors as $row): ?>
<a href="/designs/search/?color=<?=$row['color']?>"><div style="background-color:#<?=$row['color']?>;"></div></a>
<? endforeach; ?>
</div>
<? endif; ?>

<div id="bubble-2" class="mb20"></div>

Найдено: <?=$total_rows?>

<div id="bubble-2" class="mb20"></div>

<div align="right"><a  href="/designs/add/"><strong>Добавить дизайн на продажу</strong></a></div>
<div class="latest-orders">
<h3>Поиск дизайнов</h3>

<div class="offers-stateline">
<script type="text/javascript" src="/templates/js/currency.js"></script>
<span>
<a id="setRur" rel="nofollow" href="#" class="bold">Рубли</a> | 

<a id="setEur" rel="nofollow" href="#">Евро</a> | 

<a id="setUsd" rel="nofollow" href="#">Доллары</a>

<a id="setUah" rel="nofollow" href="#">Гривны</a>
</span>
</div>

<table class="listorder">
<tr>
<td class="topline lft txtl">
<? if( $input['order_field'] == 'title' and  $input['order_type'] == 'desc' ): ?>
<a  href="/designs/search/?order_field=title&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Заголовок / Превью</a>
<? else: ?>
<a  href="/designs/search/?order_field=title<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Заголовок / Превью</a>
<? endif; ?>
</td>

<td class="topline" style="width: 70px;">
<? if( $input['order_field'] == 'sales' and  $input['order_type'] == 'desc' ): ?>
<a  href="/designs/search/?order_field=sales&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Покупок</a>
<? else: ?>
<a  href="/designs/search/?order_field=sales<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Покупок</a>
<? endif; ?>
</td>

<td class="topline" style="width: 70px;">
<? if( $input['order_field'] == 'rating' and  $input['order_type'] == 'desc' ): ?>
<a  href="/designs/search/?order_field=rating&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Рейтинг</a>
<? else: ?>
<a  href="/designs/search/?order_field=rating<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Рейтинг</a>
<? endif; ?>
</td>

<td class="topline" style="width: 70px;">
<? if( $input['order_field'] == 'price_1' and  $input['order_type'] == 'desc' ): ?>
<a  href="/designs/search/?order_field=price_1&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Цена</a>
<? else: ?>
<a  href="/designs/search/?order_field=price_1<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Цена</a>
<? endif; ?>
</td>

<td class="topline rht" style="width: 70px;">
<? if( $input['order_field'] == 'price_2' and  $input['order_type'] == 'desc' ): ?>
<a  href="/designs/search/?order_field=price_2&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Цена выкупа</a>
<? else: ?>
<a  href="/designs/search/?order_field=price_2<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Цена выкупа</a>
<? endif; ?>
</td>

</tr>

<? if( !empty($data) ): ?>

<?=show_highslide()?>

<? foreach($data as $row): ?>
<tr>
<td class="ordertitle"><strong><a href="/designs/<?=$row['id']?>.html"><?=$row['title']?></a></strong><br>

<a href="<?=$row['full_image']?>" class="highslide" onclick="return hs.expand(this)">
<img src="<?=$row['small_image']?>" title="<?=$row['title']?>" />
</a>


<div class="inf">
<?=$row['category']?> | <?=$row['date']?>

</div></td>
<td class="offcount"><?=$row['sales']?></td>
<td class="offcount"><?=$row['rating']?></td>
<td class="budget"><?=$row['price_1']?> рублей</td>
<td class="budget"<? if( $row['sales'] > 0 ): ?> style="text-decoration:line-through"<? endif; ?>><?=$row['price_2']?> рублей</td>


</tr>
<? endforeach; ?>
<?=$page_links?>
<? else: ?>
<p>Ничего не найдено.</p>
<? endif; ?>

</table> 

</div>
</div>
</div>



<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div class="bd clearfix">

<ul class="marketnav">
      <h3><a href="/designs">Все дизайны</a></h3>
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
<li class="lvl-1 <? if( !empty($active) and $row['id'] == $active ): ?>active<? endif ?>"><a href="/designs/search/?category=<?=$row['id']?>"><?=$row['name']?></a></li>
<? endif; ?>

	<? if( !empty($active) and $active == $row['id'] ):?>

		<? foreach($categories as $row2): ?>
			<? if( $row['id'] == $row2['parent_id'] ): ?>
				<li class="lvl-2"><a href="/designs/search/?category=<?=$row2['id']?>"><?=$row2['name']?></a> (<?=$row2['number']?>)</li>
			<? endif; ?>
		<? endforeach; ?>
	<? endif; ?>

<? endforeach; ?>
</ul>


<? if( !empty($projects_descr) ): ?>
<div class="sideblock nomargin">
<p class="freetext"><?=$projects_descr?></p>
</div>  
<? endif; ?> 

</div>

<div class="ft"></div>
</div>