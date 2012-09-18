<script type="text/javascript" src="/templates/js/jquery.js"></script>
<script type="text/javascript" src="/templates/js/datepicker/ui.datepicker.js"></script>
<script type="text/javascript" src="/templates/js/datepicker/datepicker.translate.js"></script>
<style type="text/css">
	* {
		margin: 0;
		padding: 0;
	}
	
	html, body {
		/*background-color:#E2F2E2;*/
	}
	
	/* Стили для jQuery UI Datepicker */
	#datepicker_div, .datepicker_inline {
		font-family: "Trebuchet MS", Tahoma, Verdana, Arial, Helvetica, sans-serif;
		font-size: 12px;
		padding: 0;
		margin: 0;
		background: #DDD;
		width: 185px;
	}
	
	#datepicker_div {
		display: none;
		border: 1px solid #FF9900;
		z-index: 10;
	}
	
	.datepicker_inline {
		float: left;
		display: block;
		border: 0;
	}
	
	.datepicker_dialog {
		padding: 5px !important;
		border: 4px ridge #DDD !important;
	}
	
	button.datepicker_trigger {
		width: 25px;
	}
	
	img.datepicker_trigger {
		margin: 2px;
		vertical-align: middle;
	}
	
	.datepicker_prompt {
		float: left;
		padding: 2px;
		background: #DDD;
		color: #000;
	}
	* html .datepicker_prompt {
		width: 185px;
	}
	
	.datepicker_control, .datepicker_links, .datepicker_header, .datepicker {
		clear: both;
		float: left;
		width: 100%;
		color: #FFF;
	}
	
	.datepicker_control {
		background: #FF9900;
		padding: 2px 0px;
	}
	
	.datepicker_links {
		background: #E0F4D7;
		padding: 2px 0px;
	}
	
	.datepicker_control, .datepicker_links {
		font-weight: bold;
		font-size: 80%;
		letter-spacing: 1px;
	}
	
	.datepicker_links label {
		padding: 2px 5px;
		color: #888;
	}
	
	.datepicker_clear, .datepicker_prev {
		float: left;
		width: 34%;
	}
	
	.datepicker_current {
		float: left;
		width: 30%;
		text-align: center;
	}
	
	.datepicker_close, .datepicker_next {
		float: right;
		width: 34%;
		text-align: right;
	}
	
	.datepicker_header {
		padding: 1px 0 3px;
		background: #83C948;
		text-align: center;
		font-weight: bold;
		height: 1.3em;
	}
	
	.datepicker_header select {
		background: #83C948;
		color: #000;
		border: 0px;
		font-weight: bold;
	}
	
	.datepicker {
		background: #CCC;
		text-align: center;
		font-size: 100%;
	}
	
	.datepicker a {
		display: block;
		width: 100%;
	}
	
	.datepicker .datepicker_titleRow {
		background: #B1DB87;
		color: #000;
	}
	
	.datepicker .datepicker_daysRow {
		background: #FFF;
		color: #666;
	}
	
	.datepicker_weekCol {
		background: #B1DB87;
		color: #000;
	}
	
	.datepicker .datepicker_daysCell {
		color: #000;
		border: 1px solid #DDD;
	}
	
	#datepicker .datepicker_daysCell a {
		display: block;
	}
	
	.datepicker .datepicker_weekEndCell {
		background: #E0F4D7;
	}
	
	.datepicker .datepicker_daysCellOver {
		background: #FFF;
		border: 1px solid #777;
	}
	
	.datepicker .datepicker_unselectable {
		color: #888;
	}
	
	.datepicker_today {
		background: #B1DB87 !important;
	}
	
	.datepicker_currentDay {
		background: #83C948 !important;
	}
	
	#datepicker_div a, .datepicker_inline a {
		cursor: pointer;
		margin: 0;
		padding: 0;
		background: none;
		color: #000;
	}
	
	.datepicker_inline .datepicker_links a {
		padding: 0 5px !important;
	}
	
	.datepicker_control a, .datepicker_links a {
		padding: 2px 5px !important;
		color: #000 !important;
	}
	
	.datepicker_titleRow a {
		color: #000 !important;
	}
	
	.datepicker_control a:hover {
		background: #FDD !important;
		color: #333 !important;
	}
	
	.datepicker_links a:hover, .datepicker_titleRow a:hover {
		background: #FFF !important;
		color: #333 !important;
	}
	
	.datepicker_multi .datepicker {
		border: 1px solid #83C948;
	}
	
	.datepicker_oneMonth {
		float: left;
		width: 185px;
	}
	
	.datepicker_newRow {
		clear: left;
	}
	
	.datepicker_cover {
		display: none;
		display /**/:block;
		position: absolute;
		z-index: -1;
		filter: mask();
		top:
		-4px;
		left:
		-4px;
		width:
		193px;
		height:
		200px;
	}
	
	/* Стили для jQuery UI Datepicker */
</style>

