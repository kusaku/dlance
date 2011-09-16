<div id="yui-main">
<div class="yui-b">


<h1><a href="/account/purchased">Купленные</a></h1>

<? if( !empty($data) ): ?>
<?=show_highslide()?>
<table class="portfolio">
<tr>
<th style="width:150px;">Превью</th>
<th>Название / Краткое описание / Ссылка</th>
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
<h4><a href="/designs/<?=$row['design_id']?>.html"><?=$row['title']?></a></h4>
<p><?=$row['text']?></p>

<a href="/account/create_download/<?=$row['design_id']?>">Перейти к скачке</a> | <a href="/account/to_email/<?=$row['design_id']?>">Отправить на почту</a>
</td>
</tr>

<tr>
<td>
Дата: <?=$row['date']?> |
Продаж: <?=$row['sales']?> |
<? if( $row['kind'] == 1 ): ?>
Покупка
<? else: ?>
Выкуп
<? endif; ?>


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