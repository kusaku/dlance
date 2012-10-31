<!-- Content -->
<article class="container_12">
	<section class="grid_12">
		<div class="block-border">
			<form class="block-content form" id="table_form" method="post" action="/administrator/applications">
				<h1>Заявки</h1>
				<a href="/administrator/applications">Все</a>
				| <a href="/administrator/applications/?status=1">Ожидающие</a>
				| <a href="/administrator/applications/?status=2">Завершенные</a>
				<div class="block-controls">
					<ul class="controls-buttons">
						<?= $page_links?>
					</ul>
				</div>
				<?php if (! empty($data)): ?>
				<div class="no-margin">
					<table class="table" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th scope="col">Пользователь</th>
								<th scope="col">Сумма</th>
								<th scope="col">Кошелек</th>
								<th scope="col">Дата</th>
								<th scope="col">Статус</th>
								<th scope="col" class="table-actions">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($data as $row): ?>
							<tr>
								<td>
									<a href="/administrator/users_edit/<?=$row['id']?>"><?= $row['username']?></a>
								</td>
								<td>
									<?= $row['amount']?>
								</td>
								<td>
									<?= $row['purse']?>
								</td>
								<td>
									<?= $row['date']?>
								</td>
								<td>
									<?= $row['status']?>
								</td>
								<td class="table-actions">
									<?php if ($row['status_id'] == 1): ?><a href="/administrator/applications_done/<?=$row['id']?>">Оплачена</a>
									<?php endif; ?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<?php else : ?>
				<p>Ничего не найдено.</p>
				<?php endif; ?>
				<ul class="message no-margin">
					<li>
						Результатов: <?= $count?>
					</li>
				</ul>
				<div class="block-footer"></div>
			</form>
		</div>
	</section>
	<div class="clear"></div>
</article>
<!-- End content -->
