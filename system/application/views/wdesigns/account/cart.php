<? $this->load->view('wdesigns/account/block'); ?>
<div class="content">
	<? if (! empty($data)): ?>
	<form action="/account/pay" method="post">
		<div class="userBasketHeader">
			<div class="makeOrder">
				<input type="submit" value="оформить заказ" class="likeLink"/>
			</div>
			<div class="clearCart">
				<a href="#">очистить корзину</a>
			</div>
			<h3>Корзина:</h3>
		</div>
		<div class="contentWrapperBorderLeft" style="min-height: 500px;">
			<ul class="cartItemsList">
				<? foreach ($data as $row): ?>
				<li class="cartItem">
					<div class="itemImg">
						<a href="<?=$row['full_image']?>" class="zoom"><img src="<?=$row['small_image']?>" alt="<?=$row['title']?>" /></a>
					</div>
					<div class="itemMainDescr">
						<h3><a href="/designs/<?=$row['design_id']?>.html"><?= $row['title']?></a></h3>
						<ul>
							<li>
								<span>Тип: </span>
								<?= $row['category']?>
							</li>
							<li>
								<span>Исходник: </span>
								<?= $row['source']?>
							</li>
							<li>
								<span>Рейтинг: </span>
								<?= $row['rating']?>
							</li>
						</ul>
					</div>
					<div class="itemExtDescr">
						<p>
							<span>Описание: </span>
							<?= $row['text']?>
						</p>
					</div>
					<div class="priceBlock">
						<? if ($row['status_id'] == 1): ?>
						<input name="designs[]" type="checkbox" value="<?=$row['id']?>" checked="checked" style="display:none;"/><? endif; ?>
						<a href="/account/cart_del/<?=$row['id']?>" class="delete" title="удалить из корзины">x</a>
						<? if ($row['kind'] == 1): ?>
						<p>
							Цена покупки: <span><?= $row['price_1']?> руб.</span>
						</p>
						<? else : ?>
						<p>
							Цена выкупа: <span><?= $row['price_2']?> руб.</span>
						</p>
						<? endif; ?>
					</div>
				</li>
				<? endforeach; ?>
			</ul>
			<div class="clear"></div>
			<div class="userBasketBottom">
				<div class="makeOrder">
					<input type="submit" value="оформить заказ" class="likeLink"/>
				</div>
				<div class="clearCart">
					<a href="#">очистить корзину</a>
				</div>
			</div>
		</div>
	</form>
	<? else : ?>
	<div class="userBasketHeader">
		<h3>Корзина:</h3>
	</div>
	<div class="contentWrapperBorderLeft" style="min-height: 500px;">
		<p>Корзина пуста.</p>
	</div>
	<? endif; ?>
</div>
