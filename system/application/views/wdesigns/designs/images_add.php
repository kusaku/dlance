<?=validation_errors()?>
<? if( !empty($error) ) {?><?=$error?><? } ?>
<h1 class="title">Форма добавления изображения</h1>
<p class="subtitle">Добавить изображения</p>
<form action="" method="post" enctype="multipart/form-data"/>
  <div class="rnd">
    <div>
      <div>
        <div style="overflow:hidden;">
          <table class="order-form">
            <tr>
              <td class="caption">Заголовок(максимум 64 символов):</td>
              <td class="frnt"><input type="title" class="text" name="title" value="<?=set_value('title')?>" size="64" maxlength="64" /></td>
            </tr>

            <tr>
              <td class="caption">Описание(максимум 255 символов):</td>
              <td class="frnt"><textarea name="text" rows="10" cols="49"><?=set_value('text')?></textarea></td>
            </tr>

            <tr>
              <td class="caption">Загрузка изображения:</td>
              <td><input class="file" name="userfile" type="file">  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  Размер — до 1 Мб, Формат — JPG, Разрешение - до 1024x768 px</td>
            </tr>

          </table>
        </div>
      </div>
    </div>
  </div>
<input type="submit" value="Добавить">
</form>