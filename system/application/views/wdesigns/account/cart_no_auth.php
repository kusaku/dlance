<div id="yui-main">
	<div class="yui-b">
		<h1><a href="/account/cart">Корзина</a></h1>
		<? if (! empty($data)): ?>
		<?= show_highslide()?>
		<form action="/account/pay_no_auth" method="post">
			<div align="right">
				<input type="submit" value="Оплатить" />
			</div>
			<br/>
			<table class="portfolio">
				<tr>
					<th style="width:150px;">Превью</th>
					<th>Название / Краткое описание</th>
				</tr>
				<? foreach ($data as $row): ?>
				<tr>
					<td class="thumb" rowspan="3" style="width:150px;">
						<a href="<?=$row['full_image']?>" class="highslide" onclick="return hs.expand(this)"><img src="<?=$row['small_image']?>" title="<?=$row['title']?>" /></a>
					</td>
					<td class="info">
						Категория: <?= $row['category']?>
					</td>
				</tr>
				<tr>
					<td>
						<h4><a href="/designs/<?=$row['design_id']?>.html"><?= $row['title']?></a></h4>
						<p>
							<?= $row['text']?>
						</p>
					</td>
				</tr>
				<tr>
					<td>
						Добавлено: <?= $row['date']?> |			 
						<? if ($row['kind'] == 1): ?>
						Цена - Покупка: <?= $row['price_1']?>
						<? else : ?>
						Цена - Выкуп: <?= $row['price_2']?>
						<? endif; ?>
					</td>
				</tr>
				<tr>
					<td class="options" colspan="2">
						<input name="designs[]" type="checkbox" value="<?=$row['id']?>" checked="checked"/><span class="fr">
							<? if ($row['status_id'] == 1): ?>
							<a href="/account/buy/<?=$row['design_id']?>"><strong>Оплатить</strong>
							</a>| 
							<? endif; ?>
							<a href="/account/cart_del/<?=$row['id']?>">Удалить</a></span>
					</td>
				</tr>
				<? endforeach; ?>
			</table>
			<div align="right">
				<input type="submit" value="Оплатить" />
			</div>
		</form>
		<?= $page_links?>
		<? else : ?>
		<p>Дизайны отсутствуют.</p>
		<? endif; ?>
	</div>
</div>
<!--/yui-main-->
<? $this->load->view('wdesigns/account/block_no_auth'); ?>