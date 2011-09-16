	<!-- Content -->
	<article class="container_12">

		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="/administrator/reports_action">
				<h1>Жалобы</h1>
				<a href="/administrator/reports">Все</a> | 
<a href="/administrator/reports/?status=1">Открытые</a> | 
<a href="/administrator/reports/?status=2">Закрытые</a>
				<div class="block-controls">
					<ul class="controls-buttons">
					<?=$page_links?>	
					</ul>
				</div>
<? if( !empty($data) ): ?>
				<div class="no-margin"><table class="table" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class="black-cell"><span class="loading"></span></th>
							<th scope="col">Дизайн</th>
							<th scope="col">Отправитель</th>
							<th scope="col">Дата</th>
							<th scope="col">Статус</th>
							<th scope="col" class="table-actions">Actions</th>
						</tr>
					</thead>
					
					<tbody>
<? foreach($data as $row): ?>
						<tr>
							<th scope="row" class="table-check-cell"><input type="checkbox" name="reports[]" value="<?=$row['id']?>" /></th>
							<td><?=$row['title']?></td>
							<td><a href="/user/<?=$row['username']?>"><?=$row['username']?></a></td>
							<td><?=$row['date']?></td>
							<td><?=$row['status']?></td>
							<td class="table-actions">
								<a href="#" onClick="openModal(<?=$row['id']?>); return false;" title="Открыть" class="with-tip">Открыть</a>
							</td>
						</tr>
<? endforeach; ?>
					</tbody>
				
				</table></div>
<? else: ?>
<p>Ничего не найдено.</p>
<? endif; ?>
				<ul class="message no-margin">
					<li>Результатов: <?=$count?></li>
				</ul>
				
				<div class="block-footer">
					<img src="/templates/admin/images/icons/fugue/arrow-curve-000-left.png" width="16" height="16" class="picto"> 
					<select name="action" id="action" class="small">
						<option value="">С выбранными...</option>
						<option value="close">Закрыть</option>
						<option value="delete">Удалить</option>
					</select>
					<button type="submit" class="small">Ok</button>
				</div>
					
			</form></div>
		</section>
		
		<div class="clear"></div>
		
	</article>
	
	<!-- End content -->