<? $this->load->view('wdesigns/account/block'); ?>
<div class="content">
	<div class="userMoneyHeader top">
		<div class="addItem">
			<div class="addItemRightBrdr">
				<span>+</span>
				<a href="/account/purses_add/">добавить кошелек</a>
			</div>
		</div>
		<h3>Мои кошельки:</h3>
		<ul class="userMoneyCategory">
			<li style="width:100px;">
				<a href="#" class="active">Номер кошелька</a>
			</li>
			<li style="width:100px;">
				<a href="#">Сумма выплат</a>
			</li>
			<li style="width:100px;">
				<a href="#">Дата создания</a>
			</li>
			<li style="width:120px;">
				<a href="#">Последняя операция</a>
			</li>
		</ul>
	</div>
	<div class="userMoneyList">
		<? if (! empty($data)): ?>
		<ul class="worksList">
			<? foreach ($data as $row): ?>
			<li>
				<p class="ctype">
					<img src="images/yad.png" alt="Нужен тип кошелька" />
				</p>
				<p class="nomber">
					<span><?= $row['purse']?></span>
				</p>
				<p class="summ">
					<?= $row['amount']?>	USD
				</p>
				<p class="date">
					<?= $row['date']?>
				</p>
				<p class="last">
					<?= $row['last_operation']?>
				</p>
				<p class="spec">
					<span>x</span>
					<a href="/account/purses_del/<?=$row['id']?>">удалить</a>
				</p>
			</li>
			<? endforeach; ?>
		</ul>
		<? else : ?>
		<ul class="worksList">
			<li>
				<p>Кошельки отсутствуют.</p>
			</li>
		</ul>
		<? endif; ?>
	</div>
</div>
