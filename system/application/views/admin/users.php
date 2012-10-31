<!-- Content -->
<article class="container_12">
	<section class="grid_12">
		<div class="block-border">
			<form class="block-content form" id="table_form" method="get" action="/administrator/users/">
				<h1>Пользователи</h1>
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
								<th scope="col">Дата регистрации</th>
								<th scope="col">Последний визит</th>
								<th scope="col">
									<span class="column-sort"><a href="/administrator/users/?order_field=balance<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>" title="Sort up" class="sort-up<?php if( $input['order_field'] == 'balance' and	$input['order_type'] == 'desc' ): ?> active<?php endif;?>"></a><a href="/administrator/users/?order_field=balance&order_type=asc<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>" title="Sort down" class="sort-down<?php if( $input['order_field'] == 'balance' and	$input['order_type'] == 'asc' ): ?> active<?php endif;?>"></a></span>
									Баланс
								</th>
								<th scope="col">
									<span class="column-sort"><a href="/administrator/users/?order_field=rating<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>" title="Sort up" class="sort-up<?php if( $input['order_field'] == 'rating' and	$input['order_type'] == 'desc' ): ?> active<?php endif;?>"></a><a href="/administrator/users/?order_field=rating&order_type=asc<?php if( !empty($url) ): ?>&<?=$url?><?php endif;?>" title="Sort down" class="sort-down<?php if( $input['order_field'] == 'rating' and	$input['order_type'] == 'asc' ): ?> active<?php endif;?>"></a></span>
									Рейтинг
								</th>
								<th scope="col" class="table-actions">Действие</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($data as $row): ?>
							<tr>
								<td>
									<a href="/user/<?=$row['username']?>" target="_new"><?= $row['surname']?><?= $row['name']?>(<?= $row['username']?>)</a>
								</td>
								<td>
									<?= $row['created']?>
								</td>
								<td>
									<?= $row['last_login']?>
								</td>
								<td>
									<?= $row['balance']?>
								</td>
								<td>
									<?= $row['rating']?>
								</td>
								<td class="table-actions">
									<a href="/administrator/users_edit/<?=$row['id']?>" title="Редактировать" class="with-tip"><img src="/templates/admin/images/icons/fugue/pencil.png" width="16" height="16"></a>
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
				<div class="block-footer">
					<img src="/templates/admin/images/icons/fugue/arrow-curve-000-left.png" width="16" height="16" class="picto">Результатов на страницу:<input type="text" name="result" size="2" maxlength="2">Ключевые слова:<input type="text" name="keywords" size="64" maxlength="64" style="width:250px;">
					<button type="submit" class="small">Поиск</button>
				</div>
			</form>
		</div>
	</section>
	<div class="clear"></div>
</article>
<!-- End content -->
