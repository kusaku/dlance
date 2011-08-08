<div id="yui-main">
<div class="yui-b clearfix"> 
<div class="index-about">
<h1>Биржа по продаже и покупки дизайнов для сайтов Dlance.ru</h1>
<p>
Для современных бизнесменов важен не только престиж фирмы на рынке и репутация компании в обществе, но ещё и дизайнерское оформление логотипа и официального сайта компании, который, по сути, является визитной карточкой и олицетворением вашего бизнеса в глазах клиентов. В своё время Бил Гейтс сказал: «В будущем останется только два вида компаний: те, которые работают в интернете и те, которые вышли из бизнеса».  Ресурс Dlance.ru представляет собой биржу дизайнеров интернет сайтов, которые готовы выполнить ваш заказ в кратчайшие сроки и за умеренную плату. Сегодня работа фрилансом приобрела особенную популярность по многим причинам. Во-первых, это отсутствие необходимости снимать специальное помещение под офис для сотрудников. Во-вторых, пропадает необходимость набирать сотрудников в штат. Можно просто заказать оформление сайта одному из пользователей нашего ресурса. Подобный вид работы будет выполнен быстро и качественно, а также не потребует от вас дополнительных затрат. В том случает, если вы являетесь фрилансером и способны предоставить услуги качественного дизайна интернет сайтов, то у вас есть возможность найти себе задание, которое будет интересно именно вам. Вы сможете выполнить за обусловленное время и незамедлительно получить оплату, не опасаясь за оплату своего труда. Качественный фирменный стиль вашего сайта и отличные условия работы для фрилансеров – именно это делает ресурс Dlance.ru прекрасным выбором как для фрилансеров, так и для работодателей.
</p>
</div>

<h2>ТОП пользовательского рейтинга вебдизайнов</h2>

<div id="ptf">
<div class="top-payed">
<ul>
<? foreach($top_designs as $row): ?>
<li>
<a href="#"><img src="<?=$row['small_image']?>" title="<?=$row['title']?>" width="50px"></a>
<div>
<strong><a href="/designs/<?=$row['id']?>.html"><?=$row['title']?></a></strong>
Рейтинг: <?=$row['rating']?>
</div>
</li>
<? endforeach; ?>
</ul>
</div>
</div>

<br /><br /><br />



<div id="bubble-2" class="mb20"></div>
<div align="right"><a  href="/designs/add/"><b>Добавить дизайн</b></a></div>
<div class="latest-orders">
<h3>Последние дизайны сайтов</h3>

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
<td class="topline lft txtl">Заголовок / Превью</td>
<td class="topline" style="width: 70px;"><a  href="/designs/index/?order_field=rating">Рейтинг</a></td>
<td class="topline" style="width: 70px;"><a  href="/designs/index/?order_field=price_1">Цена</a></td>
<td class="topline rht" style="width: 70px;"><a  href="/designs/index/?order_field=price_2">Цена выкупа</a></td>
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
<td class="offcount"><?=$row['rating']?></td>
<td class="budget"><?=$row['price_1']?> рублей</td>
<td class="budget"<? if( $row['sales'] > 0 ): ?> style="text-decoration:line-through"<? endif; ?>><?=$row['price_2']?> рублей</td>


</tr>
<? endforeach; ?>

<? else: ?>
<p>Ничего не найдено.</p>
<? endif; ?>
<tr>
<td colspan="1" class="topline lft txtl">&nbsp;</td>
<td colspan="3" class="topline rht txtr"><a href="/designs">Смотреть все</a></td>
</tr>
</table> 

</div>
</div>
</div>


<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div class="bd clearfix">

<div class="sideblock">
	<h3>Новости проекта</h3>
	<ul class="latest-page">
<? foreach($news as $row): ?>
		<li><?=$row['date']?> | <a href="/news/<?=$row['id']?>.html"><?=$row['title']?></a></li>
<? endforeach; ?>
	</ul>
</div>

<div class="sideblock clearfix">
	<h3>Статистика</h3>
	<ul class="index-stats">
		<li><span><?=$count_designs?></span><a href="/designs">Дизайны</a></li>
		<li class="last"><span><?=$count_users?></span>Пользователи</li>
	</ul>
</div>

<div class="sideblock clearfix">
	<h3>Облако тегов</h3>
<div id="tagcloud">
<ul>
<?=$tagcloud?>
</ul>
</div>
</div>

<div class="sideblock">
	<h3>TOP 10 пользователей</h3>
	<ol class="best-contractors">
<? foreach($top_users as $row): ?>
			<li><span>(<?=$row['views']?>)</span><a href="/user/<?=$row['username']?>"><?=$row['username']?></a></li>
<? endforeach; ?>
	</ol>
</div>

<div class="sideblock">
      <h3>Последнии зарегистрированные пользователи</h3>
      <ol class="best-contractors">
<? foreach($newest_users as $row): ?>
        <li><a href="/user/<?=$row['username']?>"><?=$row['username']?></a></li>
<? endforeach; ?>
      </ol>
</div>


<div class="sideblock nomargin">
<p class="freetext">
На дворе XXI век и в данный момент работа дизайнера востребована не только для дизайна, каких либо интерьеров, помещений, но и для дизайна интернет ресурсов! Эта работа выполняется на дому, тем самым нет лишних затрат на аренду помещения для бизнеса. Поэтому дизайн будет стоить дешевле. Если вы решили организовать свое дело или оно у вас уже есть, то вам для привлечения новых клиентов понадобится личный сайт, к которому нужен будет особый дизайн! Dlance.ru поможет вам в этом! 
Интернет ресурсов с каждым днем становится все больше и больше, но только те сайты остаются посещаемые на которых содержится что-то индивидуальное, что может радовать глаз. На сайте Dlance.ru представлены разные виды, примеры дизайнов.
На сайте Dlance.ru вы можете заказать для себя дизайн или же купить уже имеющиеся на сайте! 
Если же вы сами рисуете дизайны web сайтов Dlance.ru вам будет в помощь ведь на этом сайте, возможно, не только покупать дизайны, но и продавать свои дизайны! Чем это выгоднее для вас! Выгода в том, что этот интернет ресурс очень продвинут и удобен в использовании. Добавляйте ваши дизайны и получайте прибыль!

</p>
</div>   

</div>
<div class="ft"></div>
</div>