	<!-- Content -->
	<article class="container_12">

		<section class="grid_12">
			<div class="block-border"><form class="block-content form" name="table_form" id="table_form" method="post" action="">
				<h1>Пользователи</h1>

					<fieldset class="grey-bg">
						<legend><a href="#">Настройки</a></legend>
						<div class="float-left gutter-right">
							<label for="stats-period">Период</label>
							<span class="input-type-text"><input type="text" name="range" id="range" value=""></span>
						</div>
						<div class="float-left gutter-right">
							<label for="stats-period">Результатов на страницу</label>
							<span class="input-type-text"><input type="text" name="result" value="<?=$input['result']?>"></span>
							<button type="submit" class="small">Поиск</button></div>
					</fieldset>

				<div class="block-controls">
					<ul class="controls-buttons">
					<?=$page_links?>	
					</ul>
				</div>
				
				<div class="with-head no-margin">
					
					<div class="head">
						<div class="black-cell with-gap"><span class="success"></span></div>
						<div class="black-cell">Сортировать по</div>
						<div>
								<span class="column-sort">
									<a href="/administrator/categories_followers/?order_field=balance<? if( !empty($url) ): ?>&<?=$url?><? endif;?>" title="Sort up" class="sort-up<? if( $input['order_field'] == 'balance' and  $input['order_type'] == 'desc' ): ?> active<? endif;?>"></a>

									<a href="/administrator/categories_followers/?order_field=balance&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>" title="Sort down" class="sort-down<? if( $input['order_field'] == 'balance' and  $input['order_type'] == 'asc' ): ?> active<? endif;?>"></a>
								</span>
								Баланс
						</div>
						<div>
								<span class="column-sort">
									<a href="/administrator/categories_followers/?order_field=rating<? if( !empty($url) ): ?>&<?=$url?><? endif;?>" title="Sort up" class="sort-up<? if( $input['order_field'] == 'rating' and  $input['order_type'] == 'desc' ): ?> active<? endif;?>"></a>

									<a href="/administrator/categories_followers/?order_field=rating&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>" title="Sort down" class="sort-down<? if( $input['order_field'] == 'rating' and  $input['order_type'] == 'asc' ): ?> active<? endif;?>"></a>
								</span>
								Рейтинг
						</div>
					</div>
					
					<ul class="grid dark-grey-gradient">
<? foreach($data as $row): ?>
						<li>
							<div class="grid-picto user">
								<small><?=$row['surname']?> <?=$row['name']?></small>
								<p class="grid-name"><?=$row['username']?></p>
								<p class="grid-details">Баланс: <b><?=$row['balance']?></b><br>
								Рейтинг: <b><?=$row['rating']?></b></p>
							</div>
							<ul class="grid-actions">
								<li><a href="/administrator/users_edit/<?=$row['id']?>" title="Редактировать" class="with-tip"><img src="/templates/admin/images/icons/fugue/pencil.png" width="16" height="16"></a></li>
								<li><input type="checkbox" name="selected[]" id="grid-selected-1" value="1"></li>
							</ul>
						</li>
<? endforeach; ?>
						
					</ul>
				</div>
				
				<ul class="message no-margin">
					<li>Результатов: <?=$count?></li>
				</ul>
				
				<div class="block-footer">					

				</div>
					
			</form></div>
		</section>

		<div class="clear"></div>
		
	</article>
	
	<!-- End content -->