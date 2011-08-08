<div id="yui-main">
<div class="yui-b clearfix"> 
<h2>Дизайнеры<? if( !empty($title) ): ?> / <?=$title?><? endif; ?></h2>

<div align="right"><a href="/users/search">Расширенный поиск</a></div><br />

<? if( !empty($data) ): $n = 0; ?>
<table class="contractors">
<tr>
<td class="topline lft txtl" style="width:15px;">№</td>
<td class="topline title">Пользователь</td>
<td class="topline rht" style="width: 50px;">
<? if( $input['order_field'] == 'rating' and  $input['order_type'] == 'desc' ): ?>
<a  href="/users/all/?order_field=rating&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Рейтинг</a>
<? else: ?>
<a  href="/users/all/?order_field=rating<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">Рейтинг</a>
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
Дизайнеров не найдено
<? endif; ?>

</div>
</div>

<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div class="bd clearfix">

<ul class="marketnav">
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

<? foreach($categories as $row): ?> 

<? if( $row['parent_id'] == 0 ) :?>
<li class="lvl-1 <? if( !empty($active) and $row['id'] == $active ): ?>active<? endif ?>"><a href="/users/all/?category=<?=$row['id']?>"><?=$row['name']?></a></li>
<? endif; ?>

	<? if( !empty($active) and $active == $row['id'] ):?>

		<? foreach($categories as $row2): ?>
			<? if( $row['id'] == $row2['parent_id'] ): ?>
				<li class="lvl-2"><a href="/users/all/?category=<?=$row2['id']?>"><?=$row2['name']?></a> (<?=$row2['number']?>)</li>
			<? endif; ?>
		<? endforeach; ?>
	<? endif; ?>

<? endforeach; ?>
</ul>

<? if( !empty($users_descr) ): ?>
<div class="sideblock nomargin">
<p class="freetext"><?=$users_descr?></p>
</div>  
<? endif; ?>

</div>
<div class="ft"></div>
</div>