<!-- Content -->
<article class="container_12">
	<section class="grid_12">
		<div class="block-border">
			<form class="block-content form" id="table_form" method="get" action="/administrator/transaction/">
				<h1>История операций</h1>
				<fieldset class="grey-bg">
					<legend>
						<a href="#">Настройки</a>
					</legend>
					<div class="float-left gutter-right">
						<label for="stats-period">Период</label>
						<span class="input-type-text"><input type="text" name="range" id="range" value="<?=$input['range']?>"><img src="/templates/admin/images/icons/fugue/calendar-month.png" width="16" height="16"></span>
					</div>
					<div class="float-left gutter-right">
						<label for="stats-period">Тип</label>
						<span>
							<select name="sort">
								<option value="0">Все</option>
								<option value="Пополнение"<? if( $input['sort'] == 'Пополнение' ): ?> selected="selected"<? endif; ?>>Пополнение</option>
								<option value="Вывод средств"<? if( $input['sort'] == 'Вывод средств' ): ?> selected="selected"<? endif; ?>>Вывод средств</option>
								<option value="Перевод средств"<? if( $input['sort'] == 'Перевод средств' ): ?> selected="selected"<? endif; ?>>Перевод средств</option>
								<option value="Получение средств"<? if( $input['sort'] == 'Получение средств' ): ?> selected="selected"<? endif; ?>>Получение средств</option>
								<option value="Установка виртуального статуса"<? if( $input['sort'] == 'Установка виртуального статуса' ): ?> selected="selected"<? endif; ?>>Установка виртуального статуса</option>
								<option value="Продление виртуального статуса"<? if( $input['sort'] == 'Продление виртуального статуса' ): ?> selected="selected"<? endif; ?>>Продление виртуального статуса</option>
								<option value="Продажа дизайна"<? if( $input['sort'] == 'Продажа дизайна' ): ?> selected="selected"<? endif; ?>>Продажа дизайна</option>
								<option value="Покупка дизайна"<? if( $input['sort'] == 'Покупка дизайна' ): ?> selected="selected"<? endif; ?>>Покупка дизайна</option>
							</select>
						</span>
					</div>
					<div class="float-left gutter-right">
						<label for="stats-period">Результатов на страницу</label>
						<span class="input-type-text"><input type="text" name="result" value="<?=$input['result']?>"></span>
						<button type="submit" class="small">Поиск</button>
					</div>
				</fieldset>
				<a href="/administrator/transaction/?range=<?=$day?>+-+<?=$today?>">вчера</a>
				| <a href="/administrator/transaction/?range=<?=$today?>+-+<?=$today?>">сегодня</a>
				| <a href="/administrator/transaction/?range=<?=$week?>+-+<?=$today?>">неделя</a>
				| <a href="/administrator/transaction/?range=<?=$month?>+-+<?=$today?>">месяц</a>
				| <a href="/administrator/transaction/?range=<?=$year?>+-+<?=$today?>">год</a>
				| <a href="/administrator/transaction/">за весь период</a>
				<div class="block-controls">
					<ul class="controls-buttons">
						<?= $page_links?>
					</ul>
				</div>
				<? if (! empty($data)): ?>
				<div class="no-margin">
					<table class="table" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th scope="col">Пользователь</th>
								<th scope="col">
									<span class="column-sort"><a href="/administrator/transaction/?order_field=descr<? if( !empty($url) ): ?>&<?=$url?><? endif;?>" title="Sort up" class="sort-up<? if( $input['order_field'] == 'descr' and	$input['order_type'] == 'desc' ): ?> active<? endif;?>"></a><a href="/administrator/transaction/?order_field=descr&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>" title="Sort down" class="sort-down<? if( $input['order_field'] == 'descr' and	$input['order_type'] == 'asc' ): ?> active<? endif;?>"></a></span>
									Описание
								</th>
								<th scope="col">Сумма</th>
								<th scope="col">
									<span class="column-sort"><a href="/administrator/transaction/?order_field=date<? if( !empty($url) ): ?>&<?=$url?><? endif;?>" title="Sort up" class="sort-up<? if( $input['order_field'] == 'date' and	$input['order_type'] == 'desc' ): ?> active<? endif;?>"></a><a href="/administrator/transaction/?order_field=date&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>" title="Sort down" class="sort-down<? if( $input['order_field'] == 'date' and	$input['order_type'] == 'asc' ): ?> active<? endif;?>"></a></span>
									Дата
								</th>
							</tr>
						</thead>
						<tbody>
							<? foreach ($data as $row): ?>
							<tr>
								<td>
									<a href="/user/<?=$row['username']?>">
										<?= $row['username']?>
									</a>
								</td>
								<td>
									<?= $row['descr']?>
								</td>
								<td>
									<?= $row['amount']?>
								</td>
								<td>
									<?= $row['date']?>
								</td>
							</tr>
							<? endforeach; ?>
						</tbody>
					</table>
				</div>
				<? else : ?>
				<p>Ничего не найдено.</p>
				<? endif; ?>
				<ul class="message no-margin">
					<li>
						Результатов: 
						<?= $count?>
					</li>
					<li>
						Сумма: 
						<?= $total_sum?>
						рублей
					</li>
				</ul>
			</form>
		</div>
	</section>
	<div class="clear"></div>
</article>
<!-- End content -->
<script type="text/javascript">
	$(document).ready(function(){
		// ---- Календарь -----
		$('#range').attachDatepicker({
			rangeSelect: true,
			yearRange: '2000:2012',
			firstDay: 1
		});
		// ---- Календарь -----
	});
</script>
