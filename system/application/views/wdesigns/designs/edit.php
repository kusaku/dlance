<?php $this->load->view('wdesigns/account/block'); ?>
<script type="text/javascript">
	$(function(){
		/*
		$("#tags").autocomplete("<?=base_url();?>designs/tags/", {
			'multiple': true,
			'autoFill': true
		});
		*/
		
		$('#tags').autocomplete({
			source: function(request, response){
				$.getJSON("<?=base_url();?>designs/tags/", {
					'term': request.term.split(/,\s*/).pop()
				}, response);
			},
			search: function(){
				var term = this.value.split(/,\s*/).pop();
				if (term.length < 1) {
					return false;
				}
			},
			focus: function(){
				return false;
			},
			select: function(event, ui){
				var terms = this.value.split(/,\s*/);
				terms.pop();
				terms.push(ui.item.value);
				terms.push('');
				this.value = terms.join(', ');
				return false;
			}
		});
		
		//Вызывается когда вводятся символы в поле с id quantity
		$("#sub").keypress(function(e){
			//Если символ - не цифра, ввыодится сообщение об ошибке, другие символы не пишутся
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				//Вывод сообщения об ошибке
				//$("#errmsg").html("Только цифры").show().fadeOut("slow"); 
				return false;
			}
		});
		
		$("#sub").autocomplete("<?=base_url();?>designs/sub/", {
			width: 500,
			max: 10,
			scrollHeight: 300,
			multiple: true,
			matchContains: true,
			formatItem: function(row){
				return "<img src='" + row[2] + "'/> " + " ID: " + row[0] + " | <strong>Название: " + row[1] + "</strong>";
			},
			formatResult: function(row){
				return row[0].replace(/(<.+?>)/gi, '');
			}
		});
		$("#sub").result(function(event, data, formatted){
			var hidden = $(this).parent().next().find(">:input");
			hidden.val((hidden.val() ? hidden.val() + ";" : hidden.val()) + data[1]);
		});
	});
