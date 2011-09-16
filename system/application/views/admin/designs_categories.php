	<!-- Content -->
	<article class="container_12">
		
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="/administrator/designs_categories_action">
				<h1>
Категории
<a href="/administrator/designs_categories_add/"><img src="/templates/admin/images/icons/fugue/plus-circle-blue.png" width="16" height="16"> Добавить</a>
                </h1>

				<div class="block-controls">
					<ul class="controls-buttons">
					</ul>
				</div>
<? if( !empty($categories) ): ?>
				<div class="no-margin"><table class="table" cellspacing="0" width="100%">
				
					<thead>
						<tr>
							<th class="black-cell"><span class="loading"></span></th>
							<th scope="col">Название</th>
							<th scope="col" class="table-actions">Actions</th>
						</tr>
					</thead>
					
					<tbody>
<? foreach($categories as $row): ?> 

<? if( $row['parent_id'] == 0 ): //Разделы?>
						<tr>
							<th scope="row" class="table-check-cell"><input type="checkbox" name="categories[]" value="<?=$row['id']?>" /></th>
							<td><strong><?=$row['name']?></strong></td>
							<td class="table-actions">
								<a href="/administrator/designs_categories_edit/<?=$row['id']?>" title="Редактировать" class="with-tip"><img src="/templates/admin/images/icons/fugue/pencil.png" width="16" height="16"></a>
							</td>
						</tr>
<? endif; ?>

	<? foreach($categories as $row2): ?>
			<? if( $row['id'] == $row2['parent_id'] ): ?>

						<tr>
							<th scope="row" class="table-check-cell"><input type="checkbox" name="categories[]" value="<?=$row['id']?>" /></th>
							<td><?=$row2['name']?></td>
							<td class="table-actions">
								<a href="/administrator/designs_categories_edit/<?=$row2['id']?>" title="Редактировать" class="with-tip"><img src="/templates/admin/images/icons/fugue/pencil.png" width="16" height="16"></a>
							</td>
						</tr>
			<? endif; ?>
	<? endforeach; ?>

<? endforeach; ?>
					</tbody>
				
				</table></div>
<? else: ?>
<p>Ничего не найдено.</p>
<? endif; ?>
				
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