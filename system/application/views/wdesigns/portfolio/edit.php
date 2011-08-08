<?=validation_errors()?>
<? if( !empty($error) ) {?><?=$error?><? } ?>
<h1 class="title">Форма редактирования работы</h1>
<p class="subtitle">Редактировать работу</p>
<form action="" method="post" enctype="multipart/form-data"/>
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
              <td class="caption">Описание(максимум 255 символов):</td>
              <td class="frnt"><textarea name="text" rows="10" cols="49"><?=$descr?></textarea></td>
            </tr>

            <tr>
              <td class="caption">Загрузка изображения:</td>
              <td>
              <img src="<?=$small_image?>" /><br />
              <input class="file" name="userfile" type="file">  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  Размер — до 1 Мб, Формат — JPG, Разрешение - до 1024x768 px</td>
            </tr>

          </table>
        </div>
      </div>
    </div>
  </div>
<input type="submit" value="Сохранить изменения">
</form>