</script>
<h1 class="title">Изменение дизайна</h1>
<br/>
<div class="registrationForm">
	<?= validation_errors()?>
	<?= $error?>
	<form action="" method="post" enctype="multipart/form-data"/>
	<table class="order-form">
		<tr>
			<td class="caption">Заголовок(максимум 64 символов)<em style="color:red;">*</em>:</td>
			<td class="frnt">
				<input type="text" class="text" name="title" value="<?= set_value('title') ? set_value('title') : $design['title'] ?>" size="64" maxlength="64" style="width:540px"/>
			</td>
		</tr>
		<tr>
			<td class="caption">Категория<em style="color:red;">*</em>:</td>
			<td class="frnt cat">
					<?php foreach ($categories as $row): ?>
					<?php if ($row['parent_id'] == 0): ?>
					<fieldset><legend><?=$row['name']?></legend>
					<?php endif; ?>
					<?php foreach ($categories as $row2): ?>
					<?php if ($row['id'] == $row2['parent_id']): ?>
					
					<label><input type="checkbox" value="1" name="category[<?=$row2['id']?>]"<?= empty($design['categories'][$row2['id']]) ? '' : ' checked="checked"' ?>/><?= $row2['name']?></label>					
					<?php endif; ?>					
					<?php endforeach; ?>
					<?php if ($row['parent_id'] == 0): ?>
					</fieldset>
					<?php endif; ?>					
					<?php endforeach; ?>
			</td>
		</tr>
		<tr>
			<td class="caption">Цена<em style="color:red;">*</em>:</td>
			<td>
				<input type="text" name="price_1" value="<?= set_value('price_1') ? set_value('price_1') : $design['price_1'] ?>" size="12" maxlength="12" style="width:40px"/>рублей
			</td>
		</tr>
		<!--tr>
			<td class="caption">Цена выкупа:</td>
			<td>
				<input type="text" name="price_2" value="<?= set_value('price_2') ? set_value('price_2') : $design['price_2'] ?>" size="12" maxlength="12" style="width:40px"/>рублей
			</td>
		</tr-->
		<tr>
			<td class="caption">Описание(максимум 10000 символов)<em style="color:red;">*</em>:</td>
			<td class="frnt">
				<textarea name="text" rows="10" cols="49"><?= set_value('text') ? set_value('text') : $design['text'] ?></textarea>
			</td>
		</tr>
		<tr>
			<td class="caption">Тэги, цвета<em style="color:red;">*</em>:</td>
			<td class="frnt">
				<input type="text" class="text" name="tags" value="<?= set_value('tags') ? set_value('tags') : $design['tags'] ?>" size="64" maxlength="64" style="width:340px" id="tags" />Не менее одного тэга
			</td>
		</tr>
		<tr>
			<td class="caption">Исходники<em style="color:red;">*</em>:</td>
			<td class="frnt">
				<input type="text" class="text" name="source" value="<?= set_value('source') ? set_value('source') : $design['source'] ?>" size="64" maxlength="64" style="width:340px"/>
			</td>
		</tr>
		<tr>
			<td class="caption">Изображение для определения цвета:</td>
			<td>
				<input class="file" name="detector" type="file" />
			</td>
		</tr>		
		<tr>
			<td class="caption">Превью 1<em style="color:red;">*</em>:</td>
			<td>
				<input class="file" name="image1" type="file" />
				<?php if (!empty($design['small_image1'])): ?>
				<a style="float:right" href="<?=$design['full_image1']?>"><img src="<?=$design['small_image1']?>"/></a>
				<?php endif; ?>	
			</td>
		</tr>
		<tr>
			<td class="caption">Превью 2:</td>
			<td>
				<input class="file" name="image2" type="file" />
				<?php if (!empty($design['small_image2'])): ?>
				<a style="float:right" href="<?=$design['full_image2']?>"><img src="<?=$design['small_image2']?>"/></a>
				<?php endif; ?>			
			</td>
		</tr>
		<tr>
			<td class="caption">Превью 3:</td>
			<td>
				<input class="file" name="image3" type="file" />
				<?php if (!empty($design['small_image3'])): ?>
				<a style="float:right" href="<?=$design['full_image3']?>"><img src="<?=$design['small_image3']?>"/></a>
				<?php endif; ?>		
			</td>
		</tr>		
		<tr>
			<td class="caption">Файл (архив)<em style="color:red;">*</em>:</td>
			<td>
				<input class="file" name="file" type="file" />
				<?php if (!empty($design['dfile'])): ?>
				<a style="float:right" href="<?=$design['dfile']?>"><?=$design['dfile']?></a>
				<?php endif; ?>		
			</td>
		</tr>
		<tr>
			<td class="caption">Наложить водяные знаки:</td>
			<td>
				<span class="niceCheck"><input type="checkbox" name="watermark" value="1" /></span>Будут наложены водяные знаки на полное изображение дизайна
			</td>
		</tr>
			<tr>
			<td colspan="3"><br/><h2 class="subtitle">Дополнительные параметры, необязательны для заполнения.</h2></td>
			</tr>
		<tr>
			<td class="caption">Сопутствующие товары:</td>
			<td class="frnt">
				<input type="text" class="text" name="sub" value="<?=set_value('sub')?>" size="64" maxlength="64" style="width:340px" id="sub" />вводите ID продуктов через запятую
			</td>
		</tr>
		<tr>
			<td class="caption">Флэш:</td>
			<td>
				<input type="radio" class="niceRadio" name="flash" value="1"<?= set_radio('flash', '1') ? set_radio('flash', '1') : ($design['flash'] == 1 ? ' checked="checked"': ''); ?>/>
				<label>Да &nbsp &nbsp</label>
				<input type="radio" class="niceRadio" name="flash" value="2"<?= set_radio('flash', '2') ? set_radio('flash', '2') : ($design['flash'] == 2 ? ' checked="checked"': ''); ?>/>
				<label>Нет</label>
			</td>
		</tr>
		<tr>
			<td class="caption">Стретч:</td>
			<td>
				<input type="radio" class="niceRadio" name="stretch" value="1"<?= set_radio('stretch', '1') ? set_radio('stretch', '1') : ($design['stretch'] == 1 ? ' checked="checked"': ''); ?>/>
				<label>Тянущаяся &nbsp &nbsp</label>
				<input type="radio" class="niceRadio" name="stretch" value="2"<?= set_radio('stretch', '2') ? set_radio('stretch', '2') : ($design['stretch'] == 2 ? ' checked="checked"': ''); ?>/>
				<label>Фиксированная</label>
			</td>
		</tr>
		<tr>
			<td class="caption">Количество колонок:</td>
			<td>
				<select name="columns">
					<option></option>
					<option value="1"<?= ($_POST['columns'] == 1 or $design['columns'] == 1) ? ' selected="selected"': '' ?>>1</option>
					<option value="2"<?= ($_POST['columns'] == 2 or $design['columns'] == 1) ? ' selected="selected"': '' ?>>2</option>
					<option value="3"<?= ($_POST['columns'] == 3 or $design['columns'] == 3) ? ' selected="selected"': '' ?>>3</option>
					<option value="4"<?= ($_POST['columns'] == 4 or $design['columns'] == 4) ? ' selected="selected"': '' ?>>4</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="caption">Назначение сайта:</td>
			<td class="frnt cat">
				<select name="destination">
					<option></option>
					<?php foreach ($destinations as $row): ?>
					<option value="<?=$row['id']?>"<?= ($_POST['destination'] == $row['id'] or $design['destination'] == $row['id']) ? ' selected="selected"': '' ?>><?= $row['name']?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="caption">Тех Качество:</td>
			<td>
				<input type="radio" class="niceRadio" name="quality" value="1"<?= set_radio('quality', '1') ? set_radio('quality', '1') : ($design['quality'] == 1 ? ' checked="checked"': ''); ?>/>
				<label>Только для IE &nbsp &nbsp</label>
				<input type="radio" class="niceRadio" name="quality" value="2"<?= set_radio('quality', '2') ? set_radio('quality', '2') : ($design['quality'] == 2 ? ' checked="checked"': ''); ?>/>
				<label>Кроссбраузерная верстка&nbsp &nbsp</label>
				<input type="radio" class="niceRadio" name="quality" value="3"<?= set_radio('quality', '3') ? set_radio('quality', '3') : ($design['quality'] == 3 ? ' checked="checked"': ''); ?>/>
				<label>Полное соответствие W3C</label>
			</td>
		</tr>
		<tr>
			<td class="caption">Тип Верстки:</td>
			<td>
				<input type="radio" class="niceRadio" name="type" value="1"<?= set_radio('type', '1') ? set_radio('type', '1') : ($design['type'] == 1 ? ' checked="checked"': ''); ?>/>
				<label>Блочная верстка &nbsp &nbsp</label>
				<input type="radio" class="niceRadio" name="type" value="2"<?= set_radio('type', '2') ? set_radio('type', '2') : ($design['type'] == 2 ? ' checked="checked"': ''); ?>/>
				<label>Табличная</label>
			</td>
		</tr>
		<tr>
			<td class="caption">Тон:</td>
			<td>
				<input type="radio" class="niceRadio" name="tone" value="1"<?= set_radio('tone', '1') ? set_radio('tone', '1') : ($design['tone'] == 1 ? ' checked="checked"': ''); ?>/>
				<label>Светлый &nbsp &nbsp</label>
				<input type="radio" class="niceRadio" name="tone" value="2"<?= set_radio('tone', '2') ? set_radio('tone', '2') : ($design['tone'] == 2 ? ' checked="checked"': ''); ?>/>
				<label>Темный</label>
			</td>
		</tr>
		<tr>
			<td class="caption">Яркость:</td>
			<td>
				<input type="radio" class="niceRadio" name="bright" value="1"<?= set_radio('tone', '1') ? set_radio('tone', '1') : ($design['tone'] == 1 ? ' checked="checked"': ''); ?>/>
				<label>Спокойный &nbsp &nbsp</label>
				<input type="radio" class="niceRadio" name="bright" value="2"<?= set_radio('tone', '2') ? set_radio('tone', '2') : ($design['tone'] == 2 ? ' checked="checked"': ''); ?>/>
				<label>Яркий</label>
			</td>
		</tr>
		<tr>
			<td class="caption">Стиль:</td>
			<td>
				<input type="radio" class="niceRadio" name="style" value="1"<?= set_radio('style', '1') ? set_radio('style', '1') : ($design['style'] == 1 ? ' checked="checked"': ''); ?>/>
				<label>Новый &nbsp &nbsp</label>
				<input type="radio" class="niceRadio" name="style" value="2"<?= set_radio('style', '2') ? set_radio('style', '2') : ($design['style'] == 2 ? ' checked="checked"': ''); ?>/>
				<label>Классический	&nbsp &nbsp</label>
				<input type="radio" class="niceRadio" name="style" value="3"<?= set_radio('style', '3') ? set_radio('style', '3') : ($design['style'] == 3 ? ' checked="checked"': ''); ?>/>
				<label>Старый</label>
			</td>
		</tr>
		<tr>
			<td class="caption">Тема:</td>
			<td class="frnt cat">
				<select name="theme">
					<option></option>
					<?php foreach ($themes as $row): ?>
					<option value="<?=$row['id']?>"<?= ($_POST['theme'] == $row['id'] or $design['theme'] == $row['id']) ? ' selected="selected"': '' ?>><?= $row['name']?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="caption">Только для взрослых:</td>
			<td>
				<span class="niceCheck"><input type="checkbox" name="adult" value="1"<?= set_checkbox('adult', '1') ? set_checkbox('adult', '1') : ($design['adult'] == 1 ? ' checked="checked"': ''); ?>/></span>
				Дизайн не будет показан не авторизированным пользователям и авторизированным пользователям, которые не достигли совершенолетия. 
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<button type="submit" value="delete" name="op" class="reg-submit">Удалить</button>
				<button type="submit" value="edit" name="op" class="reg-submit">Изменить</button></form>
			</td>
		</tr>
	</table>
</div>