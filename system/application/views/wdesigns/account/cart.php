<?php $this->load->view('wdesigns/account/block'); ?>
<div class="content">
	<?php if (! empty($data)): ?>
	<form action="/account/pay" method="post">
		<div class="userBasketHeader">
			<div class="makeOrder">
			</div>
			<div class="clearCart">
				<a href="#">очистить корзину</a>
			</div>
			<h3>Корзина:</h3>
		</div>
		<div class="contentWrapperBorderLeft" style="min-height: 500px;">
			<ul class="cartItemsList">
				<?php foreach ($data as $row): ?>
				<li class="cartItem">
					<div class="itemImg">
						<a href="<?=$row['full_image1']?>" class="zoom"><img height="154" src="<?=$row['mid_image1']?>" alt="<?=$row['title']?>" /></a>
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
						<?php if ($row['status_id'] == 1): ?>
						<input name="designs[]" type="checkbox" value="<?=$row['id']?>" checked="checked" style="display:none;"/><?php endif; ?>
						<a href="/account/cart_del/<?=$row['id']?>" class="delete" title="удалить из корзины">x</a>
						<?php if ($row['kind'] == 1): ?>
						<p>
							Цена заказа: <span><?= $row['price_1']?> руб.</span>
						</p>
						<?php else : ?>
						<p>
							Цена выкупа: <span><?= $row['price_2']?> руб.</span>
						</p>
						<?php endif; ?>
					</div>
				</li>
				<?php endforeach; ?>
			</ul>
			<div class="clear"></div>
			<div class="userBasketBottom">
				<div class="makeOrder">
				</div>
				<div class="clearCart">
					<a href="#">очистить корзину</a>
				</div>
			</div>
		</div>
	</form>
	<?php else : ?>
	<div class="userBasketHeader">
		<h3>Корзина:</h3>
	</div>
	<div class="contentWrapperBorderLeft" style="min-height: 500px;">
		<p>Корзина пуста.</p>
	</div>
	<?php endif; ?>
</div>
