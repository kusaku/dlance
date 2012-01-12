<? $this->load->view('wdesigns/account/block'); ?>

<div class="content">
	<div class="userMoneyHeader top">
		<h3>История операций:</h3>
		<ul class="userMoneyCategory">
			<li style="width:100px;"><a href="#" class="active">Дата</a></li>
			<li style="width:150px;"><a href="#">Сумма</a></li>
			<li style="width:270px;"><a href="#">Описание</a></li>
		</ul>
	</div>
	<div class="userMoneyList">
		<? if( !empty($data) ): ?>
		<ul class="worksList">
			<? foreach($data as $row): ?>
			<li>
				<p class="type">
					<?=$row['type']?>
					<? if( $row['type_id'] == 2 and $row['status'] == 1 ): //Если платеж с кодом протекции?>
					(<?=$row['time']?>)
					<? endif; ?>
				</p>
				<p class="date"><?=$row['date']?></p>
				<p class="cost"><span><?=$row['amount']?> RUB</span></p>
				<p class="comment"><?=$row['descr']?></p>
			</li>
			<? endforeach; ?>
		</ul>
		<? else: ?>
		<ul class="worksList">
			<li><p class="type">История отсутствует.</p></li>
		</ul>
		<? endif; ?>
		<p class="subtitle">
		Список платежей. Для создания нового перевода нажмите: "<a href="/account/transfer/">Создать перевод</a>"<br />
		Для принятия отправленного вам платежа, кликните по номеру.
		</p>
	</div>
</div>