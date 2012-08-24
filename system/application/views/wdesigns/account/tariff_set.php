<? $this->load->view('wdesigns/account/block'); ?>
<div class="content">
<div class="userStatusHeader">
	<h3>Мой статус:</h3>
</div>
<?= validation_errors()?>
<form action="" method="post" />
<div class="contentWrapperBorderLeft">
	<? foreach ($data as $row): ?>
	<div class="userStatusBlock">
		<p class="label">
			<? if ($this->user_tariff == $row['id']): ?>Текущий статус:<? else : ?><?= $row['name']?><? endif; ?>
		</p>
		<p class="value status<? switch($row['name']){case 'Начальный':echo 'Base'; break;case 'PRO':echo 'Pro'; break;case 'Продвинутый':echo 'Lite'; break;}; ?>">
			<span><?= $row['name']?></span>
			<? if ($row['name'] != 'Начальный'): ?>до <?= $row['tariff_period'] /*надо как-то получить дату*/?><? endif; ?>
		</p>
		<p class="label">Комиссия:</p>
		<p class="value">
			<?= $row['commission']?>%
		</p>
		<p class="label">Вывод от:</p>
		<p class="value">
			<?= $row['minimum_w_a']?>	руб.
		</p>
		<p class="label">Цена за месяц:</p>
		<p class="value">
			<a href="#" class="buttonArrowGrey"><span><? if ($this->user_tariff == $row['id']): ?>Продлить<? else : ?>Перейти<? endif; ?></span></a>
			<?= $row['price_of_month']?>	 руб.
		</p>
		<p class="label">Цена за год:</p>
		<p class="value">
			<a href="#" class="buttonArrow"><span><? if ($this->user_tariff == $row['id']): ?>Продлить<? else : ?>Перейти<? endif; ?></span></a>
			<?= $row['price_of_year']?>	 руб.
		</p>
	</div>
	<? endforeach; ?>
</div>
</form>
</div>
<!--
Тут еще был выбор периода, нужно перевесить на "кнопки"
<select name="period">
<option value="1"<? if( 1 == 1 ): ?> selected="selected"<? endif; ?>>Месяц</option>
<option value="2"<? if( 1 == 2 ): ?> selected="selected"<? endif; ?>>Год</option>
</select>
и кнопка
<input type="submit" value="Установить">
-->
