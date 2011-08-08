<script type='text/javascript' src='/templates/js/jquery-autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="/templates/js/jquery-autocomplete/jquery.autocomplete.css" />
<script type="text/javascript">
$().ready(function() {
	$("#tags").autocomplete("<?=base_url()?>designs/tags/", {
		multiple: true,
		autoFill: true
	});

    //Вызывается когда вводятся символы в поле с id quantity
    $("#sub").keypress(function (e)  
    { 
      //Если символ - не цифра, ввыодится сообщение об ошибке, другие символы не пишутся
      if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
      {
		//Вывод сообщения об ошибке
		//$("#errmsg").html("Только цифры").show().fadeOut("slow"); 
        return false;
      }    
    });
	
	$("#sub").autocomplete("<?=base_url()?>designs/sub/", {
		width: 500,
		max: 10,
		scrollHeight: 300,
		multiple: true,
		matchContains: true,
		formatItem: function(row) {
			return "<img src='" + row[2] + "'/> " + " ID: " + row[0] + " | <strong>Название: " + row[1] + "</strong>";
		},
		formatResult: function(row) {
			return row[0].replace(/(<.+?>)/gi, '');
		}
	});
	$("#sub").result(function(event, data, formatted) {
		var hidden = $(this).parent().next().find(">:input");
		hidden.val( (hidden.val() ? hidden.val() + ";" : hidden.val()) + data[1]);
	});
});
</script>
<h1 class="title">Форма добавления новых дизайнов</h1>
<p class="subtitle">Добавить новый дизайн</p>
<?=validation_errors()?>
<? if( !empty($error) ) {?><?=$error?><? } ?>
<form action="" method="post" enctype="multipart/form-data"/>
  <div class="rnd">
    <div>
      <div>
        <div style="overflow:hidden;">
          <table class="order-form">
            <tr>
              <td class="caption">Заголовок(максимум 64 символов):</td>
              <td class="frnt"><input type="text" class="text" name="title" value="<?=set_value('title')?>" size="64" maxlength="64" /></td>
            </tr>

            <tr>
              <td class="caption">Категория:</td>
              <td class="frnt cat">
<select name="category_id">
<option></option>
<? foreach($categories as $row): ?> 

<? if( $row['parent_id'] == 0): ?>
<optgroup label="<?=$row['name']?>">
<? endif; ?>

	<? foreach($categories as $row2): ?>
			<? if( $row['id'] == $row2['parent_id'] ): ?>
				<option value="<?=$row2['id']?>"<?=set_select('category_id', ''.$row2['id'].''); ?>><?=$row2['name']?></option>
			<? endif; ?>
	<? endforeach; ?>
<? endforeach; ?>
</select>
              </td>
            </tr>

            <tr>
              <td class="caption">Цена:</td>
              <td>
<input type="text" name="price_1" value="<?=set_value('price_1')?>" size="12" maxlength="12" /> рублей
              </td>
            </tr>



            <tr>
              <td class="caption">Цена выкупа:</td>
              <td>
<input type="text" name="price_2" value="<?=set_value('price_2')?>" size="12" maxlength="12" /> рублей
              </td>
            </tr>

            <tr>
              <td class="caption">Описание(максимум 10000 символов):</td>
              <td class="frnt"><textarea name="text" rows="10" cols="49"><?=set_value('text')?></textarea></td>
            </tr>

            <tr>
              <td class="caption">Тэги:</td>
              <td class="frnt"><input type="text" class="text" name="tags" value="<?=set_value('tags')?>" size="64" maxlength="64"  id="tags" />  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  Не менее одного тэга</td>
            </tr>

            <tr>
              <td class="caption">Загрузка изображения:</td>
              <td><input class="file" name="userfile" type="file" />  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  Размер — до 1 Мб, Формат — JPG, Разрешение - до 1024x768 px</td>
            </tr>

            <tr>
              <td class="caption">Файл:</td>
              <td><input class="file" name="file" type="file" />  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  Размер — до 100 Мб, Формат — ZIP, RAR</td>
            </tr>

            <tr>
              <td class="caption">Наложить водяные знаки:</td>
              <td><input type="checkbox" name="watermark" value="1" />  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  Будут наложены водяные знаки на полное изображение дизайна</td>
            </tr>


          </table>
        </div>
      </div>
    </div>
  </div>




