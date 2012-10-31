<?php $this->load->view('wdesigns/account/block'); ?>
<div class="content">
	<div class="userMoneyHeader top">
		<h3>История операций:</h3>
		<ul class="userMoneyCategory">
			<li style="width:100px;">
				<a href="#" class="active">Дата</a>
			</li>
			<li style="width:150px;">
				<a href="#">Сумма</a>
			</li>
			<li style="width:270px;">
				<a href="#">Описание</a>
			</li>
		</ul>
	</div>
	<div class="userMoneyList">
		<?php if (! empty($data)): ?>
		<ul class="worksList">
			<?php foreach ($data as $row): ?>
			<li>
				<p class="type">
					<?= $row['type']?>
					<?php //Если платеж с кодом протекции ?>
					<?php if ($row['type_id'] == 2 and $row['status'] == 1): ?>
					(<?= $row['time']?>)
					<?php endif; ?>
				</p>
				<p class="date">
					<?= $row['date']?>
				</p>
				<p class="cost">
					<span><?= $row['amount']?> RUB</span>
				</p>
				<p class="comment">
					<?= $row['descr']?>
				</p>
			</li>
			<?php endforeach; ?>
		</ul>
		<div class="paginationControl">
			<?= $page_links?>
		</div>
		<?php else : ?>
		<ul class="worksList">
			<li>
				<p class="type">История отсутствует.</p>
			</li>
		</ul>
		<?php endif; ?>
	</div>
</div>
