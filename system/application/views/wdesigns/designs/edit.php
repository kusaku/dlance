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
<form action="" method="post" enctype="multipart/form-data">
  <div class="rnd">
    <div>
      <div>
        <div style="overflow:hidden;">
          <table class="order-form">
            <tr>
              <td class="caption">Заголовок(максимум 64 символов):</td>
              <td class="frnt"><input type="text" class="text" name="title" value="<?=$title?>" size="64" maxlength="64" /></td>
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
				<option value="<?=$row2['id']?>"<? if( $row2['id'] == $category ): ?> selected="selected"<? endif; ?>><?=$row2['name']?></option>
			<? endif; ?>
	<? endforeach; ?>
<? endforeach; ?>
</select>
              </td>
            </tr>

            <tr>
              <td class="caption">Цена:</td>
              <td>
<input type="text" name="price_1" value="<?=$price_1?>" size="12" maxlength="12" /> рублей
              </td>
            </tr>

            <tr>
              <td class="caption">Цена выкупа:</td>
              <td>
<input type="text" name="price_2" value="<?=$price_2?>" size="12" maxlength="12" /> рублей
              </td>
            </tr>

            <tr>
              <td class="caption">Описание(максимум 10000 символов):</td>
              <td class="frnt"><textarea name="text" rows="10" cols="49"><?=$text?></textarea></td>
            </tr>

            <tr>
              <td class="caption">Тэги:</td>
              <td class="frnt"><input type="text" class="text" name="tags" value="<? foreach($tags as $row): ?><?=$row['tag']?>, <? endforeach; ?>" size="64" maxlength="64"  id="tags" />  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  Не менее одного тэга</td>
            </tr>

            <tr>
              <td class="caption">Исходники:</td>
              <td class="frnt"><input type="text" class="text" name="source" value="<?=set_value('source')?>" size="64" maxlength="64" /></td>
            </tr>

            <tr>
              <td class="caption">Загрузка изображения:</td>
              <td>
              <img src="<?=$small_image?>" /><br /><br />
              <input class="file" name="userfile" type="file" />  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  Размер — до 1 Мб, Формат — JPG, Разрешение - до 1024x768 px</td>
            </tr>

            <tr>
              <td class="caption">Файл:</td>
              <td>
              <?=$dfile?><br /><br />
              <input class="file" name="file" type="file" />  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  Размер — до 100 Мб, Формат — ZIP, RAR</td>
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
              <td class="frnt"><input type="text" class="text" name="sub" value="<? foreach($sub as $row): ?><?=$row['sub']?>, <? endforeach; ?>" size="64" maxlength="64" id="sub" />  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  вводите ID продуктов через запятую</td>
            </tr>

            <tr>
              <td class="caption">Флэш:<?=$flash?></td>
              <td>
<input type="radio" name="flash" value="1"<? if( $flash == 1 ): ?> checked="checked"<? endif; ?> /> Да &nbsp &nbsp
<input type="radio" name="flash" value="2"<? if( $flash == 2 ): ?> checked="checked"<? endif; ?> /> Нет
              </td>
            </tr>

            <tr>
              <td class="caption">Стретч:</td>
              <td>
<input type="radio" name="stretch" value="1"<? if( $stretch == 1 ): ?> checked="checked"<? endif; ?> /> Тянущаяся &nbsp &nbsp
<input type="radio" name="stretch" value="2"<? if( $stretch == 2 ): ?> checked="checked"<? endif; ?> /> Фиксированная
              </td>
            </tr>

            <tr>
              <td class="caption">Количество колонок:</td>
              <td>
<select name="columns">
<option></option>
<option value="1"<? if( $columns == 1 ): ?> selected="selected"<? endif; ?> />1</option>
<option value="2"<? if( $columns == 2 ): ?> selected="selected"<? endif; ?> />2</option>
<option value="3"<? if( $columns == 3 ): ?> selected="selected"<? endif; ?> />3</option>
<option value="4"<? if( $columns == 4 ): ?> selected="selected"<? endif; ?> />4</option>
</select>
              </td>
            </tr>



            <tr>
              <td class="caption">Назначение сайта:</td>
              <td class="frnt cat">
<select name="destination">
<option></option>
<? foreach($destinations as $row): ?> 
<option value="<?=$row['id']?>"<? if( $row['id'] == $destination ): ?> selected="selected"<? endif; ?>><?=$row['name']?></option>
<? endforeach; ?>
</select>
              </td>
            </tr>

            <tr>
              <td class="caption">Тех Качество:</td>
              <td>
<input type="radio" name="quality" value="1"<? if( $quality == 1 ): ?> checked="checked"<? endif; ?> /> Только для IE &nbsp &nbsp
<input type="radio" name="quality" value="2"<? if( $quality == 2 ): ?> checked="checked"<? endif; ?> /> Кроссбраузерная верстка&nbsp &nbsp
<input type="radio" name="quality" value="3"<? if( $quality == 3 ): ?> checked="checked"<? endif; ?> /> Полное соответствие W3C
              </td>
            </tr>

            <tr>
              <td class="caption">Тип Верстки:</td>
              <td>
<input type="radio" name="type" value="1"<? if( $type == 1 ): ?> checked="checked"<? endif; ?> /> Блочная верстка &nbsp &nbsp
<input type="radio" name="type" value="2"<? if( $type == 2 ): ?> checked="checked"<? endif; ?> /> Табличная
              </td>
            </tr>

            <tr>
              <td class="caption">Тон:</td>
              <td>
<input type="radio" name="tone" value="1"<? if( $tone == 1 ): ?> checked="checked"<? endif; ?> /> Светлый &nbsp &nbsp
<input type="radio" name="tone" value="2"<? if( $tone == 2 ): ?> checked="checked"<? endif; ?> /> Темный
              </td>
            </tr>

            <tr>
              <td class="caption">Яркость:</td>
              <td>
<input type="radio" name="bright" value="1"<? if( $bright == 1 ): ?> checked="checked"<? endif; ?> /> Спокойный &nbsp &nbsp
<input type="radio" name="bright" value="2"<? if( $bright == 2 ): ?> checked="checked"<? endif; ?> /> Яркий
              </td>
            </tr>

            <tr>
              <td class="caption">Стиль:</td>
              <td>
<input type="radio" name="style" value="1"<? if( $style == 1 ): ?> checked="checked"<? endif; ?> /> Новый &nbsp &nbsp
<input type="radio" name="style" value="2"<? if( $style == 2 ): ?> checked="checked"<? endif; ?> /> Классический  &nbsp &nbsp
<input type="radio" name="style" value="3"<? if( $style == 3 ): ?> checked="checked"<? endif; ?> /> Старый
              </td>
            </tr>

            <tr>
              <td class="caption">Тема:</td>
              <td class="frnt cat">
<select name="theme">
<option></option>
<? foreach($themes as $row): ?> 
<option value="<?=$row['id']?>"<? if( $row['id'] == $theme ): ?> selected="selected"<? endif; ?>><?=$row['name']?></option>
<? endforeach; ?>
</select>
              </td>
            </tr>

            <tr>
              <td class="caption">Только для взрослых:</td>
              <td><input type="checkbox" name="adult" value="1"<? if( $adult == 1 ): ?> checked="checked"<? endif; ?> />  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  Дизайн не будет показан не авторизированным пользователям и авторизированным пользователям, которые не достигли совершенолетия. </td>
            </tr>


          </table>
        </div>
      </div>
    </div>
  </div>
<input type="submit" value="Сохранить">
</form>