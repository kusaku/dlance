<div id="yui-main">
<div class="yui-b clearfix"> 

<div id="bubble-2" class="mb20"></div>
<div align="left"><a  href="/designs/search/"><strong>Поиск дизайнов</strong></a></div>
<div align="right"><a  href="/designs/add/"><strong>Добавить дизайн на продажу</strong></a></div>
<div class="latest-orders">
<h3>Все дизайны сайтов</h3>

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
<a  href="/designs/index/?order_field=title&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Заголовок / Превью</a>
<? else: ?>
<a  href="/designs/index/?order_field=title<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Заголовок / Превью</a>
<? endif; ?>
</td>

<td class="topline" style="width: 70px;">
<? if( $input['order_field'] == 'sales' and  $input['order_type'] == 'desc' ): ?>
<a  href="/designs/index/?order_field=sales&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Покупок</a>
<? else: ?>
<a  href="/designs/index/?order_field=sales<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Покупок</a>
<? endif; ?>
</td>

<td class="topline" style="width: 70px;">
<? if( $input['order_field'] == 'rating' and  $input['order_type'] == 'desc' ): ?>
<a  href="/designs/index/?order_field=rating&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Рейтинг</a>
<? else: ?>
<a  href="/designs/index/?order_field=rating<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Рейтинг</a>
<? endif; ?>
</td>

<td class="topline" style="width: 70px;">
<? if( $input['order_field'] == 'price_1' and  $input['order_type'] == 'desc' ): ?>
<a  href="/designs/index/?order_field=price_1&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Цена</a>
<? else: ?>
<a  href="/designs/index/?order_field=price_1<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Цена</a>
<? endif; ?>
</td>

<td class="topline rht" style="width: 70px;">
<? if( $input['order_field'] == 'price_2' and  $input['order_type'] == 'desc' ): ?>
<a  href="/designs/index/?order_field=price_2&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Цена выкупа</a>
<? else: ?>
<a  href="/designs/index/?order_field=price_2<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Цена выкупа</a>
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
<?=$row['section']?> / <?=$row['category']?> | <?=$row['date']?>

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
<li class="lvl-1 <? if( !empty($active) and $row['id'] == $active ): ?>active<? endif ?>"><a href="/designs/index/?category=<?=$row['id']?>"><?=$row['name']?></a></li>
<? endif; ?>

	<? if( !empty($active) and $active == $row['id'] ):?>

		<? foreach($categories as $row2): ?>
			<? if( $row['id'] == $row2['parent_id'] ): ?>
				<li class="lvl-2"><a href="/designs/index/?category=<?=$row2['id']?>"><?=$row2['name']?></a> (<?=$row2['number']?>)</li>
			<? endif; ?>
		<? endforeach; ?>
	<? endif; ?>

<? endforeach; ?>
</ul>



</div>

<div class="ft"></div>
</div>