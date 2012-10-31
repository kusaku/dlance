<?php $this->load->view('wdesigns/account/block'); ?>

<div id="yui-main">
	<div id="order-page" class="yui-b clearfix">
		<div class="order-title">
			<div class="tr">
				<div class="tl">
					<div align="right">
						<strong>ID платежа: <?= $id?></strong>
					</div>
				</div>
			</div>
		</div>
		<table class="order">
			<tr>
				<td class="lbl btb">Плательщик:</td>
				<td class="txt">
					<ul class="ocard">
					<img src="<?=$userpic?>" alt="" class="avatar" />
					<li class="black">
						<a href="/user/<?=$username?>"><?= $surname?><?= $name?>(<?= $username?>)</a>
					</li>
					<li>
						Последний визит: <?= $last_login?>
					</li>
					<li>
						Дата регистрации: <?= $created?>
					</li>
					</li>
					<li>
						<a href="/contacts/send/<?=$username?>">Личное сообщение</a>
					</li>
				</ul>
				</td>
			</tr>
			<tr>
				<td class="lbl">Сумма:</td>
				<td class="txt">
					<strong><?= $amount?>	рублей</strong>
				</td>
			</tr>
			<tr>
				<td class="lbl">Создан:</td>
				<td class="txt">
					<?= $date?>
				</td>
			</tr>
			<tr>
				<td class="lbl">Статус:</td>
				<td class="txt">
					<?= $status?>
				</td>
			</tr>
			<?php //Если платеж с кодом протекции ?>
			<?php if ($type == 2 and $status_id == 1): ?>
			<tr>
				<td class="lbl">Срок протекции:</td>
				<td class="txt">
					<?= $time?>
				</td>
			</tr>
			<?php endif; ?>
			<?php //Если платеж с кодом протекции и отправитель пользователь ?>
			<?php if ($type == 2 and $status_id == 1 and $user_id == $this->user_id): ?>
			<tr>
				<td class="lbl">Код протекции:</td>
				<td class="txt">
					<?= $code?>
				</td>
			</tr>
			<?php endif; ?>
		</table>
		<?= $text?>
		<?php if ($recipient_id == $this->user_id and $status_id == 1): ?>
		<?= validation_errors()?>
		<div class="rnd">
			<div>
				<div>
					<div>
						<div id="msearch">
							<form action="" method="post" /><input type="hidden" name="payment_id" value="<?=$id?>">
							<?php if ($type == 2): ?>
							Код протекции:
							<div>
								<input name="code" type="text" maxlength="6"></div>
							<?php endif; ?>
							<div>
								<input type="submit" value="Принять"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div><!--/order-page-->
</div><!--/yui-main-->