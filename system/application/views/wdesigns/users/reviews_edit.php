<?=validation_errors()?>
<h1 class="title">Форма редактирования отзывов</h1>
<p class="subtitle">Редактировать отзыв</p>
<form action="" method="post" />
  <div class="rnd">
    <div>
      <div>
        <div style="overflow:hidden;">
          <table class="order-form">

            <tr>
              <td class="caption">Текст:</td>
              <td class="frnt"><textarea name="text" rows="10" cols="49"><?=$text?></textarea></td>
            </tr>

          </table>
        </div>
      </div>
    </div>
  </div>
<input type="submit" value="Сохранить изменения">
</form>