<p class="subtitle">Дополнительные параметры, необязательны для заполнения.</p>
  <div class="rnd">
    <div>
      <div>
        <div style="overflow:hidden;">
          <table class="order-form">
            <tr>
              <td class="caption">Сопутствующие товары:</td>
              <td class="frnt"><input type="text" class="text" name="sub" value="<?=set_value('sub')?>" size="64" maxlength="64"  id="sub" />  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  вводите ID продуктов через запятую</td>
            </tr>

            <tr>
              <td class="caption">Флэш:</td>
              <td>
<input type="radio" name="flash" value="1" <?=set_radio('flash', '1'); ?> /> Да &nbsp &nbsp
<input type="radio" name="flash" value="2" <?=set_radio('flash', '2'); ?> /> Нет
              </td>
            </tr>

            <tr>
              <td class="caption">Стретч:</td>
              <td>
<input type="radio" name="stretch" value="1" <?=set_radio('stretch', '1'); ?> /> Тянущаяся &nbsp &nbsp
<input type="radio" name="stretch" value="2" <?=set_radio('stretch', '2'); ?> /> Фиксированная
              </td>
            </tr>

            <tr>
              <td class="caption">Количество колонок:</td>
              <td>
<select name="columns">
<option></option>
<option value="1" <?=set_select('columns', '1'); ?>>1</option>
<option value="2" <?=set_select('columns', '2'); ?>>2</option>
<option value="3" <?=set_select('columns', '3'); ?>>3</option>
<option value="4" <?=set_select('columns', '4'); ?>>4</option>
</select>
              </td>
            </tr>



            <tr>
              <td class="caption">Назначение сайта:</td>
              <td class="frnt cat">
<select name="destination">
<option></option>
<? foreach($destinations as $row): ?> 
<option value="<?=$row['id']?>"<?=set_select('destination', ''.$row['id'].''); ?>><?=$row['name']?></option>
<? endforeach; ?>
</select>
              </td>
            </tr>

            <tr>
              <td class="caption">Тех Качество:</td>
              <td>
<input type="radio" name="quality" value="1" <?=set_radio('quality', '1'); ?> /> Только для IE &nbsp &nbsp
<input type="radio" name="quality" value="2" <?=set_radio('quality', '2'); ?> /> Кроссбраузерная верстка&nbsp &nbsp
<input type="radio" name="quality" value="2" <?=set_radio('quality', '2'); ?> /> Полное соответствие W3C
              </td>
            </tr>

            <tr>
              <td class="caption">Тип Верстки:</td>
              <td>
<input type="radio" name="type" value="1" <?=set_radio('type', '1'); ?> /> Блочная верстка &nbsp &nbsp
<input type="radio" name="type" value="2" <?=set_radio('type', '2'); ?> /> Табличная
              </td>
            </tr>

            <tr>
              <td class="caption">Тон:</td>
              <td>
<input type="radio" name="tone" value="1" <?=set_radio('tone', '1'); ?> /> Светлый &nbsp &nbsp
<input type="radio" name="tone" value="2" <?=set_radio('tone', '2'); ?> /> Темный
              </td>
            </tr>

            <tr>
              <td class="caption">Яркость:</td>
              <td>
<input type="radio" name="bright" value="1" <?=set_radio('bright', '1'); ?> /> Спокойный &nbsp &nbsp
<input type="radio" name="bright" value="2" <?=set_radio('bright', '2'); ?> /> Яркий
              </td>
            </tr>

            <tr>
              <td class="caption">Стиль:</td>
              <td>
<input type="radio" name="style" value="1" <?=set_radio('style', '1'); ?> /> Новый &nbsp &nbsp
<input type="radio" name="style" value="2" <?=set_radio('style', '2'); ?> /> Классический  &nbsp &nbsp
<input type="radio" name="style" value="3" <?=set_radio('style', '3'); ?> /> Старый
              </td>
            </tr>

            <tr>
              <td class="caption">Тема:</td>
              <td class="frnt cat">
<select name="theme">
<option></option>
<? foreach($themes as $row): ?> 
<option value="<?=$row['id']?>"<?=set_select('theme', ''.$row['id'].''); ?>><?=$row['name']?></option>
<? endforeach; ?>
</select>
              </td>
            </tr>

            <tr>
              <td class="caption">Только для взрослых:</td>
              <td><input type="checkbox" name="adult" value="1" <?=set_checkbox('adult', '1'); ?> />  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  Дизайн не будет показан не авторизированным пользователям и авторизированным пользователям, которые не достигли совершенолетия. </td>
            </tr>


          </table>
        </div>
      </div>
    </div>
  </div>
<input type="submit" value="Добавить">
</form>