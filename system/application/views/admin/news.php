	<!-- Content -->
	<article class="container_12">
		
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="/administrator/news_del">
				<h1>
Новости
<a href="/administrator/news_add/"><img src="/templates/admin/images/icons/fugue/plus-circle-blue.png" width="16" height="16"> Добавить</a>
                </h1>

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
							<th scope="col">Заголовок</th>
							<th scope="col">
								<span class="column-sort">
									<a href="#" title="Sort up" class="sort-up"></a>
									<a href="#" title="Sort down" class="sort-down"></a>
								</span>
								Дата
							</th>
							<th scope="col" class="table-actions">Actions</th>
						</tr>
					</thead>
					
					<tbody>
<? foreach($data as $row): ?>
						<tr>
							<th scope="row" class="table-check-cell"><input type="checkbox" name="news[]" value="<?=$row['id']?>" /></th>
							<td><?=$row['title']?></td>
							<td><?=$row['date']?></td>
							<td class="table-actions">
								<a href="/administrator/news_edit/<?=$row['id']?>" title="Редактировать" class="with-tip"><img src="/templates/admin/images/icons/fugue/pencil.png" width="16" height="16"></a>
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
						<option value="delete">Удалить</option>
					</select>
					<button type="submit" class="small">Ok</button>
				</div>
					
			</form></div>
		</section>
		
		<div class="clear"></div>
		
	</article>
	
	<!-- End content -->