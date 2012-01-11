<? $this->load->view('wdesigns/account/block'); ?>

<div class="content">
	<div class="userBasketHeader">
		<div class="makeOrder">
			<a href="#">оформить заказ</a>
		</div>
		<div class="clearCart">
			<a href="#">очистить корзину</a>
		</div>
		<h3>Корзина:</h3>
	</div>
	<div class="contentWrapperBorderLeft" style="min-height: 500px;">
		<? if( !empty($data) ): ?>
		<ul class="cartItemsList">
			<? foreach($data as $row): ?>
			<li class="cartItem">
				<div class="itemImg">
					<a href="<?=$row['full_image']?>" class="zoom"><img src="<?=$row['small_image']?>" alt="<?=$row['title']?>" /></a>
				</div>
				<div class="itemMainDescr">
					<h3><a href="/designs/<?=$row['design_id']?>.html"><?=$row['title']?></a></h3>
					<ul>
						<li><span>Тип: </span><?=$row['category']?></li>
						<li><span>Исходник: </span><?=$row['source']?></li>
						<li><span>Рейтинг: </span><?=$row['rating']?></li>
					</ul>
				</div>
				<div class="itemExtDescr">
					<p><span>Описание: </span><?=$row['text']?></p>
				</div>
				<div class="priceBlock">
					<a href="/account/cart_del/<?=$row['id']?>" class="delete" title="удалить из корзины">x</a>
					<? if( $row['kind'] == 1 ): ?>
					<p>Цена покупки: <span><?=$row['price_1']?> руб.</span></p>
					<? else: ?>
					<p>Цена выкупа: <span><?=$row['price_2']?> руб.</span></p>
					<? endif; ?>
				</div>
			</li>
			<? endforeach; ?>
		</ul>
		<div class="clear"></div>
		<div class="userBasketBottom">
			<form action="/account/pay" method="post">
			<div class="makeOrder">
				<a href="#">оформить заказ</a>
				<!--<input type="submit" value="Оплатить" />-->
			</div>
			<div class="clearCart">
				<a href="#">очистить корзину</a>
			</div>
		</div>
		<? else: ?>
		<p>Корзина пуста.</p>
		<? endif; ?>
	</div>
</div>