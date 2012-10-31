<script src="/templates/js/register.js" type="text/javascript"></script>
<?= show_highslide()?>
<h1 class="title">Оформление покупки</h1>
<p class="subtitle">Дополнительные параметры, необязательны для заполнения.</p>
<div id="register" style="margin:10px;"></div>
<input name="cart" type="hidden" id="cart" value="<?=$cart?>" />
<div class="rnd">
	<div>
		<div>
			<div style="overflow:hidden;">
				<table class="order-form">
					<tr>
						<td class="caption">Общая сумма:</td>
						<td>
							<input name="total_amount" type="hidden" id="total_amount" value="<?=$total_amount?>" /><?= $total_amount?>	рублей
						</td>
					</tr>
					<tr>
						<td class="caption">Логин:</td>
						<td>
							<input name="username" type="text" size="20" id="username" />&nbsp;<span class="error"><span id="username_err"></span></span>
						</td>
					</tr>
					<tr>
						<td class="caption">Email:</td>
						<td>
							<input name="email" type="text" size="20" id="email" />&nbsp;<span class="error"><span id="email_err"></span></span>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<div align="center" id="robokassa">
	<input type="button" id="sendbtn" value="Отправить" onclick="send()"/>
</div>
<br/>
<?php foreach ($data as $row): ?>
<div class="rnd">
	<div>
		<div>
			<div style="overflow:hidden;">
				<table class="order-form">
					<tr>
						<td class="caption">ID дизайна:</td>
						<td>
							<?= $row['id']?>
						</td>
					</tr>
					<tr>
						<td class="caption">Дизайн:</td>
						<td>
							<div class="highslide-gallery">
								<div style="width: 170px;">
									<a href="<?=$row['full_image']?>" class="highslide" onclick="return hs.expand(this)"><img src="<?=$row['small_image']?>" title="<?=$row['title']?>" /></a>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="caption">Цена:</td>
						<td>
							<?php if ($row['kind'] == 1): ?>
							Покупка: <?= $row['price_1']?>
							<?php else : ?>
							Выкуп: <?= $row['price_2']?>
							<?php endif; ?>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<?php endforeach; ?>