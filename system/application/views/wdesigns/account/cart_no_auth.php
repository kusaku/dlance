<div id="yui-main">
	<div class="yui-b">
		<h1><a href="/account/cart">Корзина</a></h1>
		<?php if (! empty($data)): ?>
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
				<?php foreach ($data as $row): ?>
				<tr>
					<td class="thumb" rowspan="3" style="width:150px;">
						<a href="<?=$row['full_image']?>" onclick="return hs.expand(this)"><img src="<?=$row['small_image']?>" title="<?=$row['title']?>" /></a>
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
						<?php if ($row['kind'] == 1): ?>
						Цена - Заказ: <?= $row['price_1']?>
						<?php else : ?>
						Цена - Выкуп: <?= $row['price_2']?>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<td class="options" colspan="2">
						<input name="designs[]" type="checkbox" value="<?=$row['id']?>" checked="checked"/><span class="fr">
							<?php if ($row['status_id'] == 1): ?>
							<a href="/account/buy/<?=$row['design_id']?>"><strong>Оплатить</strong>
							</a>| 
							<?php endif; ?>
							<a href="/account/cart_del/<?=$row['id']?>">Удалить</a></span>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
			<div align="right">
				<input type="submit" value="Оплатить" />
			</div>
		</form>
		<?= $page_links?>
		<?php else : ?>
		<p>Дизайны отсутствуют.</p>
		<?php endif; ?>
	</div>
</div>
<!--/yui-main-->
<?php $this->load->view('wdesigns/account/block_no_auth'); ?>