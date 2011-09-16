<div id="yui-main">
<div class="yui-b">


<h1><a href="/account/designs">Дизайны</a></h1>
<p class="subtitle"> Список ваших дизайнов. Для публикации нового дизайна нажмите: "<a href="/designs/add/">Добавить дизайн</a>"</p>

<div class="offers-stateline">Статус: 
<span>
<a href="/account/designs">все</a> |
<a href="/account/designs/?status=1">открытые </a> |
<a href="/account/designs/?status=2">выкупленные </a> |
<a href="/account/designs/?status=3">закрытые </a>
</span>
</div>

<? if( !empty($data) ): ?>
<?=show_highslide()?>
<table class="portfolio">
<tr>
<th style="width:150px;">Превью</th>
<th>Название / Краткое описание</th>
</tr>
<? foreach($data as $row): ?>


<tr>
<td class="thumb" rowspan="3" style="width:150px;">
<a href="<?=$row['full_image']?>" class="highslide" onclick="return hs.expand(this)">
<img src="<?=$row['small_image']?>" title="<?=$row['title']?>" />
</a>
</td>
<td class="info">Категория: <?=$row['category']?></td>
</tr>

<tr>
<td>
<h4><a href="/designs/<?=$row['id']?>.html"><?=$row['title']?></a></h4>
<p><?=$row['text']?></p>
</td>
</tr>

<tr>
<td>Статус: <?=$row['status']?> | Дата: <?=$row['date']?></td>
</tr>
<tr>


<td class="options" colspan="2">
<span class="fr">
<a href="/designs/edit/<?=$row['id']?>">Редактировать</a>
</span>
</td>
</tr>
<? endforeach; ?>
</table>
<?=$page_links?>
<? else: ?>
<p>Дизайны отсутствуют.</p>
<? endif; ?>


  </div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>