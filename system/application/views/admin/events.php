<!-- Content -->
<article class="container_12">
	<section class="grid_12">
		<div class="block-border">
			<div class="block-content">
				<h1>События</h1>
				<div class="block-controls">
					<ul class="controls-buttons">
						<li></li>
					</ul>
				</div>
				<ul class="message no-margin">
					<li>12 events found</li>
				</ul>
				<div class="no-margin">
					<table cellspacing="0" class="list-calendar">
						<tbody>
							<?php foreach ($days as $row=>$value): ?>
							<tr class="empty">
								<th scope="row">
									<?= $value?>
								</th>
								<td>
									<?php if (! empty($events[$value])): ?><?php $cur_events = $events[$value]; ?>
									<ul class="events">
										<?php foreach ($events[$value] as $row=>$value): ?>
										<li>
											<b><?= $value['date']?></b>
											<strong><?= $value['username']?></strong>: <?= $value['title']?>
										</li>
										<?php if ($row == 25): break; endif; ?>
										<?php endforeach; ?>
									</ul>
									<div class="more-events">
										<a href="#">Смотреть остальные <?= count($cur_events)?> событий</a>
									</div>
									<?php else : ?>
									Нет событий
									<?php endif; ?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
	<div class="clear"></div>
</article>
<!-- End content -->
